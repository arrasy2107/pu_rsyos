<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DirekturController extends Controller
{


  //PENGGUNA
  public function tambahpengguna(Request $r)
  {

    $sp = \App\Models\User::where('email', $r->username)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Username ' . $r->username . ' sudah pernah diinputkan sebelumnya, silahkan input dengan username lain');
    } else {
      $sup = new \App\Models\User;
      $sup->nama = $r->nama;
      $sup->username = $r->username;
      $password = 12345678;
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
    $sp = \App\Models\User::where('email', $r->email)->where('id', '<>', $r->id)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Email ' . $r->email . ' sudah pernah diinputkan sebelumnya, silahkan input dengan username lain');
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

    $sp = \App\Models\Ruangan::where('nama_ruangan', $r->nama_ruangan)->first();

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
    $sp = \App\Models\Ruangan::where('nama_ruangan', $r->nama_ruangan)->where('id', '<>', $r->id)->first();

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


  //RUANGAN

  public function tambahdokter(Request $r)
  {

    $sp = \App\Models\Dokter::where('nama_dokter', $r->nama_dokter)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Nama Dokter  ' . $r->nama_dokter . ' sudah pernah diinputkan sebelumnya, silahkan input dengan nama lain');
    } else {
      $sup = new \App\Models\Dokter;
      $sup->nama_dokter = $r->nama_dokter;
      $sup->save();

      return redirect()->back()->with('success-add', 'Berhasil menambah data');
    }
  }

  public function editdokter(Request $r)
  {
    $sp = \App\Models\Dokter::where('nama_dokter', $r->nama_dokter)->where('id', '<>', $r->id)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Nama Dokter  ' . $r->nama_dokter . ' sudah pernah diinputkan sebelumnya, silahkan input dengan nama lain');
    } else {
      $sup = \App\Models\Dokter::where('id', $r->id)->first();
      $sup->nama_dokter = $r->nama_dokter;
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
}
