<!-- Ringkasan operasional IGD -->
<?php
$igdStatGroups = [
    [
        'title'       => 'Kondisi IGD',
        'description' => 'Situasi pasien saat ini',
        'gradient'    => 'linear-gradient(135deg,#7f1d1d,#ef4444)',
        'icon'        => 'fas fa-ambulance',
        'stats'       => [
            ['lbl' => 'Dirawat',       'key' => 'jumlah_pasien_rawat',         'color' => '#2563eb'],
            ['lbl' => 'Emergency',     'key' => 'jumlah_pasien_emergency',     'color' => '#dc2626'],
            ['lbl' => 'Non-Emergency', 'key' => 'jumlah_pasien_non_emergency', 'color' => '#d97706'],
        ],
    ],
    [
        'title'       => 'Outcome Pasien',
        'description' => 'Hasil pelayanan pasien',
        'gradient'    => 'linear-gradient(135deg,#14532d,#22c55e)',
        'icon'        => 'fas fa-chart-line',
        'stats'       => [
            ['lbl' => 'Pulang',        'key' => 'jumlah_pasien_pulang',           'color' => '#16a34a'],
            ['lbl' => 'Rujuk/Tolak',   'key' => 'jumlah_pasien_tidak_bisa_rawat', 'color' => '#7c3aed'],
            ['lbl' => 'DOA/Meninggal', 'key' => 'jumlah_pasien_doa',             'color' => '#dc2626'],
        ],
    ],
    [
        'title'       => 'SISRUTE',
        'description' => 'Status rujukan antar fasilitas',
        'gradient'    => 'linear-gradient(135deg,#0c4a6e,#0ea5e9)',
        'icon'        => 'fas fa-network-wired',
        'stats'       => [
            ['lbl' => 'Rujukan',   'key' => 'jumlah_pasien_sisrute',          'color' => '#0369a1'],
            ['lbl' => 'Diterima',  'key' => 'jumlah_pasien_sisrute_diterima', 'color' => '#16a34a'],
            ['lbl' => 'Ditolak',   'key' => 'jumlah_pasien_sisrute_ditolak',  'color' => '#dc2626'],
        ],
    ],
];
?>

<style>
    /* ── IGD Card Groups ── */
    .igd-group-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: .85rem;
        margin-bottom: 1rem;
    }
    @media (max-width: 900px) { .igd-group-grid { grid-template-columns: 1fr; } }

    .igd-group-card {
        border-radius: .8rem;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0,0,0,.06);
        transition: box-shadow .2s, transform .15s;
    }
    .igd-group-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,.12);
        transform: translateY(-2px);
    }
    .igd-group-header {
        padding: .6rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .igd-group-header-left { display: flex; align-items: center; gap: .55rem; }
    .igd-group-header-icon {
        width: 2rem; height: 2rem;
        background: rgba(255,255,255,.2);
        border-radius: .4rem;
        display: flex; align-items: center; justify-content: center;
        color: #fff;
        font-size: .85rem;
    }
    .igd-group-title { font-size: .82rem; font-weight: 800; color: #fff; }
    .igd-group-desc  { font-size: .65rem; color: rgba(255,255,255,.75); }
    .igd-group-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        background: #fff;
    }
    .igd-group-stat-cell {
        text-align: center;
        padding: .75rem .4rem;
        border-right: 1px solid #f1f5f9;
    }
    .igd-group-stat-cell:last-child { border-right: none; }
    .igd-group-stat-val {
        font-size: 1.45rem;
        font-weight: 800;
        line-height: 1;
    }
    .igd-group-stat-lbl {
        font-size: .62rem;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: .04em;
        margin-top: .15rem;
    }

    /* ── IGD Detail Panels ── */
    .igd-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .85rem;
        margin-top: .85rem;
    }
    @media (max-width: 768px) { .igd-info-grid { grid-template-columns: 1fr; } }

    .igd-info-card {
        border-radius: .7rem;
        padding: .9rem 1rem;
        border: 1px solid #e2e8f0;
        border-left: 4px solid var(--igd-info-accent);
        background: #fff;
    }
    .igd-info-card-heading {
        display: flex;
        align-items: center;
        gap: .45rem;
        font-size: .72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: var(--igd-info-accent);
        margin-bottom: .5rem;
    }
    .igd-info-card-text {
        font-size: .875rem;
        color: #334155;
        line-height: 1.6;
        white-space: pre-line;
    }
    .igd-info-card-empty {
        font-size: .85rem;
        color: #94a3b8;
        font-style: italic;
    }
    .igd-doctor-chips { display: flex; flex-wrap: wrap; gap: .4rem; }
    .igd-doctor-chip {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .3rem .65rem;
        border-radius: 999px;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: .75rem;
        font-weight: 600;
    }
</style>

{{-- ── Group Cards ── --}}
<div class="igd-group-grid">
@foreach($igdStatGroups as $group)
<div class="igd-group-card">
    <div class="igd-group-header" style="background:{{ $group['gradient'] }};">
        <div class="igd-group-header-left">
            <div class="igd-group-header-icon"><i class="{{ $group['icon'] }}"></i></div>
            <div>
                <div class="igd-group-title">{{ $group['title'] }}</div>
                <div class="igd-group-desc">{{ $group['description'] }}</div>
            </div>
        </div>
    </div>
    <div class="igd-group-stats">
        @foreach($group['stats'] as $s)
        <div class="igd-group-stat-cell">
            <div class="igd-group-stat-val" style="color:{{ $s['color'] }}">
                {{ $igdStatsRaw ? ($igdStatsRaw->{$s['key']} ?? 0) : 0 }}
            </div>
            <div class="igd-group-stat-lbl">{{ $s['lbl'] }}</div>
        </div>
        @endforeach
    </div>
</div>
@endforeach
</div>

{{-- ── Info & Dokter Grid ── --}}
<div class="igd-info-grid">
    {{-- Alasan --}}
    <div class="igd-info-card" style="--igd-info-accent:#7c3aed;">
        <div class="igd-info-card-heading">
            <i class="fas fa-file-medical-alt"></i> Alasan Tidak Bisa Dirawat
        </div>
        @if(filled($igdStatsRaw->alasan_tidak_bisa_rawat ?? ''))
            <div class="igd-info-card-text">{{ $igdStatsRaw->alasan_tidak_bisa_rawat }}</div>
        @else
            <div class="igd-info-card-empty">Belum ada catatan.</div>
        @endif
    </div>

    {{-- Dokter Jaga --}}
    <div class="igd-info-card" style="--igd-info-accent:#2563eb;">
        <div class="igd-info-card-heading">
            <i class="fas fa-user-md"></i> Dokter Jaga
        </div>
        @if($igdStatsRaw && $igdStatsRaw->id_dokter)
            @php
                $idDokterArr = array_filter(array_map('trim', explode(',', $igdStatsRaw->id_dokter)));
                $dokterJaga  = \App\Models\Dokter::whereIn('id', $idDokterArr)->get();
            @endphp
            @if($dokterJaga->isNotEmpty())
                <div class="igd-doctor-chips">
                    @foreach($dokterJaga as $dj)
                    <span class="igd-doctor-chip"><i class="fas fa-stethoscope" style="font-size:.65rem;"></i>{{ $dj->nama_dokter }}</span>
                    @endforeach
                </div>
            @else
                <div class="igd-info-card-empty">Data dokter tidak ditemukan.</div>
            @endif
        @else
            <div class="igd-info-card-empty">Belum ada dokter yang ditugaskan.</div>
        @endif
    </div>

    {{-- Permasalahan --}}
    <div class="igd-info-card" style="--igd-info-accent:#dc2626;">
        <div class="igd-info-card-heading">
            <i class="fas fa-exclamation-triangle"></i> Permasalahan
        </div>
        @if(filled($igdStatsRaw->permasalahan ?? ''))
            <div class="igd-info-card-text">{{ $igdStatsRaw->permasalahan }}</div>
        @else
            <div class="igd-info-card-empty">Belum ada permasalahan dicatat.</div>
        @endif
    </div>

    {{-- Lain-lain --}}
    <div class="igd-info-card" style="--igd-info-accent:#64748b;">
        <div class="igd-info-card-heading">
            <i class="fas fa-ellipsis-h"></i> Lain - lain
        </div>
        @if(filled($igdStatsRaw->lain_lain ?? ''))
            <div class="igd-info-card-text">{{ $igdStatsRaw->lain_lain }}</div>
        @else
            <div class="igd-info-card-empty">Tidak ada catatan lain.</div>
        @endif
    </div>
</div>