<!-- IGD -->

<div class="row ">
    <div class="col-lg-12">
    <h6 >Tanggal : {{ date('d F Y', strtotime(\App\Models\Laporan::where('id',$idlaporan)->pluck('created_at')->first() ))  }}</h6>
    <h6 >Dinas : {{  strtoupper(\App\Models\Dinas::where('id',\App\Models\Laporan::where('id',$idlaporan)->pluck('id_dinas')->first())->pluck('dinas')->first())  }} </h6>

    <h6 style="color:red"><b>Total Pasien (IGD) : {{ \App\Models\Laporanigd::where('id_laporan',$idlaporan)->pluck('jumlah_pasien')->first() }} orang</b></h6>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
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
                </thead>

                <?php
                $no = 1;
                ?>
                <tbody>
                    @foreach(\App\Models\Laporanigd::where('id_laporan',$idlaporan)->get() as $data)
                    <tr>
                        <td>{{ $data->jumlah_pasien_emergency }}</td>
                        <td>{{ $data->jumlah_pasien_non_emergency }}</td>
                        <td>{{ $data->jumlah_pasien_rawat }}</td>
                        <td>{{ $data->jumlah_pasien_pulang }}</td>
                        
                        <td>{{ $data->jumlah_pasien_tidak_bisa_rawat }}</td>
                        <td>{{ $data->jumlah_pasien_doa }}</td>
                        <td>{{ $data->jumlah_pasien_sisrute }}</td>
                        <td>{{ $data->jumlah_pasien_sisrute_diterima }}</td>
                        <td>{{ $data->jumlah_pasien_sisrute_ditolak }}</td>

                    </tr>
                    <?php
                    $no++;
                    ?>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

</div>
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="form-group shadow-textarea">
            <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Alasan pasien rujuk dan tolak rawat</label>
            <textarea class="form-control  z-depth-1" name="igd_alasan" rows="3" readonly>{{ \App\Models\Laporanigd::where('id_laporan',$idlaporan)->pluck('alasan_tidak_bisa_rawat')->first() }}</textarea>
        </div>
        <div class="form-group shadow-textarea">
            <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Permasalahan</label>
            <textarea class="form-control" name="igd_permasalahan" rows="3" readonly>{{ \App\Models\Laporanigd::where('id_laporan',$idlaporan)->pluck('permasalahan')->first() }}</textarea>
        </div>
        <div class="form-group shadow-textarea">
            <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Lain - lain</label>
            <textarea class="form-control" name="igd_lainlain" rows="3" readonly>{{ \App\Models\Laporanigd::where('id_laporan',$idlaporan)->pluck('lain_lain')->first() }}</textarea>
        </div>
        <div class="form-group">
            <label style="color:#000;font-weight:600">Dokter Jaga: </label>
            <select class="form-control" name="igd_dokterjaga" disabled>
                <option value="" selected disabled hidden>Pilih Dokter</option>
                @foreach(\App\Models\Dokter::where('status',1)->get() as $dk)
                @if(\App\Models\Laporanigd::where('id_laporan',$idlaporan)->pluck('id_dokter')->first() == $dk->id)
                <option value="{{ $dk->id }}" selected>{{ $dk->nama_dokter }}</option>
                @else
                <option value="{{ $dk->id }}">{{ $dk->nama_dokter }}</option>
                @endif
                @endforeach
            </select>
        </div>

    </div>
</div>
