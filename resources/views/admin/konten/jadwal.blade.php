@extends('master.masteradmin')
@section('custom_style')
<link href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/fixedcolumns/3.3.3/css/fixedColumns.dataTables.min.css" rel="stylesheet">

<style>
    /* Ensure that the demo table scrolls */
    th,
    td {
        white-space: nowrap;
        overflow-y: hidden
    }

    div.dataTables_wrapper {
        margin: 0 auto;
    }

    div.container {
        width: 80%;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2-selection__rendered {
    line-height: 37px !important;
}
.select2-container .select2-selection--single {
    height: calc(1.5em + .75rem + 2px);
}
.select2-selection__arrow {
    height: 34px !important;
}
</style>
@stop

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
$newDateTime = Carbon::now()->addYears(5);

?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Jadwal Dinas Pengawas Umum</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tahun"><b>Tahun</b></label>
                        <select id="tahun" name="tahun" class="form-control ">
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
                        <select id="bulan" name="bulan" class="form-control ">
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
                        <button class="btn btn-primary btn-lihat-jadwal" type="submit">Lihat Jadwal</button>
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
            <form method="post" action="" enctype="multipart/form-data">
                <div class="modal-body" style="padding:30px">
                    
                        
                        <input type="hidden" class="txtiddinas" name="id_dinas">
                        <input type="hidden" class="txttanggal" name="tanggal">

                        <div class="form-group">
                            <label>Pengawas Umum : </label><br>
                            <select class="form-control select2" name="id_pengawas" id="id_pengawas" style="width:100%" required>
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
            <form method="post" action="" enctype="multipart/form-data">
                <div class="modal-body" style="padding:30px">
                    
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="hidden" class="txtid" name="idpiket">
                        <input type="hidden" class="txtiddinas2" name="id_dinas2">
                        <input type="hidden" class="txttanggal2" name="tanggal2">

                        <div class="form-group">
                            <label>Pengawas Umum : </label><br>
                            <select class="form-control txtpengawas select2" id="id_pengawas2" name="id_pengawas" style="width:100%" required>
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

<!-- untuk custom IRJ Buka -->
<div id="jadwal2" class="modal fade" role="dialog">
    <div class="modal-dialog">


        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                Pilih Jadwal Piket Pengawas Umum
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="modal-body" style="padding:30px">
                    
                        
                        <input type="hidden" class="txtiddinasx" name="id_dinasx">
                        <input type="hidden" class="txttanggalx" name="tanggalx">

                        <div class="form-group">
                            <label>Pengawas Umum : </label><br>
                            <select class="form-control select2" name="id_pengawasx" id="id_pengawasx" style="width:100%" required>
                                <option value="" selected disabled hidden>Pilih Pengawas Umum</option>
                                @foreach(\App\Models\User::where('id_role',2)->where('status',1)->get() as $mb)
                                <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="irjbuka" name="irjbuka">
                            <label class="form-check-label" for="exampleCheck1">IRJ Buka</label>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary btn-tambah2">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="edit2" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                Ubah Jadwal Piket Pengawas Umum
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="modal-body" style="padding:30px">
                    
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="hidden" class="txtidx" name="idpiketx">
                        <input type="hidden" class="txtiddinas2x" name="id_dinas2x">
                        <input type="hidden" class="txttanggal2x" name="tanggal2x">

                        <div class="form-group">
                            <label>Pengawas Umum : </label><br>
                            <select class="form-control txtpengawasx select2" id="id_pengawas2x" name="id_pengawasx" style="width:100%" required>
                                <option value="" selected disabled hidden>Pilih Pengawas Umum</option>
                                @foreach(\App\Models\User::where('id_role',2)->where('status',1)->get() as $mb)
                                <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input txtirj" id="irjbuka2" name="irjbuka2">
                            <label class="form-check-label" for="exampleCheck1">IRJ Buka</label>
                        </div>
                </div>
            
            </form>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-hapus2 btn-danger float-left">Hapus</button>
                <button type="submit" class="btn btn-sm btn-edit2 btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
@stop
@section('custom_script')
<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.3/js/dataTables.fixedColumns.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': '{{ csrf_token() }}',
    //     }
    // });


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var id, dinas, tanggal, idpiket, cekirj, irjcheckbox;
    $("#example").on('click', '.btn-jadwal', function() {
        id = $(this).val(); //dinas
        dinas = $(this).data('dinas');
        tanggal = $(this).data('tanggal');
        console.log(tanggal)

    });

    $("#example").on('click', '.btn-ganti', function() {
        id = $(this).val(); //dinas
        idpiket = $(this).data('idpiket');
        dinas = $(this).data('dinas');
        tanggal = $(this).data('tanggal');
        pengawas = $(this).data('pengawas');
        cekirj= $(this).data('irj');
        if(cekirj){
            irjcheckbox = true;
        }
        else{
            irjcheckbox = false;
        }
      
        console.log(irjcheckbox)

    });

    $('#jadwal').on('show.bs.modal', function() {
        $(".txtiddinas").val(id);
        $(".txttanggal").val(tanggal);
        $("#id_pengawas").select2().val("").trigger("change");

    });
    $('#edit').on('show.bs.modal', function() {
        $(".txtiddinas2").val(id);
        $(".txttanggal2").val(tanggal);
        $(".txtpengawas").select2().val(pengawas).trigger("change");
        $(".txtid").val(idpiket);
    });


    $(".btn-tambah").click(function(e){

        $("#jadwal").modal('hide');

        e.preventDefault();

        var id_pengawas = $("#id_pengawas :selected").val();
        var id_dinas = $("input[name=id_dinas]").val();
        var tanggal = $("input[name=tanggal]").val();
        var irj = 0;

        
        //document.getElementById("id_pengawas").value = "";

       
        console.log(id_pengawas+' '+ id_dinas + ' '+ tanggal);
        var url = 'tambahpiket';

        $.ajax({
        url:url,
        method:'POST',
        data:{
            id_pengawas:id_pengawas,
            id_dinas:id_dinas,
            tanggal : tanggal,
            irj : irj
        },
        success:function(response){
            if(response.success){
                
                alert(response.message) //Message come from controller
                $.ajax({
                    type : "get",
                    url : 'refresh-jadwal-dinas/'+$("#tahun").val()+'/'+$("#bulan").val(),
                    data: {tahun: $("#tahun").val(), bulan: $("#bulan").val()},
                    success : function(data){
                    //console.log(data);
                    $(".tablejadwal").html(data);
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

    $(".btn-edit").click(function(e){

        $("#edit").modal('hide');

        e.preventDefault();

        var id_pengawas = $("#id_pengawas2 :selected").val();
        var id_dinas = $("input[name=id_dinas2]").val();
        var tanggal = $("input[name=tanggal2]").val();
        var irj = 0;

        console.log(id_pengawas+' - '+ id_dinas + ' - '+ tanggal);
        var url = 'editpiket';

        $.ajax({
        url:url,
        method:'PUT',
        data:{
            id_pengawas:id_pengawas,
            id_dinas:id_dinas,
            tanggal : tanggal,
            irj:0
        },
        success:function(response){
            if(response.success){
                
                alert(response.message) //Message come from controller
                $.ajax({
                    type : "get",
                    url : 'refresh-jadwal-dinas/'+$("#tahun").val()+'/'+$("#bulan").val(),
                    data: {tahun: $("#tahun").val(), bulan: $("#bulan").val()},
                    success : function(data){
                    //console.log(data);
                    $(".tablejadwal").html(data);
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

    $(".btn-hapus").click(function(e){
        var conf = confirm('apakah anda yakin ingin menghapus jadwal ini ?');
        if (conf == false) {
            e.preventDefault();
            $("#edit").modal('hide');
        }
        else{
            $("#edit").modal('hide');
            var id = $("input[name=idpiket]").val();

            console.log(id);
            var url = 'deletepiket/'+id;

            $.ajax({
            url:url,
            method:'GET',
            data:{
                id:id,
               
            },
            success:function(response){
                if(response.success){
                    
                    alert(response.message) //Message come from controller
                    $.ajax({
                        type : "get",
                        url : 'refresh-jadwal-dinas/'+$("#tahun").val()+'/'+$("#bulan").val(),
                        data: {tahun: $("#tahun").val(), bulan: $("#bulan").val()},
                        success : function(data){
                        console.log(data);
                        $(".tablejadwal").html(data);
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
        }
    });


    //Khusus untuk IRJ Custom buka

    // var irjcheckbox = true;

    $('#jadwal2').on('show.bs.modal', function() {
        $(".txtiddinasx").val(id);
        $(".txttanggalx").val(tanggal);
        $("#id_pengawasx").select2().val("").trigger("change");
        $("#irjbuka").prop("checked", false);

    });
    $('#edit2').on('show.bs.modal', function() {
        $(".txtiddinas2x").val(id);
        $(".txttanggal2x").val(tanggal);
        $(".txtpengawasx").select2().val(pengawas).trigger("change");
        $(".txtidx").val(idpiket);
        console.log(irjcheckbox)
        $(".txtirj").prop("checked", irjcheckbox);
    });


    $(".btn-tambah2").click(function(e){

        $("#jadwal2").modal('hide');

        e.preventDefault();

        var id_pengawas = $("#id_pengawasx :selected").val();
        var id_dinas = $("input[name=id_dinasx]").val();
        var tanggal = $("input[name=tanggalx]").val();
        var irj = $("#irjbuka").is(":checked");
        if(irj){
            irj = 1;
        }
        else{
            irj = 0;
        }

        $("#id_pengawasx").val("");
        
       
        console.log(id_pengawas+' '+ id_dinas + ' '+ tanggal+ ' '+irj);
        var url = 'tambahpiket';

        $.ajax({
        url:url,
        method:'POST',
        data:{
            id_pengawas:id_pengawas,
            id_dinas:id_dinas,
            tanggal : tanggal,
            irj:irj
        },
        success:function(response){
            if(response.success){
                
                alert(response.message) //Message come from controller
                $.ajax({
                    type : "get",
                    url : 'refresh-jadwal-dinas/'+$("#tahun").val()+'/'+$("#bulan").val(),
                    data: {tahun: $("#tahun").val(), bulan: $("#bulan").val()},
                    success : function(data){
                    //console.log(data);
                    $(".tablejadwal").html(data);
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

    $(".btn-edit2").click(function(e){

        $("#edit2").modal('hide');

        e.preventDefault();

        var id_pengawas = $("#id_pengawas2x :selected").val();
        var id_dinas = $("input[name=id_dinas2x]").val();
        var tanggal = $("input[name=tanggal2x]").val();
        var irj = $("#irjbuka2").is(":checked");
        if(irj){
            irj = 1;
        }
        else{
            irj = 0;
        }


        console.log(id_pengawas+' - '+ id_dinas + ' - '+ tanggal + ' - '+ irj);
        var url = 'editpiket';

        $.ajax({
        url:url,
        method:'PUT',
        data:{
            id_pengawas:id_pengawas,
            id_dinas:id_dinas,
            tanggal : tanggal,
            irj : irj
        },
        success:function(response){
            if(response.success){
                
                alert(response.message) //Message come from controller
                $.ajax({
                    type : "get",
                    url : 'refresh-jadwal-dinas/'+$("#tahun").val()+'/'+$("#bulan").val(),
                    data: {tahun: $("#tahun").val(), bulan: $("#bulan").val()},
                    success : function(data){
                    //console.log(data);
                    $(".tablejadwal").html(data);
                    }   
            });
            }else{
                alert("Error")
            }
        },
        error:function(error){
            alert(response.message)
        }
        });
    });

    $(".btn-hapus2").click(function(e){
        var conf = confirm('apakah anda yakin ingin menghapus jadwal ini ?');
        if (conf == false) {
            e.preventDefault();
            $("#edit2").modal('hide');
        }
        else{
            $("#edit2").modal('hide');
            var id = $("input[name=idpiketx]").val();

            console.log(id);
            var url = 'deletepiket/'+id;

            $.ajax({
            url:url,
            method:'GET',
            data:{
                id:id,
               
            },
            success:function(response){
                if(response.success){
                    
                    alert(response.message) //Message come from controller
                    $.ajax({
                        type : "get",
                        url : 'refresh-jadwal-dinas/'+$("#tahun").val()+'/'+$("#bulan").val(),
                        data: {tahun: $("#tahun").val(), bulan: $("#bulan").val()},
                        success : function(data){
                        console.log(data);
                        $(".tablejadwal").html(data);
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
            url : 'refresh-jadwal-dinas/'+$("#tahun").val()+'/'+$("#bulan").val(),
            data: {tahun: $("#tahun").val(), bulan: $("#bulan").val()},
            success : function(data){
            //console.log(data);
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
<script>

    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

@stop