<?php
$lastIDLaporan = \App\Models\Laporan::pluck('id')->last();
?>
<!-- Content Row -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h5 mb-0 text-gray-800">Total Pasien : {{ \App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('jumlah_total_pasien')->first() }}</h1>

</div>
<div class="row ">
    <!-- Pending Requests Card Example -->


    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">

            <div class="card-body" onmouseover="ranap1a();" onmouseout="ranap1b();">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Lama</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('jumlah_pasien_lama')->first()}} </div>
                    </div>
                    <div class="col-auto">
                        <img src="{{asset('sb-admin/icon/general/pasien.png')}}" id="gbr_inap_pasien_lama" height="64px" width="64px">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body" onmouseover="ranap2a();" onmouseout="ranap2b();">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Baru</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('jumlah_pasien_baru')->first()}}</div>
                    </div>
                    <div class="col-auto">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-baru.png')}}" id="gbr_inap_pasien_baru" height="64px" width="64px">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body" onmouseover="ranap3a();" onmouseout="ranap3b();">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Pindah (ruangan)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('jumlah_pasien_pindah')->first()}}</div>
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
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body" onmouseover="ranap4a();" onmouseout="ranap4b();">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Pindahan (ruangan)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('jumlah_pasien_pindahan')->first()}}</div>
                    </div>
                    <div class="col-auto">
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
                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Meninggal</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('jumlah_pasien_meninggal')->first()}}</div>
                    </div>
                    <div class="col-auto">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-meninggal.png')}}" id="gbr_inap_pasien_meninggal" height="64px" width="64px">
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
            <textarea class="form-control  z-depth-1" name="inap_catatan_istimewa" rows="3"  readonly>{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('catatan_pasien_istimewa')->first()}}</textarea>
        </div>
        <div class="form-group shadow-textarea">
            <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Catatan pasien baru</label>
            <textarea class="form-control" name="inap_catatan_baru" rows="3"  readonly>{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('catatan_pasien_baru')->first()}}</textarea>
        </div>

    </div>
</div>
<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">

            <div class="card-body" onmouseover="ranap6a();" onmouseout="ranap6b();">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Covid19</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('jumlah_pasien_covid')->first()}}</div>
                    </div>
                    <div class="col-auto">
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
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien suspect Covid19</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('jumlah_pasien_suspek_covid')->first()}}</div>
                    </div>
                    <div class="col-auto">
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
                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien restrain</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('jumlah_pasien_restrain')->first()}}</div>
                    </div>
                    <div class="col-auto">
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
                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Perilaku kekerasan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('jumlah_pasien_perilaku_kekerasan')->first()}}</div>
                    </div>
                    <div class="col-auto">
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
                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Keracunan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('jumlah_pasien_keracunan')->first()}}</div>
                    </div>
                    <div class="col-auto">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-keracunan.png')}}" id="gbr_inap_pasien_keracunan" height="64px" width="64px">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body" onmouseover="ranap11a();" onmouseout="ranap11b();">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Keterbatasan Bahasa</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('jumlah_pasien_keterbatasan_bahasa')->first()}}</div>
                    </div>
                    <div class="col-auto">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-keterbatasan-bahasa.png')}}" id="gbr_inap_pasien_keterbatasan_bahasa" height="64px" width="64px">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body" onmouseover="ranap12a();" onmouseout="ranap12b();">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Difabel</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('jumlah_pasien_difabel')->first()}}</div>
                    </div>
                    <div class="col-auto">
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
            <textarea class="form-control" name="inap_permasalahan" rows="3"  readonly>{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('permasalahan_umum')->first()}}</textarea>
        </div>


    </div>
</div>

<script>
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