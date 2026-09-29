@extends('master.master')

@section('page_title', 'Data Pengguna')

@section('custom_style')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@stop

@section('content')

<x-alert />

<x-page-header title="Manajemen Pengguna" subtitle="Kelola akun dan hak akses pengguna sistem laporan">
    <x-slot name="actions">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah">
            <i class="fas fa-plus"></i> Tambah Pengguna
        </button>
    </x-slot>
</x-page-header>

<x-data-card title="Daftar Pengguna Aktif" icon="fas fa-users">
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Nama</th>
                    <th>Username / NIP</th>
                    <th>Role Akses</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach(\App\Models\User::where('status',1)->where('id','<>',\Auth::user()->id)->get() as $data)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td class="fw-bold">{{ $data->nama }}</td>
                        <td><span class="badge bg-secondary pu-badge-mono">{{ $data->username }}</span></td>
                        <td><x-badge-role :role="$data->id_role" /></td>
                        <td>
                            <div class="d-flex gap-2">
                                <form action="{{ route('resetpassword', $data->id) }}" method="POST"
                                    class="d-inline form-reset-password">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning"
                                        title="Reset Password"
                                        data-bs-toggle="tooltip">
                                        <i class="fas fa-key"></i>
                                    </button>
                                </form>
                                <button value="{{ $data->id }}" class="btn btn-sm btn-info btn-edit"
                                    data-nama="{{ $data->nama }}"
                                    data-username="{{ $data->username }}"
                                    data-role="{{ $data->id_role }}"
                                    data-bs-toggle="modal" data-bs-target="#edit"
                                    title="Edit Data">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-success btn-akses"
                                    data-id="{{ $data->id }}"
                                    data-nama="{{ $data->nama }}"
                                    data-akses='{{ json_encode($data->akses_menu ?? []) }}'
                                    data-bs-toggle="modal" data-bs-target="#modalAksesMenu"
                                    title="Atur Akses Menu"
                                    data-bs-toggle="tooltip">
                                    <i class="fas fa-sliders-h"></i>
                                </button>
                                <form action="{{ route('deletepengguna', $data->id) }}" method="POST"
                                    class="d-inline form-delete-pengguna">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        title="Hapus"
                                        data-bs-toggle="tooltip">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</x-data-card>

{{-- MODAL ATUR AKSES MENU --}}
<div id="modalAksesMenu" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);">
                <div>
                    <h5 class="modal-title fw-bold text-white mb-0">
                        <i class="fas fa-sliders-h me-2"></i> Atur Akses Menu
                    </h5>
                    <small class="text-white-50" id="akses-user-nama"></small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="formAksesMenu" action="">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="POST">
                <div class="modal-body p-4">
                    <div class="alert alert-info d-flex align-items-start gap-2 py-2">
                        <i class="fas fa-info-circle mt-1"></i>
                        <div><strong>Catatan:</strong> Jika semua menu tidak dicentang (kosong), user akan kehilangan akses ke semua halaman (kecuali Dashboard). Centang menu yang boleh diakses.</div>
                    </div>

                    @php
                    $daftarMenu = [
                        'Master Data' => [
                            ['key' => 'data-pengawas-umum', 'label' => 'Data Pengawas Umum',  'icon' => 'fas fa-shield-alt'],
                            ['key' => 'data-ruangan',       'label' => 'Data Ruangan',          'icon' => 'fas fa-door-open'],
                            ['key' => 'data-dokter',        'label' => 'Data Dokter (Semua)',   'icon' => 'fas fa-user-md'],
                            ['key' => 'data-dokter-jaga',   'label' => 'Dokter Jaga IGD',       'icon' => 'fas fa-ambulance'],
                            ['key' => 'data-dokter-irj',    'label' => 'Dokter IRJ',            'icon' => 'fas fa-stethoscope'],
                            ['key' => 'data-subrumpun-sdmk','label' => 'SDMK Subrumpun',       'icon' => 'fas fa-sitemap'],
                            ['key' => 'data-jenis-sdmk',    'label' => 'SDMK Jenis',           'icon' => 'fas fa-tags'],
                        ],
                        'Laporan & Monitoring' => [
                            ['key' => 'laporan',            'label' => 'Laporan Pengawas',      'icon' => 'fas fa-file-alt'],
                            ['key' => 'log',                'label' => 'Log Aktivitas',         'icon' => 'fas fa-scroll'],
                        ],
                    ];
                    @endphp

                    @foreach($daftarMenu as $group => $menus)
                    <div class="mb-4">
                        <div class="fw-bold text-uppercase small text-muted mb-2" style="letter-spacing: 1px;">
                            <i class="fas fa-layer-group me-1"></i> {{ $group }}
                        </div>
                        <div class="row g-2">
                            @foreach($menus as $menu)
                            <div class="col-md-6">
                                <label class="d-flex align-items-center gap-3 p-3 border rounded cursor-pointer menu-checkbox-label" style="cursor:pointer; transition: all 0.15s;">
                                    <input type="checkbox" name="menus[]" value="{{ $menu['key'] }}"
                                        class="form-check-input flex-shrink-0 mt-0 menu-checkbox"
                                        id="menu-{{ $menu['key'] }}" style="width:1.2rem; height:1.2rem;">
                                    <span class="d-flex align-items-center gap-2">
                                        <i class="{{ $menu['icon'] }} text-success" style="width:16px;"></i>
                                        <span class="fw-semibold small">{{ $menu['label'] }}</span>
                                    </span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach

                    <div class="d-flex gap-2 mt-2">
                        <button type="button" id="btn-pilih-semua" class="btn btn-sm btn-outline-success">
                            <i class="fas fa-check-double me-1"></i> Pilih Semua
                        </button>
                        <button type="button" id="btn-hapus-semua" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-times me-1"></i> Hapus Semua
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Simpan Akses
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div id="tambah" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-user-plus me-2 text-primary"></i> Tambah Pengguna Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('tambahpengguna') }}" autocomplete="off">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <div class="pu-input-icon-wrap">
                            <span class="pu-input-prefix"><i class="fas fa-font"></i></span>
                            <input type="text" class="form-control" name="nama"
                                placeholder="Masukkan nama lengkap" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Username / NIP</label>
                        <div class="pu-input-icon-wrap">
                            <span class="pu-input-prefix"><i class="fas fa-id-card"></i></span>
                            <input type="text" class="form-control" name="username"
                                placeholder="Masukkan username/NIP"
                                autocomplete="nope" required />
                        </div>
                        <small class="text-muted mt-1 d-block">
                            <i class="fas fa-info-circle"></i> Password default: <strong>12345678</strong>
                        </small>
                    </div>
                    <div class="form-group mb-0">
                        <label>Hak Akses (Role)</label>
                        <select class="form-control" name="role" required>
                            <option value="" selected disabled hidden>Pilih Role...</option>
                            @foreach(\App\Models\Role::all() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->role }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="edit" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-user-edit me-2 text-info"></i> Ubah Data Pengguna
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('editpengguna') }}" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <input type="hidden" class="txtid" name="id">

                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <div class="pu-input-icon-wrap">
                            <span class="pu-input-prefix"><i class="fas fa-font"></i></span>
                            <input type="text" class="form-control txt-nama" name="nama" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Username / NIP</label>
                        <div class="pu-input-icon-wrap">
                            <span class="pu-input-prefix"><i class="fas fa-id-card"></i></span>
                            <input type="text" class="form-control txt-username" name="username" required />
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label>Hak Akses (Role)</label>
                        <select class="form-control txt-role" name="role" required>
                            @foreach(\App\Models\Role::all() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->role }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@stop

@section('custom_script')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();

        $("#dataTable").DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
            },
            pageLength: 10
        });

        // Edit Modal — populate fields
        let id, nama, username, role;
        $("#dataTable").on('click', '.btn-edit', function() {
            id = $(this).val();
            nama = $(this).data('nama');
            username = $(this).data('username');
            role = $(this).data('role');

            // populate immediately so modal shows values without extra clicks
            $(".txtid").val(id);
            $(".txt-nama").val(nama);
            $(".txt-username").val(username);
            $(".txt-role").val(role);
        });
        $('#edit').on('show.bs.modal', function() {
            $(".txtid").val(id);
            $(".txt-nama").val(nama);
            $(".txt-username").val(username);
            $(".txt-role").val(role);
        });



        // Konfirmasi reset password via SweetAlert
        $(document).on('submit', '.form-reset-password', function(e) {
            e.preventDefault();
            const form = this;
            PUAlert.confirmAction({
                title: 'Reset Password?',
                text: 'Password pengguna ini akan direset ke default (12345678).',
                icon: 'warning',
                confirmButtonText: 'Ya, reset',
                cancelButtonText: 'Batal'
            }, function() { form.submit(); });
        });

        // Konfirmasi hapus pengguna via SweetAlert
        $(document).on('submit', '.form-delete-pengguna', function(e) {
            e.preventDefault();
            const form = this;
            PUAlert.confirmAction({
                title: 'Hapus Pengguna?',
                text: 'Data pengguna ini akan dihapus dari sistem.',
                icon: 'warning',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }, function() { form.submit(); });
        });

        // --- Atur Akses Menu Modal ---
        $("#dataTable").on('click', '.btn-akses', function() {
            const id    = $(this).data('id');
            const nama  = $(this).data('nama');
            const akses = $(this).data('akses') || [];

            // Set judul modal
            $("#akses-user-nama").text(nama);

            // Set form action URL
            $("#formAksesMenu").attr('action', '/update-akses-menu/' + id);

            // Uncheck semua dulu
            $('.menu-checkbox').prop('checked', false);
            $('.menu-checkbox-label').removeClass('border-success bg-success bg-opacity-10');

            // Centang berdasarkan data akses user
            if (Array.isArray(akses) && akses.length > 0) {
                akses.forEach(function(menuKey) {
                    const $cb = $('#menu-' + menuKey);
                    $cb.prop('checked', true);
                    $cb.closest('.menu-checkbox-label').addClass('border-success bg-success bg-opacity-10');
                });
            }
        });

        // Visual feedback saat checkbox di-klik
        $(document).on('change', '.menu-checkbox', function() {
            const $label = $(this).closest('.menu-checkbox-label');
            if ($(this).is(':checked')) {
                $label.addClass('border-success bg-success bg-opacity-10');
            } else {
                $label.removeClass('border-success bg-success bg-opacity-10');
            }
        });

        // Tombol Pilih Semua
        $('#btn-pilih-semua').on('click', function() {
            $('.menu-checkbox').prop('checked', true);
            $('.menu-checkbox-label').addClass('border-success bg-success bg-opacity-10');
        });

        // Tombol Hapus Semua
        $('#btn-hapus-semua').on('click', function() {
            $('.menu-checkbox').prop('checked', false);
            $('.menu-checkbox-label').removeClass('border-success bg-success bg-opacity-10');
        });
    });
</script>
@stop
