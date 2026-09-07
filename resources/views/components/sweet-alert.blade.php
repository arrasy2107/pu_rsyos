@php
    $flashMessages = [];
    $flashTypes = [
        'success' => ['success-add', 'success-edit', 'success-delete', 'success-change', 'success'],
        'error' => ['fail-add', 'fail-delete', 'fail-edit', 'fail', 'danger'],
        'warning' => ['warning'],
        'info' => ['info'],
    ];

    foreach ($flashTypes as $type => $keys) {
        foreach ($keys as $key) {
            if (session()->has($key)) {
                $flashMessages[] = ['icon' => $type, 'text' => session($key)];
            }
        }
    }

    if ($errors->any()) {
        $flashMessages[] = ['icon' => 'error', 'text' => implode("\n", $errors->all())];
    }
@endphp

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.PUAlert = window.PUAlert || {};

    window.PUAlert.toast = function(icon, text, options) {
        return Swal.fire(Object.assign({
            toast: true,
            position: 'top',
            icon: icon,
            title: text,
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
        }, options || {}));
    };

    window.PUAlert.success = function(text, options) { return window.PUAlert.toast('success', text, options); };
    window.PUAlert.error = function(text, options) { return window.PUAlert.toast('error', text, Object.assign({ timer: 5000 }, options || {})); };
    window.PUAlert.warning = function(text, options) { return window.PUAlert.toast('warning', text, options); };
    window.PUAlert.info = function(text, options) { return window.PUAlert.toast('info', text, options); };

    window.PUAlert.confirm = function(options) {
        if (typeof options === 'string') options = { text: options };

        return Swal.fire(Object.assign({
            icon: 'warning',
            title: 'Konfirmasi tindakan',
            text: 'Apakah Anda yakin ingin melanjutkan?',
            showCancelButton: true,
            confirmButtonText: 'Ya, lanjutkan',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            focusCancel: true,
        }, options || {})).then(function(result) {
            return result.isConfirmed;
        });
    };

    // Jalankan aksi hanya setelah pengguna menyetujui dialog SweetAlert2.
    // Gunakan helper ini untuk semua aksi destruktif dari skrip jQuery lama.
    window.PUAlert.confirmAction = function(options, action) {
        return window.PUAlert.confirm(options).then(function(isConfirmed) {
            if (isConfirmed && typeof action === 'function') action();
            return isConfirmed;
        });
    };

    window.PUAlert.loading = function(text) {
        Swal.fire({
            title: text || 'Memproses...',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: function() { Swal.showLoading(); }
        });
    };

    window.PUAlert.close = function() { Swal.close(); };

    // Compatibility for legacy alert() calls. New code should call PUAlert directly.
    window.alert = function(message) {
        var text = String(message || '');
        var lowerText = text.toLowerCase();
        var icon = /berhasil|sukses/.test(lowerText) ? 'success' : (/gagal|error|kesalahan|tidak dapat/.test(lowerText) ? 'error' : 'info');
        return window.PUAlert.toast(icon, text);
    };

    window.addEventListener('pu-alert', function(event) {
        var detail = event.detail || {};
        if (Array.isArray(detail)) detail = detail[0] || {};
        window.PUAlert.toast(detail.icon || 'info', detail.text || detail.message || '', detail.options || {});
    });

    document.addEventListener('livewire:init', function() {
        Livewire.on('pu-alert', function(payload) {
            if (Array.isArray(payload)) payload = payload[0] || {};
            window.PUAlert.toast(payload.icon || 'info', payload.text || payload.message || '', payload.options || {});
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        @foreach($flashMessages as $message)
        window.PUAlert.toast(@json($message['icon']), @json($message['text']));
        @endforeach
    });
</script>
