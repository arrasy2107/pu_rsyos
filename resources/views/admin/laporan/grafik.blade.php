@extends('master.master')

@section('page_title', 'Grafik Laporan Pasien')

@section('custom_style')
<style>
    .filter-card .form-control, .filter-card .input-group-text {
        border-color: var(--color-neutral-300);
    }
    .filter-card .input-group-text {
        background: white;
        border-right: none;
    }
    .filter-card .form-control {
        border-left: none;
    }
    .filter-card .form-control:focus {
        border-color: var(--color-primary);
        box-shadow: none;
    }
    
    #chart-container {
        min-height: 420px;
        background: white;
        border-radius: var(--radius-md);
        border: 1px solid var(--color-neutral-200);
        overflow: hidden;
    }
    
    .chart-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 420px;
        color: var(--color-neutral-400);
    }
    
    .month-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 2px solid transparent;
    }
    
    .month-badge:hover {
        border-color: var(--color-primary);
        background: var(--color-primary-light, #eff6ff);
    }
</style>
@stop

@section('content')

<x-alert />

<?php
use Carbon\Carbon;
use Carbon\CarbonPeriod;

setlocale(LC_TIME, 'id_ID');
\Carbon\Carbon::setLocale('id');

$currentDateTime = Carbon::now();
$newDateTime = Carbon::now()->subYears(5);
?>

<x-page-header title="Grafik Laporan Pasien" subtitle="Visualisasi data pasien per bulan dari seluruh instalasi">
    <x-slot name="actions">
        <div class="d-none d-md-block">
            <span class="badge bg-light border px-3 py-2 shadow-sm text-primary">
                <i class="fas fa-chart-bar me-2 text-primary"></i> Powered by Highcharts
            </span>
        </div>
    </x-slot>
</x-page-header>

{{-- Filter Card --}}
<x-data-card title="Parameter Grafik" icon="fas fa-sliders-h" class="filter-card mb-4">
    <div class="row">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="form-group mb-0">
                <label class="fw-bold text-dark small text-uppercase mb-2">Tahun</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar-alt text-primary"></i></span>
                    </div>
                    <select id="tahun" name="tahun" class="form-control select2">
                        <option value="0">— Pilih Tahun —</option>
                        @foreach (range($currentDateTime->year, $newDateTime->year) as $year)
                        <option value="{{$year}}" {{ $currentDateTime->year == $year ? 'selected' : '' }}>{{$year}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="form-group mb-0">
                <label class="fw-bold text-dark small text-uppercase mb-2">Bulan</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar-day text-success"></i></span>
                    </div>
                    <select id="bulan" name="bulan" class="form-control select2">
                        <option value="0">— Pilih Bulan —</option>
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07">Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <label class="text-muted small fw-bold d-none d-md-block" style="visibility: hidden;">Aksi</label>
            <button class="btn btn-primary w-100 shadow-sm btn-lihat-jadwal" type="button" style="height: 38px;">
                <i class="fas fa-chart-line me-2"></i> Tampilkan Grafik
            </button>
        </div>
    </div>
    <hr class="mt-4 mb-3 border-gray-200">
    <div class="text-muted small">
        <i class="fas fa-lightbulb me-1 text-warning"></i> Pilih parameter rentang waktu pada kolom di atas, lalu klik tombol <b>Tampilkan Grafik</b> untuk memuat dan merender data pasien.
    </div>
</x-data-card>

{{-- Chart Container --}}
<div class="card shadow-sm animate-fade-in-up">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 fw-bold text-primary" id="chart-title"><i class="fas fa-chart-bar me-2"></i> Grafik Kunjungan Pasien</h6>
        <div id="chart-meta" class="text-muted small d-none">
            <i class="fas fa-calendar me-1"></i> <span id="chart-meta-text"></span>
        </div>
    </div>
    <div class="card-body p-0">
        <div id="chart-container" class="tablejadwal">
            <div class="chart-placeholder">
                <i class="fas fa-chart-bar fa-4x mb-4 text-gray-300"></i>
                <h5 class="fw-bold text-gray-400">Belum Ada Data Ditampilkan</h5>
                <p class="text-muted mb-4">Pilih <b>Tahun</b> dan <b>Bulan</b> pada panel filter di atas, kemudian klik <b>Tampilkan Grafik</b>.</p>
                <div class="d-flex flex-wrap justify-content-center" style="gap: 8px; max-width: 500px;">
                    @foreach(['01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'Mei','06'=>'Jun','07'=>'Jul','08'=>'Ags','09'=>'Sep','10'=>'Okt','11'=>'Nov','12'=>'Des'] as $num => $name)
                    <span class="month-badge bg-light border" data-bulan="{{ $num }}" data-tahun="{{ $currentDateTime->year }}">{{ $name }}</span>
                    @endforeach
                </div>
                <p class="text-muted small mt-2">Klik bulan di atas untuk melihat data tahun {{ $currentDateTime->year }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Info Boxes --}}
<div class="row mt-4 mb-5 animate-fade-in-up">
    <div class="col-md-4 mb-3">
        <div class="card border-left-danger shadow-sm h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Instalasi Gawat Darurat</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">Laporan IGD</div>
                        <div class="text-muted small mt-2">Pasien Gawat Darurat & Emergency</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-ambulance fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card border-left-success shadow-sm h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Rawat Inap</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">Ruangan Umum</div>
                        <div class="text-muted small mt-2">Pasien Masuk & Keluar Ruangan</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-procedures fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card border-left-primary shadow-sm h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Rawat Jalan</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">Laporan IRJ</div>
                        <div class="text-muted small mt-2">Total Pasien Rawat Jalan per Dokter</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-stethoscope fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('custom_script')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

    const monthNames = {
        '01': 'Januari', '02': 'Februari', '03': 'Maret', '04': 'April',
        '05': 'Mei', '06': 'Juni', '07': 'Juli', '08': 'Agustus',
        '09': 'September', '10': 'Oktober', '11': 'November', '12': 'Desember'
    };

    function loadGrafik(tahun, bulan) {
        if (tahun == 0 || bulan == 0) {
            alert("Lengkapi pilihan tahun dan bulan dahulu.");
            return;
        }

        const monthLabel = monthNames[bulan] || bulan;
        $(".tablejadwal").html(
            '<div class="chart-placeholder"><i class="fas fa-circle-notch fa-spin fa-3x text-primary mb-4"></i>' +
            '<p class="fw-bold text-muted">Memuat data ' + monthLabel + ' ' + tahun + '...</p></div>'
        );
        $("#chart-title").html('<i class="fas fa-chart-bar me-2"></i> Grafik Kunjungan — ' + monthLabel + ' ' + tahun);
        $("#chart-meta").removeClass('d-none');
        $("#chart-meta-text").text(monthLabel + ' ' + tahun);

        $.ajax({
            type: "get",
            url: '{{ url("/refresh-grafik") }}/' + tahun + '/' + bulan,
            data: { tahun: tahun, bulan: bulan },
            success: function(data) {
                $(".tablejadwal").html(data);
            },
            error: function() {
                $(".tablejadwal").html(
                    '<div class="chart-placeholder"><i class="fas fa-exclamation-triangle fa-3x text-danger mb-4"></i>' +
                    '<p class="fw-bold text-muted">Gagal memuat data. Silakan coba lagi.</p></div>'
                );
            }
        });
    }

    $(".btn-lihat-jadwal").click(function() {
        loadGrafik($("#tahun").val(), $("#bulan").val());
    });

    // Quick month picker
    $(document).on('click', '.month-badge', function() {
        const bulan = $(this).data('bulan');
        const tahun = $(this).data('tahun');
        $("#bulan").val(bulan).trigger('change');
        $("#tahun").val(tahun).trigger('change');
        loadGrafik(tahun, bulan);
    });

</script>
@stop