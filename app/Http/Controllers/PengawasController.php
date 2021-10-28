<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengawasController extends Controller
{

    //LAPORAN IGD
    public function draftlaporanIGD(Request $r)
    {
        if($r->igd_pasien - $r->igd_pasien_rawat < 0){
            return redirect()->back()->with('fail-add', 'Jumlah kunjungan pasien tidak boleh LEBIH KECIL dari jumlah pasien rawat');
        }
        else if($r->igd_pasien - $r->igd_pasien_emergency < 0){
            return redirect()->back()->with('fail-add', 'Jumlah kunjungan pasien tidak boleh LEBIH KECIL dari jumlah pasien Emergency');
        }
        else if($r->igd_pasien_sisrute - $r->igd_pasien_sisrute_diterima < 0){
            return redirect()->back()->with('fail-add', 'Jumlah Rujukan SISRUTE tidak boleh LEBIH KECIL dari jumlah pasien SISRUTE yang diterima');
        }
        else{
            $sup = new \App\Models\Laporanigd;
            $sup->id_pengawas = \Auth::user()->id;
            $sup->id_dokter = $r->igd_dokterjaga;
            
            $sup->jumlah_pasien = $r->igd_pasien;
            $sup->jumlah_pasien_rawat = $r->igd_pasien_rawat ;	
            $sup->jumlah_pasien_pulang	= $r->igd_pasien - $r->igd_pasien_rawat;
            $sup->jumlah_pasien_emergency = $r->igd_pasien_emergency;	
            $sup->jumlah_pasien_non_emergency = $r->igd_pasien - $r->igd_pasien_emergency;
            $sup->jumlah_pasien_tidak_bisa_rawat= $r->igd_pasien_tidak_rawat ;
            // SISRUTE
            $sup->jumlah_pasien_sisrute= $r->igd_pasien_sisrute ;
            $sup->jumlah_pasien_sisrute_diterima= $r->igd_pasien_sisrute_diterima ;
            $sup->jumlah_pasien_sisrute_ditolak= $r->igd_pasien_sisrute - $r->igd_pasien_sisrute_diterima ;
            
            $sup->alasan_tidak_bisa_rawat= $r->igd_alasan ;	
            $sup->jumlah_pasien_doa= $r->igd_pasien_doa;	
            $sup->permasalahan = $r->igd_permasalahan ;
            $sup->lain_lain = $r->igd_lainlain ;
            $date = date_default_timezone_set('Asia/Jakarta');
            $sup->created_at = date('Y-m-d H:i:s');
            $sup->updated_at =  date('Y-m-d H:i:s');
            $sup->save();
    
            //log data
            $log = new \App\Models\Log;
            $log->id_user = \Auth::user()->id;
            $log->id_log_jenis = 1;
            $log->keterangan = 'Tambah Draft';
            $log->created_at = date('Y-m-d H:i:s');
            $log->updated_at =  date('Y-m-d H:i:s');
            $log->save();
    
            return redirect()->back()->with('success-add', 'Berhasil menambah ke Draft Laporan IGD');
        }
        
    }

    public function editDraftlaporanIGD(Request $r)
    {
        if($r->igd_pasien - $r->igd_pasien_rawat < 0){
            return redirect()->back()->with('fail-add', 'Jumlah kunjungan pasien tidak boleh LEBIH KECIL dari jumlah pasien rawat');
        }
        else if($r->igd_pasien - $r->igd_pasien_emergency < 0){
            return redirect()->back()->with('fail-add', 'Jumlah kunjungan pasien tidak boleh LEBIH KECIL dari jumlah pasien Emergency');
        }
        else if($r->igd_pasien_sisrute - $r->igd_pasien_sisrute_diterima < 0){
            return redirect()->back()->with('fail-add', 'Jumlah Rujukan SISRUTE tidak boleh LEBIH KECIL dari jumlah pasien SISRUTE yang diterima');
        }
        else{
            $sup = \App\Models\Laporanigd::where('id',$r->id)->first();
            $sup->id_pengawas = \Auth::user()->id;
            $sup->id_dokter = $r->igd_dokterjaga;
            
            $sup->jumlah_pasien = $r->igd_pasien;
            $sup->jumlah_pasien_rawat = $r->igd_pasien_rawat ;	
            $sup->jumlah_pasien_pulang	= $r->igd_pasien - $r->igd_pasien_rawat;
            $sup->jumlah_pasien_emergency = $r->igd_pasien_emergency;	
            $sup->jumlah_pasien_non_emergency = $r->igd_pasien - $r->igd_pasien_emergency;
            $sup->jumlah_pasien_tidak_bisa_rawat= $r->igd_pasien_tidak_rawat ;
            // SISRUTE
            $sup->jumlah_pasien_sisrute= $r->igd_pasien_sisrute ;
            $sup->jumlah_pasien_sisrute_diterima= $r->igd_pasien_sisrute_diterima ;
            $sup->jumlah_pasien_sisrute_ditolak= $r->igd_pasien_sisrute - $r->igd_pasien_sisrute_diterima ;
            
            $sup->alasan_tidak_bisa_rawat= $r->igd_alasan ;	
            $sup->jumlah_pasien_doa= $r->igd_pasien_doa;	
            $sup->permasalahan = $r->igd_permasalahan ;
            $sup->lain_lain = $r->igd_lainlain ;
            $date = date_default_timezone_set('Asia/Jakarta');
            $sup->updated_at =  date('Y-m-d H:i:s');
            $sup->save();

            //log data
            $log = new \App\Models\Log;
            $log->id_user = \Auth::user()->id;
            $log->id_log_jenis = 1;
            $log->keterangan = 'Edit Draft';
            $log->created_at = date('Y-m-d H:i:s');
            $log->updated_at =  date('Y-m-d H:i:s');
            $log->save();

            return redirect()->back()->with('success-add', 'Berhasil mengubah data Draft Laporan IGD');
        }
    }

    public function deleteDraftlaporanIGD($id)
    {

        $sup = \App\Models\Laporanigd::where('id',$id)->first();
        $sup->status = 2; //Delete Laporan
        $sup->save();

        //log data
        $log = new \App\Models\Log;
        $log->id_user = \Auth::user()->id;
        $log->id_log_jenis = 1;
        $log->keterangan = 'Hapus Draft';
        $log->created_at = date('Y-m-d H:i:s');
        $log->updated_at =  date('Y-m-d H:i:s');
        $log->save();

        return redirect()->back()->with('success-add', 'Berhasil menghapus data draf Laporan IGD');
    }

    //LAPORAN UMUM
    public function draftlaporanUmum(Request $r)
    {
        if(($r->inap_pasien_lama + $r->inap_pasien_baru - $r->inap_pasien_pindah + $r->inap_pasien_pindahan - $r->inap_pasien_meninggal - $r->inap_pasien_pulang) < 0){
            return redirect()->back()->with('fail-add', 'Total Pasien tidak boleh di bawah 0, Coba periksa ulang inputan Anda.');
        }
        else{
            $sup = new \App\Models\Laporanumum;
            $sup->id_pengawas = \Auth::user()->id;
            $sup->id_ruangan = $r->inap_ruangan;

            $sup->jumlah_pasien_lama = $r->inap_pasien_lama;
            $sup->jumlah_pasien_baru = $r->inap_pasien_baru;
            $sup->jumlah_pasien_pindah = $r->inap_pasien_pindah;
            $sup->jumlah_pasien_pindahan = $r->inap_pasien_pindahan;
            $sup->jumlah_pasien_meninggal = $r->inap_pasien_meninggal;
            $sup->jumlah_pasien_pulang = $r->inap_pasien_pulang;

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
            
            $sup->jumlah_total_pasien = $r->inap_pasien_lama + $r->inap_pasien_baru - $r->inap_pasien_pindah + $r->inap_pasien_pindahan - $r->inap_pasien_meninggal - $r->inap_pasien_pulang;/// 
            
            $date = date_default_timezone_set('Asia/Jakarta');
            $sup->created_at = date('Y-m-d H:i:s');
            $sup->updated_at =  date('Y-m-d H:i:s');
            $sup->save();

            // Tambah Catatan Pasien
            $catatanpasien = \App\Models\Catatanpasien::where('id_pengawas',\Auth::user()->id)->where('id_ruangan',$r->inap_ruangan)->where('status',0)->update(['updated_at' => date('Y-m-d H:i:s'), 'id_laporan_umum' => \App\Models\Laporanumum::where('id_ruangan',$r->inap_ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('id')->last()]);

            //log data
            $log = new \App\Models\Log;
            $log->id_user = \Auth::user()->id;
            $log->id_log_jenis = 2;
            $log->keterangan = 'Tambah Draft';
            $log->created_at = date('Y-m-d H:i:s');
            $log->updated_at =  date('Y-m-d H:i:s');
            $log->save();

            return redirect()->back()->with('success-add', 'Berhasil menambah ke Draft Laporan Umum');
        }
    }

    public function editDraftlaporanUmum(Request $r)
    {
        if(($r->inap_pasien_lama + $r->inap_pasien_baru - $r->inap_pasien_pindah + $r->inap_pasien_pindahan - $r->inap_pasien_meninggal - $r->inap_pasien_pulang) < 0){
            return redirect()->back()->with('fail-add', 'Total Pasien tidak boleh di bawah 0, Coba periksa ulang inputan Anda.');
        }
        else{
            $sup = \App\Models\Laporanumum::where('id',$r->id)->first();
            $sup->id_pengawas = \Auth::user()->id;
            $sup->id_ruangan = $r->inap_ruangan;

            $sup->jumlah_pasien_lama = $r->inap_pasien_lama;
            $sup->jumlah_pasien_baru = $r->inap_pasien_baru;
            $sup->jumlah_pasien_pindah = $r->inap_pasien_pindah;
            $sup->jumlah_pasien_pindahan = $r->inap_pasien_pindahan;
            $sup->jumlah_pasien_meninggal = $r->inap_pasien_meninggal;
            $sup->jumlah_pasien_pulang = $r->inap_pasien_pulang;
            
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
            
            $sup->jumlah_total_pasien = $r->inap_pasien_lama + $r->inap_pasien_baru - $r->inap_pasien_pindah + $r->inap_pasien_pindahan - $r->inap_pasien_meninggal - $r->inap_pasien_pulang;/// 
            
            $date = date_default_timezone_set('Asia/Jakarta');
            $sup->created_at = date('Y-m-d H:i:s');
            $sup->updated_at =  date('Y-m-d H:i:s');
            $sup->save();

             // Edit Catatan Pasien
             $catatanpasien = \App\Models\Catatanpasien::where('id_pengawas',\Auth::user()->id)->where('id_ruangan',$r->inap_ruangan)->where('status',0)->update(['updated_at' => date('Y-m-d H:i:s'), 'id_laporan_umum' => \App\Models\Laporanumum::where('id_ruangan',$r->inap_ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('id')->last()]);


            //log data
            $log = new \App\Models\Log;
            $log->id_user = \Auth::user()->id;
            $log->id_log_jenis = 2;
            $log->keterangan = 'Edit Draft';
            $log->created_at = date('Y-m-d H:i:s');
            $log->updated_at =  date('Y-m-d H:i:s');
            $log->save();

            return redirect()->back()->with('success-add', 'Berhasil menambah ke Draft Laporan Umum');
        }
    }

    public function deleteDraftlaporanUmum($id)
    {

        $sup = \App\Models\Laporanumum::where('id',$id)->first();
        $sup->status = 2; //Delete Laporan
        $sup->save();

         // Hapus Catatan Pasien
         $catatanpasien = \App\Models\Catatanpasien::where('id_pengawas',\Auth::user()->id)->where('id_laporan_umum',$id)->update(['updated_at' => date('Y-m-d H:i:s'), 'status' => 2]);


        //log data
        $log = new \App\Models\Log;
        $log->id_user = \Auth::user()->id;
        $log->id_log_jenis = 2;
        $log->keterangan = 'Hapus Draft';
        $log->created_at = date('Y-m-d H:i:s');
        $log->updated_at =  date('Y-m-d H:i:s');
        $log->save();

        return redirect()->back()->with('success-add', 'Berhasil menghapus data draf Laporan Umum');
    }



    //IRJ
    public function tambahirjdetail(Request $r)
    {
        if( $r->id_dokter_irj == '' || $r->pasien_lama == '' || $r->pasien_baru=='')
        {
            return response()->json(
                [
                  'success' => false,
                  'message' => 'Lengkapi data terlebih dahulu'
                ]
           );
        }
        else if( ($r->pasien_lama + $r->pasien_baru) < 0 )
        {
            return response()->json(
                [
                  'success' => false,
                  'message' => 'Total Pasien tidak boleh di bawah 0, Coba periksa kembali inputan Anda.'
                ]
           );
        }
        else{
                $sup = new \App\Models\Laporanirjdetail();
                $sup->id_dokter_irj = $r->id_dokter_irj;
                $sup->id_pengawas =\Auth::user()->id;
                $sup->pasien_lama = $r->pasien_lama;
                $sup->pasien_baru = $r->pasien_baru;
                $sup->pasien_total = $r->pasien_lama + $r->pasien_baru;
                $date = date_default_timezone_set('Asia/Jakarta');
                $sup->created_at = date('Y-m-d H:i:s');
                $sup->updated_at =  date('Y-m-d H:i:s');
                $sup->save();

                //log data
                $log = new \App\Models\Log;
                $log->id_user = \Auth::user()->id;
                $log->id_log_jenis = 4;
                $log->keterangan = 'Tambah Data Keterangan menurut Dokter IRJ';
                $log->created_at = date('Y-m-d H:i:s');
                $log->updated_at =  date('Y-m-d H:i:s');
                $log->save();
        
                return response()->json(
                    [
                    'success' => true,
                    'message' => 'Berhasil menambah data keterangan pasien menurut dokter'
                    ]
            );
        }
            
    }
  
    public function editirjdetail(Request $r)
    {
 
        if( $r->id_dokter_irj == '' || $r->pasien_lama == '' || $r->pasien_baru=='' || $r->id == '')
        {
            return response()->json(
                [
                  'success' => false,
                  'message' => 'Lengkapi data terlebih dahulu'
                ]
           );
        }
        else if( ($r->pasien_lama + $r->pasien_baru) < 0 )
        {
            return response()->json(
                [
                  'success' => false,
                  'message' => 'Total Pasien tidak boleh di bawah 0, Coba periksa kembali inputan Anda.'
                ]
           );
        }
        else if( \App\Models\Laporanirjdetail::where('id_pengawas',\Auth::user()->id)->where('status',0)->where('id_dokter_irj',$r->id_dokter_irj)->where('id', '<>', $r->id)->first())
        {
            return response()->json(
                [
                  'success' => false,
                  'message' => 'Data Keterangan menurut Dokter : '.\App\Models\Dokterirj::where('id',$r->id_dokter_irj)->pluck('nama')->first() .' sudah ada'
                ]
           );
        }
        else{
            $sup = \App\Models\Laporanirjdetail::where('id', $r->id)->first();
            $sup->id_dokter_irj = $r->id_dokter_irj;
            $sup->id_pengawas =\Auth::user()->id;
            $sup->pasien_lama = $r->pasien_lama;
            $sup->pasien_baru = $r->pasien_baru;
            $sup->pasien_total = $r->pasien_lama + $r->pasien_baru;
            $date = date_default_timezone_set('Asia/Jakarta');
            $sup->updated_at =  date('Y-m-d H:i:s');
            $sup->save();
    
            //log data
            $log = new \App\Models\Log;
            $log->id_user = \Auth::user()->id;
            $log->id_log_jenis = 4;
            $log->keterangan = 'Edit Data Keterangan menurut Dokter IRJ';
            $log->created_at = date('Y-m-d H:i:s');
            $log->updated_at =  date('Y-m-d H:i:s');
            $log->save();
      
            return response()->json(
                [
                  'success' => true,
                  'message' => 'Berhasil mengubah data keterangan pasien menurut dokter'
                ]
           );
        }
        
      
    }
  
    public function deleteirjdetail(Request $r)
    {
  
      $sup = \App\Models\Laporanirjdetail::where('id', $r->id)->first()->delete();
    
      //log data
      $log = new \App\Models\Log;
      $log->id_user = \Auth::user()->id;
      $log->id_log_jenis = 4;
      $log->keterangan = 'Hapus Data Keterangan menurut Dokter IRJ';
      $log->created_at = date('Y-m-d H:i:s');
      $log->updated_at =  date('Y-m-d H:i:s');
      $log->save();

      return response()->json(
        [
          'success' => true,
          'message' => 'Berhasil menghapus data keterangan pasien menurut dokter'
        ]
        );
    }
  


    public function draftlaporanIRJ(Request $r){
        $sp = \App\Models\Laporanirjdetail::where('id_pengawas',\Auth::user()->id)->where('status',0)->first();
 
        if (!$sp) {
          return redirect()->back()->with('fail-add', 'Jumlah pasien menurut Dokter masih kosong, silahkan isi terlebih dahulu');
        } else {
            $sup = new \App\Models\Laporanirj;
            $sup->id_pengawas = \Auth::user()->id;
            $sup->masalah = $r->irj_masalah;
            $sup->langkah_atasi_masalah = $r->irj_langkah;
            $date = date_default_timezone_set('Asia/Jakarta');
            $sup->created_at = date('Y-m-d H:i:s');
            $sup->updated_at =  date('Y-m-d H:i:s');
            $sup->save();

            //log data
            $log = new \App\Models\Log;
            $log->id_user = \Auth::user()->id;
            $log->id_log_jenis = 3;
            $log->keterangan = 'Tambah Draft';
            $log->created_at = date('Y-m-d H:i:s');
            $log->updated_at =  date('Y-m-d H:i:s');
            $log->save();

        return redirect()->back()->with('success-add', 'Berhasil menambah ke Draft Laporan IRJ');
        }

    }
    public function editDraftlaporanIRJ(Request $r){
        $sp = \App\Models\Laporanirjdetail::where('id_pengawas',\Auth::user()->id)->where('status',0)->first();
 
        if (!$sp) {
          return redirect()->back()->with('fail-add', 'Jumlah pasien menurut Dokter masih kosong, silahkan isi terlebih dahulu');
        } else {
            $sup = \App\Models\Laporanirj::where('id',$r->id)->first();
            $sup->id_pengawas = \Auth::user()->id;
            $sup->masalah = $r->irj_masalah;
            $sup->langkah_atasi_masalah = $r->irj_langkah;
            
            $date = date_default_timezone_set('Asia/Jakarta');
            $sup->updated_at =  date('Y-m-d H:i:s');
            $sup->save();

            //log data
            $log = new \App\Models\Log;
            $log->id_user = \Auth::user()->id;
            $log->id_log_jenis = 3;
            $log->keterangan = 'Edit Draft';
            $log->created_at = date('Y-m-d H:i:s');
            $log->updated_at =  date('Y-m-d H:i:s');
            $log->save();

            return redirect()->back()->with('success-add', 'Berhasil menambah ke Draft Laporan IRJ');
        }
    }
    public function deleteDraftlaporanIRJ($id){
        $sup = \App\Models\Laporanirj::where('id',$id)->first();
        $sup->status = 2; //Delete Laporan
        $sup->save();

        //hapus detail
        \App\Models\Laporanirjdetail::where('status', 0)->where('id_pengawas',\Auth::user()->id)->delete();

        //log data
        $log = new \App\Models\Log;
        $log->id_user = \Auth::user()->id;
        $log->id_log_jenis = 3;
        $log->keterangan = 'Hapus Draft';
        $log->created_at = date('Y-m-d H:i:s');
        $log->updated_at =  date('Y-m-d H:i:s');
        $log->save();

        return redirect()->back()->with('success-add', 'Berhasil menghapus data draf Laporan IRJ');
    }


    //IBS
    public function tambahibsdetail(Request $r)
    {
        if( $r->nama == '' || $r->rm == '' || $r->id_dokter_operasi == '' || $r->id_dokter_anestesi == '' || $r->id_ruangan=='' || $r->jam_mulai=='' || $r->jam_selesai=='' || $r->diagnosapre=='' || $r->diagnosapost=='')
        {
            return response()->json(
                [
                  'success' => false,
                  'message' => 'Lengkapi data terlebih dahulu'
                ]
           );
        }
        else{
                $sup = new \App\Models\Laporanibsdetail();
                $sup->id_pengawas =\Auth::user()->id;
                $sup->nama = $r->nama;
                $sup->rm = $r->rm;
                $sup->id_dokter_operasi = implode(",",$r->id_dokter_operasi);
                $sup->id_dokter_anestesi = $r->id_dokter_anestesi;
                $sup->pendamping = $r->pendamping;
                $sup->id_ruangan = $r->id_ruangan;
                $sup->jam_mulai = $r->jam_mulai;
                $sup->jam_selesai = $r->jam_selesai;
                $sup->diagnosa_pre = $r->diagnosapre;
                $sup->diagnosa_post = $r->diagnosapost;

                $date = date_default_timezone_set('Asia/Jakarta');
                $sup->created_at = date('Y-m-d H:i:s');
                $sup->updated_at =  date('Y-m-d H:i:s');
                $sup->save();

                //log data
                $log = new \App\Models\Log;
                $log->id_user = \Auth::user()->id;
                $log->id_log_jenis = 17;
                $log->keterangan = 'Tambah Data Keterangan menurut Dokter IBS';
                $log->created_at = date('Y-m-d H:i:s');
                $log->updated_at =  date('Y-m-d H:i:s');
                $log->save();
        
                return response()->json(
                    [
                    'success' => true,
                    'message' => 'Berhasil menambah data keterangan pasien operasi menurut dokter'
                    ]
            );
        }
            
    }
  
    public function editibsdetail(Request $r)
    {
 
        if( $r->nama == '' || $r->rm == '' || $r->id_dokter_operasi == '' || $r->id_dokter_anestesi == '' || $r->id_ruangan=='' || $r->jam_mulai=='' || $r->jam_selesai=='' || $r->diagnosapre=='' || $r->diagnosapost=='')
        {
            return response()->json(
                [
                  'success' => false,
                  'message' => 'Lengkapi data terlebih dahulu'
                ]
           );
        }
        
        else{
            $sup = \App\Models\Laporanibsdetail::where('id', $r->id)->first();
            $sup->id_pengawas =\Auth::user()->id;
            $sup->nama = $r->nama;
            $sup->rm = $r->rm;
            $sup->id_dokter_operasi = implode(",",$r->id_dokter_operasi);
            $sup->id_dokter_anestesi = $r->id_dokter_anestesi;
            $sup->pendamping = $r->pendamping;
            $sup->id_ruangan = $r->id_ruangan;
            $sup->jam_mulai = $r->jam_mulai;
            $sup->jam_selesai = $r->jam_selesai;
            $sup->diagnosa_pre = $r->diagnosapre;
            $sup->diagnosa_post = $r->diagnosapost;
            $date = date_default_timezone_set('Asia/Jakarta');
            $sup->updated_at =  date('Y-m-d H:i:s');
            $sup->save();
    
            //log data
            $log = new \App\Models\Log;
            $log->id_user = \Auth::user()->id;
            $log->id_log_jenis = 17;
            $log->keterangan = 'Edit Data Keterangan menurut Dokter IBS';
            $log->created_at = date('Y-m-d H:i:s');
            $log->updated_at =  date('Y-m-d H:i:s');
            $log->save();
      
            return response()->json(
                [
                  'success' => true,
                  'message' => 'Berhasil mengubah data keterangan pasien menurut dokter IBS'
                ]
           );
        }
        
      
    }
  
    public function deleteibsdetail(Request $r)
    {
  
      $sup = \App\Models\Laporanibsdetail::where('id', $r->id)->first()->delete();
    
      //log data
      $log = new \App\Models\Log;
      $log->id_user = \Auth::user()->id;
      $log->id_log_jenis = 17;
      $log->keterangan = 'Hapus Data Keterangan menurut Dokter IBS';
      $log->created_at = date('Y-m-d H:i:s');
      $log->updated_at =  date('Y-m-d H:i:s');
      $log->save();

      return response()->json(
        [
          'success' => true,
          'message' => 'Berhasil menghapus data keterangan pasien menurut dokter IBS'
        ]
        );
    }
  


    public function draftlaporanIBS(Request $r){
        $sp = \App\Models\Laporanibsdetail::where('id_pengawas',\Auth::user()->id)->where('status',0)->first();
 
        if (!$sp) {
          return redirect()->back()->with('fail-add', 'Jumlah pasien menurut Dokter IBS masih kosong, silahkan isi terlebih dahulu');
        } else {
            $sup = new \App\Models\Laporanibs;
            $sup->id_pengawas = \Auth::user()->id;
            $sup->total_pasien = \App\Models\Laporanibsdetail::where('id_pengawas',\Auth::user()->id)->where('status',0)->count();
            $sup->catatan = $r->ibs_catatan;
            $date = date_default_timezone_set('Asia/Jakarta');
            $sup->created_at = date('Y-m-d H:i:s');
            $sup->updated_at =  date('Y-m-d H:i:s');
            $sup->save();

            //log data
            $log = new \App\Models\Log;
            $log->id_user = \Auth::user()->id;
            $log->id_log_jenis = 16;
            $log->keterangan = 'Tambah Draft';
            $log->created_at = date('Y-m-d H:i:s');
            $log->updated_at =  date('Y-m-d H:i:s');
            $log->save();

        return redirect()->back()->with('success-add', 'Berhasil menambah ke Draft Laporan IBS');
        }

    }
    public function editDraftlaporanIBS(Request $r){
        $sp = \App\Models\Laporanibsdetail::where('id_pengawas',\Auth::user()->id)->where('status',0)->first();
 
        if (!$sp) {
          return redirect()->back()->with('fail-add', 'Jumlah pasien menurut Dokter IBS masih kosong, silahkan isi terlebih dahulu');
        } else {
            $sup = \App\Models\Laporanibs::where('id',$r->idibs)->first();
            $sup->id_pengawas = \Auth::user()->id;
            $sup->total_pasien = \App\Models\Laporanibsdetail::where('id_pengawas',\Auth::user()->id)->where('status',0)->count();
            $sup->catatan = $r->ibs_catatan;
            
            $date = date_default_timezone_set('Asia/Jakarta');
            $sup->updated_at =  date('Y-m-d H:i:s');
            $sup->save();

            //log data
            $log = new \App\Models\Log;
            $log->id_user = \Auth::user()->id;
            $log->id_log_jenis = 16;
            $log->keterangan = 'Edit Draft';
            $log->created_at = date('Y-m-d H:i:s');
            $log->updated_at =  date('Y-m-d H:i:s');
            $log->save();

            return redirect()->back()->with('success-add', 'Berhasil menambah ke Draft Laporan IBS');
        }
    }
    public function deleteDraftlaporanIBS($id){
        $sup = \App\Models\Laporanibs::where('id',$id)->first();
        $sup->status = 2; //Delete Laporan
        $sup->save();

        //hapus detail
        \App\Models\Laporanibsdetail::where('status', 0)->where('id_pengawas',\Auth::user()->id)->delete();

        //log data
        $log = new \App\Models\Log;
        $log->id_user = \Auth::user()->id;
        $log->id_log_jenis = 16;
        $log->keterangan = 'Hapus Draft';
        $log->created_at = date('Y-m-d H:i:s');
        $log->updated_at =  date('Y-m-d H:i:s');
        $log->save();

        return redirect()->back()->with('success-add', 'Berhasil menghapus data draf Laporan IBS');
    }

    // Catatan PASIEN

    public function tambahcatatanpasien(Request $r)
    {
        if( $r->kamar == '' || $r->nama == '' || $r->rm == '' || $r->diagnosa == '' || $r->dpjp=='' || $r->kondisi=='' || $r->jenis_pasien==''|| $r->ruangan=='')
        {
            return response()->json(
                [
                  'success' => false,
                  'message' => 'Lengkapi data terlebih dahulu'
                ]
           );
        }
        else{
                $sup = new \App\Models\Catatanpasien();
                $sup->id_pengawas =\Auth::user()->id;

                if(\App\Models\Laporanumum::where('id_ruangan',$r->ruangan)->where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('id')->last())
                {
                    $sup->id_laporan_umum = \App\Models\Laporanumum::where('id_ruangan',$r->ruangan)->where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('id')->last();
                }

                $sup->id_jenis_pasien = $r->jenis_pasien;
                $sup->id_ruangan = $r->ruangan;
                $sup->kamar = $r->kamar;
                $sup->nama = $r->nama;
                $sup->rm = $r->rm;
                $sup->diagnosa = $r->diagnosa;
                $sup->dpjp = $r->dpjp;
                $sup->kondisi = $r->kondisi;
              
                $date = date_default_timezone_set('Asia/Jakarta');
                $sup->created_at = date('Y-m-d H:i:s');
                $sup->updated_at =  date('Y-m-d H:i:s');
                $sup->save();

                //log data
                $log = new \App\Models\Log;
                $log->id_user = \Auth::user()->id;
                $log->id_log_jenis = 18;
                $log->keterangan = 'Tambah Catatan Pasien '.\App\Models\Jenispasien::where('id',$r->jenis_pasien)->pluck('jenis')->first();
                $log->created_at = date('Y-m-d H:i:s');
                $log->updated_at =  date('Y-m-d H:i:s');
                $log->save();
        
                return response()->json(
                    [
                    'success' => true,
                    'message' => 'Berhasil menambah data Catatan Pasien '.\App\Models\Jenispasien::where('id',$r->jenis_pasien)->pluck('jenis')->first()
                    ]
            );
        }
            
    }
  
    public function editcatatanpasien(Request $r)
    {
 
        if( $r->kamar == '' || $r->nama == '' || $r->rm == '' || $r->diagnosa == '' || $r->dpjp=='' || $r->kondisi=='' || $r->jenis_pasien==''|| $r->ruangan=='')
        {
            return response()->json(
                [
                  'success' => false,
                  'message' => 'Lengkapi data terlebih dahulu'
                ]
           );
        }
        
        else{
            $sup = \App\Models\Catatanpasien::where('id', $r->id)->first();
            $sup->id_pengawas =\Auth::user()->id;

            if(\App\Models\Laporanumum::where('id_ruangan',$r->ruangan)->where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('id')->last())
            {
                $sup->id_laporan_umum = \App\Models\Laporanumum::where('id_ruangan',$r->ruangan)->where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('id')->last();
            }

            $sup->id_jenis_pasien = $r->jenis_pasien;
            $sup->id_ruangan = $r->ruangan;
            $sup->kamar = $r->kamar;
            $sup->nama = $r->nama;
            $sup->rm = $r->rm;
            $sup->diagnosa = $r->diagnosa;
            $sup->dpjp = $r->dpjp;
            $sup->kondisi = $r->kondisi;
            $date = date_default_timezone_set('Asia/Jakarta');
            $sup->updated_at =  date('Y-m-d H:i:s');
            $sup->save();
    
            //log data
            $log = new \App\Models\Log;
            $log->id_user = \Auth::user()->id;
            $log->id_log_jenis = 18;
            $log->keterangan = 'Ubah Catatan Pasien '.\App\Models\Jenispasien::where('id',$r->jenis_pasien)->pluck('jenis')->first();
            $log->created_at = date('Y-m-d H:i:s');
            $log->updated_at =  date('Y-m-d H:i:s');
            $log->save();
    
            return response()->json(
                [
                'success' => true,
                'message' => 'Berhasil mengubah data Catatan Pasien '.\App\Models\Jenispasien::where('id',$r->jenis_pasien)->pluck('jenis')->first()
                ]
           );
        }
        
      
    }
  
    public function deletecatatanpasien(Request $r)
    {
  
      $sup = \App\Models\Catatanpasien::where('id', $r->id)->first()->delete();
    
      //log data
      $log = new \App\Models\Log;
      $log->id_user = \Auth::user()->id;
      $log->id_log_jenis = 18;
      $log->keterangan = 'Hapus Data Catatan Pasien '.\App\Models\Jenispasien::where('id',$r->jenis_pasien)->pluck('jenis')->first();
      $log->created_at = date('Y-m-d H:i:s');
      $log->updated_at =  date('Y-m-d H:i:s');
      $log->save();

      return response()->json(
        [
          'success' => true,
          'message' => 'Berhasil menghapus data Catatan Pasien '.\App\Models\Jenispasien::where('id',$r->jenis_pasien)->pluck('jenis')->first()
        ]
        );
    }

    public function kirimLaporan(Request $r)
    {   


        $folderPath = public_path('signature/');
        $image_parts = explode(";base64,", $r->signed);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $namafile = uniqid() . '.'.$image_type;
        $file = $folderPath . $namafile;
        
        file_put_contents($file, $image_base64);
        
        $date = date_default_timezone_set('Asia/Jakarta');
        $sup = new \App\Models\Laporan;
        $sup->id_pengawas = \Auth::user()->id;
        $sup->id_dinas = $r->dinas;
        $sup->signature = $namafile;
        $sup->created_at = date('Y-m-d H:i:s');
        $sup->updated_at = date('Y-m-d H:i:s');
        $sup->save();

        //Update Laporan IGD
        $igd = \App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->first();
        $igd->id_laporan = \App\Models\Laporan::where('id_pengawas',\Auth::user()->id)->pluck('id')->last();
        $igd->status = 1;
        
        $igd->updated_at = date('Y-m-d H:i:s');
        $igd->save();

        //Update Laporan Umum
        $umum = \App\Models\Laporanumum::where('id_pengawas',\Auth::user()->id)->where('status',0)->update(['id_laporan' => \App\Models\Laporan::where('id_pengawas',\Auth::user()->id)->pluck('id')->last(), 'updated_at' => date('Y-m-d H:i:s'), 'status' => 1]);
        $catatanpasien = \App\Models\Catatanpasien::where('id_pengawas',\Auth::user()->id)->where('status',0)->update(['updated_at' => date('Y-m-d H:i:s'), 'status' => 1]);
        //Update Laporan IRJ
        $irj = \App\Models\Laporanirj::where('id_pengawas',\Auth::user()->id)->where('status',0)->update(['id_laporan' => \App\Models\Laporan::where('id_pengawas',\Auth::user()->id)->pluck('id')->last(), 'updated_at' => date('Y-m-d H:i:s'), 'status' => 1]);
        $irjdetail = \App\Models\Laporanirjdetail::where('id_pengawas',\Auth::user()->id)->where('status',0)->update(['id_laporan_irj' => \App\Models\Laporanirj::where('id_pengawas',\Auth::user()->id)->pluck('id')->last(), 'status' => 1]);

        //Update Laporan IBS
        $ibs = \App\Models\Laporanibs::where('id_pengawas',\Auth::user()->id)->where('status',0)->update(['id_laporan' => \App\Models\Laporan::where('id_pengawas',\Auth::user()->id)->pluck('id')->last(), 'updated_at' => date('Y-m-d H:i:s'), 'status' => 1]);
        $ibsdetail = \App\Models\Laporanibsdetail::where('id_pengawas',\Auth::user()->id)->where('status',0)->update(['id_laporan_ibs' => \App\Models\Laporanibs::where('id_pengawas',\Auth::user()->id)->pluck('id')->last(), 'status' => 1]);


        //log data
        $log = new \App\Models\Log;
        $log->id_user = \Auth::user()->id;
        $log->id_log_jenis = 5;
        $log->keterangan = 'Kirim Laporan ke Direktur untuk diverifikasi';
        $log->created_at = date('Y-m-d H:i:s');
        $log->updated_at =  date('Y-m-d H:i:s');
        $log->save();

        return redirect()->back()->with('success-add', 'Berhasil Submit Laporan Pengawas Umum');
    }
}
