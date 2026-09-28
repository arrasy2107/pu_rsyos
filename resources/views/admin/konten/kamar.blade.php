@extends('master.master')

@section('page_title', 'Data Kamar')

@section('custom_style')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<style>
    .select2-container {
        width: 100% !important;
    }

    .select2-container .select2-selection--single {
        height: 38px;
        border: 1px solid #d1d3e2;
        border-radius: .35rem;
    }

    .select2-selection__rendered {
        line-height: 36px !important;
    }

    .select2-selection__arrow {
        height: 36px !important;
    }
</style>
@stop

@section('content')
<x-alert />
@php($isReadOnly = (int) auth()->user()->id_role === 3)
<x-page-header title="Manajemen Kamar" subtitle="Kelola kamar berdasarkan unit rawat inap">
    @if(!$isReadOnly)
    <x-slot name="actions">
        <a class="btn btn-outline-primary" href="{{ route('data-ruangan') }}"><i class="fas fa-door-open me-1"></i> Data Unit</a>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahKamar"><i class="fas fa-plus me-1"></i> Tambah Kamar</button>
    </x-slot>
    @endif
</x-page-header>

<x-data-card title="Daftar Kamar" icon="fas fa-bed">
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="filterKamarRuangan" class="form-label">Pilih Unit</label>
            <select id="filterKamarRuangan" class="form-control select2" data-placeholder="Pilih unit">
                <option value="">Semua Unit</option>
                @foreach($ruangans as $ruangan)
                    <option value="{{ $ruangan->id }}">{{ $ruangan->nama_ruangan }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="dataTableKamar" width="100%">
            <thead class="table-light text-center" >
                <tr>
                    <th width="5%">No</th>
                    <th>Kamar</th>
                    <th>Unit</th>
                    <th>Jumlah Kasur</th>
                    @if(!$isReadOnly)<th>
                        <form method="post" action="{{ route('statuskamar.semua') }}" class="bulk-status-form d-flex align-items-center justify-content-center gap-2">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="{{ $kamars->count() > 0 && $kamars->where('status', true)->count() === $kamars->count() ? 0 : 1 }}">
                            <input type="checkbox" class="form-check-input bulk-status-toggle" {{ $kamars->count() > 0 && $kamars->where('status', true)->count() === $kamars->count() ? 'checked' : '' }} title="Aktifkan/nonaktifkan seluruh kamar">
                            <span>Status</span>
                        </form>
                    </th>
                    @endif
                    <th>Keterangan</th>
                    @if(!$isReadOnly)<th>Aksi</th>@endif
                </tr>
            </thead>
            <tbody>@foreach($kamars as $kamar)<tr data-ruangan-id="{{ $kamar->id_ruangan }}">
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-bold">{{ $kamar->nama_kamar }}</td>
                    <td>{{ $kamar->ruangan->nama_ruangan }}</td>
                    <td class="text-center">{{ $kamar->kasur->count() }}</td>
                    @if(!$isReadOnly)<td>
                        <form method="post" action="{{ route('statuskamar', $kamar) }}" class="d-flex align-items-center gap-2">
                            @csrf @method('PATCH')
                            <input type="checkbox" class="form-check-input" {{ $kamar->status ? 'checked' : '' }} onchange="this.form.submit()" title="Aktifkan/nonaktifkan kamar">
                            <span>{{ $kamar->status ? 'Aktif' : 'Nonaktif' }}</span>
                        </form>
                    </td>
                    @endif
                    <td>{{ $kamar->keterangan ?: '-' }}</td>
                    @if(!$isReadOnly)<td class="text-nowrap"><button type="button" class="btn btn-sm btn-info btn-edit-kamar" data-id="{{ $kamar->id }}" data-ruangan="{{ $kamar->id_ruangan }}" data-nama="{{ $kamar->nama_kamar }}" data-keterangan="{{ $kamar->keterangan }}" data-bs-toggle="modal" data-bs-target="#editKamar" title="Edit Kamar"><i class="fas fa-edit"></i></button>
                        <form method="post" action="{{ route('deletekamar', $kamar) }}" class="d-inline form-delete-kamar">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-danger" title="Nonaktifkan Kamar"><i class="fas fa-trash-alt"></i></button></form>
                    </td>@endif
                </tr>@endforeach</tbody>
        </table>
    </div>
</x-data-card>

@if(!$isReadOnly)
<div class="modal fade" id="tambahKamar" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i>Tambah Kamar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('tambahkamar') }}" autocomplete="off">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Unit</label>
                        <select name="id_ruangan" class="form-control select2" style="width: 100%" required>
                            <option value="">-- Pilih Unit --</option>
                            @foreach($ruangans->where('status', true) as $ruangan)
                                <option value="{{ $ruangan->id }}">{{ $ruangan->nama_ruangan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Nama Kamar</label>
                        <input name="nama_kamar" class="form-control" placeholder="Contoh: Thamrin 1" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Keterangan</label>
                        <input name="keterangan" class="form-control">
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editKamar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2 text-info"></i>Edit Kamar</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="{{ route('editkamar') }}">@csrf @method('PUT')<input type="hidden" name="id" id="editKamarId">
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Unit</label><select name="id_ruangan" id="editKamarRuangan" class="form-control select2" data-placeholder="Pilih unit" required>
                            <option value=""></option>@foreach($ruangans->where('status', true) as $ruangan)<option value="{{ $ruangan->id }}">{{ $ruangan->nama_ruangan }}</option>@endforeach
                        </select></div>
                    <div class="mb-3"><label class="form-label">Nama Kamar</label><input name="nama_kamar" id="editKamarNama" class="form-control" required></div>
                    <div><label class="form-label">Keterangan</label><input name="keterangan" id="editKamarKeterangan" class="form-control"></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button class="btn btn-info"><i class="fas fa-save me-1"></i>Simpan Perubahan</button></div>
            </form>
        </div>
    </div>
</div>
@endif
@stop

@section('custom_script')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(function() {
        $('.bulk-status-toggle').on('change', function() {
            const checkbox = this;
            const form = this.form;
            const checked = this.checked;

            PUAlert.confirmAction({
                text: checked ? 'Seluruh kamar akan diaktifkan.' : 'Seluruh kamar beserta kasur di dalamnya akan dinonaktifkan.',
                confirmButtonText: checked ? 'Ya, aktifkan semua' : 'Ya, nonaktifkan semua',
                cancelButtonText: 'Batal'
            }, function() {
                $(checkbox).siblings('input[name="status"]').val(checked ? 1 : 0);
                checkbox.checked = checked;
                form.submit();
            });
            checkbox.checked = !checked;
        });

        const kamarTable = $('#dataTableKamar').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
            },
            pageLength: 10
        });
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            if (settings.nTable.id !== 'dataTableKamar') return true;
            const ruanganId = $('#filterKamarRuangan').val();
            const row = $(kamarTable.row(dataIndex).node());
            return !ruanganId || row.data('ruangan-id').toString() === ruanganId;
        });
        $('#filterKamarRuangan').on('change', function() {
            kamarTable.draw();
        });
        $('#filterKamarRuangan').select2({
            width: '100%',
            allowClear: true
        });
        $('#tambahKamar .select2').select2({
            width: '100%',
            allowClear: true,
            dropdownParent: $('#tambahKamar')
        });

        $('#editKamar .select2').select2({
            width: '100%',
            allowClear: true,
            dropdownParent: $('#editKamar')
        });
        $('.btn-edit-kamar').on('click', function() {
            $('#editKamarId').val($(this).data('id'));
            $('#editKamarRuangan').val($(this).data('ruangan')).trigger('change');
            $('#editKamarNama').val($(this).data('nama'));
            $('#editKamarKeterangan').val($(this).data('keterangan') || '');
        });
        $('.form-delete-kamar').on('submit', function(e) {
            e.preventDefault();
            const form = this;

            PUAlert.confirmAction({
                text: 'Kamar akan dinonaktifkan beserta kasur di dalamnya.',
                confirmButtonText: 'Ya, nonaktifkan',
                cancelButtonText: 'Batal'
            }, function() {
                form.submit();
            });
        });
    });
</script>
@stop