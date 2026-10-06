@php
$user = Auth::user();
$userName = $user->nama ?? $user->name ?? 'U';
@endphp

<div class="pu-topbar">
    {{-- Mobile toggle --}}
    <button class="pu-topbar-toggle" id="sidebar-toggle" type="button">
        <i class="fas fa-bars"></i>
    </button>

    {{-- Page Title --}}
    <div class="pu-topbar-title">
        <!-- <h1>@yield('page_title', config('app.name', 'PU RSYS'))</h1> -->
    </div>

    {{-- Actions --}}
    <div class="pu-topbar-actions">
        @if($user)
        <div class="pu-topbar-user-wrap d-none d-md-flex" id="topbar-user-menu">
            <button class="pu-topbar-user pu-topbar-user-trigger" type="button" id="topbar-user-toggle" aria-haspopup="true" aria-expanded="false">
                <span class="pu-topbar-user-name">{{ $userName }}</span>
                <span class="pu-topbar-user-arrow"><i class="fas fa-chevron-down"></i></span>
                <div class="pu-topbar-user-avatar">
                    {{ strtoupper(substr($userName, 0, 1)) }}
                </div>
            </button>

            <div class="pu-topbar-dropdown" id="topbar-user-dropdown" role="menu" aria-label="Profil menu">
                <a href="{{ route('ganti-password') }}" class="pu-topbar-dropdown-item js-change-password" role="menuitem"><i class="fas fa-key"></i>Ganti Password</a>
                <a href="{{ route('logout') }}" class="pu-topbar-dropdown-item js-logout" role="menuitem"><i class="fas fa-sign-out-alt"></i>Keluar</a>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toggle = document.getElementById('topbar-user-toggle');
        var dropdown = document.getElementById('topbar-user-dropdown');

        if (toggle && dropdown) {
            toggle.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();
                var isOpen = dropdown.classList.toggle('show');
                toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });

            dropdown.addEventListener('click', function(event) {
                event.stopPropagation();
            });

            document.addEventListener('click', function() {
                if (dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                    toggle.setAttribute('aria-expanded', 'false');
                }
            });
        }

        document.querySelectorAll('.js-logout').forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                var logoutUrl = this.href;

                window.PUAlert.confirm({
                    title: 'Keluar dari aplikasi?',
                    text: 'Anda perlu masuk kembali untuk melanjutkan.',
                    icon: 'question',
                    confirmButtonText: 'Ya, keluar'
                }).then(function(confirmed) {
                    if (confirmed) window.location.href = logoutUrl;
                });
            });
        });

        document.querySelectorAll('.js-change-password').forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                var changePasswordUrl = this.href;

                window.PUAlert.confirm({
                    title: 'Ganti password akun?',
                    text: 'Anda akan diarahkan ke halaman untuk memperbarui password akun aktif.',
                    icon: 'question',
                    confirmButtonText: 'Ya, lanjutkan'
                }).then(function(confirmed) {
                    if (confirmed) window.location.href = changePasswordUrl;
                });
            });
        });
    });
</script>
