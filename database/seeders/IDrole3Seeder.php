<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IDrole3Seeder extends Seeder
{
    public function run()
    {
        $password = '$2y$10$mg3BURvucuvIXI2Rfo06/.5c/zUwNGriOKeHOn.4UFJ4LwUMx7.SS';

        DB::table('users')->insert(array_map(function ($user) use ($password) {
            $user['password'] = $password;

            return $user;
        }, [
            ['id' => 7, 'nama' => 'Bidang Keperawatan', 'nip' => null, 'username' => 'bidang', 'password' => '$2y$10$tnZVYGs6SRjenyjb6FcyXe69PMomkhgCUTO2hyU4HA.vQDEyEejyO', 'remember_token' => null, 'id_role' => 3, 'status' => 1, 'created_at' => '2021-08-25 00:11:27', 'updated_at' => '2026-09-09 05:04:55'],
            ['id' => 63, 'nama' => 'Alvrina', 'nip' => null, 'username' => 'ina', 'password' => '$2y$10$YZz8iwVeG8hflxoDy.tlS.gVFl9S3QBmLP2X9RosElDnoIy8iW/Yi', 'remember_token' => null, 'id_role' => 3, 'status' => 1, 'created_at' => '2022-03-02 07:56:44', 'updated_at' => '2026-09-09 05:04:55'],
            ['id' => 64, 'nama' => 'Admin EDP', 'nip' => null, 'username' => 'adminedp', 'password' => '$2y$10$n4A9OXSKWsZ.ZxrL9A6jzO99OYSmJSFL245Vkl64eISgJ42qeujiK', 'remember_token' => null, 'id_role' => 3, 'status' => 1, 'created_at' => '2022-03-16 14:53:15', 'updated_at' => '2026-09-09 05:04:55'],
            ['id' => 96, 'nama' => 'Sr. Clara', 'nip' => '1327', 'username' => 'clara', 'password' => '$2y$10$JZy5cSJcJTtelHrw3YDGUOQ8EbGT8QJBjvYFQSthGKdI68g1ANg.W', 'remember_token' => null, 'id_role' => 3, 'status' => 1, 'created_at' => '2024-05-08 11:46:57', 'updated_at' => '2026-09-09 05:04:55'],
            ['id' => 106, 'nama' => 'dr. MPP', 'nip' => '999', 'username' => 'mpp', 'password' => '$2y$10$zNs79csMViKNB7vR8bP/KedhsD9L8twrG69wP5kT.u2rMEWQ6zfGK', 'remember_token' => null, 'id_role' => 3, 'status' => 1, 'created_at' => '2025-06-19 09:30:40', 'updated_at' => '2026-09-09 05:04:55'],
        ]));
    }
}
