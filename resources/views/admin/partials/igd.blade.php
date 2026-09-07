<div class="row">
    <!-- Cards IGD -->
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
    ?>
    @foreach($igdStats as $stat)
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-{{ $stat['color'] }} shadow-sm h-100 py-2 icon-hover-container" data-icon-id="{{ $stat['id'] }}">
            <div class="card-body">
                <div class="row g-0 align-items-center">
                    <div class="col me-2">
                        <div class="text-xs fw-bold text-gray-500 text-uppercase mb-1">{{ $stat['title'] }}</div>
                        <div class="h4 mb-0 fw-bold text-gray-800">{{ $igdStatsRaw ? $igdStatsRaw[$stat['val']] : 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <img src="{{asset('sb-admin/icon/igd/'.$stat['icon'])}}" id="gbr_igd_{{ $stat['id'] }}" height="56px" width="56px">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row mt-2">
    <div class="col-lg-12">
        <div class="mb-3">
            <label>Alasan pasien tidak bisa dirawat</label>
            <textarea class="form-control" rows="2" readonly>{{ $igdStatsRaw->alasan_tidak_bisa_rawat ?? '' }}</textarea>
        </div>
        <div class="mb-3">
            <label>Permasalahan</label>
            <textarea class="form-control" rows="2" readonly>{{ $igdStatsRaw->permasalahan ?? '' }}</textarea>
        </div>
        <div class="mb-3">
            <label>Lain - lain</label>
            <textarea class="form-control" rows="2" readonly>{{ $igdStatsRaw->lain_lain ?? '' }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Dokter Jaga IGD</label>
            @if($igdStatsRaw && $igdStatsRaw->id_dokter)
                @php
                    $idDokterArr = array_filter(array_map('trim', explode(',', $igdStatsRaw->id_dokter)));
                    $dokterJaga  = \App\Models\Dokter::whereIn('id', $idDokterArr)->get();
                @endphp
                @if($dokterJaga->isNotEmpty())
                    <div class="d-flex flex-wrap gap-2 mt-1">
                        @foreach($dokterJaga as $dk)
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 fs-6 fw-normal rounded-pill">
                                <i class="fas fa-user-md me-1"></i>{{ $dk->nama_dokter }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted fst-italic mb-0 mt-1">Data dokter tidak ditemukan.</p>
                @endif
            @else
                <p class="text-muted fst-italic mb-0 mt-1">Belum ada dokter yang ditugaskan.</p>
            @endif
        </div>
    </div>
</div>