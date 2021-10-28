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
<script type="text/javascript" >
        var msg = '{{Session::get('fail-add')}}';
        alert(msg);
    </script>
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
                                        <div class="col-md-10 ">
                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">Total Kunjungan Pasien</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien" onfocus="igd1a();" onfocusout="igd1b();" autocomplete="off" required />

                                            </div>
                                        </div>
                                        <div class="col-md-2">
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
                                        <div class="col-md-10">
                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien rawat</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien_rawat" onfocus="igd2a();" onfocusout="igd2b();"  autocomplete="off" required />

                                            </div>
                                        </div>
                                        <div class="col-md-2">
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
                                        <div class="col-md-10">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien emergency</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien_emergency" onfocus="igd3a();" onfocusout="igd3b();"  autocomplete="off" required />

                                            </div>
                                        </div>
                                        <div class="col-md-2">
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
                                        <div class="col-md-10">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien Rujuk dan Tolak Rawat</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien_tidak_rawat" onfocus="igd4a();" onfocusout="igd4b();"  autocomplete="off" required />

                                            </div>
                                        </div>
                                        <div class="col-md-2">
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
                                        <div class="col-md-10">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien "DOA" dan pasien meninggal</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien_doa" onfocus="igd5a();" onfocusout="igd5b();"  autocomplete="off" required />

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                        <img src="{{asset('sb-admin/icon/igd/pasien-doa.png')}}" id="gbr_igd_pasien_doa" height="64px" width="64px">
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
                                        <div class="col-md-10">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Rujukan Sisrute</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien_sisrute" onfocus="igd6a();" onfocusout="igd6b();"  autocomplete="off" required />

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                        <img src="{{asset('sb-admin/icon/igd/sisrute.png')}}" id="gbr_igd_pasien_sisrute" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-md-10">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Rujukan Sisrute yang diterima</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien_sisrute_diterima" onfocus="igd7a();" onfocusout="igd7b();"  autocomplete="off" required />

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                        <img src="{{asset('sb-admin/icon/igd/sisrute-terima.png')}}" id="gbr_igd_pasien_sisrute_diterima" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Alasan pasien rujuk dan tolak rawat</label>
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
                                <select class="form-control select2" name="inap_ruangan" id="inap_ruangan" style="width: 100%" required>
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
                    <div class="row">
                        <div class="col-md-12 tablelaporan">

                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
    @endif


    @if(\App\Models\Laporanibs::where('status',0)->where('id_pengawas',\Auth::user()->id)->first())
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseIBS2" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseIBS2">
            <h6 class="m-0 font-weight-bold ">Instalasi Bedah Sentral (IBS) <span style="color:green;font-size:14px">(sudah dikunjungi) </span> <span style="font-size:14px;color:#858796;font-weight:400;float: right;">ubah data di Draf Laporan ...</span> </h6>
            
        </a>
    </div>
    @else
    <!-- Collapsable Card Example -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseIBS" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseIBS">
            <h6 class="m-0 font-weight-bold ">Instalasi Bedah Sentral (IBS)</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse " id="collapseIBS">
            <div class="card-body">
                <!-- Content Row -->
                
                   
                    <div class="row ">
                        <div class="col-lg-12 tableketeranganibs">
                            <div class="row">
                                <div class="col-md-4">
                                    <button class="btn btn-primary btn-md" data-toggle="modal" data-target="#tambahibs">Input Pasien</button>
                                    <br>
                                </div>
                            </div>
                            <br>
                           
                            <h6 style="color:red"><b>Total Pasien (IBS) : {{ \App\Models\Laporanibsdetail::where('status',0)->where('id_pengawas',\Auth::user()->id)->count() }} orang</b></h6>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama <br> (RM)</th>
                                            <th>Dokter Operasi</th>
                                            <th>Dokter Anestesi</th>
                                            <th>Pendamping</th>
                                            <th>Ruangan Asal</th>
                                            <th>Jam mulai</th>
                                            <th>Jam selesai</th>
                                            <th>Diagnosa Pre</th>
                                            <th>Diagnosa Post</th>
                                            <th width="20%">Aksi</th>

                                        </tr>
                                    </thead>
                                    
                                    <?php
                                    $no = 1;
                                    ?>
                                    <tbody>
                                        @foreach(\App\Models\Laporanibsdetail::where('status',0)->where('id_pengawas',\Auth::user()->id)->get() as $data)
                                        <?php
                                        $arrdokteroperasi = explode(',',$data->id_dokter_operasi);

                                        
                                        ?>
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $data->nama }}<br>({{ $data->rm }})</td>
                                            <td>
                                            @foreach($arrdokteroperasi as $key)  
                                                {{ \App\Models\Dokterirj::where('id',$key)->pluck('nama')->first() }}<br>    
                                            @endforeach

                                            </td>
                                            <td>{{ \App\Models\Dokterirj::where('id',$data->id_dokter_anestesi)->pluck('nama')->first() }}</td>
                                            <td>{{ $data->pendamping }}</td>
                                            <td>{{ \App\Models\Ruangan::where('id',$data->id_ruangan)->pluck('nama_ruangan')->first() }}</td>
                                            <td>{{ $data->jam_mulai }}</td>
                                            <td>{{ $data->jam_selesai }}</td>
                                            <td>{{ $data->diagnosa_pre }}</td>
                                            <td>{{ $data->diagnosa_post }}</td>
                                            <td><button value="{{ $data->id }}" class="btn btn-sm btn-success btn-edit " data-nama="{{ $data->nama }}" data-rm="{{ $data->rm }}" data-dokteroperasi="{{$data->id_dokter_operasi}}" data-dokteranestesi="{{$data->id_dokter_anestesi}}" data-pendamping="{{$data->pendamping}}" data-ruangan="{{$data->id_ruangan}}" data-jammulai="{{$data->jam_mulai}}" data-jamselesai="{{$data->jam_selesai}}" data-diagnosapre="{{$data->diagnosa_pre}}" data-diagnosapost="{{$data->diagnosa_post}}" data-toggle="modal" data-target="#editibs">Ubah</button>
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
                    <form method="post" action="{{ route('draftlaporanIBS') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Catatan IBS untuk Dinas Berikutnya</label>
                                <textarea class="form-control  z-depth-1" name="ibs_catatan" rows="3" placeholder="Tulis disini..."></textarea>
                            </div>
                            
                            
                          
                            <div class="form-group">
                                <button type="submit" style="float:right" class="btn btn-sm btn-ibs btn-primary my-3">Simpan ke Draf Laporan</button>

                            </div>
                        </div>
                    </div>



                </form>
            </div>
        </div>
    </div>

    @endif


    <!-- cek dinas pagi sore dan tidak hari libur || cek hari libur custom IRJ buka-->
    @if (strtotime($nowTime) > strtotime($start) && strtotime($nowTime) < strtotime($end) && $t->is_sunday() != true || strtotime($nowTime) > strtotime($start) && strtotime($nowTime) < strtotime($end) && $t->is_holiday() == true && \App\Models\Irjbuka::where('tanggal',$hariini)->first()) 
    
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
                
                   
                    <div class="row ">
                        <div class="col-lg-12 tableketerangan">
                            <div class="row">
                                <div class="col-md-4">
                                    <button class="btn btn-primary btn-md" data-toggle="modal" data-target="#tambah">Input Pasien</button>
                                    <br>
                                </div>
                            </div>
                            <br>
                            <h6 style="color:red"><b>Total Pasien (IRJ) : {{ \App\Models\Laporanirjdetail::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('pasien_total')->sum() }} orang</b></h6>

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
<!-- IBS -->

<div id="tambahibs" class="modal fade" role="dialog">
    <div class="modal-dialog">


        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                Input Pasien IBS
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="" id="tambahketeranganibs" role="form">
                {{ csrf_field() }}
                    <div class="form-group">
                        <label>Nama : </label>
                        <input type="text" class="form-control" name="nama"  />
                    </div>
                    <div class="form-group">
                        <label>RM : </label>
                        <input type="text" class="form-control" name="rm"  />
                    </div>
                    <div class="form-group">
                        <label>Dokter Operasi: </label><br>
                        <select multiple="multiple" class="form-control select2" name="id_dokter_operasi" id="id_dokter_operasi" style="width: 100%" data-placeholder="Pilih Dokter (Bisa lebih dari 1)" required>
                           
                            @foreach(\App\Models\Dokterirj::where('status',1)->where('id_sdmk_jenis','<>',3)->where('id_sdmk_jenis','<>',21)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Dokter Anestesi: </label><br>
                        <select class="form-control select2" name="id_dokter_anestesi" id="id_dokter_anestesi" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->where('id_sdmk_jenis',8)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pendamping / Petugas : </label>
                        <input type="text" class="form-control" name="pendamping"  />
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
                        <label>Jam Mulai : </label>
                        <input type="time" class="form-control" name="jam_mulai" required />
                    </div>
                    <div class="form-group">
                        <label>Jam Selesai : </label>
                        <input type="time" class="form-control" name="jam_selesai" required />
                    </div>
                    <div class="form-group">
                        <label>Diagnosa Pre : </label>
                        <textarea class="form-control" name="diagnosapre" rows="3" placeholder="Tulis disini..." required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Diagnosa Post : </label>
                        <textarea class="form-control" name="diagnosapost" rows="3" placeholder="Tulis disini..." required></textarea>
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
                Ubah Pasien IBS
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="" id="editketeranganibs" role="form">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                    <input type="hidden" class="txtidibs" name="idibs">
                    <div class="form-group">
                        <label>Nama : </label>
                        <input type="text" class="form-control txt-nama" name="nama2"  required/>
                    </div>
                    <div class="form-group">
                        <label>RM : </label>
                        <input type="text" class="form-control txt-rm" name="rm2"  required/>
                    </div>
                    <div class="form-group">
                        <label>Dokter Operasi: </label><br>
                        <select multiple="multiple" class="form-control select2 txt-operasi" name="id_dokter_operasi2" id="id_dokter_operasi2" style="width: 100%" required>
                            
                            @foreach(\App\Models\Dokterirj::where('status',1)->where('id_sdmk_jenis','<>',3)->where('id_sdmk_jenis','<>',21)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Dokter Anestesi: </label><br>
                        <select class="form-control select2 txt-anestesi" name="id_dokter_anestesi2" id="id_dokter_anestesi2" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->where('id_sdmk_jenis',8)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pendamping : </label>
                        <input type="text" class="form-control txt-pendamping" id="pendamping2" name="pendamping2"  />
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
                        <textarea class="form-control txt-diagnosapre" name="diagnosapre2" rows="3" placeholder="Tulis disini..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Diagnosa Post : </label>
                        <textarea class="form-control txt-diagnosapost" name="diagnosapost2" rows="3" placeholder="Tulis disini..." required></textarea>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-primary btn-simpanibs">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- IRJ -->
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
                            @if(!\App\Models\Laporanirjdetail::where('id_pengawas',\Auth::user()->id)->where('status',0)->where('id_dokter_irj',$mb->id)->first())
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Pasien Lama (Rekam Medis Lama): </label>
                        <input type="number" class="form-control" name="pasien_lama" required />
                    </div>
                    <div class="form-group">
                        <label>Jumlah Pasien Baru (Rekam Medis Baru): </label>
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
                        <label>Jumlah Pasien Lama (Rekam Medis Lama): </label>
                        <input type="number" class="form-control txtlama" name="pasien_lama2" required />
                    </div>
                    <div class="form-group">
                        <label>Jumlah Pasien Baru (Rekam Medis Baru): </label>
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
$("#dataTable2").DataTable({
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

    function igd6a() {
        document.getElementById("gbr_igd_pasien_sisrute").setAttribute('src', '{{asset('sb-admin/icon/warna/igd/sisrute.png')}}');
    }

    function igd6b() {
        document.getElementById("gbr_igd_pasien_sisrute").setAttribute('src', '{{asset('sb-admin/icon/igd/sisrute.png')}}');
    }

    function igd7a() {
        document.getElementById("gbr_igd_pasien_sisrute_diterima").setAttribute('src', '{{asset('sb-admin/icon/warna/igd/sisrute-terima.png')}}');
    }

    function igd7b() {
        document.getElementById("gbr_igd_pasien_sisrute_diterima").setAttribute('src', '{{asset('sb-admin/icon/igd/sisrute-terima.png')}}');
    }


    //Rawat Inap
    $("#inap_ruangan").change(function(){
  
        $(".tablelaporan").html("<h1>Mohon Tunggu...</h1>")
        $.ajax({
            type : "get",
            url : 'refresh-laporan-ruangan/'+$("#inap_ruangan").val(),
            data: {ruangan: $("#inap_ruangan").val()},
            success : function(data){
            console.log(data);
            $(".tablelaporan").html(data);
            }
        });


    });

    $("#editpasienlama").on('click', function(e) {

        document.getElementById("inap_pasien_lama").readOnly = false;
        
    });
    $("#inap_ruangan").change(function(){

        $(".jumlahpasienlama").html("<h3>Mohon Tunggu...</h3>")
        $.ajax({
            type : "get",
            url : 'refresh-jumlah-pasien-lama/'+$("#inap_ruangan").val(),
            data: {ruangan: $("#inap_ruangan").val()},
            success : function(data){
            console.log(data);
            $(".jumlahpasienlama").html(data);
            }
        });

    });


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

    function ranap13a() {
        document.getElementById("gbr_inap_pasien_pulang").setAttribute('src', '{{asset('sb-admin/icon/warna/igd/pasien-pulang.png')}}');
    }

    function ranap13b() {
        document.getElementById("gbr_inap_pasien_pulang").setAttribute('src', '{{asset('sb-admin/icon/igd/pasien-pulang.png')}}');
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
<!-- IBS -->

<script>
    $("#dataTable2").on('click', '.btn-edit', function() {
        idibs = $(this).val(); //laporan ibs detail
        nama = $(this).data('nama');
        rm = $(this).data('rm');
        dokteroperasi = $(this).data('dokteroperasi');

        if((typeof(dokteroperasi) == "string" &&  dokteroperasi.includes(","))){
            listdokteroperasi = dokteroperasi.split(',');
        }
        else{
            listdokteroperasi = dokteroperasi;
        }
        

        console.log(listdokteroperasi);
        dokteranestesi = $(this).data('dokteranestesi');
        pendamping = $(this).data('pendamping');
        ruangan = $(this).data('ruangan');
        jammulai = $(this).data('jammulai');
        jamselesai = $(this).data('jamselesai');
        diagnosapre = $(this).data('diagnosapre');
        diagnosapost = $(this).data('diagnosapost');

    });
    $('#editibs').on('show.bs.modal', function() {
        $(".txtidibs").val(idibs);
        $(".txt-nama").val(nama);
        $(".txt-rm").val(rm);
        $(".txt-operasi").select2().val(listdokteroperasi).trigger("change");
        $(".txt-anestesi").select2().val(dokteranestesi).trigger("change");
        $(".txt-ruangan").select2().val(ruangan).trigger("change");
        $(".txt-pendamping").val(pendamping);
        $(".txt-mulai").val(jammulai);
        $(".txt-selesai").val(jamselesai);
        $(".txt-diagnosapre").val(diagnosapre);
        $(".txt-diagnosapost").val(diagnosapost);
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
    var nama = $("input[name=nama]").val();
    var rm = $("input[name=rm]").val();
    var id_dokter_operasi = $('#id_dokter_operasi').val();
    var id_dokter_anestesi = $("#id_dokter_anestesi :selected").val();
    var id_ruangan = $("#id_ruangan :selected").val();
    var pendamping = $("input[name=pendamping]").val();
    var jam_mulai = $("input[name=jam_mulai]").val();
    var jam_selesai = $("input[name=jam_selesai]").val();
    var diagnosapre = $("textarea[name=diagnosapre]").val();
    var diagnosapost = $("textarea[name=diagnosapost]").val();

    var x = parseInt($("#hitungketeranganibs").val()) + 1;
    $("#hitungketeranganibs").val(x)




    console.log(nama +' '+rm+' '+id_dokter_operasi+' '+ id_dokter_anestesi + ' '+ pendamping + ' '+ id_ruangan + ' '+ jam_mulai + ' '+ jam_selesai + ' '+ diagnosapre + ' '+ diagnosapost);
    var url = 'tambahibsdetail';

    $.ajax({
    url:url,
    method:'POST',
    data:{
        _token: "{{ csrf_token() }}",
        nama:nama,
        rm:rm,
        id_dokter_operasi:id_dokter_operasi,
        id_dokter_anestesi:id_dokter_anestesi,
        pendamping:pendamping,
        id_ruangan : id_ruangan,
        jam_mulai : jam_mulai,
        jam_selesai : jam_selesai,
        diagnosapre : diagnosapre,
        diagnosapost : diagnosapost
    },
    success:function(response){
        if(response.success){
            $("input[name=nama]").val("");
            $("input[name=rm]").val("");
            $("#id_dokter_operasi").val("");
            $("#id_dokter_anestesi").val("");
            $("#id_ruangan").val("");
            $("input[name=jam_mulai]").val("");
            $("input[name=pendamping]").val("");
            $("input[name=jam_selesai]").val("");
            $("input[name=diagnosapre]").val("");
            $("input[name=diagnosapost]").val("");
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
        var nama2 = $("input[name=nama2]").val();
        var rm2 = $("input[name=rm2]").val();
        var id_dokter_operasi2 = $('#id_dokter_operasi2').val();
        var id_dokter_anestesi2 = $("#id_dokter_anestesi2 :selected").val();
        var id_ruangan2 = $("#id_ruangan2 :selected").val();
        var pendamping2 = $("input[name=pendamping2]").val();
        var jam_mulai2 = $("input[name=jam_mulai2]").val();
        var jam_selesai2 = $("input[name=jam_selesai2]").val();
        var diagnosapre2 = $("textarea[name=diagnosapre2]").val();
        var diagnosapost2 = $("textarea[name=diagnosapost2]").val();


        console.log(nama +' '+rm+' '+id_dokter_operasi2+' '+ id_dokter_anestesi2 + ' '+ pendamping2 + ' '+ id_ruangan2 + ' '+ jam_mulai2 + ' '+ jam_selesai2 + ' '+ diagnosapre2 + ' '+ diagnosapost2);
        var url = 'editibsdetail';

        $.ajax({
        url:url,
        method:'PUT',
        data:{
            _token: "{{ csrf_token() }}",
            id:id2,
            nama:nama2,
            rm:rm2,
            id_dokter_operasi:id_dokter_operasi2,
            id_dokter_anestesi:id_dokter_anestesi2,
            pendamping:pendamping2,
            id_ruangan : id_ruangan2,
            jam_mulai : jam_mulai2,
            jam_selesai : jam_selesai2,
            diagnosapre : diagnosapre2,
            diagnosapost : diagnosapost2
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
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>


@stop