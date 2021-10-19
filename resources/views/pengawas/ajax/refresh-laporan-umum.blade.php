
<form method="post" action="{{ route('editDraftlaporanUmum') }}" id="editdraftumum" role="form">
{{ csrf_field() }}
{{ method_field('PUT') }}
<div class="row ">
    <!-- Pending Requests Card Example -->

    <input type="hidden"  name="id" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('id')->first()}}">
    <input type="hidden"  name="inap_ruangan" value="{{$ruangan}}">
                 
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">

            <div class="card-body" onmouseover="ranap1a();" onmouseout="ranap1b();">
                <div class="row no-gutters align-items-center">
                    <div class="col-md-10">
                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Jumlah Pasien lama</div>
                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_lama" id="inap_pasien_lama" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_lama')->first()}}" readonly />
                        </div>
                    </div>
                    <div class="col-md-2">
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
                    <div class="col-md-10">
                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien baru</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_baru" id="inap_pasien_baru"  autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_baru')->first()}}" readonly />

                        </div>
                    </div>
                    <div class="col-md-2">
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
                    <div class="col-md-10">

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien pindah</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
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

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien pindahan</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_pindahan" id="inap_pasien_pindahan" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_pindahan')->first()}}" readonly />

                        </div>
                    </div>
                    <div class="col-md-2">
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
                    <div class="col-md-10">

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien Meninggal</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_meninggal" id="inap_pasien_meninggal" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_meninggal')->first()}}" readonly />

                        </div>
                    </div>
                    <div class="col-md-2">
                        <img src="{{asset('sb-admin/icon/ranap/pasien-meninggal.png')}}" id="gbr_inap_pasien_meninggal" height="64px" width="64px" >
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

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien Pulang</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_pulang" id="inap_pasien_pulang" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_pulang')->first()}}" readonly />

                        </div>
                    </div>
                    <div class="col-md-2">
                        <img src="{{asset('sb-admin/icon/igd/pasien-pulang.png')}}" id="gbr_inap_pasien_pulang" height="64px" width="64px" >
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
            <textarea class="form-control  z-depth-1" name="inap_catatan_istimewa" id="inap_catatan_istimewa" rows="3" placeholder="Tulis disini..." readonly>{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('catatan_pasien_istimewa')->first()}}</textarea>
        </div>
        <div class="form-group shadow-textarea">
            <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Catatan pasien baru</label>
            <textarea class="form-control" name="inap_catatan_baru" id="inap_catatan_baru" rows="3" placeholder="Tulis disini..." readonly>{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('catatan_pasien_baru')->first()}}</textarea>
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
                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Jumlah Pasien Covid19</div>
                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_covid" id="inap_pasien_covid" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_covid')->first()}}" readonly />
                        </div>
                    </div>
                    <div class="col-md-2">
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
                    <div class="col-md-10">
                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien Suspect Covid19</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_suspect" id="inap_pasien_suspect" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_suspek_covid')->first()}}" readonly />

                        </div>
                    </div>
                    <div class="col-md-2">
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
                    <div class="col-md-10">

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien restrain</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_restrain" id="inap_pasien_restrain" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_restrain')->first()}}" readonly />

                        </div>
                    </div>
                    <div class="col-md-2">
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
                    <div class="col-md-10">

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien perilaku kekerasan</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_kekerasan" id="inap_pasien_kekerasan" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_perilaku_kekerasan')->first()}}" readonly />

                        </div>
                    </div>
                    <div class="col-md-2">
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
                    <div class="col-md-10">

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien keracunan</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_keracunan" id="inap_pasien_keracunan" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_keracunan')->first()}}" readonly />

                        </div>
                    </div>
                    <div class="col-md-2">
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
                    <div class="col-md-10">

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien Keterbatasan bahasa</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_bahasa" id="inap_pasien_bahasa" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_keterbatasan_bahasa')->first()}}" readonly />

                        </div>
                    </div>
                    <div class="col-md-2">
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
                    <div class="col-md-10">

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien difabel</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_difabel" id="inap_pasien_difabel" autocomplete="off" value="{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('jumlah_pasien_difabel')->first()}}" readonly  />

                        </div>
                    </div>
                    <div class="col-md-2">
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
            <textarea class="form-control" name="inap_permasalahan" id="inap_permasalahan" rows="3" placeholder="Tulis disini..." readonly>{{\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('permasalahan_umum')->first()}}</textarea>
        </div>
        
      
    </div>
</div>
</form>
<div class="row">
    <div class="col-lg-12">

        @if(\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('id')->first())
        <div class="form-group">
            
            <a href="{{ route('deleteDraftlaporanUmum',\App\Models\Laporanumum::where('status',0)->where('id_ruangan',$ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('id')->first()) }}" id="batalumum" style="float:right;" class="btn btn-sm btn-danger my-3 ml-2">Batalkan Laporan</a>
            <button type="submit" style="float:right" class="btn btn-sm btn-edit-igd btn-success my-3" id="editumum" >Ubah Laporan</button>
            <button style="float:right;display:none" id="batalperubahanumum"  class="btn btn-sm btn-edit-igd btn-danger my-3 ml-2" >Batalkan Perubahan</button>
            <button style="float:right;display:none" id="simpanumum"  class="btn btn-sm btn-edit-igd btn-primary my-3" >Simpan Laporan</button>           
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

    $("#editumum").on('click', function(e) {
        document.getElementById('simpanumum').style.display = 'block'; 
        document.getElementById('batalperubahanumum').style.display = 'block'; 
        document.getElementById('batalumum').style.display = 'none'; 
        this.style.display = 'none';
        document.getElementById("inap_pasien_lama").readOnly = false;
        document.getElementById("inap_pasien_baru").readOnly = false;
        document.getElementById("inap_pasien_pindah").readOnly = false;
        document.getElementById("inap_pasien_pindahan").readOnly = false;
        document.getElementById("inap_pasien_meninggal").readOnly = false;
        document.getElementById("inap_pasien_pulang").readOnly = false;
        document.getElementById("inap_catatan_istimewa").readOnly = false;
        document.getElementById("inap_catatan_baru").readOnly = false;
        document.getElementById("inap_pasien_covid").readOnly = false;
        document.getElementById("inap_pasien_suspect").readOnly = false;
        document.getElementById("inap_pasien_restrain").readOnly = false;
        document.getElementById("inap_pasien_kekerasan").readOnly = false;
        document.getElementById("inap_pasien_keracunan").readOnly = false;
        document.getElementById("inap_pasien_bahasa").readOnly = false;
        document.getElementById("inap_pasien_difabel").readOnly = false;
        document.getElementById("inap_permasalahan").readOnly = false;
        
    });

    $("#simpanumum").on('click', function(e) {
        var conf = confirm('apakah anda yakin ingin menyimpan perubahan laporan Ruangan Umum ini ?');
        if (conf == false) {
            e.preventDefault();
        }
        else{

            a = $("#inap_pasien_lama").val();
            b = $("#inap_pasien_baru").val();
            c = $("#inap_pasien_pindah").val();
            d = $("#inap_pasien_pindahan").val();
            e = $("#inap_pasien_meninggal").val();
    
            f = $("#inap_pasien_covid").val();
            g = $("#inap_pasien_suspect").val();
            h = $("#inap_pasien_restrain").val();
            i = $("#inap_pasien_kekerasan").val();
            j = $("#inap_pasien_keracunan").val();
            k = $("#inap_pasien_bahasa").val();
            l = $("#inap_pasien_difabel").val();


            if (a == "" || b == "" || c == "" || d == "" || e == "" || f == "" || g == "" || h == "" || i == "" || j == "" || k == "" || l == "" ) {
            alert("lengkapi data terlebih dahulu");
            
            }
            else{
            document.getElementById("editdraftumum").submit();
            e.preventDefault();
            }
        }
    });
    $("#batalperubahanumum").on('click', function(e) {
        var conf = confirm('apakah anda yakin ingin membatalkan perubahan laporan Ruangan Umum ini ?');
        if (conf == false) {
            e.preventDefault();
        }
        else{
            location.reload();

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
    function ranap13a() {
        document.getElementById("gbr_inap_pasien_pulang").setAttribute('src', '{{asset('sb-admin/icon/warna/igd/pasien-pulang.png')}}');
    }

    function ranap13b() {
        document.getElementById("gbr_inap_pasien_pulang").setAttribute('src', '{{asset('sb-admin/icon/igd/pasien-pulang.png')}}');
    }
</script>




