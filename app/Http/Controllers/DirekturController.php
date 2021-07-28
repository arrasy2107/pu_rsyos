<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DirekturController extends Controller
{
    public function tambahadmin(Request $r)
  {

    $sp = \App\User::where('email', $r->email)->first();

    if ($sp) {
      return redirect()->back()->with('fail-add', 'Email ' . $r->email . ' sudah pernah diinputkan sebelumnya, silahkan input dengan email lain');
    } else {
      $sup = new \App\User;
      $sup->name = $r->name;
      $sup->email = $r->email;
      $sup->no_hp = $r->no_hp;
      $sup->id_role = $r->role;
      $sup->password = bcrypt($r->password);
      $sup->id_role = $r->role;
      $date = date_default_timezone_set('Asia/Jakarta');
      $sup->created_at = date('Y-m-d H:i:s');
      $sup->updated_at =  date('Y-m-d H:i:s');
      $sup->save();

      return redirect()->back()->with('success-add', 'Berhasil menambah data');
    }
  }

  public function editadmin(Request $r)
  {
    $sp = \App\User::where('email', $r->email)->where('id', '<>', $r->id)->first();

    if ($sp) {
      return redirect()->back()->with('fail-add', 'Email ' . $r->email . ' sudah pernah diinputkan sebelumnya, silahkan input dengan email lain');
    } else {
      $sup = \App\User::where('id', $r->id)->first();
      $sup->name = $r->name;
      $sup->email = $r->email;
      $sup->no_hp = $r->no_hp;
      $sup->id_role = $r->role;
      $date = date_default_timezone_set('Asia/Jakarta');
      $sup->updated_at =  date('Y-m-d H:i:s');
      $sup->save();

      return redirect()->back()->with('success-add', 'Berhasil mengubah data');
    }
  }

  public function deleteadmin($id)
  {

    $sup = \App\User::where('id', $id)->first()->delete();
    return redirect()->back()->with('success-delete', 'Berhasil menghapus data');
  }

}
