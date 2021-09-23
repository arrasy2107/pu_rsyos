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

    public function editDraftlaporanIGD(Request $r)
    {
    
        $sup = \App\Models\Laporanigd::where('id',$r->id)->first();
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
        
        $sup->jumlah_total_pasien = $r->inap_pasien_lama + $r->inap_pasien_baru ;///
        
        $date = date_default_timezone_set('Asia/Jakarta');
        $sup->created_at = date('Y-m-d H:i:s');
        $sup->updated_at =  date('Y-m-d H:i:s');
        $sup->save();

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

    public function editDraftlaporanUmum(Request $r)
    {

        $sup = \App\Models\Laporanumum::where('id',$r->id)->first();
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
        
        $sup->jumlah_total_pasien = $r->inap_pasien_lama + $r->inap_pasien_baru ;///
        
        $date = date_default_timezone_set('Asia/Jakarta');
        $sup->created_at = date('Y-m-d H:i:s');
        $sup->updated_at =  date('Y-m-d H:i:s');
        $sup->save();

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

    public function deleteDraftlaporanUmum($id)
    {

        $sup = \App\Models\Laporanumum::where('id',$id)->first();
        $sup->status = 2; //Delete Laporan
        $sup->save();

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
    public function deleteaftlaporanIRJ($id){
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
        $igd->id_laporan = \App\Models\Laporan::pluck('id')->last();
        $igd->status = 1;
        
        $igd->updated_at = date('Y-m-d H:i:s');
        $igd->save();

        //Update Laporan Umum
        $umum = \App\Models\Laporanumum::where('id_pengawas',\Auth::user()->id)->where('status',0)->update(['id_laporan' => \App\Models\Laporan::pluck('id')->last(), 'updated_at' => date('Y-m-d H:i:s'), 'status' => 1]);

        //Update Laporan IRJ
        $irj = \App\Models\Laporanirj::where('id_pengawas',\Auth::user()->id)->where('status',0)->update(['id_laporan' => \App\Models\Laporan::pluck('id')->last(), 'updated_at' => date('Y-m-d H:i:s'), 'status' => 1]);
        $irjdetail = \App\Models\Laporanirjdetail::where('id_pengawas',\Auth::user()->id)->where('status',0)->update(['id_laporan_irj' => \App\Models\Laporanirj::pluck('id')->last(), 'status' => 1]);

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
