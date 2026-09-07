{{-- 5. FINAL SUBMISSION (SIGNATURE) --}}
<div class="card shadow-sm mb-4 animate-fade-in-up border-left-info">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 fw-bold"><i class="fas fa-file-signature me-2 text-info"></i> Pengiriman Laporan Akhir</h6>
    </div>

    @if($visitedRoomsCount < $totalRoomsCount || !$hasIgdReport)
        <div class="card-body bg-light">
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i> <b>Perhatian:</b> Anda belum dapat mengirim laporan. Silakan lengkapi kunjungan ke seluruh Ruangan (Rawat Inap) dan Instalasi Gawat Darurat (IGD) terlebih dahulu. <small class="d-block mt-1">*(IRJ dan IBS tidak wajib diisi jika tidak ada pasien/dinas).*</small>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="bg-white p-4 border rounded shadow-sm opacity-50">
                    <div class="form-group">
                        <label class="fw-bold">Dinas</label>
                        <select class="form-control select2" disabled>
                            <option value="" selected>Pilih Dinas</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="fw-bold">Tanda Tangan {{\Auth::user()->nama}}</label>
                        <div class="kbw-signature" style="background-color: #eaecf4;"></div>
                        <button class="btn btn-danger btn-sm mt-2" disabled>Hapus Tanda Tangan</button>
                    </div>
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" class="custom-control-input" id="checkDisabled" disabled>
                        <label class="custom-control-label fw-bold text-muted" for="checkDisabled">Saya bertanggung jawab atas kebenaran laporan ini.</label>
                    </div>
                    <button class="btn btn-primary btn-block" disabled><i class="fas fa-paper-plane me-2"></i> Kirim Laporan</button>
                </div>
            </div>
        </div>
</div>
@else
<div class="card-body bg-light">
    <div class="row">
        <div class="col-lg-6">
            <form method="post" action="{{ route('kirimLaporan') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="bg-white p-4 border rounded shadow-sm">
                    <div class="form-group">
                        <label class="fw-bold text-dark">Shift Dinas saat ini:</label>
                        <select class="form-control select2" name="dinas" id="dinas" required>
                            <option value="" selected disabled hidden>Pilih Shift Dinas...</option>
                            @foreach($dinasList as $dk)
                            <option value="{{ $dk->id }}">{{ strtoupper($dk->dinas) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="fw-bold text-dark d-flex justify-content-between align-items-center">
                            <span>Tanda Tangan {{\Auth::user()->nama}}</span>
                            <button id="clear" class="btn btn-outline-danger btn-sm" type="button"><i class="fas fa-eraser me-1"></i> Bersihkan</button>
                        </label>
                        <div id="sig" class="shadow-sm"></div>
                        <textarea id="signature64" name="signed" style="display: none" required></textarea>
                    </div>

                    <div class="custom-control custom-checkbox mt-4 mb-4">
                        <input type="checkbox" class="custom-control-input" id="exampleCheck1" required>
                        <label class="custom-control-label fw-bold text-dark pt-1" style="line-height: 1.5;" for="exampleCheck1">
                            Saya, <b>{{\Auth::user()->nama}}</b>, bertanggung jawab penuh atas laporan ini dan memastikan bahwa seluruh data yang diinputkan adalah benar dan valid.
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg shadow-sm">
                        <i class="fas fa-paper-plane me-2"></i> Kirim Laporan Final
                    </button>
                </div>
            </form>
        </div>
        <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center">
            <div class="text-center text-muted">
                <i class="fas fa-clipboard-check fa-6x mb-4 text-gray-300"></i>
                <h4 class="fw-bold text-gray-500">Laporan Siap Dikirim</h4>
                <p>Pastikan Anda telah memeriksa kembali seluruh data pada draft sebelum menandatangani laporan.</p>
            </div>
        </div>
    </div>
</div>
@endif
</div>