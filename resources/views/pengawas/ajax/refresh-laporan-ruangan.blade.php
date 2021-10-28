<input type="hidden" class="form-control" id="ruangan" name="ruangan" value="{{$ruangan}}" />
                          
<div class="row ">
    <!-- Pending Requests Card Example -->


    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">

            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-md-10 jumlahpasienlama">
                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Jumlah Pasien lama <span><a data-toggle="tooltip" data-placement="right" title="Jumlah Pasien Lama Otomatis dari Inputan Dinas Sebelumnya"><i class="fa  fa-exclamation-circle"></i></a></span></div>
                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                            <input type="number" class="form-control" id="inap_pasien_lama" name="inap_pasien_lama" onfocus="ranap1a();" onfocusout="ranap1b();" autocomplete="off" readonly />
                            <!-- <a href="#" id="editpasienlama" class="fa fa-edit" style="font-size:16px">Ubah</a> -->
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
                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien baru</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
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

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien pindah (ruangan)</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
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

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien pindahan (ruangan)</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
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

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien Meninggal</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
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

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien Pulang</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
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
                            <a class="btn btn-primary btn-md" style="color:white" data-toggle="modal" data-target="#tambahistimewa">Input Catatan</a>
                            <br>
                        </div>
                    </div>
                    <br>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTableistimewa" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="10%">No</th>
                                    <th>Kamar</th>
                                    <th>Nama<br>RM<br>Diagnosa<br>DPJP</th>
                                    <th>Kondisi</th>

                                    <th width="20%">Aksi</th>

                                </tr>
                            </thead>

                            <?php
                            $no = 1;
                            ?>
                            <tbody>
                                @foreach(\App\Models\Catatanpasien::where('status',0)->where('id_ruangan',$ruangan)->where('id_jenis_pasien',1)->where('id_pengawas',\Auth::user()->id)->get() as $data)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $data->kamar }}</td>
                                    <td>{{ $data->nama }}<hr>{{ $data->rm }}<hr>{{ $data->diagnosa }}<hr>{{ \App\Models\Dokterirj::where('id',$data->dpjp)->pluck('nama')->first() }}</td>
                                    <td>{{ $data->kondisi }}</td>
                                   
                                    <td><a data-id="{{ $data->id }}" class="btn btn-sm btn-success btn-edit " style="color:white" data-kamar="{{$data->kamar}}" data-nama="{{$data->nama}}" data-rm="{{$data->rm}}" data-diagnosa="{{$data->diagnosa}}" data-dpjp="{{$data->dpjp}}" data-kondisi="{{$data->kondisi}}" data-toggle="modal" data-target="#editistimewa">Ubah</a>
                                        <a  class="btn btn-sm btn-danger btn-hapus " data-id="{{ $data->id }}" style="color:white">Hapus</a>

                                    </td>

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
        <div class="form-group shadow-textarea">
            <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Catatan Pasien Baru</label>
            <div class="row ">
                <div class="col-lg-12 tablebaru">
                    <div class="row">
                        <div class="col-md-4">
                            <a class="btn btn-primary btn-md" style="color:white" data-toggle="modal" data-target="#tambahbaru">Input Catatan</a>
                            <br>
                        </div>
                    </div>
                    <br>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTablebaru" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="10%">No</th>
                                    <th>Kamar</th>
                                    <th>Nama<br>RM<br>Diagnosa<br>DPJP</th>
                                    <th>Kondisi</th>

                                    <th width="20%">Aksi</th>

                                </tr>
                            </thead>

                            <?php
                            $no = 1;
                            ?>
                            <tbody>
                                @foreach(\App\Models\Catatanpasien::where('status',0)->where('id_ruangan',$ruangan)->where('id_jenis_pasien',2)->where('id_pengawas',\Auth::user()->id)->get() as $data)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $data->kamar }}</td>
                                    <td>{{ $data->nama }}<hr>{{ $data->rm }}<hr>{{ $data->diagnosa }}<hr>{{ \App\Models\Dokterirj::where('id',$data->dpjp)->pluck('nama')->first() }}</td>
                                    <td>{{ $data->kondisi }}</td>
                                   
                                    <td><a data-id="{{ $data->id }}" class="btn btn-sm btn-success btn-edit " style="color:white"  data-kamar="{{$data->kamar}}" data-nama="{{$data->nama}}" data-rm="{{$data->rm}}" data-diagnosa="{{$data->diagnosa}}" data-dpjp="{{$data->dpjp}}" data-kondisi="{{$data->kondisi}}" data-toggle="modal" data-target="#editbaru">Ubah</a>
                                        <a data-id="{{ $data->id }}" class="btn btn-sm btn-danger btn-hapus " style="color:white" >Hapus</a>

                                    </td>

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
<div class="row mt-3">
    <!-- Pending Requests Card Example -->


    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">

            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-md-10">
                        <div class="text-xs font-weight-bold  text-uppercase mb-1"> Jumlah Pasien Covid19</div>
                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_covid" autocomplete="off" onfocus="ranap6a();" onfocusout="ranap6b();" required />
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
                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien Suspect Covid19</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_suspect" autocomplete="off" onfocus="ranap7a();" onfocusout="ranap7b();" required />

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

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien restrain</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_restrain" autocomplete="off" onfocus="ranap8a();" onfocusout="ranap8b();" required />

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

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien perilaku kekerasan</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_kekerasan" autocomplete="off" onfocus="ranap9a();" onfocusout="ranap9b();" required />

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

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien keracunan</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_keracunan" autocomplete="off" onfocus="ranap10a();" onfocusout="ranap10b();" required />

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

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien Keterbatasan bahasa</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_bahasa" autocomplete="off" onfocus="ranap11a();" onfocusout="ranap11b();" required />

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

                        <div class="text-xs font-weight-bold  text-uppercase mb-1">jumlah Pasien difabel</div>
                        <div class="h5 mb-0 mr-3  font-weight-bold text-gray-800">
                            <input type="number" class="form-control" name="inap_pasien_difabel" autocomplete="off" onfocus="ranap12a();" onfocusout="ranap12b();" required />

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
            <button type="submit" style="float:right" class="btn btn-sm btn-igd btn-primary my-3">Simpan ke Draf Laporan</button>

        </div>
    </div>
</div>

<!-- Pasien Istimewa -->
<div id="tambahistimewa" class="modal fade" role="dialog">
    <div class="modal-dialog">


        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                Tambah Catatan Pasien Istimewa
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="" id="tambahcatatanistimewa" role="form">
                {{ csrf_field() }}
                    <input type="hidden" value="1" name="jenis_pasien">
                    <div class="form-group">
                        <label>Kamar: </label>
                        <input type="text" class="form-control" name="kamar" required />
                    </div>
                    <div class="form-group">
                        <label>Nama: </label>
                        <input type="text" class="form-control" name="nama" required />
                    </div>
                    <div class="form-group">
                        <label>RM: </label>
                        <input type="text" class="form-control" name="rm" required />
                    </div>
                    <div class="form-group shadow-textarea">
                        <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Diagnosa</label>
                        <textarea class="form-control" name="diagnosa" rows="3" placeholder="Tulis disini..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>DPJP: </label><br>
                        <select class="form-control select2" name="dpjp" id="dpjp" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->get() as $mb)
                            @if(!\App\Models\Laporanirjdetail::where('id_pengawas',\Auth::user()->id)->where('status',0)->where('id_dokter_irj',$mb->id)->first())
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group shadow-textarea">
                        <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Kondisi</label>
                        <textarea class="form-control" name="kondisi" rows="3" placeholder="Tulis disini..."></textarea>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-primary btn-tambah-istimewa">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div id="editistimewa" class="modal fade" role="dialog">
    <div class="modal-dialog">


        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                Ubah Catatan Pasien Istimewa
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="" id="editcatatanistimewa" role="form">
                {{ csrf_field() }}
                    <input type="hidden" class="txtidistimewa" name="idistimewa">
                    <input type="hidden" value="1" name="jenis_pasien2">
                    <div class="form-group">
                        <label>Kamar: </label>
                        <input type="text" class="form-control txt-kamar" name="kamar2" required />
                    </div>
                    <div class="form-group">
                        <label>Nama: </label>
                        <input type="text" class="form-control txt-nama" name="nama2" required />
                    </div>
                    <div class="form-group">
                        <label>RM: </label>
                        <input type="text" class="form-control txt-rm" name="rm2" required />
                    </div>
                    <div class="form-group shadow-textarea">
                        <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Diagnosa</label>
                        <textarea class="form-control txt-diagnosa" name="diagnosa2" rows="3" placeholder="Tulis disini..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>DPJP: </label><br>
                        <select class="form-control select2 txt-dpjp" name="dpjp2" id="dpjp2" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->get() as $mb)
                            @if(!\App\Models\Laporanirjdetail::where('id_pengawas',\Auth::user()->id)->where('status',0)->where('id_dokter_irj',$mb->id)->first())
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group shadow-textarea">
                        <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Kondisi</label>
                        <textarea class="form-control txt-kondisi" name="kondisi2" rows="3" placeholder="Tulis disini..."></textarea>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-primary btn-simpan-istimewa">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Pasien Baru -->
<div id="tambahbaru" class="modal fade" role="dialog">
    <div class="modal-dialog">


        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                Tambah Catatan Pasien Baru
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="" id="tambahcatatanbaru" role="form">
                {{ csrf_field() }}
                
                    <input type="hidden" value="2" name="jenis_pasien3">
                    <div class="form-group">
                        <label>Kamar: </label>
                        <input type="text" class="form-control" name="kamar3" required />
                    </div>
                    <div class="form-group">
                        <label>Nama: </label>
                        <input type="text" class="form-control" name="nama3" required />
                    </div>
                    <div class="form-group">
                        <label>RM: </label>
                        <input type="text" class="form-control" name="rm3" required />
                    </div>
                    <div class="form-group shadow-textarea">
                        <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Diagnosa</label>
                        <textarea class="form-control" name="diagnosa3" rows="3" placeholder="Tulis disini..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>DPJP: </label><br>
                        <select class="form-control select2" name="dpjp3" id="dpjp3" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->get() as $mb)
                            @if(!\App\Models\Laporanirjdetail::where('id_pengawas',\Auth::user()->id)->where('status',0)->where('id_dokter_irj',$mb->id)->first())
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group shadow-textarea">
                        <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Kondisi</label>
                        <textarea class="form-control" name="kondisi3" rows="3" placeholder="Tulis disini..."></textarea>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-primary btn-tambah-baru">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div id="editbaru" class="modal fade" role="dialog">
    <div class="modal-dialog">


        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                Ubah Catatan Pasien Baru
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="" id="editcatatanbaru" role="form">
                {{ csrf_field() }}
                    <input type="hidden" class="txtidbaru" name="idbaru">
                    <input type="hidden" value="2" name="jenis_pasien4">
                    <div class="form-group">
                        <label>Kamar: </label>
                        <input type="text" class="form-control txt-kamar" name="kamar4" required />
                    </div>
                    <div class="form-group">
                        <label>Nama: </label>
                        <input type="text" class="form-control txt-nama" name="nama4" required />
                    </div>
                    <div class="form-group">
                        <label>RM: </label>
                        <input type="text" class="form-control txt-rm" name="rm4" required />
                    </div>
                    <div class="form-group shadow-textarea">
                        <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Diagnosa</label>
                        <textarea class="form-control txt-diagnosa" name="diagnosa4" rows="3" placeholder="Tulis disini..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>DPJP: </label><br>
                        <select class="form-control select2 txt-dpjp" name="dpjp4" id="dpjp4" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->get() as $mb)
                            @if(!\App\Models\Laporanirjdetail::where('id_pengawas',\Auth::user()->id)->where('status',0)->where('id_dokter_irj',$mb->id)->first())
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group shadow-textarea">
                        <label for="exampleFormControlTextarea1" style="color:#000;font-weight:600">Kondisi</label>
                        <textarea class="form-control txt-kondisi" name="kondisi4" rows="3" placeholder="Tulis disini..."></textarea>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-primary btn-simpan-baru">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
$("#dataTableistimewa").DataTable({
    "pageLength": 5,
    "ordering" : false,
    lengthMenu: [[5], [5]]
    });

    $("#dataTablebaru").DataTable({
    "pageLength": 5,
    "ordering" : false,
    lengthMenu: [[5], [5]]
    });

</script>

<!-- Istimewa -->

<script>
    $("#dataTableistimewa").on('click', '.btn-edit', function() {
        id_istimewa = $(this).data('id');//laporan istimewa detail
        kamar = $(this).data('kamar');
        nama = $(this).data('nama');
        rm = $(this).data('rm');
        diagnosa = $(this).data('diagnosa');
        dpjp = $(this).data('dpjp');
        kondisi = $(this).data('kondisi');


    });
    $('#editistimewa').on('show.bs.modal', function() {
        $(".txtidistimewa").val(id_istimewa);
        $(".txt-kamar").val(kamar);
        $(".txt-nama").val(nama);
        $(".txt-rm").val(rm);
        $(".txt-diagnosa").val(diagnosa);
        $(".txt-dpjp").select2().val(dpjp).trigger("change");
        $(".txt-kondisi").val(kondisi);
      
    });

    $("#dataTableistimewa").on('click', '.btn-hapus', function(e) {
        id =$(this).data('id');
        var conf = confirm('apakah anda yakin ingin menghapus data ini ?');
        if (conf == false) {
            e.preventDefault();
            // $("#edit").modal('hide');
        }
        else{
            // $("#edit").modal('hide');
            
            console.log(id);
            var url = 'deletecatatanpasien';

            $.ajax({
            url:url,
            method:'GET',
            data:{
                _token: "{{ csrf_token() }}",
                id:id,
            
            },
            success:function(response){
                if(response.success){
                    
                    alert(response.message) //Message come from controller
                    $.ajax({
                            type : "get",
                            url : 'refresh-catatan-pasien-istimewa/'+$("input[name=ruangan]").val(),
                            data: { "_token": "{{ csrf_token() }}",},
                            success : function(data){
                            //console.log(data);
                            $(".tableistimewa").html(data);
                            }   
                    });
                }else{
                    alert("Error")
                }
            },
            error:function(error){
                console.log(error)
            }
            });
        }

    });

    
</script>
<script>


$(".btn-tambah-istimewa").click(function(e){

    $("#tambahistimewa").modal('hide');

    e.preventDefault();
    var kamar = $("input[name=kamar]").val();
    var nama = $("input[name=nama]").val();
    var rm = $("input[name=rm]").val();
    var diagnosa = $("textarea[name=diagnosa]").val();
    var dpjp = $("#dpjp :selected").val();
    var kondisi = $("textarea[name=kondisi]").val();
    var ruangan = $("input[name=ruangan]").val();


    console.log(kamar +' '+nama+' '+rm+' '+ diagnosa + ' '+ dpjp + ' '+ kondisi+ ' '+ ruangan);
    var url = 'tambahcatatanpasien';

    $.ajax({
    url:url,
    method:'POST',
    data:{
        _token: "{{ csrf_token() }}",
        kamar:kamar,
        nama:nama,
        rm:rm,
        diagnosa:diagnosa,
        dpjp:dpjp,
        kondisi:kondisi,
        jenis_pasien : 1,
        ruangan : ruangan
    },
    success:function(response){
        if(response.success){
            $("input[name=kamar]").val("");
            $("input[name=nama]").val("");
            $("input[name=rm]").val("");
            $("#dpjp").val("");
            $("textarea[name=diagnosa]").val("");
            $("textarea[name=kondisi]").val("");
            alert(response.message) //Message come from controller
            $.ajax({
                type : "get",
                url : 'refresh-catatan-pasien-istimewa/'+ruangan,
                data: { "_token": "{{ csrf_token() }}",},
                success : function(data){
                //console.log(data);
                $(".tableistimewa").html(data);
                }   
        });
        }else{
            alert(response.message) 
        }
    },
    error:function(error){
        console.log(error)
    }
    });

    });


// $(document).ready(function() {
//     $("#editketerangan").submit(function(e) {
    $(".btn-simpan-istimewa").click(function(e){

        $("#editistimewa").modal('hide');

        e.preventDefault();


        var id2 = $("input[name=idistimewa]").val();
        var kamar2 = $("input[name=kamar2]").val();
        var nama2 = $("input[name=nama2]").val();
        var rm2 = $("input[name=rm2]").val();
        var diagnosa2 = $("textarea[name=diagnosa2]").val();
        var dpjp2 = $("#dpjp2 :selected").val();
        var kondisi2 = $("textarea[name=kondisi2]").val();
        var ruangan2 = $("input[name=ruangan]").val();

        console.log(id2+' '+kamar2 +' '+nama2+' '+rm2+' '+ diagnosa2 + ' '+ dpjp2 + ' '+ kondisi2 +' '+ruangan2);
        var url = 'editcatatanpasien';

        $.ajax({
        url:url,
        method:'PUT',
        data:{
            _token: "{{ csrf_token() }}",
            id:id2,
            kamar:kamar2,
            nama:nama2,
            rm:rm2,
            diagnosa:diagnosa2,
            dpjp:dpjp2,
            kondisi:kondisi2,
            jenis_pasien : 1,
            ruangan : ruangan2
        },
        success:function(response){
            if(response.success == true){
                
                alert(response.message) //Message come from controller
                $.ajax({
                    type : "get",
                    url : 'refresh-catatan-pasien-istimewa/'+ruangan2,
                    data: { "_token": "{{ csrf_token() }}", ruangan2 : ruangan2},
                    success : function(data){
                    //console.log(data);
                    $(".tableistimewa").html(data);
                    }   
                });
            }else{
                alert(response.message)
            }
        },
        error:function(error){
            console.log(error)
        }
        });
    });



</script>


<!-- Baru -->

<script>
    $("#dataTablebaru").on('click', '.btn-edit', function() {
        id_baru = $(this).data('id');//laporan istimewa detail
        kamar = $(this).data('kamar');
        nama = $(this).data('nama');
        rm = $(this).data('rm');
        diagnosa = $(this).data('diagnosa');
        dpjp = $(this).data('dpjp');
        kondisi = $(this).data('kondisi');


    });
    $('#editbaru').on('show.bs.modal', function() {
        $(".txtidbaru").val(id_baru);
        $(".txt-kamar").val(kamar);
        $(".txt-nama").val(nama);
        $(".txt-rm").val(rm);
        $(".txt-diagnosa").val(diagnosa);
        $(".txt-dpjp").select2().val(dpjp).trigger("change");
        $(".txt-kondisi").val(kondisi);
      
    });

    $("#dataTablebaru").on('click', '.btn-hapus', function(e) {
        id =$(this).data('id');
        var conf = confirm('apakah anda yakin ingin menghapus data ini ?');
        if (conf == false) {
            e.preventDefault();
            // $("#edit").modal('hide');
        }
        else{
            // $("#edit").modal('hide');
            
            console.log(id);
            var url = 'deletecatatanpasien';

            $.ajax({
            url:url,
            method:'GET',
            data:{
                _token: "{{ csrf_token() }}",
                id:id,
            
            },
            success:function(response){
                if(response.success){
                    
                    alert(response.message) //Message come from controller
                    $.ajax({
                            type : "get",
                            url : 'refresh-catatan-pasien-baru/'+$("input[name=ruangan]").val(),
                            data: { "_token": "{{ csrf_token() }}",},
                            success : function(data){
                            //console.log(data);
                            $(".tablebaru").html(data);
                            }   
                    });
                }else{
                    alert("Error")
                }
            },
            error:function(error){
                console.log(error)
            }
            });
        }

    });

    
</script>
<script>


$(".btn-tambah-baru").click(function(e){

    $("#tambahbaru").modal('hide');

    e.preventDefault();
    var kamar = $("input[name=kamar3]").val();
    var nama = $("input[name=nama3]").val();
    var rm = $("input[name=rm3]").val();
    var diagnosa = $("textarea[name=diagnosa3]").val();
    var dpjp = $("#dpjp3 :selected").val();
    var kondisi = $("textarea[name=kondisi3]").val();
    var ruangan = $("input[name=ruangan]").val();


    console.log(kamar +' '+nama+' '+rm+' '+ diagnosa + ' '+ dpjp + ' '+ kondisi+ ' '+ ruangan);
    var url = 'tambahcatatanpasien';

    $.ajax({
    url:url,
    method:'POST',
    data:{
        _token: "{{ csrf_token() }}",
        kamar:kamar,
        nama:nama,
        rm:rm,
        diagnosa:diagnosa,
        dpjp:dpjp,
        kondisi:kondisi,
        jenis_pasien : 2,
        ruangan : ruangan
    },
    success:function(response){
        if(response.success){
            $("input[name=kamar3]").val("");
            $("input[name=nama3]").val("");
            $("input[name=rm3]").val("");
            $("#dpjp3").val("");
            $("textarea[name=diagnosa3]").val("");
            $("textarea[name=kondisi3]").val("");
            alert(response.message) //Message come from controller
            $.ajax({
                type : "get",
                url : 'refresh-catatan-pasien-baru/'+ruangan,
                data: { "_token": "{{ csrf_token() }}", },
                success : function(data){
                //console.log(data);
                $(".tablebaru").html(data);
                }   
        });
        }else{
            alert(response.message) 
        }
    },
    error:function(error){
        console.log(error)
    }
    });

    });



    $(".btn-simpan-baru").click(function(e){

        $("#editbaru").modal('hide');

        e.preventDefault();


        var id2 = $("input[name=idbaru]").val();
        var kamar2 = $("input[name=kamar4]").val();
        var nama2 = $("input[name=nama4]").val();
        var rm2 = $("input[name=rm4]").val();
        var diagnosa2 = $("textarea[name=diagnosa4]").val();
        var dpjp2 = $("#dpjp4 :selected").val();
        var kondisi2 = $("textarea[name=kondisi4]").val();
        var ruangan2 = $("input[name=ruangan]").val();

        console.log(id2+' '+kamar2 +' '+nama2+' '+rm2+' '+ diagnosa2 + ' '+ dpjp2 + ' '+ kondisi2 +' '+ruangan2);
        var url = 'editcatatanpasien';

        $.ajax({
        url:url,
        method:'PUT',
        data:{
            _token: "{{ csrf_token() }}",
            id:id2,
            kamar:kamar2,
            nama:nama2,
            rm:rm2,
            diagnosa:diagnosa2,
            dpjp:dpjp2,
            kondisi:kondisi2,
            jenis_pasien : 2,
            ruangan : ruangan2
        },
        success:function(response){
            if(response.success == true){
                
                alert(response.message) //Message come from controller
                $.ajax({
                    type : "get",
                    url : 'refresh-catatan-pasien-baru/'+ruangan2,
                    data: { "_token": "{{ csrf_token() }}", ruangan2 : ruangan2},
                    success : function(data){
                    //console.log(data);
                    $(".tablebaru").html(data);
                    }   
                });
            }else{
                alert(response.message)
            }
        },
        error:function(error){
            console.log(error)
        }
        });
    });



</script>

<script>
    
// In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.select2').select2();
});
</script>