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

                <div class="card-body" onmouseover="ranap1a();" onmouseout="ranap1b();">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-10">
                            <div class="text-xs fw-bold  text-uppercase mb-1"> Jumlah Pasien lama <span><a data-bs-toggle="tooltip" data-bs-placement="right" title="Jumlah Pasien Lama Otomatis dari Inputan Dinas Sebelumnya"><i class="fa  fa-exclamation-circle"></i></a></span></div>
                            <div class="h5 mb-0 me-3 fw-bold text-gray-800">
                                <input type="number" class="form-control" name="inap_pasien_lama" id="inap_pasien_lama" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_lama')->first()}}" readonly />
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
</form>

<div class="row">
    <div class="col-lg-12">

        @if(\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('id')->first())
        <div class="form-group">
            <a href="{{ route('deleteDraftlaporanUmum',\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('id')->first()) }}" id="batalumum" style="float:right;" class="btn btn-sm btn-danger my-3 ms-2">Batalkan Laporan</a>
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
        $('.select2').select2();
    });

    $(document).on('click', "#batalumum", function(e) {
        e.preventDefault();
        var href = this.href;
        PUAlert.confirmAction({
            text: 'Apakah Anda yakin ingin membatalkan laporan Umum Ruangan ini?',
            confirmButtonText: 'Ya, batalkan'
        }, function() {
            location.href = href;
        });
    });

    $(document).on('click', "#editumum", function(e) {
        e.preventDefault();
        document.getElementById('umum-edit-actions').innerHTML = document.getElementById('umum-edit-actions-template').innerHTML;
        document.getElementById('batalumum').style.display = 'none';
        $(this).hide();
        document.getElementById("inap_pasien_lama").readOnly = false;
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

            if (a === "" || b === "" || c === "" || d === "" || e === "" || m === "") {
                alert("Lengkapi data jumlah pasien (lama, baru, pindah, pindahan, meninggal, pulang) terlebih dahulu");
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
</script>