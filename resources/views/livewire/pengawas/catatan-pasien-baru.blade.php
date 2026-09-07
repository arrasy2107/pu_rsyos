@php
$items = $items ?? collect();
@endphp

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
        <tbody>
            @forelse($items as $index => $data)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $data->kamar }}</td>
                <td>
                    {{ $data->nama }}
                    <hr>{{ $data->rm }}
                    <hr>{{ $data->diagnosa }}
                    <hr>{{ \App\Models\Dokterirj::where('id', $data->dpjp)->value('nama') }}
                </td>
                <td>{{ $data->kondisi }}</td>
                <td>
                    <a data-id="{{ $data->id }}" class="btn btn-sm btn-success btn-edit" style="color:white" data-kamar="{{ $data->kamar }}" data-nama="{{ $data->nama }}" data-rm="{{ $data->rm }}" data-diagnosa="{{ $data->diagnosa }}" data-dpjp="{{ $data->dpjp }}" data-kondisi="{{ $data->kondisi }}" data-bs-toggle="modal" data-bs-target="#editbaru">Ubah</a>
                    <a class="btn btn-sm btn-danger btn-hapus" data-id="{{ $data->id }}" style="color:white">Hapus</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted">No data available in table</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('livewire:load', function() {
        $('#dataTablebaru').DataTable().destroy();
        $('#dataTablebaru').DataTable({
            paging: true,
            pageLength: 5,
            ordering: false,
            lengthMenu: [
                [5],
                [5]
            ],
        });
    });
</script>