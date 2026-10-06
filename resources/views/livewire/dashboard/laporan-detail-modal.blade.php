<div>
    @if(!$laporan)
    <div class="text-center py-5 text-muted">
        <i class="fas fa-circle-notch fa-spin fa-2x mb-3"></i>
        <p>Memuat detail laporan...</p>
    </div>
    @else

    {{-- ── Shared Style ── --}}
    <style>
        /* Shared card components */
        .dm-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 0.625rem;
            overflow: hidden;
            transition: box-shadow .2s, transform .15s;
        }
        .dm-card:hover {
            box-shadow: 0 6px 20px rgba(0,0,0,.1);
            transform: translateY(-2px);
        }
        .dm-card-header {
            padding: .45rem .75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .dm-card-header.igd-hdr   { background: linear-gradient(135deg,#7f1d1d,#ef4444); }
        .dm-card-header.irj-hdr   { background: linear-gradient(135deg,#0c4a6e,#0ea5e9); }
        .dm-card-header.ibs-hdr   { background: linear-gradient(135deg,#1e1b4b,#6366f1); }
        .dm-card-header.umum-hdr  { background: linear-gradient(135deg,#1e40af,#3b82f6); }
        .dm-card-title {
            font-size: .78rem;
            font-weight: 700;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 72%;
        }
        .dm-card-badge {
            font-size: .68rem;
            font-weight: 700;
            color: rgba(255,255,255,.8);
            white-space: nowrap;
        }
        .dm-stats {
            display: grid;
            gap: 0;
        }
        .dm-stats-3 { grid-template-columns: repeat(3,1fr); }
        .dm-stats-4 { grid-template-columns: repeat(4,1fr); }
        .dm-stat-cell {
            text-align: center;
            padding: .38rem .2rem;
            border-right: 1px solid #f1f5f9;
            border-bottom: 1px solid #f1f5f9;
        }
        .dm-stats-3 .dm-stat-cell:nth-child(3n) { border-right: none; }
        .dm-stats-4 .dm-stat-cell:nth-child(4n) { border-right: none; }
        .dm-stat-value {
            font-size: .95rem;
            font-weight: 700;
            color: #1e293b;
            line-height: 1.1;
        }
        .dm-stat-label {
            font-size: .59rem;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .03em;
        }
        .dm-card-body {
            padding: .55rem .75rem;
            font-size: .8rem;
        }
        .dm-card-body .dm-info-row {
            display: flex;
            gap: .4rem;
            align-items: baseline;
            margin-bottom: .2rem;
        }
        .dm-card-body .dm-info-label {
            font-size: .65rem;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            min-width: 90px;
            flex-shrink: 0;
        }
        .dm-card-body .dm-info-val {
            font-size: .78rem;
            color: #334155;
            font-weight: 500;
        }
        .dm-flags {
            padding: .35rem .65rem;
            display: flex;
            flex-wrap: wrap;
            gap: .25rem;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            min-height: 30px;
        }
        .dm-flag {
            font-size: .6rem;
            font-weight: 600;
            padding: .12rem .4rem;
            border-radius: 999px;
        }
        /* Grid layouts */
        .dm-grid-3 { display: grid; grid-template-columns: repeat(3,1fr); gap: .75rem; }
        .dm-grid-2 { display: grid; grid-template-columns: repeat(2,1fr); gap: .75rem; }
        @media (max-width: 900px) {
            .dm-grid-3 { grid-template-columns: repeat(2,1fr); }
        }
        @media (max-width: 576px) {
            .dm-grid-3, .dm-grid-2 { grid-template-columns: 1fr; }
        }
        /* Summary strip */
        .dm-summary-strip {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            padding: .65rem 1rem;
            border-radius: .5rem;
            margin-bottom: .75rem;
        }
        .dm-summary-strip .dm-sum-item { text-align: center; min-width: 64px; }
        .dm-summary-strip .dm-sum-val  { font-size: 1.05rem; font-weight: 800; }
        .dm-summary-strip .dm-sum-lbl  { font-size: .6rem; color: #64748b; text-transform: uppercase; }
        /* textarea info panel */
        .dm-info-panel {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: .5rem;
            padding: .75rem 1rem;
            margin-top: .75rem;
        }
        .dm-info-panel h6 {
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: .4rem;
        }
        .dm-info-panel p {
            font-size: .82rem;
            color: #334155;
            margin: 0;
            white-space: pre-wrap;
        }
        /* IGD single big stat */
        .dm-igd-panel { border-radius: .625rem; overflow: hidden; border: 1px solid #fecaca; }
        .dm-igd-panel .dm-igd-header {
            background: linear-gradient(135deg, #7f1d1d, #ef4444);
            padding: .6rem 1rem;
            color: #fff;
        }
        .dm-igd-panel .dm-igd-header h5 { margin: 0; font-size: .95rem; font-weight: 700; }
        .dm-igd-panel .dm-igd-header small { font-size: .72rem; opacity: .8; }
    </style>

    {{-- ── Header ringkasan ── --}}
    <div class="dm-summary-strip mb-2"
         style="background:linear-gradient(135deg,
                @if($modalType==='igd') #fff1f2,#ffe4e6); border:1px solid #fecaca;
                @elseif($modalType==='irj') #f0f9ff,#e0f2fe); border:1px solid #bae6fd;
                @elseif($modalType==='ibs') #eef2ff,#e0e7ff); border:1px solid #c7d2fe;
                @else #eff6ff,#dbeafe); border:1px solid #bfdbfe;
                @endif">
        <div class="dm-sum-item">
            <div class="dm-sum-val
                @if($modalType==='igd') text-danger
                @elseif($modalType==='irj') text-info
                @elseif($modalType==='ibs') text-primary
                @else text-primary @endif">
                @if($modalType==='igd') {{ $rows->sum('jumlah_pasien') }}
                @elseif($modalType==='irj') {{ $rows->sum('pasien_total') }}
                @elseif($modalType==='ibs') {{ $rows->count() }}
                @else {{ $rows->sum('jumlah_total_pasien') }}
                @endif
            </div>
            <div class="dm-sum-lbl">Total Pasien</div>
        </div>
        <div style="width:1px;background:#cbd5e1;align-self:stretch;"></div>
        <div class="dm-sum-item">
            <div class="dm-sum-val text-muted" style="font-size:.85rem;">{{ $laporan->created_at->isoFormat('D MMM Y') }}</div>
            <div class="dm-sum-lbl">Tanggal</div>
        </div>
        <div class="dm-sum-item">
            <div class="dm-sum-val text-muted" style="font-size:.85rem;">{{ strtoupper(optional($laporan->dinas)->dinas ?? '-') }}</div>
            <div class="dm-sum-lbl">Dinas</div>
        </div>
    </div>

    {{-- ═══════════════════════════════════ --}}
    {{-- IGD --}}
    {{-- ═══════════════════════════════════ --}}
    @if($modalType === 'igd')
    <div style="max-height:62vh; overflow-y:auto; padding-right:4px;">
        @forelse($rows as $item)
        <div class="dm-igd-panel mb-3">
            <div class="dm-igd-header d-flex justify-content-between align-items-center text-white">
                <h5 class="text-white"><i class="fas fa-ambulance me-2"></i>Instalasi Gawat Darurat</h5>
                <small>Total: <strong>{{ $item->jumlah_pasien }}</strong> pasien</small>
            </div>
            <div class="dm-stats dm-stats-3" style="background:#fff;">
                @php $igdStats = [
                    ['lbl'=>'Emergency',   'val'=>$item->jumlah_pasien_emergency,        'color'=>'#dc2626'],
                    ['lbl'=>'Non-Emergency','val'=>$item->jumlah_pasien_non_emergency,   'color'=>'#d97706'],
                    ['lbl'=>'Dirawat',     'val'=>$item->jumlah_pasien_rawat,            'color'=>'#2563eb'],
                    ['lbl'=>'Pulang',      'val'=>$item->jumlah_pasien_pulang,           'color'=>'#16a34a'],
                    ['lbl'=>'Rujuk/Tolak', 'val'=>$item->jumlah_pasien_tidak_bisa_rawat,'color'=>'#7c3aed'],
                    ['lbl'=>'DOA/Meninggal','val'=>$item->jumlah_pasien_doa,            'color'=>'#dc2626'],
                    ['lbl'=>'SISRUTE',     'val'=>$item->jumlah_pasien_sisrute,          'color'=>'#0369a1'],
                    ['lbl'=>'SISRUTE Diterima','val'=>$item->jumlah_pasien_sisrute_diterima,'color'=>'#16a34a'],
                    ['lbl'=>'SISRUTE Ditolak','val'=>$item->jumlah_pasien_sisrute_ditolak, 'color'=>'#dc2626'],
                ]; @endphp
                @foreach($igdStats as $s)
                <div class="dm-stat-cell">
                    <div class="dm-stat-value" style="color:{{ $s['color'] }}">{{ $s['val'] }}</div>
                    <div class="dm-stat-label">{{ $s['lbl'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div class="text-center text-muted py-4"><i class="fas fa-inbox fa-2x mb-2"></i><p>Tidak ada data.</p></div>
        @endforelse

        {{-- Info tambahan IGD --}}
        @if($extra['alasan'] ?? false)
        <div class="dm-info-panel">
            <h6><i class="fas fa-file-alt me-1"></i>Alasan Pasien Rujuk & Tolak Rawat</h6>
            <p>{{ $extra['alasan'] }}</p>
        </div>
        @endif
        @if($extra['permasalahan'] ?? false)
        <div class="dm-info-panel">
            <h6><i class="fas fa-exclamation-circle me-1 text-danger"></i>Permasalahan</h6>
            <p>{{ $extra['permasalahan'] }}</p>
        </div>
        @endif
        @if($extra['lain_lain'] ?? false)
        <div class="dm-info-panel">
            <h6><i class="fas fa-ellipsis-h me-1"></i>Lain-lain</h6>
            <p>{{ $extra['lain_lain'] }}</p>
        </div>
        @endif
    </div>

    {{-- ═══════════════════════════════════ --}}
    {{-- IRJ --}}
    {{-- ═══════════════════════════════════ --}}
    @elseif($modalType === 'irj')
    <div style="max-height:62vh; overflow-y:auto; padding-right:4px;">
        @if($rows->isEmpty())
            <div class="text-center text-muted py-4"><i class="fas fa-inbox fa-2x mb-2"></i><p>Tidak ada data dokter.</p></div>
        @else
        <div class="dm-grid-3">
            @foreach($rows as $idx => $item)
            <div class="dm-card">
                <div class="dm-card-header irj-hdr">
                    <span class="dm-card-title" title="{{ optional($item->dokter)->nama ?? '-' }}">
                        {{ optional($item->dokter)->nama ?? '-' }}
                    </span>
                    <span class="dm-card-badge">
                        {{ $item->pasien_total }} pasien
                    </span>
                </div>
                <div class="dm-stats dm-stats-3">
                    <div class="dm-stat-cell">
                        <div class="dm-stat-value" style="color:#0369a1;">{{ $item->pasien_lama }}</div>
                        <div class="dm-stat-label">Lama</div>
                    </div>
                    <div class="dm-stat-cell">
                        <div class="dm-stat-value" style="color:#16a34a;">{{ $item->pasien_baru }}</div>
                        <div class="dm-stat-label">Baru</div>
                    </div>
                    <div class="dm-stat-cell">
                        <div class="dm-stat-value" style="color:#1e293b;font-size:1.05rem;">{{ $item->pasien_total }}</div>
                        <div class="dm-stat-label">Total</div>
                    </div>
                </div>
                @if(optional(optional($item->dokter)->jenisSdmk)->jenis)
                <div class="dm-flags">
                    <span class="dm-flag" style="background:#e0f2fe;color:#0369a1;">
                        <i class="fas fa-user-md" style="font-size:.55rem;"></i>
                        {{ optional(optional($item->dokter)->jenisSdmk)->jenis }}
                    </span>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        {{-- Info tambahan IRJ --}}
        @if($extra['masalah'] ?? false)
        <div class="dm-info-panel">
            <h6><i class="fas fa-exclamation-circle me-1 text-danger"></i>Masalah</h6>
            <p>{{ $extra['masalah'] }}</p>
        </div>
        @endif
        @if($extra['langkah'] ?? false)
        <div class="dm-info-panel">
            <h6><i class="fas fa-tasks me-1 text-info"></i>Langkah Atasi Masalah</h6>
            <p>{{ $extra['langkah'] }}</p>
        </div>
        @endif
    </div>

    {{-- ═══════════════════════════════════ --}}
    {{-- IBS --}}
    {{-- ═══════════════════════════════════ --}}
    @elseif($modalType === 'ibs')
    <div style="max-height:62vh; overflow-y:auto; padding-right:4px;">
        @if($rows->isEmpty())
            <div class="text-center text-muted py-4"><i class="fas fa-inbox fa-2x mb-2"></i><p>Tidak ada data operasi.</p></div>
        @else
        <div class="dm-grid-2">
            @foreach($rows as $idx => $item)
            <div class="dm-card">
                <div class="dm-card-header ibs-hdr">
                    <span class="dm-card-title" title="{{ $item->nama }}">
                        <i class="fas fa-user-injured me-1" style="font-size:.7rem;"></i>
                        {{ $item->nama }}
                    </span>
                    <span class="dm-card-badge">RM: {{ $item->rm }}</span>
                </div>
                <div class="dm-card-body">
                    <div class="dm-info-row">
                        <span class="dm-info-label"><i class="fas fa-procedures me-1" style="font-size:.6rem;"></i>Ruangan</span>
                        <span class="dm-info-val">{{ optional($item->ruangan)->nama_ruangan ?? '-' }}</span>
                    </div>
                    <div class="dm-info-row">
                        <span class="dm-info-label"><i class="fas fa-user-md me-1" style="font-size:.6rem;"></i>Dokter Op.</span>
                        <span class="dm-info-val">
                            @if(count($item->dokter_operasi_names ?? []))
                                {{ implode(', ', $item->dokter_operasi_names) }}
                            @else - @endif
                        </span>
                    </div>
                    <div class="dm-info-row">
                        <span class="dm-info-label"><i class="fas fa-syringe me-1" style="font-size:.6rem;"></i>Anestesi</span>
                        <span class="dm-info-val">{{ optional($item->dokterAnestesi)->nama ?? '-' }}</span>
                    </div>
                    @if($item->pendamping)
                    <div class="dm-info-row">
                        <span class="dm-info-label"><i class="fas fa-user-nurse me-1" style="font-size:.6rem;"></i>Pendamping</span>
                        <span class="dm-info-val">{{ $item->pendamping }}</span>
                    </div>
                    @endif
                </div>
                <div class="dm-stats dm-stats-4" style="border-top:1px solid #e2e8f0;">
                    <div class="dm-stat-cell" style="border-bottom:none;">
                        <div class="dm-stat-value" style="font-size:.8rem;color:#6366f1;">{{ $item->jam_mulai ?? '-' }}</div>
                        <div class="dm-stat-label">Mulai</div>
                    </div>
                    <div class="dm-stat-cell" style="border-bottom:none;">
                        <div class="dm-stat-value" style="font-size:.8rem;color:#6366f1;">{{ $item->jam_selesai ?? '-' }}</div>
                        <div class="dm-stat-label">Selesai</div>
                    </div>
                    <div class="dm-stat-cell" style="border-bottom:none; grid-column:span 2;">
                        <div class="dm-stat-value" style="font-size:.72rem;color:#334155;text-align:left;padding-left:.2rem;">
                            <span style="color:#94a3b8;font-size:.6rem;text-transform:uppercase;">Pre</span>
                            {{ $item->diagnosa_pre ?? '-' }}<br>
                            <span style="color:#94a3b8;font-size:.6rem;text-transform:uppercase;">Post</span>
                            {{ $item->diagnosa_post ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Info tambahan IBS --}}
        @if($extra['catatan'] ?? false)
        <div class="dm-info-panel">
            <h6><i class="fas fa-clipboard me-1 text-primary"></i>Catatan IBS untuk Dinas Berikutnya</h6>
            <p>{{ $extra['catatan'] }}</p>
        </div>
        @endif
    </div>

    {{-- ═══════════════════════════════════ --}}
    {{-- UMUM (card grid — tidak berubah) --}}
    {{-- ═══════════════════════════════════ --}}
    @elseif($modalType === 'umum')
    <div style="max-height:62vh; overflow-y:auto; padding-right:4px;">
        @if($rows->isEmpty())
            <div class="text-center text-muted py-5">
                <i class="fas fa-inbox fa-2x mb-2"></i>
                <p>Tidak ada data untuk laporan ini.</p>
            </div>
        @else
        <div class="dm-grid-3">
        @foreach($rows as $item)
        @php
            $hasIstimewa = \App\Models\Catatanpasien::where('id_laporan_umum',$item->id)->where('id_ruangan',$item->id_ruangan)->where('id_jenis_pasien',1)->exists();
            $hasBaru     = \App\Models\Catatanpasien::where('id_laporan_umum',$item->id)->where('id_ruangan',$item->id_ruangan)->where('id_jenis_pasien',2)->exists();
            $flags = array_filter([
                $item->jumlah_pasien_covid              ? ['lbl'=>'Covid',    'bg'=>'#fee2e2','color'=>'#dc2626'] : null,
                $item->jumlah_pasien_suspek_covid       ? ['lbl'=>'Suspek',   'bg'=>'#ffedd5','color'=>'#c2410c'] : null,
                $item->jumlah_pasien_restrain           ? ['lbl'=>'Restrain', 'bg'=>'#ede9fe','color'=>'#7c3aed'] : null,
                $item->jumlah_pasien_perilaku_kekerasan ? ['lbl'=>'Kekerasan','bg'=>'#fee2e2','color'=>'#b91c1c'] : null,
                $item->jumlah_pasien_keracunan          ? ['lbl'=>'Keracunan','bg'=>'#fef3c7','color'=>'#d97706'] : null,
                $item->jumlah_pasien_keterbatasan_bahasa? ['lbl'=>'Bhs',      'bg'=>'#e0f2fe','color'=>'#0369a1'] : null,
                $item->jumlah_pasien_difabel            ? ['lbl'=>'Difabel',  'bg'=>'#d1fae5','color'=>'#047857'] : null,
                $item->permasalahan_umum                ? ['lbl'=>'Masalah',  'bg'=>'#fef9c3','color'=>'#b45309'] : null,
                $hasIstimewa                            ? ['lbl'=>'Istimewa', 'bg'=>'#fef3c7','color'=>'#b45309'] : null,
                $hasBaru                                ? ['lbl'=>'Ps. Baru', 'bg'=>'#d1fae5','color'=>'#065f46'] : null,
            ]);
        @endphp
        <div class="dm-card">
            <div class="dm-card-header umum-hdr">
                <span class="dm-card-title" title="{{ optional($item->ruangan)->nama_ruangan ?? '-' }}">
                    {{ optional($item->ruangan)->nama_ruangan ?? '-' }}
                </span>
                <span class="dm-card-badge">
                    <i class="fas fa-hospital-user" style="font-size:.65rem;"></i>
                    {{ $item->jumlah_total_pasien }}
                </span>
            </div>
            <div class="dm-stats dm-stats-3">
                <div class="dm-stat-cell"><div class="dm-stat-value">{{ $item->jumlah_pasien_lama }}</div><div class="dm-stat-label">Lama</div></div>
                <div class="dm-stat-cell"><div class="dm-stat-value">{{ $item->jumlah_pasien_baru }}</div><div class="dm-stat-label">Baru</div></div>
                <div class="dm-stat-cell"><div class="dm-stat-value">{{ $item->jumlah_pasien_pindah }}</div><div class="dm-stat-label">Pindah</div></div>
                <div class="dm-stat-cell"><div class="dm-stat-value">{{ $item->jumlah_pasien_pindahan }}</div><div class="dm-stat-label">Pindahan</div></div>
                <div class="dm-stat-cell">
                    <div class="dm-stat-value" style="{{ $item->jumlah_pasien_meninggal ? 'color:#dc2626' : '' }}">{{ $item->jumlah_pasien_meninggal }}</div>
                    <div class="dm-stat-label">Meninggal</div>
                </div>
                <div class="dm-stat-cell">
                    <div class="dm-stat-value" style="{{ $item->jumlah_pasien_pulang ? 'color:#16a34a' : '' }}">{{ $item->jumlah_pasien_pulang }}</div>
                    <div class="dm-stat-label">Pulang</div>
                </div>
            </div>
            @if(count($flags))
            <div class="dm-flags">
                @foreach($flags as $flag)
                <span class="dm-flag" style="background:{{ $flag['bg'] }};color:{{ $flag['color'] }};">{{ $flag['lbl'] }}</span>
                @endforeach
            </div>
            @endif
        </div>
        @endforeach
        </div>
        @endif
    </div>
    @endif

    @endif
</div>