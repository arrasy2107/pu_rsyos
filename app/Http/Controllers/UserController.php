<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //ganti password
  public function gantipassword(Request $r)
  {
    $lok = \App\User::where('id', $r->id)->first();
    //if(bcrypt($r->passlama) != $lok->password)
    if (!(Hash::check($r->get('passlama'), \Auth::user()->password))) {
      return redirect()->back()->with('fail-change', 'Password sebelumnya tidak sesuai');
    } else {
      $lok->password = bcrypt($r->password);
      $lok->save();
     
      //return redirect()->back()->with('success-edit','Berhasil ganti password');
      \Auth::logout();
      return redirect()->back()->with('success-change', 'Password berhasil diubah');
      
      
      
      
    }
  }

}
