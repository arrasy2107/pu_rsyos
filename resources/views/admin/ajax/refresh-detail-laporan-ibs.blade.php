


<div class="row ">
    <div class="col-lg-12 tableketerangan">
    <h6 >Tanggal : {{ date('d F Y', strtotime(\App\Models\Laporan::where('id',$idlaporan)->pluck('created_at')->first() ))  }}</h6>
    <h6 >Dinas : {{  strtoupper(\App\Models\Dinas::where('id',\App\Models\Laporan::where('id',$idlaporan)->pluck('id_dinas')->first())->pluck('dinas')->first())  }} </h6>
    <h6 style="color:red"><b>Total Pasien (IBS) : {{ \App\Models\Laporanibsdetail::where('status',1)->where('id_laporan_ibs',\App\Models\Laporanibs::where('id_laporan',$idlaporan)->pluck('id')->first())->count() }} orang</b></h6>

        <label class="mt-2" style="color:#000;font-weight:600">Jumlah pasien menurut Dokter IBS</label>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                                            <th>No</th>
                                            <th>Nama <br> (RM)</th>
                                            <th>Dokter Operasi</th>
                                            <th>Dokter Anestesi</th>
                                            <th>Pendamping</th>
                                            <th>Ruangan Asal</th>
                                            <th>Jam mulai</th>
                                            <th>Jam selesai</th>
                                            <th>Diagnosa Pre</th>
                                            <th>Diagnosa Post</th>
                                     

                </tr>
                    
                </thead>

                <?php
                $no = 1;
                ?>
                <tbody>
                    

                    @foreach(\App\Models\Laporanibsdetail::where('status',1)->where('id_laporan_ibs',\App\Models\Laporanibs::where('id_laporan',$idlaporan)->pluck('id')->first())->get() as $data)
                    <?php
                                        $arrdokteroperasi = explode(',',$data->id_dokter_operasi);

                                        
                                        ?>
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $data->nama }}<br>({{ $data->rm }})</td>
                                            <td>
                                            @foreach($arrdokteroperasi as $key)  
                                                {{ \App\Models\Dokterirj::where('id',$key)->pluck('nama')->first() }}<br>    
                                            @endforeach

                                            </td>
                                            <td>{{ \App\Models\Dokterirj::where('id',$data->id_dokter_anestesi)->pluck('nama')->first() }}</td>
                                            <td>{{ $data->pendamping }}</td>
                                            <td>{{ \App\Models\Ruangan::where('id',$data->id_ruangan)->pluck('nama_ruangan')->first() }}</td>
                                            <td>{{ $data->jam_mulai }}</td>
                                            <td>{{ $data->jam_selesai }}</td>
                                            <td>{{ $data->diagnosa_pre }}</td>
                                            <td>{{ $data->diagnosa_post }}</td>
                                           
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
            <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Catatan IBS untuk Dinas Berikutnya</label>
            <textarea class="form-control  z-depth-1" name="ibs_catatan" rows="3" readonly value="{{ \App\Models\Laporanibs::where('id_laporan',$idlaporan)->pluck('catatan')->first() }}"></textarea>
        </div>
       


    </div>
</div>

