<?php

use Carbon\Carbon;
use Carbon\CarbonPeriod;


$t = new Grei\TanggalMerah();


setlocale(LC_TIME, 'id_ID');
\Carbon\Carbon::setLocale('id');
\Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");


$dateObj   = \Carbon\Carbon::createFromFormat('!m', $bulan);
$monthName = $dateObj->isoFormat('MMMM'); // March
$ts = strtotime($monthName.' '.$tahun);
$lastdate = date('t', $ts); 


//$period = CarbonPeriod::create('2021-09-01', '2021-09-30');
$from = \Carbon\Carbon::createFromFormat('Y-m-d', $tahun.'-'.$bulan.'-01');

$tanggalsekarang = date("Y-m-t", strtotime($tahun.'-'.$bulan.'-01'));
$to = \Carbon\Carbon::createFromFormat('Y-m-d', $tanggalsekarang);


$period = new CarbonPeriod($from, '1 day', $to);

?>
<style>
.dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody {
  overflow-x: scroll !important;
}
.dataTables_scrollBody {
    overflow-x: scroll !important;
}
    </style>
<div class="table-responsive" style="margin-top:20px;">
<h3>{{$monthName}} {{$tahun}}</h3>
    <table id="example" class="table table-bordered" style="width:100%; overflow-x: scroll !important;">
        <thead>
<!-- warna merah #f3574e -->
            <tr>

                <th style="background-color:midnightblue;color:white">DINAS</th>
                @foreach($period as $date)
                    <?php
                        $t->set_date($date->format('Ymd'));
                    ?>
                    @if($date->isoFormat('dddd') == 'Minggu' || $t->is_holiday() == true)
                    <th style="background-color:#f3574e;color:white">{{$date->format('d')}} / <span style="font-size:12px">{{$date->isoFormat('dddd')}} </span></th>
                    @else
                    <th style="background-color:midnightblue;color:white">{{$date->format('d')}} / <span style="font-size:12px">{{$date->isoFormat('dddd')}}</span></th>
                    
                    @endif
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
                <td><span style="color:transparent;margin-left:-10px">{{$data->id}}. </span> <img src="{{asset('sb-admin/icon/piket/morning.png')}}" height="30px" width="30px"> {{ strtoupper($data->dinas) }}</td>
                @elseif($data->id == 2)
                <td><span style="color:transparent;margin-left:-10px">{{$data->id}}. </span> <img src="{{asset('sb-admin/icon/piket/ocean.png')}}" height="30px" width="30px"> {{ strtoupper($data->dinas) }}</td>
                @else
                <td><span style="color:transparent;margin-left:-10px">{{$data->id}}. </span> <img src="{{asset('sb-admin/icon/piket/half-moon.png')}}" height="30px" width="30px"> {{ strtoupper($data->dinas) }}</td>
                @endif
                @foreach($period as $tgl)
                @if(\App\Models\Piket::where('tanggal',$tgl->format('Y-m-d'))->where('id_dinas',$data->id)->first())
                <td><button value="{{$data->id}}" class="btn btn-sm btn-default btn-ganti " style="display: block;margin: auto;" data-dinas="{{ $data->id }}" data-tanggal="{{$tgl->format('Y-m-d')}}" data-pengawas="{{\App\Models\Piket::where('tanggal',$tgl->format('Y-m-d'))->where('id_dinas',$data->id)->pluck('id_pengawas')->first()}}" data-idpiket="{{\App\Models\Piket::where('tanggal',$tgl->format('Y-m-d'))->where('id_dinas',$data->id)->pluck('id')->first()}}" data-toggle="modal" data-target="#edit"><span class="badge badge-primary">{{\App\Models\User::where('id',\App\Models\Piket::where('tanggal',$tgl->format('Y-m-d'))->where('id_dinas',$data->id)->pluck('id_pengawas')->first())->pluck('nama')->first()}}</span></button></td>
                @else
                <td><button value="{{$data->id}}" class="btn btn-sm btn-default btn-jadwal " style="background-color: #f8f9fc;display: block;margin: auto;" data-dinas="{{ $data->id }}" data-tanggal="{{$tgl->format('Y-m-d')}}" data-toggle="modal" data-target="#jadwal"><i class="fa fa-plus" aria-hidden="true"></i></button></td>
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

<script>
    // $("#dataTable").DataTable({

    // });
    $(document).ready(function() {
        var table = $('#example').removeAttr('width').DataTable({
            scrollX: true,
            
            ordering: false,
            paging: false,
            searching: false,
            info: false,
            columnDefs: [{
                width: 300,
                targets: 0
            }],
            fixedColumns: true
        });
    });


</script>
<script>
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        }
    });


    var id, dinas, tanggal, idpiket;
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
        console.log(idpiket)

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
</script>