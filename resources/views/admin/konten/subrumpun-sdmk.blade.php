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
    <h1 class="h3 mb-2 text-gray-800">Data Subrumpun SDMK (Sumber Daya Manusia Kesehatan)</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <button class="btn btn-primary btn-md" data-toggle="modal" data-target="#tambah">Tambah Subrumpun</button>
                    <br>
                </div>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="10%">No</th>
                            <th>Nama Subrumpun</th>
                            <th width="20%">Aksi</th>

                        </tr>
                    </thead>
                    
                    <?php
                    $no = 1;
                    ?>
                    <tbody>
                        @foreach(\App\Models\sdmk_subrumpun::where('status',1)->get() as $data)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $data->subrumpun }}</td>
                            
                            <td><button value="{{ $data->id }}" class="btn btn-sm btn-success btn-edit " data-nama="{{$data->subrumpun}}" data-toggle="modal" data-target="#edit">Ubah</button>
                                <a href="{{ route('deletesubrumpunsdmk',$data->id) }}" style="width:auto" class="btn btn-sm btn-danger btn-delete">Hapus</a>
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
                Tambah Subrumpun
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="{{ route('tambahsubrumpunsdmk') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Nama Subrumpun: </label>
                        <input type="text" class="form-control" name="subrumpun" required />
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
                Ubah Nama Subrumpun
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="{{ route('editsubrumpunsdmk') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <input type="hidden" class="txtid" name="id">
                    <div class="form-group">
                        <label>Nama Subrumpun: </label>
                        <input type="text" class="form-control txt-nama" name="subrumpun" required />
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




    $("#dataTable").on('click', '.btn-edit', function() {
        id = $(this).val();
        nama = $(this).data('nama');

    });

    $('#edit').on('show.bs.modal', function() {
        $(".txtid").val(id);
        $(".txt-nama").val(nama);
       


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