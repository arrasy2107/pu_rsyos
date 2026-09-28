<?php

namespace Tests\Feature;

use App\Http\Controllers\FasilitasController;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DataKasurAccessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $this->app['db']->purge('sqlite');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->unsignedInteger('id_role');
            $table->unsignedInteger('status')->default(1);
            $table->text('akses_menu')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function test_all_application_roles_can_open_data_kasur(): void
    {
        $this->partialMock(FasilitasController::class, function ($mock) {
            $mock->shouldReceive('kasur')
                ->times(4)
                ->andReturn(response('data kasur'));
        });

        foreach ([0, 1, 2, 3] as $role) {
            $user = User::create([
                'nama' => "Role {$role}",
                'username' => "role-{$role}",
                'email' => "role-{$role}@example.test",
                'password' => 'password',
                'id_role' => $role,
                'status' => 1,
            ]);

            $this->actingAs($user)
                ->get(route('data-kasur'))
                ->assertOk()
                ->assertSee('data kasur');
        }
    }

    public function test_guests_are_still_required_to_log_in(): void
    {
        $this->get(route('data-kasur'))
            ->assertRedirect(route('login'));
    }
}
