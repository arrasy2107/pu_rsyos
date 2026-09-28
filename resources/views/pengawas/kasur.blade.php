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
<x-page-header title="Manajemen Kasur" subtitle="Kelola ketersediaan dan status operasional kasur" />

<x-data-card title="Daftar Kasur" icon="fas fa-procedures">
    <div class="row mb-3">
        <!-- <div class="col-md-3">
            <label for="filterKasurRuangan" class="form-label">Pilih Unit</label>
            <select id="filterKasurRuangan" class="form-control select2">
                <option value="">Semua Unit</option>
                @foreach($kamars->pluck('ruangan')->filter()->unique('id')->sortBy('nama_ruangan') as $ruangan)
                <option value="{{ $ruangan->id }}" {{ session('kasur_ruangan_filter') == $ruangan->id ? 'selected' : '' }}>{{ $ruangan->nama_ruangan }}</option>
                @endforeach
            </select>
        </div> -->
        <div class="col-md-3">
            <label for="filterKasurKamar" class="form-label">Pilih Kamar</label>
            <select id="filterKasurKamar" class="form-control select2">
                <option value="">Semua Kamar</option>
                @foreach($kamars->filter(fn($kamar) => $kamar->ruangan)->sortBy('nama_kamar') as $kamar)
                <option value="{{ $kamar->id }}" data-ruangan-id="{{ $kamar->id_ruangan }}" {{ session('kasur_kamar_filter') == $kamar->id ? 'selected' : '' }}>{{ $kamar->nama_kamar }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="text-muted small fw-bold d-none d-md-block" style="visibility: hidden;">Aksi</label>
            <a href="{{ route('data-kasur') }}?reset=1" class="btn btn-outline-secondary" id="resetKasurFilter" title="Reset / Refresh" aria-label="Reset / Refresh">
                <i class="fas fa-sync"></i>
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="dataTableKasur" width="100%">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="5%">Kode Kasur</th>
                    <th width="15%">Kamar</th>
                    <!-- <th width="15%">Unit</th> -->
                    <th width="20%">Status</th>
                    <th width="40%">Keterangan</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kasurs as $kasur)
                <tr data-ruangan-id="{{ $kasur->kamar->id_ruangan }}" data-kamar-id="{{ $kasur->id_kamar }}">
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-bold">{{ $kasur->kode_kasur }}</td>
                    <td>{{ $kasur->kamar->nama_kamar }}</td>
                    <!-- <td>{{ $kasur->kamar->ruangan->nama_ruangan }}</td> -->
                    <td>
                        <form method="post" action="{{ route('operasionalkasur', $kasur) }}" class="js-kasur-status-form">
                            @csrf @method('PATCH')
                            <input type="hidden" name="filter_ruangan" class="filter-ruangan-hidden" value="{{ session('kasur_ruangan_filter', '') }}">
                            <input type="hidden" name="filter_kamar" class="filter-kamar-hidden" value="{{ session('kasur_kamar_filter', '') }}">
                            <select name="status_operasional" class="form-control select2 js-status-operasional" data-kasur-id="{{ $kasur->id }}" aria-label="Ketersediaan {{ $kasur->kode_kasur }}">
                                <option value="available" {{ $kasur->status_operasional === 'available' ? 'selected' : '' }}>Tersedia</option>
                                <option value="occupied" {{ $kasur->status_operasional === 'occupied' ? 'selected' : '' }}>Terisi</option>
                                <option value="maintenance" {{ $kasur->status_operasional === 'maintenance' ? 'selected' : '' }}>Perbaikan</option>
                                <option value="reserved" {{ $kasur->status_operasional === 'reserved' ? 'selected' : '' }}>Dipesan</option>
                                <option value="cleaning" {{ $kasur->status_operational === 'cleaning' ? 'selected' : '' }}>Dibersihkan</option>
                            </select>
                        </form>
                    </td>
                    <td class="kasur-keterangan-cell">
                        <div class="d-flex align-items-center gap-2">
                            <span class="kasur-keterangan-value">{{ $kasur->keterangan ?: '-' }}</span>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary btn-edit-keterangan" data-id="{{ $kasur->id }}" data-keterangan="{{ $kasur->keterangan ?: '' }}" data-bs-toggle="modal" data-bs-target="#editKeteranganKasur" title="Edit Keterangan">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-data-card>

<div class="modal fade" id="editKeteranganKasur" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2 text-primary"></i>Edit Keterangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" id="formEditKeteranganKasur" class="js-keterangan-kasur-form">
                @csrf
                @method('PATCH')
                <input type="hidden" name="filter_ruangan" class="filter-ruangan-hidden" value="{{ session('kasur_ruangan_filter', '') }}">
                <input type="hidden" name="filter_kamar" class="filter-kamar-hidden" value="{{ session('kasur_kamar_filter', '') }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" id="editKeteranganKasurText" class="form-control" placeholder="Masukkan keterangan">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
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
    $(function() {
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

        function syncKasurFilterHiddenInputs() {
            const ruangan = $('#filterKasurRuangan').val() || '';
            const kamar = $('#filterKasurKamar').val() || '';

            $('.filter-ruangan-hidden').val(ruangan);
            $('.filter-kamar-hidden').val(kamar);
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
            syncKasurFilterHiddenInputs();
            applyKasurFilters();
        });

        $('#filterKasurKamar').on('change', function() {
            syncKasurFilterHiddenInputs();
            applyKasurFilters();
        });

        $('#filterKasurRuangan, #filterKasurKamar').select2({
            width: '100%',
            allowClear: true
        });

        $('#dataTableKasur select[name="status_operasional"]').select2({
            width: '100%',
            allowClear: false,
            minimumResultsForSearch: -1
        });

        const keteranganKasurRouteTemplate = "{{ route('keterangan-kasur', ['kasur' => '__KASUR_ID__']) }}";

        const csrfToken = $('meta[name="csrf-token"]')?.attr('content') || '';

        $('.btn-edit-keterangan').on('click', function() {
            const id = $(this).data('id');
            const keterangan = $(this).data('keterangan') || '';
            const route = keteranganKasurRouteTemplate.replace('__KASUR_ID__', id);
            $('#formEditKeteranganKasur').attr('action', route);
            $('#editKeteranganKasurText').val(keterangan);
        });

        $('#dataTableKasur').on('change', 'select[name="status_operasional"]', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            const data = {
                _token: csrfToken,
                _method: 'PATCH',
                status_operasional: $(this).val(),
                filter_ruangan: $('#filterKasurRuangan').val() || '',
                filter_kamar: $('#filterKasurKamar').val() || '',
            };

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: data,
                headers: { 'X-CSRF-TOKEN': csrfToken },
                success: function(res) {
                    if (res.success) {
                        PUAlert.success(res.message || 'Ketersediaan kasur berhasil diubah');
                        $('#dataTableKasur').DataTable().draw(false);
                    }
                },
                error: function(xhr) {
                    PUAlert.error(xhr.responseJSON?.message || 'Gagal mengubah ketersediaan kasur.');
                }
            });
        });

        $('#formEditKeteranganKasur').on('submit', function(e) {
            e.preventDefault();
            const form = this;
            const data = {
                _token: csrfToken,
                _method: 'PATCH',
                keterangan: $('#editKeteranganKasurText').val(),
                filter_ruangan: $('#filterKasurRuangan').val() || '',
                filter_kamar: $('#filterKasurKamar').val() || '',
            };

            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                data: data,
                headers: { 'X-CSRF-TOKEN': csrfToken },
                success: function(res) {
                    if (res.success) {
                        const id = Number($(form).attr('action').split('/').pop());
                        const row = $('#dataTableKasur').find('button.btn-edit-keterangan[data-id="' + id + '"]').closest('tr');
                        if (row.length) {
                            $(row).find('.kasur-keterangan-value').text($('#editKeteranganKasurText').val() || '-');
                        }
                        $('#editKeteranganKasur').modal('hide');
                        $('#dataTableKasur').DataTable().draw(false);
                        PUAlert.success(res.message || 'Keterangan kasur berhasil diubah');
                    }
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message || 'Gagal mengubah keterangan kasur.';
                    PUAlert.error(message);
                }
            });
        });
    });
</script>
@stop