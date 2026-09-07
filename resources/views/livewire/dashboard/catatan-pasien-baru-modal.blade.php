<div>
    @if($idlaporan && $idruangan)
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
                @forelse($items as $idx => $item)
                <tr>
                    <td>{{ $idx + 1 }}</td>
                    <td>{{ $item->kamar }}</td>
                    <td>
                        {{ $item->nama }}<br>
                        <small>{{ $item->rm }}</small><br>
                        <small>{{ $item->diagnosa }}</small><br>
                        <small>{{ $item->dpjp }}</small>
                    </td>
                    <td>{{ $item->kondisi }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Tidak ada catatan pasien baru.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center text-muted py-4">
        <i class="fas fa-circle-notch fa-spin fa-2x mb-3"></i>
        <p>Memuat data catatan pasien baru...</p>
    </div>
    @endif
</div>