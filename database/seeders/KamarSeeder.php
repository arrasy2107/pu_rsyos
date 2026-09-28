<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KamarSeeder extends Seeder
{
    public function run()
    {
        $kamars = [
            [13, 11, 'Sudirman 1'],
            [14, 11, 'Sudirman 2'],
            [15, 11, 'Sudirman 3'],
            [16, 11, 'Sudirman 4'],
            [17, 11, 'Sudirman 5'],
            [18, 11, 'Sudirman 6'],
            [19, 11, 'Sudirman 7'],
            [20, 11, 'Sudirman 8'],
            [21, 11, 'Sudirman 9'],
            [22, 11, 'Sudirman 10'],
            [23, 11, 'Sudirman 11'],
            [24, 11, 'Sudirman 12'],
            [25, 11, 'Sudirman 14'],
            [26, 15, 'Herlina 1'],
            [27, 15, 'Herlina 2'],
            [28, 15, 'Herlina 3'],
            [29, 15, 'Herlina 4'],
            [30, 15, 'Herlina 5'],
            [31, 15, 'Herlina 6'],
            [32, 3, 'Dewi Sartika 1'],
            [33, 3, 'Dewi Sartika 2'],
            [34, 3, 'Dewi Sartika 3'],
            [35, 3, 'Dewi Sartika 4'],
            [36, 3, 'Dewi Sartika 5'],
            [37, 3, 'Dewi Sartika 6'],
            [38, 3, 'Dewi Sartika 7'],
            [39, 3, 'Dewi Sartika 8'],
            [40, 3, 'Dewi Sartika 9'],
            [41, 3, 'Dewi Sartika 10'],
            [42, 3, 'Dewi Sartika 11'],
            [43, 3, 'Dewi Sartika 12'],
            [44, 2, 'Ade Irma 1'],
            [45, 2, 'Ade Irma 2'],
            [46, 2, 'Ade Irma 3'],
            [47, 2, 'Ade Irma 4'],
            [48, 2, 'Ade Irma 5'],
            [49, 2, 'Ade Irma 6'],
            [50, 2, 'Ade Irma 7'],
            [51, 2, 'Ade Irma 8'],
            [52, 2, 'Ade Irma 9'],
            [53, 2, 'Ade Irma 10'],
            [54, 2, 'Ade Irma 11'],
            [55, 2, 'Ade Irma 12'],
            [56, 1, 'Adelia 1'],
            [57, 1, 'Adelia 2'],
            [58, 1, 'Adelia 3'],
            [59, 1, 'Adelia 4'],
            [60, 1, 'Adelia 5'],
            [61, 1, 'Adelia 6'],
            [62, 1, 'Alamanda 1'],
            [63, 1, 'Alamanda 2'],
            [64, 1, 'Alamanda 3'],
            [65, 1, 'Alamanda 4'],
            [66, 1, 'Alamanda 5'],
            [67, 1, 'Alamanda 6'],
            [68, 1, 'Alamanda 7'],
        ];

        $rows = array_map(function (array $kamar) {
            return [
                'id' => $kamar[0],
                'id_ruangan' => $kamar[1],
                'nama_kamar' => $kamar[2],
                'status' => 1,
                'keterangan' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $kamars);

        DB::table('kamar')->upsert(
            $rows,
            ['id'],
            ['id_ruangan', 'nama_kamar', 'status', 'keterangan', 'updated_at']
        );
    }
}
