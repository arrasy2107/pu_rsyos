<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistem Laporan Pengawas Umum RSYOS">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PU RSYS') }}</title>
    <link rel="icon" href="{{ asset('sb-admin/img/rsyos.png') }}">

    {{-- Font Awesome --}}
    <link href="{{ asset('sb-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

    {{-- Modern Design System (overrides Bootstrap) --}}
    @vite(['resources/css/pu-modern.css'])

    @livewireStyles

    <style>
        /* Disable spinner on input type number */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>

    @yield('custom_style')
</head>

<body id="page-top">
    <div id="wrapper">

        {{-- ============================================================ --}}
        {{-- SIDEBAR --}}
        {{-- ============================================================ --}}
        @include('layouts.sidebar')

        {{-- Sidebar overlay for mobile --}}
        <div class="pu-sidebar-overlay" id="sidebar-overlay"></div>

        {{-- ============================================================ --}}
        {{-- CONTENT WRAPPER --}}
        {{-- ============================================================ --}}
        <div id="content-wrapper">

            {{-- ——— TOPBAR ——— --}}
            @include('layouts.topbar')

            {{-- ——— PAGE CONTENT ——— --}}
            <div id="page-content">
                @yield('content')
            </div>

            @include('layouts.footer')

        </div>{{-- end #content-wrapper --}}
    </div>{{-- end #wrapper --}}

    {{-- ============================================================ --}}
    {{-- MODALS --}}
    {{-- ============================================================ --}}
    @stack('modals')

    {{-- ============================================================ --}}
    {{-- SCRIPTS --}}
    {{-- ============================================================ --}}
    <script src="{{ asset('sb-admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sb-admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    @vite('resources/js/app.js')
    <x-sweet-alert />

    <script>
        (function() {
            // Mobile sidebar toggle
            var sidebar = document.getElementById('pu-sidebar');
            var overlay = document.getElementById('sidebar-overlay');
            var toggleBtn = document.getElementById('sidebar-toggle');

            function openSidebar() {
                sidebar.classList.add('show');
                overlay.classList.add('show');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }

            if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
            if (overlay) overlay.addEventListener('click', closeSidebar);

            // Auto-fade alerts
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert-call, .alert-call2, .alert-call3, .alert-call4');
                alerts.forEach(function(el) {
                    el.style.transition = 'opacity 0.6s ease';
                    el.style.opacity = '0';
                    setTimeout(function() {
                        el.style.display = 'none';
                    }, 600);
                });
            }, 3500);

            // Disable scroll wheel changing value on input type number
            document.addEventListener('wheel', function(event) {
                if (event.target.type === 'number') {
                    event.preventDefault();
                }
            }, { passive: false });
        })();
    </script>

    @yield('custom_script')
    @stack('scripts')

    @livewireScripts

</body>

</html>
