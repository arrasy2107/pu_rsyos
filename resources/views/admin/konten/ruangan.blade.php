@extends('master.master')

@section('page_title', 'Data Ruangan')

@section('custom_style')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@stop

@section('content')

<x-alert />

<x-page-header title="Manajemen Ruangan" subtitle="Kelola data ruangan rawat inap rumah sakit">
    <x-slot name="actions">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah">
            <i class="fas fa-plus"></i> Tambah Ruangan
        </button>
    </x-slot>
</x-page-header>

<x-data-card title="Daftar Ruangan" icon="fas fa-door-open">
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Ruangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach(\App\Models\Ruangan::where('status',1)->get() as $data)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="fw-bold">{{ $data->nama_ruangan }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <button value="{{ $data->id }}" class="btn btn-sm btn-info btn-edit"
                                data-nama="{{ $data->nama_ruangan }}"
                                data-bs-toggle="modal" data-bs-target="#edit" title="Edit Ruangan">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a href="{{ route('deleteruangan',$data->id) }}"
                                class="btn btn-sm btn-danger btn-delete" title="Hapus Ruangan">
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
                <h5 class="modal-title fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i> Tambah Ruangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('tambahruangan') }}" autocomplete="off">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label>Nama Ruangan</label>
                        <div class="pu-input-icon-wrap">
                            <span class="pu-input-prefix"><i class="fas fa-door-open"></i></span>
                            <input type="text" class="form-control" name="nama_ruangan" placeholder="Contoh: Ruang Melati" required />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Ruangan</button>
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
                <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2 text-info"></i> Ubah Nama Ruangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('editruangan') }}" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <input type="hidden" class="txtid" name="id">
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label>Nama Ruangan</label>
                        <div class="pu-input-icon-wrap">
                            <span class="pu-input-prefix"><i class="fas fa-door-open"></i></span>
                            <input type="text" class="form-control txt-nama" name="nama_ruangan" required />
                        </div>
                    </div>
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

        let id, nama;
        $("#dataTable").on('click', '.btn-edit', function() {
            id = $(this).val();
            nama = $(this).data('nama');

            // populate immediately so modal shows values without extra clicks
            $(".txtid").val(id);
            $(".txt-nama").val(nama);
        });

        $('#edit').on('show.bs.modal', function() {
            $(".txtid").val(id);
            $(".txt-nama").val(nama);
        });

        $("#dataTable").on('click', '.btn-delete', function(e) {
            e.preventDefault();
            const url = this.href;
            PUAlert.confirm({
                    text: 'Apakah Anda yakin ingin menghapus data ruangan ini?',
                    confirmButtonText: 'Ya, hapus'
                })
                .then(function(confirmed) {
                    if (confirmed) window.location.href = url;
                });
        });

        setTimeout(function() {
            $(".alert-call").fadeOut(500);
        }, 3500);
    });
</script>
@stop