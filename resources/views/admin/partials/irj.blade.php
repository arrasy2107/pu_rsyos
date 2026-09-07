<div class="table-responsive">
    <table class="table table-bordered table-hover" id="dataTableIRJ" width="100%" cellspacing="0">
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
        <tbody>
            @if($getIDirj)
            @foreach ($laporanIrjDetail as $index => $data)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $data->dokter->jenisSdmk->jenis ?? '' }}</td>
                <td class="fw-bold">{{ $data->dokter->nama ?? '' }}</td>
                <td>{{ $data->pasien_lama }}</td>
                <td>{{ $data->pasien_baru }}</td>
                <td class="fw-bold text-primary">{{ $data->pasien_total }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="mb-0">
            <label>Masalah</label>
            <textarea class="form-control bg-light" rows="3" readonly>{{ $masalahIrj }}</textarea>
        </div>
    </div>
    <div class="col-md-6 mt-3 mt-md-0">
        <div class="mb-0">
            <label>Langkah atasi masalah</label>
            <textarea class="form-control bg-light" rows="3" readonly>{{ $langkahIrj }}</textarea>
        </div>
    </div>
</div>