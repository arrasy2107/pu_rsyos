@extends('master.master')

@section('page_title', 'Data Pengguna')

@section('custom_style')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@stop

@section('content')

<x-alert />

<x-page-header title="Manajemen Pengguna" subtitle="Kelola akun dan hak akses pengguna sistem laporan">
    <x-slot name="actions">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah">
            <i class="fas fa-plus"></i> Tambah Pengguna
        </button>
    </x-slot>
</x-page-header>

<x-data-card title="Daftar Pengguna Aktif" icon="fas fa-users">
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username / NIP</th>
                    <th>Role Akses</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach(\App\Models\User::where('status',1)->where('id','<>',\Auth::user()->id)->get() as $data)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td class="fw-bold">{{ $data->nama }}</td>
                        <td><span class="badge bg-secondary pu-badge-mono">{{ $data->username }}</span></td>
                        <td><x-badge-role :role="$data->id_role" /></td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('resetpassword',$data->id) }}"
                                    class="btn btn-sm btn-warning btn-reset"
                                    title="Reset Password"
                                    data-bs-toggle="tooltip">
                                    <i class="fas fa-key"></i>
                                </a>
                                <button value="{{ $data->id }}" class="btn btn-sm btn-info btn-edit"
                                    data-nama="{{ $data->nama }}"
                                    data-username="{{ $data->username }}"
                                    data-role="{{ $data->id_role }}"
                                    data-bs-toggle="modal" data-bs-target="#edit"
                                    title="Edit Data">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <a href="{{ route('deletepengguna',$data->id) }}"
                                    class="btn btn-sm btn-danger btn-delete"
                                    title="Hapus"
                                    data-bs-toggle="tooltip">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</x-data-card>

{{-- MODAL TAMBAH --}}
<div id="tambah" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-user-plus me-2 text-primary"></i> Tambah Pengguna Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('tambahpengguna') }}" autocomplete="off">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <div class="pu-input-icon-wrap">
                            <span class="pu-input-prefix"><i class="fas fa-font"></i></span>
                            <input type="text" class="form-control" name="nama"
                                placeholder="Masukkan nama lengkap" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Username / NIP</label>
                        <div class="pu-input-icon-wrap">
                            <span class="pu-input-prefix"><i class="fas fa-id-card"></i></span>
                            <input type="text" class="form-control" name="username"
                                placeholder="Masukkan username/NIP"
                                autocomplete="nope" required />
                        </div>
                        <small class="text-muted mt-1 d-block">
                            <i class="fas fa-info-circle"></i> Password default: <strong>12345678</strong>
                        </small>
                    </div>
                    <div class="form-group mb-0">
                        <label>Hak Akses (Role)</label>
                        <select class="form-control" name="role" required>
                            <option value="" selected disabled hidden>Pilih Role...</option>
                            @foreach(\App\Models\Role::all() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->role }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="edit" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-user-edit me-2 text-info"></i> Ubah Data Pengguna
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('editpengguna') }}" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <input type="hidden" class="txtid" name="id">

                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <div class="pu-input-icon-wrap">
                            <span class="pu-input-prefix"><i class="fas fa-font"></i></span>
                            <input type="text" class="form-control txt-nama" name="nama" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Username / NIP</label>
                        <div class="pu-input-icon-wrap">
                            <span class="pu-input-prefix"><i class="fas fa-id-card"></i></span>
                            <input type="text" class="form-control txt-username" name="username" required />
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label>Hak Akses (Role)</label>
                        <select class="form-control txt-role" name="role" required>
                            @foreach(\App\Models\Role::all() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->role }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@stop

@section('custom_script')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();

        $("#dataTable").DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
            },
            pageLength: 10
        });

        // Edit Modal — populate fields
        let id, nama, username, role;
        $("#dataTable").on('click', '.btn-edit', function() {
            id = $(this).val();
            nama = $(this).data('nama');
            username = $(this).data('username');
            role = $(this).data('role');

            // populate immediately so modal shows values without extra clicks
            $(".txtid").val(id);
            $(".txt-nama").val(nama);
            $(".txt-username").val(username);
            $(".txt-role").val(role);
        });
        $('#edit').on('show.bs.modal', function() {
            $(".txtid").val(id);
            $(".txt-nama").val(nama);
            $(".txt-username").val(username);
            $(".txt-role").val(role);
        });

        // Confirmations
        $("#dataTable").on('click', '.btn-delete', function(e) {
            e.preventDefault();
            const url = this.href;
            PUAlert.confirm({
                title: 'Hapus pengguna?',
                text: 'Tindakan ini tidak dapat dibatalkan.',
                confirmButtonText: 'Ya, hapus'
            }).then(function(confirmed) {
                if (confirmed) window.location.href = url;
            });
        });
        $("#dataTable").on('click', '.btn-reset', function(e) {
            e.preventDefault();
            const url = this.href;
            PUAlert.confirm({
                title: 'Reset password pengguna?',
                text: 'Password akan diatur menjadi default: 12345678.',
                confirmButtonText: 'Ya, reset'
            }).then(function(confirmed) {
                if (confirmed) window.location.href = url;
            });
        });

        // Auto-hide alerts
        setTimeout(function() {
            $(".alert-call").fadeOut(500);
        }, 3500);
    });
</script>
@stop
