<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class UserController extends Controller
{
    //ganti password
  public function gantipassword(Request $r)
  {
    $lok = User::find(Auth::id());

    if (!$lok || !Hash::check($r->get('passlama'), $lok->password)) {
      return redirect()->back()->with('fail-change', 'Password sebelumnya tidak sesuai');
    } else {
      $lok->password = bcrypt($r->password);
      $lok->save();

      Auth::logout();
      return redirect('/')->with('success-change', 'Password berhasil diubah');
    }
  }

  public function gantipassword2(Request $r)
  {
    $lok = \App\Models\User::where('username', $r->username)->where('status',1)->first();
  
    if (!$lok) {
        return redirect()->back()->withErrors(['Username tidak ditemukan atau tidak aktif'])->withInput($r->only('username'));
    }

    if (!Hash::check($r->passlama, $lok->password)) {
      return redirect()->back()->withErrors(['Password sebelumnya tidak sesuai'])->withInput($r->only('username'));
    } else {
      $lok->password = bcrypt($r->password);
      $lok->save();
    
      return redirect('/')->with('success-change', 'Password berhasil diubah, silakan login');
    }
  }

}
