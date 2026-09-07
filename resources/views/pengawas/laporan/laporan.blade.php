@extends('master.master')

@section('page_title', 'Laporan')

@section('custom_style')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .shadow-textarea textarea.form-control::placeholder {
        font-weight: 300;
    }

    .shadow-textarea textarea.form-control {
        padding-left: 0.8rem;
    }

    .pu-stats-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .pu-stats-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
    }

    .pu-stats-img {
        transition: transform 0.2s;
    }

    .pu-stats-card:hover .pu-stats-img {
        transform: scale(1.1);
    }

    .collapse-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 2px solid var(--color-primary);
    }

    .collapse-header:hover {
        background: #f1f3f5;
        text-decoration: none;
    }

    .btn-action-group {
        display: flex;
        gap: 0.5rem;
    }

    /* Select2 overrides */
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

    .select2-results__options {
        max-height: 260px !important;
        overflow-y: auto !important;
    }

    /* Tambah IBS multi-select & IGD Dokter Jaga */
    #tambahibs .select2-container--default .select2-selection--multiple,
    #editibs .select2-container--default .select2-selection--multiple,
    #draft-igd-form .select2-container--default .select2-selection--multiple {
        min-height: 48px !important;
        padding: 5px 7px !important;
        border: 1.5px solid var(--color-neutral-300) !important;
        border-radius: var(--radius-md) !important;
        background: var(--color-white) !important;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    #tambahibs .select2-container--default.select2-container--focus .select2-selection--multiple,
    #tambahibs .select2-container--default.select2-container--open .select2-selection--multiple,
    #editibs .select2-container--default.select2-container--focus .select2-selection--multiple,
    #editibs .select2-container--default.select2-container--open .select2-selection--multiple,
    #draft-igd-form .select2-container--default.select2-container--focus .select2-selection--multiple,
    #draft-igd-form .select2-container--default.select2-container--open .select2-selection--multiple {
        border-color: var(--color-accent) !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
        outline: none !important;
    }

    #tambahibs .select2-selection--multiple .select2-selection__rendered,
    #editibs .select2-selection--multiple .select2-selection__rendered,
    #draft-igd-form .select2-selection--multiple .select2-selection__rendered {
        display: flex !important;
        flex-wrap: wrap;
        gap: 5px;
        padding: 0 !important;
    }

    #tambahibs .select2-selection--multiple .select2-selection__choice,
    #editibs .select2-selection--multiple .select2-selection__choice,
    #draft-igd-form .select2-selection--multiple .select2-selection__choice {
        display: inline-flex !important;
        align-items: center;
        vertical-align: middle;
        max-width: 100%;
        margin: 0 !important;
        padding: 5px 9px !important;
        border: 1px solid var(--color-primary-200) !important;
        border-radius: 6px !important;
        background: var(--color-primary-50) !important;
        color: var(--color-primary-800) !important;
        font-size: var(--font-size-sm) !important;
        line-height: 1.35 !important;
        white-space: nowrap;
    }

    #tambahibs .select2-selection--multiple .select2-selection__choice__remove,
    #editibs .select2-selection--multiple .select2-selection__choice__remove,
    #draft-igd-form .select2-selection--multiple .select2-selection__choice__remove {
        order: 0 !important;
        flex: 0 0 auto;
        margin: 0 7px 0 0 !important;
        padding: 0 !important;
        border: 0 !important;
        color: var(--color-primary-500) !important;
        font-size: 1rem !important;
        font-weight: 600;
        line-height: 1;
        float: none !important;
    }

    #tambahibs .select2-selection--multiple .select2-selection__choice__remove:hover,
    #editibs .select2-selection--multiple .select2-selection__choice__remove:hover,
    #draft-igd-form .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: var(--color-danger) !important;
        background: transparent !important;
    }

    #tambahibs .select2-selection--multiple .select2-search--inline,
    #editibs .select2-selection--multiple .select2-search--inline,
    #draft-igd-form .select2-selection--multiple .select2-search--inline {
        flex: 1 1 140px;
        min-width: 140px;
        height: 32px;
        margin: 0 !important;
    }

    #tambahibs .select2-selection--multiple .select2-search__field,
    #editibs .select2-selection--multiple .select2-search__field,
    #draft-igd-form .select2-selection--multiple .select2-search__field {
        width: 100% !important;
        min-height: 30px;
        margin: 0 !important;
        padding: 3px 4px !important;
        color: var(--color-neutral-900);
        font-family: var(--font-family) !important;
        font-size: var(--font-size-sm) !important;
    }

    #tambahibs .select2-selection--multiple .select2-search__field::placeholder,
    #editibs .select2-selection--multiple .select2-search__field::placeholder,
    #draft-igd-form .select2-selection--multiple .select2-search__field::placeholder {
        color: var(--color-neutral-400);
    }
</style>
@stop

@section('custom_script')
@stop

@section('content')

<div class="container-fluid">

    <x-alert />
    <x-page-header title="Buat Laporan" subtitle="Laporan yang sudah dibuat akan disimpan dan dapat diubah di menu Draf Laporan" icon="fas fa-file-alt text-primary">
        <x-slot name="actions">
            <div class="bg-white rounded px-4 py-2 border shadow-sm text-center">
                <span class="text-xs text-muted fw-bold d-block text-uppercase">Tanggal</span>
                <span class="text-primary fw-bold"><i class="fas fa-calendar-day me-2"></i>{{ $today }}</span>
            </div>
        </x-slot>
    </x-page-header>

    <div class="pu-stagger">
        <div class="accordion mb-4" id="pengawasAccordion">
            @include('pengawas.laporan.partials.igd')
            @include('pengawas.laporan.partials.ruangan')
            @include('pengawas.laporan.partials.ibs')
            @include('pengawas.laporan.partials.irj')
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- MODALS --}}
    {{-- ========================================== --}}

    @include('pengawas.partials.modals-and-scripts')

</div>

@stop