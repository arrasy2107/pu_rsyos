<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengawasController extends Controller
{

    //LAPORAN IGD
    public function draftlaporanIGD(Request $r)
    {

        $sup = new \App\Models\Laporanigd;
        $sup->id_pengawas = $r->nama;
        $sup->id_dokter = $r->username;
        
        $sup->jumlah_pasien = $r->role;
        $sup->jumlah_pasien_rawat = $r ;	
        $sup->jumlah_pasien_pulang	=$r ;
        $sup->jumlah_pasien_emergency = ;	
        $sup->jumlah_pasien_non_emergency = ;
        $sup->jumlah_pasien_tidak_bisa_rawat= ;
        $sup->alasan_tidak_bisa_rawat= ;	
        $sup->jumlah_pasien_doa= ;	
        $sup->permasalahan = ;
        $sup->lain_lain = ;
        $date = date_default_timezone_set('Asia/Jakarta');
        $sup->created_at = date('Y-m-d H:i:s');
        $sup->updated_at =  date('Y-m-d H:i:s');
        $sup->save();

        return redirect()->back()->with('success-add', 'Berhasil menambah ke Draft Laporan IGD');
    }
}
