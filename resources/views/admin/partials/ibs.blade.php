<style>
    .ibs-table-shell {
        overflow: hidden;
        border: 1px solid #dbe3ef;
        border-radius: .75rem;
        background: #fff;
    }

    #dataTableIBS {
        min-width: 1180px;
        margin-bottom: 0 !important;
    }

    .ibs-toolbar {
        display: grid;
        grid-template-columns: minmax(220px, 1.5fr) minmax(160px, 1fr) minmax(180px, 1fr) auto;
        gap: .65rem;
        align-items: end;
        margin-bottom: .8rem;
    }

    .ibs-toolbar .form-label {
        margin-bottom: .25rem;
        color: #64748b;
        font-size: .7rem;
        font-weight: 800;
        text-transform: uppercase;
    }

    .ibs-toolbar-actions {
        display: flex;
        gap: .4rem;
    }

    .ibs-toolbar-actions .btn {
        white-space: nowrap;
    }

    #dataTableIBS thead th {
        white-space: nowrap;
        background: #f3f7fc;
        color: #29476f;
        border-bottom: 2px solid #cbd9e8;
        font-size: .72rem;
        letter-spacing: .03em;
        text-transform: uppercase;
    }

    #dataTableIBS tbody td {
        vertical-align: middle;
        border-color: #e8eef5;
    }

    #dataTableIBS tbody tr:hover td {
        background: #f8fbff;
    }

    .ibs-time {
        display: inline-block;
        min-width: 4.5rem;
        padding: .3rem .5rem;
        border-radius: .35rem;
        font-size: .75rem;
        font-weight: 700;
        text-align: center;
    }

    .ibs-time-start { background: #e8f1ff; color: #20559b; }
    .ibs-time-end { background: #e8f7ee; color: #176b3a; }
    .ibs-time-pending { background: #fff3cd; color: #8a5a00; }

    .ibs-diagnosis {
        min-width: 150px;
        max-width: 230px;
        text-align: left;
    }

    .ibs-diagnosis summary {
        cursor: pointer;
        color: #20559b;
        font-size: .75rem;
        font-weight: 700;
    }

    .ibs-diagnosis-content {
        padding-top: .35rem;
        color: #475569;
        font-size: .75rem;
        line-height: 1.45;
        white-space: normal;
    }

    .ibs-table-shell .dataTables_scroll {
        border: 0;
    }

    .ibs-table-shell .dataTables_scrollHead,
    .ibs-table-shell .dataTables_scrollBody {
        border: 0 !important;
    }

    .ibs-table-shell .dataTables_scrollBody {
        max-height: 52vh !important;
        border-top: 1px solid #dbe3ef !important;
    }

    .ibs-note-panel {
        margin-top: 1.25rem;
        padding: 1rem 1.1rem;
        border: 1px solid #dbe3ef;
        border-left: 4px solid #f59e0b;
        border-radius: .65rem;
        background: #fffaf0;
    }

    .ibs-note-heading {
        display: flex;
        align-items: center;
        gap: .5rem;
        margin-bottom: .45rem;
        color: #8a5a00;
        font-size: .78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .03em;
    }

    .ibs-note-content {
        color: #4b5563;
        font-size: .9rem;
        line-height: 1.6;
        white-space: pre-line;
    }

    .ibs-note-empty {
        color: #9a7b36;
        font-size: .85rem;
        font-style: italic;
    }

    @media (max-width: 768px) {
        .ibs-toolbar {
            grid-template-columns: 1fr 1fr;
        }

        .ibs-toolbar-actions {
            grid-column: 1 / -1;
        }
    }
</style>

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
            <option value="{{ $namaRuangan }}">{{ $namaRuangan }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="ibsDoctorFilter" class="form-label">Dokter operasi</label>
        <input id="ibsDoctorFilter" type="search" class="form-control" placeholder="Nama dokter...">
    </div>
    <div class="ibs-toolbar-actions">
        <button type="button" class="btn btn-outline-secondary" id="ibsResetFilter" title="Reset filter">
            <i class="fas fa-undo" aria-hidden="true"></i>
        </button>
        <button type="button" class="btn btn-outline-success" id="ibsExportCsv" title="Export CSV">
            <i class="fas fa-file-csv" aria-hidden="true"></i>
        </button>
        <button type="button" class="btn btn-outline-primary" id="ibsPrint" title="Cetak tabel">
            <i class="fas fa-print" aria-hidden="true"></i>
        </button>
    </div>
</div>

<div class="ibs-table-shell">
    @if(!$getIDibs || $laporanIbsDetail->isEmpty())
    <div class="pu-empty-state">
        <i class="fas fa-folder-open" aria-hidden="true"></i>
        <h5 class="mb-1">Belum ada laporan IBS</h5>
        <p class="mb-0">Belum ada data operasi untuk tanggal ini.</p>
    </div>
    @else
    <table class="table table-bordered table-hover" id="dataTableIBS" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama / RM</th>
                <th>Dokter Operasi</th>
                <th>Dokter Anestesi</th>
                <th>Pendamping</th>
                <th>Ruangan Asal</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Diagnosa Pre</th>
                <th>Diagnosa Post</th>
            </tr>
        </thead>
        <tbody>
            @if($getIDibs)
            @foreach ($laporanIbsDetail as $index => $data)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $data->nama }}</strong><br><small class="text-muted">{{ $data->rm }}</small></td>
                <td>
                    @php $arrdokteroperasi = explode(',', $data->id_dokter_operasi); @endphp
                    @foreach(\App\Models\Dokterirj::whereIn('id', $arrdokteroperasi)->get() as $dok)
                    <span class="d-block">{{ $dok->nama }}</span>
                    @endforeach
                </td>
                <td>{{ $data->dokterAnestesi->nama ?? '' }}</td>
                <td>{{ $data->pendamping }}</td>
                <td>{{ $data->ruangan->nama_ruangan ?? '' }}</td>
                <td><span class="ibs-time ibs-time-start">{{ $data->jam_mulai ?: '-' }}</span></td>
                <td>
                    @if($data->jam_selesai)
                    <span class="ibs-time ibs-time-end">{{ $data->jam_selesai }}</span>
                    @else
                    <span class="ibs-time ibs-time-pending">Belum selesai</span>
                    @endif
                </td>
                <td>
                    <details class="ibs-diagnosis">
                        <summary>{{ filled($data->diagnosa_pre) ? 'Lihat diagnosis' : '-' }}</summary>
                        @if(filled($data->diagnosa_pre))
                        <div class="ibs-diagnosis-content">{{ $data->diagnosa_pre }}</div>
                        @endif
                    </details>
                </td>
                <td>
                    <details class="ibs-diagnosis">
                        <summary>{{ filled($data->diagnosa_post) ? 'Lihat diagnosis' : '-' }}</summary>
                        @if(filled($data->diagnosa_post))
                        <div class="ibs-diagnosis-content">{{ $data->diagnosa_post }}</div>
                        @endif
                    </details>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    @endif
</div>

<div class="ibs-note-panel">
    <div class="ibs-note-heading">
        <i class="fas fa-sticky-note" aria-hidden="true"></i>
        <span>Catatan IBS untuk Dinas Berikutnya</span>
    </div>
    @if(filled(trim((string) $catatanIbs)))
        <div class="ibs-note-content">{{ $catatanIbs }}</div>
    @else
        <div class="ibs-note-empty">Belum ada catatan untuk dinas berikutnya.</div>
    @endif
</div>