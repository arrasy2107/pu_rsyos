<div class="table-responsive">
                        <table class="table table-bordered" id="detilistimewa" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="10%">No</th>
                                    <th>Kamar</th>
                                    <th>Nama<br>RM<br>Diagnosa<br>DPJP</th>
                                    <th>Kondisi</th>

                                </tr>
                            </thead>

                            <?php
                            $no = 1;
                            ?>
                            <tbody>
                                @foreach(\App\Models\Catatanpasien::where('id_laporan_umum',$idlaporanumum)->where('id_ruangan',$idruangan)->where('id_jenis_pasien',1)->get() as $data)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $data->kamar }}</td>
                                    <td>{{ $data->nama }}<hr>{{ $data->rm }}<hr>{{ $data->diagnosa }}<hr>{{ \App\Models\Dokterirj::where('id',$data->dpjp)->pluck('nama')->first() }}</td>
                                    <td>{{ $data->kondisi }}</td>
                                   
                              
                                </tr>
                                <?php
                                $no++;
                                ?>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

<script>

$("#detilistimewa").DataTable({
    "pageLength": 5,
    "ordering" : false,
    lengthMenu: [[5], [5]]
    });
</script>