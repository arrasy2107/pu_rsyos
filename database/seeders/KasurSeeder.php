<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KasurSeeder extends Seeder
{
    public function run()
    {
        // Urutan kamar mengikuti CSV agar ID kasur tetap sama dengan data sumber.
        $kamarDenganJumlahKasur = [

            [13, 1],
            [14, 1],
            [15, 1],
            [16, 1],
            [17, 1],
            [18, 1],
            [19, 1],
            [20, 1],
            [21, 1],
            [22, 1],
            [23, 1],
            [24, 1],
            [25, 1],
            [26, 4],
            [27, 4],
            [28, 4],
            [29, 4],
            [30, 4],
            [31, 4],
            [32, 4],
            [33, 4],
            [34, 4],
            [35, 4],
            [36, 4],
            [37, 4],
            [38, 4],
            [39, 4],
            [40, 4],
            [41, 4],
            [42, 4],
            [43, 4],
            [44, 4],
            [45, 4],
            [46, 4],
            [47, 4],
            [48, 4],
            [49, 4],
            [50, 4],
            [51, 4],
            [52, 4],
            [53, 4],
            [54, 4],
            [55, 4],
            [56, 2],
            [57, 2],
            [58, 2],
            [59, 2],
            [60, 2],
            [61, 2],
            [62, 2],
            [63, 2],
            [64, 2],
            [65, 2],
            [66, 2],
            [67, 2],
            [68, 2],
        ];

        $now = now();
        $nextId = 9;
        $rows = [];

        foreach ($kamarDenganJumlahKasur as [$idKamar, $jumlahKasur]) {
            for ($nomorKasur = 1; $nomorKasur <= $jumlahKasur; $nomorKasur++) {
                $rows[] = [
                    'id' => $nextId++,
                    'id_kamar' => $idKamar,
                    'kode_kasur' => 'Bed ' . $nomorKasur,
                    'status' => 1,
                    'status_operasional' => 'available',
                    'keterangan' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        DB::table('kasur')->upsert(
            $rows,
            ['id'],
            ['id_kamar', 'kode_kasur', 'status', 'status_operasional', 'keterangan', 'updated_at']
        );
    }
}
