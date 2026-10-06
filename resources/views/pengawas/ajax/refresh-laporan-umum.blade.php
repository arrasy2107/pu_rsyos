<input type="hidden" class="form-control" id="ruangan" name="ruangan" value="{{$ruangan}}" />


<form method="post" action="{{ route('editDraftlaporanUmum') }}" id="editdraftumum" role="form">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <h6 style="color:red"><b>Total Pasien ( {{\App\Models\Ruangan::where('id',$ruangan)->pluck('nama_ruangan')->first()}} ) : {{ \App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_total_pasien')->first() }} orang</b></h6>

    <div class="row ">
        <!-- Pending Requests Card Example -->

        <input type="hidden" name="id" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('id')->first()}}">
        <input type="hidden" name="inap_ruangan" value="{{$ruangan}}">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">

                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-10">
                            <div class="text-xs fw-bold  text-uppercase mb-1"> Jumlah Pasien lama <span><a data-bs-toggle="tooltip" data-bs-placement="right" title="Jumlah Pasien Lama Otomatis dari Inputan Dinas Sebelumnya"><i class="fa  fa-exclamation-circle"></i></a></span></div>
                            <div class="h5 mb-0 me-3 fw-bold text-gray-800">
                                <input type="number" class="form-control" name="inap_pasien_lama" id="inap_pasien_lama" autocomplete="off" value="{{ $pasienLama ?? 0 }}" readonly aria-readonly="true" tabindex="-1" />
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
                <div class="card-body" onmouseover="ranap2a();" onmouseout="ranap2b();">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-10">
                            <div class="text-xs fw-bold  text-uppercase mb-1">jumlah Pasien baru</div>
                            <div class="h5 mb-0 me-3  fw-bold text-gray-800">
                                <input type="number" class="form-control" name="inap_pasien_baru" id="inap_pasien_baru" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_baru')->first()}}" readonly />

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
                <div class="card-body" onmouseover="ranap3a();" onmouseout="ranap3b();">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-10">

                            <div class="text-xs fw-bold  text-uppercase mb-1">jumlah Pasien pindah</div>
                            <div class="h5 mb-0 me-3  fw-bold text-gray-800">
                                <input type="number" class="form-control" name="inap_pasien_pindah" id="inap_pasien_pindah" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_pindah')->first()}}" readonly />

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
                <div class="card-body" onmouseover="ranap4a();" onmouseout="ranap4b();">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-10">

                            <div class="text-xs fw-bold  text-uppercase mb-1">jumlah Pasien pindahan</div>
                            <div class="h5 mb-0 me-3  fw-bold text-gray-800">
                                <input type="number" class="form-control" name="inap_pasien_pindahan" id="inap_pasien_pindahan" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_pindahan')->first()}}" readonly />

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
                <div class="card-body" onmouseover="ranap5a();" onmouseout="ranap5b();">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-10">

                            <div class="text-xs fw-bold  text-uppercase mb-1">jumlah Pasien Meninggal</div>
                            <div class="h5 mb-0 me-3  fw-bold text-gray-800">
                                <input type="number" class="form-control" name="inap_pasien_meninggal" id="inap_pasien_meninggal" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_meninggal')->first()}}" readonly />

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
                <div class="card-body" onmouseover="ranap13a();" onmouseout="ranap13b();">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-10">

                            <div class="text-xs fw-bold  text-uppercase mb-1">jumlah Pasien Pulang</div>
                            <div class="h5 mb-0 me-3  fw-bold text-gray-800">
                                <input type="number" class="form-control" name="inap_pasien_pulang" id="inap_pasien_pulang" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_pulang')->first()}}" readonly />

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
                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Catatan pasien istimewa</label>
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
                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Catatan pasien baru</label>
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

                <div class="card-body" onmouseover="ranap6a();" onmouseout="ranap6b();">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-10">
                            <div class="text-xs fw-bold  text-uppercase mb-1"> Jumlah Pasien Covid19</div>
                            <div class="h5 mb-0 me-3 fw-bold text-gray-800">
                                <input type="number" class="form-control" name="inap_pasien_covid" id="inap_pasien_covid" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_covid')->first()}}" readonly />
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
                <div class="card-body" onmouseover="ranap7a();" onmouseout="ranap7b();">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-10">
                            <div class="text-xs fw-bold  text-uppercase mb-1">jumlah Pasien Suspect Covid19</div>
                            <div class="h5 mb-0 me-3  fw-bold text-gray-800">
                                <input type="number" class="form-control" name="inap_pasien_suspect" id="inap_pasien_suspect" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_suspek_covid')->first()}}" readonly />

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
                <div class="card-body" onmouseover="ranap8a();" onmouseout="ranap8b();">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-10">

                            <div class="text-xs fw-bold  text-uppercase mb-1">jumlah Pasien restrain</div>
                            <div class="h5 mb-0 me-3  fw-bold text-gray-800">
                                <input type="number" class="form-control" name="inap_pasien_restrain" id="inap_pasien_restrain" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_restrain')->first()}}" readonly />

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
                <div class="card-body" onmouseover="ranap9a();" onmouseout="ranap9b();">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-10">

                            <div class="text-xs fw-bold  text-uppercase mb-1">jumlah Pasien perilaku kekerasan</div>
                            <div class="h5 mb-0 me-3  fw-bold text-gray-800">
                                <input type="number" class="form-control" name="inap_pasien_kekerasan" id="inap_pasien_kekerasan" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_perilaku_kekerasan')->first()}}" readonly />

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
                <div class="card-body" onmouseover="ranap10a();" onmouseout="ranap10b();">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-10">

                            <div class="text-xs fw-bold  text-uppercase mb-1">jumlah Pasien keracunan</div>
                            <div class="h5 mb-0 me-3  fw-bold text-gray-800">
                                <input type="number" class="form-control" name="inap_pasien_keracunan" id="inap_pasien_keracunan" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_keracunan')->first()}}" readonly />

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
                <div class="card-body" onmouseover="ranap11a();" onmouseout="ranap11b();">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-10">

                            <div class="text-xs fw-bold  text-uppercase mb-1">jumlah Pasien Keterbatasan bahasa</div>
                            <div class="h5 mb-0 me-3  fw-bold text-gray-800">
                                <input type="number" class="form-control" name="inap_pasien_bahasa" id="inap_pasien_bahasa" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_keterbatasan_bahasa')->first()}}" readonly />

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
                <div class="card-body" onmouseover="ranap12a();" onmouseout="ranap12b();">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-10">

                            <div class="text-xs fw-bold  text-uppercase mb-1">jumlah Pasien difabel</div>
                            <div class="h5 mb-0 me-3  fw-bold text-gray-800">
                                <input type="number" class="form-control" name="inap_pasien_difabel" id="inap_pasien_difabel" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_difabel')->first()}}" readonly />

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
                <textarea class="form-control" name="inap_permasalahan" id="inap_permasalahan" rows="3" placeholder="Tulis disini..." readonly>{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('permasalahan_umum')->first()}}</textarea>
            </div>


        </div>
    </div>

    @php
        $draftUmum = \App\Models\Laporanumum::where('status',0)
            ->where('id_ruangan', $ruangan)
            ->where('id_pengawas', \Auth::user()->id)
            ->with(['ruanganPerbantuanMasuk','ruanganPerbantuanKeluar'])
            ->first();
    @endphp

    {{-- ══════════════════════════════════════════════════════ --}}
    {{-- SECTION: DATA PETUGAS (DRAF EDIT)                     --}}
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
                               min="0" value="{{ $draftUmum?->jumlah_petugas ?? 0 }}" required autocomplete="off" readonly>
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
                               min="0" value="{{ $draftUmum?->jumlah_petugas_perbantuan_masuk ?? 0 }}" autocomplete="off" readonly>
                    </div>
                    <select class="form-select form-select-sm" name="inap_asal_perbantuan" id="inap_asal_perbantuan" disabled>
                        <option value="">— Asal Unit (opsional) —</option>
                        @foreach($ruangans->where('id', '!=', $ruangan) as $r)
                            <option value="{{ $r->id }}" {{ ($draftUmum?->id_ruangan_perbantuan_masuk == $r->id) ? 'selected' : '' }}>
                                {{ $r->nama_ruangan }}
                            </option>
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
                               min="0" value="{{ $draftUmum?->jumlah_petugas_perbantuan_keluar ?? 0 }}" autocomplete="off" readonly>
                    </div>
                    <select class="form-select form-select-sm" name="inap_tujuan_perbantuan" id="inap_tujuan_perbantuan" disabled>
                        <option value="">— Tujuan Unit (opsional) —</option>
                        @foreach($ruangans->where('id', '!=', $ruangan) as $r)
                            <option value="{{ $r->id }}" {{ ($draftUmum?->id_ruangan_perbantuan_keluar == $r->id) ? 'selected' : '' }}>
                                {{ $r->nama_ruangan }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text text-danger">Petugas yang dikirim ke unit lain.</div>
                </div>

                {{-- Catatan Petugas --}}
                <div class="col-12">
                    <label class="form-label fw-semibold text-dark">
                        <i class="fas fa-sticky-note me-1 text-warning"></i>Catatan Kondisi SDM
                    </label>
                    <textarea class="form-control" name="inap_catatan_petugas" id="inap_catatan_petugas" rows="2"
                              placeholder="Contoh: 1 petugas dari Laruffa diperbantukan karena lonjakan pasien..." readonly>{{ $draftUmum?->catatan_petugas }}</textarea>
                </div>
            </div>
        </div>
    </div>
</form>


<div class="row">
    <div class="col-lg-12">

        @if(\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('id')->first())
        <div class="form-group">
            <form method="POST" action="{{ route('deleteDraftlaporanUmum',\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('id')->first()) }}" id="batalumum-form" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" id="batalumum" style="float:right;" class="btn btn-sm btn-danger my-3 ms-2">Batalkan Laporan</button>
            </form>
            <button type="button" style="float:right" class="btn btn-sm btn-success my-3" id="editumum">Ubah Laporan</button>

            <span id="umum-edit-actions" style="float:right"></span>
            <template id="umum-edit-actions-template">
                <button type="button" id="batalperubahanumum" class="btn btn-sm btn-danger my-3 ms-2">Batal Ubah</button>
                <button type="button" id="simpanumum" class="btn btn-sm btn-primary my-3">Simpan Perubahan</button>
            </template>
        </div>
        @endif
    </div>
</div>



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
</script>



<script>
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

    $(document).on('click', "#batalumum", function(e) {
        e.preventDefault();
        var form = document.getElementById('batalumum-form');
        PUAlert.confirmAction({
            text: 'Apakah Anda yakin ingin membatalkan laporan Umum Ruangan ini?',
            confirmButtonText: 'Ya, batalkan'
        }, function() {
            form.submit();
        });
    });

    $(document).on('click', "#editumum", function(e) {
        e.preventDefault();
        document.getElementById('umum-edit-actions').innerHTML = document.getElementById('umum-edit-actions-template').innerHTML;
        document.getElementById('batalumum').style.display = 'none';
        $(this).hide();
        document.getElementById("inap_pasien_baru").readOnly = false;
        document.getElementById("inap_pasien_pindah").readOnly = false;
        document.getElementById("inap_pasien_pindahan").readOnly = false;
        document.getElementById("inap_pasien_meninggal").readOnly = false;
        document.getElementById("inap_pasien_pulang").readOnly = false;
        document.getElementById("inap_pasien_covid").readOnly = false;
        document.getElementById("inap_pasien_suspect").readOnly = false;
        document.getElementById("inap_pasien_restrain").readOnly = false;
        document.getElementById("inap_pasien_kekerasan").readOnly = false;
        document.getElementById("inap_pasien_keracunan").readOnly = false;
        document.getElementById("inap_pasien_bahasa").readOnly = false;
        document.getElementById("inap_pasien_difabel").readOnly = false;
        document.getElementById("inap_permasalahan").readOnly = false;

        document.getElementById("inap_jumlah_petugas").readOnly = false;
        document.getElementById("inap_perbantuan_masuk").readOnly = false;
        document.getElementById("inap_perbantuan_keluar").readOnly = false;
        document.getElementById("inap_asal_perbantuan").disabled = false;
        document.getElementById("inap_tujuan_perbantuan").disabled = false;
        document.getElementById("inap_catatan_petugas").readOnly = false;
    });

    $(document).on('click', "#simpanumum", function(e) {
        e.preventDefault();
        PUAlert.confirmAction({
            text: 'Apakah Anda yakin ingin menyimpan perubahan laporan Ruangan Umum ini?',
            icon: 'question',
            confirmButtonText: 'Ya, simpan'
        }, function() {
            var a = $("#inap_pasien_lama").val();
            var b = $("#inap_pasien_baru").val();
            var c = $("#inap_pasien_pindah").val();
            var d = $("#inap_pasien_pindahan").val();
            var e = $("#inap_pasien_meninggal").val();
            var m = $("#inap_pasien_pulang").val();
            var p = $("#inap_jumlah_petugas").val();

            if (a === "" || b === "" || c === "" || d === "" || e === "" || m === "" || p === "") {
                alert("Lengkapi data jumlah pasien (lama, baru, pindah, pindahan, meninggal, pulang) dan petugas terlebih dahulu");
            } else {
                document.getElementById("editdraftumum").submit();
            }
        });
    });

    $(document).on('click', "#batalperubahanumum", function(e) {
        e.preventDefault();
        PUAlert.confirmAction('Apakah Anda yakin ingin membatalkan perubahan laporan Ruangan Umum ini?', function() {
            location.reload();
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
