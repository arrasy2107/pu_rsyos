<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Login — Sistem Laporan Pengawas Umum RSYOS">
    <title>Login | PU RSYS</title>
    <link rel="icon" href="{{ asset('sb-admin/img/rsyos.png') }}">

    {{-- Font Awesome --}}
    <link href="{{ asset('sb-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

    {{-- Design System --}}
    @vite(['resources/css/pu-modern.css'])

    <style>
        body {
            overflow: hidden;
        }

        @media (max-width: 768px) {
            body {
                overflow: auto;
            }
        }
    </style>

    @yield('custom_style')
</head>

<body>
    @yield('content')

    <script src="{{ asset('sb-admin/vendor/jquery/jquery.min.js') }}"></script>
    @vite('resources/js/app.js')
    <x-sweet-alert />
    @yield('custom_script')
</body>

</html>
