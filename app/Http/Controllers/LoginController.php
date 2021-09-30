<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Carbon\Carbon;

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

    //CEK PIKET untuk login PENGAWAS UMUM
    date_default_timezone_set('Asia/Jakarta');
    setlocale(LC_TIME, 'id_ID');
    \Carbon\Carbon::setLocale('id');
    \Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
    $today = Carbon::now()->isoFormat('dddd, D MMMM Y');

    $now = \Carbon\Carbon::now();
    $ltime = date('H:i:s');
    $hariini = date('Y-m-d');
    $nowTime = $now->hour.':'.$now->minute.':'.$now->second;

    $start1 = \Carbon\Carbon::createFromTimeString(\App\Models\Dinas::where('id',1)->pluck('jam_masuk')->first());
    $end1 = \Carbon\Carbon::createFromTimeString(\App\Models\Dinas::where('id',1)->pluck('jam_pulang')->first());
    $start2 = \Carbon\Carbon::createFromTimeString(\App\Models\Dinas::where('id',2)->pluck('jam_masuk')->first());
    $end2 = \Carbon\Carbon::createFromTimeString(\App\Models\Dinas::where('id',2)->pluck('jam_pulang')->first());
    $start3 = \Carbon\Carbon::createFromTimeString(\App\Models\Dinas::where('id',3)->pluck('jam_masuk')->first());
    $end3 = \Carbon\Carbon::createFromTimeString(\App\Models\Dinas::where('id',3)->pluck('jam_pulang')->first());


    if(strtotime($nowTime) >= strtotime($start2) && strtotime($nowTime) <= strtotime($end2))
    {
      $dinas = 2;
    }
    else if(strtotime($nowTime) >= strtotime($start1) && strtotime($nowTime) <= strtotime($end1))
    {
      $dinas = 1;
    }
    else
    {
      $dinas = 3;
    }
    
    
    $cekpiket = \App\Models\Piket::where('id_dinas',$dinas)->where('tanggal',$hariini)->pluck('id_pengawas')->first();
    $userpiket = \App\Models\User::where('id',$cekpiket)->pluck('username')->first();
   
    if($r->password == '12345678'){
      if (\Auth::attempt($direktur) || \Auth::attempt($keperawatan) || \Auth::attempt($pengawas)) {
        \Auth::logout();
        return redirect()->to('/ganti-password');
      } 
      else {

        return redirect()->back()->withErrors(['Username dan password tidak cocok']);
      }
    }
    else if($cekpiket){
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
      } else if (\Auth::attempt($pengawas) && $userpiket == $r->username) {
        //log data
        $log = new \App\Models\Log;
        $log->id_user = \Auth::user()->id;
        $log->id_log_jenis = 15;
        $log->keterangan = 'Username : '.$r->username.' Login';
        $log->created_at = date('Y-m-d H:i:s');
        $log->updated_at =  date('Y-m-d H:i:s');
        $log->save();

        
  
        return redirect()->to('/laporan');

      } else if (\Auth::attempt($pengawas) && $userpiket != $r->username) {
        //log data
        $log = new \App\Models\Log;
        $log->id_user = \Auth::user()->id;
        $log->id_log_jenis = 15;
        $log->keterangan = 'Percobaan Username : '.$r->username.' Login Gagal karena tidak sedang bertugas';
        $log->created_at = date('Y-m-d H:i:s');
        $log->updated_at =  date('Y-m-d H:i:s');
        $log->save();
        \Auth::logout();
        return redirect()->back()->withErrors(['Tidak dapat masuk ke dalam Aplikasi, karena Anda tidak sedang bertugas']);
      }
      
      else {
        //log data
        $log = new \App\Models\Log;
        $log->id_user = 0;
        $log->id_log_jenis = 15;
        $log->keterangan = 'Percobaan Username : '.$r->username.' Login Gagal karena username dan password tidak cocok';
        $log->created_at = date('Y-m-d H:i:s');
        $log->updated_at =  date('Y-m-d H:i:s');
        $log->save();
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

        $user = \Auth::user();
        // $userToLogout = \App\Models\User::find(2);
        // \Auth::setUser($userToLogout);
        // \Auth::logout();

        \Auth::setUser($user);
  
        return redirect()->to('/laporan');
      } else {
        //log data
        $log = new \App\Models\Log;
        $log->id_user = 0;
        $log->id_log_jenis = 15;
        $log->keterangan = 'Percobaan Username : '.$r->username.' Login Gagal karena username dan password tidak cocok';
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
