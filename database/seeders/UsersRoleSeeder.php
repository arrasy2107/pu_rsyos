<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('users')->insert([
            [
                'nama' => 'Direktur',
                'nip' => '0001',
                'username' => 'direktur',
                'password' => Hash::make('12345678'),
                'id_role' => 1,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Pengawas',
                'nip' => '0002',
                'username' => 'pengawas',
                'password' => Hash::make('12345678'),
                'id_role' => 2,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Keperawatan',
                'nip' => '0003',
                'username' => 'keperawatan',
                'password' => Hash::make('12345678'),
                'id_role' => 3,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
