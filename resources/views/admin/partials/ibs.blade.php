<style>
    /* ── IBS Card Grid ── */
    .ibs-summary-strip {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        padding: .75rem 1.1rem;
        border-radius: .65rem;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        border: 1px solid #c7d2fe;
        margin-bottom: .85rem;
    }
    .ibs-summary-item { text-align: center; min-width: 72px; }
    .ibs-summary-val  { font-size: 1.15rem; font-weight: 800; }
    .ibs-summary-lbl  { font-size: .62rem; color: #64748b; text-transform: uppercase; letter-spacing: .03em; }

    .ibs-patient-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: .75rem;
    }
    @media (max-width: 768px) { .ibs-patient-grid { grid-template-columns: 1fr; } }

    .ibs-patient-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: .75rem;
        overflow: hidden;
        transition: box-shadow .2s, transform .15s;
    }
    .ibs-patient-card:hover {
        box-shadow: 0 6px 20px rgba(0,0,0,.1);
        transform: translateY(-2px);
    }
    .ibs-patient-header {
        background: linear-gradient(135deg, #1e1b4b, #6366f1);
        padding: .5rem .85rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .ibs-patient-name {
        font-size: .78rem; font-weight: 700; color: #fff;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 70%;
    }
    .ibs-patient-rm {
        font-size: .67rem; font-weight: 600;
        color: rgba(255,255,255,.72);
        background: rgba(255,255,255,.15);
        padding: .15rem .5rem; border-radius: 999px;
        white-space: nowrap;
    }
    .ibs-patient-body {
        padding: .55rem .85rem;
        display: flex; flex-direction: column; gap: .2rem;
    }
    .ibs-patient-row {
        display: flex; gap: .4rem; align-items: baseline;
    }
    .ibs-patient-key {
        font-size: .62rem; font-weight: 700; color: #94a3b8;
        text-transform: uppercase; min-width: 80px; flex-shrink: 0;
    }
    .ibs-patient-val {
        font-size: .77rem; color: #334155; font-weight: 500;
    }
    .ibs-patient-footer {
        display: grid;
        grid-template-columns: 1fr 1fr;
        border-top: 1px solid #f1f5f9;
    }
    .ibs-patient-time {
        text-align: center; padding: .4rem .3rem;
        border-right: 1px solid #f1f5f9;
    }
    .ibs-patient-time:last-child { border-right: none; }
    .ibs-patient-time-val {
        font-size: .82rem; font-weight: 700;
        color: #6366f1;
    }
    .ibs-patient-time-lbl {
        font-size: .58rem; color: #94a3b8; text-transform: uppercase;
    }
    .ibs-diagnosa-strip {
        padding: .4rem .85rem;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        font-size: .72rem;
        color: #475569;
        display: flex; gap: .5rem; flex-wrap: wrap;
    }
    .ibs-diagnosa-badge {
        display: inline-flex; align-items: center; gap: .25rem;
        padding: .15rem .5rem; border-radius: 999px; font-size: .62rem; font-weight: 600;
    }

    /* ── IBS Toolbar ── */
    .ibs-toolbar {
        display: grid;
        grid-template-columns: minmax(220px,1.5fr) minmax(160px,1fr) minmax(180px,1fr) auto;
        gap: .65rem; align-items: end; margin-bottom: .85rem;
    }
    .ibs-toolbar .form-label {
        margin-bottom:.25rem; color:#64748b;
        font-size:.7rem; font-weight:800; text-transform:uppercase;
    }
    .ibs-toolbar-actions { display:flex; gap:.4rem; }
    .ibs-toolbar-actions .btn { white-space: nowrap; }
    @media (max-width: 768px) {
        .ibs-toolbar { grid-template-columns: 1fr 1fr; }
        .ibs-toolbar-actions { grid-column: 1 / -1; }
    }

    /* ── IBS Note Panel ── */
    .ibs-note-panel {
        margin-top: 1rem; padding: .9rem 1rem;
        border: 1px solid #e2e8f0;
        border-left: 4px solid #f59e0b;
        border-radius: .65rem; background: #fffaf0;
    }
    .ibs-note-heading {
        display: flex; align-items: center; gap: .45rem;
        color: #8a5a00; font-size: .72rem; font-weight: 800;
        text-transform: uppercase; letter-spacing: .04em; margin-bottom: .4rem;
    }
    .ibs-note-content { color: #4b5563; font-size: .9rem; line-height: 1.6; white-space: pre-line; }
    .ibs-note-empty   { color: #9a7b36; font-size: .85rem; font-style: italic; }
</style>

{{-- ── Toolbar ── --}}
<div class="ibs-toolbar">
    <div>
        <label for="ibsSearch" class="form-label">Cari pasien / RM</label>
        <input id="ibsSearch" type="search" class="form-control" placeholder="Nama pasien atau nomor RM...">
    </div>
    <div>
        <label for="ibsRoomFilter" class="form-label">Ruangan asal</label>
        <select id="ibsRoomFilter" class="form-select">
            <option value="">Semua Ruangan</option>
            @foreach($laporanIbsDetail->pluck('ruangan.nama_ruangan')->filter()->unique()->sort() as $namaRuangan)
            <option value="{{ strtolower($namaRuangan) }}">{{ $namaRuangan }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="ibsDoctorFilter" class="form-label">Dokter operasi</label>
        <input id="ibsDoctorFilter" type="search" class="form-control" placeholder="Nama dokter...">
    </div>
    <div class="ibs-toolbar-actions">
        <button type="button" class="btn btn-outline-secondary" id="ibsResetFilter" title="Reset filter"><i class="fas fa-undo"></i></button>
        <button type="button" class="btn btn-outline-success" id="ibsExportCsv" title="Export CSV"><i class="fas fa-file-csv"></i></button>
        <button type="button" class="btn btn-outline-primary" id="ibsPrint" title="Cetak"><i class="fas fa-print"></i></button>
    </div>
</div>

@if(!$getIDibs || $laporanIbsDetail->isEmpty())
<div class="pu-empty-state">
    <i class="fas fa-folder-open"></i>
    <h5 class="mb-1">Belum ada laporan IBS</h5>
    <p class="mb-0">Belum ada data operasi untuk tanggal ini.</p>
</div>
@else

{{-- ── Summary Strip ── --}}
<div class="ibs-summary-strip mb-3">
    <div class="ibs-summary-item">
        <div class="ibs-summary-val text-primary">{{ $laporanIbsDetail->count() }}</div>
        <div class="ibs-summary-lbl">Total Operasi</div>
    </div>
    <div style="width:1px;background:#c7d2fe;align-self:stretch;"></div>
    <div class="ibs-summary-item">
        <div class="ibs-summary-val" style="color:#16a34a;">{{ $laporanIbsDetail->whereNotNull('jam_selesai')->count() }}</div>
        <div class="ibs-summary-lbl">Selesai</div>
    </div>
    <div class="ibs-summary-item">
        <div class="ibs-summary-val" style="color:#d97706;">{{ $laporanIbsDetail->whereNull('jam_selesai')->count() }}</div>
        <div class="ibs-summary-lbl">Belum Selesai</div>
    </div>
    <div style="width:1px;background:#c7d2fe;align-self:stretch;"></div>
    <div class="ibs-summary-item">
        <div class="ibs-summary-val text-muted" style="font-size:.9rem;">
            {{ $laporanIbsDetail->pluck('ruangan.nama_ruangan')->filter()->unique()->count() }}
        </div>
        <div class="ibs-summary-lbl">Ruangan</div>
    </div>
</div>

{{-- ── Patient Cards ── --}}
<div class="ibs-patient-grid" id="ibsPatientGrid">
@foreach($laporanIbsDetail as $index => $data)
@php
    $arrdokteroperasi = array_filter(explode(',', $data->id_dokter_operasi ?? ''));
    $dokterOps = \App\Models\Dokterirj::whereIn('id', $arrdokteroperasi)->get()->pluck('nama')->join(', ');
    $selesai = !!$data->jam_selesai;
@endphp
<div class="ibs-patient-card"
     data-nama="{{ strtolower($data->nama) }}"
     data-rm="{{ strtolower($data->rm) }}"
     data-ruangan="{{ strtolower($data->ruangan->nama_ruangan ?? '') }}"
     data-dokter="{{ strtolower($dokterOps) }}">
    <div class="ibs-patient-header">
        <span class="ibs-patient-name" title="{{ $data->nama }}">
            <i class="fas fa-user-injured me-1" style="font-size:.65rem;"></i>{{ $data->nama }}
        </span>
        <span class="ibs-patient-rm">{{ $data->rm }}</span>
    </div>
    <div class="ibs-patient-body">
        <div class="ibs-patient-row">
            <span class="ibs-patient-key"><i class="fas fa-procedures" style="font-size:.6rem;"></i> Ruangan</span>
            <span class="ibs-patient-val">{{ $data->ruangan->nama_ruangan ?? '-' }}</span>
        </div>
        @if($dokterOps)
        <div class="ibs-patient-row">
            <span class="ibs-patient-key"><i class="fas fa-user-md" style="font-size:.6rem;"></i> Dokter Op.</span>
            <span class="ibs-patient-val">{{ $dokterOps }}</span>
        </div>
        @endif
        <div class="ibs-patient-row">
            <span class="ibs-patient-key"><i class="fas fa-syringe" style="font-size:.6rem;"></i> Anestesi</span>
            <span class="ibs-patient-val">{{ $data->dokterAnestesi->nama ?? '-' }}</span>
        </div>
        @if($data->pendamping)
        <div class="ibs-patient-row">
            <span class="ibs-patient-key"><i class="fas fa-user-nurse" style="font-size:.6rem;"></i> Pendamping</span>
            <span class="ibs-patient-val">{{ $data->pendamping }}</span>
        </div>
        @endif
    </div>
    <div class="ibs-patient-footer">
        <div class="ibs-patient-time">
            <div class="ibs-patient-time-val">{{ $data->jam_mulai ?: '-' }}</div>
            <div class="ibs-patient-time-lbl">Mulai</div>
        </div>
        <div class="ibs-patient-time">
            <div class="ibs-patient-time-val" style="{{ $selesai ? 'color:#16a34a' : 'color:#d97706' }}">
                {{ $data->jam_selesai ?: 'Berlangsung' }}
            </div>
            <div class="ibs-patient-time-lbl">Selesai</div>
        </div>
    </div>
    @if(filled($data->diagnosa_pre) || filled($data->diagnosa_post))
    <div class="ibs-diagnosa-strip">
        @if(filled($data->diagnosa_pre))
        <span class="ibs-diagnosa-badge" style="background:#ede9fe;color:#6d28d9;">
            <i class="fas fa-notes-medical" style="font-size:.55rem;"></i> Pre: {{ Str::limit($data->diagnosa_pre, 40) }}
        </span>
        @endif
        @if(filled($data->diagnosa_post))
        <span class="ibs-diagnosa-badge" style="background:#d1fae5;color:#065f46;">
            <i class="fas fa-check-circle" style="font-size:.55rem;"></i> Post: {{ Str::limit($data->diagnosa_post, 40) }}
        </span>
        @endif
    </div>
    @endif
</div>
@endforeach
</div>
@endif

{{-- ── Note Panel ── --}}
<div class="ibs-note-panel mt-3">
    <div class="ibs-note-heading">
        <i class="fas fa-sticky-note"></i> Catatan IBS untuk Dinas Berikutnya
    </div>
    @if(filled(trim((string) $catatanIbs)))
        <div class="ibs-note-content">{{ $catatanIbs }}</div>
    @else
        <div class="ibs-note-empty">Belum ada catatan untuk dinas berikutnya.</div>
    @endif
</div>

@push('scripts')
<script>
(function() {
    const grid    = document.getElementById('ibsPatientGrid');
    if (!grid) return;
    const cards   = () => grid.querySelectorAll('.ibs-patient-card');
    const search  = document.getElementById('ibsSearch');
    const roomSel = document.getElementById('ibsRoomFilter');
    const dokSrc  = document.getElementById('ibsDoctorFilter');
    const reset   = document.getElementById('ibsResetFilter');

    function filter() {
        const q   = (search?.value ?? '').toLowerCase();
        const rm  = q;
        const r   = (roomSel?.value ?? '').toLowerCase();
        const d   = (dokSrc?.value  ?? '').toLowerCase();
        cards().forEach(c => {
            const mn = !q || c.dataset.nama.includes(q) || c.dataset.rm.includes(q);
            const mr = !r || c.dataset.ruangan === r;
            const md = !d || c.dataset.dokter.includes(d);
            c.style.display = (mn && mr && md) ? '' : 'none';
        });
    }
    search?.addEventListener('input', filter);
    roomSel?.addEventListener('change', filter);
    dokSrc?.addEventListener('input', filter);
    reset?.addEventListener('click', () => {
        [search, dokSrc].forEach(el => { if(el) el.value = ''; });
        if(roomSel) roomSel.value = '';
        filter();
    });
    document.getElementById('ibsExportCsv')?.addEventListener('click', () => {
        const rows = [['Nama','RM','Ruangan','Mulai','Selesai']];
        cards().forEach(c => {
            if (c.style.display === 'none') return;
            const vals = c.querySelectorAll('.ibs-patient-time-val');
            rows.push([c.querySelector('.ibs-patient-name')?.textContent.trim(),
                c.dataset.rm, c.dataset.ruangan,
                vals[0]?.textContent.trim(), vals[1]?.textContent.trim()]);
        });
        const csv = rows.map(r => r.join(',')).join('\n');
        const a = document.createElement('a');
        a.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
        a.download = 'laporan-ibs.csv';
        a.click();
    });
    document.getElementById('ibsPrint')?.addEventListener('click', () => window.print());
})();
</script>
@endpush