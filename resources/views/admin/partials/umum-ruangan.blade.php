<div class="row mb-4">
    <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="mb-0">
            <label for="inap_ruangan" class="form-label fw-bold">Lihat Laporan per Ruangan</label>
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

<hr>

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

    .ruangan-table-shell {
        border: 1px solid #dbe3ef;
        border-radius: .75rem;
        overflow: hidden;
        background: #fff;
    }
    .ruangan-table-shell .table-responsive {
        border: 0;
        border-radius: 0;
        max-height: 60vh;
    }
    #dataTableRuangan {
        min-width: 1080px;
        margin-bottom: 0;
        border: 0;
    }
    #dataTableRuangan th,
    #dataTableRuangan td {
        min-width: 72px;
        padding: .75rem .8rem;
        vertical-align: middle;
        text-align: center;
        border-color: #e8eef5;
    }
    #dataTableRuangan thead th {
        position: sticky;
        top: 0;
        z-index: 2;
        padding: .7rem .75rem;
        background: #f3f7fc;
        color: #29476f;
        border-bottom: 2px solid #cbd9e8;
        font-size: .7rem;
        letter-spacing: .05em;
        text-transform: uppercase;
        white-space: nowrap;
    }
    #dataTableRuangan tbody tr:hover td { background: #f8fbff; }
    #dataTableRuangan .ruangan-name {
        min-width: 180px;
        text-align: left;
        color: #1e3a5f;
        font-weight: 800;
    }
    #dataTableRuangan .ruangan-total {
        background: #eef5ff;
        color: #16427c;
        font-size: 1rem;
        font-weight: 800;
    }
    #dataTableRuangan tfoot td {
        background: #f8fbff;
        border-top: 2px solid #cbd9e8;
        font-weight: 700;
    }
    #dataTableRuangan tfoot .ruangan-name { background: #eef4fb; }
    #dataTableRuangan tfoot .ruangan-total { background: #dceaff; }
    #dataTableRuangan .ruangan-zero { color: #a0aec0; }
    #dataTableRuangan .ruangan-alert { color: #b45309; font-weight: 700; }
    #dataTableRuangan .ruangan-note-btn {
        min-width: 54px;
        padding: .25rem .5rem;
        font-size: .72rem;
    }
    #dataTableRuangan .ruangan-condition-summary {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: .25rem .6rem;
        min-width: 170px;
        text-align: left;
    }
    #dataTableRuangan .ruangan-condition-item {
        display: flex;
        justify-content: space-between;
        gap: .5rem;
        color: #64748b;
        font-size: .7rem;
    }
    #dataTableRuangan .ruangan-condition-item strong {
        color: #1e3a5f;
    }
    #dataTableRuangan .ruangan-condition-actions {
        display: flex;
        flex-wrap: wrap;
        gap: .25rem;
        margin-top: .45rem;
    }
    .ruangan-table-caption {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 1rem 1.1rem;
        border-bottom: 1px solid #dbe3ef;
        background: #f8fbff;
    }
    .ruangan-table-caption h5 { margin: 0; color: #173b72; }
    .ruangan-table-caption small { color: #64748b; }
    @media (max-width: 768px) {
        .ruangan-table-caption { align-items: flex-start; flex-direction: column; gap: .25rem; }
        #dataTableRuangan { min-width: 980px; }
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
        <div class="ruangan-table-shell">
            <div class="ruangan-table-caption">
                <h5 class="fw-bold">Rekapitulasi Laporan Umum Semua Ruangan</h5>
                <small><i class="fas fa-arrows-alt-h me-1"></i> Geser tabel untuk melihat detail</small>
            </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTableRuangan" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="ruangan-name">Ruangan</th>
                        <th>Lama</th>
                        <th>Baru</th>
                        <th>Pindah</th>
                        <th>Pindahan</th>
                        <th>Meninggal</th>
                        <th>Pulang</th>
                        <th class="ruangan-total">Total</th>
                        <th>Kondisi Khusus</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporanUmum as $data)
                    <tr>
                        <td class="ruangan-name fw-bold">{{ $data->ruangan->nama_ruangan ?? '-' }}</td>
                        @foreach(['jumlah_pasien_lama', 'jumlah_pasien_baru', 'jumlah_pasien_pindah', 'jumlah_pasien_pindahan', 'jumlah_pasien_meninggal', 'jumlah_pasien_pulang'] as $field)
                        <td class="{{ !$data->{$field} ? 'ruangan-zero' : '' }}">{{ $data->{$field} ?: '-' }}</td>
                        @endforeach
                        <td class="ruangan-total">{{ $data->jumlah_total_pasien ?: '-' }}</td>
                        <td>
                            <!-- <div class="ruangan-condition-summary">
                                <span class="ruangan-condition-item"><span>Covid</span><strong>{{ $data->jumlah_pasien_covid ?: '-' }}</strong></span>
                                <span class="ruangan-condition-item"><span>Suspect</span><strong>{{ $data->jumlah_pasien_suspek_covid ?: '-' }}</strong></span>
                                <span class="ruangan-condition-item"><span>Restrain</span><strong>{{ $data->jumlah_pasien_restrain ?: '-' }}</strong></span>
                                <span class="ruangan-condition-item"><span>Difabel</span><strong>{{ $data->jumlah_pasien_difabel ?: '-' }}</strong></span>
                                <span class="ruangan-condition-item"><span>Perilaku</span><strong>{{ $data->jumlah_pasien_perilaku_kekerasan ?: '-' }}</strong></span>
                                <span class="ruangan-condition-item"><span>Keracunan</span><strong>{{ $data->jumlah_pasien_keracunan ?: '-' }}</strong></span>
                                <span class="ruangan-condition-item"><span>Bahasa</span><strong>{{ $data->jumlah_pasien_keterbatasan_bahasa ?: '-' }}</strong></span>
                            </div> -->
                            <div class="ruangan-condition-actions">
                                @if(\App\Models\Catatanpasien::where('id_laporan_umum',$data->id)->where('id_ruangan',$data->id_ruangan)->where('id_jenis_pasien',1)->first())
                                <button data-id="{{ $data->id }}" data-ruangan="{{$data->id_ruangan}}" class="btn btn-sm btn-primary btn-istimewa text-white ruangan-note-btn" data-bs-toggle="modal" data-bs-target="#istimewa">Istimewa</button>
                                @endif
                                @if(\App\Models\Catatanpasien::where('id_laporan_umum',$data->id)->where('id_ruangan',$data->id_ruangan)->where('id_jenis_pasien',2)->first())
                                <button data-id="{{ $data->id }}" data-ruangan="{{$data->id_ruangan}}" class="btn btn-sm btn-primary btn-baru text-white ruangan-note-btn" data-bs-toggle="modal" data-bs-target="#baru">Pasien Baru</button>
                                @endif
                            </div>
                        </td>

                        <td>
                            @if($data->permasalahan_umum)
                            <button data-id="{{ $data->id }}" data-ruangan="{{$data->id_ruangan}}" class="btn btn-sm btn-warning btn-permasalahan ruangan-note-btn" data-bs-toggle="modal" data-bs-target="#permasalahan">Lihat</button>
                            @else
                            <span class="ruangan-zero">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-light fw-bold">
                        <td class="ruangan-name">TOTAL SELURUH RUANGAN</td>
                        @foreach(['jumlah_pasien_lama', 'jumlah_pasien_baru', 'jumlah_pasien_pindah', 'jumlah_pasien_pindahan', 'jumlah_pasien_meninggal', 'jumlah_pasien_pulang'] as $field)
                        <td>{{ $laporanUmum->sum($field) ?: '-' }}</td>
                        @endforeach
                        <td class="ruangan-total">{{ $totalUmum ?: '-' }}</td>
                        <td colspan="2">
                            <!-- <div class="ruangan-condition-summary">
                                <span class="ruangan-condition-item"><span>Covid</span><strong>{{ $laporanUmum->sum('jumlah_pasien_covid') ?: '-' }}</strong></span>
                                <span class="ruangan-condition-item"><span>Suspect</span><strong>{{ $laporanUmum->sum('jumlah_pasien_suspek_covid') ?: '-' }}</strong></span>
                                <span class="ruangan-condition-item"><span>Restrain</span><strong>{{ $laporanUmum->sum('jumlah_pasien_restrain') ?: '-' }}</strong></span>
                                <span class="ruangan-condition-item"><span>Difabel</span><strong>{{ $laporanUmum->sum('jumlah_pasien_difabel') ?: '-' }}</strong></span>
                                <span class="ruangan-condition-item"><span>Bahasa</span><strong>{{ $laporanUmum->sum('jumlah_pasien_keterbatasan_bahasa') ?: '-' }}</strong></span>
                            </div> -->
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        </div>
        @endif
    </div>
</div>