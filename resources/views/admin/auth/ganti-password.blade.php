@extends('master.loginregister')

@section('content')
<div class="pu-login-page">
    <div class="pu-login-panel">
        <div class="pu-login-panel-card">
            <div class="pu-login-header text-center">
                <img src="{{ asset('images/logo_rsys.jpeg') }}" alt="RSYOS" class="pu-login-logo" />
                <h3>Ganti Password</h3>
                <p class="text-muted">Perbarui password untuk menjaga keamanan akun Anda.</p>
            </div>

            <div class="pu-password-card-content">
                <div class="pu-password-notice"><i class="fas fa-shield-alt"></i><span>Password default <strong>12345678</strong> harus segera diubah.</span></div>
                <x-alert />

                <form method="POST" action="{{ route('gantipassword2') }}" autocomplete="off" id="change-password-form">
                    @csrf
                    @method('PUT')
                    <x-form-field id="username" name="username" label="Username / NIP" placeholder="Masukkan username atau NIP" icon="fas fa-user" autocomplete="nope" />

                    <div class="form-group pu-login-form-group">
                        <label for="passlama">Password Lama</label>
                        <div class="pu-login-input-wrapper">
                            <div class="pu-login-input-icon"><i class="fas fa-lock"></i></div>
                            <input type="password" class="form-control pu-login-input" id="passlama" name="passlama" autocomplete="current-password" placeholder="Masukkan password lama" required>
                            <button type="button" class="btn-input-icon pwd-toggle" data-target="passlama" aria-label="Tampilkan password lama"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>

                    <div class="form-group pu-login-form-group">
                        <label for="password">Password Baru</label>
                        <div class="pu-login-input-wrapper">
                            <div class="pu-login-input-icon"><i class="fas fa-lock-open"></i></div>
                            <input type="password" class="form-control pu-login-input" id="password" name="password" autocomplete="new-password" placeholder="Masukkan password baru" required>
                            <button type="button" class="btn-input-icon pwd-toggle" data-target="password" aria-label="Tampilkan password baru"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-login-submit w-100" id="change-password-btn" disabled>
                        <i class="fas fa-save me-2"></i>
                        Simpan Password Baru
                    </button>
                </form>
            </div>

            <div class="pu-login-footer text-center">
                <p class="small text-muted mb-1">Sudah mengganti password?</p>
                <a class="small text-primary" href="{{ route('login') }}">Kembali ke Login</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_style')
<style>
    body { background: #f8fafc; }
    .pu-login-page { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem; }
    .pu-login-panel { width: 100%; max-width: 420px; }
    .pu-login-panel-card { width: 100%; max-height: calc(100dvh - 4rem); display: flex; flex-direction: column; border-radius: 28px; padding: 2.5rem; background: #fff; box-shadow: 0 32px 60px rgba(15, 23, 42, .12); border: 1px solid rgba(15, 23, 42, .06); }
    .pu-login-header { margin-bottom: 2rem; }
    .pu-login-logo { width: 84px; height: auto; margin-bottom: 1rem; border-radius: 20px; background: rgba(14, 165, 233, .1); padding: .85rem; }
    .pu-login-header h3 { font-size: 1.85rem; font-weight: 800; margin-bottom: .35rem; color: #0f172a; }
    .pu-login-header p { color: #64748b; margin-bottom: 0; font-size: .98rem; }
    .pu-password-notice { display: flex; gap: .75rem; align-items: flex-start; margin-bottom: 1.5rem; padding: .85rem 1rem; border-radius: 16px; background: #eff6ff; color: #1e40af; font-size: .85rem; line-height: 1.5; }
    .pu-password-notice i { margin-top: .15rem; }
    .pu-password-card-content { min-height: 0; overflow-y: auto; overscroll-behavior: contain; padding-right: .5rem; }
    .pu-password-card-content::-webkit-scrollbar { width: .45rem; }
    .pu-password-card-content::-webkit-scrollbar-thumb { background: #bfdbfe; border-radius: 999px; }
    .pu-password-card-content::-webkit-scrollbar-track { background: #eff6ff; border-radius: 999px; }
    .pu-login-panel-card .alert-call { border-radius: 18px; }
    .pu-login-form-group { margin-bottom: 1.25rem; }
    .pu-login-form-group label { display: block; font-size: .75rem; font-weight: 700; letter-spacing: .2em; text-transform: uppercase; color: #475569; margin-bottom: .85rem; }
    .pu-login-input-wrapper { display: flex; align-items: center; gap: .75rem; border-radius: 24px; border: 1px solid #dbeafe; background: #f8fbff; padding: .35rem .65rem; transition: border-color .25s ease, box-shadow .25s ease; }
    .pu-login-input-wrapper:focus-within { border-color: #2563eb; box-shadow: 0 0 0 8px rgba(37, 99, 235, .12); }
    .pu-login-input-icon, .btn-input-icon { width: 50px; min-width: 50px; height: 50px; display: grid; place-items: center; border-radius: 16px; }
    .pu-login-input-icon { background: #eff6ff; color: #1d4ed8; box-shadow: inset 0 1px 2px rgba(15, 23, 42, .08); }
    .pu-login-input { flex: 1; border: none; background: transparent; min-height: 56px; font-size: 1rem; color: #0f172a; padding: .95rem .5rem; outline: none; }
    .pu-login-input::placeholder { color: #94a3b8; }
    .btn-input-icon { border: none; background: #eff6ff; color: #475569; cursor: pointer; transition: background .2s ease, color .2s ease, transform .2s ease; }
    .btn-input-icon:hover { background: #dbeafe; color: #1d4ed8; transform: translateY(-1px); }
    .btn-input-icon:focus { outline: none; box-shadow: 0 0 0 4px rgba(37, 99, 235, .15); }
    .form-control:focus { outline: none; box-shadow: none; }
    .btn-login-submit { padding: 1rem; font-size: 1rem; font-weight: 700; border-radius: 18px; background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); border: none; box-shadow: 0 18px 32px rgba(37, 99, 235, .18); transition: transform .25s ease, box-shadow .25s ease; }
    .btn-login-submit:hover:not(:disabled) { transform: translateY(-1px); box-shadow: 0 22px 38px rgba(37, 99, 235, .2); }
    .btn-login-submit:disabled { opacity: .65; cursor: not-allowed; box-shadow: none; }
    .pu-login-footer { margin-top: 1.75rem; }
    .pu-login-footer .small { color: #64748b; }
    .pu-login-footer .text-primary { color: #2563eb !important; }
    @media (max-width: 768px) { .pu-login-page { padding: 1.5rem; } .pu-login-panel-card { max-height: calc(100dvh - 3rem); padding: 2rem; } }
</style>
@endsection

@section('custom_script')
<script>
    document.querySelectorAll('.pwd-toggle').forEach(function(button) {
        button.addEventListener('click', function() {
            var input = document.getElementById(this.dataset.target);
            var icon = this.querySelector('i');
            var showPassword = input.type === 'password';
            input.type = showPassword ? 'text' : 'password';
            icon.classList.toggle('fa-eye', !showPassword);
            icon.classList.toggle('fa-eye-slash', showPassword);
        });
    });
    var form = document.getElementById('change-password-form');
    var fields = form.querySelectorAll('input[required]');
    var submitButton = document.getElementById('change-password-btn');
    function updateSubmitState() { submitButton.disabled = !Array.from(fields).every(function(field) { return field.value.trim(); }); }
    fields.forEach(function(field) { field.addEventListener('input', updateSubmitState); });
    form.addEventListener('submit', function() { submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...'; submitButton.disabled = true; });
    updateSubmitState();

    setTimeout(function() {
        document.querySelectorAll('.alert-call').forEach(function(alert) {
            alert.style.transition = 'opacity .5s ease';
            alert.style.opacity = '0';
            setTimeout(function() { alert.style.display = 'none'; }, 500);
        });
    }, 4000);
</script>
@endsection
