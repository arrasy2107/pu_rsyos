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
    // --- 1. Cek password default → paksa ganti dulu ---
    if ($r->password === '12345678') {
      // Coba login sekali untuk verifikasi identitas
      if (\Auth::attempt(['username' => $r->username, 'password' => $r->password, 'status' => 1])) {
        \Auth::logout();
        return redirect()->to('/ganti-password')->with('force_username', $r->username);
      }
      return redirect()->back()->withErrors(['Username dan password tidak cocok']);
    }

    // --- 2. Satu kali attempt dengan kredensial dasar ---
    $credentials = [
      'username' => $r->username,
      'password' => $r->password,
      'status'   => 1,
    ];

    if (!\Auth::attempt($credentials)) {
      $this->logActivity(0, 'Percobaan Username : ' . $r->username . ' Login Gagal karena username dan password tidak cocok');
      return redirect()->back()->withErrors(['Username dan password tidak cocok']);
    }

    // --- 3. User berhasil login, ambil role ---
    $user   = \Auth::user();
    $idRole = $user->id_role;

    // Superadmin (0), Direktur (1), Keperawatan (3) → langsung ke dashboard
    if (in_array($idRole, [0, 1, 3])) {
      $this->logActivity($user->id, 'Username : ' . $r->username . ' Login');
      return redirect()->to('/dashboard');
    }

    // --- 4. Pengawas (2) → sementara diperbolehkan login tanpa piket aktif ---
    if ($idRole === 2) {
      // $dinasAktif = $this->getDinasAktif();
      // $hariini    = date('Y-m-d');

      // $piket = \App\Models\Piket::where('id_dinas', $dinasAktif)
      //   ->where('tanggal', $hariini)
      //   ->where('id_pengawas', $user->id)
      //   ->exists();

      // if ($piket) {
      //   $this->logActivity($user->id, 'Username : ' . $r->username . ' Login');
      //   return redirect()->to('/laporan');
      // }

      // // Pengawas tidak punya piket aktif → tolak login
      // $this->logActivity($user->id, 'Percobaan Username : ' . $r->username . ' Login Gagal karena tidak sedang bertugas');
      // \Auth::logout();
      // return redirect()->back()->withErrors(['Tidak dapat masuk ke dalam Aplikasi, karena Anda tidak sedang bertugas']);

      // Bypass validasi dinas sementara
      $this->logActivity($user->id, 'Username : ' . $r->username . ' Login');
      return redirect()->to('/laporan');
    }

    // Role tidak dikenali → logout
    \Auth::logout();
    return redirect()->back()->withErrors(['Role tidak dikenali, hubungi administrator']);
  }

  /**
   * Tulis entri log aktivitas login.
   */
  private function logActivity(int $userId, string $keterangan): void
  {
    $log = new \App\Models\Log;
    $log->id_user = $userId;
    $log->id_log_jenis = 15;
    $log->keterangan = $keterangan;
    $log->created_at = date('Y-m-d H:i:s');
    $log->updated_at = date('Y-m-d H:i:s');
    $log->save();
  }

  /**
   * Tentukan ID dinas aktif berdasarkan waktu sekarang.
   * Mengembalikan: 1 = pagi, 2 = sore, 3 = malam.
   */
  private function getDinasAktif(): int
  {
    $nowTime = \Carbon\Carbon::now();

    $dinas = \App\Models\Dinas::whereIn('id', [1, 2, 3])->get()->keyBy('id');

    $makeTime = fn($val) => $val ? \Carbon\Carbon::createFromTimeString($val) : null;

    $start2 = $makeTime($dinas[2]->jam_masuk ?? null);
    $end2   = $makeTime($dinas[2]->jam_pulang ?? null);
    $start1 = $makeTime($dinas[1]->jam_masuk ?? null);
    $end1   = $makeTime($dinas[1]->jam_pulang ?? null);

    if ($start2 && $end2 && $nowTime->between($start2, $end2)) {
      return 2;
    }

    if ($start1 && $end1 && $nowTime->between($start1, $end1)) {
      return 1;
    }

    return 3; // default: malam
  }


  public function logout()
  {

    \Auth::logout();
    return redirect('/');
  }
}
