@extends('master.masteradmin')
@section('content')
<?php
    $lastIDLaporan = \App\Models\Laporan::pluck('id')->last();
?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Pengawas Umum Terbaru</h1>
        Tanggal : {{date('d F Y', strtotime(\App\Models\Laporan::pluck('created_at')->last()))}} | Dinas : {{ strtoupper(\App\Models\Dinas::where('id',\App\Models\Laporan::pluck('id_dinas')->last())->pluck('dinas')->first()) }}
    </div>

    <h5 class="mb-4">Pengawas Umum : {{ \App\Models\User::where('id',\App\Models\Laporan::where('id',$lastIDLaporan)->pluck('id_pengawas')->first())->pluck('nama')->first()  }}</h5>
    <!-- Collapsable Card Example -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold ">Laporan Instalasi Gawat Darurat (IGD)</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse show" id="collapseCardExample">
            <div class="card-body">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h5 mb-0 text-gray-800">Total Pasien : {{ \App\Models\Laporanigd::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien')->first() }} orang</h1>

                </div>
                <div class="row ">



                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Dirawat</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Laporanigd::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_rawat')->first() }}</div>
                                    </div>
                                    <div class="col-auto">
                                    <img src="{{asset('sb-admin/icon/warna/igd/pasien-dirawat.png')}}" height="64px" width="64px">
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

                                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Pulang</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Laporanigd::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_pulang')->first() }}</div>
                                    </div>
                                    <div class="col-auto">
                                    <img src="{{asset('sb-admin/icon/warna/igd/pasien-pulang.png')}}" height="64px" width="64px">    
                                  
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

                                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Emergency</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Laporanigd::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_emergency')->first() }}</div>
                                    </div>
                                    <div class="col-auto">
                                    <img src="{{asset('sb-admin/icon/warna/igd/pasien-emergency.png')}}" height="64px" width="64px">
                                       
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

                                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien non Emergency</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Laporanigd::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_non_emergency')->first() }}</div>
                                    </div>
                                    <div class="col-auto">
                                    <img src="{{asset('sb-admin/icon/warna/igd/pasien-non-emergency.png')}}" height="64px" width="64px">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Requests Card Example -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1"> Pasien tidak bisa Dirawat</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Laporanigd::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_tidak_bisa_rawat')->first() }}</div>
                                    </div>
                                    <div class="col-auto">
                                    <img src="{{asset('sb-admin/icon/warna/igd/pasien-tidak-bisa-dirawat.png')}}" height="64px" width="64px">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Requests Card Example -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien death on arrival (DOA)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Laporanigd::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_doa')->first() }}</div>
                                    </div>
                                    <div class="col-auto">
                                    <img src="{{asset('sb-admin/icon/warna/igd/pasien-doa.png')}}" height="64px" width="64px">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Alasan pasien tidak bisa dirawat</label>
                                <textarea class="form-control  z-depth-1" name="igd_alasan" rows="3" placeholder="Tulis disini..." readonly>{{ \App\Models\Laporanigd::where('id_laporan',$lastIDLaporan)->pluck('alasan_tidak_bisa_rawat')->first() }}</textarea>
                            </div>
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Permasalahan</label>
                                <textarea class="form-control" name="igd_permasalahan" rows="3" placeholder="Tulis disini..." readonly>{{ \App\Models\Laporanigd::where('id_laporan',$lastIDLaporan)->pluck('permasalahan')->first() }}</textarea>
                            </div>
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Lain - lain</label>
                                <textarea class="form-control" name="igd_lainlain" rows="3" placeholder="Tulis disini..." readonly>{{ \App\Models\Laporanigd::where('id_laporan',$lastIDLaporan)->pluck('lain_lain')->first() }}</textarea>
                            </div>
                            <div class="form-group">
                                <label style="color:#000;font-weight:600">Dokter Jaga: </label>
                                <select class="form-control" name="igd_dokterjaga" disabled>
                                    <option value="" selected disabled hidden>Pilih Dokter</option>
                                    @foreach(\App\Models\Dokter::where('status',1)->get() as $dk)
                                    @if(\App\Models\Laporanigd::where('id_laporan',$lastIDLaporan)->pluck('id_dokter')->first() == $dk->id) 
                                    <option value="{{ $dk->id }}" selected>{{ $dk->nama_dokter }}</option>
                                    @else
                                    <option value="{{ $dk->id }}">{{ $dk->nama_dokter }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                          
                        </div>
                    </div>
            </div>
        </div>
    </div>





    <!-- Collapsable Card Example -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseCardExample2" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample2">
            <h6 class="m-0 font-weight-bold ">Laporan Umum</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse show" id="collapseCardExample2">
            <div class="card-body">
                
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label style="color:#000;font-weight:600"> Ruangan </label>
                                <select class="form-control select2" name="inap_ruangan" id="inap_ruangan" required>
                                    <option value="" selected disabled hidden>Pilih Ruangan</option>
                                    @foreach(\App\Models\Ruangan::where('status',1)->get() as $dk)
                                    <option value="{{ $dk->id }}">{{ $dk->nama_ruangan }}</option>
                                  
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 tablelaporan">

                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Laporan Umum Semua Ruangan</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        
                                        <th >Ruangan</th>
                                        <th> Lama</th>
                                        <th> Baru</th>
                                        <th> Pindah</th>
                                        <th> Pindahan</th>
                                        <th>Meninggal</th>
                                        <th><b>Total Pasien</b></th>
                                        <th>Catatan Pasien Istimewa</th>
                                        <th>Catatan Pasien Baru</th>
                                        <th>Covid</th>
                                        <th>Suspect Covid</th>
                                        <th>Restrain</th>
                                        <th>Perilaku Kekerasan</th>
                                        <th>Keracunan</th>
                                        <th>Keterbatasan Bahasa</th>
                                        <th>Difabel</th>
                                        <th>Permasalahan Umum</th>
                                    </tr>
                                </thead>
                                
                                <?php
                                $no = 1;
                                ?>
                                <tbody>
                                    @foreach(\App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->get() as $data)
                                    <tr>
                                        
                                        <td>{{ \App\Models\Ruangan::where('id',$data->id_ruangan)->pluck('nama_ruangan')->first()  }}</td>
                                        <th> {{$data->jumlah_pasien_lama}}</th>
                                        <th> {{$data->jumlah_pasien_baru}}</th>
                                        <th> {{$data->jumlah_pasien_pindah}}</th>
                                        <th> {{$data->jumlah_pasien_pindahan}}</th>
                                        <th>{{$data->jumlah_pasien_meninggal}}</th>
                                        <th><b>{{$data->jumlah_total_pasien}}</b></th>
                                        @if($data->catatan_pasien_istimewa)
                                        <th>{{$data->catatan_pasien_istimewa}}</th>
                                        @else
                                        <th>-</th>
                                        @endif
                                        @if($data->catatan_pasien_baru)
                                        <th>{{$data->catatan_pasien_baru}}</th>
                                        @else
                                        <th>-</th>
                                        @endif
                                        <th>{{$data->jumlah_pasien_covid}}</th>
                                        <th>{{$data->jumlah_pasien_suspek_covid}}</th>
                                        <th>{{$data->jumlah_pasien_restrain}}</th>
                                        <th>{{$data->jumlah_pasien_perilaku_kekerasan}}</th>
                                        <th>{{$data->jumlah_pasien_keracunan}}</th>
                                        <th>{{$data->jumlah_pasien_keterbatasan_bahasa}}</th>
                                        <th>{{$data->jumlah_pasien_difabel}}</th>
                                        @if($data->permasalahan_umum)
                                        <th>{{$data->permasalahan_umum}}</th>
                                        @else
                                        <th>-</th>
                                        @endif

                                    </tr>
                                    <?php
                                    $no++;
                                    ?>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>

            </div>
        </div>
    </div>

    


</div>
<!-- /.container-fluid -->



@stop
@section('custom_script')
<script>
$("#inap_ruangan").change(function(){
  
     $(".tablelaporan").html("<h1>Mohon Tunggu...</h1>")
     $.ajax({
       type : "get",
       url : 'refresh-laporan-umum-pu/'+$("#inap_ruangan").val(),
        data: {ruangan: $("#inap_ruangan").val()},
       success : function(data){
         console.log(data);
         $(".tablelaporan").html(data);
       }
     });
   

});

</script>
@stop