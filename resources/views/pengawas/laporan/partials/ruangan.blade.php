{{-- 2. RUANGAN (RAWAT INAP) - LAPORAN (View Only) --}}


@if($allVisited)
{{-- Semua ruangan sudah dikunjungi: tampilkan header ringkas saja --}}
<div class="card shadow-sm mb-4 animate-fade-in-up border-left-success">
    <a href="#collapseRanap2" class="d-block card-header collapse-header py-3 collapsed" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseRanap2">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fas fa-procedures me-2 text-primary"></i> Ruangan (Rawat Inap)</h6>
            <div>
                <span class="badge bg-success px-3 py-2 me-2"><i class="fas fa-check-circle me-1"></i> ({{$visitedRooms}} / {{$totalRooms}}) Sudah Dikunjungi</span>
                <span class="text-muted small font-italic"><i class="fas fa-info-circle me-1"></i> Ubah data di Draf Laporan</span>
            </div>
        </div>
    </a>
    <div class="collapse" id="collapseRanap2" data-bs-parent="#pengawasAccordion">
        <div class="card-body bg-light">
            <div class="alert alert-secondary mb-0 d-flex justify-content-between align-items-center" role="alert">
                <span><i class="fas fa-info-circle me-2"></i>Semua Laporan Ruangan sudah tersimpan di Draf Laporan.</span>
                <a href="{{ route('draf-laporan') }}" class="btn btn-primary btn-sm ms-3 text-nowrap">Buka Draf Laporan</a>
            </div>
        </div>
    </div>
</div>

@else
{{-- Belum semua dikunjungi: tampilkan form input --}}
<div class="card shadow-sm mb-4 animate-fade-in-up border-left-primary">
    <a href="#collapseRanap" class="d-block card-header collapse-header py-3 collapsed" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseRanap">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fas fa-procedures me-2 text-primary"></i> Ruangan (Rawat Inap)</h6>
            @if($visitedRooms >= 0)
            <span class="badge bg-warning text-dark px-3 py-1"><i class="fas fa-spinner fa-spin me-1"></i> ({{$visitedRooms}} / {{$totalRooms}}) Ruangan Dikunjungi</span>
            @endif
        </div>
    </a>
    <div class="collapse" id="collapseRanap" data-bs-parent="#pengawasAccordion">
        <div class="card-body bg-light">
            <div class="bg-white p-4 border rounded shadow-sm mb-4">
                <div class="form-group mb-0">
                    <label class="fw-bold text-dark"><i class="fas fa-door-open me-2 text-primary"></i> Ruangan yang belum dikunjungi:</label>
                    <select class="form-control select2" name="inap_ruangan" id="inap_ruangan" style="width: 100%" required>
                        <option value="" selected disabled hidden>Pilih Ruangan</option>
                        @foreach($ruangans as $dk)
                        @if(!in_array($dk->id, $visitedRoomIds))
                        <option value="{{ $dk->id }}">{{ $dk->nama_ruangan }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <form method="post" action="{{ route('draftlaporanUmum') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12 tablelaporan">
                        <div class="text-center py-4 text-muted border border-dashed rounded bg-white">
                            <i class="fas fa-hand-pointer fa-2x mb-3 text-gray-300"></i>
                            <p class="mb-0">Pilih ruangan dari dropdown di atas untuk mengisi laporan form.</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endif