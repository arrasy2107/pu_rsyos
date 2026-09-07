{{-- 1. INSTALASI GAWAT DARURAT (IGD) - DRAF LAPORAN (Input/Edit) --}}


@if($igdDraf)
{{-- Sudah dikunjungi: tampilkan data dan form edit. --}}
<div class="card shadow-sm mb-4 animate-fade-in-up border-left-success">
    <a href="#collapseIGD" class="d-block card-header collapse-header py-3 collapsed" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseIGD">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fas fa-ambulance me-2 text-primary"></i> Instalasi Gawat Darurat (IGD)</h6>
            <div>
                <span class="badge bg-primary px-3 py-2 me-2"><i class="fas fa-info-circle me-1"></i> Lihat Laporan</span>
            </div>
        </div>
    </a>
    <div class="collapse" id="collapseIGD" data-bs-parent="#drafAccordion">
        <div class="card-body bg-light">
            <form method="post" action="{{ route('editDraftlaporanIGD') }}" id="editdraftigd">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <input type="hidden" name="id" value="{{ $igdDraf->id }}">

                <div class="row">
                    @php
                    $igdFields = [
                    ['igd_pasien', 'Total Kunjungan Pasien', 'jumlah_pasien'],
                    ['igd_pasien_rawat', 'Pasien Dirawat', 'jumlah_pasien_rawat'],
                    ['igd_pasien_emergency', 'Pasien Emergency', 'jumlah_pasien_emergency'],
                    ['igd_pasien_tidak_rawat', 'Pasien Rujuk & Tolak Rawat', 'jumlah_pasien_tidak_bisa_rawat'],
                    ['igd_pasien_doa', 'Pasien DOA & Meninggal', 'jumlah_pasien_doa'],
                    ['igd_pasien_sisrute', 'Rujukan SISRUTE', 'jumlah_pasien_sisrute'],
                    ['igd_pasien_sisrute_diterima', 'Rujukan SISRUTE Diterima', 'jumlah_pasien_sisrute_diterima'],
                    ];
                    @endphp
                    @foreach($igdFields as [$fieldId, $label, $column])
                    <div class="col-xl-4 col-md-6 mb-3">
                        <div class="card border-left-primary shadow-sm h-100 py-2 pu-stats-card">
                            <div class="card-body">
                                <label class="text-xs fw-bold text-uppercase mb-1 text-muted" for="{{ $fieldId }}">{{ $label }}</label>
                                <input type="number" min="0" class="form-control" name="{{ $fieldId }}" id="{{ $fieldId }}" value="{{ $igdDraf->$column }}" readonly required>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="bg-white p-4 border rounded shadow-sm">
                    <div class="form-group shadow-textarea">
                        <label class="fw-bold text-dark" for="igd_alasan"><i class="fas fa-file-alt me-2 text-primary"></i> Alasan pasien rujuk dan tolak rawat</label>
                        <textarea class="form-control" name="igd_alasan" id="igd_alasan" rows="3" readonly>{{ $igdDraf->alasan_tidak_bisa_rawat }}</textarea>
                    </div>
                    <div class="form-group shadow-textarea">
                        <label class="fw-bold text-dark" for="igd_permasalahan"><i class="fas fa-exclamation-triangle me-2 text-warning"></i> Permasalahan</label>
                        <textarea class="form-control" name="igd_permasalahan" id="igd_permasalahan" rows="3" readonly>{{ $igdDraf->permasalahan }}</textarea>
                    </div>
                    <div class="form-group shadow-textarea">
                        <label class="fw-bold text-dark" for="igd_lainlain"><i class="fas fa-comment-dots me-2 text-info"></i> Lain-lain</label>
                        <textarea class="form-control" name="igd_lainlain" id="igd_lainlain" rows="3" readonly>{{ $igdDraf->lain_lain }}</textarea>
                    </div>
                    <div class="form-group mb-0">
                        <label class="fw-bold text-dark" for="igd_dokterjaga"><i class="fas fa-user-md me-2 text-success"></i>Dokter Jaga</label>
                        <select multiple="multiple" class="form-control select2 @error('igd_dokterjaga') is-invalid @enderror" name="igd_dokterjaga[]" id="igd_dokterjaga" style="width: 100%" data-placeholder="Pilih Dokter Jaga IGD" disabled required>
                            @php $selectedDokters = array_map('trim', explode(',', $igdDraf->id_dokter ?? '')); @endphp
                            @foreach($dokters as $dk)
                            <option value="{{ $dk->id }}" @selected(in_array($dk->id, old('igd_dokterjaga', $selectedDokters)))>{{ $dk->nama_dokter }}</option>
                            @endforeach
                        </select>
                        @error('igd_dokterjaga')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                </div>
            </form>
            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('deleteDraftlaporanIGD', $igdDraf->id) }}" id="bataligd" class="btn btn-outline-danger me-2"><i class="fas fa-trash-alt me-1"></i> Batalkan Laporan</a>
                <button id="editigd" type="button" class="btn btn-primary me-2"><i class="fas fa-edit me-1"></i> Ubah Laporan</button>
                <span id="igd-edit-actions"></span>
                <template id="igd-edit-actions-template">
                    <button id="batalperubahanigd" type="button" class="btn btn-secondary me-2">Batal Ubah</button>
                    <button id="simpanigd" type="button" class="btn btn-success shadow-sm"><i class="fas fa-save me-1"></i> Simpan Perubahan</button>
                </template>
            </div>
        </div>
    </div>
</div>
@else
{{-- Belum dikunjungi: tampilkan form input --}}
<div class="card shadow-sm mb-4 animate-fade-in-up border-left-primary">
    <a href="#collapseIGD" class="d-block card-header collapse-header py-3 collapsed" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseIGD">
        <h6 class="m-0 fw-bold text-dark"><i class="fas fa-ambulance me-2 text-primary"></i> Instalasi Gawat Darurat (IGD)</h6>
    </a>
    <div class="collapse" id="collapseIGD" data-bs-parent="#drafAccordion">
        <div class="card-body bg-light">
            <form method="post" action="{{ route('draftlaporanIGD') }}" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="row">
                    {{-- Total Kunjungan Pasien --}}
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-warning shadow-sm h-100 py-2 pu-stats-card">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-md-9">
                                        <div class="text-xs fw-bold text-uppercase mb-1 text-muted">Total Kunjungan Pasien</div>
                                        <div class="h5 mb-0 fw-bold text-gray-800">
                                            <input type="number" class="form-control" name="igd_pasien" onfocus="igd1a();" onfocusout="igd1b();" autocomplete="off" readonly required/>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <img src="{{asset('sb-admin/icon/general/pasien.png')}}" id="gbr_igd_pasien" class="img-fluid pu-stats-img" alt="Icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Pasien Dirawat --}}
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-warning shadow-sm h-100 py-2 pu-stats-card">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-md-9">
                                        <div class="text-xs fw-bold text-uppercase mb-1 text-muted">Pasien Dirawat</div>
                                        <div class="h5 mb-0 fw-bold text-gray-800">
                                            <input type="number" class="form-control" name="igd_pasien_rawat" onfocus="igd2a();" onfocusout="igd2b();" autocomplete="off" readonly required />
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <img src="{{asset('sb-admin/icon/igd/pasien-dirawat.png')}}" id="gbr_igd_pasien_rawat" class="img-fluid pu-stats-img" alt="Icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Pasien Emergency --}}
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-danger shadow-sm h-100 py-2 pu-stats-card">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-md-9">
                                        <div class="text-xs fw-bold text-uppercase mb-1 text-muted">Pasien Emergency</div>
                                        <div class="h5 mb-0 fw-bold text-gray-800">
                                            <input type="number" class="form-control" name="igd_pasien_emergency" onfocus="igd3a();" onfocusout="igd3b();" autocomplete="off" readonly required />
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <img src="{{asset('sb-admin/icon/igd/pasien-emergency.png')}}" id="gbr_igd_pasien_emergency" class="img-fluid pu-stats-img" alt="Icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Pasien Rujuk & Tolak Rawat --}}
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-danger shadow-sm h-100 py-2 pu-stats-card">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-md-9">
                                        <div class="text-xs fw-bold text-uppercase mb-1 text-muted">Pasien Rujuk & Tolak Rawat</div>
                                        <div class="h5 mb-0 fw-bold text-gray-800">
                                            <input type="number" class="form-control" name="igd_pasien_tidak_rawat" onfocus="igd4a();" onfocusout="igd4b();" autocomplete="off" readonly required />
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <img src="{{asset('sb-admin/icon/igd/pasien-tidak-bisa-dirawat.png')}}" id="gbr_igd_pasien_tidak_rawat" class="img-fluid pu-stats-img" alt="Icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Pasien DOA & Meninggal --}}
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-danger shadow-sm h-100 py-2 pu-stats-card">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-md-9">
                                        <div class="text-xs fw-bold text-uppercase mb-1 text-muted">Pasien DOA & Meninggal</div>
                                        <div class="h5 mb-0 fw-bold text-gray-800">
                                            <input type="number" class="form-control" name="igd_pasien_doa" onfocus="igd5a();" onfocusout="igd5b();" autocomplete="off" readonly required />
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <img src="{{asset('sb-admin/icon/igd/pasien-doa.png')}}" id="gbr_igd_pasien_doa" class="img-fluid pu-stats-img" alt="Icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Rujukan Sisrute --}}
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-warning shadow-sm h-100 py-2 pu-stats-card">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-md-9">
                                        <div class="text-xs fw-bold text-uppercase mb-1 text-muted">Rujukan Sisrute</div>
                                        <div class="h5 mb-0 fw-bold text-gray-800">
                                            <input type="number" class="form-control" name="igd_pasien_sisrute" onfocus="igd6a();" onfocusout="igd6b();" autocomplete="off" readonly required />
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <img src="{{asset('sb-admin/icon/igd/sisrute.png')}}" id="gbr_igd_pasien_sisrute" class="img-fluid pu-stats-img" alt="Icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Rujukan Sisrute Diterima --}}
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-success shadow-sm h-100 py-2 pu-stats-card">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-md-9">
                                        <div class="text-xs fw-bold text-uppercase mb-1 text-muted">Rujukan Sisrute Diterima</div>
                                        <div class="h5 mb-0 fw-bold text-gray-800">
                                            <input type="number" class="form-control" name="igd_pasien_sisrute_diterima" onfocus="igd7a();" onfocusout="igd7b();" autocomplete="off" readonly required />
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <img src="{{asset('sb-admin/icon/igd/sisrute-terima.png')}}" id="gbr_igd_pasien_sisrute_diterima" class="img-fluid pu-stats-img" alt="Icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-4 border rounded shadow-sm">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group shadow-textarea">
                                <label class="fw-bold text-dark"><i class="fas fa-file-alt me-2 text-primary"></i> Alasan pasien rujuk dan tolak rawat</label>
                                <textarea class="form-control z-depth-1" name="igd_alasan" rows="3" placeholder="Belum Ada Data" readonly></textarea>
                            </div>
                            <div class="form-group shadow-textarea">
                                <label class="fw-bold text-dark"><i class="fas fa-exclamation-triangle me-2 text-warning"></i> Permasalahan</label>
                                <textarea class="form-control" name="igd_permasalahan" rows="3" placeholder="Belum Ada Data" readonly></textarea>
                            </div>
                            <div class="form-group shadow-textarea">
                                <label class="fw-bold text-dark"><i class="fas fa-comment-dots me-2 text-info"></i> Lain - lain</label>
                                <textarea class="form-control" name="igd_lainlain" rows="3" placeholder="Belum Ada Data" readonly></textarea>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold text-dark"><i class="fas fa-user-md me-2 text-success"></i> Dokter Jaga</label>
                                <select multiple="multiple" class="form-control select2 @error('igd_dokterjaga') is-invalid @enderror" name="igd_dokterjaga[]" id="igd_dokterjaga_tambah" style="width: 100%" data-placeholder="Belum Ada Data" required>
                                    @foreach($dokters as $dk)
                                    <option value="{{ $dk->id }}" @selected(old('igd_dokterjaga') && in_array($dk->id, old('igd_dokterjaga', [])))>{{ $dk->nama_dokter }}</option>
                                    @endforeach
                                </select>
                                @error('igd_dokterjaga')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <!-- <div class="form-group mt-4 text-end border-top pt-3">
                                <button type="submit" class="btn btn-primary btn-igd px-4 py-2 fw-bold shadow-sm">
                                    <i class="fas fa-save me-2"></i> Simpan ke Draf Laporan
                                </button>
                            </div> -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
