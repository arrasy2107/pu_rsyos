<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', function () {
    return view('admin.auth.login');
})->name('login');

Route::get('/ganti-password', function () {
    return view('admin.auth.ganti-password');
})->name('ganti-password');
Route::put('/gantipassword2', 'UserController@gantipassword2')->name('gantipassword2');

//---------------auth--------------//
Route::post('/dologin', 'LoginController@dologin')->name('dologin');
Route::get('logout', 'LoginController@logout')->name('logout');


//ALL USERS
Route::group(['middleware' => ['auth']],  function () {
    Route::put('/gantipassword', 'UserController@gantipassword')->name('gantipassword');

    //RIWAYAT LAPORAN 
    Route::get('/refresh-detail-laporan-igd/{idlaporan}',function($idlaporan){
        return view('admin.ajax.refresh-detail-laporan-igd',compact('idlaporan'));
    });
    Route::get('/refresh-detail-laporan-umum/{idlaporan}',function($idlaporan){
        return view('admin.ajax.refresh-detail-laporan-umum',compact('idlaporan'));
    });
    Route::get('/refresh-detail-laporan-irj/{idlaporan}',function($idlaporan){
        return view('admin.ajax.refresh-detail-laporan-irj',compact('idlaporan'));
    });

    //REFRESH HISTORY
    Route::get('/refresh-history/{tanggal}/{tanggal2}',function($tanggal,$tanggal2){
        return view('admin.ajax.refresh-history',compact('tanggal','tanggal2'));
    });
});

//PENGAWAS
Route::group(['middleware' => ['auth', 'pengawas']],  function () {

    //member
    Route::get('/laporan', function () {
        return view('pengawas.laporan');
    })->name('laporan');
    Route::get('/draf-laporan', function () {
        return view('pengawas.draf-laporan');
    })->name('draf-laporan');

    Route::get('/riwayat-laporan-belum-verifikasi', function () {
        return view('pengawas.riwayat-belum');
    })->name('riwayat-laporan-belum');
    Route::get('/riwayat-laporan-sudah-verifikasi', function () {
        return view('pengawas.riwayat-sudah');
    })->name('riwayat-laporan-sudah');

    Route::get('/refresh-laporan-umum/{ruangan}',function($ruangan){
        return view('pengawas.ajax.refresh-laporan-umum',compact('ruangan'));
    });
    
    //laporan
    Route::post('/draftlaporanIGD', 'PengawasController@draftlaporanIGD')->name('draftlaporanIGD');
    Route::put('/editDraftlaporanIGD', 'PengawasController@editDraftlaporanIGD')->name('editDraftlaporanIGD');
    Route::get('/deleteDraftlaporanIGD/{id}', 'PengawasController@deleteDraftlaporanIGD')->name('deleteDraftlaporanIGD');

    Route::post('/draftlaporanIRJ', 'PengawasController@draftlaporanIRJ')->name('draftlaporanIRJ');
    Route::put('/editDraftlaporanIRJ', 'PengawasController@editDraftlaporanIRJ')->name('editDraftlaporanIRJ');
    Route::get('/deleteDraftlaporanIRJ/{id}', 'PengawasController@deleteDraftlaporanIRJ')->name('deleteDraftlaporanIRJ');

    Route::post('/draftlaporanUmum', 'PengawasController@draftlaporanUmum')->name('draftlaporanUmum');
    Route::put('/editDraftlaporanUmum', 'PengawasController@editDraftlaporanUmum')->name('editDraftlaporanUmum');
    Route::get('/deleteDraftlaporanUmum/{id}', 'PengawasController@deleteDraftlaporanUmum')->name('deleteDraftlaporanUmum');

    Route::post('/kirimLaporan', 'PengawasController@kirimLaporan')->name('kirimLaporan');

    Route::post('tambahirjdetail', 'PengawasController@tambahirjdetail')->name('tambahirjdetail');
    Route::put('editirjdetail', 'PengawasController@editirjdetail')->name('editirjdetail');
    Route::get('deleteirjdetail', 'PengawasController@deleteirjdetail')->name('deleteirjdetail');
    Route::get('/refresh-irj-detail',function(){
        return view('pengawas.ajax.refresh-irj-detail');
    });
 
});

//DIREKTUR dan BIDANG KEPERAWATAN
Route::group(['middleware' => ['auth', 'direktur']],  function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard.dashboard');
    })->name('dashboard');
 
    //Riwayat Laporan
    Route::get('/riwayat-laporan-pu-belum-verifikasi', function () {
        return view('admin.konten.riwayat-belum');
    })->name('riwayat-laporan-pu-belum');
    Route::get('/riwayat-laporan-pu-sudah-verifikasi', function () {
        return view('admin.konten.riwayat-sudah');
    })->name('riwayat-laporan-pu-sudah');
    Route::put('verifikasilaporan', 'DirekturController@verifikasilaporan')->name('verifikasilaporan');

    //Grafik Laporan
    Route::get('/grafik-laporan', function () {
        return view('admin.laporan.grafik');
    })->name('grafik-laporan');
    Route::get('/refresh-grafik/{tahun}/{bulan}',function($tahun, $bulan){
        return view('admin.ajax.refresh-grafik',compact('tahun','bulan'));
    });
    
    //Jadwal Dinas
    Route::get('/jadwal-dinas', function () {
        return view('admin.konten.jadwal');
    })->name('jadwal-dinas');

    //ajax piket
    //Route::get('tambahpiket', 'KeperawatanController@showpiket');
    Route::post('tambahpiket', 'KeperawatanController@tambahpiket')->name('tambahpiket');
    Route::put('editpiket', 'KeperawatanController@editpiket')->name('editpiket');
    Route::get('deletepiket/{id}', 'KeperawatanController@deletepiket')->name('deletepiket');
    Route::get('/refresh-jadwal-dinas/{tahun}/{bulan}',function($tahun, $bulan){
        return view('admin.ajax.refresh-jadwal-dinas',compact('tahun','bulan'));
    });

    //Data Pengawas Umum
    Route::get('/data-pengawas-umum', function () {
        return view('admin.konten.pengawas');
    })->name('data-pengawas-umum');
    
    //Ruangan
    Route::get('/data-ruangan', function () {
        return view('admin.konten.ruangan');
    })->name('data-ruangan');
    Route::post('/tambahruangan', 'DirekturController@tambahruangan')->name('tambahruangan');
    Route::put('/editruangan', 'DirekturController@editruangan')->name('editruangan');
    Route::get('/deleteruangan/{id}', 'DirekturController@deleteruangan')->name('deleteruangan');

    //Dokter Jaga (IGD)
    Route::get('/data-dokter-jaga', function () {
        return view('admin.konten.dokter');
    })->name('data-dokter');
    Route::post('/tambahdokter', 'DirekturController@tambahdokter')->name('tambahdokter');
    Route::put('/editdokter', 'DirekturController@editdokter')->name('editdokter');
    Route::get('/deletedokter/{id}', 'DirekturController@deletedokter')->name('deletedokter');

    //Pengguna
    Route::get('/data-pengguna', function () {
        return view('admin.konten.pengguna');
    })->name('data-pengguna');
    Route::post('/tambahpengguna', 'DirekturController@tambahpengguna')->name('tambahpengguna');
    Route::put('/editpengguna', 'DirekturController@editpengguna')->name('editpengguna');
    Route::get('/deletepengguna/{id}', 'DirekturController@deletepengguna')->name('deletepengguna');

    //Laporan
    Route::get('/refresh-laporan-umum-pu/{ruangan}',function($ruangan){
        return view('admin.ajax.refresh-laporan-umum',compact('ruangan'));
    });
    
    //Dokter IRJ
    Route::get('/data-dokter-irj', function () {
        return view('admin.konten.dokter-irj');
    })->name('data-dokter-irj');
    Route::post('/tambahdokterirj', 'DirekturController@tambahdokterirj')->name('tambahdokterirj');
    Route::put('/editdokterirj', 'DirekturController@editdokterirj')->name('editdokterirj');
    Route::get('/deletedokterirj/{id}', 'DirekturController@deletedokterirj')->name('deletedokterirj');

    //SDMK SUBRUMPUN
    Route::get('/data-subrumpun-sdmk', function () {
        return view('admin.konten.subrumpun-sdmk');
    })->name('data-subrumpun-sdmk');
    Route::post('/tambahsubrumpunsdmk', 'DirekturController@tambahsubrumpunsdmk')->name('tambahsubrumpunsdmk');
    Route::put('/editsubrumpunsdmk', 'DirekturController@editsubrumpunsdmk')->name('editsubrumpunsdmk');
    Route::get('/deletesubrumpunsdmk/{id}', 'DirekturController@deletesubrumpunsdmk')->name('deletesubrumpunsdmk');
    
    //SDMK JENIS
    Route::get('/data-jenis-sdmk', function () {
        return view('admin.konten.jenis-sdmk');
    })->name('data-jenis-sdmk');
    Route::post('/tambahjenissdmk', 'DirekturController@tambahjenissdmk')->name('tambahjenissdmk');
    Route::put('/editjenissdmk', 'DirekturController@editjenissdmk')->name('editjenissdmk');
    Route::get('/deletejenissdmk/{id}', 'DirekturController@deletejenissdmk')->name('deletejenissdmk');

    //Log
    Route::get('/log', function () {
        if(\Auth::user()->id_role == 3)
        {
            return view('admin.dashboard.dashboard');
        }
        else{
            return view('admin.log.log');
        }
    })->name('log');
});


