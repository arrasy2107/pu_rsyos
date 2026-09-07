<div>
    @if($type)
    <div class="table-responsive">
        <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kamar</th>
                    <th>Nama / RM / Diagnosa / DPJP</th>
                    <th>Kondisi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $idx => $data)
                <tr>
                    <td>{{ $idx + 1 }}</td>
                    <td>{{ $data->kamar }}</td>
                    <td>{{ $data->nama }}
                        <hr>{{ $data->rm }}
                        <hr>{{ $data->diagnosa }}
                        <hr>{{ $data->dpjp }}
                    </td>
                    <td>{{ $data->kondisi }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Tidak ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center text-muted py-4">Pilih catatan untuk ditampilkan.</div>
    @endif
</div>