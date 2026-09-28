<style>
    .irj-table-shell {
        overflow: hidden;
        border: 1px solid #dbe3ef;
        border-radius: .75rem;
        background: #fff;
    }

    #dataTableIRJ {
        min-width: 760px;
        margin-bottom: 0 !important;
    }

    #dataTableIRJ thead th {
        white-space: nowrap;
        background: #f3f7fc;
        color: #29476f;
        border-bottom: 2px solid #cbd9e8;
        font-size: .72rem;
        letter-spacing: .03em;
        text-transform: uppercase;
    }

    #dataTableIRJ tbody td {
        vertical-align: middle;
        border-color: #e8eef5;
    }

    #dataTableIRJ tbody tr:hover td {
        background: #f8fbff;
    }

    #dataTableIRJ .irj-total {
        background: #eef5ff;
        color: #16427c;
        font-size: 1rem;
        font-weight: 800;
    }

    .irj-table-shell .dataTables_scrollHead,
    .irj-table-shell .dataTables_scrollBody {
        border: 0 !important;
    }

    .irj-table-shell .dataTables_scrollBody {
        max-height: 48vh !important;
        border-top: 1px solid #dbe3ef !important;
    }

    .irj-toolbar {
        display: grid;
        grid-template-columns: minmax(220px, 1fr) minmax(180px, 1fr) auto;
        gap: .65rem;
        align-items: end;
        margin-bottom: .8rem;
    }

    .irj-toolbar .form-label {
        margin-bottom: .25rem;
        color: #64748b;
        font-size: .7rem;
        font-weight: 800;
        text-transform: uppercase;
    }

    .irj-toolbar-actions {
        display: flex;
        gap: .4rem;
    }

    .irj-toolbar-actions .btn { white-space: nowrap; }

    .irj-info-panel {
        height: 100%;
        padding: 1rem 1.1rem;
        border: 1px solid #dbe3ef;
        border-left: 4px solid var(--irj-info-color);
        border-radius: .65rem;
        background: #fff;
    }

    .irj-info-heading {
        display: flex;
        align-items: center;
        gap: .5rem;
        margin-bottom: .5rem;
        color: var(--irj-info-color);
        font-size: .78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .03em;
    }

    .irj-info-content {
        color: #475569;
        font-size: .9rem;
        line-height: 1.6;
        white-space: pre-line;
    }

    .irj-info-empty {
        color: #94a3b8;
        font-size: .85rem;
        font-style: italic;
    }

    @media (max-width: 768px) {
        .irj-toolbar { grid-template-columns: 1fr 1fr; }
        .irj-toolbar-actions { grid-column: 1 / -1; }
    }
</style>

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
        <button type="button" class="btn btn-outline-secondary" id="irjResetFilter" title="Reset filter">
            <i class="fas fa-undo" aria-hidden="true"></i>
        </button>
        <button type="button" class="btn btn-outline-success" id="irjExportCsv" title="Export CSV">
            <i class="fas fa-file-csv" aria-hidden="true"></i>
        </button>
        <button type="button" class="btn btn-outline-primary" id="irjPrint" title="Cetak tabel">
            <i class="fas fa-print" aria-hidden="true"></i>
        </button>
    </div>
</div>

<div class="irj-table-shell">
    @if(!$getIDirj || $laporanIrjDetail->isEmpty())
    <div class="pu-empty-state">
        <i class="fas fa-folder-open" aria-hidden="true"></i>
        <h5 class="mb-1">Belum ada laporan IRJ</h5>
        <p class="mb-0">Belum ada data rawat jalan untuk tanggal ini.</p>
    </div>
    @else
    <table class="table table-bordered table-hover" id="dataTableIRJ" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th width="10%">No</th>
                <th>SDMK Jenis</th>
                <th>Nama Dokter</th>
                <th>Pasien Lama</th>
                <th>Pasien Baru</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @if($getIDirj)
            @foreach ($laporanIrjDetail as $index => $data)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $data->dokter->jenisSdmk->jenis ?? '' }}</td>
                <td class="fw-bold">{{ $data->dokter->nama ?? '' }}</td>
                <td>{{ $data->pasien_lama }}</td>
                <td>{{ $data->pasien_baru }}</td>
                <td class="irj-total">{{ $data->pasien_total }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    @endif
</div>

<div class="row g-3 mt-3">
    <div class="col-md-6">
        <div class="irj-info-panel" style="--irj-info-color: #dc2626;">
            <div class="irj-info-heading">
                <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>
                <span>Masalah</span>
            </div>
            @if(filled(trim((string) $masalahIrj)))
                <div class="irj-info-content">{{ $masalahIrj }}</div>
            @else
                <div class="irj-info-empty">Belum ada masalah yang dicatat.</div>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="irj-info-panel" style="--irj-info-color: #15803d;">
            <div class="irj-info-heading">
                <i class="fas fa-tasks" aria-hidden="true"></i>
                <span>Langkah Atasi Masalah</span>
            </div>
            @if(filled(trim((string) $langkahIrj)))
                <div class="irj-info-content">{{ $langkahIrj }}</div>
            @else
                <div class="irj-info-empty">Belum ada langkah penanganan yang dicatat.</div>
            @endif
        </div>
    </div>
</div>