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

//---------------auth--------------//
Route::post('/dologin', 'LoginController@dologin')->name('dologin');
Route::get('logout', 'LoginController@logout')->name('logout');


//ALL USERS
Route::group(['middleware' => ['auth']],  function () {
    Route::put('/gantipassword', 'UserController@gantipassword')->name('gantipassword');
    
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
    Route::get('/riwayat-laporan', function () {
        return view('pengawas.riwayat');
    })->name('riwayat-laporan');
    Route::get('/refresh-laporan-umum/{ruangan}',function($ruangan){
        return view('pengawas.ajax.refresh-laporan-umum',compact('ruangan'));
    });
    
    //laporan
    Route::post('/draftlaporanIGD', 'PengawasController@draftlaporanIGD')->name('draftlaporanIGD');
    Route::post('/draftlaporanUmum', 'PengawasController@draftlaporanUmum')->name('draftlaporanUmum');
    Route::post('/kirimLaporan', 'PengawasController@kirimLaporan')->name('kirimLaporan');
 
});

//DIREKTUR
Route::group(['middleware' => ['auth', 'direktur']],  function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard.dashboard');
    })->name('dashboard');
 
    //Riwayat Laporan
    Route::get('/riwayat-laporan-pengawas-umum', function () {
        return view('admin.konten.riwayat');
    })->name('riwayat-laporan-pengawas-umum');
    
    //Jadwal Dinas
    Route::get('/jadwal-dinas', function () {
        return view('admin.konten.jadwal');
    })->name('jadwal-dinas');
    Route::post('/tambahpiket', 'KeperawatanController@tambahpiket')->name('tambahpiket');
    Route::put('/editpiket', 'KeperawatanController@editpiket')->name('editpiket');
    Route::get('/deletepiket/{id}', 'KeperawatanController@deletepiket')->name('deletepiket');

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

    //Dokter Jaga
    Route::get('/data-dokter', function () {
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
    


});


