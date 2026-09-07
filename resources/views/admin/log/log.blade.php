@extends('master.master')

@section('page_title', 'Log Aktivitas Pengguna')

@section('custom_style')
<style>
    .log-timeline {
        position: relative;
    }
    .log-timeline::before {
        content: '';
        position: absolute;
        left: 20px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(180deg, var(--color-primary) 0%, transparent 100%);
        opacity: 0.2;
    }
    
    .log-badge-type {
        min-width: 90px;
        text-align: center;
    }
    
    .log-row:hover td {
        background-color: #f0f7ff !important;
    }
    
    .jenis-badge {
        font-size: 0.7rem;
        letter-spacing: 0.5px;
        padding: 0.3rem 0.6rem;
        border-radius: 12px;
        font-weight: 600;
    }
    
    .keterangan-cell {
        max-width: 300px;
    }
    
    .date-range-input .input-group-text {
        background: white;
        border-right: none;
    }
    .date-range-input .form-control {
        border-left: none;
    }
</style>
@stop

@section('content')

<x-alert />

<?php
setlocale(LC_TIME, 'id_ID');
\Carbon\Carbon::setLocale('id');
$date = date_default_timezone_set('Asia/Jakarta');
$today = date('Y-m-d H:i:s');
$weekAgo = date("Y-m-d", strtotime("-1 week"));

$logData = \App\Models\Log::whereBetween('created_at', [$weekAgo, $today])->orderBy('created_at','DESC')->get();
$totalLog = $logData->count();
$uniqueUsers = $logData->pluck('id_user')->unique()->count();
?>

<x-page-header title="Log Aktivitas Pengguna" subtitle="Riwayat semua aktivitas sistem dalam seminggu terakhir">
    <x-slot name="actions">
        <div class="bg-white rounded px-4 py-2 border shadow-sm text-center">
            <div class="text-xs text-muted fw-bold text-uppercase">Total Log (7 Hari)</div>
            <div class="h4 mb-0 fw-bold text-primary">{{ $totalLog }}</div>
        </div>
    </x-slot>
</x-page-header>

{{-- Summary Stats --}}
<div class="row mb-4 animate-fade-in-up">
    <div class="col-md-4">
        <x-stat-card title="Total Log (7 Hari)" value="{{ $totalLog }}" icon="fas fa-scroll" color="primary" />
    </div>
    <div class="col-md-4">
        <x-stat-card title="Pengguna Aktif" value="{{ $uniqueUsers }}" icon="fas fa-users" color="success" />
    </div>
    <div class="col-md-4">
        <x-stat-card title="Periode" value="7 Hari Terakhir" icon="fas fa-history" color="warning" />
    </div>
</div>

{{-- Filter Card --}}
<x-data-card title="Filter Log" icon="fas fa-filter" class="mb-4">
    <div class="row align-items-end">
        <div class="col-md-3">
            <div class="form-group mb-0">
                <label class="fw-bold text-dark small text-uppercase">Tanggal Mulai</label>
                <div class="input-group date-range-input">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar-alt text-primary"></i></span>
                    </div>
                    <input type="date" id="tanggal" class="form-control" name="tglmulai" value="{{ $weekAgo }}" />
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group mb-0">
                <label class="fw-bold text-dark small text-uppercase">Tanggal Selesai</label>
                <div class="input-group date-range-input">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar-check text-success"></i></span>
                    </div>
                    <input type="date" id="tanggal2" class="form-control" name="tglselesai" value="{{ date('Y-m-d') }}" />
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group mb-0">
                <label class="fw-bold text-dark small text-uppercase">Jenis Log</label>
                <div class="input-group date-range-input">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-tag text-info"></i></span>
                    </div>
                    <select id="jenis" name="jenis" class="form-control select2">
                        <option value="0">Semua Jenis</option>
                        @foreach(\App\Models\Logjenis::all() as $slk)
                        <option value="{{ $slk->id }}">{{ $slk->jenis }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <button type="button" id="lihat" class="btn btn-primary w-100 shadow-sm">
                <i class="fas fa-search me-2"></i> Cari Log
            </button>
        </div>
    </div>
</x-data-card>

{{-- Log Table --}}
<x-data-card title="Riwayat Aktivitas" icon="fas fa-list-ul">
    <x-slot name="actions">
        <span id="log-count-badge" class="badge bg-primary px-3 py-2">{{ $totalLog }} entri</span>
    </x-slot>
    <div class="tablelog p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th width="16%">Tanggal</th>
                        <th width="8%">Jam</th>
                        <th width="14%">Pengguna</th>
                        <th width="16%">Jenis Log</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logData as $data)
                    <?php
                    $jenisNama = \App\Models\Logjenis::where('id',$data->id_log_jenis)->pluck('jenis')->first() ?? '-';
                    $badgeClass = 'bg-secondary';
                    if(stripos($jenisNama, 'login') !== false) $badgeClass = 'bg-success';
                    elseif(stripos($jenisNama, 'logout') !== false) $badgeClass = 'bg-warning';
                    elseif(stripos($jenisNama, 'tambah') !== false || stripos($jenisNama, 'buat') !== false) $badgeClass = 'bg-primary';
                    elseif(stripos($jenisNama, 'edit') !== false || stripos($jenisNama, 'ubah') !== false) $badgeClass = 'bg-info';
                    elseif(stripos($jenisNama, 'hapus') !== false || stripos($jenisNama, 'batalkan') !== false) $badgeClass = 'bg-danger';
                    elseif(stripos($jenisNama, 'kirim') !== false || stripos($jenisNama, 'verifikasi') !== false) $badgeClass = 'bg-success';
                    ?>
                    <tr class="log-row">
                        <td class="align-middle">
                            <div class="fw-bold text-dark">{{ $data->created_at->isoFormat('D MMM Y') }}</div>
                            <div class="text-muted small">{{ $data->created_at->isoFormat('dddd') }}</div>
                        </td>
                        <td class="align-middle">
                            <span class="badge bg-secondary border px-2 py-1">{{ date('H:i:s', strtotime($data->created_at)) }}</span>
                        </td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px; font-size: 0.7rem; flex-shrink: 0;">
                                    {{ strtoupper(substr(\App\Models\User::where('id',$data->id_user)->pluck('username')->first() ?? 'U', 0, 1)) }}
                                </div>
                                <span class="fw-bold small">{{ \App\Models\User::where('id',$data->id_user)->pluck('username')->first() }}</span>
                            </div>
                        </td>
                        <td class="align-middle">
                            <span class="badge jenis-badge {{ $badgeClass }}">{{ $jenisNama }}</span>
                        </td>
                        <td class="align-middle keterangan-cell">
                            <span title="{{ $data->keterangan }}">{{ $data->keterangan }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-scroll fa-3x mb-3 text-gray-300"></i>
                                <p class="mb-0 fw-bold">Tidak ada log aktivitas.</p>
                                <p class="small">Coba ubah rentang tanggal atau filter jenis log di atas.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-data-card>

@stop

@section('custom_script')
<script>
    $(function() {
        $("#dataTable").DataTable({
            "ordering": false,
            "language": { url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json' },
            "pageLength": 25,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
            "order": []
        });

        setTimeout(function() { $(".alert-call, .alert-call2, .alert-call3, .alert-call4").fadeOut(500); }, 3500);
    });

    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

    $("#lihat").click(function() {
        if (!$("#tanggal").val() || !$("#tanggal2").val()) {
            alert('Lengkapi tanggal mulai dan tanggal selesai dahulu.');
            return;
        }

        const loadingHTML = `
            <div class="text-center py-5">
                <i class="fas fa-circle-notch fa-spin fa-3x text-primary mb-4"></i>
                <p class="fw-bold text-muted">Sedang memuat log...</p>
            </div>
        `;
        $(".tablelog").html(loadingHTML);

        $.ajax({
            type: "get",
            url: 'refresh-log/' + $("#tanggal").val() + '/' + $("#tanggal2").val() + '/' + $("#jenis").val(),
            data: {
                tanggal: $("#tanggal").val(),
                tanggal2: $("#tanggal2").val(),
                jenis: $("#jenis").val()
            },
            success: function(data) {
                $(".tablelog").html(data);
                // Update DataTable if the response contains a table
                if ($.fn.DataTable.isDataTable('#dataTable')) {
                    $('#dataTable').DataTable().destroy();
                }
                if ($("#dataTable").length) {
                    $("#dataTable").DataTable({
                        "ordering": false,
                        "pageLength": 25,
                        "language": { url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json' }
                    });
                }
                // Update count badge
                const rowCount = $(".tablelog tbody tr:not(:has(td[colspan]))").length;
                $("#log-count-badge").text(rowCount + " entri");
            },
            error: function() {
                $(".tablelog").html('<div class="text-center py-5 text-danger"><i class="fas fa-exclamation-triangle fa-3x mb-3"></i><p class="fw-bold">Gagal memuat data. Silakan coba lagi.</p></div>');
            }
        });
    });
</script>
@stop