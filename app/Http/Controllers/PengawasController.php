<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengawasController extends Controller
{

    //LAPORAN IGD
    public function draftlaporanIGD(Request $r)
    {

        $sup = new \App\Models\Laporanigd;
        $sup->id_pengawas = \Auth::user()->id;
        $sup->id_dokter = $r->igd_dokterjaga;
        
        $sup->jumlah_pasien = $r->igd_pasien;
        $sup->jumlah_pasien_rawat = $r->igd_pasien_rawat ;	
        $sup->jumlah_pasien_pulang	= $r->igd_pasien - $r->igd_pasien_rawat;
        $sup->jumlah_pasien_emergency = $r->igd_pasien_emergency;	
        $sup->jumlah_pasien_non_emergency = $r->igd_pasien - $r->igd_pasien_emergency;
        $sup->jumlah_pasien_tidak_bisa_rawat= $r->igd_pasien_tidak_rawat ;
        $sup->alasan_tidak_bisa_rawat= $r->igd_alasan ;	
        $sup->jumlah_pasien_doa= $r->igd_pasien_doa;	
        $sup->permasalahan = $r->igd_permasalahan ;
        $sup->lain_lain = $r->igd_lainlain ;
        $date = date_default_timezone_set('Asia/Jakarta');
        $sup->created_at = date('Y-m-d H:i:s');
        $sup->updated_at =  date('Y-m-d H:i:s');
        $sup->save();

        return redirect()->back()->with('success-add', 'Berhasil menambah ke Draft Laporan IGD');
    }

    //LAPORAN UMUM
    public function draftlaporanUmum(Request $r)
    {

        $sup = new \App\Models\Laporanumum;
        $sup->id_pengawas = \Auth::user()->id;
        $sup->id_ruangan = $r->inap_ruangan;

        $sup->jumlah_pasien_lama = $r->inap_pasien_lama;
        $sup->jumlah_pasien_baru = $r->inap_pasien_baru;
        $sup->jumlah_pasien_pindah = $r->inap_pasien_pindah;
        $sup->jumlah_pasien_pindahan = $r->inap_pasien_pindahan;
        $sup->jumlah_pasien_meninggal = $r->inap_pasien_meninggal;
        
        $sup->catatan_pasien_istimewa = $r->inap_catatan_istimewa;
        $sup->catatan_pasien_baru = $r->inap_catatan_baru;
        $sup->jumlah_pasien_covid = $r->inap_pasien_covid;
        $sup->jumlah_pasien_suspek_covid = $r->inap_pasien_suspect;
        $sup->jumlah_pasien_restrain = $r->inap_pasien_restrain;
        $sup->jumlah_pasien_perilaku_kekerasan = $r->inap_pasien_kekerasan;
        $sup->jumlah_pasien_keracunan = $r->inap_pasien_keracunan;
        $sup->jumlah_pasien_keterbatasan_bahasa = $r->inap_pasien_bahasa;
        $sup->jumlah_pasien_difabel = $r->inap_pasien_difabel;
        $sup->permasalahan_umum = $r->inap_permasalahan;
        
        $sup->jumlah_total_pasien = $r->inap_pasien_lama + $r->inap_pasien_baru + $r->inap_pasien_pindah + $r->inap_pasien_pindahan + $r->inap_pasien_meninggal + $r->inap_pasien_covid + $r->inap_pasien_suspect + $r->inap_pasien_restrain + $r->inap_pasien_kekerasan + $r->inap_pasien_keracunan + $r->inap_pasien_bahasa + $r->inap_pasien_difabel;///
        
        $date = date_default_timezone_set('Asia/Jakarta');
        $sup->created_at = date('Y-m-d H:i:s');
        $sup->updated_at =  date('Y-m-d H:i:s');
        $sup->save();

        return redirect()->back()->with('success-add', 'Berhasil menambah ke Draft Laporan Umum');
    }
}
