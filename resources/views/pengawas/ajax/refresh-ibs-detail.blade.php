<div class="row">
    <div class="col-md-4">
        <button class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#tambahibs2">Input Pasien</button>
        <br>
    </div>
</div>

<br>
<h6 style="color:red"><b>Total Pasien (IBS) : {{ \App\Models\Laporanibsdetail::where('status',0)->where('id_pengawas',\Auth::user()->id)->count() }} orang</b></h6>

<div class="table-responsive">
    <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
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
                <th width="20%">Aksi</th>

            </tr>
        </thead>

        <?php
        $no = 1;
        ?>
        <tbody>
            @foreach(\App\Models\Laporanibsdetail::where('status',0)->where('id_pengawas',\Auth::user()->id)->get() as $data)
            <?php
            $arrdokteroperasi = explode(',', $data->id_dokter_operasi);


            ?>
            <tr>
                <td>{{ $no }}</td>
                <td>{{ $data->nama }}<br>({{ $data->rm }})</td>
                <td>
                    @foreach($arrdokteroperasi as $key)
                    {{ \App\Models\Dokterirj::where('id',$key)->pluck('nama')->first() }}<br>
                    @endforeach

                </td>
                <td>{{ \App\Models\Dokterirj::where('id',$data->id_dokter_anestesi)->pluck('nama')->first() }}</td>
                <td>{{ $data->pendamping }}</td>
                <td>{{ \App\Models\Ruangan::where('id',$data->id_ruangan)->pluck('nama_ruangan')->first() }}</td>
                <td>{{ $data->jam_mulai }}</td>
                <td>{{ $data->jam_selesai }}</td>
                <td>{{ $data->diagnosa_pre }}</td>
                <td>{{ $data->diagnosa_post }}</td>
                <td><button value="{{ $data->id }}" class="btn btn-sm btn-success btn-edit " data-nama="{{ $data->nama }}" data-rm="{{ $data->rm }}" data-dokteroperasi="{{$data->id_dokter_operasi}}" data-dokteranestesi="{{$data->id_dokter_anestesi}}" data-pendamping="{{$data->pendamping}}" data-ruangan="{{$data->id_ruangan}}" data-jammulai="{{$data->jam_mulai}}" data-jamselesai="{{$data->jam_selesai}}" data-diagnosapre="{{$data->diagnosa_pre}}" data-diagnosapost="{{$data->diagnosa_post}}" data-bs-toggle="modal" data-bs-target="#editibs2">Ubah</button>
                    <button value="{{ $data->id }}" class="btn btn-sm btn-danger btn-hapus ">Hapus</button>

                </td>

            </tr>
            <?php
            $no++;
            ?>
            @endforeach

        </tbody>
    </table>
</div>

<!-- IBS -->

<div id="tambahibs2" class="modal fade" role="dialog">
    <div class="modal-dialog">


        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                Input Pasien IBS
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="" id="tambahketeranganibs" role="form">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Nama : </label>
                        <input type="text" class="form-control" name="nama" />
                    </div>
                    <div class="form-group">
                        <label>RM : </label>
                        <input type="text" class="form-control" name="rm" />
                    </div>
                    <div class="form-group">
                        <label>Dokter Operasi: </label><br>
                        <select multiple="multiple" class="form-control select2" name="id_dokter_operasi3" id="id_dokter_operasi3" style="width: 100%" data-placeholder="Pilih Dokter (Bisa lebih dari 1)" required>

                            @foreach(\App\Models\Dokterirj::where('status',1)->where('id_sdmk_jenis','<>',3)->where('id_sdmk_jenis','<>',21)->get() as $mb)
                                    <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                                    @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Dokter Anestesi: </label><br>
                        <select class="form-control select2" name="id_dokter_anestesi3" id="id_dokter_anestesi3" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->where('id_sdmk_jenis',8)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pendamping / Petugas : </label>
                        <input type="text" class="form-control" name="pendamping" />
                    </div>
                    <div class="form-group">
                        <label>Ruangan Asal: </label><br>
                        <select class="form-control select2" name="id_ruangan3" id="id_ruangan3" style="width: 100%">
                            <option value="" selected disabled hidden>Pilih Ruangan</option>
                            @foreach(\App\Models\Ruangan::where('status',1)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama_ruangan }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="form-group">
                        <label>Jam Mulai : </label>
                        <input type="time" class="form-control" name="jam_mulai" required />
                    </div>
                    <div class="form-group">
                        <label>Jam Selesai : </label>
                        <input type="time" class="form-control" name="jam_selesai" required />
                    </div>
                    <div class="form-group">
                        <label>Diagnosa Pre : </label>
                        <textarea class="form-control" name="diagnosapre" rows="3" placeholder="Tulis disini..." required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Diagnosa Post : </label>
                        <textarea class="form-control" name="diagnosapost" rows="3" placeholder="Tulis disini..." required></textarea>
                    </div>





            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-primary btn-tambahibs2">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>


<div id="editibs2" class="modal fade" role="dialog">
    <div class="modal-dialog">


        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                Ubah Pasien IBS
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="" id="editketeranganibs" role="form">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <input type="hidden" class="txtidibs" name="idibs">
                    <div class="form-group">
                        <label>Nama : </label>
                        <input type="text" class="form-control txt-nama" name="nama2" required />
                    </div>
                    <div class="form-group">
                        <label>RM : </label>
                        <input type="text" class="form-control txt-rm" name="rm2" required />
                    </div>
                    <div class="form-group">
                        <label>Dokter Operasi: </label><br>
                        <select multiple="multiple" class="form-control select2 txt-operasi" name="id_dokter_operasi4" id="id_dokter_operasi4" style="width: 100%" required>

                            @foreach(\App\Models\Dokterirj::where('status',1)->where('id_sdmk_jenis','<>',3)->where('id_sdmk_jenis','<>',21)->get() as $mb)
                                    <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                                    @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Dokter Anestesi: </label><br>
                        <select class="form-control select2 txt-anestesi" name="id_dokter_anestesi4" id="id_dokter_anestesi4" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->where('id_sdmk_jenis',8)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pendamping : </label>
                        <input type="text" class="form-control txt-pendamping" id="pendamping2" name="pendamping2" />
                    </div>
                    <div class="form-group">
                        <label>Ruangan Asal: </label><br>
                        <select class="form-control select2 txt-ruangan" name="id_ruangan4" id="id_ruangan4" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Ruangan</option>
                            @foreach(\App\Models\Ruangan::where('status',1)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama_ruangan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jam Mulai: </label>
                        <input type="time" class="form-control txt-mulai" name="jam_mulai2" required />
                    </div>
                    <div class="form-group">
                        <label>Jam Selesai: </label>
                        <input type="time" class="form-control txt-selesai" name="jam_selesai2" required />
                    </div>
                    <div class="form-group">
                        <label>Diagnosa: </label>
                        <textarea class="form-control txt-diagnosapre" name="diagnosapre2" rows="3" placeholder="Tulis disini..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Diagnosa Post : </label>
                        <textarea class="form-control txt-diagnosapost" name="diagnosapost2" rows="3" placeholder="Tulis disini..." required></textarea>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-primary btn-simpanibs2">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>




<script>
    $.ajaxSetup({
</td>
                <td>{{ \App\Models\Dokterirj::where('id',$data->id_dokter_anestesi)->pluck('nama')->first() }}</td>
                <td>{{ $data->pendamping }}</td>
                <td>{{ \App\Models\Ruangan::where('id',$data->id_ruangan)->pluck('nama_ruangan')->first() }}</td>
                <td>{{ $data->jam_mulai }}</td>
                <td>{{ $data->jam_selesai }}</td>
                <td>{{ $data->diagnosa_pre }}</td>
                <td>{{ $data->diagnosa_post }}</td>
                <td><button value="{{ $data->id }}" class="btn btn-sm btn-success btn-edit " data-nama="{{ $data->nama }}" data-rm="{{ $data->rm }}" data-dokteroperasi="{{$data->id_dokter_operasi}}" data-dokteranestesi="{{$data->id_dokter_anestesi}}" data-pendamping="{{$data->pendamping}}" data-ruangan="{{$data->id_ruangan}}" data-jammulai="{{$data->jam_mulai}}" data-jamselesai="{{$data->jam_selesai}}" data-diagnosapre="{{$data->diagnosa_pre}}" data-diagnosapost="{{$data->diagnosa_post}}" data-bs-toggle="modal" data-bs-target="#editibs2">Ubah</button>
                    <button value="{{ $data->id }}" class="btn btn-sm btn-danger btn-hapus ">Hapus</button>

                </td>

            </tr>
            <?php
            $no++;
            ?>
            @endforeach

        </tbody>
    </table>
</div>

<!-- IBS -->

<div id="tambahibs2" class="modal fade" role="dialog">
    <div class="modal-dialog">


        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                Input Pasien IBS
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="" id="tambahketeranganibs" role="form">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Nama : </label>
                        <input type="text" class="form-control" name="nama" />
                    </div>
                    <div class="form-group">
                        <label>RM : </label>
                        <input type="text" class="form-control" name="rm" />
                    </div>
                    <div class="form-group">
                        <label>Dokter Operasi: </label><br>
                        <select multiple="multiple" class="form-control select2" name="id_dokter_operasi3" id="id_dokter_operasi3" style="width: 100%" data-placeholder="Pilih Dokter (Bisa lebih dari 1)" required>

                            @foreach(\App\Models\Dokterirj::where('status',1)->where('id_sdmk_jenis','<>',3)->where('id_sdmk_jenis','<>',21)->get() as $mb)
                                    <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                                    @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Dokter Anestesi: </label><br>
                        <select class="form-control select2" name="id_dokter_anestesi3" id="id_dokter_anestesi3" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->where('id_sdmk_jenis',8)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pendamping / Petugas : </label>
                        <input type="text" class="form-control" name="pendamping" />
                    </div>
                    <div class="form-group">
                        <label>Ruangan Asal: </label><br>
                        <select class="form-control select2" name="id_ruangan3" id="id_ruangan3" style="width: 100%">
                            <option value="" selected disabled hidden>Pilih Ruangan</option>
                            @foreach(\App\Models\Ruangan::where('status',1)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama_ruangan }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="form-group">
                        <label>Jam Mulai : </label>
                        <input type="time" class="form-control" name="jam_mulai" required />
                    </div>
                    <div class="form-group">
                        <label>Jam Selesai : </label>
                        <input type="time" class="form-control" name="jam_selesai" required />
                    </div>
                    <div class="form-group">
                        <label>Diagnosa Pre : </label>
                        <textarea class="form-control" name="diagnosapre" rows="3" placeholder="Tulis disini..." required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Diagnosa Post : </label>
                        <textarea class="form-control" name="diagnosapost" rows="3" placeholder="Tulis disini..." required></textarea>
                    </div>





            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-primary btn-tambahibs2">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>


<div id="editibs2" class="modal fade" role="dialog">
    <div class="modal-dialog">


        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                Ubah Pasien IBS
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="" id="editketeranganibs" role="form">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <input type="hidden" class="txtidibs" name="idibs">
                    <div class="form-group">
                        <label>Nama : </label>
                        <input type="text" class="form-control txt-nama" name="nama2" required />
                    </div>
                    <div class="form-group">
                        <label>RM : </label>
                        <input type="text" class="form-control txt-rm" name="rm2" required />
                    </div>
                    <div class="form-group">
                        <label>Dokter Operasi: </label><br>
                        <select multiple="multiple" class="form-control select2 txt-operasi" name="id_dokter_operasi4" id="id_dokter_operasi4" style="width: 100%" required>

                            @foreach(\App\Models\Dokterirj::where('status',1)->where('id_sdmk_jenis','<>',3)->where('id_sdmk_jenis','<>',21)->get() as $mb)
                                    <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                                    @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Dokter Anestesi: </label><br>
                        <select class="form-control select2 txt-anestesi" name="id_dokter_anestesi4" id="id_dokter_anestesi4" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->where('id_sdmk_jenis',8)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pendamping : </label>
                        <input type="text" class="form-control txt-pendamping" id="pendamping2" name="pendamping2" />
                    </div>
                    <div class="form-group">
                        <label>Ruangan Asal: </label><br>
                        <select class="form-control select2 txt-ruangan" name="id_ruangan4" id="id_ruangan4" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Ruangan</option>
                            @foreach(\App\Models\Ruangan::where('status',1)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama_ruangan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jam Mulai: </label>
                        <input type="time" class="form-control txt-mulai" name="jam_mulai2" required />
                    </div>
                    <div class="form-group">
                        <label>Jam Selesai: </label>
                        <input type="time" class="form-control txt-selesai" name="jam_selesai2" required />
                    </div>
                    <div class="form-group">
                        <label>Diagnosa: </label>
                        <textarea class="form-control txt-diagnosapre" name="diagnosapre2" rows="3" placeholder="Tulis disini..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Diagnosa Post : </label>
                        <textarea class="form-control txt-diagnosapost" name="diagnosapost2" rows="3" placeholder="Tulis disini..." required></textarea>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-primary btn-simpanibs2">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>




<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#dataTable2").on('click', '.btn-edit', function() {
        let idibs = $(this).val(); //laporan ibs detail
        let d_op = $(this).attr('data-dokteroperasi');
        let listdokteroperasi = (d_op && d_op.includes(",")) ? d_op.split(',') : (d_op ? [d_op] : []);

        $('#editibs2 .txtidibs').val(idibs);
        $('#editibs2 .txt-nama').val($(this).attr('data-nama'));
        $('#editibs2 .txt-rm').val($(this).attr('data-rm'));
        $('#editibs2 .txt-operasi').select2().val(listdokteroperasi).trigger("change");
        $('#editibs2 .txt-anestesi').select2().val($(this).attr('data-dokteranestesi')).trigger("change");
        $('#editibs2 .txt-ruangan').select2().val($(this).attr('data-ruangan')).trigger("change");
        $('#editibs2 .txt-pendamping').val($(this).attr('data-pendamping'));
        $('#editibs2 .txt-mulai').val($(this).attr('data-jammulai'));
        $('#editibs2 .txt-selesai').val($(this).attr('data-jamselesai'));
        $('#editibs2 .txt-diagnosapre').val($(this).attr('data-diagnosapre'));
        $('#editibs2 .txt-diagnosapost').val($(this).attr('data-diagnosapost'));
    });

    $("#dataTable2").on('click', '.btn-hapus', function(e) {
        e.preventDefault();
        id = $(this).val();
        PUAlert.confirmAction({ text: 'Apakah Anda yakin ingin menghapus data ini?', confirmButtonText: 'Ya, hapus' }, function() {
            // $("#edit").modal('hide');
            var x = parseInt($("#hitungketeranganibs").val()) - 1;
            $("#hitungketeranganibs").val(x)
            console.log(id);
            var url = 'deleteibsdetail';

            $.ajax({
                url: url,
                method: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,

                },
                success: function(response) {
                    if (response.success) {

                        alert(response.message) //Message come from controller
                        $.ajax({
                            type: "get",
                            url: 'refresh-ibs-detail/',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(data) {
                                //console.log(data);
                                $(".tableketeranganibs").html(data);
                            }
                        });
                    } else {
                        alert("Error")
                    }
                },
                error: function(error) {
                    console.log(error)
                }
            });
        });

    });
</script>

<script>
    $(".btn-tambahibs2").click(function(e) {

        $("#tambahibs2").modal('hide');

        e.preventDefault();

        var nama = $("input[name=nama]").val();
        var rm = $("input[name=rm]").val();
        var id_dokter_operasi = $('#id_dokter_operasi3').val();
        var id_dokter_anestesi = $("#id_dokter_anestesi3 :selected").val();
        var id_ruangan = $("#id_ruangan3 :selected").val();
        var pendamping = $("input[name=pendamping]").val();
        var jam_mulai = $("input[name=jam_mulai]").val();
        var jam_selesai = $("input[name=jam_selesai]").val();
        var diagnosapre = $("textarea[name=diagnosapre]").val();
        var diagnosapost = $("textarea[name=diagnosapost]").val();


        var x = parseInt($("#hitungketeranganibs").val()) + 1;
        $("#hitungketeranganibs").val(x)




        console.log(nama + ' ' + rm + ' ' + id_dokter_operasi + ' ' + id_dokter_anestesi + ' ' + pendamping + ' ' + id_ruangan + ' ' + jam_mulai + ' ' + jam_selesai + ' ' + diagnosapre + ' ' + diagnosapost);
        var url = 'tambahibsdetail';

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                nama: nama,
                rm: rm,
                id_dokter_operasi: id_dokter_operasi,
                id_dokter_anestesi: id_dokter_anestesi,
                pendamping: pendamping,
                id_ruangan: id_ruangan,
                jam_mulai: jam_mulai,
                jam_selesai: jam_selesai,
                diagnosapre: diagnosapre,
                diagnosapost: diagnosapost
            },
            success: function(response) {
                if (response.success) {
                    $("input[name=nama]").val("");
                    $("input[name=rm]").val("");
                    $("#id_dokter_operasi").val("");
                    $("#id_dokter_anestesi").val("");
                    $("#id_ruangan").val("");
                    $("input[name=jam_mulai]").val("");
                    $("input[name=pendamping]").val("");
                    $("input[name=jam_selesai]").val("");
                    $("input[name=diagnosapre]").val("");
                    $("input[name=diagnosapost]").val("");
                    alert(response.message) //Message come from controller
                    $.ajax({
                        type: "get",
                        url: 'refresh-ibs-detail/',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            //console.log(data);
                            $(".tableketeranganibs").html(data);
                        }
                    });
                } else {
                    alert(response.message)
                }
            },
            error: function(error) {
                console.log(error)
            }
        });

    });


    // $(document).ready(function() {
    //     $("#editketerangan").submit(function(e) {
    $(".btn-simpanibs2").click(function(e) {

        $("#editibs2").modal('hide');

        e.preventDefault();


        var id2 = $("input[name=idibs]").val();
        var nama2 = $("input[name=nama2]").val();
        var rm2 = $("input[name=rm2]").val();
        var id_dokter_operasi2 = $('#id_dokter_operasi4').val();
        var id_dokter_anestesi2 = $("#id_dokter_anestesi4 :selected").val();
        var id_ruangan2 = $("#id_ruangan4 :selected").val();
        var pendamping2 = $("input[name=pendamping2]").val();
        var jam_mulai2 = $("input[name=jam_mulai2]").val();
        var jam_selesai2 = $("input[name=jam_selesai2]").val();
        var diagnosapre2 = $("textarea[name=diagnosapre2]").val();
        var diagnosapost2 = $("textarea[name=diagnosapost2]").val();



        console.log(nama + ' ' + rm + ' ' + id_dokter_operasi2 + ' ' + id_dokter_anestesi2 + ' ' + pendamping2 + ' ' + id_ruangan2 + ' ' + jam_mulai2 + ' ' + jam_selesai2 + ' ' + diagnosapre2 + ' ' + diagnosapost2);
        var url = 'editibsdetail';

        $.ajax({
            url: url,
            method: 'PUT',
            data: {
                _token: "{{ csrf_token() }}",
                id: id2,
                nama: nama2,
                rm: rm2,
                id_dokter_operasi: id_dokter_operasi2,
                id_dokter_anestesi: id_dokter_anestesi2,
                pendamping: pendamping2,
                id_ruangan: id_ruangan2,
                jam_mulai: jam_mulai2,
                jam_selesai: jam_selesai2,
                diagnosapre: diagnosapre2,
                diagnosapost: diagnosapost2
            },
            success: function(response) {
                if (response.success == true) {

                    alert(response.message) //Message come from controller
                    $.ajax({
                        type: "get",
                        url: 'refresh-ibs-detail/',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            //console.log(data);
                            $(".tableketeranganibs").html(data);
                        }
                    });
                } else {
                    alert(response.message)
                }
            },
            error: function(error) {
                console.log(error)
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $(".js-example-basic-single").select2();
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
</script>
