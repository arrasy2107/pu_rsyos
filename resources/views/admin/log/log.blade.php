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



setlocale(LC_TIME, 'id_ID');
\Carbon\Carbon::setLocale('id');
\Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");



?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Log Aktivitas Pengguna (Seminggu Terakhir)</h1>

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
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="lokasi">Jenis Log</label>
                        <select id="jenis" name="jenis" class="form-control select2">
                        <option value="0">Semua</option>
                        @foreach(\App\Models\Logjenis::all() as $slk)
                        <option value="{{ $slk->id }}">{{ $slk->jenis }}</option>
                        @endforeach
                        </select>
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
                <div class="col-md-12 tablelog">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="20%">Tanggal</th>
                                    <th width="10%">Jam</th>
                                    <th>User</th>
                                    <th>Log Jenis</th>
                                    <th>Keterangan</th>
                                

                                </tr>
                            </thead>
                            <?php
                            $date = date_default_timezone_set('Asia/Jakarta');
                            $today = date('Y-m-d H:i:s');
                            
                            ?>
                            <tbody>
                                @foreach(\App\Models\Log::whereBetween('created_at',[date("Y-m-d", strtotime("-1 week")),$today])->orderBy('created_at','DESC')->get() as $data)
                                <tr>

                                    <td>{{ $data->created_at->isoFormat('dddd, D MMMM Y') }}</td>
                                    <td>{{ date('H:i:s', strtotime($data->created_at)) }}</td>
                                    <td>{{ \App\Models\User::where('id',$data->id_user)->pluck('username')->first() }}</td>
                                    <td>{{ \App\Models\Logjenis::where('id',$data->id_log_jenis)->pluck('jenis')->first() }}</td>
                                    <td>{{ $data->keterangan }}</td>

                                </tr>
                            
                                @endforeach

                            </tbody>
                        </table>
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
        // scrollY: "400px",
        // scrollX: true,
      
        // paging: false,
        ordering: false,
        
    });

    $("#lihat").click(function() {

    if (!$("#tanggal").val() || !$("#tanggal2").val()) {
    alert('lengkapi tanggal dahulu');
    } else {
    $(".tablelog").html("<h1>Mohon Tunggu...</h1>")
    $.ajax({
        type: "get",
        url: 'refresh-log/' + $("#tanggal").val() + '/' + $("#tanggal2").val() + '/' + $("#jenis").val(),
        data: {
        tanggal2: $("#tanggal2").val(),
        tanggal: $("#tanggal").val(),
        jenis: $("#jenis").val()
        },
        success: function(data) {
        console.log(data);
        $(".tablelog").html(data);
        }
    });
    }

    });
</script>



@stop