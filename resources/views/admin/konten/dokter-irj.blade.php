@extends('master.masteradmin')
@section('custom_style')
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

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Dokter IRJ</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <button class="btn btn-primary btn-md" data-toggle="modal" data-target="#tambah">Tambah Dokter</button>
                    <br>
                </div>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="10%">No</th>
                            <th>Nama Dokter</th>
                            <th>Subrumpun SDMK</th>
                            <th>Jenis SDMK</th>
                            <th width="20%">Aksi</th>

                        </tr>
                    </thead>
                    
                    <?php
                    $no = 1;
                    ?>
                    <tbody>
                        @foreach(\App\Models\Dokterirj::where('status',1)->get() as $data)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $data->nama}}</td>
                            <td>{{ \App\Models\sdmk_subrumpun::where('id',\App\Models\sdmk_jenis::where('id',$data->id_sdmk_jenis)->pluck('id_subrumpun')->first())->pluck('subrumpun')->first() }}</td>
                            <td>{{ \App\Models\sdmk_jenis::where('id',$data->id_sdmk_jenis)->pluck('jenis')->first() }}</td>
                            
                            
                            <td><button value="{{ $data->id }}" class="btn btn-sm btn-success btn-edit " data-nama="{{$data->nama}}" data-jenis="{{$data->id_sdmk_jenis}}" data-toggle="modal" data-target="#edit">Ubah</button>
                                <a href="{{ route('deletedokterirj',$data->id) }}" style="width:auto" class="btn btn-sm btn-danger btn-delete">Hapus</a>
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
<div id="tambah" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                Tambah Dokter IRJ
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="{{ route('tambahdokterirj') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Nama Dokter: </label>
                        <input type="text" class="form-control" name="nama_dokter" required />
                    </div>
                    <div class="form-group ">
                        <label>Jenis SDMK: </label><br>
                        <select class="form-control select2" name="id_sdmk_jenis"  style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Jenis SDMK</option>
                            @foreach(\App\Models\sdmk_jenis::all() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->jenis }}</option>
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
<div id="edit" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                Ubah Nama Dokter IRJ
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="{{ route('editdokterirj') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <input type="hidden" class="txtid" name="id">
                    <div class="form-group">
                        <label>Nama Dokter: </label>
                        <input type="text" class="form-control txt-nama" name="nama_dokter" required />
                    </div>
                    <div class="form-group ">
                        <label>Jenis SDMK: </label><br>
                        <select class="form-control select2 txt-jenis" name="id_sdmk_jenis"  style="width: 100%" required>
                            @foreach(\App\Models\sdmk_jenis::all() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->jenis }}</option>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $("#dataTable").DataTable({
       
    });



    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        }
    });




    $("#dataTable").on('click', '.btn-edit', function() {
        id = $(this).val();
        nama = $(this).data('nama');
        jenis = $(this).data('jenis');

    });

    $('#edit').on('show.bs.modal', function() {
        $(".txtid").val(id);
        $(".txt-nama").val(nama);
        $(".txt-jenis").select2().val(jenis).trigger("change");

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

<script>

    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

@stop