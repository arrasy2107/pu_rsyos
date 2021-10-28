@extends('master.masterpengawas')
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


setlocale(LC_TIME, 'id_ID');
\Carbon\Carbon::setLocale('id');
\Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
$t = new Grei\TanggalMerah();



?>
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Riwayat Laporan Sebulan terakhir (Sudah diverifikasi Direktur)</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        <div class ="row">
            <div class="col-md-3">
                <label for="tglmulai">Tanggal Mulai</label>
                <div class="form-group">

                <input type="date" id="tanggal" class="form-control" name="tglmulai" />
                </div>
            </div>
            <div class="col-md-3">
                <label for="tglmulai">Tanggal Selesai</label>
                <div class="form-group">

                <input type="date" id="tanggal2" class="form-control" name="tglselesai" />
                </div>
            </div>
        
            <div class="col-md-1">
                <label for="tglmulai" style="color:white">Lihat</label>
                <div class="form-group">

                <button type="button" id="lihat" class="btn btn-primary btn-sm" name="lihat">Lihat</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 tablehistory">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="10%">No</th>
                                <th width="15%">Tanggal</th>
                                <th width="10%">Jam</th>
                                <th>Dinas</th>
                                <th>Pengawas Umum</th>
                                <th >Tanda Tangan</th>
                                <th width="20%">Laporan</th>

                            </tr>
                        </thead>
                        
                        <?php
                        $date = date_default_timezone_set('Asia/Jakarta');
                        $today = date('Y-m-d H:i:s');
                        $no = 1;
                        ?>
                        
                        <tbody>
                            @foreach(\App\Models\Laporan::whereBetween('created_at',[date("Y-m-d", strtotime("-1 month")),$today])->where('verified',1)->orderBy('updated_at','DESC')->where('status',1)->get() as $data)
                            <?php
                            $t->set_date( date('Ymd', strtotime($data->created_at)));
                            ?>
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $data->created_at->isoFormat('dddd, D MMMM Y')}}</td>
                                <td>{{ date('H:i:s', strtotime($data->created_at)) }}</td>
                                <td>{{ strtoupper(\App\Models\Dinas::where('id',$data->id_dinas)->pluck('dinas')->first()) }}</td>
                                <td>{{ \App\Models\User::where('id',$data->id_pengawas)->pluck('nama')->first() }}</td>
                                <td><img style="width:150px; height:auto" class="img-fluid rounded mb-3 mb-md-0" src="{{asset('signature/'.$data->signature)}}" alt=""></td>
                                
                                <td>
                                    <button value="{{ $data->id }}" class="btn btn-sm btn-danger btn-igd " data-jenis="1" data-toggle="modal" data-target="#igd">IGD</button>
                                    <button value="{{ $data->id }}" class="btn btn-sm btn-success btn-umum " data-jenis="2" data-toggle="modal" data-target="#umum">Umum</button>
                                    <button value="{{ $data->id }}" class="btn btn-sm btn-warning btn-ibs " style="color:#000" data-jenis="4" data-toggle="modal" data-target="#ibs">IBS</button>
                                    @if($data->id_dinas != 3 && $t->check() != true)
                                    <button value="{{ $data->id }}" class="btn btn-sm btn-primary btn-irj " data-jenis="3" data-toggle="modal" data-target="#irj">IRJ</button>
                                    @endif
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
                
    </div>
</div>

</div>
<div id="igd" class="modal fade" role="dialog">
    
    <div class="modal-dialog modal-xl">

        <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-header">
                <h4>Instalasi Gawat Darurat (IGD)</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
            <div class="row ">
                <div class="col-lg-12 tableigd">
                
                </div>
            </div>
            </div>
          
           
        </div>
    </div>
</div>
<div id="umum" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl" >

        <!-- Modal content-->
        <div class="modal-content">

        <div class="modal-header">
                <h4>Umum / Ruangan</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
            <div class="row ">
                <div class="col-lg-12 tableumum">
                
                </div>
            </div>
            </div>
           
        </div>
    </div>
</div>
<div id="ibs" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl" >

        <!-- Modal content-->
        <div class="modal-content">

        <div class="modal-header">
                <h4>Instalasi Bedah Sentral (IBS)</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
            <div class="row ">
                <div class="col-lg-12 tableibs">
                
                </div>
            </div>
            </div>
           
        </div>
    </div>
</div>
<div id="irj" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">

        <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-header">
                <h4>Instalasi Rawat Jalan (IRJ)</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
            <div class="row ">
                <div class="col-lg-12 tableirj">
                
                </div>
            </div>
            </div>
           
        </div>
    </div>
</div>

<!-- Rincian umum -->
<div id="istimewa" class="modal fade" role="dialog"  >
    <div class="modal-dialog modal-lg" >

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                <h4>Catatan Pasien Istimewa</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                
            </div>
            <div class="modal-body" style="padding:30px">
                <div class="row ">
                    <div class="col-lg-12 tableistimewa">
                
                    </div>
                </div>
            </div>
         
        </div>
        
    </div>
</div>

<div id="baru" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" >

        <!-- Modal content-->
        <div class="modal-content">

        <div class="modal-header">
                <h4>Catatan Pasien Baru</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
            <div class="row ">
                <div class="col-lg-12 tablebaru">
                
                </div>
            </div>
            </div>
           
        </div>
    </div>
</div>


<div id="permasalahan" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" >

        <!-- Modal content-->
        <div class="modal-content">

        <div class="modal-header">
                <h4>Permasalahan</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
            <div class="row ">
                <div class="col-lg-12 tablemasalah">
                
                </div>
            </div>
            </div>
           
        </div>
    </div>
</div>
@stop
@section('custom_script')
<script>
    $("#dataTable").DataTable({
        "ordering":false
    });



    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        }
    });




    $("#dataTable").on('click', '.btn-igd', function() {
        id1 = $(this).val();
     

    });
    $("#dataTable").on('click', '.btn-umum', function() {
        id2 = $(this).val();
   

    });
    $("#dataTable").on('click', '.btn-irj', function() {
        id3 = $(this).val();

    });
    $("#dataTable").on('click', '.btn-ibs', function() {
        id4 = $(this).val();

    });

    $('#igd').on('show.bs.modal', function() {
           $.ajax({
                            type : "get",
                            url : 'refresh-detail-laporan-igd/'+id1,
                            data: { "_token": "{{ csrf_token() }}", idlaporan : id1},
                            success : function(data){
                            //console.log(data);
                            $(".tableigd").html(data);
                            }   
                    });


    });

    $('#umum').on('show.bs.modal', function() {
           $.ajax({
                            type : "get",
                            url : 'refresh-detail-laporan-umum/'+id2,
                            data: { "_token": "{{ csrf_token() }}", idlaporan : id2},
                            success : function(data){
                            //console.log(data);
                            $(".tableumum").html(data);
                            }   
                    });


    });

    $('#irj').on('show.bs.modal', function() {
           $.ajax({
                            type : "get",
                            url : 'refresh-detail-laporan-irj/'+id3,
                            data: { "_token": "{{ csrf_token() }}", idlaporan : id3},
                            success : function(data){
                            //console.log(data);
                            $(".tableirj").html(data);
                            }   
                    });


    });

    $('#ibs').on('show.bs.modal', function() {
           $.ajax({
                            type : "get",
                            url : 'refresh-detail-laporan-ibs/'+id4,
                            data: { "_token": "{{ csrf_token() }}", idlaporan : id4},
                            success : function(data){
                            //console.log(data);
                            $(".tableibs").html(data);
                            }   
                    });


    });

       // 
 $("#dataTableRuangan").on('click','.btn-istimewa',function(){
        idlaporan =  $(this).data('id');
        ruangan =  $(this).data('ruangan');
        $(".tableistimewa").html('<h4>Mohon Tunggu...</h4>');
        $.ajax({
                            type : "get",
                            url : 'refresh-istimewa/'+idlaporan+'/'+ruangan,
                            data: { "_token": "{{ csrf_token() }}", idlaporan : idlaporan, idruangan:ruangan},
                            success : function(data){
                            //console.log(data);
                            $(".tableistimewa").html(data);
                            }   
                    });

    });

    $("#dataTableRuangan").on('click','.btn-baru',function(){
        idlaporan =  $(this).data('id');
        ruangan =  $(this).data('ruangan');
        $(".tablebaru").html('<h4>Mohon Tunggu...</h4>');
        $.ajax({
                            type : "get",
                            url : 'refresh-baru/'+idlaporan+'/'+ruangan,
                            data: { "_token": "{{ csrf_token() }}", idlaporan : idlaporan, idruangan:ruangan},
                            success : function(data){
                            //console.log(data);
                            $(".tablebaru").html(data);
                            }   
                    });

    });

    $("#dataTableRuangan").on('click','.btn-permasalahan',function(){
        idlaporan =  $(this).data('id');
        ruangan =  $(this).data('ruangan');
        $(".tablemasalah").html('<h4>Mohon Tunggu...</h4>');
        $.ajax({
                            type : "get",
                            url : 'refresh-permasalahan/'+idlaporan+'/'+ruangan,
                            data: { "_token": "{{ csrf_token() }}", idlaporan : idlaporan, idruangan:ruangan},
                            success : function(data){
                            //console.log(data);
                            $(".tablemasalah").html(data);
                            }   
                    });

    });


    $("#lihat").click(function() {

    if (!$("#tanggal").val() || !$("#tanggal2").val()) {
    alert('lengkapi tanggal dahulu');
    } else {
    $(".tablehistory").html("<h1>Mohon Tunggu...</h1>")
    $.ajax({
        type: "get",
        url: 'refresh-history/' + $("#tanggal").val() + '/' + $("#tanggal2").val(),
        data: {
        tanggal2: $("#tanggal2").val(),
        tanggal: $("#tanggal").val(),
        },
        success: function(data) {
        console.log(data);
        $(".tablehistory").html(data);
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