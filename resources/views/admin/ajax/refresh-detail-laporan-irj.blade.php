


<div class="row ">
    <div class="col-lg-12 tableketerangan">
    <h6 >Tanggal : {{ date('d F Y', strtotime(\App\Models\Laporan::where('id',$idlaporan)->pluck('created_at')->first() ))  }}</h6>
    <h6 >Dinas : {{  strtoupper(\App\Models\Dinas::where('id',\App\Models\Laporan::where('id',$idlaporan)->pluck('id_dinas')->first())->pluck('dinas')->first())  }} </h6>
    <h6 style="color:red"><b>Total Pasien (IRJ) : {{ \App\Models\Laporanirjdetail::where('status',1)->where('id_laporan_irj',\App\Models\Laporanirj::where('id_laporan',$idlaporan)->pluck('id')->first())->pluck('pasien_total')->sum() }} orang</b></h6>

        <label class="mt-2" style="color:#000;font-weight:600">Jumlah pasien menurut Dokter </label>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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

                <?php
                $no = 1;
                ?>
                <tbody>
                    @foreach(\App\Models\Laporanirjdetail::where('status',1)->where('id_laporan_irj',\App\Models\Laporanirj::where('id_laporan',$idlaporan)->pluck('id')->first())->get() as $data)
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{{ \App\Models\sdmk_jenis::where('id',\App\Models\Dokterirj::where('id',$data->id_dokter_irj)->pluck('id_sdmk_jenis')->first())->pluck('jenis')->first() }}</td>
                        <td>{{ \App\Models\Dokterirj::where('id',$data->id_dokter_irj)->pluck('nama')->first() }}</td>
                        <td>{{ $data->pasien_lama }}</td>
                        <td>{{ $data->pasien_baru }}</td>
                        <td>{{ $data->pasien_total }}</td>


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
            <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Masalah</label>
            <textarea class="form-control  z-depth-1" name="irj_masalah" rows="3" readonly value="{{ \App\Models\Laporanirj::where('id_laporan',$idlaporan)->pluck('masalah')->first() }}"></textarea>
        </div>
        <div class="form-group shadow-textarea">
            <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Langkah atasi masalah</label>
            <textarea class="form-control" name="irj_langkah" rows="3" readonly value="{{ \App\Models\Laporanirj::where('id_laporan',$idlaporan)->pluck('langkah_atasi_masalah')->first() }}"></textarea>
        </div>


    </div>
</div>

