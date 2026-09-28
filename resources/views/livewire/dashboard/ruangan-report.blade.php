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

    @if($data)
        @php
            $summaryItems = [
                ['label' => 'Total Pasien', 'value' => $data->jumlah_total_pasien ?? 0, 'class' => 'primary', 'icon' => 'fa-users'],
                ['label' => 'Pasien Lama', 'value' => $data->jumlah_pasien_lama ?? 0, 'class' => 'info', 'icon' => 'fa-user-clock'],
                ['label' => 'Pasien Baru', 'value' => $data->jumlah_pasien_baru ?? 0, 'class' => 'success', 'icon' => 'fa-user-plus'],
                ['label' => 'Pasien Masuk', 'value' => ($data->jumlah_pasien_baru ?? 0) + ($data->jumlah_pasien_pindah ?? 0) + ($data->jumlah_pasien_pindahan ?? 0), 'class' => 'warning', 'icon' => 'fa-arrow-right'],
                ['label' => 'Pasien Keluar', 'value' => ($data->jumlah_pasien_pulang ?? 0) + ($data->jumlah_pasien_meninggal ?? 0), 'class' => 'danger', 'icon' => 'fa-arrow-right-from-bracket'],
            ];
            $specialItems = [
                ['label' => 'Covid', 'value' => $data->jumlah_pasien_covid ?? 0],
                ['label' => 'Suspect Covid', 'value' => $data->jumlah_pasien_suspek_covid ?? 0],
                ['label' => 'Restrain', 'value' => $data->jumlah_pasien_restrain ?? 0],
                ['label' => 'Difabel', 'value' => $data->jumlah_pasien_difabel ?? 0],
            ];
        @endphp

        <div class="ruangan-report-summary">
            @foreach($summaryItems as $item)
            <div class="ruangan-report-stat ruangan-report-stat-{{ $item['class'] }}">
                <div class="ruangan-report-stat-icon"><i class="fas {{ $item['icon'] }}" aria-hidden="true"></i></div>
                <div>
                    <div class="ruangan-report-stat-label">{{ $item['label'] }}</div>
                    <div class="ruangan-report-stat-value">{{ $item['value'] }}</div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="ruangan-report-secondary">
            <div class="ruangan-report-secondary-heading">
                <span><i class="fas fa-triangle-exclamation me-2" aria-hidden="true"></i>Kondisi Khusus</span>
                @if($data->permasalahan_umum)
                    <span class="ruangan-report-note">Ada permasalahan</span>
                @endif
            </div>
            <div class="ruangan-report-special-list">
                @foreach($specialItems as $item)
                <div class="ruangan-report-special-item">
                    <span>{{ $item['label'] }}</span>
                    <strong>{{ $item['value'] }}</strong>
                </div>
                @endforeach
            </div>
            @if($data->permasalahan_umum)
            <div class="ruangan-report-problem">
                <span class="ruangan-report-problem-label">Permasalahan Umum</span>
                <span>{{ $data->permasalahan_umum }}</span>
            </div>
            @endif
        </div>
    @else
        <div class="ruangan-report-empty text-muted">Pilih ruangan untuk melihat laporan.</div>
    @endif
</div>