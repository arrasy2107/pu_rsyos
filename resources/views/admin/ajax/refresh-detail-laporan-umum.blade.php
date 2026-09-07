<!-- Ruangan -->

<div class="row ">
    <div class="col-lg-12">
        <h6>Tanggal : {{ date('d F Y', strtotime(\App\Models\Laporan::where('id',$idlaporan)->pluck('created_at')->first() ))  }}</h6>
        <h6>Dinas : {{ strtoupper(\App\Models\Dinas::where('id',\App\Models\Laporan::where('id',$idlaporan)->pluck('id_dinas')->first())->pluck('dinas')->first())  }} </h6>
        <h6 style="color:red"><b>Total Pasien (Ruangan) : {{ \App\Models\Laporanumum::where('id_laporan',$idlaporan)->pluck('jumlah_total_pasien')->sum() }} orang</b></h6>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTableRuangan" width="100%" cellspacing="0">
                <thead>
                    <tr style="background-color:green;color:white">

                        <th style="background-color:green;color:white;box-shadow:5px 0 3px -2px #ccc;width:200px;position:fixed; position:absolute;z-index: 1; ">TOTAL</th>
                        <th style="padding-left:250px">{{ \App\Models\Laporanumum::where('id_laporan',$idlaporan)->pluck('jumlah_pasien_lama')->sum() }}</th>
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

                        <th style="white-space: nowrap;word-wrap: break-word;box-shadow:5px 0 3px -2px #ccc;width:200px;position:fixed; position:absolute;z-index: 1;background-color:white; color:#858796">Ruangan</th>
                        <th style="white-space: nowrap;word-wrap: break-word;padding-left:250px"> Lama</th>
                        <th style="white-space: nowrap;word-wrap: break-word;"> Baru</th>
                        <th style="white-space: nowrap;word-wrap: break-word;"> Pindah</th>
                        <th style="white-space: nowrap;word-wrap: break-word;"> Pindahan</th>
                        <th style="white-space: nowrap;word-wrap: break-word;">Meninggal</th>
                        <th style="white-space: nowrap;word-wrap: break-word;">Pulang</th>

                        <th style="white-space: nowrap;word-wrap: break-word;"><b>Total Pasien</b></th>

                        <th style="white-space: nowrap;word-wrap: break-word;">Catatan Pasien Istimewa</th>
                        <th style="white-space: nowrap;word-wrap: break-word;">Catatan Pasien Baru</th>
                        <th style="white-space: nowrap;word-wrap: break-word;">Covid</th>
                        <th style="white-space: nowrap;word-wrap: break-word;">Suspect Covid</th>
                        <th style="white-space: nowrap;word-wrap: break-word;">Restrain</th>
                        <th style="white-space: nowrap;word-wrap: break-word;">Perilaku Kekerasan</th>
                        <th style="white-space: nowrap;word-wrap: break-word;">Keracunan</th>
                        <th style="white-space: nowrap;word-wrap: break-word;">Keterbatasan Bahasa</th>
                        <th style="white-space: nowrap;word-wrap: break-word;">Difabel</th>
                        <th style="white-space: nowrap;word-wrap: break-word;">Permasalahan Umum</th>
                    </tr>
                </thead>

                <?php
                $no = 1;
                ?>
                <tbody>
                    @foreach(\App\Models\Laporanumum::where('id_laporan',$idlaporan)->get() as $data)
                    <tr>

                        <td style="white-space: nowrap;word-wrap: break-word;box-shadow:5px 0 3px -2px #ccc;width:200px;position:fixed;position:absolute;z-index: 1;background:white;">{{ \App\Models\Ruangan::where('id',$data->id_ruangan)->pluck('nama_ruangan')->first()  }}</td>
                        <td style="padding-left:250px"> {{$data->jumlah_pasien_lama}}</td>
                        <td> {{$data->jumlah_pasien_baru}}</td>

                        <td> {{$data->jumlah_pasien_pindah}}</td>
                        <td> {{$data->jumlah_pasien_pindahan}}</td>
                        <td>{{$data->jumlah_pasien_meninggal}}</td>
                        <td>{{$data->jumlah_pasien_pulang}}</td>
                        <td><b>{{$data->jumlah_total_pasien}}</b></td>
                        @if(\App\Models\Catatanpasien::where('id_laporan_umum',$data->id)->where('id_ruangan',$data->id_ruangan)->where('id_jenis_pasien',1)->first())
                        <td><a href="#" data-id="{{ $data->id }}" data-ruangan="{{$data->id_ruangan}}" class="btn-istimewa" data-bs-toggle="modal" data-bs-target="#istimewa">Lihat</a></td>
                        @else
                        <td>-</td>
                        @endif

                        @if(\App\Models\Catatanpasien::where('id_laporan_umum',$data->id)->where('id_ruangan',$data->id_ruangan)->where('id_jenis_pasien',2)->first())
                        <td><a href="#" data-id="{{ $data->id }}" data-ruangan="{{$data->id_ruangan}}" class="btn-baru" data-bs-toggle="modal" data-bs-target="#baru">Lihat</a></td>
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
                        <td><a href="#" data-id="{{ $data->id }}" data-ruangan="{{$data->id_ruangan}}" class="btn-permasalahan" data-bs-toggle="modal" data-bs-target="#permasalahan">Lihat</a></td>
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

<script>
    // 
    $("#dataTableRuangan").on('click', '.btn-istimewa', function() {
        idlaporan = $(this).data('id');
        ruangan = $(this).data('ruangan');
        $(".tableistimewa").html('<h4>Mohon Tunggu...</h4>');
        $.ajax({
            type: "get",
            url: 'refresh-istimewa/' + idlaporan + '/' + ruangan,
            data: {
                "_token": "{{ csrf_token() }}",
                idlaporan: idlaporan,
                idruangan: ruangan
            },
            success: function(data) {
                //console.log(data);
                $(".tableistimewa").html(data);
            }
        });

    });

    $("#dataTableRuangan").on('click', '.btn-baru', function() {
        idlaporan = $(this).data('id');
        ruangan = $(this).data('ruangan');
        $(".tablebaru").html('<h4>Mohon Tunggu...</h4>');
        $.ajax({
            type: "get",
            url: 'refresh-baru/' + idlaporan + '/' + ruangan,
            data: {
                "_token": "{{ csrf_token() }}",
                idlaporan: idlaporan,
                idruangan: ruangan
            },
            success: function(data) {
                //console.log(data);
                $(".tablebaru").html(data);
            }
        });

    });

    $("#dataTableRuangan").on('click', '.btn-permasalahan', function() {
        idlaporan = $(this).data('id');
        ruangan = $(this).data('ruangan');
        $(".tablemasalah").html('<h4>Mohon Tunggu...</h4>');
        $.ajax({
            type: "get",
            url: 'refresh-permasalahan/' + idlaporan + '/' + ruangan,
            data: {
                "_token": "{{ csrf_token() }}",
                idlaporan: idlaporan,
                idruangan: ruangan
            },
            success: function(data) {
                //console.log(data);
                $(".tablemasalah").html(data);
            }
        });

    });
</script>