@php
$ruanganId = $ruangan;
$ruanganNama = \App\Models\Ruangan::where('id', $ruanganId)->value('nama_ruangan');
$laporan = \App\Models\Laporanumum::where('status', 0)
->where('id_ruangan', $ruanganId)
->where('id_pengawas', auth()->id())
->first();
@endphp

@if($ruanganId)
<input type="hidden" class="form-control" id="ruangan" name="ruangan" value="{{ $ruanganId }}" />

<form method="post" action="{{ route('editDraftlaporanUmum') }}" id="editdraftumum" role="form">
    {{ csrf_field() }}
    {{ method_field('PUT') }}

    <h6 style="color:red"><b>Total Pasien ( {{ $ruanganNama }} ) : {{ optional($laporan)->jumlah_total_pasien ?? 0 }} orang</b></h6>

    <div class="row">
        <input type="hidden" name="id" value="{{ optional($laporan)->id }}">
        <input type="hidden" name="inap_ruangan" value="{{ $ruanganId }}">

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-10">
                            <div class="text-xs fw-bold text-uppercase mb-1">Jumlah Pasien Lama</div>
                            <div class="h5 mb-0 me-3 fw-bold text-gray-800">
                                <input type="number" class="form-control" name="inap_pasien_lama" id="inap_pasien_lama" autocomplete="off" value="{{ $pasienLama ?? 0 }}" readonly aria-readonly="true" tabindex="-1" />
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <img src="{{ asset('sb-admin/icon/general/pasien.png') }}" id="gbr_inap_pasien_lama" height="64px" width="64px">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-10">
                            <div class="text-xs fw-bold text-uppercase mb-1">Jumlah Pasien Baru</div>
                            <div class="h5 mb-0 me-3 fw-bold text-gray-800">
                                <input type="number" class="form-control" name="inap_pasien_baru" id="inap_pasien_baru" autocomplete="off" value="{{ optional($laporan)->jumlah_pasien_baru ?? 0 }}" readonly />
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <img src="{{ asset('sb-admin/icon/ranap/pasien-baru.png') }}" id="gbr_inap_pasien_baru" height="64px" width="64px">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-10">
                            <div class="text-xs fw-bold text-uppercase mb-1">Jumlah Pasien Pindah</div>
                            <div class="h5 mb-0 me-3 fw-bold text-gray-800">
                                <input type="number" class="form-control" name="inap_pasien_pindah" id="inap_pasien_pindah" autocomplete="off" value="{{ optional($laporan)->jumlah_pasien_pindah ?? 0 }}" readonly />
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <img src="{{ asset('sb-admin/icon/ranap/pasien-pindah.png') }}" id="gbr_inap_pasien_pindah" height="64px" width="64px">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-10">
                            <div class="text-xs fw-bold text-uppercase mb-1">Jumlah Pasien Pindahan</div>
                            <div class="h5 mb-0 me-3 fw-bold text-gray-800">
                                <input type="number" class="form-control" name="inap_pasien_pindahan" id="inap_pasien_pindahan" autocomplete="off" value="{{ optional($laporan)->jumlah_pasien_pindahan ?? 0 }}" readonly />
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <img src="{{ asset('sb-admin/icon/ranap/pasien-pindahan.png') }}" id="gbr_inap_pasien_pindahan" height="64px" width="64px">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-10">
                            <div class="text-xs fw-bold text-uppercase mb-1">Jumlah Pasien Meninggal</div>
                            <div class="h5 mb-0 me-3 fw-bold text-gray-800">
                                <input type="number" class="form-control" name="inap_pasien_meninggal" id="inap_pasien_meninggal" autocomplete="off" value="{{ optional($laporan)->jumlah_pasien_meninggal ?? 0 }}" readonly />
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <img src="{{ asset('sb-admin/icon/ranap/pasien-meninggal.png') }}" id="gbr_inap_pasien_meninggal" height="64px" width="64px">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-10">
                            <div class="text-xs fw-bold text-uppercase mb-1">Jumlah Pasien Pulang</div>
                            <div class="h5 mb-0 me-3 fw-bold text-gray-800">
                                <input type="number" class="form-control" name="inap_pasien_pulang" id="inap_pasien_pulang" autocomplete="off" value="{{ optional($laporan)->jumlah_pasien_pulang ?? 0 }}" readonly />
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <img src="{{ asset('sb-admin/icon/igd/pasien-pulang.png') }}" id="gbr_inap_pasien_pulang" height="64px" width="64px">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@else
<div class="text-center py-4 text-muted border border-dashed rounded bg-white">
    <i class="fas fa-hand-pointer fa-2x mb-3 text-gray-300"></i>
    <p class="mb-0">Pilih ruangan dari dropdown di atas untuk mengisi laporan form.</p>
</div>
@endif