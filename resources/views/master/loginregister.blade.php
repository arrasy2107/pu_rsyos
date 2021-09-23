<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Login</title>
  <!-- logo -->
  <link rel="icon" href="{{asset('sb-admin/img/rsyos.png')}}">

  <!-- Custom fonts for this template-->
  <link href="{{asset('sb-admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  
  <!-- <link rel="stylesheet" type="text/css" href="{{asset('theme/css/font-awesome.css')}}"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <!-- Custom styles for this template-->
  <link href="{{asset('sb-admin/css/sb-admin-2.min.css')}}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,300,400,500,700,900" rel="stylesheet">
</head>

<body class="" style="background-color: #fff">
  @yield('content')


  <!-- Bootstrap core JavaScript-->
  <script src="{{asset('sb-admin/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('sb-admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{asset('sb-admin/js/sb-admin-2.min.js')}}"></script>
  
  <script type="javascript">
    console.log($("#"+d));
    
  </script>
  <script>
    $(function() {
      $(".alert-call").fadeOut(3000);
    });
  </script>
   @yield('custom_script')
</body>

</html>