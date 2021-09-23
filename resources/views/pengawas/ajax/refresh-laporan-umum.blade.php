

<div class="row ">
    <!-- Pending Requests Card Example -->


    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">

            <div class="card-body" onmouseover="ranap1a();" onmouseout="ranap1b();">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Jumlah Pasien lama</div>
                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_lama" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_lama')->first()}}" readonly />
                        </div>
                    </div>
                    <div class="col-auto">
                        <img src="{{asset('sb-admin/icon/general/pasien.png')}}" id="gbr_inap_pasien_lama" height="64px" width="64px" >
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
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien baru</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_baru" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_baru')->first()}}" readonly />

                        </div>
                    </div>
                    <div class="col-auto">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-baru.png')}}" id="gbr_inap_pasien_baru" height="64px" width="64px" >
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body"  onmouseover="ranap3a();" onmouseout="ranap3b();">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien pindah</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_pindah" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_pindah')->first()}}" readonly />

                        </div>
                    </div>
                    <div class="col-auto">
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
                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien pindahan</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_pindahan" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_pindahan')->first()}}" readonly />

                        </div>
                    </div>
                    <div class="col-auto">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-pindahan.png')}}" id="gbr_inap_pasien_pindahan" height="64px" width="64px" >
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
                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien Meninggal</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_meninggal" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_meninggal')->first()}}" readonly />

                        </div>
                    </div>
                    <div class="col-auto">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-meninggal.png')}}" id="gbr_inap_pasien_meninggal" height="64px" width="64px" >
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
            <textarea class="form-control  z-depth-1" name="inap_catatan_istimewa" rows="3" placeholder="Tulis disini..." readonly>{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('catatan_pasien_istimewa')->first()}}</textarea>
        </div>
        <div class="form-group shadow-textarea">
            <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Catatan pasien baru</label>
            <textarea class="form-control" name="inap_catatan_baru" rows="3" placeholder="Tulis disini..." readonly>{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('catatan_pasien_baru')->first()}}</textarea>
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
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Jumlah Pasien Covid19</div>
                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_covid" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_covid')->first()}}" readonly />
                        </div>
                    </div>
                    <div class="col-auto">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-covid.png')}}" id="gbr_inap_pasien_covid" height="64px" width="64px" >
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
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien Suspect Covid19</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_suspect" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_suspek_covid')->first()}}" readonly />

                        </div>
                    </div>
                    <div class="col-auto">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-suspect-covid.png')}}" id="gbr_inap_pasien_suspek_covid" height="64px" width="64px" >
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
                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien restrain</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_restrain" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_restrain')->first()}}" readonly />

                        </div>
                    </div>
                    <div class="col-auto">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-restrain.png')}}" id="gbr_inap_pasien_restrain" height="64px" width="64px" >
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
                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien perilaku kekerasan</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_kekerasan" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_perilaku_kekerasan')->first()}}" readonly />

                        </div>
                    </div>
                    <div class="col-auto">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-perilaku-kekerasan.png')}}" id="gbr_inap_pasien_perilaku_kekerasan" height="64px" width="64px" >
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
                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien keracunan</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_keracunan" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_keracunan')->first()}}" readonly />

                        </div>
                    </div>
                    <div class="col-auto">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-keracunan.png')}}" id="gbr_inap_pasien_keracunan" height="64px" width="64px" >
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
                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien Keterbatasan bahasa</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_bahasa" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_keterbatasan_bahasa')->first()}}" readonly />

                        </div>
                    </div>
                    <div class="col-auto">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-keterbatasan-bahasa.png')}}" id="gbr_inap_pasien_keterbatasan_bahasa" height="64px" width="64px" >
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
                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien difabel</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_difabel" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_difabel')->first()}}" readonly  />

                        </div>
                    </div>
                    <div class="col-auto">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-difabel.png')}}" id="gbr_inap_pasien_difabel" height="64px" width="64px" >
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
            <textarea class="form-control" name="inap_permasalahan" rows="3" placeholder="Tulis disini..." readonly>{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('permasalahan_umum')->first()}}</textarea>
        </div>

        @if(\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('id')->first())
        <div class="form-group">
            
            <a href="{{ route('deleteDraftlaporanUmum',\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('id')->first()) }}" id="batalumum" style="float:right;" class="btn btn-sm btn-danger my-3 ml-2">Batalkan Laporan</a>
            <button type="submit" style="float:right" class="btn btn-sm btn-edit-igd btn-success my-3" id="editumum" >Ubah Laporan</button>
                                
        </div>
        @endif
    </div>
</div>


<script>
       $("#batalumum").on('click', function(e) {
        var conf = confirm('apakah anda yakin ingin membatalkan laporan Umum Ruangan ini ?');
        if (conf == false) {
            e.preventDefault();
        }
    });


 //RAWAT INAP
    function ranap1a() {
        document.getElementById("gbr_inap_pasien_lama").setAttribute('src', '{{asset('sb-admin/icon/warna/general/pasien.png')}}');
    }

    function ranap1b() {
        document.getElementById("gbr_inap_pasien_lama").setAttribute('src', '{{asset('sb-admin/icon/general/pasien.png')}}');
    }

    function ranap2a() {
        document.getElementById("gbr_inap_pasien_baru").setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-baru.png')}}');
    }

    function ranap2b() {
        document.getElementById("gbr_inap_pasien_baru").setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-baru.png')}}');
    }

    function ranap3a() {
        document.getElementById("gbr_inap_pasien_pindah").setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-pindah.png')}}');
    }

    function ranap3b() {
        document.getElementById("gbr_inap_pasien_pindah").setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-pindah.png')}}');
    }

    function ranap4a() {
        document.getElementById("gbr_inap_pasien_pindahan").setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-pindahan.png')}}');
    }

    function ranap4b() {
        document.getElementById("gbr_inap_pasien_pindahan").setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-pindahan.png')}}');
    }

    function ranap5a() {
        document.getElementById("gbr_inap_pasien_meninggal").setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-meninggal.png')}}');
    }

    function ranap5b() {
        document.getElementById("gbr_inap_pasien_meninggal").setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-meninggal.png')}}');
    }

    function ranap6a() {
        document.getElementById("gbr_inap_pasien_covid").setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-covid.png')}}');
    }

    function ranap6b() {
        document.getElementById("gbr_inap_pasien_covid").setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-covid.png')}}');
    }

    function ranap7a() {
        document.getElementById("gbr_inap_pasien_suspek_covid").setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-suspect-covid.png')}}');
    }

    function ranap7b() {
        document.getElementById("gbr_inap_pasien_suspek_covid").setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-suspect-covid.png')}}');
    }

    function ranap8a() {
        document.getElementById("gbr_inap_pasien_restrain").setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-restrain.png')}}');
    }

    function ranap8b() {
        document.getElementById("gbr_inap_pasien_restrain").setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-restrain.png')}}');
    }

    function ranap9a() {
        document.getElementById("gbr_inap_pasien_perilaku_kekerasan").setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-perilaku-kekerasan.png')}}');
    }

    function ranap9b() {
        document.getElementById("gbr_inap_pasien_perilaku_kekerasan").setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-perilaku-kekerasan.png')}}');
    }

    function ranap10a() {
        document.getElementById("gbr_inap_pasien_keracunan").setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-keracunan.png')}}');
    }

    function ranap10b() {
        document.getElementById("gbr_inap_pasien_keracunan").setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-keracunan.png')}}');
    }

    function ranap11a() {
        document.getElementById("gbr_inap_pasien_keterbatasan_bahasa").setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-keterbatasan-bahasa.png')}}');
    }

    function ranap11b() {
        document.getElementById("gbr_inap_pasien_keterbatasan_bahasa").setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-keterbatasan-bahasa.png')}}');
    }

    function ranap12a() {
        document.getElementById("gbr_inap_pasien_difabel").setAttribute('src', '{{asset('sb-admin/icon/warna/ranap/pasien-difabel.png')}}');
    }

    function ranap12b() {
        document.getElementById("gbr_inap_pasien_difabel").setAttribute('src', '{{asset('sb-admin/icon/ranap/pasien-difabel.png')}}');
    }
</script>




