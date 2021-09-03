<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DirekturController extends Controller
{


  //PENGGUNA
  public function tambahpengguna(Request $r)
  {

    $sp = \App\Models\User::where('username', $r->username)->where('status',1)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Username ' . $r->username . ' sudah pernah diinputkan sebelumnya, silahkan input dengan username lain');
    } else {
      $sup = new \App\Models\User;
      $sup->nama = $r->nama;
      $sup->username = $r->username;
      $password = '12345678';
      $sup->password = bcrypt($password);
      $sup->id_role = $r->role;
      $date = date_default_timezone_set('Asia/Jakarta');
      $sup->created_at = date('Y-m-d H:i:s');
      $sup->updated_at =  date('Y-m-d H:i:s');
      $sup->save();

      return redirect()->back()->with('success-add', 'Berhasil menambah data');
    }
  }

  public function editpengguna(Request $r)
  {
    $sp = \App\Models\User::where('username', $r->username)->where('id', '<>', $r->id)->where('status',1)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Username ' . $r->username . ' sudah pernah diinputkan sebelumnya, silahkan input dengan username lain');
    } else {
      $sup = \App\Models\User::where('id', $r->id)->first();
      $sup->nama = $r->nama;
      $sup->username = $r->username;
      $sup->id_role = $r->role;
      $date = date_default_timezone_set('Asia/Jakarta');
      $sup->updated_at =  date('Y-m-d H:i:s');
      $sup->save();

      return redirect()->back()->with('success-add', 'Berhasil mengubah data');
    }
  }

  public function deletepengguna($id)
  {

    $sup = \App\Models\User::where('id', $id)->first();
    $sup->status = 0;
    $sup->save();
    return redirect()->back()->with('success-delete', 'Berhasil menghapus data');
  }

  //RUANGAN

  public function tambahruangan(Request $r)
  {

    $sp = \App\Models\Ruangan::where('nama_ruangan', $r->nama_ruangan)->where('status',1)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Nama Ruangan  ' . $r->nama_ruangan . ' sudah pernah diinputkan sebelumnya, silahkan input dengan nama lain');
    } else {
      $sup = new \App\Models\Ruangan;
      $sup->nama_ruangan = $r->nama_ruangan;
      $sup->save();

      return redirect()->back()->with('success-add', 'Berhasil menambah data');
    }
  }

  public function editruangan(Request $r)
  {
    $sp = \App\Models\Ruangan::where('nama_ruangan', $r->nama_ruangan)->where('id', '<>', $r->id)->where('status',1)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Nama Ruangan  ' . $r->nama_ruangan . ' sudah pernah diinputkan sebelumnya, silahkan input dengan nama lain');
    } else {
      $sup = \App\Models\Ruangan::where('id', $r->id)->first();
      $sup->nama_ruangan = $r->nama_ruangan;
      $sup->save();

      return redirect()->back()->with('success-add', 'Berhasil mengubah data');
    }
  }

  public function deleteruangan($id)
  {

    $sup = \App\Models\Ruangan::where('id', $id)->first();
    $sup->status = 0;
    $sup->save();
    return redirect()->back()->with('success-delete', 'Berhasil menghapus data');
  }


  //DOKTER IGD

  public function tambahdokter(Request $r)
  {

    $sp = \App\Models\Dokter::where('nama_dokter', $r->nama_dokter)->where('status',1)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Nama Dokter  ' . $r->nama_dokter . ' sudah pernah diinputkan sebelumnya, silahkan input dengan nama lain');
    } else {
      $sup = new \App\Models\Dokter;
      $sup->nama_dokter = $r->nama_dokter;
      $sup->id_sdmk_jenis = $r->id_sdmk_jenis;
      $sup->save();

      return redirect()->back()->with('success-add', 'Berhasil menambah data');
    }
  }

  public function editdokter(Request $r)
  {
    $sp = \App\Models\Dokter::where('nama_dokter', $r->nama_dokter)->where('id', '<>', $r->id)->where('status',1)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Nama Dokter  ' . $r->nama_dokter . ' sudah pernah diinputkan sebelumnya, silahkan input dengan nama lain');
    } else {
      $sup = \App\Models\Dokter::where('id', $r->id)->first();
      $sup->nama_dokter = $r->nama_dokter;
      $sup->id_sdmk_jenis = $r->id_sdmk_jenis;
      $sup->save();

      return redirect()->back()->with('success-add', 'Berhasil mengubah data');
    }
  }

  public function deletedokter($id)
  {

    $sup = \App\Models\Dokter::where('id', $id)->first();
    $sup->status = 0;
    $sup->save();
    return redirect()->back()->with('success-delete', 'Berhasil menghapus data');
  }

  //DOKTER IRJ

  public function tambahdokterirj(Request $r)
  {

    $sp = \App\Models\Dokterirj::where('nama', $r->nama_dokter)->where('status',1)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Nama Dokter  ' . $r->nama_dokter . ' sudah pernah diinputkan sebelumnya, silahkan input dengan nama lain');
    } else {
      $sup = new \App\Models\Dokterirj;
      $sup->nama = $r->nama_dokter;
      $sup->id_sdmk_jenis = $r->id_sdmk_jenis;
      $sup->save();

      return redirect()->back()->with('success-add', 'Berhasil menambah data');
    }
  }

  public function editdokterirj(Request $r)
  {
    $sp = \App\Models\Dokterirj::where('nama', $r->nama_dokter)->where('id', '<>', $r->id)->where('status',1)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Nama Dokter  ' . $r->nama_dokter . ' sudah pernah diinputkan sebelumnya, silahkan input dengan nama lain');
    } else {
      $sup = \App\Models\Dokterirj::where('id', $r->id)->first();
      $sup->nama_dokter = $r->nama_dokter;
      $sup->id_sdmk_jenis = $r->id_sdmk_jenis;
      $sup->save();

      return redirect()->back()->with('success-add', 'Berhasil mengubah data');
    }
  }

  public function deletedokterirj($id)
  {

    $sup = \App\Models\Dokterirj::where('id', $id)->first();
    $sup->status = 0;
    $sup->save();
    return redirect()->back()->with('success-delete', 'Berhasil menghapus data');
  }


  //Jenis SDMK

  public function tambahjenissdmk(Request $r)
  {

    $sp = \App\Models\sdmk_jenis::where('jenis', $r->jenis)->where('status',1)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Nama Jenis  ' . $r->jenis . ' sudah pernah diinputkan sebelumnya, silahkan input dengan nama lain');
    } else {
      $sup = new \App\Models\sdmk_jenis();
      $sup->id_subrumpun = $r->id_subrumpun;
      $sup->jenis = $r->jenis;
      $sup->save();

      return redirect()->back()->with('success-add', 'Berhasil menambah data');
    }
  }

  public function editjenissdmk(Request $r)
  {
    $sp = \App\Models\sdmk_jenis::where('jenis', $r->jenis)->where('id', '<>', $r->id)->where('status',1)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Nama Jenis  ' . $r->jenis . ' sudah pernah diinputkan sebelumnya, silahkan input dengan nama lain');
    } else {
      $sup = \App\Models\sdmk_jenis::where('id', $r->id)->first();
      $sup->id_subrumpun = $r->id_subrumpun;
      $sup->jenis = $r->jenis;
      $sup->save();

      return redirect()->back()->with('success-add', 'Berhasil mengubah data');
    }
  }

  public function deletejenissdmk($id)
  {

    $sup = \App\Models\sdmk_jenis::where('id', $id)->first();
    $sup->status = 0;
    $sup->save();
    return redirect()->back()->with('success-delete', 'Berhasil menghapus data');
  }

   //Subrumpun SDMK

   public function tambahsubrumpunsdmk(Request $r)
   {
 
     $sp = \App\Models\sdmk_subrumpun::where('subrumpun', $r->subrumpun)->where('status',1)->first();
 
     if ($sp) {
       return redirect()->back()->with('fail-delete', 'Nama Subrumpun  ' . $r->subrumpun . ' sudah pernah diinputkan sebelumnya, silahkan input dengan nama lain');
     } else {
       $sup = new \App\Models\sdmk_subrumpun();
       $sup->subrumpun = $r->subrumpun;
       $sup->save();
 
       return redirect()->back()->with('success-add', 'Berhasil menambah data');
     }
   }
 
   public function editsubrumpunsdmk(Request $r)
   {
     $sp = \App\Models\sdmk_subrumpun::where('subrumpun', $r->subrumpun)->where('id', '<>', $r->id)->where('status',1)->first();
 
     if ($sp) {
       return redirect()->back()->with('fail-delete', 'Nama Subrumpun  ' . $r->subrumpun . ' sudah pernah diinputkan sebelumnya, silahkan input dengan nama lain');
     } else {
       $sup = \App\Models\sdmk_subrumpun::where('id', $r->id)->first();
       $sup->subrumpun = $r->subrumpun;
       $sup->save();
 
       return redirect()->back()->with('success-add', 'Berhasil mengubah data');
     }
   }
 
   public function deletesubrumpunsdmk($id)
   {
 
     $sup = \App\Models\sdmk_subrumpun::where('id', $id)->first();
     $sup->status = 0;
     $sup->save();
     return redirect()->back()->with('success-delete', 'Berhasil menghapus data');
   }


}
