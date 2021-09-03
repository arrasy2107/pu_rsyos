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

    $sup = \App\Models\Piket::where('id', $id)->first()->delete();
    //return redirect()->back()->with('success-delete', 'Berhasil menghapus data');
    return response()->json(
      [
        'success' => true,
        'message' => 'Berhasil menghapus data jadwal'
      ]
 );
  
  }
}
