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

   
    if($r->password == '12345678'){
      if (\Auth::attempt($direktur) || \Auth::attempt($keperawatan) || \Auth::attempt($pengawas)) {

        return redirect()->to('/ganti-password');
      } 
      else {

        return redirect()->back()->withErrors(['Username dan password tidak cocok']);
      }
    }
    else{
      if (\Auth::attempt($direktur) || \Auth::attempt($keperawatan)) {

        //log data
        $log = new \App\Models\Log;
        $log->id_user = \Auth::user()->id;
        $log->id_log_jenis = 15;
        $log->keterangan = 'Username : '.$r->username.' Login';
        $log->created_at = date('Y-m-d H:i:s');
        $log->updated_at =  date('Y-m-d H:i:s');
        $log->save();
  
        return redirect()->to('/dashboard');
      } else if (\Auth::attempt($pengawas)) {
        //log data
        $log = new \App\Models\Log;
        $log->id_user = \Auth::user()->id;
        $log->id_log_jenis = 15;
        $log->keterangan = 'Username : '.$r->username.' Login';
        $log->created_at = date('Y-m-d H:i:s');
        $log->updated_at =  date('Y-m-d H:i:s');
        $log->save();
  
        return redirect()->to('/laporan');
      } else {
        //log data
        $log = new \App\Models\Log;
        $log->id_user = 0;
        $log->id_log_jenis = 15;
        $log->keterangan = 'Percobaan Username : '.$r->username.' Login Gagal';
        $log->created_at = date('Y-m-d H:i:s');
        $log->updated_at =  date('Y-m-d H:i:s');
        $log->save();
        return redirect()->back()->withErrors(['Username dan password tidak cocok']);
      }
    }
    
  }


  public function logout()
  {

    \Auth::logout();
    return redirect('/');
  }
 
}
