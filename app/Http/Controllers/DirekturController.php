<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DirekturController extends Controller
{
  private const DOKTER_JAGA_JENIS = 1;
  private const PENGAWAS_ROLE = 2;

  private function authorizeRoles(array $roles)
  {
    if (!Auth::check()) {
      abort(403);
    }

    $role = (int) Auth::user()->id_role;

    // Super admin (id_role = 0) diizinkan mengakses semua
    if ($role === 0) {
      return;
    }

    if (!in_array($role, $roles, true)) {
      abort(403);
    }
  }

  public function dashboard()
  {
    $kasursDashboard = \App\Models\Kasur::with('kamar.ruangan')
      ->orderBy('id_kamar')
      ->orderBy('kode_kasur')
      ->get();
    $kasurStatusSummary = $kasursDashboard->groupBy('status_operasional')->map->count();

    $lastIDLaporan = \App\Models\Laporan::pluck('id')->last();
    $laporanDate = \App\Models\Laporan::pluck('created_at')->last();
    $laporanStatus = $lastIDLaporan ? \App\Models\Laporan::find($lastIDLaporan) : null;
    $dinasId = \App\Models\Laporan::pluck('id_dinas')->last();
    $dinasName = \App\Models\Dinas::where('id', $dinasId)->pluck('dinas')->first() ?? '-';
    $pengawasId = \App\Models\Laporan::where('id', $lastIDLaporan)->pluck('id_pengawas')->first();
    $pengawasName = \App\Models\User::where('id', $pengawasId)->pluck('nama')->first() ?? '-';

    // Top-level stats
    $totalIGD = \App\Models\Laporanigd::where('id_laporan', $lastIDLaporan)->pluck('jumlah_pasien')->first() ?? 0;
    $totalUmum = \App\Models\Laporanumum::where('id_laporan', $lastIDLaporan)->pluck('jumlah_total_pasien')->sum() ?? 0;
    $getIDibs = \App\Models\Laporanibs::where('id_laporan', $lastIDLaporan)->pluck('id')->first();
    $totalIBS = $getIDibs ? \App\Models\Laporanibs::where('id_laporan', $lastIDLaporan)->pluck('total_pasien')->first() : 0;
    $getIDirj = \App\Models\Laporanirj::where('id_laporan', $lastIDLaporan)->pluck('id')->first();
    $totalIRJ = $getIDirj ? \App\Models\Laporanirjdetail::where('id_laporan_irj', $getIDirj)->pluck('pasien_total')->sum() : 0;

    // Detail Data for view rendering to avoid doing queries in blade as much as possible
    $igdStatsRaw = \App\Models\Laporanigd::where('id_laporan', $lastIDLaporan)->first();
    $laporanUmum = \App\Models\Laporanumum::with('ruangan')->where('id_laporan', $lastIDLaporan)->get();
    $laporanIbsDetail = $getIDibs ? \App\Models\Laporanibsdetail::with(['dokter', 'dokterAnestesi', 'ruangan'])->where('id_laporan_ibs', $getIDibs)->get() : collect();
    $catatanIbs = \App\Models\Laporanibs::where('id_laporan', $lastIDLaporan)->pluck('catatan')->first();
    $laporanIrjDetail = $getIDirj ? \App\Models\Laporanirjdetail::with('dokter.jenisSdmk')->where('status', 1)->where('id_laporan_irj', $getIDirj)->get() : collect();

    $masalahIrj = \App\Models\Laporanirj::where('id_laporan', $lastIDLaporan)->pluck('masalah')->first();
    $langkahIrj = \App\Models\Laporanirj::where('id_laporan', $lastIDLaporan)->pluck('langkah_atasi_masalah')->first();

    return view('admin.dashboard.dashboard', compact(
      'lastIDLaporan',
      'laporanDate',
      'laporanStatus',
      'dinasId',
      'dinasName',
      'pengawasId',
      'pengawasName',
      'totalIGD',
      'totalUmum',
      'totalIBS',
      'totalIRJ',
      'igdStatsRaw',
      'laporanUmum',
      'laporanIbsDetail',
      'catatanIbs',
      'laporanIrjDetail',
      'masalahIrj',
      'langkahIrj',
      'getIDibs',
      'getIDirj',
      'kasursDashboard',
      'kasurStatusSummary'
    ));
  }

  //PENGGUNA
  public function tambahpengguna(Request $r)
  {
    $this->authorizeRoles([1, 3]);

    $r->validate([
      'nama' => 'required|string|max:255',
      'username' => 'required|string|alpha_dash|max:255',
      'role' => 'required|integer'
    ]);

    // Bidang Keperawatan hanya dapat membuat akun Pengawas Umum.
    $role = Auth::user()->id_role == 3 ? self::PENGAWAS_ROLE : $r->role;

    $sp = \App\Models\User::where('username', $r->username)->where('status', 1)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Username ' . $r->username . ' sudah pernah diinputkan sebelumnya, silahkan input dengan username lain');
    } else {
      $sup = new \App\Models\User;
      $sup->nama = $r->nama;
      $sup->username = $r->username;
      $password = '12345678';
      $sup->password = bcrypt($password);
      $sup->id_role = $role;
      $date = date_default_timezone_set('Asia/Jakarta');
      $sup->created_at = date('Y-m-d H:i:s');
      $sup->updated_at =  date('Y-m-d H:i:s');
      $sup->save();

      //log data
      $log = new \App\Models\Log;
      $log->id_user = \Auth::user()->id;
      $log->id_log_jenis = 7;
      $log->keterangan = 'Tambah Pengguna : ' . $r->nama . ' (' . $r->username . ')';
      $log->created_at = date('Y-m-d H:i:s');
      $log->updated_at =  date('Y-m-d H:i:s');
      $log->save();

      return redirect()->back()->with('success-add', 'Berhasil menambah data');
    }
  }

  public function editpengguna(Request $r)
  {
    $this->authorizeRoles([1, 3]);

    $r->validate([
      'id' => 'required|integer',
      'nama' => 'required|string|max:255',
      'username' => 'required|string|alpha_dash|max:255',
      'role' => 'required|integer'
    ]);

    $isBidangKeperawatan = Auth::user()->id_role == 3;
    $role = $isBidangKeperawatan ? self::PENGAWAS_ROLE : $r->role;

    $sp = \App\Models\User::where('username', $r->username)->where('id', '<>', $r->id)->where('status', 1)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Username ' . $r->username . ' sudah pernah diinputkan sebelumnya, silahkan input dengan username lain');
    } else {
      $query = \App\Models\User::where('id', $r->id);
      if ($isBidangKeperawatan) {
        $query->where('id_role', self::PENGAWAS_ROLE);
      }
      $sup = $query->firstOrFail();
      $sup->nama = $r->nama;
      $sup->username = $r->username;
      $sup->id_role = $role;
      $date = date_default_timezone_set('Asia/Jakarta');
      $sup->updated_at =  date('Y-m-d H:i:s');
      $sup->save();

      //log data
      $log = new \App\Models\Log;
      $log->id_user = \Auth::user()->id;
      $log->id_log_jenis = 7;
      $log->keterangan = 'Edit Pengguna : ' . $r->nama . ' (' . $r->username . ')';
      $log->created_at = date('Y-m-d H:i:s');
      $log->updated_at =  date('Y-m-d H:i:s');
      $log->save();

      return redirect()->back()->with('success-add', 'Berhasil mengubah data');
    }
  }

  public function deletepengguna($id)
  {
    $this->authorizeRoles([1, 3]);

    $query = \App\Models\User::where('id', $id);
    if (Auth::user()->id_role == 3) {
      $query->where('id_role', self::PENGAWAS_ROLE);
    }
    $sup = $query->firstOrFail();

    // Simpan identitas sebelum dihapus agar log tetap informatif
    $namaAsli     = $sup->nama;
    $usernameAsli = $sup->username;

    $sup->username = 0;
    $sup->status   = 0;
    $sup->save();

    //log data
    $log = new \App\Models\Log;
    $log->id_user = \Auth::user()->id;
    $log->id_log_jenis = 7;
    $log->keterangan = 'Hapus Pengguna : ' . $namaAsli . ' (' . $usernameAsli . ')';
    $log->created_at = date('Y-m-d H:i:s');
    $log->updated_at =  date('Y-m-d H:i:s');
    $log->save();

    return redirect()->back()->with('success-delete', 'Berhasil menghapus data');
  }


  public function resetpassword($id)
  {

    $this->authorizeRoles([1]);

    $sup = \App\Models\User::findOrFail($id);
    $sup->password = bcrypt('12345678');
    $sup->save();

    //log data
    $log = new \App\Models\Log;
    $log->id_user = \Auth::user()->id;
    $log->id_log_jenis = 7;
    $log->keterangan = 'Reset Password Pengguna : ' . $sup->nama . ' (' . $sup->username . ')';
    $log->created_at = date('Y-m-d H:i:s');
    $log->updated_at =  date('Y-m-d H:i:s');
    $log->save();

    return redirect()->back()->with('success-delete', 'Password berhasil direset ke default');
  }

  //RUANGAN

  public function tambahruangan(Request $r)
  {

    $this->authorizeRoles([1, 3]);

    $r->validate([
      'nama_ruangan' => 'required|string|max:255'
    ]);

    $sp = \App\Models\Ruangan::where('nama_ruangan', $r->nama_ruangan)->where('status', 1)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Nama Ruangan  ' . $r->nama_ruangan . ' sudah pernah diinputkan sebelumnya, silahkan input dengan nama lain');
    } else {
      $sup = new \App\Models\Ruangan;
      $sup->nama_ruangan = $r->nama_ruangan;
      $sup->save();

      //log data
      $log = new \App\Models\Log;
      $log->id_user = \Auth::user()->id;
      $log->id_log_jenis = 8;
      $log->keterangan = 'Tambah Ruangan : ' . $r->nama_ruangan;
      $log->created_at = date('Y-m-d H:i:s');
      $log->updated_at =  date('Y-m-d H:i:s');
      $log->save();


      return redirect()->back()->with('success-add', 'Berhasil menambah data');
    }
  }

  public function editruangan(Request $r)
  {
    $this->authorizeRoles([1, 3]);

    $r->validate([
      'id' => 'required|integer',
      'nama_ruangan' => 'required|string|max:255'
    ]);

    $sp = \App\Models\Ruangan::where('nama_ruangan', $r->nama_ruangan)->where('id', '<>', $r->id)->where('status', 1)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Nama Ruangan  ' . $r->nama_ruangan . ' sudah pernah diinputkan sebelumnya, silahkan input dengan nama lain');
    } else {
      $sup = \App\Models\Ruangan::where('id', $r->id)->first();
      $sup->nama_ruangan = $r->nama_ruangan;
      $sup->save();

      //log data
      $log = new \App\Models\Log;
      $log->id_user = \Auth::user()->id;
      $log->id_log_jenis = 8;
      $log->keterangan = 'Edit Ruangan : ' . $r->nama_ruangan;
      $log->created_at = date('Y-m-d H:i:s');
      $log->updated_at =  date('Y-m-d H:i:s');
      $log->save();


      return redirect()->back()->with('success-add', 'Berhasil mengubah data');
    }
  }

  public function deleteruangan($id)
  {

    $this->authorizeRoles([0, 1, 3]);

    $sup = \App\Models\Ruangan::where('id', $id)->first();
    $sup->status = 0;
    $sup->save();

    //log data
    $log = new \App\Models\Log;
    $log->id_user = \Auth::user()->id;
    $log->id_log_jenis = 8;
    $log->keterangan = 'Hapus Ruangan : ' . $sup->nama_ruangan;
    $log->created_at = date('Y-m-d H:i:s');
    $log->updated_at =  date('Y-m-d H:i:s');
    $log->save();

    return redirect()->back()->with('success-delete', 'Berhasil menghapus data');
  }

  public function statusruangan($id)
  {
    $this->authorizeRoles([1, 3]);

    $ruangan = \App\Models\Ruangan::findOrFail($id);
    $ruangan->status = !$ruangan->status;
    $ruangan->save();

    if (!$ruangan->status) {
      $ruangan->kamar()->update(['status' => false]);
      foreach ($ruangan->kamar as $kamar) {
        $kamar->kasur()->update(['status' => false]);
      }
    }

    return redirect()->back()->with('success-add', 'Status unit berhasil diubah');
  }

  public function bulkStatusRuangan(Request $request)
  {
    $this->authorizeRoles([1, 3]);
    $status = $request->boolean('status');

    Ruangan::query()->update(['status' => $status]);
    if (!$status) {
      Kamar::query()->update(['status' => false]);
      Kasur::query()->update(['status' => false]);
    }

    return back()->with('success-add', 'Status seluruh unit berhasil diubah');
  }


  //DOKTER IGD

  public function tambahdokterigd(Request $r)
  {

    $this->authorizeRoles([1, 3]);

    $r->validate([
      'nama_dokter' => 'required|string|max:255'
    ]);

    $sp = \App\Models\Dokter::where('nama_dokter', $r->nama_dokter)->where('status', 1)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Nama Dokter  ' . $r->nama_dokter . ' sudah pernah diinputkan sebelumnya, silahkan input dengan nama lain');
    } else {
      $sup = new \App\Models\Dokter;
      $sup->nama_dokter = $r->nama_dokter;
      // Data yang dikelola dari halaman ini selalu Dokter Jaga IGD.
      $sup->id_sdmk_jenis = self::DOKTER_JAGA_JENIS;
      $sup->save();

      //log data
      $log = new \App\Models\Log;
      $log->id_user = \Auth::user()->id;
      $log->id_log_jenis = 9;
      $log->keterangan = 'Tambah Dokter Jaga (IGD) : ' . $r->nama_dokter;
      $log->created_at = date('Y-m-d H:i:s');
      $log->updated_at =  date('Y-m-d H:i:s');
      $log->save();


      return redirect()->back()->with('success-add', 'Berhasil menambah data');
    }
  }

  public function editdokterigd(Request $r)
  {
    $this->authorizeRoles([1, 3]);

    $r->validate([
      'id' => 'required|integer',
      'nama_dokter' => 'required|string|max:255'
    ]);

    $sp = \App\Models\Dokter::where('nama_dokter', $r->nama_dokter)->where('id', '<>', $r->id)->where('status', 1)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Nama Dokter  ' . $r->nama_dokter . ' sudah pernah diinputkan sebelumnya, silahkan input dengan nama lain');
    } else {
      $sup = \App\Models\Dokter::where('id', $r->id)
        ->where('id_sdmk_jenis', self::DOKTER_JAGA_JENIS)
        ->firstOrFail();
      $sup->nama_dokter = $r->nama_dokter;
      $sup->id_sdmk_jenis = self::DOKTER_JAGA_JENIS;
      $sup->save();

      //log data
      $log = new \App\Models\Log;
      $log->id_user = \Auth::user()->id;
      $log->id_log_jenis = 9;
      $log->keterangan = 'Edit Dokter Jaga (IGD) : ' . $r->nama_dokter;
      $log->created_at = date('Y-m-d H:i:s');
      $log->updated_at =  date('Y-m-d H:i:s');
      $log->save();

      return redirect()->back()->with('success-add', 'Berhasil mengubah data');
    }
  }

  public function deletedokterigd($id)
  {

    $this->authorizeRoles([1, 3]);

    $sup = \App\Models\Dokter::where('id', $id)
      ->where('id_sdmk_jenis', self::DOKTER_JAGA_JENIS)
      ->firstOrFail();
    $sup->status = 0;
    $sup->save();

    //log data
    $log = new \App\Models\Log;
    $log->id_user = \Auth::user()->id;
    $log->id_log_jenis = 9;
    $log->keterangan = 'Hapus Dokter Jaga (IGD) : ' . $sup->nama_dokter;
    $log->created_at = date('Y-m-d H:i:s');
    $log->updated_at =  date('Y-m-d H:i:s');
    $log->save();

    return redirect()->back()->with('success-delete', 'Berhasil menghapus data');
  }

  //DOKTER GLOBAL

  public function tambahdokter(Request $r)
  {
    $this->authorizeRoles([1, 3]);

    $r->validate([
      'nama_dokter' => 'required|string|max:255',
      'id_sdmk_jenis' => 'required|integer|exists:sdmk_jenis,id'
    ]);

    $sp = \App\Models\Dokter::where('nama_dokter', $r->nama_dokter)->where('status', 1)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Nama Dokter  ' . $r->nama_dokter . ' sudah pernah diinputkan sebelumnya, silahkan input dengan nama lain');
    } else {
      $sup = new \App\Models\Dokter;
      $sup->nama_dokter = $r->nama_dokter;
      $sup->id_sdmk_jenis = $r->id_sdmk_jenis;
      $sup->save();

      //log data
      $log = new \App\Models\Log;
      $log->id_user = \Auth::user()->id;
      $log->id_log_jenis = 9;
      $log->keterangan = 'Tambah Dokter Global : ' . $r->nama_dokter;
      $log->created_at = date('Y-m-d H:i:s');
      $log->updated_at =  date('Y-m-d H:i:s');
      $log->save();

      return redirect()->back()->with('success-add', 'Berhasil menambah data');
    }
  }

  public function editdokter(Request $r)
  {
    $this->authorizeRoles([1, 3]);

    $r->validate([
      'id' => 'required|integer',
      'nama_dokter' => 'required|string|max:255',
      'id_sdmk_jenis' => 'required|integer|exists:sdmk_jenis,id'
    ]);

    $sp = \App\Models\Dokter::where('nama_dokter', $r->nama_dokter)->where('id', '<>', $r->id)->where('status', 1)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Nama Dokter  ' . $r->nama_dokter . ' sudah pernah diinputkan sebelumnya, silahkan input dengan nama lain');
    } else {
      $sup = \App\Models\Dokter::where('id', $r->id)->firstOrFail();
      $sup->nama_dokter = $r->nama_dokter;
      $sup->id_sdmk_jenis = $r->id_sdmk_jenis;
      $sup->save();

      //log data
      $log = new \App\Models\Log;
      $log->id_user = \Auth::user()->id;
      $log->id_log_jenis = 9;
      $log->keterangan = 'Edit Dokter Global : ' . $r->nama_dokter;
      $log->created_at = date('Y-m-d H:i:s');
      $log->updated_at =  date('Y-m-d H:i:s');
      $log->save();

      return redirect()->back()->with('success-add', 'Berhasil mengubah data');
    }
  }

  public function deletedokter($id)
  {
    $this->authorizeRoles([1, 3]);

    $sup = \App\Models\Dokter::where('id', $id)->firstOrFail();
    $sup->status = 0;
    $sup->save();

    //log data
    $log = new \App\Models\Log;
    $log->id_user = \Auth::user()->id;
    $log->id_log_jenis = 9;
    $log->keterangan = 'Hapus Dokter Global : ' . $sup->nama_dokter;
    $log->created_at = date('Y-m-d H:i:s');
    $log->updated_at =  date('Y-m-d H:i:s');
    $log->save();

    return redirect()->back()->with('success-delete', 'Berhasil menghapus data');
  }

  //DOKTER IRJ

  public function tambahdokterirj(Request $r)
  {

    $this->authorizeRoles([1, 3]);

    $r->validate([
      'nama_dokter' => 'required|string|max:255',
      'id_sdmk_jenis' => 'required|integer|not_in:1|exists:sdmk_jenis,id'
    ]);

    $sp = \App\Models\Dokterirj::where('nama', $r->nama_dokter)->where('status', 1)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Nama Dokter  ' . $r->nama_dokter . ' sudah pernah diinputkan sebelumnya, silahkan input dengan nama lain');
    } else {
      $sup = new \App\Models\Dokterirj;
      $sup->nama = $r->nama_dokter;
      $sup->id_sdmk_jenis = $r->id_sdmk_jenis;
      $sup->save();

      //log data
      $log = new \App\Models\Log;
      $log->id_user = \Auth::user()->id;
      $log->id_log_jenis = 10;
      $log->keterangan = 'Tambah Dokter IRJ : ' . $r->nama_dokter;
      $log->created_at = date('Y-m-d H:i:s');
      $log->updated_at =  date('Y-m-d H:i:s');
      $log->save();

      return redirect()->back()->with('success-add', 'Berhasil menambah data');
    }
  }

  public function editdokterirj(Request $r)
  {
    $this->authorizeRoles([1, 3]);

    $r->validate([
      'id' => 'required|integer',
      'nama_dokter' => 'required|string|max:255',
      'id_sdmk_jenis' => 'required|integer|not_in:1|exists:sdmk_jenis,id'
    ]);

    $sp = \App\Models\Dokterirj::where('nama', $r->nama_dokter)->where('id', '<>', $r->id)->where('status', 1)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Nama Dokter  ' . $r->nama_dokter . ' sudah pernah diinputkan sebelumnya, silahkan input dengan nama lain');
    } else {
      $sup = \App\Models\Dokterirj::where('id', $r->id)
        ->where('id_sdmk_jenis', '<>', self::DOKTER_JAGA_JENIS)
        ->firstOrFail();
      $sup->nama = $r->nama_dokter;
      $sup->id_sdmk_jenis = $r->id_sdmk_jenis;
      $sup->save();

      //log data
      $log = new \App\Models\Log;
      $log->id_user = \Auth::user()->id;
      $log->id_log_jenis = 10;
      $log->keterangan = 'Edit Dokter IRJ : ' . $r->nama_dokter;
      $log->created_at = date('Y-m-d H:i:s');
      $log->updated_at =  date('Y-m-d H:i:s');
      $log->save();

      return redirect()->back()->with('success-add', 'Berhasil mengubah data');
    }
  }

  public function deletedokterirj($id)
  {

    $this->authorizeRoles([1, 3]);

    $sup = \App\Models\Dokterirj::where('id', $id)
      ->where('id_sdmk_jenis', '<>', self::DOKTER_JAGA_JENIS)
      ->firstOrFail();
    $sup->status = 0;
    $sup->save();

    //log data
    $log = new \App\Models\Log;
    $log->id_user = \Auth::user()->id;
    $log->id_log_jenis = 10;
    $log->keterangan = 'Hapus Dokter IRJ : ' . $sup->nama;
    $log->created_at = date('Y-m-d H:i:s');
    $log->updated_at =  date('Y-m-d H:i:s');
    $log->save();

    return redirect()->back()->with('success-delete', 'Berhasil menghapus data');
  }


  //Jenis SDMK

  public function tambahjenissdmk(Request $r)
  {

    $this->authorizeRoles([1, 3]);

    $r->validate([
      'id_subrumpun' => 'required|integer',
      'jenis' => 'required|string|max:255'
    ]);

    $sp = \App\Models\sdmk_jenis::where('jenis', $r->jenis)->where('status', 1)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Nama Jenis  ' . $r->jenis . ' sudah pernah diinputkan sebelumnya, silahkan input dengan nama lain');
    } else {
      $sup = new \App\Models\sdmk_jenis();
      $sup->id_subrumpun = $r->id_subrumpun;
      $sup->jenis = $r->jenis;
      $sup->save();

      //log data
      $log = new \App\Models\Log;
      $log->id_user = \Auth::user()->id;
      $log->id_log_jenis = 11;
      $log->keterangan = 'Tambah Jenis SDMK : ' . $r->jenis;
      $log->created_at = date('Y-m-d H:i:s');
      $log->updated_at =  date('Y-m-d H:i:s');
      $log->save();

      return redirect()->back()->with('success-add', 'Berhasil menambah data');
    }
  }

  public function editjenissdmk(Request $r)
  {
    $this->authorizeRoles([1, 3]);

    $r->validate([
      'id' => 'required|integer',
      'id_subrumpun' => 'required|integer',
      'jenis' => 'required|string|max:255'
    ]);

    $sp = \App\Models\sdmk_jenis::where('jenis', $r->jenis)->where('id', '<>', $r->id)->where('status', 1)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Nama Jenis  ' . $r->jenis . ' sudah pernah diinputkan sebelumnya, silahkan input dengan nama lain');
    } else {
      $sup = \App\Models\sdmk_jenis::where('id', $r->id)->first();
      $sup->id_subrumpun = $r->id_subrumpun;
      $sup->jenis = $r->jenis;
      $sup->save();

      //log data
      $log = new \App\Models\Log;
      $log->id_user = \Auth::user()->id;
      $log->id_log_jenis = 11;
      $log->keterangan = 'Edit Jenis SDMK : ' . $r->jenis;
      $log->created_at = date('Y-m-d H:i:s');
      $log->updated_at =  date('Y-m-d H:i:s');
      $log->save();

      return redirect()->back()->with('success-add', 'Berhasil mengubah data');
    }
  }

  public function deletejenissdmk($id)
  {

    $this->authorizeRoles([1, 3]);

    $sup = \App\Models\sdmk_jenis::where('id', $id)->first();
    $sup->status = 0;
    $sup->save();

    //log data
    $log = new \App\Models\Log;
    $log->id_user = \Auth::user()->id;
    $log->id_log_jenis = 11;
    $log->keterangan = 'Hapus Jenis SDMK : ' . $sup->jenis;
    $log->created_at = date('Y-m-d H:i:s');
    $log->updated_at =  date('Y-m-d H:i:s');
    $log->save();

    return redirect()->back()->with('success-delete', 'Berhasil menghapus data');
  }

  //Subrumpun SDMK

  public function tambahsubrumpunsdmk(Request $r)
  {

    $this->authorizeRoles([1, 3]);

    $r->validate([
      'subrumpun' => 'required|string|max:255'
    ]);

    $sp = \App\Models\sdmk_subrumpun::where('subrumpun', $r->subrumpun)->where('status', 1)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Nama Subrumpun  ' . $r->subrumpun . ' sudah pernah diinputkan sebelumnya, silahkan input dengan nama lain');
    } else {
      $sup = new \App\Models\sdmk_subrumpun();
      $sup->subrumpun = $r->subrumpun;
      $sup->save();

      //log data
      $log = new \App\Models\Log;
      $log->id_user = \Auth::user()->id;
      $log->id_log_jenis = 12;
      $log->keterangan = 'Tambah Subrumpun SDMK : ' . $r->subrumpun;
      $log->created_at = date('Y-m-d H:i:s');
      $log->updated_at =  date('Y-m-d H:i:s');
      $log->save();

      return redirect()->back()->with('success-add', 'Berhasil menambah data');
    }
  }

  public function editsubrumpunsdmk(Request $r)
  {
    $this->authorizeRoles([1, 3]);

    $r->validate([
      'id' => 'required|integer',
      'subrumpun' => 'required|string|max:255'
    ]);

    $sp = \App\Models\sdmk_subrumpun::where('subrumpun', $r->subrumpun)->where('id', '<>', $r->id)->where('status', 1)->first();

    if ($sp) {
      return redirect()->back()->with('fail-delete', 'Nama Subrumpun  ' . $r->subrumpun . ' sudah pernah diinputkan sebelumnya, silahkan input dengan nama lain');
    } else {
      $sup = \App\Models\sdmk_subrumpun::where('id', $r->id)->first();
      $sup->subrumpun = $r->subrumpun;
      $sup->save();

      //log data
      $log = new \App\Models\Log;
      $log->id_user = \Auth::user()->id;
      $log->id_log_jenis = 12;
      $log->keterangan = 'Edit Subrumpun SDMK : ' . $r->subrumpun;
      $log->created_at = date('Y-m-d H:i:s');
      $log->updated_at =  date('Y-m-d H:i:s');
      $log->save();

      return redirect()->back()->with('success-add', 'Berhasil mengubah data');
    }
  }

  public function deletesubrumpunsdmk($id)
  {

    $this->authorizeRoles([1, 3]);

    $sup = \App\Models\sdmk_subrumpun::where('id', $id)->first();
    $sup->status = 0;
    $sup->save();

    //log data
    $log = new \App\Models\Log;
    $log->id_user = \Auth::user()->id;
    $log->id_log_jenis = 12;
    $log->keterangan = 'Hapus Subrumpun SDMK : ' . $sup->subrumpun;
    $log->created_at = date('Y-m-d H:i:s');
    $log->updated_at =  date('Y-m-d H:i:s');
    $log->save();

    return redirect()->back()->with('success-delete', 'Berhasil menghapus data');
  }


  //LAPORAN

  public function verifikasilaporan(Request $r)
  {
    if (!Auth::check() || !in_array((int) Auth::user()->id_role, [1, 3], true)) {
      abort(403);
    }

    $r->validate([
      'verifikasi' => 'required|array',
      'verifikasi.*' => 'integer|distinct'
    ]);

    $ids = $r->input('verifikasi');
    $role = (int) Auth::user()->id_role;
    $laporanQuery = \App\Models\Laporan::whereIn('id', $ids)->where('status', 1);

    if ($role === 3) {
      $updated = $laporanQuery
        ->where('verified_bidang', 0)
        ->where('verified', 0)
        ->update(['verified_bidang' => 1, 'updated_at' => now('Asia/Jakarta')]);
      $tahap = 'Keperawatan';
    } else {
      $updated = $laporanQuery
        ->where('verified_bidang', 1)
        ->where('verified', 0)
        ->update(['verified' => 1, 'updated_at' => now('Asia/Jakarta')]);
      $tahap = 'Direktur';
    }

    if ($updated === 0) {
      return response()->json([
        'success' => false,
        'message' => 'Laporan tidak tersedia untuk tahap verifikasi Anda atau telah diproses.'
      ], 422);
    }

    //log data
    $log = new \App\Models\Log;
    $log->id_user = \Auth::user()->id;
    $log->id_log_jenis = 13;
    $log->keterangan = 'Verifikasi ' . $tahap . ' laporan id : ' . implode(', ', array_values($ids));
    $log->created_at = date('Y-m-d H:i:s');
    $log->updated_at =  date('Y-m-d H:i:s');
    $log->save();

    return response()->json(
      [
        'success' => true,
        'message' => 'Berhasil verifikasi ' . $tahap . ' untuk ' . $updated . ' laporan.'
      ]
    );
    //return redirect()->back()->with('success-add', 'Berhasil verifikasi laporan');

    }

  public function administrasiLaporan(Request $request)
  {
    $this->authorizeRoles([0]);

    $laporanQuery = \App\Models\Laporan::with(['dinas', 'pengawas'])->where('status', 1);

    if ($request->filled('tanggal_mulai')) {
      $laporanQuery->whereDate('created_at', '>=', $request->date('tanggal_mulai'));
    }

    if ($request->filled('tanggal_selesai')) {
      $laporanQuery->whereDate('created_at', '<=', $request->date('tanggal_selesai'));
    }

    if ($request->filled('status_verifikasi')) {
      if ($request->status_verifikasi === 'belum_bidang') {
        $laporanQuery->where('verified_bidang', 0)->where('verified', 0);
      } elseif ($request->status_verifikasi === 'belum_direktur') {
        $laporanQuery->where('verified_bidang', 1)->where('verified', 0);
      } elseif ($request->status_verifikasi === 'selesai') {
        $laporanQuery->where('verified', 1);
      }
    }

    $laporans = $laporanQuery->latest('created_at')->paginate(20)->withQueryString();

    return view('admin.laporan.administrasi', compact('laporans'));
  }

  public function kembalikanLaporan(Request $request, int $id)
  {
    $this->authorizeRoles([0]);

    $validated = $request->validate([
      'alasan' => ['required', 'string', 'min:10', 'max:1000'],
    ]);

    $laporan = \App\Models\Laporan::where('status', 1)->findOrFail($id);

    DB::transaction(function () use ($laporan, $validated) {
      $laporanId = $laporan->id;

      \App\Models\Laporanigd::where('id_laporan', $laporanId)
        ->update(['id_laporan' => null, 'status' => 0, 'updated_at' => now('Asia/Jakarta')]);

      $laporanUmumIds = \App\Models\Laporanumum::where('id_laporan', $laporanId)->pluck('id');
      \App\Models\Catatanpasien::whereIn('id_laporan_umum', $laporanUmumIds)
        ->update(['id_laporan_umum' => null, 'status' => 0, 'updated_at' => now('Asia/Jakarta')]);
      \App\Models\Laporanumum::whereIn('id', $laporanUmumIds)
        ->update([
          'id_laporan' => null,
          'status' => \App\Models\Laporanumum::STATUS_DRAFT,
          'updated_at' => now('Asia/Jakarta'),
        ]);

      $laporanIrjIds = \App\Models\Laporanirj::where('id_laporan', $laporanId)->pluck('id');
      \App\Models\Laporanirjdetail::whereIn('id_laporan_irj', $laporanIrjIds)
        ->update(['id_laporan_irj' => null, 'status' => 0, 'updated_at' => now('Asia/Jakarta')]);
      \App\Models\Laporanirj::whereIn('id', $laporanIrjIds)
        ->update(['id_laporan' => null, 'status' => 0, 'updated_at' => now('Asia/Jakarta')]);

      $laporanIbsIds = \App\Models\Laporanibs::where('id_laporan', $laporanId)->pluck('id');
      \App\Models\Laporanibsdetail::whereIn('id_laporan_ibs', $laporanIbsIds)
        ->update(['id_laporan_ibs' => null, 'status' => 0, 'updated_at' => now('Asia/Jakarta')]);
      \App\Models\Laporanibs::whereIn('id', $laporanIbsIds)
        ->update(['id_laporan' => null, 'status' => 0, 'updated_at' => now('Asia/Jakarta')]);

      $laporan->update([
        'status' => 0,
        'verified_bidang' => 0,
        'verified' => 0,
        'updated_at' => now('Asia/Jakarta'),
      ]);

      $log = new \App\Models\Log;
      $log->id_user = Auth::id();
      $log->id_log_jenis = 14;
      $log->keterangan = 'Mengembalikan laporan id ' . $laporanId . ' kepada pengawas. Alasan: ' . $validated['alasan'];
      $log->created_at = now('Asia/Jakarta');
      $log->updated_at = now('Asia/Jakarta');
      $log->save();
    });

    return redirect()->route('administrasi-laporan')->with('success-change', 'Laporan berhasil dikembalikan untuk diperbaiki.');
  }

    /**
     * Simpan konfigurasi akses menu untuk user tertentu.
     * Hanya bisa diakses oleh super_admin (id_role = 0).
     */
    public function updateAksesMenu(Request $request, $id)
    {
        $this->authorizeRoles([0]);

        $user = \App\Models\User::findOrFail($id);

        // Ambil array menu yang dicentang, default ke array kosong jika tidak ada
        $menus = $request->input('menus', []);

        $user->akses_menu = empty($menus) ? null : array_values($menus);
        $user->save();

        // Catat di log
        $log = new \App\Models\Log;
        $log->id_user     = \Auth::user()->id;
        $log->id_log_jenis = 1; // Gunakan jenis log yang tersedia
        $log->keterangan  = 'Update akses menu untuk user: ' . $user->nama . ' (' . $user->username . ')';
        $log->created_at  = date('Y-m-d H:i:s');
        $log->updated_at  = date('Y-m-d H:i:s');
        $log->save();

        return redirect()->route('data-pengguna')
            ->with('success-edit', 'Akses menu untuk ' . $user->nama . ' berhasil diperbarui.');
    }
}
