@extends('master.loginregister')

@section('content')
<div class="pu-login-page">

    {{-- Background foto gedung RS --}}
    <div class="pu-login-bg"></div>
    <div class="pu-login-overlay"></div>

    {{-- Card utama --}}
    <div class="pu-login-panel">
        <div class="pu-login-panel-card">

            {{-- Header: Logo + Nama RS + Judul --}}
            <div class="pu-login-header text-center">
                <img src="{{ asset('images/logo_rsys.png') }}" alt="Logo RS Yos Sudarso" class="pu-login-logo">
                <p class="pu-login-rs-name">RS YOS SUDARSO PADANG</p>
                <h2 class="pu-login-title">
                    <span class="title-white">Sistem Laporan Pengawas Umum</span>
                </h2>
            </div>

            {{-- Subheader --}}
            <div class="pu-login-subheader">
                <p class="pu-login-welcome">Selamat Datang</p>
                <p class="pu-login-sub">Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            <x-alert />

            <form method="POST" action="{{ route('dologin') }}" autocomplete="off" id="login-form">
                @csrf

                {{-- Username --}}
                <div class="form-group pu-login-form-group">
                    <label for="username">USERNAME / NIP</label>
                    <div class="pu-login-input-wrapper">
                        <div class="pu-login-input-icon"><i class="fas fa-user"></i></div>
                        <input type="text" class="form-control pu-login-input" id="username" name="username"
                            autocomplete="nope" placeholder="Masukkan username atau NIP" required>
                    </div>
                </div>

                {{-- Password --}}
                <div class="form-group pu-login-form-group">
                    <label for="password">PASSWORD</label>
                    <div class="pu-login-input-wrapper">
                        <div class="pu-login-input-icon"><i class="fas fa-lock"></i></div>
                        <input type="password" class="form-control pu-login-input" id="password" name="password"
                            autocomplete="new-password" placeholder="Masukkan password" required>
                        <button type="button" class="btn-input-icon" id="toggle-pwd" aria-label="Tampilkan password">
                            <i class="fas fa-eye" id="pwd-eye"></i>
                        </button>
                    </div>
                </div>

                {{-- Remember + Lupa Password --}}
                <div class="pu-login-meta">
                    <label class="pu-remember-label">
                        <input type="checkbox" name="remember" id="remember" class="pu-remember-check">
                        <span>Ingat saya</span>
                    </label>
                    <a href="#" class="pu-forgot-link">Lupa password?</a>
                </div>

                <button type="submit" class="btn btn-primary btn-login-submit w-100" id="login-btn" disabled>
                    <i class="fas fa-arrow-right-to-bracket me-2"></i>
                    Masuk
                </button>
            </form>

            {{-- Footer --}}
            <div class="pu-login-footer text-center">
                <p class="pu-footer-info">
                    Tidak punya akun? <a href="#" class="pu-footer-link">Hubungi IT RSYS untuk akses</a>
                </p>
                <p class="pu-footer-copy">&copy; {{ date('Y') }} RS Yos Sudarso Padang</p>
            </div>

        </div>
    </div>

    {{-- Tombol bantuan pojok kanan bawah --}}
    <button class="pu-help-btn" title="Bantuan">?</button>

</div>
@endsection

@section('custom_style')
<style>
    * { box-sizing: border-box; }

    /* === BACKGROUND === */
    body { margin: 0; padding: 0; overflow: hidden; }

    .pu-login-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        position: relative;
    }

    .pu-login-bg {
        position: fixed;
        inset: 0;
        background: url('{{ asset('images/pic_rsys01.jpeg') }}') center center / cover no-repeat;
        z-index: 0;
    }

    .pu-login-overlay {
        position: fixed;
        inset: 0;
        background: rgba(10, 20, 50, 0.58);
        backdrop-filter: blur(1px);
        z-index: 1;
    }

    /* === PANEL === */
    .pu-login-panel {
        width: 100%;
        max-width: 420px;
        position: relative;
        z-index: 2;
    }

    .pu-login-panel-card {
        width: 100%;
        border-radius: 24px;
        padding: 2.25rem 2.25rem 1.75rem;
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(28px) saturate(1.4);
        -webkit-backdrop-filter: blur(28px) saturate(1.4);
        border: 1px solid rgba(255, 255, 255, 0.22);
        box-shadow: 0 32px 64px rgba(0, 0, 0, 0.35), inset 0 1px 0 rgba(255,255,255,0.18);
    }

    /* === HEADER === */
    .pu-login-header {
        margin-bottom: 1.5rem;
    }

    .pu-login-logo {
        width: 90px;
        height: auto;
        display: block;
        margin: 0 auto 1rem;
        filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.4));
    }

    .pu-login-rs-name {
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.75);
        margin-bottom: 0.4rem;
    }

    .pu-login-title {
        font-size: 1.6rem;
        font-weight: 800;
        line-height: 1.25;
        margin-bottom: 0;
    }

    .title-white { color: #ffffff; }
    .title-blue  { color: #60a5fa; }

    /* === SUBHEADER === */
    .pu-login-subheader {
        margin-bottom: 1.25rem;
    }

    .pu-login-welcome {
        font-size: 1.05rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 0.15rem;
    }

    .pu-login-sub {
        font-size: 0.82rem;
        color: rgba(255,255,255,0.62);
        margin-bottom: 0;
    }

    /* === FORM === */
    .pu-login-form-group {
        margin-bottom: 1.1rem;
    }

    .pu-login-form-group label {
        display: block;
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.65);
        margin-bottom: 0.5rem;
    }

    .pu-login-input-wrapper {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        border-radius: 14px;
        border: 1px solid rgba(255,255,255,0.18);
        background: rgba(255,255,255,0.10);
        padding: 0.25rem 0.5rem;
        transition: border-color 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
    }

    .pu-login-input-wrapper:focus-within {
        border-color: rgba(96,165,250,0.7);
        background: rgba(255,255,255,0.15);
        box-shadow: 0 0 0 4px rgba(96,165,250,0.18);
    }

    .pu-login-input-icon {
        width: 40px;
        min-width: 40px;
        height: 40px;
        display: grid;
        place-items: center;
        border-radius: 10px;
        background: rgba(255,255,255,0.12);
        color: rgba(255,255,255,0.70);
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .pu-login-input {
        flex: 1;
        border: none;
        background: transparent;
        min-height: 46px;
        font-size: 0.95rem;
        color: #fff;
        padding: 0.6rem 0.25rem;
        outline: none;
    }

    .pu-login-input::placeholder { color: rgba(255,255,255,0.40); }
    .form-control:focus { outline: none; box-shadow: none; }

    .btn-input-icon {
        width: 40px;
        height: 40px;
        display: grid;
        place-items: center;
        border: none;
        border-radius: 10px;
        background: rgba(255,255,255,0.10);
        color: rgba(255,255,255,0.60);
        cursor: pointer;
        transition: background 0.2s ease, color 0.2s ease;
        flex-shrink: 0;
    }

    .btn-input-icon:hover {
        background: rgba(255,255,255,0.20);
        color: #fff;
    }

    /* === REMEMBER + LUPA === */
    .pu-login-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
    }

    .pu-remember-label {
        display: flex;
        align-items: center;
        gap: 0.45rem;
        font-size: 0.82rem;
        color: rgba(255,255,255,0.70);
        cursor: pointer;
        user-select: none;
    }

    .pu-remember-check {
        width: 15px; height: 15px;
        border-radius: 4px;
        accent-color: #3b82f6;
        cursor: pointer;
    }

    .pu-forgot-link {
        font-size: 0.82rem;
        color: rgba(255,255,255,0.70);
        text-decoration: none;
        transition: color 0.2s;
    }

    .pu-forgot-link:hover { color: #60a5fa; }

    /* === TOMBOL MASUK === */
    .btn-login-submit {
        padding: 0.85rem 1rem;
        font-size: 1rem;
        font-weight: 700;
        border-radius: 14px;
        background: linear-gradient(135deg, #1e40af 0%, #2563eb 60%, #3b82f6 100%);
        border: none;
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.40);
        color: #fff;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        margin-top: 0.25rem;
    }

    .btn-login-submit:hover:not(:disabled) {
        transform: translateY(-1px);
        box-shadow: 0 12px 30px rgba(37, 99, 235, 0.50);
    }

    .btn-login-submit:disabled {
        opacity: 0.55;
        cursor: not-allowed;
        box-shadow: none;
    }

    /* === FOOTER === */
    .pu-login-footer {
        margin-top: 1.5rem;
    }

    .pu-footer-info {
        font-size: 0.78rem;
        color: rgba(255,255,255,0.55);
        margin-bottom: 0.3rem;
    }

    .pu-footer-link {
        color: #60a5fa;
        text-decoration: none;
        font-weight: 600;
    }

    .pu-footer-link:hover { color: #93c5fd; text-decoration: underline; }

    .pu-footer-copy {
        font-size: 0.72rem;
        color: rgba(255,255,255,0.35);
        margin-bottom: 0;
    }

    /* === TOMBOL BANTUAN === */
    .pu-help-btn {
        position: fixed;
        bottom: 1.5rem;
        right: 1.5rem;
        z-index: 10;
        width: 38px; height: 38px;
        border-radius: 50%;
        background: rgba(255,255,255,0.18);
        border: 1px solid rgba(255,255,255,0.25);
        color: rgba(255,255,255,0.75);
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        display: grid;
        place-items: center;
        backdrop-filter: blur(8px);
        transition: background 0.2s, color 0.2s;
    }

    .pu-help-btn:hover {
        background: rgba(255,255,255,0.30);
        color: #fff;
    }

    /* === ALERT === */
    .pu-login-panel-card .alert-call {
        border-radius: 14px;
        background: rgba(239,68,68,0.20);
        border: 1px solid rgba(239,68,68,0.35);
        color: #fecaca;
        margin-bottom: 1rem;
        font-size: 0.85rem;
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        body { overflow: auto; }
        .pu-login-page { padding: 1.25rem; align-items: flex-start; padding-top: 3rem; }
        .pu-login-panel-card { padding: 1.75rem 1.5rem; }
    }
</style>
@endsection

@section('custom_script')
<script>
    // Toggle password visibility
    var toggleBtn = document.getElementById('toggle-pwd');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            var pwd  = document.getElementById('password');
            var eye  = document.getElementById('pwd-eye');
            var show = pwd.type === 'password';
            pwd.type = show ? 'text' : 'password';
            eye.classList.toggle('fa-eye',       !show);
            eye.classList.toggle('fa-eye-slash',  show);
        });
    }

    // Aktifkan tombol Masuk hanya jika username + password terisi
    var usernameInput = document.getElementById('username');
    var passwordInput = document.getElementById('password');
    var loginBtn      = document.getElementById('login-btn');

    function updateLoginButtonState() {
        if (!loginBtn) return;
        loginBtn.disabled = !(usernameInput?.value.trim() && passwordInput?.value.trim());
    }

    usernameInput?.addEventListener('input', updateLoginButtonState);
    passwordInput?.addEventListener('input', updateLoginButtonState);
    updateLoginButtonState();

    // Loading state saat submit
    document.getElementById('login-form')?.addEventListener('submit', function () {
        if (!loginBtn) return;
        loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
        loginBtn.disabled  = true;
    });

    // Auto-hide alert setelah 4 detik
    setTimeout(function () {
        document.querySelectorAll('.alert-call').forEach(function (el) {
            el.style.transition = 'opacity 0.5s ease';
            el.style.opacity    = '0';
            setTimeout(function () { el.style.display = 'none'; }, 500);
        });
    }, 4000);
</script>
@stop
