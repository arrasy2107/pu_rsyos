<div class="table-responsive">
    <table class="table table-bordered table-hover" id="dataTableIBS" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama / RM</th>
                <th>Dokter Operasi</th>
                <th>Dokter Anestesi</th>
                <th>Pendamping</th>
                <th>Ruangan Asal</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Diagnosa Pre</th>
                <th>Diagnosa Post</th>
            </tr>
        </thead>
        <tbody>
            @if($getIDibs)
            @foreach ($laporanIbsDetail as $index => $data)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $data->nama }}</strong><br><small class="text-muted">{{ $data->rm }}</small></td>
                <td>
                    @php $arrdokteroperasi = explode(',', $data->id_dokter_operasi); @endphp
                    @foreach(\App\Models\Dokterirj::whereIn('id', $arrdokteroperasi)->get() as $dok)
                    <span class="d-block">{{ $dok->nama }}</span>
                    @endforeach
                </td>
                <td>{{ $data->dokterAnestesi->nama ?? '' }}</td>
                <td>{{ $data->pendamping }}</td>
                <td>{{ $data->ruangan->nama_ruangan ?? '' }}</td>
                <td><span class="badge bg-secondary">{{ $data->jam_mulai }}</span></td>
                <td><span class="badge bg-secondary">{{ $data->jam_selesai }}</span></td>
                <td>{{ $data->diagnosa_pre }}</td>
                <td>{{ $data->diagnosa_post }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>

<div class="mt-4">
    <div class="mb-0">
        <label>Catatan IBS untuk Dinas Berikutnya</label>
        <textarea class="form-control bg-light" rows="3" readonly>{{ $catatanIbs }}</textarea>
    </div>
</div>