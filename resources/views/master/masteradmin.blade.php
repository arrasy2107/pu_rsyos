<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Laporan Pengawas Umum Rumah Sakit Yos Sudarso Padang</title>
  <!-- logo -->
  <link rel="icon" href="{{asset('sb-admin/img/rsyos.png')}}">
  <!-- Custom fonts for this template-->
  <link href="{{asset('sb-admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{asset('sb-admin/css/datatable.css')}}" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="{{asset('sb-admin/css/sb-admin-2.min.css')}}" rel="stylesheet">

  <style>
    .sidebar-dark .nav-item.active .nav-link {

      background-color: midnightblue;
    }
  </style>
<style>
thead {
    background-color:slategrey;
        color:white;
}
</style>

  @yield('custom_style')
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->


      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('dashboard')}}">
        <div class="sidebar-brand-icon">
          <img src="{{asset('sb-admin/img/rsyos.png')}}" style=" width:100%;height:100%;display: block;margin-top:auto;margin-left: auto;margin-right: auto;">

        </div>
        <!-- <div class="sidebar-brand-text mx-3">teeto.id</div> -->
      </a>
      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      @if(Route::current()->getName() == 'dashboard')
      <li class="nav-item active">
        @else
      <li class="nav-item">
        @endif
        <a class="nav-link" href="{{route('dashboard')}}">
          <i class="far fa-file-alt	"></i>
          <span>Laporan Terbaru</span></a>
      </li>

      <!-- Divider -->
      <!-- <hr class="sidebar-divider my-0"> -->

      <!-- Heading -->
      <!-- <div class="sidebar-heading">
        Laporan
      </div> -->
      @if(Route::current()->getName() == 'riwayat-laporan-pu-belum' || Route::current()->getName() == 'riwayat-laporan-pu-sudah')
      <li class="nav-item active">
        @else
      <li class="nav-item">
        @endif
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRiwayat" aria-expanded="true" aria-controls="collapseRiwayat">
          <i class="fas fa-history"></i>
          <span>Riwayat Laporan</span>
        </a>
        <div id="collapseRiwayat" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">

            <a class="collapse-item" href="{{route('riwayat-laporan-pu-belum')}}">Belum diverifikasi</a>
            <a class="collapse-item" href="{{route('riwayat-laporan-pu-sudah')}}">Sudah diverifikasi</a>
          </div>
        </div>
      </li>





      @if(Route::current()->getName() == 'grafik-laporan')
      <li class="nav-item active">
        @else
      <li class="nav-item">
        @endif
        <a class="nav-link" href="{{route('grafik-laporan')}}">
          <i class="fas fa-chart-bar"></i>
          <span>Grafik Laporan</span></a>
      </li>
      
      @if(\Auth::user()->id_role == 3)
      @if(Route::current()->getName() == 'jadwal-dinas')
      <li class="nav-item active">
        @else
      <li class="nav-item">
        @endif
        <a class="nav-link" href="{{route('jadwal-dinas')}}">
          <i class="far fa-calendar-alt"></i>
          <span>Jadwal Dinas</span></a>
      </li>
      @endif

      @if(Route::current()->getName() == 'data-pengawas-umum')
      <li class="nav-item active">
        @else
      <li class="nav-item">
        @endif
        <a class="nav-link" href="{{route('data-pengawas-umum')}}">
          <i class="fa fa-users"></i>
          <span>Data Pengawas Umum</span></a>
      </li>



      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">


      <!-- Heading -->
      <div class="sidebar-heading">
        Data Master
      </div>

      @if(Route::current()->getName() == 'data-ruangan')
      <li class="nav-item active">
        @else
      <li class="nav-item">
        @endif
        <a class="nav-link" href="{{route('data-ruangan')}}">
          <i class="fas fa-procedures	"></i>
          <span>Ruangan</span></a>
      </li>


      <!-- Nav Item - Pages Collapse Menu -->
      @if(Route::current()->getName() == 'data-subrumpun-sdmk' || Route::current()->getName() == 'data-jenis-sdmk')
      <li class="nav-item active">
        @else
      <li class="nav-item">
        @endif
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          <i class="fas fa-users	"></i>
          <span>SDMK</span>
        </a>
        <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="white-space: normal;">Sumber Daya Manusia Kesehatan (SDMK):</h6>
            <a class="collapse-item" href="{{route('data-subrumpun-sdmk')}}">Subrumpun SDMK</a>
            <a class="collapse-item" href="{{route('data-jenis-sdmk')}}">Jenis SDMK</a>
          </div>
        </div>
      </li>


      @if(Route::current()->getName() == 'data-dokter' || Route::current()->getName() == 'data-dokter-irj')
      <li class="nav-item active">
        @else
      <li class="nav-item">
        @endif
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-user-md"></i>
          <span>Dokter</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">

            <a class="collapse-item" href="{{route('data-dokter')}}">Dokter Jaga (IGD)</a>
            <a class="collapse-item" href="{{route('data-dokter-irj')}}">Dokter IRJ</a>
          </div>
        </div>
      </li>
      @if(\Auth::user()->id_role == 1)
      @if(Route::current()->getName() == 'data-pengguna')
      <li class="nav-item active">
        @else
      <li class="nav-item">
        @endif
        <a class="nav-link" href="{{route('data-pengguna')}}">
          <i class="fas fa-user-friends	"></i>
          <span>Pengguna</span></a>
      </li>
      @endif


      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      @if(\Auth::user()->id_role == 1)
      @if(Route::current()->getName() == 'log')
      <li class="nav-item active">
        @else
      <li class="nav-item">
        @endif
        <a class="nav-link" href="{{route('log')}}">
          <i class="fas fa-folder	"></i>
          <span>Log Aktivitas</span></a>
      </li>
      @endif

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>



          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>

            </li>

            <!-- Nav Item - Alerts -->




            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ \Auth::user()->nama }}</span>
                <img class="img-profile rounded-circle" src="{{asset('sb-admin/img/user.png')}}">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                <a class="dropdown-item btn-edit" href="#" data-toggle="modal" data-target="#gantipassword" data-id="{{\Auth::user()->id }}" data-email="{{ \Auth::user()->username }}" data-nama="{{ \Auth::user()->name }}">
                  <i class="fas fa-lock fa-sm fa-fw mr-2 text-gray-400"></i>
                  Change Password
                </a>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->
        @if (Session::has('success-change'))
        <div class="alert alert-success alert-call">
          <p>{{ Session::get('success-change') }}</p>
        </div>
        @endif

        @if (Session::has('fail-change'))
        <div class="alert alert-danger alert-call2">
          <p>{{ Session::get('fail-change') }}</p>
        </div>
        @endif
        @yield('content')
        <!-- Begin Page Content -->


      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Rumah Sakit Yos Sudarso Padang 2021</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="{{ route('logout') }}">Logout</a>
        </div>
      </div>
    </div>
  </div>
  <div id="gantipassword" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 align="center">Ganti Password</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>
        <div class="modal-body">
          <form method="post" action="{{ route('gantipassword') }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <input type="hidden" class="txtid" name="id">
            <div class="form-group">
              <label>Username: </label>
              <input type="text" class="form-control txt-email" value="{{\Auth::user()->username}}" name="email" readonly />
            </div>
            <div class="form-group">
              <label>Password Lama: </label>
                <div class="input-group" id="show_hide_password">
                <input type="password" class="form-control" name="passlama" autocomplete="off" required />
                  <div class="input-group-addon" style="margin-top:10px;margin-left:10px">
                  <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Password Baru: </label>
                <div class="input-group" id="show_hide_password2">
                <input type="password" class="form-control" name="password" autocomplete="off" required />
                    <div class="input-group-addon" style="margin-top:10px;margin-left:10px">
                    <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                  </div>
                </div>
            </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-selesai btn-primary">Ganti Password</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->


  <script src="{{asset('sb-admin/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('sb-admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{asset('sb-admin/js/sb-admin-2.min.js')}}"></script>

  <!-- Page level plugins -->
  <script src="{{asset('sb-admin/vendor/chart.js/Chart.min.js')}}"></script>

  <!-- Page level custom scripts
  <script src="{{asset('sb-admin/js/demo/chart-area-demo.js')}}"></script>
  <script src="{{asset('sb-admin/js/demo/chart-pie-demo.js')}}"></script> -->
  <!-- Page level plugins -->
  <script src="{{asset('sb-admin/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('sb-admin/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>





  <script>
    var id, email, nama;
    $(".btn-edit").click(function() {
      id = $(this).data('id');
      nama = $(this).data('nama');
      email = $(this).data('email');
    });

    $('#gantipassword').on('show.bs.modal', function() {
      $(".txtid").val(id);
      $(".txt-nama").val(nama);
      $(".txt-email").val(email);
    });

    $(".btn-profile").click(function() {
      id = $(this).data('id');
      nama = $(this).data('nama');
      email = $(this).data('email');

      wa = $(this).data('wa');
    });

    $('#profile').on('show.bs.modal', function() {
      $(".txtid").val(id);
      $(".txt-nama").val(nama);
      $(".txt-email").val(email);
      $(".txt-wa").val(wa);
    });
    (function($) {
      $(".alert-call").fadeOut(2500);
      $(".alert-call2").fadeOut(2500);


    })(jQuery);
  </script>
   <script>
$(document).ready(function() {
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });
});
    </script>
      <script>
$(document).ready(function() {
    $("#show_hide_password2 a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password2 input').attr("type") == "text"){
            $('#show_hide_password2 input').attr('type', 'password');
            $('#show_hide_password2 i').addClass( "fa-eye-slash" );
            $('#show_hide_password2 i').removeClass( "fa-eye" );
        }else if($('#show_hide_password2 input').attr("type") == "password"){
            $('#show_hide_password2 input').attr('type', 'text');
            $('#show_hide_password2 i').removeClass( "fa-eye-slash" );
            $('#show_hide_password2 i').addClass( "fa-eye" );
        }
    });
});
    </script>
  @yield('custom_script')
</body>

</html>