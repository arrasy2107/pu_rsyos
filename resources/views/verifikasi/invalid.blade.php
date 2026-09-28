<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Tidak Valid — RSUD Yos Sudarso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            background: #dde6f5;
            min-height: 100vh;
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
            display: flex; align-items: center; justify-content: center;
            padding: 1.5rem;
        }

        /* === CARD === */
        .verify-card {
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 12px 48px rgba(30,58,138,.14), 0 2px 8px rgba(0,0,0,.06);
            max-width: 460px;
            width: 100%;
            overflow: hidden;
        }

        /* === HEADER === */
        .verify-header {
            background: linear-gradient(135deg, #7f1d1d 0%, #dc2626 65%, #ef4444 100%);
            padding: 1.6rem 1.5rem 2.4rem;
            position: relative;
            overflow: hidden;
        }
        .verify-header::before {
            content: '';
            position: absolute;
            width: 240px; height: 240px;
            border-radius: 50%;
            background: rgba(255,255,255,.06);
            top: -90px; right: -70px;
            pointer-events: none;
        }
        .verify-header::after {
            content: '';
            position: absolute;
            width: 150px; height: 150px;
            border-radius: 50%;
            background: rgba(255,255,255,.05);
            bottom: -55px; left: -35px;
            pointer-events: none;
        }
        .header-top {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: 1.3rem;
            position: relative; z-index: 1;
        }
        .header-logo {
            width: 44px; height: 44px;
            border-radius: 50%;
            background: #fff;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 10px rgba(0,0,0,.18);
            overflow: hidden;
        }
        .header-logo img { width: 38px; height: 38px; object-fit: contain; }
        .header-logo .logo-fallback { font-size: 1.25rem; color: #dc2626; }
        .header-org { color: #fff; }
        .header-org .org-name { font-size: .87rem; font-weight: 700; line-height: 1.2; }
        .header-org .org-sub  { font-size: .71rem; opacity: .75; margin-top: 2px; }

        .header-body { position: relative; z-index: 1; text-align: left; }
        .invalid-badge {
            display: inline-flex; align-items: center; gap: .35rem;
            background: rgba(255,255,255,.18);
            border: 1px solid rgba(255,255,255,.28);
            color: #fecaca;
            font-size: .67rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .08em;
            padding: .22rem .65rem;
            border-radius: 999px;
            margin-bottom: .55rem;
        }
        .header-title {
            color: #fff;
            font-size: 1.6rem; font-weight: 800;
            line-height: 1.2; margin-bottom: .3rem;
        }
        .header-subtitle { color: rgba(255,255,255,.68); font-size: .79rem; }

        /* === ERROR BOX === */
        .error-box {
            background: #fff5f5;
            border: 1px solid #fecaca;
            border-radius: .85rem;
            padding: .85rem 1rem;
            margin: -1.15rem 1.25rem 0;
            position: relative; z-index: 2;
            display: flex; align-items: flex-start; gap: .65rem;
        }
        .error-box-icon {
            width: 32px; height: 32px; flex-shrink: 0;
            border-radius: 50%;
            background: #fee2e2;
            color: #dc2626;
            display: flex; align-items: center; justify-content: center;
            font-size: .8rem; margin-top: 1px;
        }
        .error-box-label {
            font-size: .63rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .08em;
            color: #6b7280; margin-bottom: 3px;
        }
        .error-box-value {
            font-size: .88rem; font-weight: 600;
            color: #991b1b; line-height: 1.45;
        }

        /* === BODY === */
        .verify-body { padding: 1.4rem 1.25rem 1.2rem; }

        .info-row {
            display: flex; align-items: flex-start; gap: .85rem;
            padding: .82rem 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .info-row:last-child { border-bottom: none; }
        .info-icon {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: #f1f5f9; color: #64748b;
            display: flex; align-items: center; justify-content: center;
            font-size: .8rem; flex-shrink: 0; margin-top: 1px;
        }
        .info-content { flex: 1; min-width: 0; }
        .info-label {
            font-size: .64rem; font-weight: 700; color: #94a3b8;
            text-transform: uppercase; letter-spacing: .08em; margin-bottom: 3px;
        }
        .info-value { font-weight: 500; color: #475569; font-size: .88rem; line-height: 1.5; }

        /* === FOOTER === */
        .verify-footer {
            background: #f8fafc; border-top: 1px solid #f1f5f9;
            padding: .85rem 1.25rem;
            display: flex; align-items: center; gap: .6rem;
        }
        .footer-icon {
            width: 30px; height: 30px; border-radius: 8px;
            background: #fee2e2; color: #dc2626;
            display: flex; align-items: center; justify-content: center;
            font-size: .72rem; flex-shrink: 0;
        }
        .footer-text { font-size: .71rem; color: #64748b; line-height: 1.4; }
        .footer-text strong { color: #1e293b; }

        .scan-timestamp {
            text-align: center; font-size: .67rem; color: #94a3b8;
            padding: .45rem 1.25rem .7rem; background: #f8fafc;
        }
    </style>
</head>
<body>
    <div class="verify-card">

        {{-- HEADER --}}
        <div class="verify-header">
            <div class="header-top">
                <div class="header-logo">
                    @if(file_exists(public_path('logo.png')))
                        <img src="{{ asset('logo.png') }}" alt="Logo RSUD">
                    @elseif(file_exists(public_path('images/logo.png')))
                        <img src="{{ asset('images/logo.png') }}" alt="Logo RSUD">
                    @else
                        <span class="logo-fallback"><i class="fas fa-hospital"></i></span>
                    @endif
                </div>
                <div class="header-org">
                    <div class="org-name">RSUD YOS SUDARSO</div>
                    <div class="org-sub">Padang &middot; Sistem Pengawas Umum</div>
                </div>
            </div>
            <div class="header-body">
                <div class="invalid-badge">
                    <i class="fas fa-times-circle"></i> Verifikasi Gagal
                </div>
                <div class="header-title">QR Code Tidak Valid</div>
                <div class="header-subtitle">Dokumen ini tidak dapat diverifikasi oleh sistem.</div>
            </div>
        </div>

        {{-- ERROR BOX --}}
        <div class="error-box">
            <div class="error-box-icon"><i class="fas fa-exclamation-triangle"></i></div>
            <div>
                <div class="error-box-label">Keterangan</div>
                <div class="error-box-value">{{ $pesan }}</div>
            </div>
        </div>

        {{-- BODY --}}
        <div class="verify-body">

            <div class="info-row">
                <div class="info-icon"><i class="fas fa-qrcode"></i></div>
                <div class="info-content">
                    <div class="info-label">Kemungkinan Penyebab</div>
                    <div class="info-value">
                        QR Code mungkin sudah kadaluarsa, telah dimanipulasi, atau bukan berasal dari sistem ini.
                    </div>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon"><i class="fas fa-info-circle"></i></div>
                <div class="info-content">
                    <div class="info-label">Tindakan yang Disarankan</div>
                    <div class="info-value">
                        Pastikan Anda memindai QR Code yang benar dari dokumen laporan asli.
                        Jika masalah berlanjut, hubungi administrator sistem.
                    </div>
                </div>
            </div>

        </div>

        {{-- FOOTER --}}
        <div class="verify-footer">
            <div class="footer-icon"><i class="fas fa-lock"></i></div>
            <div class="footer-text">
                Sistem Informasi <strong>Pengawas Umum</strong>
                &middot; RSUD Yos Sudarso
            </div>
        </div>
        <div class="scan-timestamp">
            Dipindai pada {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }} &middot; {{ \Carbon\Carbon::now()->format('H:i') }} WIB
        </div>

    </div>
</body>
</html>
