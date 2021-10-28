<input type="hidden" class="form-control" id="ruangan" name="ruangan" value="{{$ruangan2}}" />
               
<div class="row">
                        <div class="col-md-4">
                            <a class="btn btn-primary btn-md" style="color:white" data-toggle="modal" data-target="#tambahistimewa">Input Catatan</a>
                            <br>
                        </div>
                    </div>
                    <br>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTableistimewa2" width="100%" cellspacing="0">
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
                                @foreach(\App\Models\Catatanpasien::where('status',0)->where('id_ruangan',$ruangan2)->where('id_jenis_pasien',1)->where('id_pengawas',\Auth::user()->id)->get() as $data)
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
<script>
$("#dataTableistimewa2").DataTable({
    "pageLength": 5,
    "ordering" : false,
    lengthMenu: [[5], [5]]
    });


</script>
<script>
    $("#dataTableistimewa2").on('click', '.btn-edit', function() {
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

    $("#dataTableistimewa2").on('click', '.btn-hapus', function(e) {
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