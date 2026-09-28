<?php

namespace Tests\Feature;

use App\Http\Livewire\Admin\JadwalDinas;
use App\Models\Dinas;
use App\Models\Irjbuka;
use App\Models\Log;
use App\Models\Piket;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class JadwalDinasTest extends TestCase
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
            $table->string('nip')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->unsignedInteger('id_role')->default(2);
            $table->unsignedInteger('status')->default(1);
            $table->text('akses_menu')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('dinas', function (Blueprint $table) {
            $table->id();
            $table->string('dinas');
            $table->time('jam_masuk');
            $table->time('jam_pulang');
        });
        Schema::create('piket', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_pengawas');
            $table->unsignedInteger('id_dinas');
            $table->date('tanggal');
        });
        Schema::create('irj_buka', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_dinas');
            $table->date('tanggal');
        });
        Schema::create('log', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_user')->nullable();
            $table->unsignedInteger('id_log_jenis')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

        Dinas::insert([
            ['id' => 1, 'dinas' => 'pagi', 'jam_masuk' => '06:45:00', 'jam_pulang' => '14:15:00'],
            ['id' => 2, 'dinas' => 'sore', 'jam_masuk' => '13:45:00', 'jam_pulang' => '21:15:00'],
            ['id' => 3, 'dinas' => 'malam', 'jam_masuk' => '20:45:00', 'jam_pulang' => '07:15:00'],
        ]);
    }

    public function test_it_renders_empty_state_before_a_month_is_loaded(): void
    {
        $component = new JadwalDinas();
        $component->mount();

        $html = $component->render()->with(get_object_vars($component))->render();

        $this->assertStringContainsString('Pilih Bulan dan Tahun', $html);
        $this->assertStringContainsString('Lihat Jadwal', $html);
        $this->assertStringContainsString('Ekspor XLSX', $html);
    }

    public function test_it_requires_valid_year_and_month_before_loading(): void
    {
        $component = new JadwalDinas();
        $component->mount();
        $component->lihatJadwal();

        $this->assertFalse($component->readyToLoad);
        $this->assertSame('calendar', $component->viewMode);
    }

    public function test_it_renders_loaded_schedule_and_applies_list_filters(): void
    {
        $pengawas = User::create([
            'nama' => 'Pengawas Aktif',
            'username' => 'pengawas-aktif',
            'email' => 'pengawas@example.test',
            'password' => 'password',
            'id_role' => 2,
            'status' => 1,
        ]);
        Piket::create(['id_pengawas' => $pengawas->id, 'id_dinas' => 1, 'tanggal' => '2026-09-10']);

        $component = new JadwalDinas();
        $component->mount();
        $component->tahun = '2026';
        $component->bulan = '09';
        $component->lihatJadwal();
        $component->viewMode = 'list';
        $component->filterPengawas = (string) $pengawas->id;
        $component->filterStatus = 'assigned';

        $html = $component->render()->with(get_object_vars($component))->render();

        $this->assertTrue($component->readyToLoad);
        $this->assertStringContainsString('September 2026', $html);
        $this->assertStringContainsString('Pengawas Aktif', $html);
        $this->assertStringContainsString('Terisi', $html);
        $this->assertStringContainsString('jadwal-list-view', $html);
    }

    public function test_it_creates_schedule_and_irj_record_then_deletes_both(): void
    {
        $user = User::create([
            'nama' => 'Admin Test',
            'username' => 'admin-test',
            'email' => 'admin@example.test',
            'password' => 'password',
            'id_role' => 3,
            'status' => 1,
        ]);
        $pengawas = User::create([
            'nama' => 'Pengawas Test',
            'username' => 'pengawas-test',
            'email' => 'pengawas-test@example.test',
            'password' => 'password',
            'id_role' => 2,
            'status' => 1,
        ]);
        Auth::login($user);

        $component = new JadwalDinas();
        $component->mount();
        $component->tahun = '2026';
        $component->bulan = '09';
        $component->prepareCreate(1, '2026-09-10', true);
        $component->selectedPengawas = $pengawas->id;
        $component->selectedIrj = true;
        $component->savePiket();

        $this->assertSame(1, Piket::where('id_pengawas', $pengawas->id)
            ->where('id_dinas', 1)
            ->whereDate('tanggal', '2026-09-10')
            ->count());
        $this->assertSame(1, Irjbuka::where('id_dinas', 1)->whereDate('tanggal', '2026-09-10')->count());
        $this->assertDatabaseHas('log', ['id_user' => $user->id, 'id_log_jenis' => 6]);

        $piket = Piket::where('id_dinas', 1)->whereDate('tanggal', '2026-09-10')->firstOrFail();
        $component->deletePiketById($piket->id, 1, '2026-09-10', $pengawas->id);

        $this->assertSame(0, Piket::where('id_dinas', 1)->whereDate('tanggal', '2026-09-10')->count());
        $this->assertSame(0, Irjbuka::where('id_dinas', 1)->whereDate('tanggal', '2026-09-10')->count());
    }
}
