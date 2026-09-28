<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Laporan — RSUD Yos Sudarso</title>
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
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 65%, #3b82f6 100%);
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
        .header-logo .logo-fallback { font-size: 1.25rem; color: #1e3a8a; }
        .header-org { color: #fff; }
        .header-org .org-name { font-size: .87rem; font-weight: 700; line-height: 1.2; }
        .header-org .org-sub  { font-size: .71rem; opacity: .75; margin-top: 2px; }

        .header-body { position: relative; z-index: 1; }
        .valid-badge {
            display: inline-flex; align-items: center; gap: .35rem;
            font-size: .67rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .08em;
            padding: .22rem .65rem;
            border-radius: 999px;
            margin-bottom: .55rem;
        }
        /* Badge penuh: kedua verifikasi selesai */
        .valid-badge.badge-full {
            background: rgba(74,222,128,.22);
            border: 1px solid rgba(74,222,128,.45);
            color: #bbf7d0;
        }
        /* Badge sebagian: bidang sudah, direktur belum */
        .valid-badge.badge-partial {
            background: rgba(251,191,36,.20);
            border: 1px solid rgba(251,191,36,.40);
            color: #fde68a;
        }
        /* Badge menunggu: belum ada yang verifikasi */
        .valid-badge.badge-waiting {
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.25);
            color: #bfdbfe;
        }
        .header-title {
            color: #fff;
            font-size: 1.6rem; font-weight: 800;
            line-height: 1.2; margin-bottom: .3rem;
        }
        .header-subtitle { color: rgba(255,255,255,.68); font-size: .79rem; }

        /* === NOMOR LAPORAN BOX === */
        .laporan-box {
            background: #eef2ff;
            border: 1px solid #c7d2fe;
            border-radius: .85rem;
            padding: .8rem 1rem;
            margin: -1.15rem 1.25rem 0;
            position: relative; z-index: 2;
            display: flex; align-items: center; justify-content: space-between;
        }
        .laporan-box-label {
            font-size: .63rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .08em;
            color: #6b7280; margin-bottom: 3px;
        }
        .laporan-box-value {
            font-size: .97rem; font-weight: 700;
            color: #1e3a8a; letter-spacing: .03em;
            font-family: 'Courier New', monospace;
        }
        .copy-btn {
            background: none; border: none; cursor: pointer;
            color: #94a3b8; padding: .3rem .4rem;
            border-radius: .4rem;
            transition: all .2s ease; flex-shrink: 0;
        }
        .copy-btn:hover { background: #dbeafe; color: #2563eb; }
        .copy-btn.copied { color: #16a34a; }

        /* === BODY === */
        .verify-body { padding: 1.5rem 1.25rem 1rem; }

        .info-row {
            display: flex; align-items: flex-start; gap: .85rem;
            padding: .82rem 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .info-row:last-child { border-bottom: none; }
        .info-icon {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: #f1f5f9;
            color: #64748b;
            display: flex; align-items: center; justify-content: center;
            font-size: .8rem; flex-shrink: 0; margin-top: 1px;
        }
        .info-content { flex: 1; min-width: 0; }
        .info-label {
            font-size: .64rem; font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase; letter-spacing: .08em;
            margin-bottom: 3px;
        }
        .info-value { font-weight: 600; color: #1e293b; font-size: .91rem; line-height: 1.4; }

        .shift-dot {
            display: inline-block; width: 8px; height: 8px;
            border-radius: 50%; background: #f59e0b;
            margin-right: .4rem; vertical-align: middle; position: relative; top: -1px;
        }

        /* === STATUS BADGES === */
        .status-badge {
            display: inline-flex; align-items: center; gap: .35rem;
            font-size: .77rem; font-weight: 600;
            padding: .28rem .72rem; border-radius: .5rem;
        }
        .badge-pending  { background:#fef3c7; color:#92400e; border:1px solid #fde68a; }
        .badge-pending i { color:#f59e0b; }
        .badge-verified { background:#dcfce7; color:#14532d; border:1px solid #bbf7d0; }
        .badge-verified i { color:#16a34a; }

        /* === FOOTER === */
        .verify-footer {
            background: #f8fafc; border-top: 1px solid #f1f5f9;
            padding: .85rem 1.25rem;
            display: flex; align-items: center; gap: .6rem;
        }
        .footer-icon {
            width: 30px; height: 30px; border-radius: 8px;
            background: #dbeafe; color: #2563eb;
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
                        <img src="{{ asset('logo.png') }}" alt="Logo RSYS">
                    @elseif(file_exists(public_path('images/logo.png')))
                        <img src="{{ asset('images/logo.png') }}" alt="Logo RSYS">
                    @else
                        <span class="logo-fallback"><i class="fas fa-hospital"></i></span>
                    @endif
                </div>
                <div class="header-org">
                    <div class="org-name">RS YOS SUDARSO PADANG</div>
                    <div class="org-sub">Sistem Laporan &middot; Pengawas Umum</div>
                </div>
            </div>
            <div class="header-body">
                @if($verified && $verified_bidang)
                    <div class="valid-badge badge-full">
                        <i class="fas fa-check-double"></i> Terverifikasi Penuh
                    </div>
                    <div class="header-title">QR Code Sah &amp; Valid</div>
                    <div class="header-subtitle">Laporan telah diverifikasi oleh Bidang Keperawatan dan Direktur.</div>
                @elseif($verified_bidang)
                    <div class="valid-badge badge-partial">
                        <i class="fas fa-check-circle"></i> Terverifikasi Sebagian
                    </div>
                    <div class="header-title">QR Code Sah &amp; Valid</div>
                    <div class="header-subtitle">Laporan telah diverifikasi Bidang Keperawatan, menunggu Direktur.</div>
                @else
                    <div class="valid-badge badge-waiting">
                        <i class="fas fa-clock"></i> Menunggu Verifikasi
                    </div>
                    <div class="header-title">QR Code Sah &amp; Valid</div>
                    <div class="header-subtitle">Laporan telah dikirim, menunggu proses verifikasi.</div>
                @endif
            </div>
        </div>

        {{-- NOMOR LAPORAN --}}
        <div class="laporan-box">
            <div>
                <div class="laporan-box-label">No. Laporan</div>
                <div class="laporan-box-value" id="nomorLaporan">
                    {{ $nomor_laporan ?? ('LP-' . \Carbon\Carbon::parse($tanggal_submit)->format('Y-m-d') . '-' . str_pad($laporan_id ?? 0, 4, '0', STR_PAD_LEFT)) }}
                </div>
            </div>
            <button class="copy-btn" id="copyBtn" onclick="copyNomor()" title="Salin nomor laporan">
                <i class="fas fa-copy" id="copyIcon"></i>
            </button>
        </div>

        {{-- BODY --}}
        <div class="verify-body">

            <div class="info-row">
                <div class="info-icon"><i class="fas fa-user"></i></div>
                <div class="info-content">
                    <div class="info-label">Pengawas Umum</div>
                    <div class="info-value">{{ $nama_pengawas }}</div>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon"><i class="fas fa-clock"></i></div>
                <div class="info-content">
                    <div class="info-label">Shift Dinas</div>
                    <div class="info-value"><span class="shift-dot"></span>{{ $shift_dinas }}</div>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon"><i class="fas fa-calendar-alt"></i></div>
                <div class="info-content">
                    <div class="info-label">Tanggal &amp; Jam Submit</div>
                    <div class="info-value">
                        {{ \Carbon\Carbon::parse($tanggal_submit)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                        &mdash;
                        {{ \Carbon\Carbon::parse($tanggal_submit)->format('H:i') }} WIB
                    </div>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon"><i class="fas fa-shield-alt"></i></div>
                <div class="info-content">
                    <div class="info-label">Verifikasi Bidang Keperawatan</div>
                    <div class="info-value">
                        @if($verified_bidang)
                            <span class="status-badge badge-verified"><i class="fas fa-check-circle"></i> Sudah Diverifikasi</span>
                        @else
                            <span class="status-badge badge-pending"><i class="fas fa-clock"></i> Menunggu Verifikasi</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon"><i class="fas fa-user-tie"></i></div>
                <div class="info-content">
                    <div class="info-label">Verifikasi Direktur</div>
                    <div class="info-value">
                        @if($verified)
                            <span class="status-badge badge-verified"><i class="fas fa-check-double"></i> Sudah Diverifikasi</span>
                        @else
                            <span class="status-badge badge-pending"><i class="fas fa-clock"></i> Menunggu Verifikasi</span>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- FOOTER --}}
        <div class="verify-footer">
            <div class="footer-icon"><i class="fas fa-lock"></i></div>
            <div class="footer-text">
                Diverifikasi oleh <strong>Sistem Informasi Pengawas Umum</strong>
                &middot; RS Yos Sudarso Padang
            </div>
        </div>
        <div class="scan-timestamp">
            Dipindai pada {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }} &middot; {{ \Carbon\Carbon::now()->format('H:i') }} WIB
        </div>

    </div>

    <script>
        function copyNomor() {
            const nomor = document.getElementById('nomorLaporan').textContent.trim();
            const btn   = document.getElementById('copyBtn');
            const icon  = document.getElementById('copyIcon');
            navigator.clipboard.writeText(nomor).then(() => {
                icon.className = 'fas fa-check';
                btn.classList.add('copied');
                setTimeout(() => { icon.className = 'fas fa-copy'; btn.classList.remove('copied'); }, 2000);
            }).catch(() => {
                const el = document.createElement('textarea');
                el.value = nomor; document.body.appendChild(el); el.select();
                document.execCommand('copy'); document.body.removeChild(el);
            });
        }
    </script>
</body>
</html>
