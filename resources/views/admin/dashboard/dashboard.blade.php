@extends('master.master')

@section('page_title', 'Dashboard Laporan')

@section('custom_style')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/fixedcolumns/3.3.3/css/fixedColumns.bootstrap5.min.css" rel="stylesheet">
<style>
    /* Custom override for DataTables */
    table.dataTable {
        border-collapse: collapse !important;
    }

    table.dataTable thead th {
        background: var(--color-primary-800) !important;
        color: white !important;
        border-bottom: none !important;
        white-space: nowrap;
    }

    .dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody {
        overflow-x: scroll !important;
    }

    .icon-hover-container {
        transition: var(--transition-fast);
    }

    .icon-hover-container:hover {
        transform: scale(1.05);
    }

    /* ── KPI Strip ── */
    .pu-kpi-strip {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 992px) {
        .pu-kpi-strip { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 576px) {
        .pu-kpi-strip { grid-template-columns: 1fr; }
    }

    .pu-kpi-card {
        background: #fff;
        border-radius: 0.75rem;
        padding: 1.1rem 1.25rem;
        box-shadow: 0 1px 6px rgba(0,0,0,.07);
        border-left: 4px solid transparent;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: transform 0.18s, box-shadow 0.18s;
    }

    .pu-kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0,0,0,.1);
    }

    .pu-kpi-card.kpi-igd   { border-left-color: var(--bs-primary); }
    .pu-kpi-card.kpi-umum  { border-left-color: var(--bs-success); }
    .pu-kpi-card.kpi-ibs   { border-left-color: var(--bs-warning); }
    .pu-kpi-card.kpi-irj   { border-left-color: var(--bs-info); }

    .pu-kpi-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .pu-kpi-value {
        font-size: 1.6rem;
        font-weight: 700;
        line-height: 1;
        color: var(--color-neutral-900, #1a1a2e);
    }

    .pu-kpi-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: var(--color-neutral-500, #6c757d);
        margin-top: 2px;
    }

    /* ── Status Badge ── */
    .pu-status-badge {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .35rem .85rem;
        border-radius: 50rem;
        font-size: .78rem;
        font-weight: 600;
        letter-spacing: .03em;
    }

    /* ── Tab Panel ── */
    .pu-review-tabs .nav-tabs {
        border-bottom: 2px solid var(--color-neutral-200, #e9ecef);
        gap: .25rem;
        flex-wrap: nowrap;
        overflow-x: auto;
    }

    .pu-review-tabs .nav-tabs .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        border-radius: 0;
        padding: .65rem 1.1rem;
        font-size: .875rem;
        font-weight: 600;
        color: var(--color-neutral-600, #6c757d);
        white-space: nowrap;
        transition: color .15s, border-color .15s;
    }

    .pu-review-tabs .nav-tabs .nav-link:hover {
        color: var(--color-primary, #0d6efd);
        border-bottom-color: var(--color-primary-200, #b6d4fe);
    }

    .pu-review-tabs .nav-tabs .nav-link.active {
        color: var(--color-primary, #0d6efd);
        border-bottom-color: var(--color-primary, #0d6efd);
        background: transparent;
    }

    .pu-review-tabs .tab-content {
        background: #fff;
        border: 1px solid var(--color-neutral-200, #dee2e6);
        border-top: none;
        border-radius: 0 0 .75rem .75rem;
        padding: 1.5rem;
    }

    .pu-tab-badge {
        font-size: .65rem;
        padding: .2em .55em;
        margin-left: .35rem;
        vertical-align: middle;
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
<x-page-header title="Laporan Pengawas Umum Terbaru" subtitle="Tanggal: {{ date('d F Y', strtotime($laporanDate)) }} | Dinas: {{ strtoupper($dinasName) }}">
    <x-slot name="actions">
        {{-- Status Verifikasi --}}
        @php
            $vBidang = $laporanStatus?->verified_bidang ?? 0;
            $vDirektur = $laporanStatus?->verified ?? 0;
        @endphp
        @if($vDirektur && $vBidang)
            <span class="pu-status-badge bg-success-subtle text-success border border-success-subtle">
                <i class="fas fa-check-double"></i> Terverifikasi Direktur
            </span>
        @elseif($vBidang)
            <span class="pu-status-badge bg-info-subtle text-info border border-info-subtle">
                <i class="fas fa-check"></i> Terverifikasi Keperawatan
            </span>
        @else
            <span class="pu-status-badge bg-warning-subtle text-dark border border-warning-subtle">
                <i class="fas fa-spinner fa-spin me-1"></i> Menunggu Verifikasi
            </span>
        @endif

        {{-- Info Pengawas --}}
        <div class="d-flex align-items-center bg-white px-4 py-2 rounded shadow-sm border border-gray-200 ms-2">
            <div class="me-3 text-end">
                <div class="text-xs text-gray-500 text-uppercase fw-bold">Pengawas Bertugas</div>
                <div class="fw-bold text-gray-800">{{ $pengawasName }}</div>
            </div>
            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm" style="width:40px;height:40px;font-size:1rem;">
                {{ strtoupper(substr($pengawasName ?? 'U', 0, 1)) }}
            </div>
        </div>
    </x-slot>
</x-page-header>

{{-- ========================================== --}}
{{-- KPI STRIP --}}
{{-- ========================================== --}}
<div class="pu-kpi-strip animate-fade-in-up">
    {{-- IGD --}}
    <div class="pu-kpi-card kpi-igd">
        <div class="pu-kpi-icon bg-primary-subtle text-primary">
            <i class="fas fa-ambulance"></i>
        </div>
        <div>
            <div class="pu-kpi-value">{{ $totalIGD }}</div>
            <div class="pu-kpi-label">IGD</div>
        </div>
    </div>
    {{-- Rawat Inap / Umum --}}
    <div class="pu-kpi-card kpi-umum">
        <div class="pu-kpi-icon bg-success-subtle text-success">
            <i class="fas fa-procedures"></i>
        </div>
        <div>
            <div class="pu-kpi-value">{{ $totalUmum }}</div>
            <div class="pu-kpi-label">Rawat Inap</div>
        </div>
    </div>
    {{-- IBS --}}
    <div class="pu-kpi-card kpi-ibs">
        <div class="pu-kpi-icon bg-warning-subtle text-warning">
            <i class="fas fa-syringe"></i>
        </div>
        <div>
            <div class="pu-kpi-value">{{ $totalIBS }}</div>
            <div class="pu-kpi-label">IBS</div>
        </div>
    </div>
    {{-- IRJ --}}
    <div class="pu-kpi-card kpi-irj">
        <div class="pu-kpi-icon bg-info-subtle text-info">
            <i class="fas fa-stethoscope"></i>
        </div>
        <div>
            <div class="pu-kpi-value">{{ $totalIRJ }}</div>
            <div class="pu-kpi-label">Rawat Jalan (IRJ)</div>
        </div>
    </div>
</div>

{{-- ========================================== --}}
{{-- TAB PANEL --}}
{{-- ========================================== --}}
<div class="pu-review-tabs animate-fade-in-up">
    <ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab-igd" data-bs-toggle="tab" data-bs-target="#panel-igd"
                type="button" role="tab" aria-controls="panel-igd" aria-selected="true">
                <i class="fas fa-ambulance me-2 text-primary"></i>IGD
                <span class="badge rounded-pill bg-primary pu-tab-badge">{{ $totalIGD }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-umum" data-bs-toggle="tab" data-bs-target="#panel-umum"
                type="button" role="tab" aria-controls="panel-umum" aria-selected="false">
                <i class="fas fa-procedures me-2 text-success"></i>Umum / Ruangan
                <span class="badge rounded-pill bg-success pu-tab-badge">{{ $totalUmum }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-ibs" data-bs-toggle="tab" data-bs-target="#panel-ibs"
                type="button" role="tab" aria-controls="panel-ibs" aria-selected="false">
                <i class="fas fa-syringe me-2 text-warning"></i>IBS
                <span class="badge rounded-pill bg-warning text-dark pu-tab-badge">{{ $totalIBS }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-irj" data-bs-toggle="tab" data-bs-target="#panel-irj"
                type="button" role="tab" aria-controls="panel-irj" aria-selected="false">
                <i class="fas fa-stethoscope me-2 text-info"></i>IRJ
                <span class="badge rounded-pill bg-info pu-tab-badge">{{ $totalIRJ }}</span>
            </button>
        </li>
    </ul>

    <div class="tab-content" id="dashboardTabsContent">
        <div class="tab-pane fade show active" id="panel-igd" role="tabpanel" aria-labelledby="tab-igd">
            @include('admin.partials.igd')
        </div>
        <div class="tab-pane fade" id="panel-umum" role="tabpanel" aria-labelledby="tab-umum">
            @include('admin.partials.umum-ruangan')
        </div>
        <div class="tab-pane fade" id="panel-ibs" role="tabpanel" aria-labelledby="tab-ibs">
            @include('admin.partials.ibs')
        </div>
        <div class="tab-pane fade" id="panel-irj" role="tabpanel" aria-labelledby="tab-irj">
            @include('admin.partials.irj')
        </div>
    </div>
</div>

{{-- ========================================== --}}
{{-- MODALS --}}
{{-- ========================================== --}}
@include('admin.partials.dashboard-modals')

@stop

@section('custom_script')
@include('admin.partials.dashboard-scripts')
@stop