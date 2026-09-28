<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    public function test_login_page_is_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_user_must_change_default_password()
    {
        $user = User::create([
            'nama' => 'Test User',
            'username' => 'testuser',
            'password' => bcrypt('12345678'),
            'id_role' => 0,
            'status' => 1
        ]);

        $response = $this->post('/dologin', [
            'username' => 'testuser',
            'password' => '12345678'
        ]);

        $response->assertRedirect('/ganti-password');
        $this->assertGuest();
    }

    public function test_superadmin_can_login()
    {
        $user = User::create([
            'nama' => 'Super Admin',
            'username' => 'admin',
            'password' => bcrypt('securepassword123'),
            'id_role' => 0,
            'status' => 1
        ]);

        $response = $this->post('/dologin', [
            'username' => 'admin',
            'password' => 'securepassword123'
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_wrong_password()
    {
        $user = User::create([
            'nama' => 'Test',
            'username' => 'tester',
            'password' => bcrypt('correctpassword'),
            'id_role' => 0,
            'status' => 1
        ]);

        $response = $this->post('/dologin', [
            'username' => 'tester',
            'password' => 'wrongpassword'
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }
}
