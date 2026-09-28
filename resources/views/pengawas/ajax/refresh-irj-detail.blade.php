                  <div class="row">
                      <div class="col-md-4">
                          <button class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#tambah2">Input Pasien</button>
                          <br>
                      </div>
                  </div>

                  <br>
                  <h6 style="color:red"><b>Total Pasien (IRJ) : {{ \App\Models\Laporanirjdetail::where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('pasien_total')->sum() }} orang</b></h6>

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
                                  <td><button value="{{ $data->id }}" class="btn btn-sm btn-success btn-edit " data-dokter="{{$data->id_dokter_irj}}" data-lama="{{$data->pasien_lama}}" data-baru="{{$data->pasien_baru}}" data-bs-toggle="modal" data-bs-target="#edit2">Ubah</button>
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
                  <div id="tambah2" class="modal fade" role="dialog">
                      <div class="modal-dialog">


                          <!-- Modal content-->
                          <div class="modal-content">
                              <div class="modal-header">
                                  Tambah Keterangan Jumlah Pasien menurut Dokter
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>
                              <div class="modal-body" style="padding:30px">
                                  <form method="post" action="" id="tambahketerangan2" role="form">
                                      {{ csrf_field() }}
                                      <div class="form-group">
                                          <label>Dokter : </label><br>
                                          <select class="form-control select2" name="id_dokter_irj3" id="id_dokter_irj3" style="width: 100%" required>
                                              <option value="" selected disabled hidden>Pilih Dokter</option>
                                              @foreach(\App\Models\Dokterirj::where('status',1)->get() as $mb)
                                              @if(!\App\Models\Laporanirjdetail::where('id_pengawas',\Auth::user()->id)->where('status',0)->where('id_dokter_irj',$mb->id)->first())
                                              <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                                              @endif
                                              @endforeach
                                          </select>
                                      </div>
                                      <div class="form-group">
                                          <label>Jumlah Pasien Lama (Rekam Medis Lama): </label>
                                          <input type="number" class="form-control" name="pasien_lama" required />
                                      </div>
                                      <div class="form-group">
                                          <label>Jumlah Pasien Baru (Rekam Medis Baru): </label>
                                          <input type="number" class="form-control" name="pasien_baru" required />
                                      </div>


                              </div>
                              <div class="modal-footer">
                                  <button type="submit" class="btn btn-sm btn-primary btn-tambah2">Simpan</button>
                              </div>
                              </form>
                          </div>
                      </div>
                  </div>
                  <div id="edit2" class="modal" tabindex="-1" role="dialog">
                      <div class="modal-dialog">

                          <!-- Modal content-->
                          <div class="modal-content">
                              <div class="modal-header">
                                  Ubah Keterangan Jumlah Pasien menurut Dokter
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>
                              <div class="modal-body" style="padding:30px">
                                  <form method="post" action="" id="editketerangan" role="form">
                                      {{ csrf_field() }}
                                      {{ method_field('PUT') }}
                                      <input type="hidden" class="txtid" name="id">
                                      <div class="form-group">
                                          <label>Dokter : </label><br>
                                          <select class="form-control txtiddokter select2" name="id_dokter_irj4" id="id_dokter_irj4" style="width: 100%" required>
                                              <option value="" selected disabled hidden>Pilih Dokter</option>
                                              @foreach(\App\Models\Dokterirj::where('status',1)->get() as $mb)
                                              <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                                              @endforeach
                                          </select>
                                      </div>
                                      <div class="form-group">
                                          <label>Jumlah Pasien Lama (Rekam Medis Lama): </label>
                                          <input type="number" class="form-control txtlama" name="pasien_lama2" required />
                                      </div>
                                      <div class="form-group">
                                          <label>Jumlah Pasien Baru (Rekam Medis Baru): </label>
                                          <input type="number" class="form-control txtbaru" name="pasien_baru2" required />
                                      </div>
                              </div>

                              </form>
                              <div class="modal-footer">
                                  <button type="submit" class="btn btn-sm btn-primary btn-simpan2">Simpan</button>
                              </div>
                          </div>
                      </div>
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

                          // populate immediately so modal shows values without extra clicks
                          $(".txtid").val(id);
                          $(".txtiddokter").val(dokter);
                          $(".txtlama").val(lama);
                          $(".txtbaru").val(baru);

                      });

                      $('#edit2').on('show.bs.modal', function() {
                          $(".txtid").val(id);
                          $(".txtiddokter").val(dokter);
                          $(".txtlama").val(lama);
                          $(".txtbaru").val(baru);
                      });

                      $("#dataTable").on('click', '.btn-hapus', function(e) {
                          e.preventDefault();
                          id = $(this).val();
                          PUAlert.confirmAction({ text: 'Apakah Anda yakin ingin menghapus data ini?', confirmButtonText: 'Ya, hapus' }, function() {
                              var x = parseInt($("#hitungketerangan").val()) - 1;
                              $("#hitungketerangan").val(x)

                              console.log(id);
                              var url = 'deleteirjdetail';

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
                                              url: 'refresh-irj-detail/',
                                              data: {
                                                  "_token": "{{ csrf_token() }}",
                                              },
                                              success: function(data) {
                                                  //console.log(data);
                                                  $(".tableketerangan").html(data);
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
                      $(".btn-simpan2").click(function(e) {

                          $("#edit2").modal('hide');

                          e.preventDefault();


                          var id2 = $("input[name=id]").val();
                          var id_dokter_irj2 = $("#id_dokter_irj4 :selected").val();
                          var pasien_lama2 = $("input[name=pasien_lama2]").val();
                          var pasien_baru2 = $("input[name=pasien_baru2]").val();

                          console.log(id2 + ' - ' + id_dokter_irj2 + ' - ' + pasien_lama2 + ' - ' + pasien_baru2);
                          var url = 'editirjdetail';

                          $.ajax({
                              url: url,
                              method: 'PUT',
                              data: {
                                  _token: "{{ csrf_token() }}",
                                  id: id2,
                                  id_dokter_irj: id_dokter_irj2,
                                  pasien_lama: pasien_lama2,
                                  pasien_baru: pasien_baru2
                              },
                              success: function(response) {
                                  if (response.success == true) {

                                      alert(response.message) //Message come from controller
                                      $.ajax({
                                          type: "get",
                                          url: 'refresh-irj-detail/',
                                          data: {
                                              "_token": "{{ csrf_token() }}",
                                          },
                                          success: function(data) {
                                              //console.log(data);
                                              $(".tableketerangan").html(data);
                                          }
                                      });
                                  } else {
                                      alert(response.message) //Message come from controller
                                  }
                              },
                              error: function(error) {
                                  console.log(error)
                              }
                          });
                      });

                      $(".btn-tambah2").click(function(e) {

                          $("#tambah2").modal('hide');

                          e.preventDefault();

                          var id_dokter_irj = $("#id_dokter_irj3 :selected").val();
                          var pasien_lama = $("input[name=pasien_lama]").val();
                          var pasien_baru = $("input[name=pasien_baru]").val();

                          var x = parseInt($("#hitungketerangan").val()) + 1;
                          $("#hitungketerangan").val(x)




                          console.log(id_dokter_irj + ' ' + pasien_lama + ' ' + pasien_baru);
                          var url = 'tambahirjdetail';

                          $.ajax({
                              url: url,
                              method: 'POST',
                              data: {
                                  _token: "{{ csrf_token() }}",
                                  id_dokter_irj: id_dokter_irj,
                                  pasien_lama: pasien_lama,
                                  pasien_baru: pasien_baru
                              },
                              success: function(response) {
                                  if (response.success) {
                                      $("#id_dokter_irj").val("");
                                      $("input[name=pasien_lama]").val("");
                                      $("input[name=pasien_baru]").val("");
                                      alert(response.message) //Message come from controller
                                      $.ajax({
                                          type: "get",
                                          url: 'refresh-irj-detail/',
                                          data: {
                                              "_token": "{{ csrf_token() }}",
                                          },
                                          success: function(data) {
                                              //console.log(data);
                                              $(".tableketerangan").html(data);
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
                      // In your Javascript (external .js resource or <script> tag)
                      $(document).ready(function() {
                          $('.select2').select2();
                      });
                  </script>
