<nav class="pu-sidebar" id="pu-sidebar">

    {{-- Brand --}}
    <div class="pu-sidebar-brand">
        <img src="{{ asset('images/logo_rsys.png') }}" alt="RSYOS Logo" class="pu-sidebar-brand-logo" width="38" height="38">
        <div class="pu-sidebar-brand-text">
            <span class="title">Sistem Informasi</span>
            <span class="subtitle">Laporan Pengawas Umum</span>
        </div>
    </div>

    {{-- Navigation --}}
    <ul class="pu-nav" id="sidebar-nav">

        @if(in_array(Auth::user()->id_role, [0, 1, 3]))
        {{-- ============================
         SIDEBAR: DIREKTUR / KEPERAWATAN (role 1 & 3)
         ============================ --}}

        {{-- Dashboard --}}
        <li class="pu-nav-item">
            <a class="pu-nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="pu-nav-icon fas fa-tachometer-alt"></i>
                <span class="pu-nav-text">Dashboard</span>
            </a>
        </li>

        <span class="pu-nav-section-label">Laporan</span>

        @if(Auth::user()->id_role == 0)
        <li class="pu-nav-item">
            <a class="pu-nav-link {{ request()->is('administrasi-laporan') ? 'active' : '' }}" href="{{ route('administrasi-laporan') }}">
                <i class="pu-nav-icon fas fa-user-cog"></i>
                <span class="pu-nav-text">Administrasi Laporan</span>
            </a>
        </li>
        @endif

        {{-- Laporan Group --}}
        <li class="pu-nav-item">
            <button class="pu-nav-collapse-toggle {{ request()->is('riwayat-laporan-pu*', 'grafik-laporan') ? '' : 'collapsed' }}"
                data-bs-toggle="collapse" data-bs-target="#collapseRiwayat" aria-expanded="{{ request()->is('riwayat-laporan-pu*', 'grafik-laporan') ? 'true' : 'false' }}">
                <i class="pu-nav-icon fas fa-file-alt"></i>
                <span class="pu-nav-text">Riwayat Laporan</span>
                <i class="pu-nav-arrow fas fa-chevron-down"></i>
            </button>
            <div class="collapse {{ request()->is('riwayat-laporan-pu*', 'grafik-laporan') ? 'show' : '' }}" id="collapseRiwayat">
                <ul class="pu-nav-sub">
                    <li class="pu-nav-item">
                        <a class="pu-nav-link {{ request()->is('riwayat-laporan-pu-belum-verifikasi') ? 'active' : '' }}" href="{{ route('riwayat-laporan-pu-belum') }}">
                            <i class="pu-nav-icon fas fa-clock"></i>
                            <span class="pu-nav-text">Belum Diverifikasi</span>
                        </a>
                    </li>
                    <li class="pu-nav-item">
                        <a class="pu-nav-link {{ request()->is('riwayat-laporan-pu-sudah-verifikasi') ? 'active' : '' }}" href="{{ route('riwayat-laporan-pu-sudah') }}">
                            <i class="pu-nav-icon fas fa-check-circle"></i>
                            <span class="pu-nav-text">Sudah Diverifikasi</span>
                        </a>
                    </li>
                    <li class="pu-nav-item">
                        <a class="pu-nav-link {{ request()->is('grafik-laporan') ? 'active' : '' }}" href="{{ route('grafik-laporan') }}">
                            <i class="pu-nav-icon fas fa-chart-bar"></i>
                            <span class="pu-nav-text">Grafik Laporan</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        @if(Auth::user()->id_role == 3)
        <span class="pu-nav-section-label">Jadwal</span>

        <li class="pu-nav-item">
            <a class="pu-nav-link {{ request()->is('jadwal-dinas') ? 'active' : '' }}" href="{{ route('jadwal-dinas') }}">
                <i class="pu-nav-icon fas fa-calendar-alt"></i>
                <span class="pu-nav-text">Jadwal Dinas</span>
            </a>
        </li>
        @endif

        <span class="pu-nav-section-label">Data Master</span>

        {{-- Data Master Group --}}
        <li class="pu-nav-item">
            <button class="pu-nav-collapse-toggle {{ request()->is('data-pengawas*', 'data-ruangan', 'data-kamar', 'data-kasur', 'data-dokter*', 'data-pengguna', 'data-subrumpun*', 'data-jenis*') ? '' : 'collapsed' }}"
                data-bs-toggle="collapse" data-bs-target="#collapseData" aria-expanded="{{ request()->is('data-pengawas*', 'data-ruangan', 'data-kamar', 'data-kasur', 'data-dokter*', 'data-pengguna', 'data-subrumpun*', 'data-jenis*') ? 'true' : 'false' }}">
                <i class="pu-nav-icon fas fa-database"></i>
                <span class="pu-nav-text">Data Master</span>
                <i class="pu-nav-arrow fas fa-chevron-down"></i>
            </button>
            <div class="collapse {{ request()->is('data-pengawas*', 'data-ruangan', 'data-kamar', 'data-kasur', 'data-dokter*', 'data-pengguna', 'data-subrumpun*', 'data-jenis*') ? 'show' : '' }}" id="collapseData">
                <ul class="pu-nav-sub">
                    @if(Auth::user()->id_role == 0)
                    <li class="pu-nav-item">
                        <a class="pu-nav-link {{ request()->is('data-pengguna') ? 'active' : '' }}" href="{{ route('data-pengguna') }}">
                            <i class="pu-nav-icon fas fa-users"></i>
                            <span class="pu-nav-text">Data Pengguna</span>
                        </a>
                    </li>
                    @endif
                    <li class="pu-nav-item">
                        <a class="pu-nav-link {{ request()->is('data-pengawas-umum') ? 'active' : '' }}" href="{{ route('data-pengawas-umum') }}">
                            <i class="pu-nav-icon fas fa-user-shield"></i>
                            <span class="pu-nav-text">Pengawas Umum</span>
                        </a>
                    </li>
                    @if(Auth::user()->hasMenuAccess('data-ruangan'))
                    <li class="pu-nav-item">
                        <a class="pu-nav-link {{ request()->is('data-ruangan') ? 'active' : '' }}" href="{{ route('data-ruangan') }}">
                            <i class="pu-nav-icon fas fa-door-open"></i>
                            <span class="pu-nav-text">Data Unit</span>
                        </a>
                    </li>
                    <li class="pu-nav-item">
                        <a class="pu-nav-link {{ request()->is('data-kamar') ? 'active' : '' }}" href="{{ route('data-kamar') }}">
                            <i class="pu-nav-icon fas fa-bed"></i><span class="pu-nav-text">Data Kamar</span>
                        </a>
                    </li>
                    <li class="pu-nav-item">
                        <a class="pu-nav-link {{ request()->is('data-kasur') ? 'active' : '' }}" href="{{ route('data-kasur') }}">
                            <i class="pu-nav-icon fas fa-procedures"></i><span class="pu-nav-text">Data Kasur</span>
                        </a>
                    </li>
                    <li class="pu-nav-item">
                        <a class="pu-nav-link {{ request()->is('data-dokter') ? 'active' : '' }}" href="{{ route('data-dokter-global') }}">
                            <i class="pu-nav-icon fas fa-user-md"></i>
                            <span class="pu-nav-text">Data Semua Dokter</span>
                        </a>
                    </li>
                    <li class="pu-nav-item">
                        <a class="pu-nav-link {{ request()->is('data-dokter-jaga') ? 'active' : '' }}" href="{{ route('data-dokter-igd') }}">
                            <i class="pu-nav-icon fas fa-ambulance"></i>
                            <span class="pu-nav-text">Dokter Jaga IGD</span>
                        </a>
                    </li>
                    <li class="pu-nav-item">
                        <a class="pu-nav-link {{ request()->is('data-dokter-irj') ? 'active' : '' }}" href="{{ route('data-dokter-irj') }}">
                            <i class="pu-nav-icon fas fa-stethoscope"></i>
                            <span class="pu-nav-text">Dokter IRJ</span>
                        </a>
                    </li>
                    <li class="pu-nav-item">
                        <a class="pu-nav-link {{ request()->is('data-subrumpun-sdmk') ? 'active' : '' }}" href="{{ route('data-subrumpun-sdmk') }}">
                            <i class="pu-nav-icon fas fa-sitemap"></i>
                            <span class="pu-nav-text">SDMK Subrumpun</span>
                        </a>
                    </li>
                    <li class="pu-nav-item">
                        <a class="pu-nav-link {{ request()->is('data-jenis-sdmk') ? 'active' : '' }}" href="{{ route('data-jenis-sdmk') }}">
                            <i class="pu-nav-icon fas fa-layer-group"></i>
                            <span class="pu-nav-text">SDMK Jenis</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </li>

        @if(Auth::user()->hasMenuAccess('log'))
        <span class="pu-nav-section-label">Sistem</span>
        <li class="pu-nav-item">
            <a class="pu-nav-link {{ request()->is('log') ? 'active' : '' }}" href="{{ route('log') }}">
                <i class="pu-nav-icon fas fa-clipboard-list"></i>
                <span class="pu-nav-text">Log Aktivitas</span>
            </a>
        </li>
        @endif

        @elseif(Auth::user()->id_role == 2)
        {{-- ============================
         SIDEBAR: PENGAWAS UMUM (role 2)
         ============================ --}}

        <span class="pu-nav-section-label">Laporan</span>

        <li class="pu-nav-item">
            <a class="pu-nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="pu-nav-icon fas fa-tachometer-alt"></i>
                <span class="pu-nav-text">Dashboard</span>
            </a>
        </li>

        <li class="pu-nav-item">
            <a class="pu-nav-link {{ request()->is('laporan') ? 'active' : '' }}" href="{{ route('laporan') }}">
                <i class="pu-nav-icon fas fa-pen-alt"></i>
                <span class="pu-nav-text">Laporan Hari Ini</span>
            </a>
        </li>
        <li class="pu-nav-item">
            <a class="pu-nav-link {{ request()->is('draf-laporan') ? 'active' : '' }}" href="{{ route('draf-laporan') }}">
                <i class="pu-nav-icon fas fa-file-signature"></i>
                <span class="pu-nav-text">Draft Laporan</span>
            </a>
        </li>

        <span class="pu-nav-section-label">Riwayat</span>

        <li class="pu-nav-item">
            <a class="pu-nav-link {{ request()->is('riwayat-laporan-belum-verifikasi') ? 'active' : '' }}" href="{{ route('riwayat-laporan-belum') }}">
                <i class="pu-nav-icon fas fa-clock"></i>
                <span class="pu-nav-text">Belum Diverifikasi</span>
            </a>
        </li>
        <li class="pu-nav-item">
            <a class="pu-nav-link {{ request()->is('riwayat-laporan-sudah-verifikasi') ? 'active' : '' }}" href="{{ route('riwayat-laporan-sudah') }}">
                <i class="pu-nav-icon fas fa-check-circle"></i>
                <span class="pu-nav-text">Sudah Diverifikasi</span>
            </a>
        </li>

        <span class="pu-nav-section-label">Data Master</span>

        <li class="pu-nav-item">
            <a class="pu-nav-link {{ request()->is('data-kasur') ? 'active' : '' }}" href="{{ route('data-kasur') }}">
                <i class="pu-nav-icon fas fa-procedures"></i>
                <span class="pu-nav-text">Data Kasur</span>
            </a>
        </li>
        @endif
    </ul>
</nav>