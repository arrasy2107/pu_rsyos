<div class="row mb-4">
    <div class="col-lg-12 col-md-4 col-sm-6">
        <div class="mb-0">
            <label for="inap_ruangan" class="form-label fw-bold" style="font-size: 24px;">Lihat Laporan per Ruangan</label>
            <select class="form-select select2" id="inap_ruangan" style="width: 100%;">
                <option value=""></option>
                @foreach(\App\Models\Ruangan::where('status',1)->get() as $ruang)
                <option value="{{ $ruang->id }}">{{ $ruang->nama_ruangan }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        @livewire('dashboard.ruangan-report')
    </div>
</div>


<style>
    .ruangan-report-summary {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: .75rem;
        margin-bottom: 1rem;
    }
    .ruangan-report-stat {
        display: flex;
        align-items: center;
        gap: .7rem;
        min-width: 0;
        padding: .8rem;
        border: 1px solid #dbe3ef;
        border-left: 4px solid var(--ruangan-stat-color);
        border-radius: .6rem;
        background: #fff;
    }
    .ruangan-report-stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        flex: 0 0 auto;
        border-radius: .45rem;
        background: color-mix(in srgb, var(--ruangan-stat-color) 12%, white);
        color: var(--ruangan-stat-color);
    }
    .ruangan-report-stat-label {
        color: #64748b;
        font-size: .7rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .ruangan-report-stat-value {
        margin-top: .15rem;
        color: #1e3a5f;
        font-size: 1.35rem;
        font-weight: 800;
        line-height: 1;
    }
    .ruangan-report-stat-primary { --ruangan-stat-color: #2563eb; }
    .ruangan-report-stat-info { --ruangan-stat-color: #0891b2; }
    .ruangan-report-stat-success { --ruangan-stat-color: #15803d; }
    .ruangan-report-stat-warning { --ruangan-stat-color: #b45309; }
    .ruangan-report-stat-danger { --ruangan-stat-color: #dc2626; }
    .ruangan-report-secondary {
        padding: .9rem 1rem;
        border: 1px solid #dbe3ef;
        border-radius: .6rem;
        background: #f8fbff;
    }
    .ruangan-report-secondary-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .75rem;
        color: #29476f;
        font-size: .78rem;
        font-weight: 800;
        text-transform: uppercase;
    }
    .ruangan-report-note {
        padding: .2rem .5rem;
        border-radius: 50rem;
        background: #fff3cd;
        color: #8a5a00;
        font-size: .68rem;
        text-transform: none;
    }
    .ruangan-report-special-list {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: .5rem;
        margin-top: .7rem;
    }
    .ruangan-report-special-item {
        display: flex;
        justify-content: space-between;
        gap: .5rem;
        padding: .45rem .6rem;
        border-radius: .4rem;
        background: #fff;
        color: #64748b;
        font-size: .75rem;
    }
    .ruangan-report-special-item strong { color: #1e3a5f; }
    .ruangan-report-problem {
        display: flex;
        flex-direction: column;
        gap: .2rem;
        margin-top: .7rem;
        padding-top: .7rem;
        border-top: 1px solid #dbe3ef;
        color: #334155;
        font-size: .8rem;
        line-height: 1.5;
    }
    .ruangan-report-problem-label {
        color: #64748b;
        font-size: .68rem;
        font-weight: 800;
        text-transform: uppercase;
    }
    .ruangan-report-empty {
        padding: 2rem 1rem;
        text-align: center;
    }
    @media (max-width: 992px) {
        .ruangan-report-summary { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .ruangan-report-special-list { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 576px) {
        .ruangan-report-summary { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .ruangan-report-special-list { grid-template-columns: 1fr; }
    }

    /* ── Summary Strip ── */
    .ruangan-summary-strip {
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
        gap: 0;
        border: 1px solid #dbe3ef;
        border-radius: .75rem;
        overflow: hidden;
        background: #fff;
        margin-bottom: 1.25rem;
    }
    .ruangan-summary-cell {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: .15rem;
        padding: .85rem .5rem;
        border-right: 1px solid #e8eef5;
        text-align: center;
        transition: background .15s;
    }
    .ruangan-summary-cell:last-child { border-right: 0; }
    .ruangan-summary-cell.is-total {
        background: linear-gradient(135deg, #1e40af, #2563eb);
        color: #fff;
    }
    .ruangan-summary-cell .sc-value {
        font-size: 1.45rem;
        font-weight: 800;
        line-height: 1;
        color: #1e3a5f;
    }
    .ruangan-summary-cell.is-total .sc-value { color: #fff; }
    .ruangan-summary-cell .sc-label {
        font-size: .62rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: #64748b;
        white-space: nowrap;
    }
    .ruangan-summary-cell.is-total .sc-label { color: rgba(255,255,255,.75); }
    .ruangan-summary-cell .sc-icon {
        font-size: .95rem;
        margin-bottom: .05rem;
        opacity: .55;
        color: #2563eb;
    }
    .ruangan-summary-cell.is-total .sc-icon { color: rgba(255,255,255,.7); opacity: 1; }

    /* ── Card Grid ── */
    .ruangan-card-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: .75rem;
    }
    .ruangan-card {
        display: flex;
        flex-direction: column;
        border: 1px solid #dbe3ef;
        border-radius: .75rem;
        background: #fff;
        overflow: hidden;
        transition: box-shadow .18s, transform .18s;
    }
    .ruangan-card:hover {
        box-shadow: 0 4px 16px rgba(30,58,143,.1);
        transform: translateY(-2px);
    }
    .ruangan-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .5rem;
        padding: .65rem .9rem;
        background: #f3f7fc;
        border-bottom: 1px solid #e4ecf6;
    }
    .ruangan-card-title {
        font-size: .82rem;
        font-weight: 800;
        color: #1e3a5f;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .ruangan-card-total {
        flex-shrink: 0;
        padding: .2rem .6rem;
        border-radius: 50rem;
        background: #2563eb;
        color: #fff;
        font-size: .78rem;
        font-weight: 400;
    }
    .ruangan-card-body {
        padding: .65rem .9rem;
        flex: 1;
    }
    .ruangan-card-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: .35rem .5rem;
    }
    .ruangan-card-stat {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: .4rem .3rem;
        border-radius: .4rem;
        background: #f8fbff;
        text-align: center;
    }
    .ruangan-card-stat .cs-value {
        font-size: .95rem;
        font-weight: 800;
        line-height: 1;
        color: #1e3a5f;
    }
    .ruangan-card-stat .cs-value.is-zero { color: #cbd5e1; }
    .ruangan-card-stat .cs-label {
        margin-top: .18rem;
        font-size: .58rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #94a3b8;
    }
    .ruangan-card-footer {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: .35rem;
        padding: .5rem .9rem;
        border-top: 1px solid #e4ecf6;
        background: #fafcff;
        min-height: 40px;
    }
    .ruangan-card-footer .no-action {
        color: #cbd5e1;
        font-size: .72rem;
    }

    /* ── Section heading ── */
    .ruangan-section-heading {
        display: flex;
        align-items: center;
        gap: .5rem;
        margin-bottom: .75rem;
        color: #29476f;
        font-size: .8rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .05em;
    }
    .ruangan-section-heading::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #dbe3ef;
    }

    @media (max-width: 992px) {
        .ruangan-summary-strip { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        .ruangan-summary-cell { border-bottom: 1px solid #e8eef5; }
        .ruangan-card-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 576px) {
        .ruangan-summary-strip { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .ruangan-card-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="row mt-4">
    <div class="col-md-12">
        @if($laporanUmum->isEmpty())
        <div class="pu-empty-state border rounded">
            <i class="fas fa-folder-open" aria-hidden="true"></i>
            <h5 class="mb-1">Belum ada laporan ruangan</h5>
            <p class="mb-0">Belum ada data rawat inap untuk tanggal ini.</p>
        </div>
        @else

        {{-- ── Summary Strip ── --}}
        <div class="ruangan-summary-strip">
            <div class="ruangan-summary-cell">
                <i class="fas fa-user-clock sc-icon"></i>
                <span class="sc-value">{{ $laporanUmum->sum('jumlah_pasien_lama') ?: '0' }}</span>
                <span class="sc-label">Lama</span>
            </div>
            <div class="ruangan-summary-cell">
                <i class="fas fa-user-plus sc-icon"></i>
                <span class="sc-value">{{ $laporanUmum->sum('jumlah_pasien_baru') ?: '0' }}</span>
                <span class="sc-label">Baru</span>
            </div>
            <div class="ruangan-summary-cell">
                <i class="fas fa-exchange-alt sc-icon"></i>
                <span class="sc-value">{{ $laporanUmum->sum('jumlah_pasien_pindah') ?: '0' }}</span>
                <span class="sc-label">Pindah</span>
            </div>
            <div class="ruangan-summary-cell">
                <i class="fas fa-sign-in-alt sc-icon"></i>
                <span class="sc-value">{{ $laporanUmum->sum('jumlah_pasien_pindahan') ?: '0' }}</span>
                <span class="sc-label">Pindahan</span>
            </div>
            <div class="ruangan-summary-cell">
                <i class="fas fa-heart-broken sc-icon" style="color:#dc2626;"></i>
                <span class="sc-value">{{ $laporanUmum->sum('jumlah_pasien_meninggal') ?: '0' }}</span>
                <span class="sc-label">Meninggal</span>
            </div>
            <div class="ruangan-summary-cell">
                <i class="fas fa-walking sc-icon" style="color:#15803d;"></i>
                <span class="sc-value">{{ $laporanUmum->sum('jumlah_pasien_pulang') ?: '0' }}</span>
                <span class="sc-label">Pulang</span>
            </div>
            <div class="ruangan-summary-cell is-total">
                <i class="fas fa-hospital-user sc-icon"></i>
                <span class="sc-value">{{ $totalUmum ?: '0' }}</span>
                <span class="sc-label">Total Pasien</span>
            </div>
            <div class="ruangan-summary-cell" style="background:linear-gradient(135deg,#1e3a5f 0%,#2d6a9f 100%);">
                <i class="fas fa-user-nurse sc-icon" style="color:#93c5fd;"></i>
                <span class="sc-value" style="color:#fff;">{{ $laporanUmum->sum('jumlah_petugas') ?: '0' }}</span>
                <span class="sc-label" style="color:rgba(255,255,255,.75);">Petugas</span>
            </div>
        </div>

        {{-- ── Card Grid per Ruangan ── --}}
        <div class="ruangan-section-heading">
            <i class="fas fa-th-large"></i> Per Ruangan
        </div>
        <div class="ruangan-card-grid" id="ruanganCardGrid">
            @foreach ($laporanUmum as $data)
            @php
                $stats = [
                    ['label' => 'Lama',     'value' => $data->jumlah_pasien_lama,      'icon' => 'fa-user-clock'],
                    ['label' => 'Baru',     'value' => $data->jumlah_pasien_baru,      'icon' => 'fa-user-plus'],
                    ['label' => 'Pindah',   'value' => $data->jumlah_pasien_pindah,    'icon' => 'fa-exchange-alt'],
                    ['label' => 'Pindahan', 'value' => $data->jumlah_pasien_pindahan,  'icon' => 'fa-sign-in-alt'],
                    ['label' => 'Meninggal','value' => $data->jumlah_pasien_meninggal, 'icon' => 'fa-heart-broken'],
                    ['label' => 'Pulang',   'value' => $data->jumlah_pasien_pulang,    'icon' => 'fa-walking'],
                ];
                $hasIstimewa = \App\Models\Catatanpasien::where('id_laporan_umum',$data->id)->where('id_ruangan',$data->id_ruangan)->where('id_jenis_pasien',1)->exists();
                $hasBaru     = \App\Models\Catatanpasien::where('id_laporan_umum',$data->id)->where('id_ruangan',$data->id_ruangan)->where('id_jenis_pasien',2)->exists();
                $hasActions  = $hasIstimewa || $hasBaru || $data->permasalahan_umum;
            @endphp
            <div class="ruangan-card" data-ruangan-id="{{ $data->id_ruangan }}">
                {{-- Header --}}
                <div class="ruangan-card-header">
                    <span class="ruangan-card-title" title="{{ $data->ruangan->nama_ruangan ?? '-' }}">
                        <i class="fas fa-hospital me-1 text-primary" style="opacity:.6"></i>
                        {{ $data->ruangan->nama_ruangan ?? '-' }}
                    </span>
                    <span class="ruangan-card-total" title="Total pasien">Total Pasien : {{ $data->jumlah_total_pasien ?: '0' }}</span>
                </div>
                {{-- Stats --}}
                <div class="ruangan-card-body">
                    <div class="ruangan-card-stats">
                        @foreach($stats as $s)
                        <div class="ruangan-card-stat">
                            <span class="cs-value {{ !$s['value'] ? 'is-zero' : '' }}">{{ $s['value'] ?: '0' }}</span>
                            <span class="cs-label">{{ $s['label'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    {{-- Petugas Strip --}}
                    @php
                        $jmlPetugas   = $data->jumlah_petugas ?? 0;
                        $perbantuanMasuk  = $data->jumlah_petugas_perbantuan_masuk ?? 0;
                        $perbantuanKeluar = $data->jumlah_petugas_perbantuan_keluar ?? 0;
                        $efektif = max(0, $jmlPetugas + $perbantuanMasuk - $perbantuanKeluar);
                        $totalPasien = $data->jumlah_total_pasien ?? 0;
                        $rasioVal = $efektif > 0 ? round($totalPasien / $efektif, 1) : null;
                        $rasioKelas = $rasioVal === null ? 'secondary' : ($rasioVal <= 4 ? 'success' : ($rasioVal <= 7 ? 'warning' : 'danger'));
                        $rasioLabel = $rasioVal === null ? '—' : '1:' . $rasioVal;
                        $rasioIcon = $rasioVal === null ? '' : ($rasioVal <= 4 ? '🟢' : ($rasioVal <= 7 ? '🟡' : '🔴'));
                        $namaAsalPerbantuan   = $data->ruanganPerbantuanMasuk->nama_ruangan  ?? null;
                        $namaTujuanPerbantuan = $data->ruanganPerbantuanKeluar->nama_ruangan ?? null;
                    @endphp
                    <div class="d-flex align-items-center gap-2 px-2 pt-2 pb-1 border-top" style="font-size:.75rem;">
                        <span class="fw-semibold text-muted"><i class="fas fa-user-nurse me-1"></i>{{ $efektif }} Petugas</span>
                        @if($perbantuanMasuk > 0)
                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill" title="Perbantuan dari {{ $namaAsalPerbantuan ?? '?' }}">
                                +{{ $perbantuanMasuk }} dari {{ $namaAsalPerbantuan ?? '?' }}
                            </span>
                        @endif
                        @if($perbantuanKeluar > 0)
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill" title="Perbantuan ke {{ $namaTujuanPerbantuan ?? '?' }}">
                                -{{ $perbantuanKeluar }} ke {{ $namaTujuanPerbantuan ?? '?' }}
                            </span>
                        @endif
                        <span class="ms-auto badge bg-{{ $rasioKelas }}-subtle text-{{ $rasioKelas }} border border-{{ $rasioKelas }}-subtle rounded-pill fw-bold">
                            {{ $rasioIcon }} {{ $rasioLabel }}
                        </span>
                    </div>
                </div>
                {{-- Footer / Actions --}}
                <div class="ruangan-card-footer">
                    @if(!$hasActions)
                        <span class="no-action"><i class="fas fa-minus-circle me-1"></i>Tidak ada catatan</span>
                    @else
                        @if($hasIstimewa)
                        <button data-id="{{ $data->id }}" data-ruangan="{{ $data->id_ruangan }}"
                            class="btn btn-sm btn-primary btn-istimewa text-white"
                            data-bs-toggle="modal" data-bs-target="#istimewa">
                            <i class="fas fa-star me-1"></i>Istimewa
                        </button>
                        @endif
                        @if($hasBaru)
                        <button data-id="{{ $data->id }}" data-ruangan="{{ $data->id_ruangan }}"
                            class="btn btn-sm btn-info btn-baru text-white"
                            data-bs-toggle="modal" data-bs-target="#baru">
                            <i class="fas fa-user-plus me-1"></i>Pasien Baru
                        </button>
                        @endif
                        @if($data->permasalahan_umum)
                        <button data-id="{{ $data->id }}" data-ruangan="{{ $data->id_ruangan }}"
                            class="btn btn-sm btn-warning btn-permasalahan"
                            data-bs-toggle="modal" data-bs-target="#permasalahan">
                            <i class="fas fa-exclamation-triangle me-1"></i>Catatan
                        </button>
                        @endif
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @endif
    </div>
</div>