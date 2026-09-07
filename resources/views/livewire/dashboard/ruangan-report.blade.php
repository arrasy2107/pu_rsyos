@php
$data = $data ?? null;
@endphp

<div class="position-relative min-vh-25">
    {{-- Animasi Loading Otomatis dari Livewire --}}
    <div wire:loading.flex class="position-absolute w-100 h-100 justify-content-center align-items-center" style="background: rgba(255,255,255,0.8); z-index: 10; left: 0; top: 0;">
        <div class="text-center text-primary py-5">
            <i class="fas fa-circle-notch fa-spin fa-3x mb-3"></i>
            <h5 class="fw-bold">Memuat Data Ruangan...</h5>
        </div>
    </div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h5 mb-0 text-gray-800">Total Pasien : {{ $data ? $data->jumlah_total_pasien : 0 }}</h1>
    </div>

    <div class="row">
        @if($data)
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs fw-bold text-uppercase mb-1"> Pasien Lama</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $data->jumlah_pasien_lama }}</div>
                        </div>
                        <div class="col-auto">
                            <img src="{{ asset('sb-admin/icon/general/pasien.png') }}" height="64" width="64">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Repeat other cards similar to original partial but using $data fields -->
        {{-- For brevity include only a few; expand as needed --}}
        @else
        <div class="col-12 text-muted py-4 text-center">Pilih ruangan untuk melihat laporan.</div>
        @endif
    </div>
</div>