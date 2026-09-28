<div>
    @if(!$laporan)
    <div class="text-center py-5 text-muted">
        <i class="fas fa-circle-notch fa-spin fa-2x mb-3"></i>
        <p>Memuat detail laporan...</p>
    </div>
    @else

    <div class="row">
        <div class="col-lg-12">
            <h6>Tanggal : {{ $laporan->created_at->isoFormat('D MMMM Y') }}</h6>
            <h6>Dinas : {{ strtoupper(optional($laporan->dinas)->dinas ?? '-') }}</h6>
            @if($modalType === 'igd')
            <h6 style="color:red"><b>Total Pasien (IGD) : {{ $rows->sum('jumlah_pasien') }} orang</b></h6>
            @elseif($modalType === 'umum')
            <h6 style="color:red"><b>Total Pasien (Umum) : {{ $rows->sum('jumlah_total_pasien') }} orang</b></h6>
            @elseif($modalType === 'irj')
            <h6 style="color:red"><b>Total Pasien (IRJ) : {{ $rows->sum('pasien_total') }} orang</b></h6>
            @elseif($modalType === 'ibs')
            <h6 style="color:red"><b>Total Pasien (IBS) : {{ $rows->count() }} orang</b></h6>
            @endif
        </div>
    </div>

    <style>
        .table-laporan-detail th {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #f8f9fa;
            box-shadow: 0 1px 0 #dee2e6;
        }
        .table-laporan-detail th.sticky-col {
            position: sticky;
            left: 0;
            z-index: 11;
            min-width: 150px;
            white-space: nowrap;
            background-color: #f8f9fa;
            box-shadow: 1px 1px 0 #dee2e6;
        }
        .table-laporan-detail td.sticky-col {
            position: sticky;
            left: 0;
            z-index: 9;
            min-width: 150px;
            white-space: nowrap;
            background-color: #fff;
            box-shadow: 1px 0 0 #dee2e6;
        }
    </style>

    <div class="row mt-3">
        <div class="col-12 table-responsive" style="max-height: 60vh; overflow-y: auto;">
            <table class="table table-bordered mb-0 table-laporan-detail" width="100%" cellspacing="0">
                <thead>
                    @if($modalType === 'igd')
                    <tr>
                        <th>Pasien Emergency</th>
                        <th>Pasien Non Emergency</th>
                        <th>Pasien Dirawat</th>
                        <th>Pasien Pulang</th>
                        <th>Pasien Rujuk dan Tolak Rawat</th>
                        <th>Pasien DOA dan meninggal</th>
                        <th>Rujukan SISRUTE</th>
                        <th>SISRUTE diterima</th>
                        <th>SISRUTE ditolak</th>
                    </tr>
                    @elseif($modalType === 'umum')
                    <tr>
                        <th class="sticky-col">Ruangan</th>
                        <th>Lama</th>
                        <th>Baru</th>
                        <th>Pindah</th>
                        <th>Pindahan</th>
                        <th>Meninggal</th>
                        <th>Pulang</th>
                        <th>Total Pasien</th>
                        <th>Istimewa</th>
                        <th>Baru</th>
                        <th>Covid</th>
                        <th>Suspek Covid</th>
                        <th>Restrain</th>
                        <th>Kekerasan</th>
                        <th>Keracunan</th>
                        <th>Keterbatasan Bahasa</th>
                        <th>Difabel</th>
                        <th>Permasalahan Umum</th>
                    </tr>
                    @elseif($modalType === 'irj')
                    <tr>
                        <th>No</th>
                        <th>SDMK Jenis</th>
                        <th>Nama Dokter</th>
                        <th>Pasien Lama</th>
                        <th>Pasien Baru</th>
                        <th>Total</th>
                    </tr>
                    @elseif($modalType === 'ibs')
                    <tr>
                        <th>No</th>
                        <th class="sticky-col">Nama (RM)</th>
                        <th>Dokter Operasi</th>
                        <th>Dokter Anestesi</th>
                        <th>Pendamping</th>
                        <th>Ruangan Asal</th>
                        <th>Jam mulai</th>
                        <th>Jam selesai</th>
                        <th>Diagnosa Pre</th>
                        <th>Diagnosa Post</th>
                    </tr>
                    @endif
                </thead>
                <tbody>
                    @forelse($rows as $idx => $item)
                    @if($modalType === 'igd')
                    <tr>
                        <td>{{ $item->jumlah_pasien_emergency }}</td>
                        <td>{{ $item->jumlah_pasien_non_emergency }}</td>
                        <td>{{ $item->jumlah_pasien_rawat }}</td>
                        <td>{{ $item->jumlah_pasien_pulang }}</td>
                        <td>{{ $item->jumlah_pasien_tidak_bisa_rawat }}</td>
                        <td>{{ $item->jumlah_pasien_doa }}</td>
                        <td>{{ $item->jumlah_pasien_sisrute }}</td>
                        <td>{{ $item->jumlah_pasien_sisrute_diterima }}</td>
                        <td>{{ $item->jumlah_pasien_sisrute_ditolak }}</td>
                    </tr>
                    @elseif($modalType === 'umum')
                    <tr>
                        <td class="sticky-col">{{ optional($item->ruangan)->nama_ruangan ?? '-' }}</td>
                        <td>{{ $item->jumlah_pasien_lama }}</td>
                        <td>{{ $item->jumlah_pasien_baru }}</td>
                        <td>{{ $item->jumlah_pasien_pindah }}</td>
                        <td>{{ $item->jumlah_pasien_pindahan }}</td>
                        <td>{{ $item->jumlah_pasien_meninggal }}</td>
                        <td>{{ $item->jumlah_pasien_pulang }}</td>
                        <td>{{ $item->jumlah_total_pasien }}</td>
                        <td>{{ \App\Models\Catatanpasien::where('id_laporan_umum', $item->id)->where('id_ruangan', $item->id_ruangan)->where('id_jenis_pasien',1)->exists() ? 'Ya' : '-' }}</td>
                        <td>{{ \App\Models\Catatanpasien::where('id_laporan_umum', $item->id)->where('id_ruangan', $item->id_ruangan)->where('id_jenis_pasien',2)->exists() ? 'Ya' : '-' }}</td>
                        <td>{{ $item->jumlah_pasien_covid }}</td>
                        <td>{{ $item->jumlah_pasien_suspek_covid }}</td>
                        <td>{{ $item->jumlah_pasien_restrain }}</td>
                        <td>{{ $item->jumlah_pasien_perilaku_kekerasan }}</td>
                        <td>{{ $item->jumlah_pasien_keracunan }}</td>
                        <td>{{ $item->jumlah_pasien_keterbatasan_bahasa }}</td>
                        <td>{{ $item->jumlah_pasien_difabel }}</td>
                        <td>{{ $item->permasalahan_umum ? 'Ya' : '-' }}</td>
                    </tr>
                    @elseif($modalType === 'irj')
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td>{{ optional(optional($item->dokter)->jenisSdmk)->jenis ?? '-' }}</td>
                        <td>{{ optional($item->dokter)->nama ?? '-' }}</td>
                        <td>{{ $item->pasien_lama }}</td>
                        <td>{{ $item->pasien_baru }}</td>
                        <td>{{ $item->pasien_total }}</td>
                    </tr>
                    @elseif($modalType === 'ibs')
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td class="sticky-col">{{ $item->nama }}<br><small>({{ $item->rm }})</small></td>
                        <td>
                            @forelse($item->dokter_operasi_names ?? [] as $namaDokter)
                                <div>{{ $namaDokter }}</div>
                            @empty
                                -
                            @endforelse
                        </td>
                        <td>{{ optional($item->dokterAnestesi)->nama ?? '-' }}</td>
                        <td>{{ $item->pendamping }}</td>
                        <td>{{ optional($item->ruangan)->nama_ruangan ?? '-' }}</td>
                        <td>{{ $item->jam_mulai }}</td>
                        <td>{{ $item->jam_selesai }}</td>
                        <td>{{ $item->diagnosa_pre }}</td>
                        <td>{{ $item->diagnosa_post }}</td>
                    </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="{{ $modalType === 'umum' ? 18 : 10 }}" class="text-center text-muted">Tidak ada data untuk laporan ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($modalType === 'igd')
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="form-group shadow-textarea mb-3">
                <label class="fw-bold">Alasan pasien rujuk dan tolak rawat</label>
                <textarea class="form-control" rows="3" readonly>{{ $extra['alasan'] ?? '' }}</textarea>
            </div>
            <div class="form-group shadow-textarea mb-3">
                <label class="fw-bold">Permasalahan</label>
                <textarea class="form-control" rows="3" readonly>{{ $extra['permasalahan'] ?? '' }}</textarea>
            </div>
            <div class="form-group shadow-textarea">
                <label class="fw-bold">Lain - lain</label>
                <textarea class="form-control" rows="3" readonly>{{ $extra['lain_lain'] ?? '' }}</textarea>
            </div>
        </div>
    </div>
    @elseif($modalType === 'irj')
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="form-group shadow-textarea">
                <label class="fw-bold">Masalah</label>
                <textarea class="form-control" rows="3" readonly>{{ $extra['masalah'] ?? '' }}</textarea>
            </div>
            <div class="form-group shadow-textarea mt-3">
                <label class="fw-bold">Langkah atasi masalah</label>
                <textarea class="form-control" rows="3" readonly>{{ $extra['langkah'] ?? '' }}</textarea>
            </div>
        </div>
    </div>
    @elseif($modalType === 'ibs')
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="form-group shadow-textarea">
                <label class="fw-bold">Catatan IBS untuk Dinas Berikutnya</label>
                <textarea class="form-control" rows="3" readonly>{{ $extra['catatan'] ?? '' }}</textarea>
            </div>
        </div>
    </div>
    @endif
    @endif
</div>