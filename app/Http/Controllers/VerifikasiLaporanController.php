<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class VerifikasiLaporanController extends Controller
{
    /**
     * Halaman verifikasi QR Code laporan — dapat diakses tanpa login.
     * Hanya menampilkan metadata ringkas (bukan data medis detail).
     */
    public function show(Request $request, string $token)
    {
        // Cari laporan berdasarkan token yang tersimpan di database
        $laporan = Laporan::with(['pengawas', 'dinas'])
            ->where('qr_token', $token)
            ->first();

        if (!$laporan) {
            return view('verifikasi.invalid', [
                'pesan' => 'Token QR Code tidak ditemukan atau tidak valid.',
            ]);
        }

        return view('verifikasi.valid', [
            'laporan'        => $laporan,
            'nama_pengawas'  => $laporan->pengawas->nama ?? '-',
            'shift_dinas'    => $laporan->dinas->dinas ?? '-',
            'tanggal_submit' => $laporan->created_at,
            'verified'       => (bool) $laporan->verified,
            'verified_bidang'=> (bool) $laporan->verified_bidang,
        ]);
    }
}
