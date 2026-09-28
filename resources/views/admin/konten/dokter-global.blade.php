@extends('master.master')

@section('page_title', 'Data Dokter')

@section('custom_style')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .btn-action-group {
        display: flex;
        gap: 0.5rem;
    }

    /* Select2 overrides to match new design system */
    .select2-container .select2-selection--single {
        height: 42px !important;
        border: 1.5px solid var(--color-neutral-300) !important;
        border-radius: var(--radius-md) !important;
        font-family: var(--font-family) !important;
        font-size: var(--font-size-sm) !important;
    }

    .select2-selection__rendered {
        line-height: 40px !important;
        padding-left: 2.5rem !important;
        /* Space for icon */
        color: var(--color-neutral-900) !important;
    }

    .select2-selection__arrow {
        height: 40px !important;
    }

    .select2-container--default .select2-selection--single:focus,
    .select2-container--open .select2-selection--single {
        border-color: var(--color-accent) !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
        outline: none !important;
    }

    .select2-dropdown {
        border: 1.5px solid var(--color-neutral-300) !important;
        border-radius: var(--radius-md) !important;
        box-shadow: var(--shadow-md) !important;
        font-family: var(--font-family) !important;
        font-size: var(--font-size-sm) !important;
    }
</style>
@stop

@section('content')

<x-alert />

<x-page-header title="Manajemen Dokter" subtitle="Kelola Data Dokter">
    <x-slot name="actions">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah">
            <i class="fas fa-plus"></i> Tambah Dokter
        </button>
    </x-slot>
</x-page-header>

<x-data-card title="Daftar Dokter Jaga" icon="fas fa-user-md">
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Dokter</th>
                    <th>Subrumpun SDMK</th>
                    <th>Jenis SDMK</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach(\App\Models\Dokter::where('status', 1)->get() as $data)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="fw-bold">{{ $data->nama_dokter }}</td>
                    <td>{{ \App\Models\sdmk_subrumpun::where('id',\App\Models\sdmk_jenis::where('id',$data->id_sdmk_jenis)->pluck('id_subrumpun')->first())->pluck('subrumpun')->first() }}</td>
                    <td><span class="badge bg-secondary">{{ \App\Models\sdmk_jenis::where('id',$data->id_sdmk_jenis)->pluck('jenis')->first() }}</span></td>
                    <td>
                        <div class="d-flex gap-2">
                            <button value="{{ $data->id }}" class="btn btn-sm btn-info btn-edit"
                                data-nama="{{ $data->nama_dokter }}"
                                data-jenis="{{ $data->id_sdmk_jenis }}"
                                data-bs-toggle="modal" data-bs-target="#edit" title="Edit Dokter">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('deletedokter', $data->id) }}" method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus dokter ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Dokter">
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
                <h5 class="modal-title fw-bold"><i class="fas fa-user-plus me-2 text-primary"></i> Tambah Dokter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('tambahdokter') }}" autocomplete="off">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Dokter</label>
                        <div class="pu-input-icon-wrap">
                            <span class="pu-input-prefix"><i class="fas fa-user-md"></i></span>
                            <input type="text" class="form-control" name="nama_dokter" placeholder="Contoh: dr. Budi Santoso" required />
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label>Jenis SDMK</label>
                        <select class="form-control select2" name="id_sdmk_jenis" style="width: 100%" required>
                            <option value="">-- Pilih Jenis SDMK --</option>
                            @foreach(\App\Models\sdmk_jenis::all() as $sj)
                                <option value="{{ $sj->id }}">{{ $sj->jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Dokter</button>
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
                <h5 class="modal-title fw-bold"><i class="fas fa-user-edit me-2 text-info"></i> Ubah Data Dokter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('editdokter') }}" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <input type="hidden" class="txtid" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Dokter</label>
                        <div class="pu-input-icon-wrap">
                            <span class="pu-input-prefix"><i class="fas fa-user-md"></i></span>
                            <input type="text" class="form-control txt-nama" name="nama_dokter" required />
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label>Jenis SDMK</label>
                        <select class="form-control select2 txt-jenis" name="id_sdmk_jenis" style="width: 100%" required>
                            <option value="">-- Pilih Jenis SDMK --</option>
                            @foreach(\App\Models\sdmk_jenis::all() as $sj)
                                <option value="{{ $sj->id }}">{{ $sj->jenis }}</option>
                            @endforeach
                        </select>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $("#dataTable").DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
            },
            pageLength: 10
        });

        // Initialize Select2 with proper dropdown parent so it works inside modals
        $('#tambah .select2').select2({
            dropdownParent: $('#tambah')
        });
        
        $('#edit .select2').select2({
            dropdownParent: $('#edit')
        });

        let id, nama, jenis;
        $("#dataTable").on('click', '.btn-edit', function() {
            id = $(this).val();
            nama = $(this).data('nama');
            jenis = $(this).data('jenis');

            // populate immediately so modal shows values without extra clicks
            $(".txtid").val(id);
            $(".txt-nama").val(nama);
            $(".txt-jenis").val(jenis).trigger('change');
        });

        $('#edit').on('show.bs.modal', function() {
            $(".txtid").val(id);
            $(".txt-nama").val(nama);
            $(".txt-jenis").val(jenis).trigger('change');
        });



        setTimeout(function() {
            $(".alert-call").fadeOut(500);
        }, 3500);
    });
</script>
@stop
