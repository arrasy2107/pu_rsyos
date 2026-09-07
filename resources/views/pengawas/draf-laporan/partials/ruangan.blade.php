{{-- 2. RUANGAN (RAWAT INAP) - DRAF LAPORAN (Input/Edit) --}}

<div class="card shadow-sm mb-4 animate-fade-in-up border-left-{{ $visitedRoomsDraf > 0 ? 'success' : 'primary' }}">
    <a href="#collapseRanap" class="d-block card-header collapse-header py-3 collapsed" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseRanap">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fas fa-procedures me-2 text-primary"></i> Ruangan (Rawat Inap)</h6>
            @if($visitedRoomsDraf > 0)
            <div>
                <span class="badge bg-success px-3 py-1 me-2"><i class="fas fa-check-circle me-1"></i> ({{$visitedRoomsDraf}} / {{$totalRoomsDraf}}) Dikunjungi</span>
                <span class="text-white small fw-bold px-2 py-1 bg-secondary">Total Pasien: {{$totalPasienDraf}}</span>
            </div>
            @endif
        </div>
    </a>
    <div class="collapse" id="collapseRanap" data-bs-parent="#drafAccordion">
        <div class="card-body bg-light">
            <div class="bg-white p-4 border rounded shadow-sm mb-4">
                <div class="form-group mb-0">
                    <label class="fw-bold text-dark"><i class="fas fa-door-open me-2 text-primary"></i> Pilih Ruangan yang telah dikunjungi:</label>
                    <select class="form-control select2" name="inap_ruangan" id="inap_ruangan" style="width: 100%" required>
                        <option value="" selected disabled hidden>Lihat data laporan ruangan...</option>
                        @foreach($ruangans as $dk)
                        @if(in_array($dk->id, $visitedRoomIdsDraf))
                        <option value="{{ $dk->id }}">{{ $dk->nama_ruangan }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 tablelaporan">
                    <div class="text-center py-4 text-muted border border-dashed rounded bg-white">
                        <i class="fas fa-hand-pointer fa-2x mb-3 text-gray-300"></i>
                        <p class="mb-0">Pilih ruangan dari dropdown di atas untuk melihat laporannya.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>