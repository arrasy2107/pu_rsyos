<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KeperawatanController extends Controller
{

    //PIKET
    public function showpiket()
    {
        return view('admin.konten.jadwal');
    }

    public function tambahpiket(Request $r)
  {
      if($r->id_pengawas == '')
      {
        return response()->json(
          [
            'success' => false,
            'message' => 'Pilih Pengawas Umum terlebih dahulu'
          ]
        );
      }
      else{
        if($r->irj == 1){
              $irj = new \App\Models\Irjbuka;
              $irj->id_dinas = $r->id_dinas;
              $irj->tanggal = $r->tanggal;
              $irj->save();
            }
      
            $sup = new \App\Models\Piket;
            $sup->id_pengawas = $r->id_pengawas;
            $sup->id_dinas = $r->id_dinas;
            $sup->tanggal = $r->tanggal;
            $sup->save();
      
            //log data
            $log = new \App\Models\Log;
            $log->id_user = \Auth::user()->id;
            $log->id_log_jenis = 6;
            $log->keterangan = 'Tambah Jadwal Piket : '.\App\Models\User::where('id',$r->id_pengawas)->pluck('nama')->first().' (Dinas : '.\App\Models\Dinas::where('id',$r->id_dinas)->pluck('dinas')->first().', Tanggal : '.$r->tanggal.')';
            $log->created_at = date('Y-m-d H:i:s');
            $log->updated_at =  date('Y-m-d H:i:s');
            $log->save();
      
            //return redirect()->back()->with('success-add', 'Berhasil menambah data');
            return response()->json(
              [
                'success' => true,
                'message' => 'Berhasil menambah data jadwal'
              ]
        );
      }
      

  }

  public function editpiket(Request $r)
  {
    if($r->id_pengawas == '')
      {
        return response()->json(
          [
            'success' => false,
            'message' => 'Pilih Pengawas Umum terlebih dahulu'
          ]
        );
      }
      else{
    
          $sup = \App\Models\Piket::where('tanggal', $r->tanggal)->where('id_dinas',$r->id_dinas)->first();
          $cekirj = \App\Models\Irjbuka::where('id_dinas', $r->id_dinas)->where('tanggal',$r->tanggal)->first();

            if($r->irj == 1){
              if(!$cekirj){
                $irj = new \App\Models\Irjbuka;
                $irj->id_dinas = $r->id_dinas;
                $irj->tanggal = $r->tanggal;
                $irj->save();
              }
              
            }else{
              if($cekirj){
                $cekirj->delete();
              }

            }
      
            $sup->id_pengawas = $r->id_pengawas;
            $sup->id_dinas = $r->id_dinas;
            $sup->tanggal = $r->tanggal;
            $sup->save();

            //log data
            $log = new \App\Models\Log;
            $log->id_user = \Auth::user()->id;
            $log->id_log_jenis = 6;
            $log->keterangan = 'Edit Jadwal Piket : '.\App\Models\User::where('id',$r->id_pengawas)->pluck('nama')->first().' (Dinas : '.\App\Models\Dinas::where('id',$r->id_dinas)->pluck('dinas')->first().', Tanggal : '.$r->tanggal.')';
            $log->created_at = date('Y-m-d H:i:s');
            $log->updated_at =  date('Y-m-d H:i:s');
            $log->save();
      
            //return redirect()->back()->with('success-add', 'Berhasil mengubah data');
            return response()->json(
              [
                'success' => true,
                'message' => 'Berhasil mengubah data jadwal'
              ]
        );
          
      }
  }

  public function deletepiket($id)
  {

    $sup = \App\Models\Piket::where('id', $id)->first();

    $cekirj = \App\Models\Irjbuka::where('id_dinas', $sup->id_dinas)->where('tanggal',$sup->tanggal)->first();

    if($cekirj){
      $cekirj->delete();
    }
    //log data
    $log = new \App\Models\Log;
    $log->id_user = \Auth::user()->id;
    $log->id_log_jenis = 6;
    $log->keterangan = 'Hapus Jadwal Piket : '.\App\Models\User::where('id',$sup->id_pengawas)->pluck('nama')->first().' (Dinas : '.\App\Models\Dinas::where('id',$sup->id_dinas)->pluck('dinas')->first().', Tanggal : '.$sup->tanggal.')';
    $log->created_at = date('Y-m-d H:i:s');
    $log->updated_at =  date('Y-m-d H:i:s');
    $log->save();

    $sup->delete();

    //return redirect()->back()->with('success-delete', 'Berhasil menghapus data');
    return response()->json(
      [
        'success' => true,
        'message' => 'Berhasil menghapus data jadwal'
      ]
 );
  
  }
}
