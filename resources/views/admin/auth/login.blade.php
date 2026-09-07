@extends('master.loginregister')

@section('content')
<div class="pu-login-page">
    <div class="pu-login-panel">
        <div class="pu-login-panel-card">
            <div class="pu-login-header text-center">
                <img src="{{ asset('images/logo_rsys.jpeg') }}" alt="RSYOS" class="pu-login-logo" />
                <h3>Selamat Datang</h3>
                <p class="text-muted">Masuk ke akun Anda untuk melanjutkan.</p>
            </div>

            <x-alert />

            <form method="POST" action="{{ route('dologin') }}" autocomplete="off" id="login-form">
                @csrf

                <x-form-field
                    id="username"
                    name="username"
                    label="Username / NIP"
                    placeholder="Masukkan username atau NIP"
                    icon="fas fa-user"
                    autocomplete="nope" />

                <x-form-field
                    type="password"
                    id="password"
                    name="password"
                    label="Password"
                    placeholder="Masukkan password"
                    icon="fas fa-lock"
                    autocomplete="new-password"
                    append="toggle-pwd" />

                <button type="submit" class="btn btn-primary btn-login-submit w-100" id="login-btn" disabled>
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Masuk
                </button>
            </form>

            <div class="pu-login-footer text-center">
                <p class="small text-muted mb-1">Tidak punya akun?</p>
                <p class="small text-primary mb-0">Hubungi IT RSYS untuk akses.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_style')
<style>
    body {
        background: #f8fafc;
    }

    .pu-login-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .pu-login-panel {
        width: 100%;
        max-width: 420px;
    }

    .pu-login-panel-card {
        width: 100%;
        border-radius: 28px;
        padding: 2.5rem;
        background: #ffffff;
        box-shadow: 0 32px 60px rgba(15, 23, 42, 0.12);
        border: 1px solid rgba(15, 23, 42, 0.06);
    }

    .pu-login-header {
        margin-bottom: 2rem;
    }

    .pu-login-logo {
        width: 84px;
        height: auto;
        margin-bottom: 1rem;
        border-radius: 20px;
        background: rgba(14, 165, 233, 0.1);
        padding: 0.85rem;
    }

    .pu-login-header h3 {
        font-size: 1.85rem;
        font-weight: 800;
        margin-bottom: 0.35rem;
        color: #0f172a;
    }

    .pu-login-header p {
        color: #64748b;
        margin-bottom: 0;
        font-size: 0.98rem;
    }

    .pu-login-panel-card .alert-call {
        border-radius: 18px;
    }

    .pu-login-form-group {
        margin-bottom: 1.25rem;
    }

    .pu-login-form-group label {
        display: block;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: #475569;
        margin-bottom: 0.85rem;
    }

    .pu-login-input-wrapper {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        border-radius: 24px;
        border: 1px solid #dbeafe;
        background: #f8fbff;
        padding: 0.35rem 0.65rem;
        transition: border-color 0.25s ease, box-shadow 0.25s ease;
    }

    .pu-login-input-wrapper:focus-within {
        border-color: #2563eb;
        box-shadow: 0 0 0 8px rgba(37, 99, 235, 0.12);
    }

    .pu-login-input-icon {
        width: 50px;
        min-width: 50px;
        height: 50px;
        display: grid;
        place-items: center;
        border-radius: 16px;
        background: #eff6ff;
        color: #1d4ed8;
        box-shadow: inset 0 1px 2px rgba(15, 23, 42, 0.08);
    }

    .pu-login-input {
        flex: 1;
        border: none;
        background: transparent;
        min-height: 56px;
        font-size: 1rem;
        color: #0f172a;
        padding: 0.95rem 0.5rem;
        outline: none;
    }

    .pu-login-input::placeholder {
        color: #94a3b8;
    }

    .btn-input-icon {
        width: 50px;
        height: 50px;
        display: grid;
        place-items: center;
        border: none;
        border-radius: 16px;
        background: #eff6ff;
        color: #475569;
        cursor: pointer;
        transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
    }

    .btn-input-icon:hover {
        background: #dbeafe;
        color: #1d4ed8;
        transform: translateY(-1px);
    }

    .btn-input-icon:focus {
        outline: none;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
    }

    .form-control:focus {
        outline: none;
        box-shadow: none;
    }

    .btn-login-submit {
        padding: 1rem 1rem;
        font-size: 1rem;
        font-weight: 700;
        border-radius: 18px;
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        border: none;
        box-shadow: 0 18px 32px rgba(37, 99, 235, 0.18);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .btn-login-submit:hover:not(:disabled) {
        transform: translateY(-1px);
        box-shadow: 0 22px 38px rgba(37, 99, 235, 0.2);
    }

    .btn-login-submit:disabled {
        opacity: 0.65;
        cursor: not-allowed;
        box-shadow: none;
    }

    .pu-login-footer {
        margin-top: 1.75rem;
    }

    .pu-login-footer .small {
        color: #64748b;
    }

    .pu-login-footer .text-primary {
        color: #2563eb !important;
    }

    @media (max-width: 768px) {
        .pu-login-page {
            padding: 1.5rem;
        }

        .pu-login-panel-card {
            padding: 2rem;
        }
    }
</style>
@endsection

@section('custom_script')
<script>
    var toggleBtn = document.getElementById('toggle-pwd');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            var pwd = document.getElementById('password');
            var eye = document.getElementById('pwd-eye');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                eye.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                pwd.type = 'password';
                eye.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    }

    var usernameInput = document.getElementById('username');
    var passwordInput = document.getElementById('password');
    var loginBtn = document.getElementById('login-btn');

    function updateLoginButtonState() {
        if (!loginBtn) return;
        var isValid = usernameInput && usernameInput.value.trim() && passwordInput && passwordInput.value.trim();
        loginBtn.disabled = !isValid;
    }

    if (usernameInput) {
        usernameInput.addEventListener('input', updateLoginButtonState);
    }
    if (passwordInput) {
        passwordInput.addEventListener('input', updateLoginButtonState);
    }

    updateLoginButtonState();

    var loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function() {
            if (!loginBtn) return;
            loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
            loginBtn.disabled = true;
        });
    }

    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert-call');
        alerts.forEach(function(el) {
            el.style.transition = 'opacity 0.5s ease';
            el.style.opacity = '0';
            setTimeout(function() {
                el.style.display = 'none';
            }, 500);
        });
    }, 4000);
</script>
@stop
