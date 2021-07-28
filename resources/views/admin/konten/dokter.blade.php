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

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Dokter</h1>

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
                            <th>Aksi</th>

                        </tr>
                    </thead>
                    
                    <?php
                    $no = 1;
                    ?>
                    <tbody>
                        @foreach(\App\Models\Dokter::all() as $data)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $data->nama_dokter }}</td>
                            
                            <td><button value="{{ $data->id }}" class="btn btn-sm btn-success btn-edit " data-judul="{{$data->judul}}" data-subjudul="{{ $data->subjudul }}" data-ringkasan="{{$data->text_preview}}" data-penulis="{{ $data->penulis }}" data-tanggal="{{ $data->tanggal }}" data-teks="{{ $data->teks }}" data-toggle="modal" data-target="#edit">Ubah</button>
                                <a href="" style="width:auto" class="btn btn-sm btn-danger btn-delete">Hapus</a>
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
                Add Blog
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="#" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Judul: </label>
                        <input type="text" class="form-control" name="judul" required />
                    </div>

                    <div class="form-group">
                        <label>Gambar: </label>
                        <div>
                            <input type="file" name="image" classs="form-control" accept="image/*" required />

                        </div>
                    </div>

                    <div class="form-group">
                        <label>Ringkasan: </label>
                        <textarea type="text" rows="4" class="form-control" name="text_preview" required></textarea>
                    </div>
                    <!-- <div class="form-group">
                        <label>Penulis: </label>
                        <input type="text" class="form-control" name="penulis" required />
                    </div> -->
                    <div class="form-group">
                        <label>Tanggal: </label>
                        <input type="date" class="form-control" name="tanggal" required />
                    </div>
                    <div class="form-group">
                        <label>Teks: </label>
                        <textarea type="text" rows="10" class="form-control" id="editor1" name="teks" required></textarea>
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
                Edit Blog
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="#" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <input type="hidden" class="txtid" name="id">
                    <div class="form-group">
                        <label>Judul: </label>
                        <input type="text" class="form-control txt-judul" name="judul" required />
                    </div>

                    <div class="form-group">
                        <label>Gambar: </label>
                        <div>
                            <input type="file" name="image" classs="form-control txt-gambar" accept="image/*" />

                        </div>
                    </div>

                    <div class="form-group">
                        <label>Ringkasan: </label>
                        <textarea type="text" rows="4" class="form-control txt-ringkasan" name="text_preview" required></textarea>
                    </div>
                    <!-- <div class="form-group">
                        <label>Penulis: </label>
                        <input type="text" class="form-control txt-penulis" name="penulis" required />
                    </div> -->
                    <div class="form-group">
                        <label>Tanggal: </label>
                        <input type="date" class="form-control txt-tanggal" name="tanggal" required />
                    </div>
                    <div class="form-group">
                        <label>Teks: </label>
                        <textarea type="text" rows="10" class="form-control txt-teks" id="editor" name="teks" required></textarea>
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
<script>
    $("#dataTable").DataTable({
       
    });



    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        }
    });



    var idanggota, username, kuota, reset, idd, usern, namanya, namanya2;
    $("#dataTable").on('click', '.btn-edit', function() {
        id = $(this).val();
        judul = $(this).data('judul');

        ringkasan = $(this).data('ringkasan');
        penulis = $(this).data('penulis');
        tanggal = $(this).data('tanggal');
        teks = $(this).data('teks');
    });

    $('#edit').on('show.bs.modal', function() {
        $(".txtid").val(id);
        $(".txt-judul").val(judul);
        $(".txt-ringkasan").val(ringkasan);
        $(".txt-penulis").val(penulis);
        $(".txt-tanggal").val(tanggal);
       


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