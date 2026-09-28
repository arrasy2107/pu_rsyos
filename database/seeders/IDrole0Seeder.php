<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IDrole0Seeder extends Seeder
{
    public function run()
    {
        // Password default: 12345678
        // Saat login dengan password ini, user akan diarahkan ke halaman ganti-password
        $defaultPassword = '$2y$10$.K5tcX9fYtBMzXoJhrXuVeyikza/XpVw2ZoU02p7qKPPZdPfrMDmK';

        DB::table('users')->insert([
            // id_role = 0 => Super Admin (akses penuh: data-pengguna, log, semua fitur)
            [
                'id'             => 19,
                'nama'           => 'Administrator',
                'nip'            => '0',
                'username'       => 'super_admin',
                'password'       => $defaultPassword,
                'remember_token' => null,
                'id_role'        => 0,
                'status'         => 1,
                'created_at'     => '2021-10-14 12:24:14',
                'updated_at'     => '2026-09-09 05:04:55',
            ],
        ]);
    }
}