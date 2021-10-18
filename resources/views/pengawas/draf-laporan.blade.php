@extends('master.masterpengawas')
@section('custom_style')
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script src="{{asset('sb-admin/js/signature.js')}}"></script>
<link href="{{asset('sb-admin/css/signature.css')}}" rel="stylesheet">


<style>
    .kbw-signature {
        width: 100%;
        height: 200px;
    }

    #sig canvas {
        width: 100% !important;
        height: auto;
    }
</style>
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
date_default_timezone_set('Asia/Jakarta');
use Carbon\Carbon;

setlocale(LC_TIME, 'id_ID');
\Carbon\Carbon::setLocale('id');
\Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
$today = Carbon::now()->isoFormat('dddd, D MMMM Y');



$cekhariini = \Carbon\Carbon::now()->format('Ymd');
$t = new Grei\TanggalMerah();
$t->set_date($cekhariini);
// $t->set_date('20211002');


$now = \Carbon\Carbon::now();
// $now = new \Carbon\Carbon('2021-10-02 16:53:20');
$ltime = date('H:i:s');
$hariini = date('Y-m-d');
// $hariini = '2021-10-02';
$nowTime = $now->hour.':'.$now->minute.':'.$now->second;

if(\App\Models\Irjbuka::where('tanggal',$hariini)->first())
{
    $cekdinaspagi = \App\Models\Irjbuka::where('tanggal',$hariini)->where('id_dinas',1)->first();
    $cekdinassore = \App\Models\Irjbuka::where('tanggal',$hariini)->where('id_dinas',2)->first();

    if($cekdinaspagi && $cekdinassore){
        $start = \Carbon\Carbon::createFromTimeString(\App\Models\Dinas::where('id',1)->pluck('jam_masuk')->first());
        $end = \Carbon\Carbon::createFromTimeString(\App\Models\Dinas::where('id',2)->pluck('jam_pulang')->first());
    }
    else if($cekdinaspagi){
        $start = \Carbon\Carbon::createFromTimeString(\App\Models\Dinas::where('id',1)->pluck('jam_masuk')->first());
        $end = \Carbon\Carbon::createFromTimeString(\App\Models\Dinas::where('id',1)->pluck('jam_pulang')->first());

    }else{
        $start = \Carbon\Carbon::createFromTimeString(\App\Models\Dinas::where('id',2)->pluck('jam_masuk')->first());
        $end = \Carbon\Carbon::createFromTimeString(\App\Models\Dinas::where('id',2)->pluck('jam_pulang')->first());

    }

}
else{

$start = \Carbon\Carbon::createFromTimeString(\App\Models\Dinas::where('id',1)->pluck('jam_masuk')->first());
$end = \Carbon\Carbon::createFromTimeString(\App\Models\Dinas::where('id',2)->pluck('jam_pulang')->first());
}


?>
<style>
    .shadow-textarea textarea.form-control::placeholder {
        font-weight: 300;
    }

    .shadow-textarea textarea.form-control {
        padding-left: 0.8rem;
    }

    .kbw-signature {
        width: 100%;
        height: 200px;
    }

    #sig canvas {

        width: 100% !important;

        height: auto;

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
                <form method="post" action="{{ route('editDraftlaporanIGD') }}" id="editdraftigd" role="form">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row ">
                    <input type="hidden" class="txtid" name="id" value="{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('id')->first()}}">
                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body" onmouseover="igd1a();" onmouseout="igd1b();">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien" id="igd_pasien"  autocomplete="off" value="{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien')->first()}}" readonly />

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
                                <div class="card-body" onmouseover="igd2a();" onmouseout="igd2b();">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien rawat</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien_rawat" id="igd_pasien_rawat" autocomplete="off" value="{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_rawat')->first()}}" readonly />

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
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body" onmouseover="igd6a();" onmouseout="igd6b();">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien Pulang</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien_pulang" id="igd_pasien_pulang" autocomplete="off" value="{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_pulang')->first()}}" readonly />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/igd/pasien-pulang.png')}}" id="gbr_igd_pasien_pulang" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body" onmouseover="igd3a();" onmouseout="igd3b();">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien emergency</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien_emergency" id="igd_pasien_emergency" autocomplete="off" value="{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_emergency')->first()}}" readonly />

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
                                <div class="card-body" onmouseover="igd7a();" onmouseout="igd7b();">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien Non emergency</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien_non_emergency" id="igd_pasien_non_emergency"  autocomplete="off" value="{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_non_emergency')->first()}}" readonly />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/igd/pasien-non-emergency.png')}}" id="gbr_igd_pasien_non_emergency" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body" onmouseover="igd4a();" onmouseout="igd4b();">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah pasien rujuk dan tolak rawat </div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien_tidak_rawat" id="igd_pasien_tidak_rawat" autocomplete="off" value="{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_tidak_bisa_rawat')->first()}}" readonly />

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
                                <div class="card-body" onmouseover="igd5a();" onmouseout="igd5b();">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah "DOA" dan pasien meninggal</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien_doa" id="igd_pasien_doa" autocomplete="off" value="{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_doa')->first()}}" readonly />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/igd/pasien-doa.png')}}" id="gbr_igd_pasien_doa" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                         <!-- Earnings (Monthly) Card Example -->
                         <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body" onmouseover="igd8a();" onmouseout="igd8b();">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Rujukan Sisrute</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien_sisrute" id="igd_pasien_sisrute" autocomplete="off" value="{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_sisrute')->first()}}" readonly />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/igd/sisrute.png')}}" id="gbr_igd_pasien_sisrute" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body" onmouseover="igd9a();" onmouseout="igd9b();">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Rujukan Sisrute yang diterima</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien_sisrute_diterima" id="igd_pasien_sisrute_diterima" autocomplete="off" value="{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_sisrute_diterima')->first()}}" readonly />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/igd/sisrute-terima.png')}}" id="gbr_igd_pasien_sisrute_diterima" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body" onmouseover="igd10a();" onmouseout="igd10b();">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Rujukan Sisrute yang ditolak</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien_sisrute_ditolak" id="igd_pasien_sisrute_ditolak" autocomplete="off" value="{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_sisrute_ditolak')->first()}}" readonly />

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/igd/sisrute-tolak.png')}}" id="gbr_igd_pasien_sisrute_ditolak" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Alasan pasien rujuk dan tolak rawat </label>
                                <textarea class="form-control  z-depth-1" name="igd_alasan" id="igd_alasan" rows="3"  readonly>{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('alasan_tidak_bisa_rawat')->first()}}</textarea>
                            </div>
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Permasalahan</label>
                                <textarea class="form-control" name="igd_permasalahan" id="igd_permasalahan" rows="3"  readonly>{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('permasalahan')->first()}}</textarea>
                            </div>
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Lain - lain</label>
                                <textarea class="form-control" name="igd_lainlain" id="igd_lainlain" rows="3"  readonly>{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('lain_lain')->first()}}</textarea>
                            </div>
                            <div class="form-group">
                                <label style="color:#000;font-weight:600">Dokter Jaga: </label><br>
                                <select class="form-control select2" name="igd_dokterjaga" id="igd_dokterjaga" style="width: 100%" disabled>
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
                           
                        </div>
                    </div>

                    

                </form>
                @if(\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('id')->first())
                            <div class="form-group">
                                
                                <a href="{{ route('deleteDraftlaporanIGD',\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('id')->first()) }}" id="bataligd" style="float:right;" class="btn btn-sm btn-danger my-3 ml-2">Batalkan Laporan</a>
                                <button style="float:right" id="editigd" class="btn btn-sm btn-edit-igd btn-success my-3 ml-2" >Ubah Laporan</button>
                                <button style="float:right;display:none" id="batalperubahanigd"  class="btn btn-sm btn-edit-igd btn-danger my-3 ml-2" >Batalkan Perubahan</button>
                                <button style="float:right;display:none" id="simpanigd"  class="btn btn-sm btn-edit-igd btn-primary my-3" type="submit"  >Simpan Laporan</button>
                                
                            </div>
                            @endif
                            
            </div>
        </div>
    </div>



    <!-- Collapsable Card Example -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        
            
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
                                <label style="color:#000;font-weight:600"> Ruangan yang sudah dikunjungi: </label><br>
                                <select class="form-control select2" name="inap_ruangan" id="inap_ruangan" style="width: 100%" required>
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
                    <div class="row">
                        <div class="col-md-12 tablelaporan">

                        </div>
                    </div>
                </div>
            </div>
        
    </div>

    <!-- IBS -->
    <!-- Collapsable Card Example -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseIBS" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseIBS">
           
            @if(\App\Models\Laporanibs::where('status',0)->where('id_pengawas',\Auth::user()->id)->first())
            <h6 class="m-0 font-weight-bold ">Instalasi Bedah Sentral (IBS) <span style="color:green;font-size:14px">(sudah dikunjungi)</span></h6>
            @else
            <h6 class="m-0 font-weight-bold ">Instalasi Bedah Sentral (IBS)</h6>
            @endif
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse " id="collapseIBS">
            <div class="card-body">
                <!-- Content Row -->
                
                   
                    <div class="row ">
                        <div class="col-lg-12 tableketeranganibs">
                            <div class="row">
                                <div class="col-md-4">
                                    <button class="btn btn-primary btn-md" data-toggle="modal" data-target="#tambahibs">Tambah Keterangan</button>
                                    <br>
                                </div>
                            </div>
                            <br>
                            <label  style="color:#000;font-weight:600">Jumlah pasien menurut Dokter IBS</label>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="10%">No</th>
                                            <th>Dokter Operasi</th>
                                            <th>Dokter Anestesi</th>
                                            <th>Ruangan Asal</th>
                                            <th>Jam mulai</th>
                                            <th>Jam selesai</th>
                                            <th>Diagnosa</th>
                                            <th>Jumlah Pasien</th>
                                            <th width="20%">Aksi</th>

                                        </tr>
                                    </thead>
                                    
                                    <?php
                                    $no = 1;
                                    ?>
                                    <tbody>
                                    @if(\App\Models\Laporanibs::where('status',0)->where('id_pengawas',\Auth::user()->id)->first())
                                        @foreach(\App\Models\Laporanibsdetail::where('status',0)->where('id_pengawas',\Auth::user()->id)->get() as $data)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ \App\Models\Dokterirj::where('id',$data->id_dokter_operasi)->pluck('nama')->first() }}</td>
                                            <td>{{ \App\Models\Dokterirj::where('id',$data->id_dokter_anestesi)->pluck('nama')->first() }}</td>
                                            <td>{{ \App\Models\Ruangan::where('id',$data->id_ruangan)->pluck('nama_ruangan')->first() }}</td>
                                            <td>{{ $data->jam_mulai }}</td>
                                            <td>{{ $data->jam_selesai }}</td>
                                            <td>{{ $data->diagnosa }}</td>
                                            <td>{{ $data->jumlah_pasien }}</td>
                                            <td><button value="{{ $data->id }}" class="btn btn-sm btn-success btn-edit " data-dokteroperasi="{{$data->id_dokter_operasi}}" data-dokteranestesi="{{$data->id_dokter_anestesi}}" data-ruangan="{{$data->id_ruangan}}" data-jammulai="{{$data->jam_mulai}}" data-jamselesai="{{$data->jam_selesai}}" data-diagnosa="{{$data->diagnosa}}" data-jumlahpasien="{{$data->jumlah_pasien}}" data-toggle="modal" data-target="#editibs">Ubah</button>
                                            <button value="{{ $data->id }}" class="btn btn-sm btn-danger btn-hapus ">Hapus</button>
                                                
                                            </td>

                                        </tr>
                                        <?php
                                        $no++;
                                        ?>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                        </tr>
                                    @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                 
                    <form method="post" action="{{ route('editDraftlaporanIBS') }}" id="editdraftibs" role="form">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <input type="hidden" name="hitungketeranganibs" id="hitungketeranganibs" value="{{\App\Models\Laporanibsdetail::where('status',0)->where('id_pengawas',\Auth::user()->id)->count()}}">
                    <input type="hidden"  name="idibs" value="{{\App\Models\Laporanibs::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('id')->first()}}">
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Catatan IBS untuk Dinas Berikutnya</label>
                                <textarea class="form-control  z-depth-1" name="ibs_catatan" id="ibs_catatan" rows="3" readonly>{{\App\Models\Laporanibs::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('catatan')->first()}}</textarea>
                            </div>
                            
                        
                        </div>
                    </div>

                    </form>
                    <div class="row">
                        <div class="col-lg-12">
                         
                            <div class="form-group">
                                @if(\App\Models\Laporanibs::where('status',0)->where('id_pengawas',\Auth::user()->id)->first())
                                
                                <a href="{{ route('deleteDraftlaporanIBS',\App\Models\Laporanibs::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('id')->first()) }}" id="batalibs" style="float:right;" class="btn btn-sm btn-danger my-3 ml-2">Batalkan Laporan</a>
                                <button style="float:right" id="editibslaporan" class="btn btn-sm btn-edit-ibs btn-success my-3" >Ubah Laporan</button>
                                <button style="float:right;display:none" id="batalperubahanibs"  class="btn btn-sm btn-batal-ibs btn-danger my-3 ml-2" >Batalkan Perubahan</button>
                                <button style="float:right;display:none" id="simpanibs"  class="btn btn-sm btn-simpan-ibs btn-primary my-3" type="submit"  >Simpan Laporan</button>
                                @endif

                             
                            </div>
                        

                        </div>
                    </div>
            </div>
        </div>
    </div>

   


    <!-- cek dinas pagi sore dan tidak hari libur || cek hari libur custom IRJ buka-->
    @if (strtotime($nowTime) > strtotime($start) && strtotime($nowTime) < strtotime($end)  && $t->check() != true || strtotime($nowTime) > strtotime($start) && strtotime($nowTime) < strtotime($end) && $t->is_holiday() == true && \App\Models\Irjbuka::where('tanggal',$hariini)->first())
    <!-- IRJ -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseIRJ" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseIRJ">
            
        @if(\App\Models\Laporanirj::where('status',0)->where('id_pengawas',\Auth::user()->id)->first())
        <h6 class="m-0 font-weight-bold ">Instalasi Rawat Jalan (IRJ) <span style="color:green;font-size:14px">(sudah dikunjungi)</span></h6>
                @else
                <h6 class="m-0 font-weight-bold ">Instalasi Rawat Jalan (IRJ)</h6>
                @endif
        
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse " id="collapseIRJ">
            <div class="card-body">
                <!-- Content Row -->
                
                    
                    <div class="row ">
                    <div class="col-lg-12 tableketerangan">
                    @if(\App\Models\Laporanirj::where('status',0)->where('id_pengawas',\Auth::user()->id)->first())
                    <div class="row">
                        <div class="col-md-4">
                            <button class="btn btn-primary btn-md" data-toggle="modal" data-target="#tambah">Tambah Keterangan</button>
                            <br>
                        </div>
                    </div>
                    @endif
                    <br>
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
                                        @if(\App\Models\Laporanirj::where('status',0)->where('id_pengawas',\Auth::user()->id)->first())
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
                                        @else
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                        </tr>

                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <form method="post" action="{{ route('editDraftlaporanIRJ') }}" id="editdraftirj" role="form">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-lg-12">
                        <input type="hidden" name="hitungketerangan" id="hitungketerangan" value="{{\App\Models\Laporanirjdetail::where('status',0)->where('id_pengawas',\Auth::user()->id)->count()}}">
                        <input type="hidden"  name="id" value="{{\App\Models\Laporanirj::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('id')->first()}}">
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Masalah</label>
                                <textarea class="form-control  z-depth-1" name="irj_masalah" id="irj_masalah" rows="3" readonly> {{\App\Models\Laporanirj::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('masalah')->first()}}</textarea>
                            </div>
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Langkah atasi masalah</label>
                                <textarea class="form-control" name="irj_langkah" id="irj_langkah" rows="3" placeholder="" readonly>{{\App\Models\Laporanirj::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('langkah_atasi_masalah')->first()}}</textarea>
                            </div>
                            
                        

                        </div>
                    </div>



                </form>
                <div class="row">
                        <div class="col-lg-12">
                         
                            <div class="form-group">
                                @if(\App\Models\Laporanirj::where('status',0)->where('id_pengawas',\Auth::user()->id)->first())
                                
                                <a href="{{ route('deleteDraftlaporanIRJ',\App\Models\Laporanirj::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('id')->first()) }}" id="batalirj" style="float:right;" class="btn btn-sm btn-danger my-3 ml-2">Batalkan Laporan</a>
                                <button style="float:right" id="editirj" class="btn btn-sm btn-edit-igd btn-success my-3" >Ubah Laporan</button>
                                <button style="float:right;display:none" id="batalperubahanirj"  class="btn btn-sm btn-edit-igd btn-danger my-3 ml-2" >Batalkan Perubahan</button>
                                <button style="float:right;display:none" id="simpanirj"  class="btn btn-sm btn-edit-igd btn-primary my-3" type="submit"  >Simpan Laporan</button>
                                @endif

                             
                            </div>
                        

                        </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    
    <div class="card shadow mb-4 ">
        @if(\App\Models\Laporanumum::where('id_pengawas',\Auth::user()->id)->where('status',0)->count() < \App\Models\Ruangan::where('status',1)->count() && \App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->first() || \App\Models\Laporanumum::where('id_pengawas',\Auth::user()->id)->where('status',0)->count() == 0 && \App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->count() == 0 || strtotime($nowTime) > strtotime($start) && strtotime($nowTime) < strtotime($end) && $t->check() != true && \App\Models\Laporanirj::where('id_pengawas',\Auth::user()->id)->where('status',0)->count() == 0 || strtotime($nowTime) > strtotime($start) && strtotime($nowTime) < strtotime($end) && $t->is_holiday() == true && \App\Models\Irjbuka::where('tanggal',$hariini)->first() && \App\Models\Laporanirj::where('id_pengawas',\Auth::user()->id)->where('status',0)->count() == 0 && \App\Models\Laporanibs::where('status',0)->where('id_pengawas',\Auth::user()->id)->first())
            
            <div class="card-body">
                <p style="color:red">* kunjungi semua ruangan dahulu agar bisa tanda tangan dan kirim laporan</p>
                <div class="row">
                    <form method="post" action="#" class="col-lg-6" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label style="color:#000;font-weight:600"> Dinas </label>
                                <select class="form-control select2" disabled>
                                    <option value="" selected disabled hidden>Pilih Dinas</option>
                                    @foreach(\App\Models\Dinas::all() as $dk)
                                    <option value="{{ $dk->id }}">{{ strtoupper($dk->dinas) }}</option>

                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="form-group">
                                <label style="color:#000;font-weight:600"> Tanda Tangan {{\Auth::user()->nama}}</label>
                                <br />
                                <div style="  background-color: #eaecf4;width: 100%;height: 200px;border-radius:.35rem"></div>
                                <br />
                                <button id="clear" class="btn btn-danger btn-sm" disabled>Hapus Tanda Tangan</button>
                                <textarea id="" style="display: none" required></textarea>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" disabled>
                                <label class="form-check-label" for="exampleCheck1">Saya bertanggung jawab atas laporan ini  dan sudah memastikan bahwa semua data yang diinputkan sudah benar.</label>
                            </div>
                            <div class="form-group">
                                    <button type="submit" class="btn btn-lg btn-primary my-3" disabled>Kirim Laporan</button>
                            </div>
                        </div>
                    
                        
                    </form>
                    
                </div>
            </div>
            
        @else
    
                <div class="card-body">
                    <div class="row">
                        <form method="post" action="{{ route('kirimLaporan') }}" class="col-lg-6" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label style="color:#000;font-weight:600"> Dinas </label>
                                    <select class="form-control select2" name="dinas" id="dinas" required>
                                        <option value="" selected disabled hidden>Pilih Dinas</option>
                                        @foreach(\App\Models\Dinas::all() as $dk)
                                        <option value="{{ $dk->id }}">{{ strtoupper($dk->dinas) }}</option>

                                        @endforeach
                                    </select>
                                </div>
                            
                                <div class="form-group">
                                    <label style="color:#000;font-weight:600"> Tanda Tangan {{\Auth::user()->nama}}</label>
                                    <br />
                                    <div id="sig"></div>
                                    <br />
                                    <button id="clear" class="btn btn-danger btn-sm">Hapus Tanda Tangan</button>
                                    <textarea id="signature64" name="signed" style="display: none" required></textarea>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                                    <label class="form-check-label" for="exampleCheck1">Saya bertanggung jawab atas laporan ini dan sudah memastikan bahwa semua data yang diinputkan sudah benar.</label>
                                </div>
                                <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-kirim btn-primary my-3" >Kirim Laporan</button>
                                </div>
                            </div>
                        
                            
                        </form>
                        
                    </div>
                </div>
          
        @endif

    </div>




</div>
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
                            @if(!\App\Models\Laporanirjdetail::where('id_pengawas',\Auth::user()->id)->where('status',0)->where('id_dokter_irj',$mb->id)->first())
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endif
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
<!-- IBS -->

<div id="tambahibs" class="modal fade" role="dialog">
    <div class="modal-dialog">


        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                Tambah Keterangan Jumlah Pasien IBS
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="" id="tambahketeranganibs" role="form">
                {{ csrf_field() }}
                    <div class="form-group">
                        <label>Dokter Operasi: </label><br>
                        <select class="form-control select2" name="id_dokter_operasi" id="id_dokter_operasi" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Dokter Anestesi: </label><br>
                        <select class="form-control select2" name="id_dokter_anestesi" id="id_dokter_anestesi" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Ruangan Asal: </label><br>
                        <select class="form-control select2" name="id_ruangan" id="id_ruangan" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Ruangan</option>
                            @foreach(\App\Models\Ruangan::where('status',1)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama_ruangan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jam Mulai: </label>
                        <input type="time" class="form-control" name="jam_mulai" required />
                    </div>
                    <div class="form-group">
                        <label>Jam Selesai: </label>
                        <input type="time" class="form-control" name="jam_selesai" required />
                    </div>
                    <div class="form-group">
                        <label>Diagnosa: </label>
                        <textarea class="form-control" name="diagnosa" rows="3" placeholder="Tulis disini..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Pasien : </label>
                        <input type="number" class="form-control" name="jumlah_pasien" required />
                    </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-primary btn-tambahibs">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>


<div id="editibs" class="modal fade" role="dialog">
    <div class="modal-dialog">


        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                Ubah Keterangan Jumlah Pasien IBS
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="" id="editketeranganibs" role="form">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                    <input type="hidden" class="txtidibs" name="idibs">
                    <div class="form-group">
                        <label>Dokter Operasi: </label><br>
                        <select class="form-control select2 txt-operasi" name="id_dokter_operasi2" id="id_dokter_operasi2" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Dokter Anestesi: </label><br>
                        <select class="form-control select2 txt-anestesi" name="id_dokter_anestesi2" id="id_dokter_anestesi2" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Ruangan Asal: </label><br>
                        <select class="form-control select2 txt-ruangan" name="id_ruangan2" id="id_ruangan2" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Ruangan</option>
                            @foreach(\App\Models\Ruangan::where('status',1)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama_ruangan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jam Mulai: </label>
                        <input type="time" class="form-control txt-mulai" name="jam_mulai2" required />
                    </div>
                    <div class="form-group">
                        <label>Jam Selesai: </label>
                        <input type="time" class="form-control txt-selesai" name="jam_selesai2" required />
                    </div>
                    <div class="form-group">
                        <label>Diagnosa: </label>
                        <textarea class="form-control txt-diagnosa" name="diagnosa2" rows="3" placeholder="Tulis disini..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Pasien : </label>
                        <input type="number" class="form-control txt-jumlah" name="jumlah_pasien2" required />
                    </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-primary btn-simpanibs">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    var sig = $("#sig").signature({
        syncField: "#signature64",
        syncFormat: "PNG"
    });
    $('#clear').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature64").val('');
    });
</script>
<!-- /.container-fluid -->
@stop
@section('custom_script')
<script>

$(function(){
       $("input").prop('required',true);
});



$("#dataTable").DataTable({
    "pageLength": 5,
    "ordering" : false,
    "dom": 'rtip'
    });
$("#dataTable2").DataTable({
    "pageLength": 5,
    "ordering" : false,
    lengthMenu: [[5], [5]]
    });
//IGD EDIT dan HAPUS

    $("#bataligd").on('click', function(e) {
        var conf = confirm('apakah anda yakin ingin membatalkan laporan IGD ini ?');
        if (conf == false) {
            e.preventDefault();
        }
    });

    $("#editigd").on('click', function(e) {
        document.getElementById('simpanigd').style.display = 'block'; 
        document.getElementById('batalperubahanigd').style.display = 'block'; 
        document.getElementById('bataligd').style.display = 'none'; 
        this.style.display = 'none';
        document.getElementById("igd_pasien").readOnly = false;
        document.getElementById("igd_pasien_rawat").readOnly = false;
        document.getElementById("igd_pasien_emergency").readOnly = false;
        document.getElementById("igd_pasien_tidak_rawat").readOnly = false;
        document.getElementById("igd_pasien_doa").readOnly = false;
        // SISRUTE
        document.getElementById("igd_pasien_sisrute").readOnly = false;
        document.getElementById("igd_pasien_sisrute_diterima").readOnly = false;
        
        document.getElementById("igd_alasan").readOnly = false;
        document.getElementById("igd_permasalahan").readOnly = false;
        document.getElementById("igd_lainlain").readOnly = false;
        document.getElementById("igd_dokterjaga").disabled = false;
    });

    $("#simpanigd").on('click', function(e) {
        var conf = confirm('apakah anda yakin ingin menyimpan perubahan laporan IGD ini ?');
        if (conf == false) {
            e.preventDefault();
        }
        else{
           
            a = $("#igd_pasien").val();
            b = $("#igd_pasien_rawat").val();
            c = $("#igd_pasien_emergency").val();
            d = $("#igd_pasien_tidak_rawat").val();
            e = $("#igd_pasien_doa").val();
            f = $("#igd_dokterjaga").val();
            g = $("#igd_pasien_sisrute").val();
            h = $("#igd_pasien_sisrute_diterima").val();
            

            if (a == "" || b == "" || c == "" || d == "" || e == "" || f == "" || g == "" || h == "") {
            alert("lengkapi data terlebih dahulu");
            
            }
            else{
                document.getElementById("editdraftigd").submit();
                e.preventDefault();
            }
        }
           
        
    });

  
    $("#batalperubahanigd").on('click', function(e) {
        var conf = confirm('apakah anda yakin ingin membatalkan perubahan laporan IGD ini ?');
        if (conf == false) {
            e.preventDefault();
        }
        else{
            location.reload();

        }
    });



//IRJ EDIT dan HAPUS

$("#editirj").on('click', function(e) {
        document.getElementById('simpanirj').style.display = 'block'; 
        document.getElementById('batalperubahanirj').style.display = 'block'; 
        document.getElementById('batalirj').style.display = 'none'; 
        this.style.display = 'none';
        document.getElementById("irj_masalah").readOnly = false;
        document.getElementById("irj_langkah").readOnly = false;

    });

    $("#simpanirj").on('click', function(e) {
        var conf = confirm('apakah anda yakin ingin menyimpan perubahan laporan IRJ ini ?');
        if (conf == false) {
            e.preventDefault();
        }
        else{
           
            a = $("#hitungketerangan").val();
            if(a > 0){
                document.getElementById("editdraftirj").submit();
                e.preventDefault();
            }
            else{
                alert('Jumlah pasien menurut Dokter masih kosong, silahkan isi terlebih dahulu')
            }
            
        }
           
        
    });

    $("#batalirj").on('click', function(e) {
        var conf = confirm('apakah anda yakin ingin membatalkan laporan IRJ ini ?');
        if (conf == false) {
            e.preventDefault();
        }
    });

    $("#batalperubahanirj").on('click', function(e) {
        var conf = confirm('apakah anda yakin ingin membatalkan perubahan laporan IRJ ini ?');
        if (conf == false) {
            e.preventDefault();
        }
        else{
            location.reload();

        }
    });

    //IBS EDIT dan HAPUS

$("#editibslaporan").on('click', function(e) {
        document.getElementById('simpanibs').style.display = 'block'; 
        document.getElementById('batalperubahanibs').style.display = 'block'; 
        document.getElementById('batalibs').style.display = 'none'; 
        this.style.display = 'none';
        document.getElementById("ibs_catatan").readOnly = false;

    });

    $("#simpanibs").on('click', function(e) {
        var conf = confirm('apakah anda yakin ingin menyimpan perubahan laporan IBS ini ?');
        if (conf == false) {
            e.preventDefault();
        }
        else{
           
            a = $("#hitungketeranganibs").val();
            if(a > 0){
                document.getElementById("editdraftibs").submit();
                e.preventDefault();
            }
            else{
                alert('Jumlah pasien menurut Dokter IBS masih kosong, silahkan isi terlebih dahulu')
            }
            
        }
           
        
    });

    $("#batalibs").on('click', function(e) {
        var conf = confirm('apakah anda yakin ingin membatalkan laporan IBS ini ?');
        if (conf == false) {
            e.preventDefault();
        }
    });

    $("#batalperubahanibs").on('click', function(e) {
        var conf = confirm('apakah anda yakin ingin membatalkan perubahan laporan IBS ini ?');
        if (conf == false) {
            e.preventDefault();
        }
        else{
            location.reload();

        }
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

    function igd6a() {
        document.getElementById("gbr_igd_pasien_pulang").setAttribute('src', '{{asset('sb-admin/icon/warna/igd/pasien-pulang.png')}}');
    }

    function igd6b() {
        document.getElementById("gbr_igd_pasien_pulang").setAttribute('src', '{{asset('sb-admin/icon/igd/pasien-pulang.png')}}');
    }

    function igd7a() {
        document.getElementById("gbr_igd_pasien_non_emergency").setAttribute('src', '{{asset('sb-admin/icon/warna/igd/pasien-non-emergency.png')}}');
    }

    function igd7b() {
        document.getElementById("gbr_igd_pasien_non_emergency").setAttribute('src', '{{asset('sb-admin/icon/igd/pasien-non-emergency.png')}}');
    }

    function igd8a() {
        document.getElementById("gbr_igd_pasien_sisrute").setAttribute('src', '{{asset('sb-admin/icon/warna/igd/sisrute.png')}}');
    }

    function igd8b() {
        document.getElementById("gbr_igd_pasien_sisrute").setAttribute('src', '{{asset('sb-admin/icon/igd/sisrute.png')}}');
    }

    function igd9a() {
        document.getElementById("gbr_igd_pasien_sisrute_diterima").setAttribute('src', '{{asset('sb-admin/icon/warna/igd/sisrute-terima.png')}}');
    }

    function igd9b() {
        document.getElementById("gbr_igd_pasien_sisrute_diterima").setAttribute('src', '{{asset('sb-admin/icon/igd/sisrute-terima.png')}}');
    }

    function igd10a() {
        document.getElementById("gbr_igd_pasien_sisrute_ditolak").setAttribute('src', '{{asset('sb-admin/icon/warna/igd/sisrute-tolak.png')}}');
    }

    function igd10b() {
        document.getElementById("gbr_igd_pasien_sisrute_ditolak").setAttribute('src', '{{asset('sb-admin/icon/igd/sisrute-tolak.png')}}');
    }
</script>
<!-- IRJ -->
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
            //$("#edit").modal('hide');
        }
        else{
            //$("#edit").modal('hide');
            
            var x = parseInt($("#hitungketerangan").val()) - 1;
            $("#hitungketerangan").val(x)

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
                alert(response.message) //Message come from controller
            }
        },
        error:function(error){
            console.log(error)
        }
        });
});

$(".btn-tambah").click(function(e){

    $("#tambah").modal('hide');

    e.preventDefault();

    var id_dokter_irj = $("#id_dokter_irj :selected").val();
    var pasien_lama = $("input[name=pasien_lama]").val();
    var pasien_baru = $("input[name=pasien_baru]").val();

    var x = parseInt($("#hitungketerangan").val()) + 1;
    $("#hitungketerangan").val(x)




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
            alert(response.message) 
        }
    },
    error:function(error){
        console.log(error)
    }
    });

});

</script>

<script>
$("#inap_ruangan").change(function(){
  
     $(".tablelaporan").html("<h1>Mohon Tunggu...</h1>")
     $.ajax({
       type : "get",
       url : 'refresh-laporan-umum/'+$("#inap_ruangan").val(),
        data: {ruangan: $("#inap_ruangan").val()},
       success : function(data){
         console.log(data);
         $(".tablelaporan").html(data);
       }
     });
   

});

$(".btn-kirim").click(function(){
    // var conf = confirm('Apakah anda yakin ingin setujui laporan ini ?');
    //     if (conf == false) {
    //         e.preventDefault();
    //     }
    // });
    if(document.getElementById("signature64").value == '')
    {
        alert("Tanda tangan tidak boleh kosong");
       
    }
});
</script>
<!-- IBS -->

<script>
    $("#dataTable2").on('click', '.btn-edit', function() {
        idibs = $(this).val(); //laporan ibs detail
        dokteroperasi = $(this).data('dokteroperasi');
        dokteranestesi = $(this).data('dokteranestesi');
        ruangan = $(this).data('ruangan');
        jammulai = $(this).data('jammulai');
        jamselesai = $(this).data('jamselesai');
        diagnosa = $(this).data('diagnosa');
        jumlahpasien = $(this).data('jumlahpasien');

    });
    $('#editibs').on('show.bs.modal', function() {
        $(".txtidibs").val(idibs);
        $(".txt-operasi").select2().val(dokteroperasi).trigger("change");
        $(".txt-anestesi").select2().val(dokteranestesi).trigger("change");
        $(".txt-ruangan").select2().val(ruangan).trigger("change");
        $(".txt-mulai").val(jammulai);
        $(".txt-selesai").val(jamselesai);
        $(".txt-diagnosa").val(diagnosa);
        $(".txt-jumlah").val(jumlahpasien);
    });

    $("#dataTable2").on('click', '.btn-hapus', function(e) {
        id = $(this).val(); 
        var conf = confirm('apakah anda yakin ingin menghapus data ini ?');
        if (conf == false) {
            e.preventDefault();
            // $("#edit").modal('hide');
        }
        else{
            // $("#edit").modal('hide');
            var x = parseInt($("#hitungketeranganibs").val()) - 1;
            $("#hitungketeranganibs").val(x)
            console.log(id);
            var url = 'deleteibsdetail';

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
                            url : 'refresh-ibs-detail/',
                            data: { "_token": "{{ csrf_token() }}",},
                            success : function(data){
                            //console.log(data);
                            $(".tableketeranganibs").html(data);
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

    
</script>
<script>


$(".btn-tambahibs").click(function(e){

    $("#tambahibs").modal('hide');

    e.preventDefault();

    var id_dokter_operasi = $("#id_dokter_operasi :selected").val();
    var id_dokter_anestesi = $("#id_dokter_anestesi :selected").val();
    var id_ruangan = $("#id_ruangan :selected").val();
    var jam_mulai = $("input[name=jam_mulai]").val();
    var jam_selesai = $("input[name=jam_selesai]").val();
    var diagnosa = $("textarea[name=diagnosa]").val();
    var jumlah_pasien = $("input[name=jumlah_pasien]").val();

    var x = parseInt($("#hitungketeranganibs").val()) + 1;
    $("#hitungketeranganibs").val(x)




    console.log(id_dokter_operasi+' '+ id_dokter_anestesi + ' '+ id_ruangan + ' '+ jam_mulai + ' '+ jam_selesai + ' '+ diagnosa + ' '+ jumlah_pasien);
    var url = 'tambahibsdetail';

    $.ajax({
    url:url,
    method:'POST',
    data:{
        _token: "{{ csrf_token() }}",
        id_dokter_operasi:id_dokter_operasi,
        id_dokter_anestesi:id_dokter_anestesi,
        id_ruangan : id_ruangan,
        jam_mulai : jam_mulai,
        jam_selesai : jam_selesai,
        diagnosa : diagnosa,
        jumlah_pasien : jumlah_pasien
    },
    success:function(response){
        if(response.success){
            $("#id_dokter_operasi").val("");
            $("#id_dokter_anestesi").val("");
            $("#id_ruangan").val("");
            $("input[name=jam_mulai]").val("");
            $("input[name=jam_selesai]").val("");
            $("input[name=diagnosa]").val("");
            $("input[name=jumlah_pasien]").val("");
            alert(response.message) //Message come from controller
            $.ajax({
                type : "get",
                url : 'refresh-ibs-detail/',
                data: { "_token": "{{ csrf_token() }}",},
                success : function(data){
                //console.log(data);
                $(".tableketeranganibs").html(data);
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


// $(document).ready(function() {
//     $("#editketerangan").submit(function(e) {
 $(".btn-simpanibs").click(function(e){

        $("#editibs").modal('hide');

        e.preventDefault();


        var id2 = $("input[name=idibs]").val();
        var id_dokter_operasi2 = $("#id_dokter_operasi2 :selected").val();
        var id_dokter_anestesi2 = $("#id_dokter_anestesi2 :selected").val();
        var id_ruangan2 = $("#id_ruangan2 :selected").val();
        var jam_mulai2 = $("input[name=jam_mulai2]").val();
        var jam_selesai2 = $("input[name=jam_selesai2]").val();
        var diagnosa2 = $("textarea[name=diagnosa2]").val();
        var jumlah_pasien2 = $("input[name=jumlah_pasien2]").val();


        console.log(id_dokter_operasi2+' '+ id_dokter_anestesi2 + ' '+ id_ruangan2 + ' '+ jam_mulai2 + ' '+ jam_selesai2 + ' '+ diagnosa2 + ' '+ jumlah_pasien2);
        var url = 'editibsdetail';

        $.ajax({
        url:url,
        method:'PUT',
        data:{
            _token: "{{ csrf_token() }}",
            id:id2,
            id_dokter_operasi:id_dokter_operasi2,
            id_dokter_anestesi:id_dokter_anestesi2,
            id_ruangan : id_ruangan2,
            jam_mulai : jam_mulai2,
            jam_selesai : jam_selesai2,
            diagnosa : diagnosa2,
            jumlah_pasien : jumlah_pasien2
        },
        success:function(response){
            if(response.success == true){
                
                alert(response.message) //Message come from controller
                $.ajax({
                    type : "get",
                    url : 'refresh-ibs-detail/',
                    data: { "_token": "{{ csrf_token() }}",},
                    success : function(data){
                    //console.log(data);
                    $(".tableketeranganibs").html(data);
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