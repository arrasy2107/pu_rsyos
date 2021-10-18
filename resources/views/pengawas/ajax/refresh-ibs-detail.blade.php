                  <div class="row">
                        <div class="col-md-4">
                            <button class="btn btn-primary btn-md" data-toggle="modal" data-target="#tambahibs2">Tambah Keterangan</button>
                            <br>
                        </div>
                    </div>
                 
                    <br>
<label style="color:#000;font-weight:600">Jumlah pasien menurut Dokter IBS</label>
<div class="table-responsive">
    <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
        <thead>
            <tr>
                
            <th width="10%">No</th>
            <th>Dokter Operasi</th>
            <th>Dokter Anestesi</th>
            <th>Pendamping</th>
            <th>Ruangan Asal</th>
            <th>Jam mulai</th>
            <th>Jam selesai</th>
            <th>Diagnosa</th>
            <th>Jumlah Pasien</th>
            <th width="20%">Aksi</th>
            </tr>
        </thead>

        <?php
        $no = 1;
        ?>
        <tbody>
            @foreach(\App\Models\Laporanibsdetail::where('status',0)->where('id_pengawas',\Auth::user()->id)->get() as $data)
            <tr>
                            <td>{{ $no }}</td>
                                            <td>{{ \App\Models\Dokterirj::where('id',$data->id_dokter_operasi)->pluck('nama')->first() }}</td>
                                            <td>{{ \App\Models\Dokterirj::where('id',$data->id_dokter_anestesi)->pluck('nama')->first() }}</td>
                                            <td>{{ $data->pendamping }}</td>
                                            <td>{{ \App\Models\Ruangan::where('id',$data->id_ruangan)->pluck('nama_ruangan')->first() }}</td>
                                            <td>{{ $data->jam_mulai }}</td>
                                            <td>{{ $data->jam_selesai }}</td>
                                            <td>{{ $data->diagnosa }}</td>
                                            <td>{{ $data->jumlah_pasien }}</td>
                                            <td><button value="{{ $data->id }}" class="btn btn-sm btn-success btn-edit " data-dokteroperasi="{{$data->id_dokter_operasi}}" data-dokteranestesi="{{$data->id_dokter_anestesi}}" data-pendamping="{{$data->pendamping}}" data-ruangan="{{$data->id_ruangan}}" data-jammulai="{{$data->jam_mulai}}" data-jamselesai="{{$data->jam_selesai}}" data-diagnosa="{{$data->diagnosa}}" data-jumlahpasien="{{$data->jumlah_pasien}}" data-toggle="modal" data-target="#editibs2">Ubah</button>
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
                Tambah Keterangan Jumlah Pasien IBS
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="" id="tambahketeranganibs" role="form">
                {{ csrf_field() }}
                    <div class="form-group">
                        <label>Dokter Operasi: </label><br>
                        <select class="form-control select2" name="id_dokter_operasi" id="id_dokter_operasi" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Dokter Anestesi: </label><br>
                        <select class="form-control select2" name="id_dokter_anestesi" id="id_dokter_anestesi" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pendamping : </label>
                        <input type="text" class="form-control" name="pendamping"  />
                    </div>
                    <div class="form-group">
                        <label>Ruangan Asal: </label><br>
                        <select class="form-control select2" name="id_ruangan" id="id_ruangan" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Ruangan</option>
                            @foreach(\App\Models\Ruangan::where('status',1)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama_ruangan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jam Mulai: </label>
                        <input type="time" class="form-control" name="jam_mulai" required />
                    </div>
                    <div class="form-group">
                        <label>Jam Selesai: </label>
                        <input type="time" class="form-control" name="jam_selesai" required />
                    </div>
                    <div class="form-group">
                        <label>Diagnosa: </label>
                        <textarea class="form-control" name="diagnosa" rows="3" placeholder="Tulis disini..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Pasien : </label>
                        <input type="number" class="form-control" name="jumlah_pasien" required />
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
                Ubah Keterangan Jumlah Pasien IBS
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:30px">
                <form method="post" action="" id="editketeranganibs" role="form">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                    <input type="hidden" class="txtidibs" name="idibs">
                    <div class="form-group">
                        <label>Dokter Operasi: </label><br>
                        <select class="form-control select2 txt-operasi" name="id_dokter_operasi2" id="id_dokter_operasi2" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Dokter Anestesi: </label><br>
                        <select class="form-control select2 txt-anestesi" name="id_dokter_anestesi2" id="id_dokter_anestesi2" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pendamping : </label>
                        <input type="text" class="form-control txt-pendamping" id="pendamping2" name="pendamping2"  />
                    </div>
                    <div class="form-group">
                        <label>Ruangan Asal: </label><br>
                        <select class="form-control select2 txt-ruangan" name="id_ruangan2" id="id_ruangan2" style="width: 100%" required>
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
                        <textarea class="form-control txt-diagnosa" name="diagnosa2" rows="3" placeholder="Tulis disini..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Pasien : </label>
                        <input type="number" class="form-control txt-jumlah" name="jumlah_pasien2" required />
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
        idibs = $(this).val(); //laporan ibs detail
        dokteroperasi = $(this).data('dokteroperasi');
        dokteranestesi = $(this).data('dokteranestesi');
        pendamping = $(this).data('pendamping');
        ruangan = $(this).data('ruangan');
        jammulai = $(this).data('jammulai');
        jamselesai = $(this).data('jamselesai');
        diagnosa = $(this).data('diagnosa');
        jumlahpasien = $(this).data('jumlahpasien');

    });
    $('#editibs2').on('show.bs.modal', function() {
        $(".txtidibs").val(idibs);
        $(".txt-operasi").select2().val(dokteroperasi).trigger("change");
        $(".txt-anestesi").select2().val(dokteranestesi).trigger("change");
        $(".txt-ruangan").select2().val(ruangan).trigger("change");
        $(".txt-pendamping").val(pendamping);
        $(".txt-mulai").val(jammulai);
        $(".txt-selesai").val(jamselesai);
        $(".txt-diagnosa").val(diagnosa);
        $(".txt-jumlah").val(jumlahpasien);
    });

    $("#dataTable2").on('click', '.btn-hapus', function(e) {
        id = $(this).val(); 
        var conf = confirm('apakah anda yakin ingin menghapus data ini ?');
        if (conf == false) {
            e.preventDefault();
            // $("#edit").modal('hide');
        }
        else{
            // $("#edit").modal('hide');
            var x = parseInt($("#hitungketeranganibs").val()) - 1;
            $("#hitungketeranganibs").val(x)
            console.log(id);
            var url = 'deleteibsdetail';

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
                            url : 'refresh-ibs-detail/',
                            data: { "_token": "{{ csrf_token() }}",},
                            success : function(data){
                            //console.log(data);
                            $(".tableketeranganibs").html(data);
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


$(".btn-tambahibs2").click(function(e){

    $("#tambahibs2").modal('hide');

    e.preventDefault();

    var id_dokter_operasi = $("#id_dokter_operasi :selected").val();
    var id_dokter_anestesi = $("#id_dokter_anestesi :selected").val();
    var pendamping = $("input[name=pendamping]").val();
    var id_ruangan = $("#id_ruangan :selected").val();
    var jam_mulai = $("input[name=jam_mulai]").val();
    var jam_selesai = $("input[name=jam_selesai]").val();
    var diagnosa = $("textarea[name=diagnosa]").val();
    var jumlah_pasien = $("input[name=jumlah_pasien]").val();

    var x = parseInt($("#hitungketeranganibs").val()) + 1;
    $("#hitungketeranganibs").val(x)




    console.log(id_dokter_operasi+' '+ id_dokter_anestesi + ' '+ id_ruangan + ' '+ pendamping +  ' '+ jam_mulai + ' '+ jam_selesai + ' '+ diagnosa + ' '+ jumlah_pasien);
    var url = 'tambahibsdetail';

    $.ajax({
    url:url,
    method:'POST',
    data:{
        _token: "{{ csrf_token() }}",
        id_dokter_operasi:id_dokter_operasi,
        id_dokter_anestesi:id_dokter_anestesi,
        pendamping:pendamping,
        id_ruangan : id_ruangan,
        jam_mulai : jam_mulai,
        jam_selesai : jam_selesai,
        diagnosa : diagnosa,
        jumlah_pasien : jumlah_pasien
    },
    success:function(response){
        if(response.success){
            $("#id_dokter_operasi").val("");
            $("#id_dokter_anestesi").val("");
            $("#id_ruangan").val("");
            $("input[name=pendamping]").val("");
            $("input[name=jam_mulai]").val("");
            $("input[name=jam_selesai]").val("");
            $("input[name=diagnosa]").val("");
            $("input[name=jumlah_pasien]").val("");
            alert(response.message) //Message come from controller
            $.ajax({
                type : "get",
                url : 'refresh-ibs-detail/',
                data: { "_token": "{{ csrf_token() }}",},
                success : function(data){
                //console.log(data);
                $(".tableketeranganibs").html(data);
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
 $(".btn-simpanibs2").click(function(e){

        $("#editibs2").modal('hide');

        e.preventDefault();


        var id2 = $("input[name=idibs]").val();
        var id_dokter_operasi2 = $("#id_dokter_operasi2 :selected").val();
        var id_dokter_anestesi2 = $("#id_dokter_anestesi2 :selected").val();
        var id_ruangan2 = $("#id_ruangan2 :selected").val();
        var pendamping2 = $("input[name=pendamping2]").val();
        var jam_mulai2 = $("input[name=jam_mulai2]").val();
        var jam_selesai2 = $("input[name=jam_selesai2]").val();
        var diagnosa2 = $("textarea[name=diagnosa2]").val();
        var jumlah_pasien2 = $("input[name=jumlah_pasien2]").val();


        console.log(id_dokter_operasi2+' '+ id_dokter_anestesi2 + ' '+ id_ruangan2 +  ' '+ pendamping2 + ' '+ jam_mulai2 + ' '+ jam_selesai2 + ' '+ diagnosa2 + ' '+ jumlah_pasien2);
        var url = 'editibsdetail';

        $.ajax({
        url:url,
        method:'PUT',
        data:{
            _token: "{{ csrf_token() }}",
            id:id2,
            id_dokter_operasi:id_dokter_operasi2,
            id_dokter_anestesi:id_dokter_anestesi2,
            pendamping:pendamping2,
            id_ruangan : id_ruangan2,
            jam_mulai : jam_mulai2,
            jam_selesai : jam_selesai2,
            diagnosa : diagnosa2,
            jumlah_pasien : jumlah_pasien2
        },
        success:function(response){
            if(response.success == true){
                
                alert(response.message) //Message come from controller
                $.ajax({
                    type : "get",
                    url : 'refresh-ibs-detail/',
                    data: { "_token": "{{ csrf_token() }}",},
                    success : function(data){
                    //console.log(data);
                    $(".tableketeranganibs").html(data);
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