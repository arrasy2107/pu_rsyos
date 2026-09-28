<div class="laporan-summary-content">
    <style>
        .laporan-summary-content .summary-heading {
            color: #212529;
            font-size: 0.95rem;
            font-weight: 700;
        }
        .laporan-summary-content .summary-meta {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .laporan-summary-content .summary-panel {
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 1rem;
        }
        .laporan-summary-content .summary-actions .btn {
            min-width: 112px;
        }
    </style>
    @if(!$laporan)
        <div class="text-center py-5 text-muted">
            <i class="fas fa-eye fa-2x mb-3"></i>
            <p class="mb-0">Pilih laporan untuk melihat ringkasannya.</p>
        </div>
    @else
        <div class="summary-panel row g-3 align-items-center">
            <div class="col-md-8">
            <div class="summary-heading">{{ $laporan->created_at?->isoFormat('dddd, D MMMM Y HH:mm') }}</div>
            <div class="summary-meta">Dinas: {{ $laporan->dinas->dinas ?? '-' }}</div>
            <div class="summary-meta">Pengawas Umum: {{ $laporan->pengawas->nama ?? '-' }}</div>
            </div>
            <div class="col-md-4 text-md-end">
                @if($laporan->qr_code)
                    <a href="{{ route('verifikasi.laporan', ['token' => $laporan->qr_token]) }}" target="_blank" title="Klik atau scan untuk verifikasi laporan">
                        <img src="{{ asset('storage/qrcodes/' . $laporan->qr_code) }}"
                             alt="QR Code Verifikasi"
                             class="img-fluid rounded border shadow-sm"
                             style="max-width: 100px; max-height: 100px; object-fit: contain;">
                    </a>
                    <div class="mt-1" style="font-size:.7rem; color:#94a3b8;">
                        <i class="fas fa-qrcode me-1"></i>Scan untuk verifikasi
                    </div>
                @elseif($laporan->signature)
                    <img src="{{ asset('signature/' . $laporan->signature) }}"
                         alt="Tanda tangan laporan"
                         class="img-fluid rounded border shadow-sm"
                         style="max-width: 220px; max-height: 90px; object-fit: contain;">
                @endif
            </div>
        </div>

        <hr>

        <div class="row g-2">
            <div class="col-md-6">
            <div class="summary-meta">Verifikasi Keperawatan</div>
                <span class="badge {{ $laporan->verified_bidang ? 'bg-success' : 'bg-warning text-dark' }}">
                    {{ $laporan->verified_bidang ? 'Terverifikasi' : 'Belum diverifikasi' }}
                </span>
            </div>
            <div class="col-md-6">
                <div class="summary-meta">Verifikasi Direktur</div>
                <span class="badge {{ $laporan->verified ? 'bg-success' : 'bg-warning text-dark' }}">
                    {{ $laporan->verified ? 'Terverifikasi' : 'Belum diverifikasi' }}
                </span>
            </div>
        </div>

        <div class="summary-actions d-flex flex-wrap gap-2 mt-4" role="group" aria-label="Detail laporan">
            <button type="button" class="btn btn-danger btn-summary-detail" data-type="igd" data-id="{{ $laporan->id }}">
                <i class="fas fa-ambulance me-1"></i> IGD
            </button>
            <button type="button" class="btn btn-success btn-summary-detail" data-type="umum" data-id="{{ $laporan->id }}">
                <i class="fas fa-procedures me-1"></i> Umum
            </button>
            <button type="button" class="btn btn-warning text-dark btn-summary-detail" data-type="ibs" data-id="{{ $laporan->id }}">
                <i class="fas fa-syringe me-1"></i> IBS
            </button>
            @if($laporan->id_dinas != 3)
                <button type="button" class="btn btn-primary btn-summary-detail" data-type="irj" data-id="{{ $laporan->id }}">
                    <i class="fas fa-stethoscope me-1"></i> IRJ
                </button>
            @endif
        </div>
    @endif
</div>
