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
                    <span class="title-white">Ganti </span><span class="title-blue">Password</span>
                </h2>
            </div>

            {{-- Subheader --}}
            <div class="pu-login-subheader">
                <p class="pu-login-welcome">Perbarui Password Anda</p>
                <p class="pu-login-sub">Perbarui password untuk menjaga keamanan akun Anda.</p>
            </div>

            {{-- Notice --}}
            <div class="pu-password-notice">
                <i class="fas fa-shield-alt"></i>
                <span>Password default <strong>12345678</strong> harus segera diubah.</span>
            </div>

            <x-alert />

            <div class="pu-password-card-content">
                <form method="POST" action="{{ $activeUser ? route('gantipassword') : route('gantipassword2') }}" autocomplete="off" id="change-password-form">
                    @csrf
                    @method('PUT')

                    {{-- Username --}}
                    <div class="form-group pu-login-form-group">
                        <label for="username">USERNAME / NIP</label>
                        <div class="pu-login-input-wrapper {{ $activeUser || old('username', session('force_username')) ? 'input-readonly' : '' }}">
                            <div class="pu-login-input-icon"><i class="fas fa-user"></i></div>
                            <input type="text" class="form-control pu-login-input" id="username" name="username"
                                autocomplete="off" placeholder="Masukkan username atau NIP"
                                value="{{ $activeUser?->username ?? old('username', session('force_username')) }}"
                                {{ $activeUser || old('username', session('force_username')) ? 'readonly' : '' }}>
                        </div>
                    </div>

                    {{-- Password Lama --}}
                    <div class="form-group pu-login-form-group">
                        <label for="passlama">PASSWORD LAMA</label>
                        <div class="pu-login-input-wrapper">
                            <div class="pu-login-input-icon"><i class="fas fa-lock"></i></div>
                            <input type="password" class="form-control pu-login-input" id="passlama" name="passlama"
                                autocomplete="current-password" placeholder="Masukkan password lama" required>
                            <button type="button" class="btn-input-icon pwd-toggle" data-target="passlama" aria-label="Tampilkan password lama">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Password Baru --}}
                    <div class="form-group pu-login-form-group">
                        <label for="password">PASSWORD BARU</label>
                        <div class="pu-login-input-wrapper">
                            <div class="pu-login-input-icon"><i class="fas fa-lock-open"></i></div>
                            <input type="password" class="form-control pu-login-input" id="password" name="password"
                                autocomplete="new-password" placeholder="Masukkan password baru" required>
                            <button type="button" class="btn-input-icon pwd-toggle" data-target="password" aria-label="Tampilkan password baru">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-login-submit w-100" id="change-password-btn" disabled>
                        <i class="fas fa-floppy-disk me-2"></i>
                        Simpan Password Baru
                    </button>
                </form>
            </div>

            {{-- Footer --}}
            <div class="pu-login-footer text-center">
                <p class="pu-footer-info">
                    Sudah mengganti password? <a href="{{ route('login') }}" class="pu-footer-link">Kembali ke Login</a>
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

    body { margin: 0; padding: 0; }

    .pu-login-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
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

    .pu-login-panel {
        width: 100%;
        max-width: 430px;
        position: relative;
        z-index: 2;
        max-height: calc(100dvh - 3rem);
        display: flex;
        flex-direction: column;
    }

    .pu-login-panel-card {
        width: 100%;
        border-radius: 24px;
        padding: 2rem 2.25rem 1.75rem;
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(28px) saturate(1.4);
        -webkit-backdrop-filter: blur(28px) saturate(1.4);
        border: 1px solid rgba(255, 255, 255, 0.22);
        box-shadow: 0 32px 64px rgba(0, 0, 0, 0.35), inset 0 1px 0 rgba(255,255,255,0.18);
        overflow-y: auto;
        overscroll-behavior: contain;
    }

    .pu-login-panel-card::-webkit-scrollbar { width: 4px; }
    .pu-login-panel-card::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.25); border-radius: 999px; }
    .pu-login-panel-card::-webkit-scrollbar-track { background: transparent; }

    /* === HEADER === */
    .pu-login-header { margin-bottom: 1.25rem; }

    .pu-login-logo {
        width: 90px;
        height: auto;
        display: block;
        margin: 0 auto 1rem;
        filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.4));
    }

    .pu-login-rs-name {
        font-size: 0.67rem; font-weight: 700; letter-spacing: 0.14em;
        text-transform: uppercase; color: rgba(255,255,255,0.75); margin-bottom: 0.3rem;
    }

    .pu-login-title { font-size: 1.5rem; font-weight: 800; line-height: 1.2; margin-bottom: 0; }
    .title-white { color: #ffffff; }
    .title-blue  { color: #60a5fa; }

    /* === SUBHEADER === */
    .pu-login-subheader { margin-bottom: 1rem; }
    .pu-login-welcome { font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: 0.1rem; }
    .pu-login-sub { font-size: 0.80rem; color: rgba(255,255,255,0.60); margin-bottom: 0; }

    /* === NOTICE === */
    .pu-password-notice {
        display: flex; gap: 0.7rem; align-items: flex-start;
        margin-bottom: 1rem; padding: 0.75rem 0.9rem;
        border-radius: 12px;
        background: rgba(59, 130, 246, 0.18);
        border: 1px solid rgba(96, 165, 250, 0.30);
        color: #bfdbfe; font-size: 0.82rem; line-height: 1.5;
    }
    .pu-password-notice i { margin-top: 0.1rem; color: #60a5fa; }
    .pu-password-notice strong { color: #eff6ff; }

    /* === FORM === */
    .pu-password-card-content { }

    .pu-login-form-group { margin-bottom: 1rem; }

    .pu-login-form-group label {
        display: block; font-size: 0.63rem; font-weight: 700;
        letter-spacing: 0.18em; text-transform: uppercase;
        color: rgba(255,255,255,0.60); margin-bottom: 0.45rem;
    }

    .pu-login-input-wrapper {
        display: flex; align-items: center; gap: 0.55rem;
        border-radius: 14px;
        border: 1px solid rgba(255,255,255,0.18);
        background: rgba(255,255,255,0.10);
        padding: 0.2rem 0.45rem;
        transition: border-color 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
    }

    .pu-login-input-wrapper:focus-within {
        border-color: rgba(96,165,250,0.7);
        background: rgba(255,255,255,0.15);
        box-shadow: 0 0 0 4px rgba(96,165,250,0.18);
    }

    .input-readonly { opacity: 0.65; cursor: not-allowed; }

    .pu-login-input-icon {
        width: 38px; min-width: 38px; height: 38px;
        display: grid; place-items: center;
        border-radius: 10px;
        background: rgba(255,255,255,0.12);
        color: rgba(255,255,255,0.65); font-size: 0.82rem; flex-shrink: 0;
    }

    .pu-login-input {
        flex: 1; border: none; background: transparent;
        min-height: 42px; font-size: 0.92rem; color: #fff;
        padding: 0.55rem 0.2rem; outline: none;
    }

    .pu-login-input::placeholder { color: rgba(255,255,255,0.38); }
    .pu-login-input:read-only { color: rgba(255,255,255,0.55); }
    .form-control:focus { outline: none; box-shadow: none; }

    .btn-input-icon {
        width: 38px; height: 38px;
        display: grid; place-items: center; border: none;
        border-radius: 10px;
        background: rgba(255,255,255,0.10);
        color: rgba(255,255,255,0.55); cursor: pointer;
        transition: background 0.2s ease, color 0.2s ease; flex-shrink: 0;
    }
    .btn-input-icon:hover { background: rgba(255,255,255,0.20); color: #fff; }

    /* === TOMBOL SIMPAN === */
    .btn-login-submit {
        padding: 0.8rem 1rem; font-size: 0.95rem; font-weight: 700;
        border-radius: 14px;
        background: linear-gradient(135deg, #1e40af 0%, #2563eb 60%, #3b82f6 100%);
        border: none;
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.40);
        color: #fff; margin-top: 0.5rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .btn-login-submit:hover:not(:disabled) { transform: translateY(-1px); box-shadow: 0 12px 30px rgba(37, 99, 235, 0.50); }
    .btn-login-submit:disabled { opacity: 0.5; cursor: not-allowed; box-shadow: none; }

    /* === FOOTER === */
    .pu-login-footer { margin-top: 1.25rem; }
    .pu-footer-info { font-size: 0.77rem; color: rgba(255,255,255,0.52); margin-bottom: 0.25rem; }
    .pu-footer-link { color: #60a5fa; text-decoration: none; font-weight: 600; }
    .pu-footer-link:hover { color: #93c5fd; text-decoration: underline; }
    .pu-footer-copy { font-size: 0.7rem; color: rgba(255,255,255,0.32); margin-bottom: 0; }

    /* === TOMBOL BANTUAN === */
    .pu-help-btn {
        position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 10;
        width: 38px; height: 38px; border-radius: 50%;
        background: rgba(255,255,255,0.18);
        border: 1px solid rgba(255,255,255,0.25);
        color: rgba(255,255,255,0.75); font-size: 1rem; font-weight: 700;
        cursor: pointer; display: grid; place-items: center;
        backdrop-filter: blur(8px); transition: background 0.2s, color 0.2s;
    }
    .pu-help-btn:hover { background: rgba(255,255,255,0.30); color: #fff; }

    /* === ALERT === */
    .pu-login-panel-card .alert-call {
        border-radius: 12px;
        background: rgba(239,68,68,0.18);
        border: 1px solid rgba(239,68,68,0.32);
        color: #fecaca; margin-bottom: 0.85rem; font-size: 0.83rem;
    }

    @media (max-width: 768px) {
        body { overflow: auto; }
        .pu-login-page { padding: 1rem; align-items: flex-start; padding-top: 2rem; }
        .pu-login-panel { max-height: none; }
        .pu-login-panel-card { padding: 1.5rem 1.25rem; }
    }
</style>
@endsection

@section('custom_script')
<script>
    // Toggle semua password field
    document.querySelectorAll('.pwd-toggle').forEach(function (button) {
        button.addEventListener('click', function () {
            var input = document.getElementById(this.dataset.target);
            var icon  = this.querySelector('i');
            var show  = input.type === 'password';
            input.type = show ? 'text' : 'password';
            icon.classList.toggle('fa-eye',       !show);
            icon.classList.toggle('fa-eye-slash',  show);
        });
    });

    // Aktifkan tombol Simpan hanya jika semua field required terisi
    var form         = document.getElementById('change-password-form');
    var fields       = form.querySelectorAll('input[required]');
    var submitButton = document.getElementById('change-password-btn');

    function updateSubmitState() {
        submitButton.disabled = !Array.from(fields).every(function (f) { return f.value.trim(); });
    }

    fields.forEach(function (f) { f.addEventListener('input', updateSubmitState); });
    updateSubmitState();

    // Loading state saat submit
    form.addEventListener('submit', function () {
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
        submitButton.disabled  = true;
    });

    // Auto-hide alert setelah 4 detik
    setTimeout(function () {
        document.querySelectorAll('.alert-call').forEach(function (el) {
            el.style.transition = 'opacity .5s ease';
            el.style.opacity    = '0';
            setTimeout(function () { el.style.display = 'none'; }, 500);
        });
    }, 4000);
</script>
@endsection

