@extends('master.loginregister')

<title>Ganti Password </title>
@section('content')
<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center h-100">

        <div class=" col-md-6  my-auto">
            <img src="{{asset('sb-admin/img/rsyos.png')}}" style=" display: block;margin-top:50px;margin-left: auto;margin-right: auto;">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">

                        <div class="col-lg-12 ">
                            <div class="p-5">

                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Ganti Password</h1>
                                </div>
                               
                                @if($errors->any())
                                <div class="alert alert-danger alert-call">
                                    {{ $errors->first() }}
                                </div>
                                @endif
                                @if (Session::has('success-change'))
                                <div class="alert alert-success alert-call">
                                    <p>{{ Session::get('success-change') }}</p>
                                </div>
                                @endif
                                <form method="post" action="{{ route('gantipassword2') }}">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                 
                                    <div class="form-group">
                                    <label>Username: </label>
                                    <input type="text" class="form-control txt-email" autocomplete="nope" name="username" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Password Lama: </label>
                                        <div class="input-group" id="show_hide_password">
                                            <input type="password" class="form-control" name="passlama" autocomplete="new-password" required />
                                            <div class="input-group-addon" style="margin-top:10px;margin-left:10px">
                                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Password Baru: </label>
                                        <div class="input-group" id="show_hide_password2">
                                            <input type="password" class="form-control" name="password"  required />
                                            <div class="input-group-addon" style="margin-top:10px;margin-left:10px">
                                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Ganti
                                    </button>

                                    <br>
                                    <p style="text-align:center">Sudah Ganti Password ? <a href="{{ route('login') }}">Login</a></p>


                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

@endsection
@section('custom_script')
<script>

$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        }
    });
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
@stop