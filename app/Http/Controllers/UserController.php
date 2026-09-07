<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
class UserController extends Controller
{
    //ganti password
  public function gantipassword(Request $r)
  {
    $lok = \App\Models\User::where('id', $r->id)->first();
    //if(bcrypt($r->passlama) != $lok->password)
    if (!(Hash::check($r->get('passlama'), \Auth::user()->password))) {
      return redirect()->back()->with('fail-change', 'Password sebelumnya tidak sesuai');
    } else {
      $lok->password = bcrypt($r->password);
      $lok->save();
     
      //return redirect()->back()->with('success-edit','Berhasil ganti password');
      
      return redirect('/')->with('success-change', 'Password berhasil diubah');
      \Auth::logout();
      
      
      
    }
  }

  public function gantipassword2(Request $r)
  {
    $lok = \App\Models\User::where('username', $r->username)->where('status',1)->first();
  
    if (!$lok) {
        return redirect()->back()->withErrors(['Username tidak ditemukan atau tidak aktif']);
    }

    if (!Hash::check($r->passlama, $lok->password)) {
      return redirect()->back()->withErrors(['Password sebelumnya tidak sesuai']);
    } else {
      $lok->password = bcrypt($r->password);
      $lok->save();
    
      return redirect()->back()->with('success-change', 'Password berhasil diubah');
    }
  }

}
