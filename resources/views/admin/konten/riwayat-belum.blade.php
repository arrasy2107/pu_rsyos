@extends('master.masteradmin')
@section('custom_style')
<style>
.double {
  zoom: 2;
  transform: scale(1.2);
  -ms-transform: scale(1.2);
  -webkit-transform: scale(1.2);
  -o-transform: scale(1.2);
  -moz-transform: scale(1.2);
  transform-origin: 0 0;
  -ms-transform-origin: 0 0;
  -webkit-transform-origin: 0 0;
  -o-transform-origin: 0 0;
  -moz-transform-origin: 0 0;
  text-
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


setlocale(LC_TIME, 'id_ID');
\Carbon\Carbon::setLocale('id');
\Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");

$t = new Grei\TanggalMerah();



?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Riwayat Laporan (Belum diverifikasi Direktur)</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            @if(\Auth::user()->id_role == 1)
            <div class="row">
                <div class="col-md-4">
                    <button class="btn btn-primary btn-md btn-verifikasi" id="btn-verifikasi" >Verifikasi Laporan</button>
                    <br>
                </div>
            </div>
            <br>
            @endif
            
                        <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            @if(\Auth::user()->id_role == 1)
                            <th width="7%">Check</th>
                            @endif
                            <th width="15%">Tanggal</th>
                            <th width="10%">Jam</th>
                            <th>Dinas</th>
                            <th>Pengawas Umum</th>
                            <th >Tanda Tangan</th>
                            <th width="20%">Laporan</th>

                        </tr>
                    </thead>
                    
                    <?php
                    $no = 1;
                    ?>
                    
                    <tbody>
                        @foreach(\App\Models\Laporan::where('verified',0)->orderBy('created_at','DESC')->where('status',1)->get() as $data)
                        <?php
                        $t->set_date( date('Ymd', strtotime($data->created_at)));
                        ?>
                        <tr>
                            @if(\Auth::user()->id_role == 1)
                            <td><div class="double"><input type="checkbox" name="verifikasi[]" value="{{ $data->id }}"/></div> </td>
                            @endif
                            <td>{{ $data->created_at->isoFormat('dddd, D MMMM Y') }}</td>
                            <td>{{ date('H:i:s', strtotime($data->created_at)) }}</td>
                            <td>{{ strtoupper(\App\Models\Dinas::where('id',$data->id_dinas)->pluck('dinas')->first()) }}</td>
                            <td>{{ \App\Models\User::where('id',$data->id_pengawas)->pluck('nama')->first() }}</td>
                            <td><img style="width:150px; height:auto" class="img-fluid rounded mb-3 mb-md-0" src="{{asset('signature/'.$data->signature)}}" alt=""></td>
                            
                            <td>
                            <button value="{{ $data->id }}" class="btn btn-sm btn-danger btn-igd " data-jenis="1" data-toggle="modal" data-target="#igd">IGD</button>
                                <button value="{{ $data->id }}" class="btn btn-sm btn-success btn-umum " data-jenis="2" data-toggle="modal" data-target="#umum">Umum</button>
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




    (function($) {
        $(".alert-call").fadeOut(2500);
        $(".alert-call2").fadeOut(2500);
        $(".alert-call3").fadeOut(2500);
        $(".alert-call4").fadeOut(2500);
    })(jQuery);
</script>

<script>
    $(document).ready(function() {
        $("#btn-verifikasi").click(function(){
            var cek = [];
            $.each($("input[name='verifikasi[]']:checked"), function(){
                cek.push($(this).val());
            });
            if(cek == '')
            {
                alert('Pilih Laporan yang akan diverifikasi terlebih dahulu')
            }else{
                //alert("Cek: " + cek.join(", "));
            
                var conf = confirm('apakah Anda yakin ingin verifikasi laporan ini ?');
                if (conf == false) {
                    e.preventDefault();
                }
                else{
                    console.log(cek);
                    var url = 'verifikasilaporan';

                    $.ajax({
                        url:url,
                        method:'PUT',
                        data:{
                            verifikasi:cek,
                        
                        },
                        success:function(response){
                            if(response.success){
                                
                                alert(response.message) //Message come from controller
                                location.reload();
                            }
                            else{
                                alert("Error")
                            }
                        },
                        error:function(error){
                            console.log(error)
                        }
                    });
                }
                



            }
            
        });
    });

</script>

@stop