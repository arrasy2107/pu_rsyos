@php
$no = 1;
@endphp

<div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
    <table class="table table-bordered table-hover mb-0" id="dataTable2" width="100%" cellspacing="0">
        <thead class="thead-light" style="position: sticky; top: 0; z-index: 1; background-color: #f8f9fa;">
            <tr>
                <th width="5%" class="text-center">No</th>
                <th>Nama (RM)</th>
                <th>Dokter Operasi</th>
                <th>Dokter Anestesi</th>
                <th>Ruangan Asal</th>
                <th>Waktu</th>
                <th>Diagnosa</th>
                <th width="12%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $data)
            @php $arrdokteroperasi = explode(',', $data->id_dokter_operasi); @endphp
            <tr>
                <td class="text-center align-middle">{{ $no++ }}</td>
                <td class="align-middle">
                    <div class="fw-bold">{{ $data->nama }}</div>
                    <div class="text-muted small">RM: {{ $data->rm }}</div>
                </td>
                <td class="align-middle">
                    @foreach($arrdokteroperasi as $key)
                    <div class="badge bg-info mb-1">{{ \App\Models\Dokterirj::where('id', $key)->value('nama') }}</div>
                    @endforeach
                </td>
                <td class="align-middle">{{ optional($data->dokterAnestesi)->nama }}</td>
                <td class="align-middle">{{ optional($data->ruangan)->nama_ruangan }}</td>
                <td class="align-middle text-nowrap">
                    <span class="text-success"><i class="fas fa-play-circle me-1"></i> {{ $data->jam_mulai }}</span><br>
                    <span class="text-danger"><i class="fas fa-stop-circle me-1"></i> {{ $data->jam_selesai }}</span>
                </td>
                <td class="align-middle small">
                    <b>Pre:</b> {{ Str::limit($data->diagnosa_pre, 30) }}<br>
                    <b>Post:</b> {{ Str::limit($data->diagnosa_post, 30) }}
                </td>
                <td class="align-middle">
                    <div class="btn-group w-100 shadow-sm" role="group">
                        <button value="{{ $data->id }}" class="btn btn-sm btn-info btn-edit"
                            data-nama="{{ $data->nama }}" data-rm="{{ $data->rm }}"
                            data-dokteroperasi="{{ $data->id_dokter_operasi }}"
                            data-dokteranestesi="{{ $data->id_dokter_anestesi }}"
                            data-pendamping="{{ $data->pendamping }}"
                            data-ruangan="{{ $data->id_ruangan }}"
                            data-jammulai="{{ $data->jam_mulai }}"
                            data-jamselesai="{{ $data->jam_selesai }}"
                            data-diagnosapre="{{ $data->diagnosa_pre }}"
                            data-diagnosapost="{{ $data->diagnosa_post }}"
                            data-bs-toggle="modal" data-bs-target="#editibs" title="Edit">
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
                <td colspan="8" class="text-center text-muted py-4">Belum ada data IBS.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>