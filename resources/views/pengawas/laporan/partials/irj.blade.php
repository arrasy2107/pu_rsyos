{{-- 4. INSTALASI RAWAT JALAN (IRJ) --}}
@if ($piketTerlambat || (strtotime($nowTime) > strtotime($start) && strtotime($nowTime) < strtotime($end) && $t->is_sunday() != true) ||
    (strtotime($nowTime) > strtotime($start) && strtotime($nowTime) < strtotime($end) && $t->is_holiday() == true && \App\Models\Irjbuka::where('tanggal',$hariini)->first()))


@if($irjLaporan)
<div class="card shadow-sm mb-4 animate-fade-in-up border-left-success">
    <a href="#collapseIRJ" class="d-block card-header collapse-header py-3 collapsed" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseIRJ">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fas fa-stethoscope me-2 text-primary"></i> Instalasi Rawat Jalan (IRJ)</h6>
            <div>
                <span class="badge bg-success px-3 py-2 me-2"><i class="fas fa-check-circle me-1"></i> Sudah Dikunjungi</span>
                <span class="text-muted small font-italic"><i class="fas fa-info-circle me-1"></i> Ubah data di Draf Laporan</span>
            </div>
        </div>
    </a>
    <div class="collapse" id="collapseIRJ" data-bs-parent="#pengawasAccordion">
        <div class="card-body bg-light">
            <div class="alert alert-secondary mb-0 d-flex justify-content-between align-items-center" role="alert">
                <span><i class="fas fa-info-circle me-2"></i>Laporan IRJ sudah disimpan. Perubahan dilakukan melalui Draf Laporan.</span>
                <a href="{{ route('draf-laporan') }}" class="btn btn-primary btn-sm ms-3 text-nowrap">Buka Draf Laporan</a>
            </div>
        </div>
    </div>
</div>
@else
{{-- Belum dikunjungi: tampilkan form input --}}
<div class="card shadow-sm mb-4 animate-fade-in-up border-left-primary">
    <a href="#collapseIRJ" class="d-block card-header collapse-header py-3 collapsed" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseIRJ">
        <h6 class="m-0 fw-bold text-dark"><i class="fas fa-stethoscope me-2 text-primary"></i> Instalasi Rawat Jalan (IRJ)</h6>
    </a>
    <div class="collapse" id="collapseIRJ" data-bs-parent="#pengawasAccordion">
        <div class="card-body bg-light">
            <div class="bg-white p-4 border rounded shadow-sm mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-bold m-0 text-danger"><i class="fas fa-users me-2"></i> Total Pasien IRJ: {{ $irjDetailTotal }} orang</h6>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah"><i class="fas fa-plus me-1"></i> Input Pasien Dokter</button>
                </div>

                <div class="tableketerangan">
                    @livewire('pengawas.irj-detail')
                </div>
            </div>

            <form method="post" action="{{ route('draftlaporanIRJ') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="bg-white p-4 border rounded shadow-sm">
                    <div class="form-group shadow-textarea">
                        <label class="fw-bold text-dark"><i class="fas fa-exclamation-circle me-2 text-warning"></i> Masalah (Jika ada)</label>
                        <textarea class="form-control z-depth-1" name="irj_masalah" rows="3" placeholder="Deskripsikan kendala yang terjadi..."></textarea>
                    </div>
                    <div class="form-group shadow-textarea">
                        <label class="fw-bold text-dark"><i class="fas fa-check-circle me-2 text-success"></i> Langkah atasi masalah</label>
                        <textarea class="form-control" name="irj_langkah" rows="3" placeholder="Deskripsikan solusi yang diambil..."></textarea>
                    </div>

                    <div class="form-group mt-4 text-end border-top pt-3">
                        <button type="submit" class="btn btn-primary btn-irj px-4 py-2 fw-bold shadow-sm">
                            <i class="fas fa-save me-2"></i> Simpan ke Draf Laporan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endif
