@extends('master.master')

@section('page_title', 'Riwayat Laporan Sudah Diverifikasi')

@section('custom_style')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<style>
    .btn-action-group {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .signature-img {
        max-width: 150px;
        height: auto;
        border: 1px solid var(--color-neutral-200);
        border-radius: var(--radius-sm);
        padding: 5px;
        background: white;
    }

    .filter-section {
        background-color: var(--color-neutral-50);
        border: 1px solid var(--color-neutral-200);
        border-radius: var(--radius-md);
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
</style>
@stop

@section('content')

<x-alert />

<?php
setlocale(LC_TIME, 'id_ID');
\Carbon\Carbon::setLocale('id');
$t = new Grei\TanggalMerah();
?>

<x-page-header title="Riwayat Laporan" subtitle="Daftar laporan pengawas umum yang telah diverifikasi oleh Direktur" />

<x-data-card title="Sudah Diverifikasi" icon="fas fa-check-double" class="border-left-success shadow-sm">
    {{-- FILTER SECTION --}}
    <div class="filter-section shadow-sm">
        <div class="row">
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="form-group mb-0">
                    <label class="text-muted small fw-bold">Tanggal Mulai</label>
                    <input type="date" id="tanggal" class="form-control" name="tglmulai"/>
                </div>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="form-group mb-0">
                    <label class="text-muted small fw-bold">Tanggal Selesai</label>
                    <input type="date" id="tanggal2" class="form-control" name="tglselesai" />
                </div>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="form-group mb-0">
                    <label class="text-muted small fw-bold d-none d-md-block" style="visibility: hidden;">Aksi</label>
                    <button type="button" id="lihat" class="btn btn-primary w-100" name="lihat">
                        <i class="fas fa-search me-2"></i> Tampilkan Data
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLE SECTION --}}
    <div class="tablehistory bg-white p-3 rounded border border-gray-200">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="15%">Waktu Laporan</th>
                        <th>Dinas</th>
                        <th>Pengawas Umum</th>
                        <th>Verifikasi Keperawatan</th>
                        <th>Verifikasi Direktur</th>
                        <th>Tanda Tangan</th>
                        <th width="20%">Lihat Detail Laporan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $date = date_default_timezone_set('Asia/Jakarta');
                    $today = date('Y-m-d H:i:s');
                    $no = 1;
                    $userRole = (int) \Auth::user()->id_role;
                    $laporanQuery = \App\Models\Laporan::with(['dinas', 'pengawas'])->whereBetween('created_at', [date("Y-m-d", strtotime("-1 month")), $today])->where('status', 1);
                    
                    if ($userRole === 3) {
                        $laporanQuery->where('verified_bidang', 1);
                    } else {
                        $laporanQuery->where('verified', 1);
                    }
                    
                    $laporans = $laporanQuery->orderBy('updated_at', 'DESC')->get();
                    ?>
                    @foreach($laporans as $data)
                    @php $t->set_date(date('Ymd', strtotime($data->created_at))); @endphp
                    <tr>
                        <td class="text-center align-middle">{{ $no++ }}</td>
                        <td class="align-middle">
                            <div class="fw-bold">{{ $data->created_at->isoFormat('dddd, D MMMM Y') }}</div>
                            <div class="text-muted small"><i class="fas fa-clock me-1"></i> {{ date('H:i:s', strtotime($data->created_at)) }}</div>
                        </td>
                        <td class="align-middle">
                            <span class="badge bg-primary px-2 py-1">{{ strtoupper($data->dinas->dinas ?? '') }}</span>
                        </td>
                        <td class="align-middle fw-bold">
                            {{ $data->pengawas->nama ?? '' }}
                        </td>
                        <td class="text-center align-middle">
                            @if($data->verified_bidang)
                            <span class="badge bg-success"><i class="fas fa-check me-1"></i>Terverifikasi</span>
                            @else
                            <span class="badge bg-warning text-dark"><i class="fas fa-exclamation-triangle me-1"></i>Belum tercatat</span>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            @if($data->verified)
                            <span class="badge bg-success"><i class="fas fa-check-double me-1"></i>Terverifikasi Final</span>
                            @else
                            <span class="badge bg-warning text-dark"><i class="fas fa-spinner fa-spin me-1"></i>Menunggu</span>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            <img class="signature-img shadow-sm" src="{{asset('signature/'.$data->signature)}}" alt="Tanda Tangan">
                        </td>
                        <td class="align-middle">
                            <div class="btn-action-group">
                                <button value="{{ $data->id }}" class="btn btn-sm btn-danger btn-igd shadow-sm" data-jenis="1" data-bs-toggle="modal" data-bs-target="#igd">
                                    <i class="fas fa-ambulance me-1"></i> IGD
                                </button>
                                <button value="{{ $data->id }}" class="btn btn-sm btn-success btn-umum shadow-sm" data-jenis="2" data-bs-toggle="modal" data-bs-target="#umum">
                                    <i class="fas fa-procedures me-1"></i> Umum
                                </button>
                                <button value="{{ $data->id }}" class="btn btn-sm btn-warning btn-ibs shadow-sm text-dark" data-jenis="4" data-bs-toggle="modal" data-bs-target="#ibs">
                                    <i class="fas fa-syringe me-1"></i> IBS
                                </button>

                                @if($data->id_dinas != 3 && $t->check() != true)
                                <button value="{{ $data->id }}" class="btn btn-sm btn-primary btn-irj shadow-sm" data-jenis="3" data-bs-toggle="modal" data-bs-target="#irj">
                                    <i class="fas fa-stethoscope me-1"></i> IRJ
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3 text-muted small">
            <i class="fas fa-info-circle text-primary me-1"></i>
            Secara default, tabel menampilkan riwayat laporan <strong>1 bulan terakhir</strong>. Gunakan filter di atas untuk melihat data yang lebih lama.
        </div>
    </div>
</x-data-card>

{{-- ========================================== --}}
{{-- MODAL DETAIL LAPORAN --}}
{{-- ========================================== --}}

<!-- Modal IGD -->
<div id="igd" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header pu-card-gradient-header text-white">
                <h5 class="modal-title fw-bold"><i class="fas fa-ambulance me-2"></i> Instalasi Gawat Darurat (IGD)</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light p-4">
                <div class="tableigd">
                    @livewire('dashboard.laporan-detail-modal', ['modalType' => 'igd'], key('laporan-detail-igd'))
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal IBS -->
<div id="ibs" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header pu-card-gradient-header text-white">
                <h5 class="modal-title fw-bold"><i class="fas fa-syringe me-2"></i> Instalasi Bedah Sentral (IBS)</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light p-4">
                <div class="tableibs">
                    @livewire('dashboard.laporan-detail-modal', ['modalType' => 'ibs'], key('laporan-detail-ibs'))
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Umum -->
<div id="umum" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header pu-card-gradient-header text-white">
                <h5 class="modal-title fw-bold"><i class="fas fa-procedures me-2"></i> Umum / Ruangan</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light p-4">
                <div class="tableumum">
                    @livewire('dashboard.laporan-detail-modal', ['modalType' => 'umum'], key('laporan-detail-umum'))
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal IRJ -->
<div id="irj" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header pu-card-gradient-header text-white">
                <h5 class="modal-title fw-bold"><i class="fas fa-stethoscope me-2"></i> Instalasi Rawat Jalan (IRJ)</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light p-4">
                <div class="tableirj">
                    @livewire('dashboard.laporan-detail-modal', ['modalType' => 'irj'], key('laporan-detail-irj'))
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL SUB-DETAIL (Istimewa, Baru, Permasalahan) --}}

<!-- Modal Istimewa -->
<div id="istimewa" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="fas fa-star text-warning me-2"></i> Catatan Pasien Istimewa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="tableistimewa">
                    @livewire('dashboard.catatan-pasien-istimewa-modal', [], key('catatan-pasien-istimewa'))
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Baru -->
<div id="baru" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="fas fa-user-plus text-success me-2"></i> Catatan Pasien Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="tablebaru">
                    @livewire('dashboard.catatan-pasien-baru-modal', [], key('catatan-pasien-baru'))
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Permasalahan -->
<div id="permasalahan" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="fas fa-exclamation-triangle text-danger me-2"></i> Permasalahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="tablemasalah">
                    @livewire('dashboard.permasalahan-modal', [], key('catatan-pasien-permasalahan'))
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('custom_script')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        $("#dataTable").DataTable({
            "ordering": false,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
            },
            pageLength: 10
        });

        // Auto-hide alerts
        setTimeout(function() {
            $(".alert-call").fadeOut(500);
        }, 3500);

        // ==========================================
        // Handle Filter AJAX
        // ==========================================
        $("#lihat").click(function() {
            if (!$("#tanggal").val() || !$("#tanggal2").val()) {
                alert('Silakan lengkapi tanggal mulai dan tanggal selesai terlebih dahulu.');
            } else {
                $(".tablehistory").html('<div class="text-center py-5"><i class="fas fa-circle-notch fa-spin fa-3x text-primary mb-3"></i><p>Memuat riwayat laporan...</p></div>');
                $.ajax({
                    type: "get",
                    url: '{{ url("/refresh-history") }}/' + $("#tanggal").val() + '/' + $("#tanggal2").val(),
                    data: {
                        tanggal: $("#tanggal").val(),
                        tanggal2: $("#tanggal2").val()
                    },
                    success: function(data) {
                        $(".tablehistory").html(data);
                    },
                    error: function() {
                        alert('Gagal memuat data. Silakan coba lagi.');
                        location.reload();
                    }
                });
            }
        });

        // ==========================================
        // Handle Detail Modals loading (using event delegation for AJAX loaded tables)
        // ==========================================
        let id1, id2, id3, id4;

        $(document).on('click', '.btn-igd', function() {
            id1 = $(this).val();
        });
        $(document).on('click', '.btn-umum', function() {
            id2 = $(this).val();
        });
        $(document).on('click', '.btn-irj', function() {
            id3 = $(this).val();
        });
        $(document).on('click', '.btn-ibs', function() {
            id4 = $(this).val();
        });

        $('#igd').on('show.bs.modal', function() {
            if (window.Livewire) {
                Livewire.dispatch('openLaporanDetailModal', {
                    type: 'igd',
                    idlaporan: id1
                });
            } else {
                $(".tableigd").html('<div class="text-center py-5"><i class="fas fa-circle-notch fa-spin fa-3x text-primary mb-3"></i><p>Memuat data IGD...</p></div>');
                $.ajax({
                    type: "get",
                    url: 'refresh-detail-laporan-igd/' + id1,
                    data: {
                        idlaporan: id1
                    },
                    success: function(data) {
                        $(".tableigd").html(data);
                    }
                });
            }
        });

        $('#umum').on('show.bs.modal', function() {
            if (window.Livewire) {
                Livewire.dispatch('openLaporanDetailModal', {
                    type: 'umum',
                    idlaporan: id2
                });
            } else {
                $(".tableumum").html('<div class="text-center py-5"><i class="fas fa-circle-notch fa-spin fa-3x text-primary mb-3"></i><p>Memuat data Umum...</p></div>');
                $.ajax({
                    type: "get",
                    url: 'refresh-detail-laporan-umum/' + id2,
                    data: {
                        idlaporan: id2
                    },
                    success: function(data) {
                        $(".tableumum").html(data);
                    }
                });
            }
        });

        $('#irj').on('show.bs.modal', function() {
            if (window.Livewire) {
                Livewire.dispatch('openLaporanDetailModal', {
                    type: 'irj',
                    idlaporan: id3
                });
            } else {
                $(".tableirj").html('<div class="text-center py-5"><i class="fas fa-circle-notch fa-spin fa-3x text-primary mb-3"></i><p>Memuat data IRJ...</p></div>');
                $.ajax({
                    type: "get",
                    url: 'refresh-detail-laporan-irj/' + id3,
                    data: {
                        idlaporan: id3
                    },
                    success: function(data) {
                        $(".tableirj").html(data);
                    }
                });
            }
        });

        $('#ibs').on('show.bs.modal', function() {
            if (window.Livewire) {
                Livewire.dispatch('openLaporanDetailModal', {
                    type: 'ibs',
                    idlaporan: id4
                });
            } else {
                $(".tableibs").html('<div class="text-center py-5"><i class="fas fa-circle-notch fa-spin fa-3x text-primary mb-3"></i><p>Memuat data IBS...</p></div>');
                $.ajax({
                    type: "get",
                    url: 'refresh-detail-laporan-ibs/' + id4,
                    data: {
                        idlaporan: id4
                    },
                    success: function(data) {
                        $(".tableibs").html(data);
                    }
                });
            }
        });

        // ==========================================
        // Handle Sub-Modals (Loaded dynamically in Umum)
        // ==========================================
        $(document).on('click', '.btn-istimewa', function() {
            let idlaporan = $(this).data('id');
            let ruangan = $(this).data('ruangan');
            if (window.Livewire) {
                Livewire.dispatch('openIstimewaModal', {
                    idlaporan: idlaporan,
                    idruangan: ruangan
                });
            } else {
                $(".tableistimewa").html('<div class="text-center p-4"><i class="fas fa-circle-notch fa-spin fa-2x mb-2 text-primary"></i></div>');
                $.ajax({
                    type: "get",
                    url: 'refresh-istimewa/' + idlaporan + '/' + ruangan,
                    data: {
                        idlaporan: idlaporan,
                        idruangan: ruangan
                    },
                    success: function(data) {
                        $(".tableistimewa").html(data);
                    }
                });
            }
        });

        $(document).on('click', '.btn-baru', function() {
            let idlaporan = $(this).data('id');
            let ruangan = $(this).data('ruangan');
            if (window.Livewire) {
                Livewire.dispatch('openBaruModal', {
                    idlaporan: idlaporan,
                    idruangan: ruangan
                });
            } else {
                $(".tablebaru").html('<div class="text-center p-4"><i class="fas fa-circle-notch fa-spin fa-2x mb-2 text-primary"></i></div>');
                $.ajax({
                    type: "get",
                    url: 'refresh-baru/' + idlaporan + '/' + ruangan,
                    data: {
                        idlaporan: idlaporan,
                        idruangan: ruangan
                    },
                    success: function(data) {
                        $(".tablebaru").html(data);
                    }
                });
            }
        });

        $(document).on('click', '.btn-permasalahan', function() {
            let idlaporan = $(this).data('id');
            let ruangan = $(this).data('ruangan');
            if (window.Livewire) {
                Livewire.dispatch('openPermasalahanModal', {
                    idlaporan: idlaporan,
                    idruangan: ruangan
                });
            } else {
                $(".tablemasalah").html('<div class="text-center p-4"><i class="fas fa-circle-notch fa-spin fa-2x mb-2 text-primary"></i></div>');
                $.ajax({
                    type: "get",
                    url: 'refresh-permasalahan/' + idlaporan + '/' + ruangan,
                    data: {
                        idlaporan: idlaporan,
                        idruangan: ruangan
                    },
                    success: function(data) {
                        $(".tablemasalah").html(data);
                    }
                });
            }
        });
    });
</script>
@stop
