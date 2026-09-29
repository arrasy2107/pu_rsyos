@extends('master.master')

@section('page_title', 'Data Pengawas Umum')

@section('custom_style')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@stop

@section('content')

<x-alert />

<x-page-header title="Manajemen Pengawas Umum" subtitle="Kelola akun dan data khusus role Pengawas Umum">
    <x-slot name="actions">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah">
            <i class="fas fa-plus"></i> Tambah Pengawas Umum
        </button>
    </x-slot>
</x-page-header>

<x-data-card title="Daftar Pengawas Umum" icon="fas fa-user-shield">
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Pengawas</th>
                    <th>Username / NIP</th>
                    <th>Password</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach(\App\Models\User::where('id_role',2)->where('status',1)->get() as $data)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="fw-bold">{{ $data->nama }}</td>
                    <td><span class="badge bg-secondary pu-badge-mono">{{ $data->username }}</span></td>
                    <td><span class="text-muted">******</span></td>
                    <td>
                        <div class="d-flex gap-2">
                            <button value="{{ $data->id }}" class="btn btn-sm btn-info btn-edit"
                                data-nama="{{ $data->nama }}" data-username="{{ $data->username }}"
                                data-bs-toggle="modal" data-bs-target="#edit" title="Edit Data">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('deletepengguna', $data->id) }}" method="POST"
                                class="d-inline form-delete-pengawas">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
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
                <h5 class="modal-title fw-bold"><i class="fas fa-user-plus me-2 text-primary"></i> Tambah Pengawas Umum</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('tambahpengguna') }}" autocomplete="off">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <div class="pu-input-icon-wrap">
                            <span class="pu-input-prefix"><i class="fas fa-font"></i></span>
                            <input type="text" class="form-control" name="nama" placeholder="Masukkan nama lengkap" required />
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label>Username / NIP</label>
                        <div class="pu-input-icon-wrap">
                            <span class="pu-input-prefix"><i class="fas fa-id-card"></i></span>
                            <input type="text" class="form-control" name="username" placeholder="Masukkan username/NIP" autocomplete="nope" required />
                        </div>
                        <small class="text-muted mt-1 d-block"><i class="fas fa-info-circle"></i> Password default: <strong>12345678</strong></small>
                    </div>
                    {{-- id_role = 2 (Pengawas Umum) --}}
                    <input type="hidden" name="role" value="2">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Data</button>
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
                <h5 class="modal-title fw-bold"><i class="fas fa-user-edit me-2 text-info"></i> Ubah Data Pengawas Umum</h5>
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
                    <div class="form-group mb-0">
                        <label>Username / NIP</label>
                        <div class="pu-input-icon-wrap">
                            <span class="pu-input-prefix"><i class="fas fa-id-card"></i></span>
                            <input type="text" class="form-control txt-username" name="username" required />
                        </div>
                    </div>
                    {{-- Role Pengawas Umum dipertahankan saat data diperbarui. --}}
                    <input type="hidden" name="role" value="2">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info"><i class="fas fa-save me-1"></i> Simpan Perubahan</button>
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
        $("#dataTable").DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
            },
            pageLength: 10
        });

        let id, nama, username;
        $("#dataTable").on('click', '.btn-edit', function() {
            id = $(this).val();
            nama = $(this).data('nama');
            username = $(this).data('username');

            // populate immediately so modal shows values without extra clicks
            $(".txtid").val(id);
            $(".txt-nama").val(nama);
            $(".txt-username").val(username);
        });

        $('#edit').on('show.bs.modal', function() {
            $(".txtid").val(id);
            $(".txt-nama").val(nama);
            $(".txt-username").val(username);
        });

        // Konfirmasi hapus pengawas via SweetAlert
        $(document).on('submit', '.form-delete-pengawas', function(e) {
            e.preventDefault();
            const form = this;
            PUAlert.confirmAction({
                title: 'Hapus Pengawas?',
                text: 'Data pengawas ini akan dihapus dari sistem.',
                icon: 'warning',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }, function() { form.submit(); });
        });
    });
</script>
@stop
