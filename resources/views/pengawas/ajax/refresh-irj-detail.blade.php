<label style="color:#000;font-weight:600">Jumlah pasien menurut Dokter </label>
<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th width="10%">No</th>
                <th>SDMK Jenis</th>
                <th>Nama Dokter</th>
                <th>Pasien Lama</th>
                <th>Pasien Baru</th>
                <th>Total</th>
                <th width="20%">Aksi</th>

            </tr>
        </thead>

        <?php
        $no = 1;
        ?>
        <tbody>
            @foreach(\App\Models\Laporanirjdetail::where('status',0)->where('id_pengawas',\Auth::user()->id)->get() as $data)
            <tr>
                <td>{{ $no }}</td>
                <td>{{ \App\Models\sdmk_jenis::where('id',\App\Models\Dokterirj::where('id',$data->id_dokter_irj)->pluck('id_sdmk_jenis')->first())->pluck('jenis')->first() }}</td>
                <td>{{ \App\Models\Dokterirj::where('id',$data->id_dokter_irj)->pluck('nama')->first() }}</td>
                <td>{{ $data->pasien_lama }}</td>
                <td>{{ $data->pasien_baru }}</td>
                <td>{{ $data->pasien_total }}</td>
                <td><button value="{{ $data->id }}" class="btn btn-sm btn-success btn-edit " data-dokter="{{$data->id_dokter_irj}}" data-lama="{{$data->pasien_lama}}" data-baru="{{$data->pasien_baru}}" data-toggle="modal" data-target="#edit">Ubah</button>
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


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var id, dokter, lama, baru;
    $("#dataTable").on('click', '.btn-edit', function() {
        id = $(this).val(); //dinas
        dokter = $(this).data('dokter');
        lama = $(this).data('lama');
        baru = $(this).data('baru');

    });

    $('#edit').on('show.bs.modal', function() {
        $(".txtid").val(id);
        $(".txtiddokter").val(dokter);
        $(".txtlama").val(lama);
        $(".txtbaru").val(baru);
    });

    $("#dataTable").on('click', '.btn-hapus', function() {
        id = $(this).val(); 
        var conf = confirm('apakah anda yakin ingin menghapus data ini ?');
        if (conf == false) {
            e.preventDefault();
            $("#edit").modal('hide');
        }
        else{
            $("#edit").modal('hide');
            
            console.log(id);
            var url = 'deleteirjdetail';

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
                            url : 'refresh-irj-detail/',
                            data: { "_token": "{{ csrf_token() }}",},
                            success : function(data){
                            //console.log(data);
                            $(".tableketerangan").html(data);
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