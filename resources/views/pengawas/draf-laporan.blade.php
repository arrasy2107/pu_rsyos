@extends('master.masterpengawas')
@section('content')
@if (Session::has('success-add'))
<div class="alert alert-success alert-call">
    <p>{{ Session::get('success-add') }}</p>
</div>
@endif
<?php

use Carbon\Carbon;

setlocale(LC_TIME, 'id_ID');
\Carbon\Carbon::setLocale('id');
\Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
$today = Carbon::now()->isoFormat('dddd, D MMMM Y');
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
        <h1 class="h3 mb-0 text-gray-800">Draf Laporan Pengawas Umum</h1>
        {{$today}}
    </div>


    <!-- Collapsable Card Example -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseIGD" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseIGD">
            @if(\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->first())
            <h6 class="m-0 font-weight-bold ">Instalasi Gawat Darurat (IGD) <span style="color:green;font-size:14px">(sudah dikunjungi)</span></h6>
            @else
            <h6 class="m-0 font-weight-bold ">Instalasi Gawat Darurat (IGD)</h6>
            @endif
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse " id="collapseIGD">
            <div class="card-body">
                <!-- Content Row -->
                <form method="post" action="#" enctype="multipart/form-data">
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
                                                <input type="number" class="form-control" name="igd_pasien" autocomplete="off" value="{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien')->first()}}" readonly />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/general/pasien.png')}}" height="64px" width="64px" onmouseover="igd1a(this);" onmouseout="igd1b(this);">
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
                                                <input type="number" class="form-control" name="igd_pasien_rawat" autocomplete="off" value="{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_rawat')->first()}}" readonly />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/igd/pasien-dirawat.png')}}" height="64px" width="64px" onmouseover="igd2a(this);" onmouseout="igd2b(this);">
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
                                                <input type="number" class="form-control" name="igd_pasien_emergency" autocomplete="off" value="{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_emergency')->first()}}" readonly />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/igd/pasien-emergency.png')}}" height="64px" width="64px" onmouseover="igd3a(this);" onmouseout="igd3b(this);">
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
                                                <input type="number" class="form-control" name="igd_pasien_tidak_rawat" autocomplete="off" value="{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_tidak_bisa_rawat')->first()}}" readonly />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/igd/pasien-tidak-bisa-dirawat.png')}}" height="64px" width="64px" onmouseover="igd4a(this);" onmouseout="igd4b(this);">
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
                                                <input type="number" class="form-control" name="igd_pasien_doa" autocomplete="off" value="{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_doa')->first()}}" readonly />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/igd/pasien-doa.png')}}" height="64px" width="64px" onmouseover="igd5a(this);" onmouseout="igd5b(this);">
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
                                <textarea class="form-control  z-depth-1" name="igd_alasan" rows="3" placeholder="Tulis disini..." readonly>{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('alasan_tidak_bisa_rawat')->first()}}</textarea>
                            </div>
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Permasalahan</label>
                                <textarea class="form-control" name="igd_permasalahan" rows="3" placeholder="Tulis disini..." readonly>{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('permasalahan')->first()}}</textarea>
                            </div>
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Lain - lain</label>
                                <textarea class="form-control" name="igd_lainlain" rows="3" placeholder="Tulis disini..." readonly>{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('lain_lain')->first()}}</textarea>
                            </div>
                            <div class="form-group">
                                <label style="color:#000;font-weight:600">Dokter Jaga: </label>
                                <select class="form-control" name="igd_dokterjaga" disabled>
                                    <option value="" selected disabled hidden>Pilih Dokter</option>
                                    @foreach(\App\Models\Dokter::where('status',1)->get() as $dk)
                                    @if(\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('id_dokter')->first() == $dk->id)
                                    <option value="{{ $dk->id }}" selected>{{ $dk->nama_dokter }}</option>
                                    @else
                                    <option value="{{ $dk->id }}">{{ $dk->nama_dokter }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" style="float:right" class="btn btn-sm btn-igd btn-primary my-3" disabled>Simpan Laporan</button>

                            </div>
                        </div>
                    </div>



                </form>
            </div>
        </div>
    </div>




    <!-- Collapsable Card Example -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <form method="post" action="{{ route('draftlaporanUmum') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <a href="#collapseRanap" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseRanap">
                @if(\App\Models\Laporanumum::where('status',0)->where('id_pengawas',\Auth::user()->id)->first())
                <h6 class="m-0 font-weight-bold ">Rawat Inap <span style="color:green;font-size:14px">( {{\App\Models\Laporanumum::where('status',0)->where('id_pengawas',\Auth::user()->id)->count()}} / {{\App\Models\Ruangan::where('status',1)->count()}} sudah dikunjungi)</span></h6>
                @else
                <h6 class="m-0 font-weight-bold ">Rawat Inap</h6>
                @endif
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse" id="collapseRanap">
                <div class="card-body">
                    <!-- Content Row -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label style="color:#000;font-weight:600"> Ruangan yang sudah dikunjungi: </label>
                                <select class="form-control select2" name="inap_ruangan" required>
                                    <option value="" selected disabled hidden>Pilih Ruangan</option>
                                    @foreach(\App\Models\Ruangan::where('status',1)->get() as $dk)
                                    @if(\App\Models\Laporanumum::where('id_pengawas',\Auth::user()->id)->where('status',0)->where('id_ruangan',$dk->id)->first())
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
                                                <input type="number" class="form-control" name="inap_pasien_lama" autocomplete="off" required />
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/general/pasien.png')}}" height="64px" width="64px" onmouseover="ranap1a(this);" onmouseout="ranap1b(this);">
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
                                                <input type="number" class="form-control" name="inap_pasien_baru" autocomplete="off" required />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/ranap/pasien-baru.png')}}" height="64px" width="64px" onmouseover="ranap2a(this);" onmouseout="ranap2b(this);">
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

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien pindah</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="inap_pasien_pindah" autocomplete="off" required />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/ranap/pasien-pindah.png')}}" height="64px" width="64px" onmouseover="ranap3a(this);" onmouseout="ranap3b(this);">
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

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien pindahan</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="inap_pasien_pindahan" autocomplete="off" required />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/ranap/pasien-pindahan.png')}}" height="64px" width="64px" onmouseover="ranap4a(this);" onmouseout="ranap4b(this);">
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
                                                <input type="number" class="form-control" name="inap_pasien_meninggal" autocomplete="off" required />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/ranap/pasien-meninggal.png')}}" height="64px" width="64px" onmouseover="ranap5a(this);" onmouseout="ranap5b(this);">
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
                                                <input type="number" class="form-control" name="inap_pasien_covid" autocomplete="off" required />
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/ranap/pasien-covid.png')}}" height="64px" width="64px" onmouseover="ranap6a(this);" onmouseout="ranap6b(this);">
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
                                                <input type="number" class="form-control" name="inap_pasien_suspect" autocomplete="off" required />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/ranap/pasien-suspect-covid.png')}}" height="64px" width="64px" onmouseover="ranap7a(this);" onmouseout="ranap7b(this);">
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
                                                <input type="number" class="form-control" name="inap_pasien_restrain" autocomplete="off" required />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/ranap/pasien-restrain.png')}}" height="64px" width="64px" onmouseover="ranap8a(this);" onmouseout="ranap8b(this);">
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
                                                <input type="number" class="form-control" name="inap_pasien_kekerasan" autocomplete="off" required />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/ranap/pasien-perilaku-kekerasan.png')}}" height="64px" width="64px" onmouseover="ranap9a(this);" onmouseout="ranap9b(this);">
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
                                                <input type="number" class="form-control" name="inap_pasien_keracunan" autocomplete="off" required />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/ranap/pasien-keracunan.png')}}" height="64px" width="64px" onmouseover="ranap10a(this);" onmouseout="ranap10b(this);">
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
                                                <input type="number" class="form-control" name="inap_pasien_bahasa" autocomplete="off" required />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/ranap/pasien-keterbatasan-bahasa.png')}}" height="64px" width="64px" onmouseover="ranap11a(this);" onmouseout="ranap11b(this);">
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
                                                <input type="number" class="form-control" name="inap_pasien_difabel" autocomplete="off" required />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/ranap/pasien-difabel.png')}}" height="64px" width="64px" onmouseover="ranap12a(this);" onmouseout="ranap12b(this);">
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



</div>
<!-- /.container-fluid -->
@stop
@section('custom_script')
<script>
    // IGD

    function igd1a(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/warna/general/pasien.png')}}');
    }

    function igd1b(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/general/pasien.png')}}');
    }
    
    function igd2a(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/warna/igd/pasien-dirawat.png')}}');
    }

    function igd2b(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/igd/pasien-dirawat.png')}}');
    }
    
    function igd3a(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/warna/igd/pasien-emergency.png')}}');
    }

    function igd3b(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/igd/pasien-emergency.png')}}');
    }
    
    function igd4a(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/warna/igd/pasien-tidak-bisa-dirawat.png')}}');
    }

    function igd4b(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/igd/pasien-tidak-bisa-dirawat.png')}}');
    }
    
    function igd5a(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/warna/igd/pasien-doa.png')}}');
    }

    function igd5b(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/igd/pasien-doa.png')}}');
    }

    //RAWAT INAP

    function ranap1a(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/warna/general/pasien.png')}}');
    }

    function ranap1b(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/general/pasien.png')}}');
    }
    
    function ranap2a(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-baru.png')}}');
    }

    function ranap2b(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-baru.png')}}');
    }

    function ranap3a(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-pindah.png')}}');
    }

    function ranap3b(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-pindah.png')}}');
    }

    function ranap4a(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-pindahan.png')}}');
    }

    function ranap4b(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-pindahan.png')}}');
    }

    function ranap5a(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-meninggal.png')}}');
    }

    function ranap5b(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-meninggal.png')}}');
    }

    function ranap6a(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-covid.png')}}');
    }

    function ranap6b(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-covid.png')}}');
    }

    function ranap7a(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-suspect-covid.png')}}');
    }

    function ranap7b(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-suspect-covid.png')}}');
    }

    function ranap8a(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-restrain.png')}}');
    }

    function ranap8b(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-restrain.png')}}');
    }

    function ranap9a(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-perilaku-kekerasan.png')}}');
    }

    function ranap9b(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-perilaku-kekerasan.png')}}');
    }

    function ranap10a(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-keracunan.png')}}');
    }

    function ranap10b(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-keracunan.png')}}');
    }

    function ranap11a(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-keterbatasan-bahasa.png')}}');
    }

    function ranap11b(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-keterbatasan-bahasa.png')}}');
    }

    function ranap12a(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-difabel.png')}}');
    }

    function ranap12b(element) {
        element.setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-difabel.png')}}');
    }
</script>
@stop