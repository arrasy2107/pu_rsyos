@extends('master.master')

@section('page_title', 'Data Kasur')

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
<x-page-header title="Manajemen Kasur" subtitle="Kelola ketersediaan dan status operasional kasur">
    <x-slot name="actions">
        <a class="btn btn-outline-primary" href="{{ route('data-kamar') }}"><i class="fas fa-bed me-1"></i> Data Kamar</a>
        @if(!$isReadOnly)
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahKasur"><i class="fas fa-plus me-1"></i> Tambah Kasur</button>
        @endif
    </x-slot>
</x-page-header>

<x-data-card title="Daftar Kasur" icon="fas fa-procedures">
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="filterKasurRuangan" class="form-label">Pilih Unit</label>
            <select id="filterKasurRuangan" class="form-control select2">
                <option value="">Semua Unit</option>
                @foreach($kamars->pluck('ruangan')->filter()->unique('id')->sortBy('nama_ruangan') as $ruangan)
                <option value="{{ $ruangan->id }}">{{ $ruangan->nama_ruangan }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="filterKasurKamar" class="form-label">Pilih Kamar</label>
            <select id="filterKasurKamar" class="form-control select2">
                <option value="">Semua Kamar</option>
                @foreach($kamars->filter(fn($kamar) => $kamar->ruangan)->sortBy('nama_kamar') as $kamar)
                <option value="{{ $kamar->id }}" data-ruangan-id="{{ $kamar->id_ruangan }}">{{ $kamar->nama_kamar }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="dataTableKasur" width="100%">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Kode Kasur</th>
                    <th>Kamar</th>
                    <th>Unit</th>
                    @if(!$isReadOnly)<th>
                        <form method="post" action="{{ route('statuskasur.semua') }}" class="bulk-status-form d-flex align-items-center justify-content-center gap-2">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="{{ $kasurs->count() > 0 && $kasurs->where('status', true)->count() === $kasurs->count() ? 0 : 1 }}">
                            <input type="checkbox" class="form-check-input bulk-status-toggle" {{ $kasurs->count() > 0 && $kasurs->where('status', true)->count() === $kasurs->count() ? 'checked' : '' }} title="Aktifkan/nonaktifkan seluruh kasur">
                            <span>Status</span>
                        </form>
                    </th>
                    @endif
                    <th>Ketersediaan</th>
                    <th>Keterangan</th>
                    @if(!$isReadOnly)<th>Aksi</th>@endif
                </tr>
            </thead>
            <tbody>
                @foreach($kasurs as $kasur)<tr data-ruangan-id="{{ $kasur->kamar->id_ruangan }}" data-kamar-id="{{ $kasur->id_kamar }}">
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-bold">{{ $kasur->kode_kasur }}</td>
                    <td>{{ $kasur->kamar->nama_kamar }}</td>
                    <td>{{ $kasur->kamar->ruangan->nama_ruangan }}</td>
                    @if(!$isReadOnly)<td>
                        <form method="post" action="{{ route('statuskasur', $kasur) }}" class="d-flex align-items-center gap-2">
                            @csrf @method('PATCH')
                            <input type="checkbox" class="form-check-input" {{ $kasur->status ? 'checked' : '' }} onchange="this.form.submit()" title="Aktifkan/nonaktifkan kasur">
                            <span>{{ $kasur->status ? 'Aktif' : 'Nonaktif' }}</span>
                        </form>
                    </td>
                    @endif
                    <td>
                        <span class="badge bg-primary">{{ ['available' => 'Tersedia', 'occupied' => 'Terisi', 'maintenance' => 'Perbaikan', 'reserved' => 'Dipesan', 'cleaning' => 'Dibersihkan'][$kasur->status_operasional] ?? $kasur->status_operasional }}</span>
                    </td>
                    <td>{{ $kasur->keterangan ?: '-' }}</td>
                    @if(!$isReadOnly)<td class="text-nowrap">
                        <button type="button" class="btn btn-sm btn-info btn-edit-kasur" data-id="{{ $kasur->id }}" data-kamar="{{ $kasur->id_kamar }}" data-kode="{{ $kasur->kode_kasur }}" data-status="{{ $kasur->status_operasional }}" data-keterangan="{{ $kasur->keterangan }}" data-bs-toggle="modal" data-bs-target="#editKasur" title="Edit Kasur"><i class="fas fa-edit"></i></button>
                        <form method="post" action="{{ route('deletekasur', $kasur) }}" class="d-inline form-delete-kasur">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-danger" title="Nonaktifkan Kasur"><i class="fas fa-trash-alt"></i></button></form>
                    </td>@endif
                </tr>@endforeach</tbody>
        </table>
    </div>
</x-data-card>

@if(!$isReadOnly)
<div class="modal fade" id="tambahKasur" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i>Tambah Kasur</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="{{ route('tambahkasur') }}">@csrf<div class="modal-body">
                    <div class="mb-3"><label class="form-label">Kamar</label><select name="id_kamar" class="form-control select2" data-placeholder="Pilih kamar" required>
                            <option value=""></option>@foreach($kamars->where('status', true)->filter(fn($kamar) => $kamar->ruangan && $kamar->ruangan->status) as $kamar)<option value="{{ $kamar->id }}">{{ $kamar->ruangan->nama_ruangan }} - {{ $kamar->nama_kamar }}</option>@endforeach
                        </select></div>
                    <div class="mb-3"><label class="form-label">Kode Kasur</label><input name="kode_kasur" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Ketersediaan</label><select name="status_operasional" class="form-control select2" data-placeholder="Pilih ketersediaan">
                            <option value="available">Tersedia</option>
                            <option value="occupied">Terisi</option>
                            <option value="maintenance">Perbaikan</option>
                            <option value="reserved">Dipesan</option>
                            <option value="cleaning">Dibersihkan</option>
                        </select></div>
                    <div><label class="form-label">Keterangan</label><input name="keterangan" class="form-control"></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editKasur" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2 text-info"></i>Edit Kasur</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="{{ route('editkasur') }}">@csrf @method('PUT')<input type="hidden" name="id" id="editKasurId">
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Kamar</label><select name="id_kamar" id="editKasurKamar" class="form-control select2" data-placeholder="Pilih kamar" required>
                            <option value=""></option>@foreach($kamars->where('status', true)->filter(fn($kamar) => $kamar->ruangan && $kamar->ruangan->status) as $kamar)<option value="{{ $kamar->id }}">{{ $kamar->ruangan->nama_ruangan }} - {{ $kamar->nama_kamar }}</option>@endforeach
                        </select></div>
                    <div class="mb-3"><label class="form-label">Kode Kasur</label><input name="kode_kasur" id="editKasurKode" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Ketersediaan</label><select name="status_operasional" id="editKasurStatus" class="form-control select2" data-placeholder="Pilih ketersediaan">
                            <option value="available">Tersedia</option>
                            <option value="occupied">Terisi</option>
                            <option value="maintenance">Perbaikan</option>
                            <option value="reserved">Dipesan</option>
                            <option value="cleaning">Dibersihkan</option>
                        </select></div>
                    <div><label class="form-label">Keterangan</label><input name="keterangan" id="editKasurKeterangan" class="form-control"></div>
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
                text: checked ? 'Seluruh kasur akan diaktifkan.' : 'Seluruh kasur akan dinonaktifkan dan tidak dapat digunakan.',
                confirmButtonText: checked ? 'Ya, aktifkan semua' : 'Ya, nonaktifkan semua',
                cancelButtonText: 'Batal'
            }, function() {
                $(checkbox).siblings('input[name="status"]').val(checked ? 1 : 0);
                checkbox.checked = checked;
                form.submit();
            });
            checkbox.checked = !checked;
        });

        const kasurTable = $('#dataTableKasur').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
            },
            pageLength: 10
        });
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            if (settings.nTable.id !== 'dataTableKasur') return true;
            const ruanganId = $('#filterKasurRuangan').val();
            const kamarId = $('#filterKasurKamar').val();
            const row = $(kasurTable.row(dataIndex).node());
            return (!ruanganId || row.data('ruangan-id').toString() === ruanganId) &&
                (!kamarId || row.data('kamar-id').toString() === kamarId);
        });

        function applyKasurFilters() {
            kasurTable.draw();
        }
        $('#filterKasurRuangan').on('change', function() {
            const ruanganId = this.value;
            const selectedKamar = $('#filterKasurKamar').val();

            $('#filterKasurKamar option').each(function() {
                const visible = !this.value || !ruanganId || $(this).data('ruangan-id').toString() === ruanganId;
                $(this).prop('disabled', !visible);
            });

            if (selectedKamar && $('#filterKasurKamar option:selected').prop('disabled')) {
                $('#filterKasurKamar').val('').trigger('change');
            }

            $('#filterKasurKamar').trigger('change.select2');
            applyKasurFilters();
        });
        $('#filterKasurKamar').on('change', applyKasurFilters);
        $('#filterKasurRuangan, #filterKasurKamar').select2({
            width: '100%',
            allowClear: true
        });
        $('#tambahKasur .select2').select2({
            width: '100%',
            allowClear: true,
            dropdownParent: $('#tambahKasur')
        });

        $('#editKasur .select2').select2({
            width: '100%',
            allowClear: true,
            dropdownParent: $('#editKasur')
        });
        $('.btn-edit-kasur').on('click', function() {
            $('#editKasurId').val($(this).data('id'));
            $('#editKasurKamar').val($(this).data('kamar')).trigger('change');
            $('#editKasurKode').val($(this).data('kode'));
            $('#editKasurStatus').val($(this).data('status')).trigger('change');
            $('#editKasurKeterangan').val($(this).data('keterangan') || '');
        });
        $('.form-delete-kasur').on('submit', function(e) {
            e.preventDefault();
            const form = this;

            PUAlert.confirmAction({
                text: 'Kasur akan dinonaktifkan dan tidak dapat digunakan.',
                confirmButtonText: 'Ya, nonaktifkan',
                cancelButtonText: 'Batal'
            }, function() {
                form.submit();
            });
        });
    });
</script>
@stop