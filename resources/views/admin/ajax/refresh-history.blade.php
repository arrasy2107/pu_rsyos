<?php 


setlocale(LC_TIME, 'id_ID');
\Carbon\Carbon::setLocale('id');
\Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
$t = new Grei\TanggalMerah();



?>
<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="10%">No</th>
                                    <th width="15%">Tanggal</th>
                                    <th width="10%">Jam</th>
                                    <th>Dinas</th>
                                    <th>Pengawas Umum</th>
                                    <th >Tanda Tangan</th>
                                    <th width="20%">Laporan</th>

                                </tr>
                            </thead>
                            
                            <?php
                            $date = date_default_timezone_set('Asia/Jakarta');
                            $today = date('Y-m-d H:i:s');
                            $no = 1;
                            ?>
                            
                            <tbody>
                                @foreach(\App\Models\Laporan::whereDate('created_at','>=',$tanggal)->whereDate('created_at','<=',$tanggal2)->where('verified',1)->orderBy('updated_at','DESC')->where('status',1)->get() as $data)
                                <?php
                                $t->set_date( date('Ymd', strtotime($data->created_at)));
                                ?>
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $data->created_at->isoFormat('dddd, D MMMM Y')}}</td>
                                    <td>{{ date('H:i:s', strtotime($data->created_at)) }}</td>
                                    <td>{{ strtoupper(\App\Models\Dinas::where('id',$data->id_dinas)->pluck('dinas')->first()) }}</td>
                                    <td>{{ \App\Models\User::where('id',$data->id_pengawas)->pluck('nama')->first() }}</td>
                                    <td><img style="width:150px; height:auto" class="img-fluid rounded mb-3 mb-md-0" src="{{asset('signature/'.$data->signature)}}" alt=""></td>
                                    
                                    <td>
                                        <button value="{{ $data->id }}" class="btn btn-sm btn-danger btn-igd " data-jenis="1" data-toggle="modal" data-target="#igd">IGD</button>
                                        <button value="{{ $data->id }}" class="btn btn-sm btn-success btn-umum " data-jenis="2" data-toggle="modal" data-target="#umum">Umum</button>
                                        <button value="{{ $data->id }}" class="btn btn-sm btn-warning btn-ibs " style="color:#000" data-jenis="4" data-toggle="modal" data-target="#ibs">IBS</button>
                                        @if($data->id_dinas != 3 && $t->check() != true)
                                        <button value="{{ $data->id }}" class="btn btn-sm btn-primary btn-irj " data-jenis="3" data-toggle="modal" data-target="#irj">IRJ</button>
                                        @endif
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
    $("#dataTable").DataTable({
        "ordering":false
    });
$("#dataTable").on('click', '.btn-igd', function() {
        id1 = $(this).val();
     

    });
    $("#dataTable").on('click', '.btn-umum', function() {
        id2 = $(this).val();
   

    });
    $("#dataTable").on('click', '.btn-irj', function() {
        id3 = $(this).val();

    });
    $("#dataTable").on('click', '.btn-ibs', function() {
        id4 = $(this).val();

    });


    $('#igd').on('show.bs.modal', function() {
           $.ajax({
                            type : "get",
                            url : 'refresh-detail-laporan-igd/'+id1,
                            data: { "_token": "{{ csrf_token() }}", idlaporan : id1},
                            success : function(data){
                            //console.log(data);
                            $(".tableigd").html(data);
                            }   
                    });


    });

    $('#umum').on('show.bs.modal', function() {
           $.ajax({
                            type : "get",
                            url : 'refresh-detail-laporan-umum/'+id2,
                            data: { "_token": "{{ csrf_token() }}", idlaporan : id2},
                            success : function(data){
                            //console.log(data);
                            $(".tableumum").html(data);
                            }   
                    });


    });

    $('#irj').on('show.bs.modal', function() {
           $.ajax({
                            type : "get",
                            url : 'refresh-detail-laporan-irj/'+id3,
                            data: { "_token": "{{ csrf_token() }}", idlaporan : id3},
                            success : function(data){
                            //console.log(data);
                            $(".tableirj").html(data);
                            }   
                    });


    });
    $('#ibs').on('show.bs.modal', function() {
           $.ajax({
                            type : "get",
                            url : 'refresh-detail-laporan-ibs/'+id4,
                            data: { "_token": "{{ csrf_token() }}", idlaporan : id4},
                            success : function(data){
                            //console.log(data);
                            $(".tableibs").html(data);
                            }   
                    });


    });

</script>