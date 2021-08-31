<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KeperawatanController extends Controller
{

    //PIKET

    public function tambahpiket(Request $r)
  {

      $sup = new \App\Models\Piket;
      $sup->id_pengawas = $r->id_pengawas;
      $sup->id_dinas = $r->id_dinas;
      $sup->tanggal = $r->tanggal;
      $sup->save();

      return redirect()->back()->with('success-add', 'Berhasil menambah data');

  }

  public function editpiket(Request $r)
  {
    
      $sup = \App\Models\Piket::where('tanggal', $r->tanggal)->where('id_dinas',$r->id_dinas)->first();

   
        $sup->id_pengawas = $r->id_pengawas;
        $sup->id_dinas = $r->id_dinas;
        $sup->tanggal = $r->tanggal;
        $sup->save();
  
        return redirect()->back()->with('success-add', 'Berhasil mengubah data');
    
      
    
  }

  public function deletepiket($id)
  {

    $sup = \App\Models\Piket::where('id', $id)->first()->delete();
    return redirect()->back()->with('success-delete', 'Berhasil menghapus data');
  }
}
