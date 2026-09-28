<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IDrole1Seeder extends Seeder
{
    public function run()
    {
        $password = '$2y$10$mg3BURvucuvIXI2Rfo06/.5c/zUwNGriOKeHOn.4UFJ4LwUMx7.SS';

        DB::table('users')->insert(array_map(function ($user) use ($password) {
            $user['password'] = $password;

            return $user;
        }, [
            ['id' => 1, 'nama' => 'dr. Ananto Pratikno, SpOG, MARS, FISQua, COTM', 'nip' => null, 'username' => 'direktur', 'password' => '$2y$10$AaxS17VLNyjHy6wOb/fPFOekvJpjO/1nAMLNgCZ3jLh0hjn.uo1N2', 'remember_token' => '', 'id_role' => 1, 'status' => 1, 'created_at' => '2021-07-27 22:50:16', 'updated_at' => '2026-09-09 05:04:55'],
            ['id' => 18, 'nama' => 'dr. Mariani Sukirman', 'nip' => null, 'username' => 'wadirpelayanan', 'password' => '$2y$10$2wypWRQ2Zn8XzTozU4qUv.NvyWSXmhTPb9pwxE5BF37QZcZbdLS2O', 'remember_token' => null, 'id_role' => 1, 'status' => 1, 'created_at' => '2021-10-14 12:23:45', 'updated_at' => '2026-09-09 05:04:55'],
            ['id' => 114, 'nama' => 'dr. Mila Gunawan, MARS, FISQua', 'nip' => '0', 'username' => 'milgun', 'password' => '$2y$10$80Sn3SSgOVP/jWGU/UN4oeMTE8VU/6Akf2K0w8RzCbEPgIlzgaeZm', 'remember_token' => null, 'id_role' => 1, 'status' => 1, 'created_at' => '2026-03-03 09:52:45', 'updated_at' => '2026-09-09 05:04:55'],
        ]));
    }
}
