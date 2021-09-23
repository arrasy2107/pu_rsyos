@extends('master.masterpengawas')
@section('custom_style')

@stop 
@section('content')
@if (Session::has('success-add'))
<div class="alert alert-success alert-call">
    <p>{{ Session::get('success-add') }}</p>
</div>
@endif
@if (Session::has('fail-add'))
<div class="alert alert-danger alert-call">
    <p>{{ Session::get('fail-add') }}</p>
</div>
@endif
<?php 
use Carbon\Carbon;
date_default_timezone_set('Asia/Jakarta');

setlocale(LC_TIME, 'id_ID');

\Carbon\Carbon::setLocale('id');
\Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
$today = Carbon::now()->isoFormat('dddd, D MMMM Y');

$cekhariini = \Carbon\Carbon::now()->format('Ymd');
$t = new Grei\TanggalMerah();
$t->set_date($cekhariini);


$now = \Carbon\Carbon::now();
$ltime = date('H:i:s');
$nowTime = $now->hour.':'.$now->minute.':'.$now->second;

$start = \Carbon\Carbon::createFromTimeString(\App\Models\Dinas::where('id',1)->pluck('jam_masuk')->first());
$end = \Carbon\Carbon::createFromTimeString(\App\Models\Dinas::where('id',2)->pluck('jam_pulang')->first());

 

?>
<style>
    .shadow-textarea textarea.form-control::placeholder {
        font-weight: 300;
    }

    .shadow-textarea textarea.form-control {
        padding-left: 0.8rem;
    }
</style>
<div class="container-fluid">


    
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Pengawas Umum</h1>
        {{$today}}
    </div>

    @if(\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->first())
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseIGD2" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseIGD2">
            <h6 class="m-0 font-weight-bold ">Instalasi Gawat Darurat (IGD) <span style="color:green;font-size:14px">(sudah dikunjungi) </span> <span style="font-size:14px;color:#858796;font-weight:400;float: right;">ubah data di Draf Laporan ...</span> </h6>
            
        </a>
    </div>
    @else
    <!-- Collapsable Card Example -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseIGD" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseIGD">
            <h6 class="m-0 font-weight-bold ">Instalasi Gawat Darurat (IGD)</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse " id="collapseIGD">
            <div class="card-body">
                <!-- Content Row -->
                <form method="post" action="{{ route('draftlaporanIGD') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row ">
                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien" onfocus="igd1a();" onfocusout="igd1b();" autocomplete="off" required />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        <img src="{{asset('sb-admin/icon/general/pasien.png')}}" id="gbr_igd_pasien" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                 

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien rawat</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien_rawat" onfocus="igd2a();" onfocusout="igd2b();"  autocomplete="off" required />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        <img src="{{asset('sb-admin/icon/igd/pasien-dirawat.png')}}" id="gbr_igd_pasien_rawat" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien emergency</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien_emergency" onfocus="igd3a();" onfocusout="igd3b();"  autocomplete="off" required />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        <img src="{{asset('sb-admin/icon/igd/pasien-emergency.png')}}" id="gbr_igd_pasien_emergency" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien Tidak bisa dirawat</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien_tidak_rawat" onfocus="igd4a();" onfocusout="igd4b();"  autocomplete="off" required />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        <img src="{{asset('sb-admin/icon/igd/pasien-tidak-bisa-dirawat.png')}}" id="gbr_igd_pasien_tidak_rawat" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien Death on arrival (DOA)</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien_doa" onfocus="igd5a();" onfocusout="igd5b();"  autocomplete="off" required />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        <img src="{{asset('sb-admin/icon/igd/pasien-doa.png')}}" id="gbr_igd_pasien_doa" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Alasan pasien tidak bisa dirawat</label>
                                <textarea class="form-control  z-depth-1" name="igd_alasan" rows="3" placeholder="Tulis disini..."></textarea>
                            </div>
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Permasalahan</label>
                                <textarea class="form-control" name="igd_permasalahan" rows="3" placeholder="Tulis disini..."></textarea>
                            </div>
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Lain - lain</label>
                                <textarea class="form-control" name="igd_lainlain" rows="3" placeholder="Tulis disini..."></textarea>
                            </div>
                            <div class="form-group">
                                <label style="color:#000;font-weight:600">Dokter Jaga: </label><br>
                                <select class="form-control select2" name="igd_dokterjaga" style="width: 100%" required>
                                    <option value="" selected disabled hidden>Pilih Dokter</option>
                                    @foreach(\App\Models\Dokter::where('status',1)->get() as $dk)
                                    <option value="{{ $dk->id }}">{{ $dk->nama_dokter }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" style="float:right" class="btn btn-sm btn-igd btn-primary my-3">Simpan ke Draf Laporan</button>

                            </div>
                        </div>
                    </div>



                </form>
            </div>
        </div>
    </div>

    @endif

    
    @if(\App\Models\Laporanumum::where('status',0)->where('id_pengawas',\Auth::user()->id)->count() == \App\Models\Ruangan::where('status',1)->count())
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseRanap2" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseRanap2">
            <h6 class="m-0 font-weight-bold ">Ruangan <span style="color:green;font-size:14px">( {{\App\Models\Laporanumum::where('status',0)->where('id_pengawas',\Auth::user()->id)->count()}} / {{\App\Models\Ruangan::where('status',1)->count()}} sudah dikunjungi)</span> <span style="font-size:14px;color:#858796;font-weight:400;float: right;">ubah data di Draf Laporan ...</span> </h6>
            
        </a>
    </div>
    @else
    <!-- Collapsable Card Example -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <form method="post" action="{{ route('draftlaporanUmum') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <a href="#collapseRanap" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseRanap">
            @if(\App\Models\Laporanumum::where('status',0)->where('id_pengawas',\Auth::user()->id)->first())
            <h6 class="m-0 font-weight-bold ">Ruangan <span style="color:green;font-size:14px">( {{\App\Models\Laporanumum::where('status',0)->where('id_pengawas',\Auth::user()->id)->count()}} / {{\App\Models\Ruangan::where('status',1)->count()}} sudah dikunjungi)</span></h6>
            @else
                <h6 class="m-0 font-weight-bold ">Ruangan</h6>
                @endif
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse" id="collapseRanap">
                <div class="card-body">
                    <!-- Content Row -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label style="color:#000;font-weight:600"> Ruangan yang belum dikunjungi: </label><br>
                                <select class="form-control select2" name="inap_ruangan" style="width: 100%" required>
                                    <option value="" selected disabled hidden>Pilih Ruangan</option>
                                    @foreach(\App\Models\Ruangan::where('status',1)->get() as $dk)
                                        @if(!\App\Models\Laporanumum::where('id_pengawas',\Auth::user()->id)->where('status',0)->where('id_ruangan',$dk->id)->first())
                                        <option value="{{ $dk->id }}">{{ $dk->nama_ruangan }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <!-- Pending Requests Card Example -->


                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">

                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold  text-uppercase mb-1"> Jumlah Pasien lama</div>
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" id="inap_pasien_lama" name="inap_pasien_lama" onfocus="ranap1a();" onfocusout="ranap1b();" autocomplete="off" required />
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        <img src="{{asset('sb-admin/icon/general/pasien.png')}}" id="gbr_inap_pasien_lama" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien baru</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="inap_pasien_baru" autocomplete="off" onfocus="ranap2a();" onfocusout="ranap2b();" required />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        <img src="{{asset('sb-admin/icon/ranap/pasien-baru.png')}}" id="gbr_inap_pasien_baru" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien pindah (ruangan)</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="inap_pasien_pindah" autocomplete="off" onfocus="ranap3a();" onfocusout="ranap3b();" required />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        <img src="{{asset('sb-admin/icon/ranap/pasien-pindah.png')}}" id="gbr_inap_pasien_pindah" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien pindahan (ruangan)</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="inap_pasien_pindahan" autocomplete="off" onfocus="ranap4a();" onfocusout="ranap4b();" required />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        <img src="{{asset('sb-admin/icon/ranap/pasien-pindahan.png')}}" id="gbr_inap_pasien_pindahan" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien Meninggal</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="inap_pasien_meninggal" autocomplete="off" onfocus="ranap5a();" onfocusout="ranap5b();" required />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        <img src="{{asset('sb-admin/icon/ranap/pasien-meninggal.png')}}" id="gbr_inap_pasien_meninggal" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Catatan pasien istimewa</label>
                                <textarea class="form-control  z-depth-1" name="inap_catatan_istimewa" rows="3" placeholder="Tulis disini..."></textarea>
                            </div>
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Catatan pasien baru</label>
                                <textarea class="form-control" name="inap_catatan_baru" rows="3" placeholder="Tulis disini..."></textarea>
                            </div>

                        </div>
                    </div>
                    <div class="row mt-3">
                        <!-- Pending Requests Card Example -->


                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">

                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold  text-uppercase mb-1"> Jumlah Pasien Covid19</div>
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="inap_pasien_covid" autocomplete="off" onfocus="ranap6a();" onfocusout="ranap6b();" required />
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        <img src="{{asset('sb-admin/icon/ranap/pasien-covid.png')}}" id="gbr_inap_pasien_covid" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien Suspect Covid19</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="inap_pasien_suspect" autocomplete="off" onfocus="ranap7a();" onfocusout="ranap7b();" required />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        <img src="{{asset('sb-admin/icon/ranap/pasien-suspect-covid.png')}}" id="gbr_inap_pasien_suspek_covid" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien restrain</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="inap_pasien_restrain" autocomplete="off" onfocus="ranap8a();" onfocusout="ranap8b();" required />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        <img src="{{asset('sb-admin/icon/ranap/pasien-restrain.png')}}" id="gbr_inap_pasien_restrain" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien perilaku kekerasan</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="inap_pasien_kekerasan" autocomplete="off" onfocus="ranap9a();" onfocusout="ranap9b();" required />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        <img src="{{asset('sb-admin/icon/ranap/pasien-perilaku-kekerasan.png')}}" id="gbr_inap_pasien_perilaku_kekerasan" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien keracunan</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="inap_pasien_keracunan" autocomplete="off" onfocus="ranap10a();" onfocusout="ranap10b();" required />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        <img src="{{asset('sb-admin/icon/ranap/pasien-keracunan.png')}}" id="gbr_inap_pasien_keracunan" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                         <!-- Earnings (Monthly) Card Example -->
                         <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien Keterbatasan bahasa</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="inap_pasien_bahasa" autocomplete="off" onfocus="ranap11a();" onfocusout="ranap11b();" required />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        <img src="{{asset('sb-admin/icon/ranap/pasien-keterbatasan-bahasa.png')}}" id="gbr_inap_pasien_keterbatasan_bahasa" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                         <!-- Earnings (Monthly) Card Example -->
                         <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien difabel</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="inap_pasien_difabel" autocomplete="off" onfocus="ranap12a();" onfocusout="ranap12b();" required />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        <img src="{{asset('sb-admin/icon/ranap/pasien-difabel.png')}}" id="gbr_inap_pasien_difabel" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-12">

                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Permasalahan Umum</label>
                                <textarea class="form-control" name="inap_permasalahan" rows="3" placeholder="Tulis disini..."></textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" style="float:right" class="btn btn-sm btn-igd btn-primary my-3">Simpan ke Draf Laporan</button>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
    @endif


    <!-- cek dinas malam atau hari libur -->
    @if (strtotime($nowTime) > strtotime($start) && strtotime($nowTime) < strtotime($end) && $t->check() != true)

    @if(\App\Models\Laporanirj::where('status',0)->where('id_pengawas',\Auth::user()->id)->first())
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseIRJ2" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseIRJ2">
            <h6 class="m-0 font-weight-bold ">Instalasi Rawat Jalan (IRJ) <span style="color:green;font-size:14px">(sudah dikunjungi) </span> <span style="font-size:14px;color:#858796;font-weight:400;float: right;">ubah data di Draf Laporan ...</span> </h6>
            
        </a>
    </div>
    @else
    <!-- Collapsable Card Example -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseIRJ" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseIRJ">
            <h6 class="m-0 font-weight-bold ">Instalasi Rawat Jalan (IRJ)</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse " id="collapseIRJ">
            <div class="card-body">
                <!-- Content Row -->
                
                    <div class="row">
                        <div class="col-md-4">
                            <button class="btn btn-primary btn-md" data-toggle="modal" data-target="#tambah">Tambah Keterangan</button>
                            <br>
                        </div>
                    </div>
                    <br>
                    <div class="row ">
                        <div class="col-lg-12 tableketerangan">
                            <label  style="color:#000;font-weight:600">Jumlah pasien menurut Dokter </label>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="10%">No</th>
                                            <th>SDMK Jenis</th>
                                            <th>Nama Dokter</th>
                                            <th>Pasien Lama</th>
                                            <th>Pasien Baru</th>
                                            <th>Total</th>
                                            <th width="20%">Aksi</th>

                                        </tr>
                                    </thead>
                                    
                                    <?php
                                    $no = 1;
                                    ?>
                                    <tbody>
                                        @foreach(\App\Models\Laporanirjdetail::where('status',0)->where('id_pengawas',\Auth::user()->id)->get() as $data)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ \App\Models\sdmk_jenis::where('id',\App\Models\Dokterirj::where('id',$data->id_dokter_irj)->pluck('id_sdmk_jenis')->first())->pluck('jenis')->first() }}</td>
                                            <td>{{ \App\Models\Dokterirj::where('id',$data->id_dokter_irj)->pluck('nama')->first() }}</td>
                                            <td>{{ $data->pasien_lama }}</td>
                                            <td>{{ $data->pasien_baru }}</td>
                                            <td>{{ $data->pasien_total }}</td>
                                            <td><button value="{{ $data->id }}" class="btn btn-sm btn-success btn-edit " data-dokter="{{$data->id_dokter_irj}}" data-lama="{{$data->pasien_lama}}" data-baru="{{$data->pasien_baru}}" data-toggle="modal" data-target="#edit">Ubah</button>
                                            <button value="{{ $data->id }}" class="btn btn-sm btn-danger btn-hapus ">Hapus</button>
                                                
                                            </td>

                                        </tr>
                                        <?php
                                        $no++;
                                        ?>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <form method="post" action="{{ route('draftlaporanIRJ') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Masalah</label>
                                <textarea class="form-control  z-depth-1" name="irj_masalah" rows="3" placeholder="Tulis disini..."></textarea>
                            </div>
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Langkah atasi masalah</label>
                                <textarea class="form-control" name="irj_langkah" rows="3" placeholder="Tulis disini..."></textarea>
                            </div>
                            
                          
                            <div class="form-group">
                                <button type="submit" style="float:right" class="btn btn-sm btn-irj btn-primary my-3">Simpan ke Draf Laporan</button>

                            </div>
                        </div>
                    </div>



                </form>
            </div>
        </div>
    </div>

    @endif
    @endif

</div>
<!-- /.container-fluid -->

<div id="tambah" class="modal fade" role="dialog">
    <div class="modal-dialog">


        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                Tambah Keterangan Jumlah Pasien menurut Dokter
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="" id="tambahketerangan" role="form">
                {{ csrf_field() }}
                    <div class="form-group">
                        <label>Dokter : </label><br>
                        <select class="form-control select2" name="id_dokter_irj" id="id_dokter_irj" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Pasien Lama: </label>
                        <input type="number" class="form-control" name="pasien_lama" required />
                    </div>
                    <div class="form-group">
                        <label>Jumlah Pasien Baru: </label>
                        <input type="number" class="form-control" name="pasien_baru" required />
                    </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-primary btn-tambah">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div id="edit" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                Ubah Keterangan Jumlah Pasien menurut Dokter
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="" id="editketerangan" role="form">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <input type="hidden" class="txtid" name="id">
                    <div class="form-group">
                        <label>Dokter : </label><br>
                        <select class="form-control txtiddokter select2" name="id_dokter_irj2" id="id_dokter_irj2" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Pasien Lama: </label>
                        <input type="number" class="form-control txtlama" name="pasien_lama2" required />
                    </div>
                    <div class="form-group">
                        <label>Jumlah Pasien Baru: </label>
                        <input type="number" class="form-control txtbaru" name="pasien_baru2" required />
                    </div>
            </div>
            
            </form>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-primary btn-simpan">Simpan</button>
            </div>
        </div>
    </div>
</div>
@stop
@section('custom_script')

<script>

$("#dataTable").DataTable({
    "pageLength": 5,
    "ordering" : false,
    lengthMenu: [[5], [5]]
    });
    //IGD
    
    function igd1a() {
        document.getElementById("gbr_igd_pasien").setAttribute('src', '{{asset('sb-admin/icon/warna/general/pasien.png')}}');
    }

    function igd1b() {
        document.getElementById("gbr_igd_pasien").setAttribute('src', '{{asset('sb-admin/icon/general/pasien.png')}}');
    }
    
    function igd2a() {
        document.getElementById("gbr_igd_pasien_rawat").setAttribute('src', '{{asset('sb-admin/icon/warna/igd/pasien-dirawat.png')}}');
    }

    function igd2b() {
        document.getElementById("gbr_igd_pasien_rawat").setAttribute('src', '{{asset('sb-admin/icon/igd/pasien-dirawat.png')}}');
    }
    
    function igd3a() {
        document.getElementById("gbr_igd_pasien_emergency").setAttribute('src', '{{asset('sb-admin/icon/warna/igd/pasien-emergency.png')}}');
    }

    function igd3b() {
        document.getElementById("gbr_igd_pasien_emergency").setAttribute('src', '{{asset('sb-admin/icon/igd/pasien-emergency.png')}}');
    }
    
    function igd4a() {
        document.getElementById("gbr_igd_pasien_tidak_rawat").setAttribute('src', '{{asset('sb-admin/icon/warna/igd/pasien-tidak-bisa-dirawat.png')}}');
    }

    function igd4b() {
        document.getElementById("gbr_igd_pasien_tidak_rawat").setAttribute('src', '{{asset('sb-admin/icon/igd/pasien-tidak-bisa-dirawat.png')}}');
    }
    
    function igd5a() {
        document.getElementById("gbr_igd_pasien_doa").setAttribute('src', '{{asset('sb-admin/icon/warna/igd/pasien-doa.png')}}');
    }

    function igd5b() {
        document.getElementById("gbr_igd_pasien_doa").setAttribute('src', '{{asset('sb-admin/icon/igd/pasien-doa.png')}}');
    }


    //Rawat Inap
    function ranap1a() {
        document.getElementById("gbr_inap_pasien_lama").setAttribute('src', '{{asset('sb-admin/icon/warna/general/pasien.png')}}');
    }

    function ranap1b() {
        document.getElementById("gbr_inap_pasien_lama").setAttribute('src', '{{asset('sb-admin/icon/general/pasien.png')}}');
    }

    function ranap2a() {
        document.getElementById("gbr_inap_pasien_baru").setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-baru.png')}}');
    }

    function ranap2b() {
        document.getElementById("gbr_inap_pasien_baru").setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-baru.png')}}');
    }

    function ranap3a() {
        document.getElementById("gbr_inap_pasien_pindah").setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-pindah.png')}}');
    }

    function ranap3b() {
        document.getElementById("gbr_inap_pasien_pindah").setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-pindah.png')}}');
    }

    function ranap4a() {
        document.getElementById("gbr_inap_pasien_pindahan").setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-pindahan.png')}}');
    }

    function ranap4b() {
        document.getElementById("gbr_inap_pasien_pindahan").setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-pindahan.png')}}');
    }

    function ranap5a() {
        document.getElementById("gbr_inap_pasien_meninggal").setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-meninggal.png')}}');
    }

    function ranap5b() {
        document.getElementById("gbr_inap_pasien_meninggal").setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-meninggal.png')}}');
    }

    function ranap6a() {
        document.getElementById("gbr_inap_pasien_covid").setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-covid.png')}}');
    }

    function ranap6b() {
        document.getElementById("gbr_inap_pasien_covid").setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-covid.png')}}');
    }

    function ranap7a() {
        document.getElementById("gbr_inap_pasien_suspek_covid").setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-suspect-covid.png')}}');
    }

    function ranap7b() {
        document.getElementById("gbr_inap_pasien_suspek_covid").setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-suspect-covid.png')}}');
    }

    function ranap8a() {
        document.getElementById("gbr_inap_pasien_restrain").setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-restrain.png')}}');
    }

    function ranap8b() {
        document.getElementById("gbr_inap_pasien_restrain").setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-restrain.png')}}');
    }

    function ranap9a() {
        document.getElementById("gbr_inap_pasien_perilaku_kekerasan").setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-perilaku-kekerasan.png')}}');
    }

    function ranap9b() {
        document.getElementById("gbr_inap_pasien_perilaku_kekerasan").setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-perilaku-kekerasan.png')}}');
    }

    function ranap10a() {
        document.getElementById("gbr_inap_pasien_keracunan").setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-keracunan.png')}}');
    }

    function ranap10b() {
        document.getElementById("gbr_inap_pasien_keracunan").setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-keracunan.png')}}');
    }

    function ranap11a() {
        document.getElementById("gbr_inap_pasien_keterbatasan_bahasa").setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-keterbatasan-bahasa.png')}}');
    }

    function ranap11b() {
        document.getElementById("gbr_inap_pasien_keterbatasan_bahasa").setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-keterbatasan-bahasa.png')}}');
    }

    function ranap12a() {
        document.getElementById("gbr_inap_pasien_difabel").setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-difabel.png')}}');
    }

    function ranap12b() {
        document.getElementById("gbr_inap_pasien_difabel").setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-difabel.png')}}');
    }
</script>

<script>
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

var id,dokter,lama,baru;
    $("#dataTable").on('click', '.btn-edit', function() {
        id = $(this).val(); //dinas
        dokter = $(this).data('dokter');
        lama = $(this).data('lama');
        baru = $(this).data('baru');

    });

    $("#dataTable").on('click', '.btn-hapus', function(e) {
        id = $(this).val(); 
        var conf = confirm('apakah anda yakin ingin menghapus data ini ?');
        if (conf == false) {
            e.preventDefault();
            // $("#edit").modal('hide');
        }
        else{
            // $("#edit").modal('hide');
            
            console.log(id);
            var url = 'deleteirjdetail';

            $.ajax({
            url:url,
            method:'GET',
            data:{
                _token: "{{ csrf_token() }}",
                id:id,
            
            },
            success:function(response){
                if(response.success){
                    
                    alert(response.message) //Message come from controller
                    $.ajax({
                            type : "get",
                            url : 'refresh-irj-detail/',
                            data: { "_token": "{{ csrf_token() }}",},
                            success : function(data){
                            //console.log(data);
                            $(".tableketerangan").html(data);
                            }   
                    });
                }else{
                    alert("Error")
                }
            },
            error:function(error){
                console.log(error)
            }
            });
        }

    });

    $('#edit').on('show.bs.modal', function() {
        $(".txtid").val(id);
        $(".txtiddokter").select2().val(dokter).trigger("change");
        $(".txtlama").val(lama);
        $(".txtbaru").val(baru);
    });



</script>

<script>
$(document).ready(function() {
    $("#tambahketerangan").submit(function(e) {
        $("#tambah").modal('hide');

        e.preventDefault();

        var id_dokter_irj = $("#id_dokter_irj :selected").val();
        var pasien_lama = $("input[name=pasien_lama]").val();
        var pasien_baru = $("input[name=pasien_baru]").val();
    
        
            console.log(id_dokter_irj+' '+ pasien_lama + ' '+ pasien_baru);
            var url = 'tambahirjdetail';

            $.ajax({
            url:url,
            method:'POST',
            data:{
                _token: "{{ csrf_token() }}",
                id_dokter_irj:id_dokter_irj,
                pasien_lama:pasien_lama,
                pasien_baru : pasien_baru
            },
            success:function(response){
                if(response.success){
                    $("#id_dokter_irj").val("");
                    $("input[name=pasien_lama]").val("");
                    $("input[name=pasien_baru]").val("");
                    alert(response.message) //Message come from controller
                    $.ajax({
                        type : "get",
                        url : 'refresh-irj-detail/',
                        data: { "_token": "{{ csrf_token() }}",},
                        success : function(data){
                        //console.log(data);
                        $(".tableketerangan").html(data);
                        }   
                });
                }else{
                    alert("Error")
                }
            },
            error:function(error){
                console.log(error)
            }
            });
        
        
    });
});

</script>

<script>

// $(document).ready(function() {
//     $("#editketerangan").submit(function(e) {
 $(".btn-simpan").click(function(e){

        $("#edit").modal('hide');

        e.preventDefault();


        var id2 = $("input[name=id]").val();
        var id_dokter_irj2 = $("#id_dokter_irj2 :selected").val();
        var pasien_lama2 =$("input[name=pasien_lama2]").val();
        var pasien_baru2 = $("input[name=pasien_baru2]").val();

        console.log(id2+' - '+id_dokter_irj2+' - '+ pasien_lama2 + ' - '+ pasien_baru2);
        var url = 'editirjdetail';

        $.ajax({
        url:url,
        method:'PUT',
        data:{
            _token: "{{ csrf_token() }}",
            id:id2,
            id_dokter_irj:id_dokter_irj2,
            pasien_lama:pasien_lama2,
            pasien_baru : pasien_baru2
        },
        success:function(response){
            if(response.success == true){
                
                alert(response.message) //Message come from controller
                $.ajax({
                    type : "get",
                    url : 'refresh-irj-detail/',
                    data: { "_token": "{{ csrf_token() }}",},
                    success : function(data){
                    //console.log(data);
                    $(".tableketerangan").html(data);
                    }   
                });
            }else{
                alert(response.message)
            }
        },
        error:function(error){
            console.log(error)
        }
        });
    });



</script>

@stop