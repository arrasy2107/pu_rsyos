<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;

class LoginController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    // $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */

  
  public function dologin(Request $r)
  {
    $direktur = array(
      'username' => $r->username,
      'password' => $r->password,
      'id_role' => 1,
      'status' => 1,
    );
    $pengawas = array(
      'username' => $r->username,
      'password' => $r->password,
      'id_role' => 2,
      'status' => 1,
    );
    $keperawatan = array(
      'username' => $r->username,
      'password' => $r->password,
      'id_role' => 3,
      'status' => 1,
    );

   

    if (\Auth::attempt($direktur) || \Auth::attempt($keperawatan)) {
      return redirect()->to('/dashboard');
    } else if (\Auth::attempt($pengawas)) {
      return redirect()->to('/laporan');
    } else {
      return redirect()->back()->withErrors(['Username dan password tidak cocok']);
    }
  }


  public function logout()
  {

    \Auth::logout();
    return redirect('/');
  }
 
}
