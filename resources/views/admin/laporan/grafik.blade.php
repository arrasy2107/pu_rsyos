@extends('master.masteradmin')

@section('content')
@if (Session::has('success-add'))
<div class="alert alert-success alert-call">
    <p>{{ Session::get('success-add') }}</p>
</div>
@endif
@if (Session::has('success-edit'))
<div class="alert alert-success alert-call2">
    <p>{{ Session::get('success-edit') }}</p>
</div>
@endif
@if (Session::has('success-delete'))
<div class="alert alert-success alert-call3">
    <p>{{ Session::get('success-delete') }}</p>
</div>
@endif
@if (Session::has('fail-delete'))
<div class="alert alert-danger alert-call4">
    <p>{{ Session::get('fail-delete') }}</p>
</div>
@endif

<?php

use Carbon\Carbon;
use Carbon\CarbonPeriod;



setlocale(LC_TIME, 'id_ID');
\Carbon\Carbon::setLocale('id');
\Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");


//$period = CarbonPeriod::create('2021-09-01', '2021-09-30');
$from = \Carbon\Carbon::createFromFormat('Y-m-d', '2021-09-01');
$to = \Carbon\Carbon::createFromFormat('Y-m-d', '2021-09-30');

$period = new CarbonPeriod($from, '1 day', $to);


// Years range setup
$currentDateTime = Carbon::now();
$newDateTime = Carbon::now()->subYears(5);

?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Grafik Laporan Pasien / Bulan</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tahun"><b>Tahun</b></label>
                        <select id="tahun" name="tahun" class="form-control select2">
                            <option value="0">Pilih Tahun</option>
                            @foreach (range($currentDateTime->year, $newDateTime->year) as $year)
                            <option value="{{$year}}">{{$year}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="bulan">Bulan</label>
                        <select id="bulan" name="bulan" class="form-control select2">
                            <option value="0">Pilih Bulan</option>

                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="color:transparent">cari</label><br>
                        <button class="btn btn-primary btn-lihat-jadwal" type="submit">Lihat Grafik</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 tablejadwal">
                    
                </div>
            </div>


        </div>
    </div>

</div>
<div id="jadwal" class="modal fade" role="dialog">
    <div class="modal-dialog">


        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                Pilih Jadwal Piket Pengawas Umum
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="" enctype="multipart/form-data">
                    
                    <input type="hidden" class="txtiddinas" name="id_dinas">
                    <input type="hidden" class="txttanggal" name="tanggal">

                    <div class="form-group">
                        <label>Pengawas Umum : </label>
                        <select class="form-control" name="id_pengawas" id="id_pengawas" required>
                            <option value="" selected disabled hidden>Pilih Pengawas Umum</option>
                            @foreach(\App\Models\User::where('id_role',2)->where('status',1)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endforeach
                        </select>
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
                Ubah Jadwal Piket Pengawas Umum
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <input type="hidden" class="txtid" name="idpiket">
                    <input type="hidden" class="txtiddinas2" name="id_dinas2">
                    <input type="hidden" class="txttanggal2" name="tanggal2">

                    <div class="form-group">
                        <label>Pengawas Umum : </label>
                        <select class="form-control txtpengawas" id="id_pengawas2" name="id_pengawas" required>
                            <option value="" selected disabled hidden>Pilih Pengawas Umum</option>
                            @foreach(\App\Models\User::where('id_role',2)->where('status',1)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            
            </form>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-hapus btn-danger float-left">Hapus</button>
                <button type="submit" class="btn btn-sm btn-edit btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
@stop
@section('custom_script')

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        }
    });


    $(".btn-lihat-jadwal").click(function(){
        if($("#tahun").val() == 0 || $("#bulan").val() == 0)
        {
            alert("Lengkapi pilihan tahun dan bulan dahulu.")
        }
        else{
            $(".tablejadwal").html("<h1>Mohon Tunggu...</h1>")
            $.ajax({
            type : "get",
            url : 'refresh-grafik/'+$("#tahun").val()+'/'+$("#bulan").val(),
            data: {tahun: $("#tahun").val(), bulan: $("#bulan").val()},
            success : function(data){
            $(".tablejadwal").html(data);
            }
        });
        }
        


    });

    



    (function($) {
        $(".alert-call").fadeOut(2500);
        $(".alert-call2").fadeOut(2500);
        $(".alert-call3").fadeOut(2500);
        $(".alert-call4").fadeOut(2500);
    })(jQuery);
</script>

@stop