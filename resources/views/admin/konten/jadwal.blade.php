@extends('master.masteradmin')
@section('custom_style')
<link href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/fixedcolumns/3.3.3/css/fixedColumns.dataTables.min.css" rel="stylesheet">

<style>
/* Ensure that the demo table scrolls */
th, td { white-space: nowrap; overflow-y:hidden}
    div.dataTables_wrapper {
        margin: 0 auto;
    }
 
    div.container {
        width: 80%;
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
?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Jadwal Dinas Pengawas Umum</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
         
            <div class="table-responsive">
                <table id="example" class="table table-bordered" style="width:100%">
                    <thead>
                   
                        <tr>
                            
                            <th >DINAS</th>
                            @foreach($period as $date)
                            <th>{{$date->format('d')}} / <span style="font-size:12px">{{$date->isoFormat('dddd')}}</span></th>
                            @endforeach
                            
                        </tr>
                    </thead>
                    
                    <?php
                    $no = 1;
                    ?>
                    <tbody>
                        @foreach(\App\Models\Dinas::orderBy('id')->get() as $data)
                        <tr>

                            @if($data->id == 1)
                            <td><span style="color:transparent;margin-left:-10px">{{$data->id}}. </span> <img src="{{asset('sb-admin/icon/piket/morning.png')}}" height="30px" width="30px">  {{ strtoupper($data->dinas) }}</td>
                            @elseif($data->id == 2)
                            <td><span style="color:transparent;margin-left:-10px">{{$data->id}}. </span> <img src="{{asset('sb-admin/icon/piket/ocean.png')}}" height="30px" width="30px">  {{ strtoupper($data->dinas) }}</td>
                            @else
                            <td><span style="color:transparent;margin-left:-10px">{{$data->id}}. </span> <img src="{{asset('sb-admin/icon/piket/half-moon.png')}}" height="30px" width="30px">  {{ strtoupper($data->dinas) }}</td>
                            @endif
                            @foreach($period as $tgl)
                                @if(\App\Models\Piket::where('tanggal',$tgl->format('Y-m-d'))->where('id_dinas',$data->id)->first())
                                    <td><button value="{{$data->id}}" class="btn btn-sm btn-default btn-ganti " style="display: block;margin: auto;" data-dinas="{{ $data->id }}" data-tanggal="{{$tgl->format('Y-m-d')}}" data-pengawas="{{\App\Models\Piket::where('tanggal',$tgl->format('Y-m-d'))->where('id_dinas',$data->id)->pluck('id_pengawas')->first()}}"  data-toggle="modal" data-target="#edit"><span class="badge badge-primary">{{\App\Models\User::where('id',\App\Models\Piket::where('tanggal',$tgl->format('Y-m-d'))->where('id_dinas',$data->id)->pluck('id_pengawas')->first())->pluck('nama')->first()}}</span></button></td>
                                @else
                                <td><button value="{{$data->id}}" class="btn btn-sm btn-default btn-jadwal " style="background-color: #f8f9fc;display: block;margin: auto;" data-dinas="{{ $data->id }}" data-tanggal="{{$tgl->format('Y-m-d')}}"  data-toggle="modal" data-target="#jadwal"><i class="fa fa-plus" aria-hidden="true"></i></button></td>
                                @endif
                            @endforeach
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
<div id="jadwal" class="modal fade" role="dialog">
    <div class="modal-dialog">


        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                Pilih Jadwal Piket Pengawas Umum
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="{{ route('tambahpiket') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" class="txtiddinas" name="id_dinas" >
                    <input type="hidden" class="txttanggal" name="tanggal">
                   
                    <div class="form-group">
                        <label>Pengawas Umum : </label>
                        <select class="form-control" name="id_pengawas" required>
                            <option value="" selected disabled hidden>Pilih Pengawas Umum</option>
                            @foreach(\App\Models\User::where('id_role',2)->where('status',1)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-selesai btn-primary">Simpan</button>
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
                <form method="post" action="{{ route('editpiket') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <input type="hidden" class="txtiddinas2" name="id_dinas" >
                    <input type="hidden" class="txttanggal2" name="tanggal">
                   
                    <div class="form-group">
                        <label>Pengawas Umum : </label>
                        <select class="form-control txtpengawas" name="id_pengawas" required>
                            <option value="" selected disabled hidden>Pilih Pengawas Umum</option>
                            @foreach(\App\Models\User::where('id_role',2)->where('status',1)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-selesai btn-primary">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>
@stop
@section('custom_script')
<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.3/js/dataTables.fixedColumns.min.js"></script>
<script>
    // $("#dataTable").DataTable({

    // });
    $(document).ready(function() {
        var table = $('#example').removeAttr('width').DataTable( {
            scrollX:        true,
            scrollCollapse: true,
            ordering : false,
            paging:         false,
            searching : false,
            info:false,
            columnDefs: [
                { width: 300, targets: 0 }
            ],
            fixedColumns: true
        } );
    } );

</script>
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        }
    });


    var id,dinas,tanggal;
    $("#example").on('click', '.btn-jadwal', function() {
        id = $(this).val(); //dinas
        dinas = $(this).data('dinas');
        tanggal = $(this).data('tanggal');
        console.log(tanggal)
        
    });

    $("#example").on('click', '.btn-ganti', function() {
        id = $(this).val(); //dinas
        dinas = $(this).data('dinas');
        tanggal = $(this).data('tanggal');
        pengawas = $(this).data('pengawas');
        console.log(tanggal)
        
    });

    $('#jadwal').on('show.bs.modal', function() {
        $(".txtiddinas").val(id);
        $(".txttanggal").val(tanggal);


    });
    $('#edit').on('show.bs.modal', function() {
        $(".txtiddinas2").val(id);
        $(".txttanggal2").val(tanggal);
        $(".txtpengawas").val(pengawas);

    });

    $("#dataTable").on('click', '.btn-delete', function(e) {
        var conf = confirm('apakah anda yakin ingin menghapus data ini ?');
        if (conf == false) {
            e.preventDefault();
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