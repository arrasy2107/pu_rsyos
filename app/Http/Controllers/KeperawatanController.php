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

  public function editpiket(Request $r)
  {
    
      $sup = \App\Models\Piket::where('tanggal', $r->tanggal)->where('id_dinas',$r->id_dinas)->first();

   
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

  public function deletepiket($id)
  {

    $sup = \App\Models\Piket::where('id', $id)->first();

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
