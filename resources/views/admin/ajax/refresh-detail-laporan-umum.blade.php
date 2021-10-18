
<!-- Ruangan -->

<div class="row ">
    <div class="col-lg-12">
<h6 >Tanggal : {{ date('d F Y', strtotime(\App\Models\Laporan::where('id',$idlaporan)->pluck('created_at')->first() ))  }}</h6>
    <h6 >Dinas : {{  strtoupper(\App\Models\Dinas::where('id',\App\Models\Laporan::where('id',$idlaporan)->pluck('id_dinas')->first())->pluck('dinas')->first())  }} </h6>

<div class="table-responsive">
    <table class="table table-bordered" id="dataTableRuangan" width="100%" cellspacing="0">
        <thead>
            <tr style="background-color:green;color:white">

                <th>TOTAL</th>
                <th>{{ \App\Models\Laporanumum::where('id_laporan',$idlaporan)->pluck('jumlah_pasien_lama')->sum() }}</th>
                <th> {{ \App\Models\Laporanumum::where('id_laporan',$idlaporan)->pluck('jumlah_pasien_baru')->sum() }}</th>
                <th> {{ \App\Models\Laporanumum::where('id_laporan',$idlaporan)->pluck('jumlah_pasien_pindah')->sum() }}</th>
                <th> {{ \App\Models\Laporanumum::where('id_laporan',$idlaporan)->pluck('jumlah_pasien_pindahan')->sum() }}</th>
                <th>{{ \App\Models\Laporanumum::where('id_laporan',$idlaporan)->pluck('jumlah_pasien_meninggal')->sum() }}</th>
                <th>{{ \App\Models\Laporanumum::where('id_laporan',$idlaporan)->pluck('jumlah_pasien_pulang')->sum() }}</th>

                <th><b>{{ \App\Models\Laporanumum::where('id_laporan',$idlaporan)->pluck('jumlah_total_pasien')->sum() }}</b></th>

                <th>-</th>
                <th>-</th>
                <th>{{ \App\Models\Laporanumum::where('id_laporan',$idlaporan)->pluck('jumlah_pasien_covid')->sum() }}</th>
                <th>{{ \App\Models\Laporanumum::where('id_laporan',$idlaporan)->pluck('jumlah_pasien_suspek_covid')->sum() }}</th>
                <th>{{ \App\Models\Laporanumum::where('id_laporan',$idlaporan)->pluck('jumlah_pasien_restrain')->sum() }}</th>
                <th>{{ \App\Models\Laporanumum::where('id_laporan',$idlaporan)->pluck('jumlah_pasien_perilaku_kekerasan')->sum() }}</th>
                <th>{{ \App\Models\Laporanumum::where('id_laporan',$idlaporan)->pluck('jumlah_pasien_keracunan')->sum() }}</th>
                <th>{{ \App\Models\Laporanumum::where('id_laporan',$idlaporan)->pluck('jumlah_pasien_keterbatasan_bahasa')->sum() }}</th>
                <th>{{ \App\Models\Laporanumum::where('id_laporan',$idlaporan)->pluck('jumlah_pasien_difabel')->sum() }}</th>
                <th>-</th>
            </tr>
            <tr>

                <th>Ruangan</th>
                <th> Lama</th>
                <th> Baru</th>
                <th> Pindah</th>
                <th> Pindahan</th>
                <th>Meninggal</th>
                <th>Pulang</th>

                <th><b>Total Pasien</b></th>

                <th>Catatan Pasien Istimewa</th>
                <th>Catatan Pasien Baru</th>
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

        <?php
        $no = 1;
        ?>
        <tbody>
            @foreach(\App\Models\Laporanumum::where('id_laporan',$idlaporan)->get() as $data)
            <tr>

                <td style="white-space: nowrap;word-wrap: break-word;">{{ \App\Models\Ruangan::where('id',$data->id_ruangan)->pluck('nama_ruangan')->first()  }}</td>
                <td> {{$data->jumlah_pasien_lama}}</td>
                <td> {{$data->jumlah_pasien_baru}}</td>
                
                <td> {{$data->jumlah_pasien_pindah}}</td>
                <td> {{$data->jumlah_pasien_pindahan}}</td>
                <td>{{$data->jumlah_pasien_meninggal}}</td>
                <td>{{$data->jumlah_pasien_pulang}}</td>
                <td><b>{{$data->jumlah_total_pasien}}</b></td>
                @if($data->catatan_pasien_istimewa)
                <td>{{$data->catatan_pasien_istimewa}}</td>
                @else
                <td>-</td>
                @endif
                @if($data->catatan_pasien_baru)
                <td>{{$data->catatan_pasien_baru}}</td>
                @else
                <td>-</td>
                @endif
                <td>{{$data->jumlah_pasien_covid}}</td>
                <td>{{$data->jumlah_pasien_suspek_covid}}</td>
                <td>{{$data->jumlah_pasien_restrain}}</td>
                <td>{{$data->jumlah_pasien_perilaku_kekerasan}}</td>
                <td>{{$data->jumlah_pasien_keracunan}}</td>
                <td>{{$data->jumlah_pasien_keterbatasan_bahasa}}</td>
                <td>{{$data->jumlah_pasien_difabel}}</td>
                @if($data->permasalahan_umum)
                <td>{{$data->permasalahan_umum}}</td>
                @else
                <td>-</td>
                @endif

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
