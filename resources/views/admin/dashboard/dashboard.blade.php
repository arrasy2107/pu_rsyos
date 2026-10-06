@extends('master.master')

@section('page_title', 'Dashboard Laporan')

@section('custom_style')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/fixedcolumns/3.3.3/css/fixedColumns.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
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

    .igd-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md, 0 4px 12px rgba(15,38,87,.08)) !important;
    }

    .igd-stat-section + .igd-stat-section {
        margin-top: 1.25rem;
    }

    .igd-section-heading,
    .igd-detail-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: .65rem;
    }

    .igd-section-title {
        margin: 0;
        color: var(--color-neutral-800, #334155);
        font-size: .9rem;
        font-weight: 800;
        letter-spacing: .02em;
    }

    .igd-section-description {
        margin: .15rem 0 0;
        color: var(--color-neutral-500, #64748b);
        font-size: .75rem;
    }

    .igd-stat-grid {
        row-gap: .6rem;
    }

    .igd-stat-card {
        border-radius: .65rem;
        transition: var(--transition-fast);
    }

    .igd-stat-card .card-body {
        min-height: 78px;
    }

    .igd-info-list {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: .85rem 1.25rem;
    }

    .igd-info-item {
        padding-bottom: .75rem;
        border-bottom: 1px solid var(--color-neutral-200, #e5e7eb);
    }

    .igd-info-item:first-child {
        grid-column: 1 / -1;
    }

    .igd-info-item:last-child {
        padding-bottom: 0;
        border-bottom: 0;
    }

    .igd-info-label {
        margin-bottom: .2rem;
        color: var(--color-neutral-600, #64748b);
        font-size: .72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .03em;
    }

    .igd-info-value {
        color: var(--color-neutral-900, #1f2937);
        font-size: .9rem;
        line-height: 1.5;
        white-space: pre-line;
    }

    .igd-detail-panel {
        padding: 1rem;
        border: 1px solid var(--color-neutral-200, #e5e7eb);
        border-radius: .65rem;
        background: #fff;
    }

    .igd-detail-icon {
        color: var(--color-primary, #2563eb);
        font-size: 1rem;
        opacity: .8;
    }

    .igd-doctor-value {
        color: var(--color-neutral-900, #1f2937);
        font-size: .9rem;
        line-height: 1.6;
    }

    @media (max-width: 576px) {
        .igd-info-list {
            grid-template-columns: 1fr;
        }

        .igd-info-item:first-child {
            grid-column: auto;
        }
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
        position: relative;
        overflow: hidden;
        min-height: 148px;
        border-radius: var(--radius-xl, 1rem);
        padding: 1.25rem;
        box-shadow: var(--shadow-md, 0 4px 12px rgba(15,38,87,.08));
        border: 2px solid transparent;
        display: flex;
        align-items: center;
        gap: 1rem;
        color: #fff;
        isolation: isolate;
        cursor: pointer;
        transition: transform .2s ease, box-shadow .2s ease, filter .2s ease, opacity .2s ease;
    }

    .pu-kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-xl, 0 20px 25px rgba(15,38,87,.1));
    }

    .pu-kpi-card.is-selected {
        border-color: #bfdbfe;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .28), var(--shadow-xl, 0 20px 25px rgba(15,38,87,.1));
        filter: saturate(1.08);
        transform: translateY(-3px);
    }

    .pu-kpi-card:not(.is-selected) {
        filter: saturate(.78);
        opacity: .84;
    }

    .pu-kpi-card.is-activating {
        animation: kpi-selected-pulse .36s ease-out;
    }

    @keyframes kpi-selected-pulse {
        0% { box-shadow: 0 0 0 0000000000000000000000000000000000000000000000000000000 rgba(37, 99, 235, .62), var(--shadow-xl, 0 20px 25px rgba(15,38,87,.1)); }
        100% { box-shadow: 0 0 0 3px rgba(37, 99, 235, .28), var(--shadow-xl, 0 20px 25px rgba(15,38,87,.1)); }
    }

    .pu-kpi-card.is-selected::before {
        content: '';
        position: absolute;
        top: 0;
        right: 1.25rem;
        left: 1.25rem;
        height: 4px;
        border-radius: 0 0 4px 4px;
        background: #dbeafe;
        z-index: 1;
    }

    .pu-kpi-card:focus-visible {
        outline: 3px solid #93c5fd;
        outline-offset: 3px;
    }

    .pu-kpi-card::after {
        content: '';
        position: absolute;
        width: 170px;
        height: 170px;
        right: -55px;
        top: -65px;
        border-radius: 50%;
        background: rgba(255,255,255,.12);
        z-index: -1;
    }

    .pu-kpi-card.kpi-igd  { background: linear-gradient(135deg, #2563eb, #1e40af); }
    .pu-kpi-card.kpi-umum { background: linear-gradient(135deg, #10b981, #047857); }
    .pu-kpi-card.kpi-ibs  { background: linear-gradient(135deg, #f59e0b, #b45309); }
    .pu-kpi-card.kpi-irj  { background: linear-gradient(135deg, #0891b2, #155e75); }

    .pu-kpi-card .kpi-content { position: relative; z-index: 1; width: 100%; }
    .pu-kpi-card .kpi-label { color: rgba(255,255,255,.75); letter-spacing: .08em; }
    .pu-kpi-card .kpi-icon { background: rgba(255,255,255,.18); backdrop-filter: blur(5px); }
    .pu-kpi-card .kpi-value { color: #fff; font-size: 2.35rem; font-weight: 800; line-height: 1; }

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

    .dashboard-kasur-summary {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: .75rem;
    }

    .dashboard-kasur-status {
        padding: .85rem 1rem;
        border: 1px solid var(--color-neutral-200, #e5e7eb);
        border-left: 4px solid var(--status-color, #64748b);
        border-radius: .6rem;
        background: #fff;
    }

    .dashboard-kasur-status .value {
        color: var(--status-color, #334155);
        font-size: 1.45rem;
        font-weight: 800;
        line-height: 1;
    }

    .dashboard-kasur-status .label {
        margin-top: .35rem;
        color: #64748b;
        font-size: .72rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .dashboard-kasur-toolbar {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) auto;
        gap: .75rem;
        align-items: end;
    }

    .dashboard-kasur-unit {
        border: 1px solid #dbe3ef;
        border-radius: .7rem;
        overflow: hidden;
        background: #fff;
    }

    .dashboard-kasur-unit + .dashboard-kasur-unit { margin-top: .75rem; }

    .dashboard-kasur-unit-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        width: 100%;
        padding: .9rem 1rem;
        border: 0;
        background: #f3f7fc;
        color: #173b72;
        text-align: left;
        font-weight: 700;
    }

    .dashboard-kasur-unit-header:hover { background: #e8f1fb; }

    .dashboard-kasur-unit-meta {
        display: flex;
        flex-wrap: wrap;
        gap: .4rem;
        color: #64748b;
        font-size: .75rem;
        font-weight: 600;
    }

    .dashboard-kasur-unit-body { padding: .9rem; }

    .dashboard-kasur-room-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: .75rem;
    }

    .dashboard-kasur-room {
        display: flex;
        flex-direction: column;
        min-width: 0;
        padding: .85rem;
        border: 1px solid #e1e8f0;
        border-radius: .6rem;
        background: #fff;
    }

    .dashboard-kasur-room-title {
        display: flex;
        justify-content: space-between;
        gap: .5rem;
        margin-bottom: .7rem;
        color: #1e3a5f;
        font-weight: 700;
    }

    .dashboard-kasur-room-count {
        color: #64748b;
        font-size: .72rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .dashboard-kasur-bed-list {
        display: flex;
        flex-wrap: wrap;
        gap: .4rem;
        margin-top: auto;
    }

    .dashboard-kasur-bed {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        max-width: 100%;
        padding: .35rem .5rem;
        border-radius: .4rem;
        background: #f8fafc;
        color: #334155;
        font-size: .72rem;
    }

    .dashboard-kasur-bed-dot {
        width: .45rem;
        height: .45rem;
        flex: 0 0 auto;
        border-radius: 50%;
        background: var(--bed-color);
    }

    .dashboard-kasur-empty {
        padding: 1.25rem;
        color: #64748b;
        text-align: center;
    }

    @media (max-width: 992px) {
        .dashboard-kasur-summary { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .dashboard-kasur-room-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 576px) {
        .dashboard-kasur-summary { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .dashboard-kasur-toolbar { grid-template-columns: 1fr; }
        .dashboard-kasur-room-grid { grid-template-columns: 1fr; }
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
        position: relative;
        border-bottom: 2px solid var(--color-neutral-200, #e9ecef);
        gap: .25rem;
        flex-wrap: nowrap;
        overflow-x: auto;
        scrollbar-width: thin;
        -webkit-overflow-scrolling: touch;
    }

    .pu-review-tabs .nav-tabs::after {
        content: '';
        position: sticky;
        right: 0;
        min-width: 1.5rem;
        height: 2.5rem;
        margin-left: auto;
        pointer-events: none;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,.95));
        opacity: 0;
        transition: opacity .2s ease;
    }

    .pu-review-tabs .nav-tabs.has-overflow::after,
    .pu-review-tabs .nav-tabs.is-scrolled::after {
        opacity: 1;
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

    .pu-empty-state {
        padding: 3rem 1rem;
        text-align: center;
        color: var(--color-neutral-500, #64748b);
    }

    .pu-empty-state i {
        display: block;
        margin-bottom: .75rem;
        color: var(--color-neutral-300, #cbd5e1);
        font-size: 2.5rem;
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
<x-page-header title="Laporan Pengawas Umum Terbaru" subtitle="Tanggal: {{ $laporanDate ? date('d F Y', strtotime($laporanDate)) : '-' }} | Dinas: {{ strtoupper($dinasName) }}">
    <x-slot name="actions">
        {{-- Status Verifikasi --}}
        @php
            $vBidang = $laporanStatus?->verified_bidang ?? 0;
            $vDirektur = $laporanStatus?->verified ?? 0;
        @endphp
        @if($vDirektur && $vBidang)
            <span class="pu-status-badge bg-success-subtle text-success border border-success-subtle">
                <i class="fas fa-check-double"></i> Terverifikasi Final
            </span>
        @elseif($vBidang)
            <span class="pu-status-badge bg-info-subtle text-info border border-info-subtle">
                <i class="fas fa-check"></i> Terverifikasi Bidang
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
    <div class="pu-kpi-card kpi-igd is-selected" data-kpi-target="#panel-igd" role="button" tabindex="0" aria-controls="panel-igd" aria-selected="true">
        <div class="kpi-content">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="kpi-label small fw-bold text-uppercase">IGD</div>
                <div class="kpi-icon rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="fas fa-ambulance text-white fs-5"></i>
                </div>
            </div>
            <h2 class="kpi-value mb-0">{{ $totalIGD }}</h2>
            <div class="mt-2 text-white-50 small">Pasien Gawat Darurat</div>
        </div>
    </div>

    {{-- Rawat Inap / Umum --}}
    <div class="pu-kpi-card kpi-umum" data-kpi-target="#panel-umum" role="button" tabindex="0" aria-controls="panel-umum" aria-selected="false">
        <div class="kpi-content">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="kpi-label small fw-bold text-uppercase">Rawat Inap</div>
                <div class="kpi-icon rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="fas fa-procedures text-white fs-5"></i>
                </div>
            </div>
            <h2 class="kpi-value mb-0">{{ $totalUmum }}</h2>
            <div class="mt-2 text-white-50 small">Pasien Rawat Inap</div>
        </div>
    </div>

    {{-- IBS --}}
    <div class="pu-kpi-card kpi-ibs" data-kpi-target="#panel-ibs" role="button" tabindex="0" aria-controls="panel-ibs" aria-selected="false">
        <div class="kpi-content">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="kpi-label small fw-bold text-uppercase">IBS</div>
                <div class="kpi-icon rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="fas fa-syringe text-white fs-5"></i>
                </div>
            </div>
            <h2 class="kpi-value mb-0">{{ $totalIBS }}</h2>
            <div class="mt-2 text-white-50 small">Pasien Bedah Sentral</div>
        </div>
    </div>

    {{-- IRJ --}}
    <div class="pu-kpi-card kpi-irj" data-kpi-target="#panel-irj" role="button" tabindex="0" aria-controls="panel-irj" aria-selected="false">
        <div class="kpi-content">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="kpi-label small fw-bold text-uppercase">IRJ</div>
                <div class="kpi-icon rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="fas fa-stethoscope text-white fs-5"></i>
                </div>
            </div>
            <h2 class="kpi-value mb-0">{{ $totalIRJ }}</h2>
            <div class="mt-2 text-white-50 small">Pasien Rawat Jalan</div>
        </div>
    </div>
</div>

{{-- ========================================== --}}
{{-- TAB PANEL --}}
{{-- ========================================== --}}
<div class="pu-review-tabs animate-fade-in-up mb-4">
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
                <i class="fas fa-procedures me-2 text-success"></i>Rawat Inap
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
{{-- STATUS KASUR --}}
{{-- ========================================== --}}
@php
    $kasurStatusLabels = [
        'available' => ['label' => 'Tersedia', 'color' => '#15803d'],
        'occupied' => ['label' => 'Terisi', 'color' => '#dc2626'],
        'maintenance' => ['label' => 'Perbaikan', 'color' => '#b45309'],
        'reserved' => ['label' => 'Dipesan', 'color' => '#2563eb'],
        'cleaning' => ['label' => 'Dibersihkan', 'color' => '#64748b'],
    ];
@endphp
<x-data-card title="Status Kasur" icon="fas fa-procedures" class="animate-fade-in-up">
    <div class="dashboard-kasur-summary mb-4">
        @foreach($kasurStatusLabels as $status => $statusInfo)
        <div class="dashboard-kasur-status" style="--status-color: {{ $statusInfo['color'] }};">
            <div class="value" data-kasur-summary="{{ $status }}">{{ $kasurStatusSummary->get($status, 0) }}</div>
            <div class="label">{{ $statusInfo['label'] }}</div>
        </div>
        @endforeach
    </div>

    <div class="dashboard-kasur-toolbar mb-3">
        <div>
            <label for="dashboardKasurUnit" class="form-label fw-bold">Unit</label>
            <select id="dashboardKasurUnit" class="form-select">
                <option value="">Semua Unit</option>
                @foreach($kasursDashboard->pluck('kamar.ruangan')->filter()->unique('id')->sortBy('nama_ruangan') as $ruangan)
                <option value="{{ $ruangan->id }}">{{ $ruangan->nama_ruangan }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="dashboardKasurSearch" class="form-label fw-bold">Cari Kamar</label>
            <input id="dashboardKasurSearch" class="form-control" type="search" placeholder="Nama kamar...">
        </div>
        <a href="{{ route('data-kasur') }}" class="btn btn-outline-primary"><i class="fas fa-list me-1"></i> Lihat Semua</a>
    </div>

    @php($kasursByUnit = $kasursDashboard->groupBy(fn ($kasur) => $kasur->kamar?->ruangan?->id ?? 'tanpa-unit'))
    <div id="dashboardKasurUnits">
        @forelse($kasursByUnit as $unitId => $unitKasurs)
        @php($unit = $unitKasurs->first()?->kamar?->ruangan)
        @php($unitCounts = $unitKasurs->groupBy('status_operasional')->map->count())
        <section class="dashboard-kasur-unit" data-unit-id="{{ $unitId }}">
            <button type="button" class="dashboard-kasur-unit-header" data-bs-toggle="collapse" data-bs-target="#dashboardKasurUnit{{ $unitId }}" aria-expanded="true">
                <span><i class="fas fa-hospital me-2"></i>{{ $unit?->nama_ruangan ?? 'Tanpa Unit' }}</span>
                <span class="dashboard-kasur-unit-meta">
                    <span>{{ $unitKasurs->count() }} kasur</span>
                    <span>{{ $unitCounts->get('occupied', 0) }} terisi</span>
                    <i class="fas fa-chevron-down ms-1"></i>
                </span>
            </button>
            <div id="dashboardKasurUnit{{ $unitId }}" class="collapse show">
                <div class="dashboard-kasur-unit-body">
                    <div class="dashboard-kasur-room-grid">
                        @foreach($unitKasurs->groupBy('id_kamar') as $roomKasurs)
                        @php($room = $roomKasurs->first()->kamar)
                        <article class="dashboard-kasur-room" data-room-name="{{ strtolower($room?->nama_kamar ?? '') }}">
                            <div class="dashboard-kasur-room-title">
                                <span><i class="fas fa-bed me-1 text-primary"></i>{{ $room?->nama_kamar ?? 'Tanpa Kamar' }}</span>
                                <span class="dashboard-kasur-room-count">{{ $roomKasurs->count() }} kasur</span>
                            </div>
                            <div class="dashboard-kasur-bed-list">
                                @foreach($roomKasurs as $kasur)
                                @php($bedStatus = $kasurStatusLabels[$kasur->status_operasional] ?? ['label' => $kasur->status_operasional, 'color' => '#64748b'])
                                <span class="dashboard-kasur-bed" title="{{ $bedStatus['label'] }}{{ $kasur->keterangan ? ': '.$kasur->keterangan : '' }}" style="--bed-color: {{ $bedStatus['color'] }};">
                                    <span class="dashboard-kasur-bed-dot"></span>{{ $kasur->kode_kasur }}
                                </span>
                                @endforeach
                            </div>
                        </article>
                        @endforeach
                    </div>
                    <div class="dashboard-kasur-empty d-none">Tidak ada kamar yang cocok.</div>
                </div>
            </div>
        </section>
        @empty
        <div class="dashboard-kasur-empty">Belum ada data kasur.</div>
        @endforelse
    </div>
</x-data-card>

{{-- ========================================== --}}
{{-- MODALS --}}
{{-- ========================================== --}}
@include('admin.partials.dashboard-modals')

@stop

@section('custom_script')
@include('admin.partials.dashboard-scripts')
<script>
    $(function() {
        const unitFilter = $('#dashboardKasurUnit');
        const roomSearch = $('#dashboardKasurSearch');

        function refreshKasurCards() {
            const unitId = String(unitFilter.val() || '');
            const search = String(roomSearch.val() || '').toLowerCase().trim();

            $('#dashboardKasurUnits .dashboard-kasur-unit').each(function() {
                const unit = $(this);
                const unitVisible = !unitId || String(unit.data('unit-id')) === unitId;
                let visibleRooms = 0;

                unit.find('.dashboard-kasur-room').each(function() {
                    const room = $(this);
                    const visible = unitVisible && (!search || String(room.data('room-name')).includes(search));
                    room.toggle(visible);
                    if (visible) visibleRooms++;
                });

                unit.toggle(unitVisible && visibleRooms > 0);
                unit.find('.dashboard-kasur-empty').toggleClass('d-none', visibleRooms > 0);
            });
        }

        unitFilter.on('change', refreshKasurCards);
        roomSearch.on('input', refreshKasurCards);
    });
</script>
@stop