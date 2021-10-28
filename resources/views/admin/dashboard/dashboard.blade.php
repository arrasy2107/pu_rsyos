@extends('master.masteradmin')
@section('custom_style')
<link href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/fixedcolumns/3.3.3/css/fixedColumns.dataTables.min.css" rel="stylesheet">
<style>
 th{
        background-color:slategrey;
        color:white;
        white-space: nowrap;
    }
    .dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody {
  overflow-x: scroll !important;
}
.dataTables_scrollBody {
    overflow-x: scroll !important;
}
</style>
@stop 
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
                    
                    <h6 style="color:red"><b>Total Pasien (IGD) : {{ \App\Models\Laporanigd::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien')->first() }} orang</b></h6>

                </div>
                <div class="row ">



                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body" onmouseover="igd1a()" onmouseout="igd1b()">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Dirawat</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Laporanigd::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_rawat')->first() }}</div>
                                    </div>
                                    <div class="col-auto">
                                    <img src="{{asset('sb-admin/icon/igd/pasien-dirawat.png')}}" id="gbr_igd_pasien"  height="64px" width="64px">
                                       </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body" onmouseover="igd2a()" onmouseout="igd2b()">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">

                                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Pulang</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Laporanigd::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_pulang')->first() }}</div>
                                    </div>
                                    <div class="col-auto">
                                    <img src="{{asset('sb-admin/icon/igd/pasien-pulang.png')}}" id="gbr_igd_pasien_pulang"  height="64px" width="64px">    
                                  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body" onmouseover="igd3a()" onmouseout="igd3b()">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">

                                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien Emergency</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Laporanigd::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_emergency')->first() }}</div>
                                    </div>
                                    <div class="col-auto">
                                    <img src="{{asset('sb-admin/icon/igd/pasien-emergency.png')}}" id="gbr_igd_pasien_emergency"  height="64px" width="64px">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body" onmouseover="igd4a()" onmouseout="igd4b()">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">

                                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien non Emergency</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Laporanigd::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_non_emergency')->first() }}</div>
                                    </div>
                                    <div class="col-auto">
                                    <img src="{{asset('sb-admin/icon/igd/pasien-non-emergency.png')}}" id="gbr_igd_pasien_non_emergency"  height="64px" width="64px">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Requests Card Example -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body" onmouseover="igd5a()" onmouseout="igd5b()">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1"> Pasien pasien rujuk dan tolak rawat</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Laporanigd::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_tidak_bisa_rawat')->first() }}</div>
                                    </div>
                                    <div class="col-auto">
                                    <img src="{{asset('sb-admin/icon/igd/pasien-tidak-bisa-dirawat.png')}}" id="gbr_igd_pasien_tidak_rawat" height="64px" width="64px">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Requests Card Example -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body" onmouseover="igd6a()" onmouseout="igd6b()">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Pasien "DOA" dan pasien meninggal</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Laporanigd::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_doa')->first() }}</div>
                                    </div>
                                    <div class="col-auto">
                                    <img src="{{asset('sb-admin/icon/igd/pasien-doa.png')}}" id="gbr_igd_pasien_doa" height="64px" width="64px">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body" onmouseover="igd7a();" onmouseout="igd7b();">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Rujukan Sisrute</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Laporanigd::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_sisrute')->first() }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/igd/sisrute.png')}}" id="gbr_igd_pasien_sisrute" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body" onmouseover="igd8a();" onmouseout="igd8b();">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Rujukan Sisrute yang diterima</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Laporanigd::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_sisrute_diterima')->first() }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/igd/sisrute-terima.png')}}" id="gbr_igd_pasien_sisrute_diterima" height="64px" width="64px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body" onmouseover="igd9a();" onmouseout="igd9b();">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Rujukan Sisrute yang ditolak</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Laporanigd::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_sisrute_ditolak')->first() }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{asset('sb-admin/icon/igd/sisrute-tolak.png')}}" id="gbr_igd_pasien_sisrute_ditolak" height="64px" width="64px">
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
                                <textarea class="form-control  z-depth-1" name="igd_alasan" rows="3"  readonly>{{ \App\Models\Laporanigd::where('id_laporan',$lastIDLaporan)->pluck('alasan_tidak_bisa_rawat')->first() }}</textarea>
                            </div>
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Permasalahan</label>
                                <textarea class="form-control" name="igd_permasalahan" rows="3"  readonly>{{ \App\Models\Laporanigd::where('id_laporan',$lastIDLaporan)->pluck('permasalahan')->first() }}</textarea>
                            </div>
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Lain - lain</label>
                                <textarea class="form-control" name="igd_lainlain" rows="3"  readonly>{{ \App\Models\Laporanigd::where('id_laporan',$lastIDLaporan)->pluck('lain_lain')->first() }}</textarea>
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
            <h6 class="m-0 font-weight-bold ">Laporan Umum / Ruangan</h6>
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
                            <h6 style="color:red"><b>Total Pasien (Ruangan) : {{ \App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->pluck('jumlah_total_pasien')->sum() }} orang</b></h6>

                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTableRuangan" width="100%" cellspacing="0">
                                <thead>
                                    <tr style="background-color:green;color:white">

                                        <th >TOTAL</th>
                                        <th >{{ \App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_lama')->sum() }}</th>
                                        <th> {{ \App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_baru')->sum() }}</th>
                                        <th> {{ \App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_pindah')->sum() }}</th>
                                        <th> {{ \App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_pindahan')->sum() }}</th>
                                        <th>{{ \App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_meninggal')->sum() }}</th>
                                        <th>{{ \App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_pulang')->sum() }}</th>

                                        <th><b>{{ \App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->pluck('jumlah_total_pasien')->sum() }}</b></th>

                                        <th>-</th>
                                        <th>-</th>
                                        <th>{{ \App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_covid')->sum() }}</th>
                                        <th>{{ \App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_suspek_covid')->sum() }}</th>
                                        <th>{{ \App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_restrain')->sum() }}</th>
                                        <th>{{ \App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_perilaku_kekerasan')->sum() }}</th>
                                        <th>{{ \App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_keracunan')->sum() }}</th>
                                        <th>{{ \App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_keterbatasan_bahasa')->sum() }}</th>
                                        <th>{{ \App\Models\Laporanumum::where('id_laporan',$lastIDLaporan)->pluck('jumlah_pasien_difabel')->sum() }}</th>
                                        <th>-</th>
                                    </tr>
                                    <tr>
                                        
                                        <th >Ruangan</th>
                                        <th> Lama</th>
                                        <th> Baru</th>
                                        
                                        <th> Pindah</th>
                                        <th> Pindahan</th>
                                        <th>Meninggal</th>
                                        <th>Pulang</th>
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
                                        
                                        <td style="white-space: nowrap;word-wrap: break-word;">{{ \App\Models\Ruangan::where('id',$data->id_ruangan)->pluck('nama_ruangan')->first()  }}</td>
                                        <td> {{$data->jumlah_pasien_lama}}</td>
                                        <td> {{$data->jumlah_pasien_baru}}</td>
                                        
                                        <td> {{$data->jumlah_pasien_pindah}}</td>
                                        <td> {{$data->jumlah_pasien_pindahan}}</td>
                                        <td>{{$data->jumlah_pasien_meninggal}}</td>
                                        <td>{{$data->jumlah_pasien_pulang}}</td>
                                        <td><b>{{$data->jumlah_total_pasien}}</b></td>

                                        @if(\App\Models\Catatanpasien::where('id_laporan_umum',$data->id)->where('id_ruangan',$data->id_ruangan)->where('id_jenis_pasien',1)->first())
                                        <td><a href="#" data-id="{{ $data->id }}"  data-ruangan="{{$data->id_ruangan}}" class="btn-istimewa" data-toggle="modal" data-target="#istimewa" >Lihat</a></td>
                                        @else
                                        <td>-</td>
                                        @endif

                                        @if(\App\Models\Catatanpasien::where('id_laporan_umum',$data->id)->where('id_ruangan',$data->id_ruangan)->where('id_jenis_pasien',2)->first())
                                        <td><a href="#" data-id="{{ $data->id }}"  data-ruangan="{{$data->id_ruangan}}" class="btn-baru" data-toggle="modal" data-target="#baru" >Lihat</a></td>
                                        @else
                                        <td>-</td>
                                        @endif

                                        <td>{{$data->jumlah_pasien_covid}}</td>
                                        <td>{{$data->jumlah_pasien_suspek_covid}}</td>
                                        <td>{{$data->jumlah_pasien_restrain}}</td>
                                        <td>{{$data->jumlah_pasien_perilaku_kekerasan}}</td>
                                        <td>{{$data->jumlah_pasien_keracunan}}</td>
                                        <td>{{$data->jumlah_pasien_keterbatasan_bahasa}}</td>
                                        <td>{{$data->jumlah_pasien_difabel}}</td>
                                        @if($data->permasalahan_umum)
                                        <td><a href="#" data-id="{{ $data->id }}" data-ruangan="{{$data->id_ruangan}}"  class="btn-permasalahan" data-toggle="modal" data-target="#permasalahan" >Lihat</a></td>
                                        @else
                                        <td>-</td>
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

<!-- IBS -->
   <!-- Collapsable Card Example -->
   <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseIBS" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseIBS">
            <h6 class="m-0 font-weight-bold ">Instalasi Bedah Sentral (IBS)</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse show" id="collapseIBS">
            <div class="card-body">
                <!-- Content Row -->
                
                    <div class="row ">
                        <div class="col-lg-12 tableketerangan">
                        <?php
                            $getIDibs = \App\Models\Laporanibs::where('id_laporan',$lastIDLaporan)->pluck('id')->first();
                        ?>
                        @if($getIDibs)
                        <h6 style="color:red"><b>Total Pasien (IBS) : {{ \App\Models\Laporanibs::where('id_laporan',$lastIDLaporan)->pluck('total_pasien')->first() }} orang</b></h6>
                        @else
                        <h6 style="color:red"><b>Total Pasien (IBS) : 0 orang</b></h6>
                        
                        @endif
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTableIBS" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama <br> (RM)</th>
                                            <th>Dokter Operasi</th>
                                            <th>Dokter Anestesi</th>
                                            <th>Pendamping</th>
                                            <th>Ruangan Asal</th>
                                            <th>Jam mulai</th>
                                            <th>Jam selesai</th>
                                            <th>Diagnosa Pre</th>
                                            <th>Diagnosa Post</th>
                                  

                                        </tr>
                                    </thead>
                                    
                                    <?php
                                    $no = 1;
                                    ?>
                                    <tbody>
                                        @foreach(\App\Models\Laporanibsdetail::where('id_laporan_ibs',$getIDibs)->get() as $data)
                                        <?php
                                        $arrdokteroperasi = explode(',',$data->id_dokter_operasi);

                                        
                                        ?>
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $data->nama }}<br>({{ $data->rm }})</td>
                                            <td>
                                            @foreach($arrdokteroperasi as $key)  
                                                {{ \App\Models\Dokterirj::where('id',$key)->pluck('nama')->first() }}<br>    
                                            @endforeach

                                            </td>
                                            <!-- <td>{{ \App\Models\Dokterirj::where('id',$data->id_dokter_operasi)->pluck('nama')->first() }}</td> -->
                                            <td>{{ \App\Models\Dokterirj::where('id',$data->id_dokter_anestesi)->pluck('nama')->first() }}</td>
                                            <td>{{ $data->pendamping }}</td>
                                            <td>{{ \App\Models\Ruangan::where('id',$data->id_ruangan)->pluck('nama_ruangan')->first() }}</td>
                                            <td>{{ $data->jam_mulai }}</td>
                                            <td>{{ $data->jam_selesai }}</td>
                                            <td>{{ $data->diagnosa_pre }}</td>
                                            <td>{{ $data->diagnosa_post }}</td>
                                            
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
                    
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Catatan IBS untuk Dinas berikutnya</label>
                                <textarea class="form-control  z-depth-1" name="ibs_catatan" rows="3" disabled >{{ \App\Models\Laporanibs::where('id_laporan',$lastIDLaporan)->pluck('catatan')->first() }}</textarea>
                            </div>
                           
                          
                        </div>
                    </div>



            </div>
        </div>
    </div>




    <!-- Collapsable Card Example -->
<div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseIRJ" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseIRJ">
            <h6 class="m-0 font-weight-bold ">Instalasi Rawat Jalan (IRJ)</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse show" id="collapseIRJ">
            <div class="card-body">
                <!-- Content Row -->
                
                    <div class="row ">
                        <div class="col-lg-12 tableketerangan">
                        <?php
                            $getIDirj = \App\Models\Laporanirj::where('id_laporan',$lastIDLaporan)->pluck('id')->first();
                        ?>
                        @if($getIDirj)
                        <h6 style="color:red"><b>Total Pasien (IRJ) : {{ \App\Models\Laporanirjdetail::where('id_laporan_irj',$getIDirj)->pluck('pasien_total')->sum() }} orang</b></h6>
                        @else
                        <h6 style="color:red"><b>Total Pasien (IRJ) : 0 orang</b></h6>
                        
                        @endif
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTableIRJ" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="10%">No</th>
                                            <th>SDMK Jenis</th>
                                            <th>Nama Dokter</th>
                                            <th>Pasien Lama</th>
                                            <th>Pasien Baru</th>
                                            <th>Total</th>
                                           
                                        </tr>
                                    </thead>
                                    
                                    <?php
                                    $no = 1;
                                    ?>
                                    <tbody>
                                        @foreach(\App\Models\Laporanirjdetail::where('status',1)->where('id_laporan_irj',\App\Models\Laporanirj::where('id_laporan',$lastIDLaporan)->pluck('id')->first())->get() as $data)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ \App\Models\sdmk_jenis::where('id',\App\Models\Dokterirj::where('id',$data->id_dokter_irj)->pluck('id_sdmk_jenis')->first())->pluck('jenis')->first() }}</td>
                                            <td>{{ \App\Models\Dokterirj::where('id',$data->id_dokter_irj)->pluck('nama')->first() }}</td>
                                            <td>{{ $data->pasien_lama }}</td>
                                            <td>{{ $data->pasien_baru }}</td>
                                            <td>{{ $data->pasien_total }}</td>
                                         

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
                    
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Masalah</label>
                                <textarea class="form-control  z-depth-1" name="irj_masalah" rows="3" disabled >{{ \App\Models\Laporanirj::where('id_laporan',$lastIDLaporan)->pluck('masalah')->first() }}</textarea>
                            </div>
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Langkah atasi masalah</label>
                                <textarea class="form-control" name="irj_langkah" rows="3" disabled >{{ \App\Models\Laporanirj::where('id_laporan',$lastIDLaporan)->pluck('langkah_atasi_masalah')->first() }}</textarea>
                            </div>
                            
                          
                        </div>
                    </div>



            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->



<!-- Rincian umum -->
<div id="istimewa" class="modal fade" role="dialog"  >
    <div class="modal-dialog modal-lg" >

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                <h4>Catatan Pasien Istimewa</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                
            </div>
            <div class="modal-body" style="padding:30px">
                <div class="row ">
                    <div class="col-lg-12 tableistimewa">
                
                    </div>
                </div>
            </div>
         
        </div>
        
    </div>
</div>

<div id="baru" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" >

        <!-- Modal content-->
        <div class="modal-content">

        <div class="modal-header">
                <h4>Catatan Pasien Baru</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
            <div class="row ">
                <div class="col-lg-12 tablebaru">
                
                </div>
            </div>
            </div>
           
        </div>
    </div>
</div>


<div id="permasalahan" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" >

        <!-- Modal content-->
        <div class="modal-content">

        <div class="modal-header">
                <h4>Permasalahan</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
            <div class="row ">
                <div class="col-lg-12 tablemasalah">
                
                </div>
            </div>
            </div>
           
        </div>
    </div>
</div>


@stop
@section('custom_script')
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.3/js/dataTables.fixedColumns.min.js"></script>
<script>
    $("#dataTableIRJ").DataTable({
        "pageLength": 5,
        "ordering" : false,
        lengthMenu: [[5], [5]]
    });
    $("#dataTableIBS").DataTable({
        "pageLength": 5,
        "ordering" : false,
        lengthMenu: [[5], [5]]
    });
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
<script>
    //IGD
    

    
    function igd1a() {
        document.getElementById("gbr_igd_pasien").setAttribute('src', '{{asset('sb-admin/icon/warna/igd/pasien-dirawat.png')}}');
    }

    function igd1b() {
        document.getElementById("gbr_igd_pasien").setAttribute('src', '{{asset('sb-admin/icon/igd/pasien-dirawat.png')}}');
    }

    function igd2a() {
        document.getElementById("gbr_igd_pasien_pulang").setAttribute('src', '{{asset('sb-admin/icon/warna/igd/pasien-pulang.png')}}');
    }

    function igd2b() {
        document.getElementById("gbr_igd_pasien_pulang").setAttribute('src', '{{asset('sb-admin/icon/igd/pasien-pulang.png')}}');
    }
    
    function igd3a() {
        document.getElementById("gbr_igd_pasien_emergency").setAttribute('src', '{{asset('sb-admin/icon/warna/igd/pasien-emergency.png')}}');
    }

    function igd3b() {
        document.getElementById("gbr_igd_pasien_emergency").setAttribute('src', '{{asset('sb-admin/icon/igd/pasien-emergency.png')}}');
    }
    
    function igd4a() {
        document.getElementById("gbr_igd_pasien_non_emergency").setAttribute('src', '{{asset('sb-admin/icon/warna/igd/pasien-non-emergency.png')}}');
    }

    function igd4b() {
        document.getElementById("gbr_igd_pasien_non_emergency").setAttribute('src', '{{asset('sb-admin/icon/igd/pasien-non-emergency.png')}}');
    }

    function igd5a() {
        document.getElementById("gbr_igd_pasien_tidak_rawat").setAttribute('src', '{{asset('sb-admin/icon/warna/igd/pasien-tidak-bisa-dirawat.png')}}');
    }

    function igd5b() {
        document.getElementById("gbr_igd_pasien_tidak_rawat").setAttribute('src', '{{asset('sb-admin/icon/igd/pasien-tidak-bisa-dirawat.png')}}');
    }
    
    function igd6a() {
        document.getElementById("gbr_igd_pasien_doa").setAttribute('src', '{{asset('sb-admin/icon/warna/igd/pasien-doa.png')}}');
    }

    function igd6b() {
        document.getElementById("gbr_igd_pasien_doa").setAttribute('src', '{{asset('sb-admin/icon/igd/pasien-doa.png')}}');
    }

    function igd7a() {
        document.getElementById("gbr_igd_pasien_sisrute").setAttribute('src', '{{asset('sb-admin/icon/warna/igd/sisrute.png')}}');
    }

    function igd7b() {
        document.getElementById("gbr_igd_pasien_sisrute").setAttribute('src', '{{asset('sb-admin/icon/igd/sisrute.png')}}');
    }

    function igd8a() {
        document.getElementById("gbr_igd_pasien_sisrute_diterima").setAttribute('src', '{{asset('sb-admin/icon/warna/igd/sisrute-terima.png')}}');
    }

    function igd8b() {
        document.getElementById("gbr_igd_pasien_sisrute_diterima").setAttribute('src', '{{asset('sb-admin/icon/igd/sisrute-terima.png')}}');
    }

    function igd9a() {
        document.getElementById("gbr_igd_pasien_sisrute_ditolak").setAttribute('src', '{{asset('sb-admin/icon/warna/igd/sisrute-tolak.png')}}');
    }

    function igd9b() {
        document.getElementById("gbr_igd_pasien_sisrute_ditolak").setAttribute('src', '{{asset('sb-admin/icon/igd/sisrute-tolak.png')}}');
    }


    //Rawat Inap
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

<script>
    // $("#dataTable").DataTable({

    // });
    $(document).ready(function() {
        var table = $('#dataTableRuangan').removeAttr('width').DataTable({
            scrollX: true,
            
            ordering: false,
            paging: false,
            searching: false,
            info: false,
            columnDefs: [{
                width: 150,
                targets: 0
            }],
            fixedColumns: true
        });
    });


</script>
<script>
// 
$("#dataTableRuangan").on('click','.btn-istimewa',function(){
        idlaporan =  $(this).data('id');
        ruangan =  $(this).data('ruangan');
        $(".tableistimewa").html('<h4>Mohon Tunggu...</h4>');
        $.ajax({
                            type : "get",
                            url : 'refresh-istimewa/'+idlaporan+'/'+ruangan,
                            data: { "_token": "{{ csrf_token() }}", idlaporan : idlaporan, idruangan:ruangan},
                            success : function(data){
                            //console.log(data);
                            $(".tableistimewa").html(data);
                            }   
                    });

    });

    $("#dataTableRuangan").on('click','.btn-baru',function(){
        idlaporan =  $(this).data('id');
        ruangan =  $(this).data('ruangan');
        $(".tablebaru").html('<h4>Mohon Tunggu...</h4>');
        $.ajax({
                            type : "get",
                            url : 'refresh-baru/'+idlaporan+'/'+ruangan,
                            data: { "_token": "{{ csrf_token() }}", idlaporan : idlaporan, idruangan:ruangan},
                            success : function(data){
                            //console.log(data);
                            $(".tablebaru").html(data);
                            }   
                    });

    });

    $("#dataTableRuangan").on('click','.btn-permasalahan',function(){
        idlaporan =  $(this).data('id');
        ruangan =  $(this).data('ruangan');
        $(".tablemasalah").html('<h4>Mohon Tunggu...</h4>');
        $.ajax({
                            type : "get",
                            url : 'refresh-permasalahan/'+idlaporan+'/'+ruangan,
                            data: { "_token": "{{ csrf_token() }}", idlaporan : idlaporan, idruangan:ruangan},
                            success : function(data){
                            //console.log(data);
                            $(".tablemasalah").html(data);
                            }   
                    });

    });
</script>
@stop