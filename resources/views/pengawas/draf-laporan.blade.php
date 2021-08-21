@extends('master.masterpengawas')
@section('custom_style')
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>

<link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">

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
                <form method="post" action="#" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row ">
                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body" onmouseover="igd1a();" onmouseout="igd1b();">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien" autocomplete="off" value="{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien')->first()}}" readonly />

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
                                                <input type="number" class="form-control" name="igd_pasien_rawat" autocomplete="off" value="{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_rawat')->first()}}" readonly />

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
                                <div class="card-body" onmouseover="igd3a();" onmouseout="igd3b();">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien emergency</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien_emergency" autocomplete="off" value="{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_emergency')->first()}}" readonly />

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
                                <div class="card-body" onmouseover="igd4a();" onmouseout="igd4b();">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien Tidak bisa dirawat</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien_tidak_rawat" autocomplete="off" value="{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_tidak_bisa_rawat')->first()}}" readonly />

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

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien Death on arrival (DOA)</div>
                                            <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                                                <input type="number" class="form-control" name="igd_pasien_doa" autocomplete="off" value="{{\App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_doa')->first()}}" readonly />

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
                                <button type="submit" style="float:right" class="btn btn-sm btn-delete-igd btn-danger my-3 ml-2" >Batalkan Laporan</button>
                                <button type="submit" style="float:right" class="btn btn-sm btn-edit-igd btn-success my-3" >Ubah Laporan</button>
                                
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
        <form method="post" action="#" enctype="multipart/form-data">
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
                                <select class="form-control select2" name="inap_ruangan" id="inap_ruangan" required>
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
        </form>
    </div>
    <div class="card shadow mb-4 ">
        @if(\App\Models\Laporanumum::where('id_pengawas',\Auth::user()->id)->where('status',0)->count() < \App\Models\Ruangan::where('status',1)->count() && \App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->first() || \App\Models\Laporanumum::where('id_pengawas',\Auth::user()->id)->where('status',0)->count() == 0 && \App\Models\Laporanigd::where('status',0)->where('id_pengawas',\Auth::user()->id)->count() == 0)
        <div class="card-body">
            <p style="color:red">* kunjungi semua ruangan dahulu agar bisa tanda tangan dan kirim laporan</p>
            <div class="row">
                <form method="post" action="#" class="col-lg-4" enctype="multipart/form-data">
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
                            <label class="form-check-label" for="exampleCheck1">Saya bertanggung jawab atas laporan ini</label>
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
                <form method="post" action="{{ route('kirimLaporan') }}" class="col-lg-4" enctype="multipart/form-data">
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
                            <label class="form-check-label" for="exampleCheck1">Saya bertanggung jawab atas laporan ini</label>
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


@stop