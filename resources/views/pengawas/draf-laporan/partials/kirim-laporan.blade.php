{{-- 5. FINAL SUBMISSION (QR CODE) --}}
<div class="card shadow-sm mb-4 animate-fade-in-up border-left-info">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 fw-bold"><i class="fas fa-qrcode me-2 text-info"></i> Pengiriman Laporan Akhir</h6>
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
                    <div class="alert alert-secondary py-2 mt-3">
                        <i class="fas fa-qrcode me-2"></i>
                        QR Code verifikasi akan digenerate otomatis saat laporan dikirim.
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
            <form method="post" action="{{ route('kirimLaporan') }}">
                {{ csrf_field() }}
                <div class="bg-white p-4 border rounded shadow-sm">
                    <div class="form-group">
                        <label class="fw-bold text-dark">Shift Dinas saat ini:</label>
                        @php
                            $activePiket = $piketHariIni ?? $piketTerlambat ?? null;
                        @endphp
                        @if($activePiket)
                            <div class="d-flex align-items-center bg-light border rounded px-3 py-2">
                                <i class="fas fa-clock text-primary me-2"></i>
                                <span class="fw-bold text-primary">{{ strtoupper($activePiket->dinas->dinas ?? 'TIDAK DIKETAHUI') }}</span>
                                @if(isset($piketTerlambat) && $piketTerlambat)
                                <span class="badge bg-danger ms-auto"><i class="fas fa-exclamation-circle me-1"></i> Terlambat</span>
                                @endif
                            </div>
                            <input type="hidden" name="dinas" value="{{ $activePiket->id_dinas }}">
                            <input type="hidden" name="tanggal_dinas" value="{{ \Carbon\Carbon::parse($activePiket->tanggal)->toDateString() }}">
                            @if(isset($piketTerlambat) && $piketTerlambat)
                            <input type="hidden" name="is_terlambat" value="1">
                            @endif
                        @else
                            <div class="alert alert-danger py-2 px-3 mb-0">
                                <i class="fas fa-exclamation-triangle me-2"></i> Jadwal dinas Anda untuk hari ini belum diatur oleh Bidang Keperawatan.
                            </div>
                            <input type="hidden" name="dinas" value="">
                        @endif
                    </div>

                    {{-- Informasi QR Code --}}
                    <div class="alert alert-info mt-3 mb-3 d-flex align-items-start gap-3">
                        <i class="fas fa-qrcode fa-2x text-info mt-1 flex-shrink-0"></i>
                        <div>
                            <div class="fw-bold mb-1">Tanda Tangan Digital (QR Code)</div>
                            <small class="text-muted">
                                Setelah laporan dikirim, sistem akan menghasilkan <b>QR Code verifikasi</b> yang terikat dengan
                                identitas Anda sebagai <b>{{ \Auth::user()->nama }}</b>. QR Code ini dapat dipindai oleh siapapun
                                untuk memverifikasi keaslian laporan ini.
                            </small>
                        </div>
                    </div>

                    <div class="custom-control custom-checkbox mt-3 mb-4">
                        <input type="checkbox" class="custom-control-input" id="exampleCheck1" required>
                        <label class="custom-control-label fw-bold text-dark pt-1" style="line-height: 1.5;" for="exampleCheck1">
                            Saya, <b>{{\Auth::user()->nama}}</b>, bertanggung jawab penuh atas laporan ini dan memastikan bahwa seluruh data yang diinputkan adalah benar dan valid.
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg shadow-sm" {{ isset($activePiket) && $activePiket ? '' : 'disabled' }}>
                        <i class="fas fa-paper-plane me-2"></i> Kirim Laporan Final
                    </button>
                </div>
            </form>
        </div>
        <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center">
            <div class="text-center text-muted">
                <i class="fas fa-qrcode fa-6x mb-4 text-info"></i>
                <h4 class="fw-bold text-gray-500">QR Code Verifikasi</h4>
                <p>QR Code akan digenerate otomatis setelah laporan berhasil dikirim.<br>
                <small>Siapapun dapat memindai QR Code untuk memverifikasi keaslian laporan.</small></p>
            </div>
        </div>
    </div>
</div>
@endif
</div>