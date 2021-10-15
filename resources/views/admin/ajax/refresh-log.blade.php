<div class="table-responsive">
    <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th width="20%">Tanggal</th>
                <th width="10%">Jam</th>
                <th>User</th>
                <th>Log Jenis</th>
                <th>Keterangan</th>


            </tr>
        </thead>
        <?php
        $date = date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d');

        ?>
        <tbody>
            @if($jenis == 0)
                @foreach(\App\Models\Log::whereDate('created_at','>=',$tanggalmulai)->whereDate('created_at','<=',$tanggalselesai)->orderBy('created_at','DESC')->get() as $data)
                <tr>

                    <td>{{ $data->created_at->isoFormat('dddd, D MMMM Y') }}</td>
                    <td>{{ date('H:i:s', strtotime($data->created_at)) }}</td>
                    <td>{{ \App\Models\User::where('id',$data->id_user)->pluck('username')->first() }}</td>
                    <td>{{ \App\Models\Logjenis::where('id',$data->id_log_jenis)->pluck('jenis')->first() }}</td>
                    <td>{{ $data->keterangan }}</td>

                </tr>

                @endforeach
            @else
                @foreach(\App\Models\Log::whereDate('created_at','>=',$tanggalmulai)->whereDate('created_at','<=',$tanggalselesai)->where('id_log_jenis',$jenis)->orderBy('created_at','DESC')->get() as $data)
                    <tr>

                        <td>{{ $data->created_at->isoFormat('dddd, D MMMM Y') }}</td>
                        <td>{{ date('H:i:s', strtotime($data->created_at)) }}</td>
                        <td>{{ \App\Models\User::where('id',$data->id_user)->pluck('username')->first() }}</td>
                        <td>{{ \App\Models\Logjenis::where('id',$data->id_log_jenis)->pluck('jenis')->first() }}</td>
                        <td>{{ $data->keterangan }}</td>

                    </tr>

                @endforeach
            @endif

        </tbody>
    </table>
</div>

<script>
    $("#dataTable2").DataTable({

        ordering: false,
        
    });
</script>