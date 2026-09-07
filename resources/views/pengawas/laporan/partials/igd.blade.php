{{-- Instalasi Gawat Darurat (IGD) - input laporan baru. --}}
<div class="card shadow-sm mb-4 animate-fade-in-up border-left-{{ $igdLaporan ? 'success' : 'primary' }}">
    <a href="#collapseIGD" class="d-block card-header collapse-header py-3 collapsed" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseIGD">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fas fa-ambulance me-2 text-primary"></i> Instalasi Gawat Darurat (IGD)</h6>
            @if($igdLaporan)
            <div>
                <span class="badge bg-success px-3 py-2 me-2"><i class="fas fa-check-circle me-1"></i> Sudah Dikunjungi</span>
                <span class="text-muted small font-italic"><i class="fas fa-info-circle me-1"></i> Ubah data di Draf Laporan</span>
            </div>
            @endif
        </div>
    </a>
    <div class="collapse" id="collapseIGD" data-bs-parent="#pengawasAccordion">
        <div class="card-body bg-light">
            @if($igdLaporan)
            <div class="alert alert-secondary mb-0 d-flex justify-content-between align-items-center" role="alert">
                <span><i class="fas fa-info-circle me-2"></i>Laporan IGD sudah tersimpan di Draf Laporan.</span>
                <a href="{{ route('draf-laporan') }}" class="btn btn-primary btn-sm ms-3 text-nowrap">Buka Draf Laporan</a>
            </div>
            @else
            <form method="post" action="{{ route('draftlaporanIGD') }}" id="draft-igd-form">
                @csrf
                @php
                $igdFields = [
                ['igd_pasien', 'Total Kunjungan Pasien', 'general/pasien.png', 'warning'],
                ['igd_pasien_rawat', 'Pasien Dirawat', 'igd/pasien-dirawat.png', 'warning'],
                ['igd_pasien_emergency', 'Pasien Emergency', 'igd/pasien-emergency.png', 'danger'],
                ['igd_pasien_tidak_rawat', 'Pasien Rujuk & Tolak Rawat', 'igd/pasien-tidak-bisa-dirawat.png', 'danger'],
                ['igd_pasien_doa', 'Pasien DOA & Meninggal', 'igd/pasien-doa.png', 'danger'],
                ['igd_pasien_sisrute', 'Rujukan SISRUTE', 'igd/sisrute.png', 'warning'],
                ['igd_pasien_sisrute_diterima', 'Rujukan SISRUTE Diterima', 'igd/sisrute-terima.png', 'success'],
                ];
                @endphp
                <div class="row">
                    @foreach($igdFields as [$field, $label, $icon, $color])
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-{{ $color }} shadow-sm h-100 py-2 pu-stats-card">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-md-9">
                                        <label class="text-xs fw-bold text-muted text-uppercase mb-1" for="{{ $field }}">{{ $label }}</label>
                                        <input type="number" min="0" step="1" class="form-control @error($field) is-invalid @enderror" name="{{ $field }}" id="{{ $field }}" value="{{ old($field) }}" autocomplete="off" required>
                                        @error($field)<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-3 text-end"><img src="{{ asset('sb-admin/icon/' . $icon) }}" class="img-fluid pu-stats-img" alt=""></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="bg-white p-4 border rounded shadow-sm">
                    <div class="form-group shadow-textarea"><label class="fw-bold text-dark" for="igd_alasan"><i class="fas fa-file-alt me-2 text-primary"></i> Alasan pasien rujuk dan tolak rawat</label><textarea class="form-control @error('igd_alasan') is-invalid @enderror" name="igd_alasan" id="igd_alasan" rows="3">{{ old('igd_alasan') }}</textarea>@error('igd_alasan')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="form-group shadow-textarea"><label class="fw-bold text-dark" for="igd_permasalahan"><i class="fas fa-exclamation-triangle me-2 text-warning"></i> Permasalahan</label><textarea class="form-control @error('igd_permasalahan') is-invalid @enderror" name="igd_permasalahan" id="igd_permasalahan" rows="3">{{ old('igd_permasalahan') }}</textarea>@error('igd_permasalahan')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="form-group shadow-textarea"><label class="fw-bold text-dark" for="igd_lainlain"><i class="fas fa-comment-dots me-2 text-info"></i> Lain-lain</label><textarea class="form-control @error('igd_lainlain') is-invalid @enderror" name="igd_lainlain" id="igd_lainlain" rows="3">{{ old('igd_lainlain') }}</textarea>@error('igd_lainlain')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="form-group mb-0">
                        <label class="fw-bold text-dark" for="igd_dokterjaga"><i class="fas fa-user-md me-2 text-success"></i> Dokter Jaga</label>
                        <select multiple="multiple" class="form-control select2 @error('igd_dokterjaga') is-invalid @enderror" name="igd_dokterjaga[]" id="igd_dokterjaga" style="width: 100%" data-placeholder="Pilih Dokter Jaga IGD" required>
                            @foreach($dokters as $dk)
                            <option value="{{ $dk->id }}" @selected(old('igd_dokterjaga') == $dk->id)>{{ $dk->nama_dokter }}</option>
                            @endforeach
                        </select>
                        @error('igd_dokterjaga')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group mt-4 mb-0 text-end border-top pt-3"><button type="submit" class="btn btn-primary px-4 py-2 fw-bold shadow-sm"><i class="fas fa-save me-2"></i>Simpan ke Draf Laporan</button></div>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>
