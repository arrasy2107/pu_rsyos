<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PengawasController;
use App\Http\Controllers\DirekturController;

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

Route::get('/', fn() => view('admin.auth.login'))->name('login');

Route::get('/ganti-password', fn() => view('admin.auth.ganti-password'))->name('ganti-password');
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
    Route::get('/refresh-laporan-ruangan/{ruangan}', fn($ruangan) => view('pengawas.ajax.refresh-laporan-ruangan', compact('ruangan')));
    Route::get('/refresh-laporan-ruangan-draf/{ruangan}', fn($ruangan) => view('pengawas.ajax.refresh-laporan-umum', compact('ruangan')));
    Route::get('/refresh-catatan-pasien-istimewa/{ruangan2}', fn($ruangan2) => view('pengawas.ajax.refresh-catatan-pasien-istimewa', compact('ruangan2')));
    Route::get('/refresh-catatan-pasien-baru/{ruangan2}', fn($ruangan2) => view('pengawas.ajax.refresh-catatan-pasien-baru', compact('ruangan2')));

    Route::get('/riwayat-laporan-belum-verifikasi', fn() => view('pengawas.riwayat-belum'))->name('riwayat-laporan-belum');
    Route::get('/riwayat-laporan-sudah-verifikasi', fn() => view('pengawas.riwayat-sudah'))->name('riwayat-laporan-sudah');

    // Livewire handles the ruangan summary/form rendering; these AJAX endpoints are no longer used.

    //laporan
    Route::post('/draftlaporanIGD', [PengawasController::class, 'draftlaporanIGD'])->name('draftlaporanIGD');
    Route::put('/editDraftlaporanIGD', [PengawasController::class, 'editDraftlaporanIGD'])->name('editDraftlaporanIGD');
    Route::get('/deleteDraftlaporanIGD/{id}', [PengawasController::class, 'deleteDraftlaporanIGD'])->name('deleteDraftlaporanIGD');

    Route::post('/draftlaporanIRJ', [PengawasController::class, 'draftlaporanIRJ'])->name('draftlaporanIRJ');
    Route::put('/editDraftlaporanIRJ', [PengawasController::class, 'editDraftlaporanIRJ'])->name('editDraftlaporanIRJ');
    Route::get('/deleteDraftlaporanIRJ/{id}', [PengawasController::class, 'deleteDraftlaporanIRJ'])->name('deleteDraftlaporanIRJ');

    Route::post('/draftlaporanIBS', [PengawasController::class, 'draftlaporanIBS'])->name('draftlaporanIBS');
    Route::put('/editDraftlaporanIBS', [PengawasController::class, 'editDraftlaporanIBS'])->name('editDraftlaporanIBS');
    Route::get('/deleteDraftlaporanIBS/{id}', [PengawasController::class, 'deleteDraftlaporanIBS'])->name('deleteDraftlaporanIBS');

    Route::post('/draftlaporanUmum', [PengawasController::class, 'draftlaporanUmum'])->name('draftlaporanUmum');
    Route::put('/editDraftlaporanUmum', [PengawasController::class, 'editDraftlaporanUmum'])->name('editDraftlaporanUmum');
    Route::get('/deleteDraftlaporanUmum/{id}', [PengawasController::class, 'deleteDraftlaporanUmum'])->name('deleteDraftlaporanUmum');

    Route::post('/kirimLaporan', [PengawasController::class, 'kirimLaporan'])->name('kirimLaporan');

    Route::post('tambahirjdetail', [PengawasController::class, 'tambahirjdetail'])->name('tambahirjdetail');
    Route::put('editirjdetail', [PengawasController::class, 'editirjdetail'])->name('editirjdetail');
    Route::get('deleteirjdetail', [PengawasController::class, 'deleteirjdetail'])->name('deleteirjdetail');

    Route::post('tambahibsdetail', [PengawasController::class, 'tambahibsdetail'])->name('tambahibsdetail');
    Route::put('editibsdetail', [PengawasController::class, 'editibsdetail'])->name('editibsdetail');
    Route::get('deleteibsdetail', [PengawasController::class, 'deleteibsdetail'])->name('deleteibsdetail');

    Route::post('tambahcatatanpasien', [PengawasController::class, 'tambahcatatanpasien'])->name('tambahcatatanpasien');
    Route::put('editcatatanpasien', [PengawasController::class, 'editcatatanpasien'])->name('editcatatanpasien');
    Route::get('deletecatatanpasien', [PengawasController::class, 'deletecatatanpasien'])->name('deletecatatanpasien');
});

//DIREKTUR dan BIDANG KEPERAWATAN
Route::group(['middleware' => ['auth', 'direktur']], function () {
    Route::get('/dashboard', [DirekturController::class, 'dashboard'])->name('dashboard');

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
    Route::get('/deleteruangan/{id}', [DirekturController::class, 'deleteruangan'])->name('deleteruangan');

    //Dokter Jaga (IGD)
    Route::get('/data-dokter-jaga', fn() => view('admin.konten.dokter-igd'))->name('data-dokter-igd');
    Route::post('/tambahdokterigd', [DirekturController::class, 'tambahdokterigd'])->name('tambahdokterigd');
    Route::put('/editdokterigd', [DirekturController::class, 'editdokterigd'])->name('editdokterigd');
    Route::get('/deletedokterigd/{id}', [DirekturController::class, 'deletedokterigd'])->name('deletedokterigd');

    //Data Dokter (Global)
    Route::get('/data-dokter', fn() => view('admin.konten.dokter-global'))->name('data-dokter-global');
    Route::post('/tambahdokter', [DirekturController::class, 'tambahdokter'])->name('tambahdokter');
    Route::put('/editdokter', [DirekturController::class, 'editdokter'])->name('editdokter');
    Route::get('/deletedokter/{id}', [DirekturController::class, 'deletedokter'])->name('deletedokter');

    //Pengguna (hanya role 1)
    Route::get('/data-pengguna', function () {
        if (\Auth::user()->id_role != 1) {
            return redirect()->to('/dashboard');
        }
        return view('admin.konten.pengguna');
    })->name('data-pengguna');
    Route::post('/tambahpengguna', [DirekturController::class, 'tambahpengguna'])->name('tambahpengguna');
    Route::put('/editpengguna', [DirekturController::class, 'editpengguna'])->name('editpengguna');
    Route::get('/deletepengguna/{id}', [DirekturController::class, 'deletepengguna'])->name('deletepengguna');
    Route::get('/resetpassword/{id}', [DirekturController::class, 'resetpassword'])->name('resetpassword');

    //Laporan
    Route::get('/refresh-laporan-umum-pu/{ruangan}', fn($ruangan) => view('admin.ajax.refresh-laporan-umum', compact('ruangan')));

    //Dokter IRJ
    Route::get('/data-dokter-irj', fn() => view('admin.konten.dokter-irj'))->name('data-dokter-irj');
    Route::post('/tambahdokterirj', [DirekturController::class, 'tambahdokterirj'])->name('tambahdokterirj');
    Route::put('/editdokterirj', [DirekturController::class, 'editdokterirj'])->name('editdokterirj');
    Route::get('/deletedokterirj/{id}', [DirekturController::class, 'deletedokterirj'])->name('deletedokterirj');

    //SDMK SUBRUMPUN
    Route::get('/data-subrumpun-sdmk', fn() => view('admin.konten.subrumpun-sdmk'))->name('data-subrumpun-sdmk');
    Route::post('/tambahsubrumpunsdmk', [DirekturController::class, 'tambahsubrumpunsdmk'])->name('tambahsubrumpunsdmk');
    Route::put('/editsubrumpunsdmk', [DirekturController::class, 'editsubrumpunsdmk'])->name('editsubrumpunsdmk');
    Route::get('/deletesubrumpunsdmk/{id}', [DirekturController::class, 'deletesubrumpunsdmk'])->name('deletesubrumpunsdmk');

    //SDMK JENIS
    Route::get('/data-jenis-sdmk', fn() => view('admin.konten.jenis-sdmk'))->name('data-jenis-sdmk');
    Route::post('/tambahjenissdmk', [DirekturController::class, 'tambahjenissdmk'])->name('tambahjenissdmk');
    Route::put('/editjenissdmk', [DirekturController::class, 'editjenissdmk'])->name('editjenissdmk');
    Route::get('/deletejenissdmk/{id}', [DirekturController::class, 'deletejenissdmk'])->name('deletejenissdmk');

    //Log
    Route::get('/log', function () {
        if (\Auth::user()->id_role == 3) {
            return redirect()->to('/dashboard');
        }
        return view('admin.log.log');
    })->name('log');
    Route::get('/refresh-log/{tanggalmulai}/{tanggalselesai}/{jenis}', fn($tanggalmulai, $tanggalselesai, $jenis) => view('admin.ajax.refresh-log', compact('tanggalmulai', 'tanggalselesai', 'jenis')));
});
