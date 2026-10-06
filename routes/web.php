<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PengawasController;
use App\Http\Controllers\DirekturController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\VerifikasiLaporanController;
use App\Models\Laporanumum;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ─── VERIFIKASI QR CODE (Publik, tanpa login) ───────────────────────────────
Route::get('/verifikasi/{token}', [VerifikasiLaporanController::class, 'show'])
    ->name('verifikasi.laporan')
    ->where('token', '[a-f0-9]{64}');

Route::get('/', fn() => view('admin.auth.login'))->name('login');

Route::get('/ganti-password', fn() => view('admin.auth.ganti-password', [
    'activeUser' => Auth::user(),
]))->name('ganti-password');
Route::match(['get', 'put'], '/gantipassword2', [UserController::class, 'gantipassword2'])->name('gantipassword2');

//---------------auth--------------//
Route::post('/dologin', [LoginController::class, 'dologin'])->name('dologin');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');


//ALL USERS
Route::group(['middleware' => ['auth']], function () {
    Route::put('/gantipassword', [UserController::class, 'gantipassword'])->name('gantipassword');

    //RIWAYAT LAPORAN
    Route::get('/refresh-detail-laporan-igd/{idlaporan}', fn($idlaporan) => view('admin.ajax.refresh-detail-laporan-igd', compact('idlaporan')));
    Route::get('/refresh-detail-laporan-umum/{idlaporan}', fn($idlaporan) => view('admin.ajax.refresh-detail-laporan-umum', compact('idlaporan')));
    Route::get('/refresh-detail-laporan-irj/{idlaporan}', fn($idlaporan) => view('admin.ajax.refresh-detail-laporan-irj', compact('idlaporan')));
    Route::get('/refresh-detail-laporan-ibs/{idlaporan}', fn($idlaporan) => view('admin.ajax.refresh-detail-laporan-ibs', compact('idlaporan')));

    //REFRESH HISTORY
    Route::get('/refresh-history/{tanggal}/{tanggal2}', fn($tanggal, $tanggal2) => view('admin.ajax.refresh-history', compact('tanggal', 'tanggal2')));

    Route::get('/dashboard', [DirekturController::class, 'dashboard'])->name('dashboard');

    Route::get('/data-kasur', [FasilitasController::class, 'kasur'])->name('data-kasur');

    // Riwayat Ruangan
    Route::get('/refresh-istimewa/{idlaporanumum}/{idruangan}', fn($idlaporanumum, $idruangan) => view('admin.ajax.ruangan.refresh-istimewa', compact('idlaporanumum', 'idruangan')));
    Route::get('/refresh-baru/{idlaporanumum}/{idruangan}', fn($idlaporanumum, $idruangan) => view('admin.ajax.ruangan.refresh-baru', compact('idlaporanumum', 'idruangan')));
    Route::get('/refresh-permasalahan/{idlaporanumum}/{idruangan}', fn($idlaporanumum, $idruangan) => view('admin.ajax.ruangan.refresh-permasalahan', compact('idlaporanumum', 'idruangan')));
});

//PENGAWAS
Route::group(['middleware' => ['auth', 'pengawas']], function () {

    //member
    Route::get('/laporan', [PengawasController::class, 'laporan'])->name('laporan');
    Route::get('/draf-laporan', [PengawasController::class, 'drafLaporan'])->name('draf-laporan');
    Route::get('/refresh-laporan-ruangan/{ruangan}', function ($ruangan) {
        $pasienLama = Laporanumum::saldoPasienLama((int) $ruangan);
        $ruangans   = \App\Models\Ruangan::where('status', 1)->get();

        return view('pengawas.ajax.refresh-laporan-ruangan', compact('ruangan', 'pasienLama', 'ruangans'));
    });
    Route::get('/refresh-laporan-ruangan-draf/{ruangan}', function ($ruangan) {
        $pasienLama = Laporanumum::saldoPasienLama((int) $ruangan);
        $ruangans   = \App\Models\Ruangan::where('status', 1)->get();

        return view('pengawas.ajax.refresh-laporan-umum', compact('ruangan', 'pasienLama', 'ruangans'));
    })->name('draf-laporan.ruangan');
    Route::get('/refresh-catatan-pasien-istimewa/{ruangan2}', fn($ruangan2) => view('pengawas.ajax.refresh-catatan-pasien-istimewa', compact('ruangan2')));
    Route::get('/refresh-catatan-pasien-baru/{ruangan2}', fn($ruangan2) => view('pengawas.ajax.refresh-catatan-pasien-baru', compact('ruangan2')));

    Route::get('/riwayat-laporan-belum-verifikasi', fn() => view('pengawas.riwayat-belum'))->name('riwayat-laporan-belum');
    Route::get('/riwayat-laporan-sudah-verifikasi', fn() => view('pengawas.riwayat-sudah'))->name('riwayat-laporan-sudah');

    // Livewire handles the ruangan summary/form rendering; these AJAX endpoints are no longer used.

    //laporan
    Route::post('/draftlaporanIGD', [PengawasController::class, 'draftlaporanIGD'])->name('draftlaporanIGD');
    Route::put('/editDraftlaporanIGD', [PengawasController::class, 'editDraftlaporanIGD'])->name('editDraftlaporanIGD');
    Route::delete('/deleteDraftlaporanIGD/{id}', [PengawasController::class, 'deleteDraftlaporanIGD'])->name('deleteDraftlaporanIGD');

    Route::post('/draftlaporanIRJ', [PengawasController::class, 'draftlaporanIRJ'])->name('draftlaporanIRJ');
    Route::put('/editDraftlaporanIRJ', [PengawasController::class, 'editDraftlaporanIRJ'])->name('editDraftlaporanIRJ');
    Route::delete('/deleteDraftlaporanIRJ/{id}', [PengawasController::class, 'deleteDraftlaporanIRJ'])->name('deleteDraftlaporanIRJ');

    Route::post('/draftlaporanIBS', [PengawasController::class, 'draftlaporanIBS'])->name('draftlaporanIBS');
    Route::put('/editDraftlaporanIBS', [PengawasController::class, 'editDraftlaporanIBS'])->name('editDraftlaporanIBS');
    Route::delete('/deleteDraftlaporanIBS/{id}', [PengawasController::class, 'deleteDraftlaporanIBS'])->name('deleteDraftlaporanIBS');

    Route::post('/draftlaporanUmum', [PengawasController::class, 'draftlaporanUmum'])->name('draftlaporanUmum');
    Route::put('/editDraftlaporanUmum', [PengawasController::class, 'editDraftlaporanUmum'])->name('editDraftlaporanUmum');
    Route::delete('/deleteDraftlaporanUmum/{id}', [PengawasController::class, 'deleteDraftlaporanUmum'])->name('deleteDraftlaporanUmum');

    Route::post('/kirimLaporan', [PengawasController::class, 'kirimLaporan'])->name('kirimLaporan');

    Route::post('tambahirjdetail', [PengawasController::class, 'tambahirjdetail'])->name('tambahirjdetail');
    Route::put('editirjdetail', [PengawasController::class, 'editirjdetail'])->name('editirjdetail');
    Route::delete('deleteirjdetail', [PengawasController::class, 'deleteirjdetail'])->name('deleteirjdetail');

    Route::post('tambahibsdetail', [PengawasController::class, 'tambahibsdetail'])->name('tambahibsdetail');
    Route::put('editibsdetail', [PengawasController::class, 'editibsdetail'])->name('editibsdetail');
    Route::delete('deleteibsdetail', [PengawasController::class, 'deleteibsdetail'])->name('deleteibsdetail');

    Route::post('tambahcatatanpasien', [PengawasController::class, 'tambahcatatanpasien'])->name('tambahcatatanpasien');
    Route::put('editcatatanpasien', [PengawasController::class, 'editcatatanpasien'])->name('editcatatanpasien');
    Route::delete('deletecatatanpasien', [PengawasController::class, 'deletecatatanpasien'])->name('deletecatatanpasien');
    Route::patch('/keterangan-kasur/{kasur}', [FasilitasController::class, 'updateKeteranganKasur'])->name('keterangan-kasur');
    Route::patch('/operasionalkasur/{kasur}', [FasilitasController::class, 'updateStatusKasur'])->name('operasionalkasur');
});

//DIREKTUR dan BIDANG KEPERAWATAN
Route::group(['middleware' => ['auth', 'direktur']], function () {
    //Riwayat Laporan
    Route::get('/riwayat-laporan-pu-belum-verifikasi', fn() => view('admin.konten.riwayat-belum'))->name('riwayat-laporan-pu-belum');
    Route::get('/riwayat-laporan-pu-sudah-verifikasi', fn() => view('admin.konten.riwayat-sudah'))->name('riwayat-laporan-pu-sudah');
    Route::put('verifikasilaporan', [DirekturController::class, 'verifikasilaporan'])->name('verifikasilaporan');

    //Grafik Laporan
    Route::get('/grafik-laporan', fn() => view('admin.laporan.grafik'))->name('grafik-laporan');
    Route::get('/refresh-grafik/{tahun}/{bulan}', fn($tahun, $bulan) => view('admin.ajax.refresh-grafik', compact('tahun', 'bulan')));

    //Jadwal Dinas
    Route::get('/jadwal-dinas', fn() => view('admin.konten.jadwal'))->name('jadwal-dinas');

    //Data Pengawas Umum
    Route::get('/data-pengawas-umum', fn() => view('admin.konten.pengawas'))->name('data-pengawas-umum');

    //Ruangan
    Route::get('/data-ruangan', fn() => view('admin.konten.ruangan'))->name('data-ruangan');
    Route::post('/tambahruangan', [DirekturController::class, 'tambahruangan'])->name('tambahruangan');
    Route::put('/editruangan', [DirekturController::class, 'editruangan'])->name('editruangan');
    Route::delete('/deleteruangan/{id}', [DirekturController::class, 'deleteruangan'])->name('deleteruangan');
    Route::patch('/statusruangan/{id}', [DirekturController::class, 'statusruangan'])->name('statusruangan');
    Route::patch('/statusruangan-semua', [DirekturController::class, 'bulkStatusRuangan'])->name('statusruangan.semua');
    Route::get('/data-kamar', [FasilitasController::class, 'kamar'])->name('data-kamar');
    Route::post('/tambahkamar', [FasilitasController::class, 'tambahKamar'])->name('tambahkamar');
    Route::put('/editkamar', [FasilitasController::class, 'editKamar'])->name('editkamar');
    Route::patch('/statuskamar/{kamar}', [FasilitasController::class, 'toggleKamar'])->name('statuskamar');
    Route::patch('/statuskamar-semua', [FasilitasController::class, 'bulkStatusKamar'])->name('statuskamar.semua');
    Route::delete('/deletekamar/{kamar}', [FasilitasController::class, 'deleteKamar'])->name('deletekamar');
    Route::post('/tambahkasur', [FasilitasController::class, 'tambahKasur'])->name('tambahkasur');
    Route::put('/editkasur', [FasilitasController::class, 'editKasur'])->name('editkasur');
    Route::patch('/statuskasur/{kasur}', [FasilitasController::class, 'toggleKasur'])->name('statuskasur');
    Route::patch('/statuskasur-semua', [FasilitasController::class, 'bulkStatusKasur'])->name('statuskasur.semua');
    Route::delete('/deletekasur/{kasur}', [FasilitasController::class, 'deleteKasur'])->name('deletekasur');

    //Dokter Jaga (IGD)
    Route::get('/data-dokter-jaga', fn() => view('admin.konten.dokter-igd'))->name('data-dokter-igd');
    Route::post('/tambahdokterigd', [DirekturController::class, 'tambahdokterigd'])->name('tambahdokterigd');
    Route::put('/editdokterigd', [DirekturController::class, 'editdokterigd'])->name('editdokterigd');
    Route::delete('/deletedokterigd/{id}', [DirekturController::class, 'deletedokterigd'])->name('deletedokterigd');

    //Data Dokter (Global)
    Route::get('/data-dokter', fn() => view('admin.konten.dokter-global'))->name('data-dokter-global');
    Route::post('/tambahdokter', [DirekturController::class, 'tambahdokter'])->name('tambahdokter');
    Route::put('/editdokter', [DirekturController::class, 'editdokter'])->name('editdokter');
    Route::delete('/deletedokter/{id}', [DirekturController::class, 'deletedokter'])->name('deletedokter');

    //Pengguna (hanya super_admin / role 0)
    Route::get('/data-pengguna', function () {
        if (Auth::user()->id_role !== 0) {
            return redirect()->to('/dashboard');
        }
        return view('admin.konten.pengguna');
    })->name('data-pengguna');
    Route::post('/tambahpengguna', [DirekturController::class, 'tambahpengguna'])->name('tambahpengguna');
    Route::put('/editpengguna', [DirekturController::class, 'editpengguna'])->name('editpengguna');
    Route::delete('/deletepengguna/{id}', [DirekturController::class, 'deletepengguna'])->name('deletepengguna');
    Route::post('/resetpassword/{id}', [DirekturController::class, 'resetpassword'])->name('resetpassword');
    Route::post('/update-akses-menu/{id}', [DirekturController::class, 'updateAksesMenu'])->name('update-akses-menu');

    //Laporan
    Route::get('/administrasi-laporan', [DirekturController::class, 'administrasiLaporan'])->name('administrasi-laporan');
    Route::put('/administrasi-laporan/{id}/kembalikan', [DirekturController::class, 'kembalikanLaporan'])->name('administrasi-laporan.kembalikan');
    Route::get('/refresh-laporan-umum-pu/{ruangan}', fn($ruangan) => view('admin.ajax.refresh-laporan-umum', compact('ruangan')));

    //Dokter IRJ
    Route::get('/data-dokter-irj', fn() => view('admin.konten.dokter-irj'))->name('data-dokter-irj');
    Route::post('/tambahdokterirj', [DirekturController::class, 'tambahdokterirj'])->name('tambahdokterirj');
    Route::put('/editdokterirj', [DirekturController::class, 'editdokterirj'])->name('editdokterirj');
    Route::delete('/deletedokterirj/{id}', [DirekturController::class, 'deletedokterirj'])->name('deletedokterirj');

    //SDMK SUBRUMPUN
    Route::get('/data-subrumpun-sdmk', fn() => view('admin.konten.subrumpun-sdmk'))->name('data-subrumpun-sdmk');
    Route::post('/tambahsubrumpunsdmk', [DirekturController::class, 'tambahsubrumpunsdmk'])->name('tambahsubrumpunsdmk');
    Route::put('/editsubrumpunsdmk', [DirekturController::class, 'editsubrumpunsdmk'])->name('editsubrumpunsdmk');
    Route::delete('/deletesubrumpunsdmk/{id}', [DirekturController::class, 'deletesubrumpunsdmk'])->name('deletesubrumpunsdmk');

    //SDMK JENIS
    Route::get('/data-jenis-sdmk', fn() => view('admin.konten.jenis-sdmk'))->name('data-jenis-sdmk');
    Route::post('/tambahjenissdmk', [DirekturController::class, 'tambahjenissdmk'])->name('tambahjenissdmk');
    Route::put('/editjenissdmk', [DirekturController::class, 'editjenissdmk'])->name('editjenissdmk');
    Route::delete('/deletejenissdmk/{id}', [DirekturController::class, 'deletejenissdmk'])->name('deletejenissdmk');

    //Log (super_admin dan direktur: role 0 & 1)
    Route::get('/log', function () {
        if (!in_array(Auth::user()->id_role, [0, 1])) {
            return redirect()->to('/dashboard');
        }
        return view('admin.log.log');
    })->name('log');
    Route::get('/refresh-log/{tanggalmulai}/{tanggalselesai}/{jenis}', fn($tanggalmulai, $tanggalselesai, $jenis) => view('admin.ajax.refresh-log', compact('tanggalmulai', 'tanggalselesai', 'jenis')));
});
