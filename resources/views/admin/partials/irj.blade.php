<style>
    /* ── IRJ Card Grid ── */
    .irj-summary-strip {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        padding: .75rem 1.1rem;
        border-radius: .65rem;
        background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
        border: 1px solid #bae6fd;
        margin-bottom: .85rem;
    }
    .irj-summary-item { text-align: center; min-width: 72px; }
    .irj-summary-val  { font-size: 1.15rem; font-weight: 800; }
    .irj-summary-lbl  { font-size: .62rem; color: #64748b; text-transform: uppercase; letter-spacing: .03em; }

    .irj-doctor-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: .75rem;
    }
    @media (max-width: 960px) { .irj-doctor-grid { grid-template-columns: repeat(2,1fr); } }
    @media (max-width: 576px) { .irj-doctor-grid { grid-template-columns: 1fr; } }

    .irj-doctor-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: .7rem;
        overflow: hidden;
        transition: box-shadow .2s, transform .15s;
    }
    .irj-doctor-card:hover {
        box-shadow: 0 6px 20px rgba(0,0,0,.1);
        transform: translateY(-2px);
    }
    .irj-doctor-header {
        background: linear-gradient(135deg, #0c4a6e, #0ea5e9);
        padding: .5rem .8rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }
    .irj-doctor-avatar {
        width: 2rem; height: 2rem;
        background: rgba(255,255,255,.25);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: .75rem;
        font-weight: 800;
        color: #fff;
        flex-shrink: 0;
    }
    .irj-doctor-name-wrap { overflow: hidden; min-width: 0; }
    .irj-doctor-name {
        font-size: .78rem;
        font-weight: 700;
        color: #fff;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .irj-doctor-sdmk {
        font-size: .62rem;
        color: rgba(255,255,255,.72);
    }
    .irj-doctor-stats {
        display: grid;
        grid-template-columns: repeat(3,1fr);
    }
    .irj-doctor-stat {
        text-align: center;
        padding: .6rem .25rem;
        border-right: 1px solid #f1f5f9;
        border-bottom: 1px solid #f1f5f9;
    }
    .irj-doctor-stat:last-child { border-right: none; }
    .irj-doctor-stat-val {
        font-size: 1.05rem;
        font-weight: 800;
        line-height: 1;
    }
    .irj-doctor-stat-lbl {
        font-size: .6rem;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: .03em;
    }

    /* ── IRJ Info Panel ── */
    .irj-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .85rem;
        margin-top: .85rem;
    }
    @media (max-width: 768px) { .irj-info-grid { grid-template-columns: 1fr; } }

    .irj-info-card {
        border-radius: .65rem;
        padding: .9rem 1rem;
        border: 1px solid #e2e8f0;
        border-left: 4px solid var(--irj-accent);
        background: #fff;
    }
    .irj-info-heading {
        display: flex; align-items: center; gap: .4rem;
        font-size: .72rem; font-weight: 800;
        text-transform: uppercase; letter-spacing: .04em;
        color: var(--irj-accent);
        margin-bottom: .45rem;
    }
    .irj-info-text  { font-size: .875rem; color: #334155; line-height: 1.6; white-space: pre-line; }
    .irj-info-empty { font-size: .85rem; color: #94a3b8; font-style: italic; }

    .irj-toolbar {
        display: grid;
        grid-template-columns: minmax(220px,1fr) minmax(180px,1fr) auto;
        gap: .65rem;
        align-items: end;
        margin-bottom: .85rem;
    }
    .irj-toolbar .form-label {
        margin-bottom: .25rem; color: #64748b;
        font-size: .7rem; font-weight: 800; text-transform: uppercase;
    }
    .irj-toolbar-actions { display: flex; gap: .4rem; }
    .irj-toolbar-actions .btn { white-space: nowrap; }
    @media (max-width: 768px) {
        .irj-toolbar { grid-template-columns: 1fr 1fr; }
        .irj-toolbar-actions { grid-column: 1 / -1; }
    }
</style>

{{-- ── Toolbar ── --}}
<div class="irj-toolbar">
    <div>
        <label for="irjSearch" class="form-label">Cari dokter</label>
        <input id="irjSearch" type="search" class="form-control" placeholder="Nama dokter...">
    </div>
    <div>
        <label for="irjSdmkFilter" class="form-label">Jenis SDMK</label>
        <select id="irjSdmkFilter" class="form-select">
            <option value="">Semua Jenis SDMK</option>
            @foreach($laporanIrjDetail->pluck('dokter.jenisSdmk.jenis')->filter()->unique()->sort() as $jenisSdmk)
            <option value="{{ $jenisSdmk }}">{{ $jenisSdmk }}</option>
            @endforeach
        </select>
    </div>
    <div class="irj-toolbar-actions">
        <button type="button" class="btn btn-outline-secondary" id="irjResetFilter" title="Reset filter"><i class="fas fa-undo"></i></button>
        <button type="button" class="btn btn-outline-success" id="irjExportCsv" title="Export CSV"><i class="fas fa-file-csv"></i></button>
        <button type="button" class="btn btn-outline-primary" id="irjPrint" title="Cetak"><i class="fas fa-print"></i></button>
    </div>
</div>

@if(!$getIDirj || $laporanIrjDetail->isEmpty())
<div class="pu-empty-state">
    <i class="fas fa-folder-open"></i>
    <h5 class="mb-1">Belum ada laporan IRJ</h5>
    <p class="mb-0">Belum ada data rawat jalan untuk tanggal ini.</p>
</div>
@else

{{-- ── Summary Strip ── --}}
<div class="irj-summary-strip mb-3">
    <div class="irj-summary-item">
        <div class="irj-summary-val text-info">{{ $laporanIrjDetail->sum('pasien_total') }}</div>
        <div class="irj-summary-lbl">Total Pasien</div>
    </div>
    <div style="width:1px;background:#bae6fd;align-self:stretch;"></div>
    <div class="irj-summary-item">
        <div class="irj-summary-val" style="color:#0369a1;">{{ $laporanIrjDetail->sum('pasien_lama') }}</div>
        <div class="irj-summary-lbl">Pasien Lama</div>
    </div>
    <div class="irj-summary-item">
        <div class="irj-summary-val" style="color:#16a34a;">{{ $laporanIrjDetail->sum('pasien_baru') }}</div>
        <div class="irj-summary-lbl">Pasien Baru</div>
    </div>
    <div style="width:1px;background:#bae6fd;align-self:stretch;"></div>
    <div class="irj-summary-item">
        <div class="irj-summary-val text-muted" style="font-size:.9rem;">{{ $laporanIrjDetail->count() }}</div>
        <div class="irj-summary-lbl">Dokter Berpraktek</div>
    </div>
</div>

{{-- ── Doctor Cards ── --}}
<div class="irj-doctor-grid" id="irjDoctorGrid">
    @foreach($laporanIrjDetail as $data)
    @php
        $namaDokter = $data->dokter->nama ?? '-';
        $jenisSdmk  = $data->dokter->jenisSdmk->jenis ?? '-';
        $initial    = strtoupper(mb_substr($namaDokter, 0, 1));
    @endphp
    <div class="irj-doctor-card" data-nama="{{ strtolower($namaDokter) }}" data-sdmk="{{ $jenisSdmk }}">
        <div class="irj-doctor-header">
            <div class="irj-doctor-avatar">{{ $initial }}</div>
            <div class="irj-doctor-name-wrap">
                <div class="irj-doctor-name" title="{{ $namaDokter }}">{{ $namaDokter }}</div>
                <div class="irj-doctor-sdmk">{{ $jenisSdmk }}</div>
            </div>
        </div>
        <div class="irj-doctor-stats">
            <div class="irj-doctor-stat">
                <div class="irj-doctor-stat-val" style="color:#0369a1;">{{ $data->pasien_lama }}</div>
                <div class="irj-doctor-stat-lbl">Lama</div>
            </div>
            <div class="irj-doctor-stat">
                <div class="irj-doctor-stat-val" style="color:#16a34a;">{{ $data->pasien_baru }}</div>
                <div class="irj-doctor-stat-lbl">Baru</div>
            </div>
            <div class="irj-doctor-stat">
                <div class="irj-doctor-stat-val" style="color:#1e293b;font-size:1.15rem;">{{ $data->pasien_total }}</div>
                <div class="irj-doctor-stat-lbl">Total</div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- ── Info Panel ── --}}
<div class="irj-info-grid">
    <div class="irj-info-card" style="--irj-accent:#dc2626;">
        <div class="irj-info-heading"><i class="fas fa-exclamation-triangle"></i> Masalah</div>
        @if(filled(trim((string) $masalahIrj)))
            <div class="irj-info-text">{{ $masalahIrj }}</div>
        @else
            <div class="irj-info-empty">Belum ada masalah yang dicatat.</div>
        @endif
    </div>
    <div class="irj-info-card" style="--irj-accent:#15803d;">
        <div class="irj-info-heading"><i class="fas fa-tasks"></i> Langkah Atasi Masalah</div>
        @if(filled(trim((string) $langkahIrj)))
            <div class="irj-info-text">{{ $langkahIrj }}</div>
        @else
            <div class="irj-info-empty">Belum ada langkah penanganan yang dicatat.</div>
        @endif
    </div>
</div>

@push('scripts')
<script>
(function() {
    const grid    = document.getElementById('irjDoctorGrid');
    if (!grid) return;
    const cards   = () => grid.querySelectorAll('.irj-doctor-card');
    const search  = document.getElementById('irjSearch');
    const sdmkSel = document.getElementById('irjSdmkFilter');
    const reset   = document.getElementById('irjResetFilter');

    function filterCards() {
        const q    = (search?.value ?? '').toLowerCase();
        const sdmk = (sdmkSel?.value ?? '').toLowerCase();
        cards().forEach(c => {
            const matchNama = !q    || c.dataset.nama.includes(q);
            const matchSdmk = !sdmk || c.dataset.sdmk.toLowerCase() === sdmk;
            c.style.display = (matchNama && matchSdmk) ? '' : 'none';
        });
    }
    search?.addEventListener('input', filterCards);
    sdmkSel?.addEventListener('change', filterCards);
    reset?.addEventListener('click', () => {
        if (search)  search.value  = '';
        if (sdmkSel) sdmkSel.value = '';
        filterCards();
    });

    document.getElementById('irjExportCsv')?.addEventListener('click', () => {
        const rows = [['Nama Dokter','SDMK Jenis','Pasien Lama','Pasien Baru','Total']];
        cards().forEach(c => {
            if (c.style.display === 'none') return;
            const vals = c.querySelectorAll('.irj-doctor-stat-val');
            rows.push([c.querySelector('.irj-doctor-name').textContent.trim(), c.dataset.sdmk,
                vals[0]?.textContent.trim(), vals[1]?.textContent.trim(), vals[2]?.textContent.trim()]);
        });
        const csv = rows.map(r => r.join(',')).join('\n');
        const a = document.createElement('a');
        a.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
        a.download = 'laporan-irj.csv';
        a.click();
    });

    document.getElementById('irjPrint')?.addEventListener('click', () => window.print());
})();
</script>
@endpush