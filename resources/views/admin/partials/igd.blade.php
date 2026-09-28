<!-- Ringkasan operasional IGD -->
    <?php
    $igdStats = [
        ['title' => 'Dirawat', 'val' => 'jumlah_pasien_rawat', 'icon' => 'pasien-dirawat.png', 'color' => 'primary', 'id' => '1'],
        ['title' => 'Pulang', 'val' => 'jumlah_pasien_pulang', 'icon' => 'pasien-pulang.png', 'color' => 'success', 'id' => '2'],
        ['title' => 'Emergency', 'val' => 'jumlah_pasien_emergency', 'icon' => 'pasien-emergency.png', 'color' => 'danger', 'id' => '3'],
        ['title' => 'Non Emergency', 'val' => 'jumlah_pasien_non_emergency', 'icon' => 'pasien-non-emergency.png', 'color' => 'warning', 'id' => '4'],
        ['title' => 'Rujuk / Tolak Rawat', 'val' => 'jumlah_pasien_tidak_bisa_rawat', 'icon' => 'pasien-tidak-bisa-dirawat.png', 'color' => 'danger', 'id' => '5'],
        ['title' => 'DOA / Meninggal', 'val' => 'jumlah_pasien_doa', 'icon' => 'pasien-doa.png', 'color' => 'danger', 'id' => '6'],
        ['title' => 'Rujukan Sisrute', 'val' => 'jumlah_pasien_sisrute', 'icon' => 'sisrute.png', 'color' => 'warning', 'id' => '7'],
        ['title' => 'Sisrute Diterima', 'val' => 'jumlah_pasien_sisrute_diterima', 'icon' => 'sisrute-terima.png', 'color' => 'success', 'id' => '8'],
        ['title' => 'Sisrute Ditolak', 'val' => 'jumlah_pasien_sisrute_ditolak', 'icon' => 'sisrute-tolak.png', 'color' => 'danger', 'id' => '9'],
    ];

    $igdGroups = [
        ['title' => 'Kondisi IGD', 'description' => 'Situasi pasien saat ini', 'stats' => [$igdStats[0], $igdStats[2], $igdStats[3]]],
        ['title' => 'Outcome Pasien', 'description' => 'Hasil pelayanan pasien', 'stats' => [$igdStats[1], $igdStats[4], $igdStats[5]]],
        ['title' => 'Sisrute', 'description' => 'Status rujukan antar fasilitas', 'stats' => [$igdStats[6], $igdStats[7], $igdStats[8]]],
    ];
    ?>
    @foreach($igdGroups as $group)
    <section class="igd-stat-section">
        <div class="igd-section-heading">
            <div>
                <h3 class="igd-section-title">{{ $group['title'] }}</h3>
                <p class="igd-section-description">{{ $group['description'] }}</p>
            </div>
        </div>
        <div class="row igd-stat-grid">
            @foreach($group['stats'] as $stat)
            <div class="col-lg-4 col-md-6">
                <div class="card border-left-{{ $stat['color'] }} shadow-sm h-100 igd-stat-card icon-hover-container" data-icon-id="{{ $stat['id'] }}">
                    <div class="card-body p-3">
                        <div class="row g-0 align-items-center">
                            <div class="col me-2">
                                <div class="text-xs fw-bold text-gray-500 text-uppercase mb-1">{{ $stat['title'] }}</div>
                                <div class="h5 mb-0 fw-bold text-gray-800">{{ $igdStatsRaw ? $igdStatsRaw[$stat['val']] : 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <img src="{{ asset('sb-admin/icon/igd/'.$stat['icon']) }}" id="gbr_igd_{{ $stat['id'] }}" alt="{{ $stat['title'] }}" height="40px" width="40px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
</section>
@endforeach

<div class="row g-3 mt-2">
    <div class="col-lg-8">
        <section class="igd-detail-panel h-100">
            <div class="igd-detail-heading">
                <div>
                    <h3 class="igd-section-title">Catatan IGD</h3>
                    <p class="igd-section-description">Informasi tambahan dari laporan jaga</p>
                </div>
                <i class="fas fa-notes-medical igd-detail-icon" aria-hidden="true"></i>
            </div>
            <div class="igd-info-list">
            <div class="igd-info-item">
                <div class="igd-info-label">Alasan pasien tidak bisa dirawat</div>
                <div class="igd-info-value">{{ $igdStatsRaw->alasan_tidak_bisa_rawat ?? '-' }}</div>
            </div>
            <div class="igd-info-item">
                <div class="igd-info-label">Permasalahan</div>
                <div class="igd-info-value">{{ $igdStatsRaw->permasalahan ?? '-' }}</div>
            </div>
            <div class="igd-info-item">
                <div class="igd-info-label">Lain - lain</div>
                <div class="igd-info-value">{{ $igdStatsRaw->lain_lain ?? '-' }}</div>
            </div>
            </div>
        </section>
    </div>
    <div class="col-lg-4">
        <section class="igd-detail-panel h-100">
            <div class="igd-detail-heading">
                <div>
                    <h3 class="igd-section-title">Dokter Jaga</h3>
                    <p class="igd-section-description">Petugas medis IGD</p>
                </div>
                <i class="fas fa-user-md igd-detail-icon" aria-hidden="true"></i>
            </div>
            <div class="igd-doctor-value">
                @if($igdStatsRaw && $igdStatsRaw->id_dokter)
                    @php
                        $idDokterArr = array_filter(array_map('trim', explode(',', $igdStatsRaw->id_dokter)));
                        $dokterJaga  = \App\Models\Dokter::whereIn('id', $idDokterArr)->get();
                    @endphp
                    {{ $dokterJaga->isNotEmpty() ? $dokterJaga->pluck('nama_dokter')->join(', ') : 'Data dokter tidak ditemukan.' }}
                @else
                    Belum ada dokter yang ditugaskan.
                @endif
            </div>
        </section>
    </div>
</div>