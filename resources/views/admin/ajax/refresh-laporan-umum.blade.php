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

                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Lama</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('jumlah_pasien_lama')->first()}} </div>
                                    </div>
                                    <div class="col-auto">
                                    <img src="{{asset('sb-admin/icon/warna/general/pasien.png')}}" height="64px" width="64px">
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
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Baru</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('jumlah_pasien_baru')->first()}}</div>
                                    </div>
                                    <div class="col-auto">
                                    <img src="{{asset('sb-admin/icon/warna/ranap/pasien-baru.png')}}" height="64px" width="64px">
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
                                    <div class="col mr-2">

                                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Pindah</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('jumlah_pasien_pindah')->first()}}</div>
                                    </div>
                                    <div class="col-auto">
                                    <img src="{{asset('sb-admin/icon/warna/ranap/pasien-pindah.png')}}" height="64px" width="64px">
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
                                    <div class="col mr-2">

                                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Pindahan</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('jumlah_pasien_pindahan')->first()}}</div>
                                    </div>
                                    <div class="col-auto">
                                    <img src="{{asset('sb-admin/icon/warna/ranap/pasien-pindahan.png')}}" height="64px" width="64px">
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
                                    <div class="col mr-2">

                                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Meninggal</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('jumlah_pasien_meninggal')->first()}}</div>
                                    </div>
                                    <div class="col-auto">
                                    <img src="{{asset('sb-admin/icon/warna/ranap/pasien-meninggal.png')}}" height="64px" width="64px">
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
                            <textarea class="form-control  z-depth-1" name="inap_catatan_istimewa" rows="3" placeholder="Tulis disini..." readonly>{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('catatan_pasien_istimewa')->first()}}</textarea>
                        </div>
                        <div class="form-group shadow-textarea">
                            <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Catatan pasien baru</label>
                            <textarea class="form-control" name="inap_catatan_baru" rows="3" placeholder="Tulis disini..." readonly>{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('catatan_pasien_baru')->first()}}</textarea>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">

                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Covid19</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('jumlah_pasien_covid')->first()}}</div>
                                    </div>
                                    <div class="col-auto">
                                    <img src="{{asset('sb-admin/icon/warna/ranap/pasien-covid.png')}}" height="64px" width="64px">
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
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien suspect Covid19</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('jumlah_pasien_suspek_covid')->first()}}</div>
                                    </div>
                                    <div class="col-auto">
                                    <img src="{{asset('sb-admin/icon/warna/ranap/pasien-suspect-covid.png')}}" height="64px" width="64px">
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
                                    <div class="col mr-2">

                                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien restrain</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('jumlah_pasien_restrain')->first()}}</div>
                                    </div>
                                    <div class="col-auto">
                                    <img src="{{asset('sb-admin/icon/warna/ranap/pasien-restrain.png')}}" height="64px" width="64px">
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
                                    <div class="col mr-2">

                                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Perilaku kekerasan</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('jumlah_pasien_perilaku_kekerasan')->first()}}</div>
                                    </div>
                                    <div class="col-auto">
                                    <img src="{{asset('sb-admin/icon/warna/ranap/pasien-perilaku-kekerasan.png')}}" height="64px" width="64px">
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
                                    <div class="col mr-2">

                                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Keracunan</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('jumlah_pasien_keracunan')->first()}}</div>
                                    </div>
                                    <div class="col-auto">
                                    <img src="{{asset('sb-admin/icon/warna/ranap/pasien-keracunan.png')}}" height="64px" width="64px">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Requests Card Example -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Keterbatasan Bahasa</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('jumlah_pasien_keterbatasan_bahasa')->first()}}</div>
                                    </div>
                                    <div class="col-auto">
                                    <img src="{{asset('sb-admin/icon/warna/ranap/pasien-keterbatasan-bahasa.png')}}" height="64px" width="64px">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Requests Card Example -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Difabel</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('jumlah_pasien_difabel')->first()}}</div>
                                    </div>
                                    <div class="col-auto">
                                    <img src="{{asset('sb-admin/icon/warna/ranap/pasien-difabel.png')}}" height="64px" width="64px">
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
                            <textarea class="form-control" name="inap_permasalahan" rows="3" placeholder="Tulis disini..." readonly>{{\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->where('id_ruangan',$ruangan)->pluck('permasalahan_umum')->first()}}</textarea>
                        </div>

                    
                    </div>
                </div>