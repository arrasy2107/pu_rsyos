@php
$no = 1;
@endphp

<div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
    <table class="table table-bordered table-hover mb-0" id="dataTable" width="100%" cellspacing="0">
        <thead class="thead-light" style="position: sticky; top: 0; z-index: 1; background-color: #f8f9fa;">
            <tr>
                <th width="5%" class="text-center">No</th>
                <th>SDMK Jenis</th>
                <th>Nama Dokter</th>
                <th class="text-center">Pasien Lama</th>
                <th class="text-center">Pasien Baru</th>
                <th class="text-center text-primary">Total</th>
                <th width="15%" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $data)
            <tr>
                <td class="text-center align-middle">{{ $no++ }}</td>
                <td class="align-middle">{{ \App\Models\sdmk_jenis::where('id', optional($data->dokter)->id_sdmk_jenis)->value('jenis') }}</td>
                <td class="align-middle fw-bold">{{ optional($data->dokter)->nama }}</td>
                <td class="text-center align-middle">{{ $data->pasien_lama }}</td>
                <td class="text-center align-middle">{{ $data->pasien_baru }}</td>
                <td class="text-center align-middle fw-bold text-primary" style="font-size: 1.1rem;">{{ $data->pasien_total }}</td>
                <td class="text-center align-middle">
                    <div class="btn-group shadow-sm" role="group">
                        <button value="{{ $data->id }}" class="btn btn-sm btn-info btn-edit"
                            data-dokter="{{ $data->id_dokter_irj }}"
                            data-lama="{{ $data->pasien_lama }}"
                            data-baru="{{ $data->pasien_baru }}"
                            data-bs-toggle="modal" data-bs-target="#edit" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button value="{{ $data->id }}" class="btn btn-sm btn-danger btn-hapus" title="Hapus">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted py-4">Belum ada data IRJ.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>