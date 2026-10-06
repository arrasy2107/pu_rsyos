@section ('custom_style')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Select2 overrides */
    .select2-container .select2-selection--single {
        height: 42px !important;
        border: 1.5px solid var(--color-neutral-300) !important;
        border-radius: var(--radius-md) !important;
        font-family: var(--font-family) !important;
        font-size: var(--font-size-sm) !important;
    }

    .select2-selection__rendered {
        line-height: 40px !important;
        padding-left: 2.5rem !important;
        color: var(--color-neutral-900) !important;
    }

    .select2-selection__arrow {
        height: 40px !important;
    }

    .select2-container--default .select2-selection--single:focus,
    .select2-container--open .select2-selection--single {
        border-color: var(--color-accent) !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
        outline: none !important;
    }

    .select2-dropdown {
        border: 1.5px solid var(--color-neutral-300) !important;
        border-radius: var(--radius-md) !important;
        box-shadow: var(--shadow-md) !important;
        font-family: var(--font-family) !important;
        font-size: var(--font-size-sm) !important;
    }

    .select2-results__options {
        max-height: 260px !important;
        overflow-y: auto !important;
    }
</style>
@stop

<input type="hidden" class="form-control" id="ruangan" name="ruangan" value="{{$ruangan}}" />
<input type="hidden" class="form-control" name="inap_ruangan" value="{{$ruangan}}" />

<div class="row ">
    <!-- Pending Requests Card Example -->


    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">

            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-md-10 jumlahpasienlama">
                        <div class="text-xs fw-bold  text-uppercase mb-1"> Jumlah Pasien lama <span><a data-bs-toggle="tooltip" data-bs-placement="right" title="Jumlah Pasien Lama Otomatis dari Inputan Dinas Sebelumnya"><i class="fa  fa-exclamation-circle"></i></a></span></div>
                        <div class="h5 mb-0 me-3 fw-bold text-gray-800">
                            <input type="number" class="form-control" id="inap_pasien_lama" name="inap_pasien_lama" value="{{ $pasienLama ?? 0 }}" autocomplete="off" readonly aria-readonly="true" tabindex="-1" required />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <img src="{{asset('sb-admin/icon/general/pasien.png')}}" id="gbr_inap_pasien_lama" height="64px" width="64px">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-md-10">
                        <div class="text-xs fw-bold  text-uppercase mb-1">jumlah Pasien baru</div>
                        <div class="h5 mb-0 me-3  fw-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_baru" autocomplete="off" onfocus="ranap2a();" onfocusout="ranap2b();" required />

                        </div>
                    </div>
                    <div class="col-md-2">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-baru.png')}}" id="gbr_inap_pasien_baru" height="64px" width="64px">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-md-10">

                        <div class="text-xs fw-bold  text-uppercase mb-1">jumlah Pasien pindah (ruangan)</div>
                        <div class="h5 mb-0 me-3  fw-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_pindah" autocomplete="off" onfocus="ranap3a();" onfocusout="ranap3b();" required />

                        </div>
                    </div>
                    <div class="col-md-2">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-pindah.png')}}" id="gbr_inap_pasien_pindah" height="64px" width="64px">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-md-10">

                        <div class="text-xs fw-bold  text-uppercase mb-1">jumlah Pasien pindahan (ruangan)</div>
                        <div class="h5 mb-0 me-3  fw-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_pindahan" autocomplete="off" onfocus="ranap4a();" onfocusout="ranap4b();" required />

                        </div>
                    </div>
                    <div class="col-md-2">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-pindahan.png')}}" id="gbr_inap_pasien_pindahan" height="64px" width="64px">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-md-10">

                        <div class="text-xs fw-bold  text-uppercase mb-1">jumlah Pasien Meninggal</div>
                        <div class="h5 mb-0 me-3  fw-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_meninggal" autocomplete="off" onfocus="ranap5a();" onfocusout="ranap5b();" required />

                        </div>
                    </div>
                    <div class="col-md-2">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-meninggal.png')}}" id="gbr_inap_pasien_meninggal" height="64px" width="64px">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-md-10">

                        <div class="text-xs fw-bold  text-uppercase mb-1">jumlah Pasien Pulang</div>
                        <div class="h5 mb-0 me-3  fw-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_pulang" autocomplete="off" onfocus="ranap13a();" onfocusout="ranap13b();" required />

                        </div>
                    </div>
                    <div class="col-md-2">
                        <img src="{{asset('sb-admin/icon/igd/pasien-pulang.png')}}" id="gbr_inap_pasien_pulang" height="64px" width="64px">
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
<div class="row">
    <div class="col-lg-12">
        <div class="form-group shadow-textarea">
            <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Catatan Pasien Istimewa</label>
            <div class="row ">
                <div class="col-lg-12 tableistimewa">
                    <div class="row">
                        <div class="col-md-4">
                            <a class="btn btn-primary btn-md" style="color:white" data-bs-toggle="modal" data-bs-target="#tambahistimewa">Input Catatan</a>
                            <br>
                        </div>
                    </div>
                    <br>
                    @livewire('pengawas.catatan-pasien-istimewa', ['ruangan' => $ruangan])
                </div>

            </div>

        </div>
        <div class="form-group shadow-textarea">
            <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Catatan Pasien Baru</label>
            <div class="row ">
                <div class="col-lg-12 tablebaru">
                    <div class="row">
                        <div class="col-md-4">
                            <a class="btn btn-primary btn-md" style="color:white" data-bs-toggle="modal" data-bs-target="#tambahbaru">Input Catatan</a>
                            <br>
                        </div>
                    </div>
                    <br>
                    @livewire('pengawas.catatan-pasien-baru', ['ruangan' => $ruangan])
                </div>
            </div>
        </div>

    </div>
</div>
<div class="row mt-3">
    <!-- Pending Requests Card Example -->

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-md-10">

                        <div class="text-xs fw-bold  text-uppercase mb-1">jumlah Pasien restrain</div>
                        <div class="h5 mb-0 me-3  fw-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_restrain" autocomplete="off" onfocus="ranap8a();" onfocusout="ranap8b();" min="0" />

                        </div>
                    </div>
                    <div class="col-md-2">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-restrain.png')}}" id="gbr_inap_pasien_restrain" height="64px" width="64px">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-md-10">

                        <div class="text-xs fw-bold  text-uppercase mb-1">jumlah Pasien perilaku kekerasan</div>
                        <div class="h5 mb-0 me-3  fw-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_kekerasan" autocomplete="off" onfocus="ranap9a();" onfocusout="ranap9b();" min="0" />

                        </div>
                    </div>
                    <div class="col-md-2">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-perilaku-kekerasan.png')}}" id="gbr_inap_pasien_perilaku_kekerasan" height="64px" width="64px">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-md-10">

                        <div class="text-xs fw-bold  text-uppercase mb-1">jumlah Pasien keracunan</div>
                        <div class="h5 mb-0 me-3  fw-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_keracunan" autocomplete="off" onfocus="ranap10a();" onfocusout="ranap10b();" min="0" />

                        </div>
                    </div>
                    <div class="col-md-2">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-keracunan.png')}}" id="gbr_inap_pasien_keracunan" height="64px" width="64px">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-md-10">

                        <div class="text-xs fw-bold  text-uppercase mb-1">jumlah Pasien Keterbatasan bahasa</div>
                        <div class="h5 mb-0 me-3  fw-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_bahasa" autocomplete="off" onfocus="ranap11a();" onfocusout="ranap11b();" min="0" />

                        </div>
                    </div>
                    <div class="col-md-2">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-keterbatasan-bahasa.png')}}" id="gbr_inap_pasien_keterbatasan_bahasa" height="64px" width="64px">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-md-10">

                        <div class="text-xs fw-bold  text-uppercase mb-1">jumlah Pasien difabel</div>
                        <div class="h5 mb-0 me-3  fw-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_difabel" autocomplete="off" onfocus="ranap12a();" onfocusout="ranap12b();" min="0" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-difabel.png')}}" id="gbr_inap_pasien_difabel" height="64px" width="64px">
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-lg-12">

        <div class="form-group shadow-textarea">
            <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Permasalahan Umum</label>
            <textarea class="form-control" name="inap_permasalahan" rows="3" placeholder="Tulis disini..."></textarea>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════ --}}
{{-- SECTION: DATA PETUGAS                                 --}}
{{-- ══════════════════════════════════════════════════════ --}}
<div class="card border-0 shadow-sm mt-3 mb-4" style="border-radius:1rem;overflow:hidden;">
    <div class="card-header py-3" style="background:linear-gradient(135deg,#1e3a5f,#2d6a9f);">
        <h6 class="m-0 fw-bold text-white">
            <i class="fas fa-user-nurse me-2"></i>Data Petugas Dinas
        </h6>
    </div>
    <div class="card-body p-4">

        {{-- Preview Rasio --}}
        <div class="rasio-preview-box d-flex align-items-center gap-3 mb-4 p-3 rounded-3" id="rasioPreviewBox"
             style="background:#f0f7ff;border:1.5px solid #bfdbfe;">
            <div class="text-center" style="min-width:80px;">
                <div class="fw-bold" style="font-size:1.5rem;line-height:1;" id="rasioValue">—</div>
                <div class="text-xs text-muted mt-1">Rasio P:Petugas</div>
            </div>
            <div class="vr"></div>
            <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge rounded-pill px-3 py-2" id="rasioLabel" style="font-size:.8rem;background:#6b7280;">Belum Dihitung</span>
                    <small class="text-muted" id="rasioKeterangan">Masukkan jumlah petugas untuk melihat rasio.</small>
                </div>
            </div>
            <div>
                <span class="fw-semibold text-muted" style="font-size:.8rem;">Petugas Efektif:</span>
                <span class="fw-bold ms-1" id="petugasEfektif">0</span>
            </div>
        </div>

        <div class="row g-3">
            {{-- Jumlah Petugas Dinas --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold text-dark">
                    <i class="fas fa-users me-1 text-primary"></i>Jumlah Petugas Dinas
                    <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user-check"></i></span>
                    <input type="number" class="form-control" name="inap_jumlah_petugas" id="inap_jumlah_petugas"
                           min="0" value="0" required autocomplete="off" placeholder="0">
                </div>
                <div class="form-text">Wajib diisi. Min: 0.</div>
            </div>

            {{-- Perbantuan Masuk --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold text-dark">
                    <i class="fas fa-sign-in-alt me-1 text-success"></i>Perbantuan Masuk
                </label>
                <div class="input-group mb-2">
                    <span class="input-group-text bg-success text-dark"><i class="fas fa-plus"></i></span>
                    <input type="number" class="form-control" name="inap_perbantuan_masuk" id="inap_perbantuan_masuk"
                           min="0" value="0" autocomplete="off" placeholder="0">
                </div>
                <select class="form-select form-select-sm" name="inap_asal_perbantuan" id="inap_asal_perbantuan">
                    <option value="">— Asal Unit (opsional) —</option>
                    @foreach($ruangans->where('id', '!=', $ruangan) as $r)
                        <option value="{{ $r->id }}">{{ $r->nama_ruangan }}</option>
                    @endforeach
                </select>
                <div class="form-text text-success">Petugas yang datang dari unit lain.</div>
            </div>

            {{-- Perbantuan Keluar --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold text-dark">
                    <i class="fas fa-sign-out-alt me-1 text-danger"></i>Perbantuan Keluar
                </label>
                <div class="input-group mb-2">
                    <span class="input-group-text bg-danger text-dark"><i class="fas fa-minus"></i></span>
                    <input type="number" class="form-control" name="inap_perbantuan_keluar" id="inap_perbantuan_keluar"
                           min="0" value="0" autocomplete="off" placeholder="0">
                </div>
                <select class="form-select form-select-sm" name="inap_tujuan_perbantuan" id="inap_tujuan_perbantuan">
                    <option value="">— Tujuan Unit (opsional) —</option>
                    @foreach($ruangans->where('id', '!=', $ruangan) as $r)
                        <option value="{{ $r->id }}">{{ $r->nama_ruangan }}</option>
                    @endforeach
                </select>
                <div class="form-text text-danger">Petugas yang dikirim ke unit lain.</div>
            </div>

            {{-- Catatan Petugas --}}
            <div class="col-12">
                <label class="form-label fw-semibold text-dark">
                    <i class="fas fa-sticky-note me-1 text-warning"></i>Catatan Kondisi SDM
                </label>
                <textarea class="form-control" name="inap_catatan_petugas" rows="2"
                          placeholder="Contoh: 1 petugas dari Laruffa diperbantukan karena lonjakan pasien..."></textarea>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <button type="submit" style="float:right" class="btn btn-sm btn-igd btn-primary my-3"><i class="fas fa-save me-2"></i>Simpan ke Draf Laporan</button>
        </div>
    </div>
</div>


@section('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $("#dataTableistimewa").DataTable({
        "pageLength": 5,
        "ordering": false,
        lengthMenu: [
            [5],
            [5]
        ]
    });

    $("#dataTablebaru").DataTable({
        "pageLength": 5,
        "ordering": false,
        lengthMenu: [
            [5],
            [5]
        ]
    });
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.select2').each(function() {
            var $this = $(this);
            var parent = $this.closest('.modal').length ? $this.closest('.modal') : $('body');
            $this.select2({
                dropdownParent: parent
            });
        });
    });

    // ── Rasio Petugas Real-time Calculator ──
    function hitungRasio() {
        var totalPasien = parseInt($('#inap_total_pasien').val()) || 0;
        // total pasien dari field tersembunyi atau dihitung live
        var pasienLama   = parseInt($('[name="inap_pasien_lama"]').val()) || 0;
        var pasienBaru   = parseInt($('[name="inap_pasien_baru"]').val()) || 0;
        var pasienPindah = parseInt($('[name="inap_pasien_pindah"]').val()) || 0;
        var pasienPindahan = parseInt($('[name="inap_pasien_pindahan"]').val()) || 0;
        var pasienPulang = parseInt($('[name="inap_pasien_pulang"]').val()) || 0;
        var pasienMeninggal = parseInt($('[name="inap_pasien_meninggal"]').val()) || 0;
        var totalPasienCalc = (pasienLama + pasienBaru + pasienPindahan) - (pasienPindah + pasienPulang + pasienMeninggal);
        if (totalPasienCalc < 0) totalPasienCalc = 0;

        var petugas       = parseInt($('#inap_jumlah_petugas').val()) || 0;
        var perbantuanMasuk  = parseInt($('#inap_perbantuan_masuk').val()) || 0;
        var perbantuanKeluar = parseInt($('#inap_perbantuan_keluar').val()) || 0;
        var efektif = petugas + perbantuanMasuk - perbantuanKeluar;
        if (efektif < 0) efektif = 0;

        $('#petugasEfektif').text(efektif);

        if (efektif === 0) {
            $('#rasioValue').text('—');
            $('#rasioLabel').text('Belum Dihitung').css('background','#6b7280');
            $('#rasioKeterangan').text('Masukkan jumlah petugas untuk melihat rasio.');
            $('#rasioPreviewBox').css({'background':'#f0f7ff','border-color':'#bfdbfe'});
            return;
        }

        var rasio = totalPasienCalc / efektif;
        $('#rasioValue').text('1 : ' + rasio.toFixed(1));

        if (rasio <= 4) {
            $('#rasioLabel').text('🟢 Optimal').css('background','#16a34a');
            $('#rasioKeterangan').text('Jumlah petugas mencukupi untuk ' + totalPasienCalc + ' pasien.');
            $('#rasioPreviewBox').css({'background':'#f0fdf4','border-color':'#86efac'});
        } else if (rasio <= 7) {
            $('#rasioLabel').text('🟡 Perlu Perhatian').css('background','#d97706');
            $('#rasioKeterangan').text('Pertimbangkan perbantuan — ' + totalPasienCalc + ' pasien, ' + efektif + ' petugas efektif.');
            $('#rasioPreviewBox').css({'background':'#fffbeb','border-color':'#fcd34d'});
        } else {
            $('#rasioLabel').text('🔴 Kritis!').css('background','#dc2626');
            $('#rasioKeterangan').text('Perbantuan wajib dikoordinasikan! ' + totalPasienCalc + ' pasien, hanya ' + efektif + ' petugas efektif.');
            $('#rasioPreviewBox').css({'background':'#fef2f2','border-color':'#fca5a5'});
        }
    }

    $(document).on('input change', '#inap_jumlah_petugas, #inap_perbantuan_masuk, #inap_perbantuan_keluar, [name="inap_pasien_baru"], [name="inap_pasien_pindah"], [name="inap_pasien_pindahan"], [name="inap_pasien_pulang"], [name="inap_pasien_meninggal"]', function() {
        hitungRasio();
    });
    // Hitung awal
    hitungRasio();
</script>
@endsection