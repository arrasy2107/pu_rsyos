<input type="hidden" class="form-control" id="ruangan" name="ruangan" value="{{$ruangan2}}" />

<div class="row">
    <div class="col-md-4">
        <a class="btn btn-primary btn-md" style="color:white" data-bs-toggle="modal" data-bs-target="#tambahbaru">Input Catatan</a>
        <br>
    </div>
</div>
<br>

<div class="table-responsive">
    <table class="table table-bordered" id="dataTablebaru" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th width="10%">No</th>
                <th>Kamar</th>
                <th>Nama<br>RM<br>Diagnosa<br>DPJP</th>
                <th>Kondisi</th>

                <th width="20%">Aksi</th>

            </tr>
        </thead>

        <?php
        $no = 1;
        ?>
        <tbody>
            @foreach(\App\Models\Catatanpasien::where('status',0)->where('id_ruangan',$ruangan2)->where('id_jenis_pasien',2)->where('id_pengawas',\Auth::user()->id)->get() as $data)
            <tr>
                <td>{{ $no }}</td>
                <td>{{ $data->kamar }}</td>
                <td>{{ $data->nama }}
                    <hr>{{ $data->rm }}
                    <hr>{{ $data->diagnosa }}
                    <hr>{{ \App\Models\Dokterirj::where('id',$data->dpjp)->pluck('nama')->first() }}
                </td>
                <td>{{ $data->kondisi }}</td>

                <td><a data-id="{{ $data->id }}" class="btn btn-sm btn-success btn-edit " style="color:white" data-kamar="{{$data->kamar}}" data-nama="{{$data->nama}}" data-rm="{{$data->rm}}" data-diagnosa="{{$data->diagnosa}}" data-dpjp="{{$data->dpjp}}" data-kondisi="{{$data->kondisi}}" data-bs-toggle="modal" data-bs-target="#editbaru">Ubah</a>
                    <a class="btn btn-sm btn-danger btn-hapus " data-id="{{ $data->id }}" style="color:white">Hapus</a>

                </td>

            </tr>
            <?php
            $no++;
            ?>
            @endforeach

        </tbody>
    </table>
</div>
<script>
    $("#dataTablebaru").DataTable({
        "pageLength": 5,
        "ordering": false,
        lengthMenu: [
            [5],
            [5]
        ]
    });
</script>