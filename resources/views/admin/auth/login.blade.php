@extends('master.loginregister')

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
                                    <h1 class="h4 text-gray-900 mb-4">Laporan Pengawas Umum</h1>
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
                                <form method="POST" action="{{ route('dologin') }}" autocomplete="off">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="username" name="username" autocomplete="nope" placeholder="Username">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password" name="password" autocomplete="new-password" placeholder="Password">
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>


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

@stop