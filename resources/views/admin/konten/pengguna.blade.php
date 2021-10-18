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
    <h1 class="h3 mb-2 text-gray-800">Data Pengguna</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <button class="btn btn-primary btn-md" data-toggle="modal" data-target="#tambah">Tambah Pengguna</button>
                    <br>
                </div>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Password</th>
                            
                            <th>Aksi</th>

                        </tr>
                    </thead>

                    <?php
                    $no = 1;
                    ?>
                    <tbody>
                        @foreach(\App\Models\User::where('status',1)->where('id','<>',\Auth::user()->id )->get() as $data)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->username }}</td>
                            
                            <td>{{App\Models\Role::where('id',$data->id_role)->pluck('role')->first()}}</td>
                            <td><a href="{{ route('resetpassword',$data->id) }}" style="width:auto" class="btn btn-sm btn-primary btn-reset">Reset</a></td>
                            <td><button value="{{ $data->id }}" class="btn btn-sm btn-success btn-edit " data-nama="{{$data->nama}}" data-username="{{ $data->username }}" data-role="{{$data->id_role}}"  data-toggle="modal" data-target="#edit">Ubah</button>
                                <a href="{{ route('deletepengguna',$data->id) }}" style="width:auto" class="btn btn-sm btn-danger btn-delete">Hapus</a>
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
                Tanbah Pengguna
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="{{ route('tambahpengguna') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Nama: </label>
                        <input type="text" class="form-control" name="nama" required />
                    </div>
                    <div class="form-group">
                        <label>Username/NIP: </label>
                        <input type="text" class="form-control" name="username" required />
                    </div>
                    <div class="form-group">
                        <label>Role: </label>
                        <select class="form-control" name="role" required>
                            @foreach(\App\Models\Role::all() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->role }}</option>
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
                Ubah Data Pengguna
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="{{ route('editpengguna') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <input type="hidden" class="txtid" name="id">
                    <div class="form-group">
                        <label>Nama: </label>
                        <input type="text" class="form-control txt-nama" name="nama" required />
                    </div>
                    <div class="form-group">
                        <label>Username/NIP: </label>
                        <input type="text" class="form-control txt-username" name="username" required />
                    </div>
                    <div class="form-group">
                        <label>Role: </label>
                        <select class="form-control txt-role" name="role" required>
                            @foreach(\App\Models\Role::all() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->role }}</option>
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
        username = $(this).data('username');
        role = $(this).data('role');
        
    });

    $('#edit').on('show.bs.modal', function() {
        $(".txtid").val(id);
        $(".txt-nama").val(nama);
        $(".txt-username").val(username);
        $(".txt-role").val(role);

    });

    $("#dataTable").on('click', '.btn-delete', function(e) {
        var conf = confirm('apakah anda yakin ingin menghapus data ini ?');
        if (conf == false) {
            e.preventDefault();
        }
    });
    $("#dataTable").on('click', '.btn-reset', function(e) {
        var conf = confirm('apakah anda yakin ingin reset password pengguna ini ?');
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