<div class="row mb-4">
    <div class="col-lg-6">
        <div class="mb-0">
            <label>Lihat Laporan per Ruangan</label>
            <select class="form-select select2" id="inap_ruangan">
                <option value="" selected disabled hidden>Pilih Ruangan</option>
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

<div class="row mt-4">
    <div class="col-md-12">
        <h5 class="mb-3 fw-bold text-primary">Rekapitulasi Laporan Umum Semua Ruangan</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTableRuangan" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Ruangan</th>
                        <th>Lama</th>
                        <th>Baru</th>
                        <th>Pindah</th>
                        <th>Pindahan</th>
                        <th>Meninggal</th>
                        <th>Pulang</th>
                        <th class="bg-primary text-white">Total</th>
                        <th>Pasien Istimewa</th>
                        <th>Pasien Baru</th>
                        <th>Covid</th>
                        <th>Suspect Covid</th>
                        <th>Restrain</th>
                        <th>Perilaku Kekerasan</th>
                        <th>Keracunan</th>
                        <th>Keterbatasan Bahasa</th>
                        <th>Difabel</th>
                        <th>Permasalahan Umum</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporanUmum as $data)
                    <tr>
                        <td>{{ $data->ruangan->nama_ruangan ?? '' }}</td>
                        <td>{{$data->jumlah_pasien_lama}}</td>
                        <td>{{$data->jumlah_pasien_baru}}</td>
                        <td>{{$data->jumlah_pasien_pindah}}</td>
                        <td>{{$data->jumlah_pasien_pindahan}}</td>
                        <td>{{$data->jumlah_pasien_meninggal}}</td>
                        <td>{{$data->jumlah_pasien_pulang}}</td>
                        <td class="fw-bold bg-light">{{$data->jumlah_total_pasien}}</td>

                        <td>
                            @if(\App\Models\Catatanpasien::where('id_laporan_umum',$data->id)->where('id_ruangan',$data->id_ruangan)->where('id_jenis_pasien',1)->first())
                            <button data-id="{{ $data->id }}" data-ruangan="{{$data->id_ruangan}}" class="btn btn-sm btn-primary btn-istimewa text-white" data-bs-toggle="modal" data-bs-target="#istimewa">Lihat</button>
                            @else - @endif
                        </td>
                        <td>
                            @if(\App\Models\Catatanpasien::where('id_laporan_umum',$data->id)->where('id_ruangan',$data->id_ruangan)->where('id_jenis_pasien',2)->first())
                            <button data-id="{{ $data->id }}" data-ruangan="{{$data->id_ruangan}}" class="btn btn-sm btn-primary btn-baru text-white" data-bs-toggle="modal" data-bs-target="#baru">Lihat</button>
                            @else - @endif
                        </td>

                        <td>{{$data->jumlah_pasien_covid}}</td>
                        <td>{{$data->jumlah_pasien_suspek_covid}}</td>
                        <td>{{$data->jumlah_pasien_restrain}}</td>
                        <td>{{$data->jumlah_pasien_perilaku_kekerasan}}</td>
                        <td>{{$data->jumlah_pasien_keracunan}}</td>
                        <td>{{$data->jumlah_pasien_keterbatasan_bahasa}}</td>
                        <td>{{$data->jumlah_pasien_difabel}}</td>

                        <td>
                            @if($data->permasalahan_umum)
                            <button data-id="{{ $data->id }}" data-ruangan="{{$data->id_ruangan}}" class="btn btn-sm btn-warning btn-permasalahan" data-bs-toggle="modal" data-bs-target="#permasalahan">Lihat</button>
                            @else - @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-light fw-bold">
                        <td>TOTAL SELURUH RUANGAN</td>
                        <td>{{ $laporanUmum->sum('jumlah_pasien_lama') }}</td>
                        <td>{{ $laporanUmum->sum('jumlah_pasien_baru') }}</td>
                        <td>{{ $laporanUmum->sum('jumlah_pasien_pindah') }}</td>
                        <td>{{ $laporanUmum->sum('jumlah_pasien_pindahan') }}</td>
                        <td>{{ $laporanUmum->sum('jumlah_pasien_meninggal') }}</td>
                        <td>{{ $laporanUmum->sum('jumlah_pasien_pulang') }}</td>
                        <td class="text-primary">{{ $totalUmum }}</td>
                        <td colspan="2"></td>
                        <td>{{ $laporanUmum->sum('jumlah_pasien_covid') }}</td>
                        <td>{{ $laporanUmum->sum('jumlah_pasien_suspek_covid') }}</td>
                        <td>{{ $laporanUmum->sum('jumlah_pasien_restrain') }}</td>
                        <td>{{ $laporanUmum->sum('jumlah_pasien_perilaku_kekerasan') }}</td>
                        <td>{{ $laporanUmum->sum('jumlah_pasien_keracunan') }}</td>
                        <td>{{ $laporanUmum->sum('jumlah_pasien_keterbatasan_bahasa') }}</td>
                        <td>{{ $laporanUmum->sum('jumlah_pasien_difabel') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>