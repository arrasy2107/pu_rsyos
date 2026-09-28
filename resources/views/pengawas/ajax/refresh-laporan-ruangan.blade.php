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
                        <div class="text-xs fw-bold  text-uppercase mb-1"> Jumlah Pasien Covid19</div>
                        <div class="h5 mb-0 me-3 fw-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_covid" autocomplete="off" onfocus="ranap6a();" onfocusout="ranap6b();" min="0" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-covid.png')}}" id="gbr_inap_pasien_covid" height="64px" width="64px">
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
                        <div class="text-xs fw-bold  text-uppercase mb-1">jumlah Pasien Suspect Covid19</div>
                        <div class="h5 mb-0 me-3  fw-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_suspect" autocomplete="off" onfocus="ranap7a();" onfocusout="ranap7b();" min="0" />

                        </div>
                    </div>
                    <div class="col-md-2">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-suspect-covid.png')}}" id="gbr_inap_pasien_suspek_covid" height="64px" width="64px">
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
        $('.select2').select2();
    });
</script>
@endsection