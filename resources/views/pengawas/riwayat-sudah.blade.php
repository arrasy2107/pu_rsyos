@extends('master.master')

@section('page_title', 'Riwayat Sudah Diverifikasi')

@section('content')

<div class="container-fluid">

    <x-alert />

    <?php
    setlocale(LC_TIME, 'id_ID');
    \Carbon\Carbon::setLocale('id');
    $t = new Grei\TanggalMerah();
    $date = date_default_timezone_set('Asia/Jakarta');
    $today = date('Y-m-d H:i:s');
    $laporans = \App\Models\Laporan::with(['dinas', 'pengawas'])
        ->where('id_pengawas', \Auth::id())
        ->where('verified', 1)
        ->where('verified_bidang', 1)
        ->where('status', 1)
        ->whereBetween('created_at', [date('Y-m-d', strtotime('-1 month')), $today])
        ->orderBy('updated_at', 'DESC')
        ->get();
    ?>

    <x-page-header title="Riwayat Laporan Sebulan Terakhir" subtitle="Laporan yang telah diverifikasi oleh Direktur dalam 30 hari terakhir">
        <x-slot name="actions">
            <span class="badge bg-success px-3 py-2 shadow-sm" style="font-size: 0.875rem;">
                <i class="fas fa-check-double me-2"></i> Sudah Terverifikasi
            </span>
        </x-slot>
    </x-page-header>

    {{-- Filter Card --}}
    <x-data-card title="Filter Rentang Tanggal" icon="fas fa-filter" class="mb-4">
        <div class="row align-items-end">
            <div class="col-md-4">
                <div class="form-group mb-0">
                    <label class="fw-bold text-dark small text-uppercase">Tanggal Mulai</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-right-0"><i class="fas fa-calendar-alt text-primary"></i></span>
                        </div>
                        <input type="date" id="tanggal" class="form-control border-left-0" name="tglmulai" />
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-0">
                    <label class="fw-bold text-dark small text-uppercase">Tanggal Selesai</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-right-0"><i class="fas fa-calendar-check text-success"></i></span>
                        </div>
                        <input type="date" id="tanggal2" class="form-control border-left-0" name="tglselesai" />
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <button type="button" id="lihat" class="btn btn-primary w-100 shadow-sm">
                    <i class="fas fa-search me-2"></i> Cari Laporan
                </button>
            </div>
        </div>
    </x-data-card>

    {{-- Data Table Card --}}
    <x-data-card title="Laporan Terverifikasi (30 Hari Terakhir)" icon="fas fa-clipboard-check" headerClass="text-success">
        <x-slot name="actions">
            <span class="text-muted small"><i class="fas fa-info-circle me-1"></i> Gunakan filter di atas untuk mempersempit pencarian</span>
        </x-slot>
        <div class="col-md-12 tablehistory p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%" class="text-center ps-4">No</th>
                            <th width="18%">Tanggal</th>
                            <th width="8%">Jam</th>
                            <th width="10%">Dinas</th>
                            <th>Pengawas Umum</th>
                            <th width="14%">Tanda Tangan</th>
                            <th width="22%" class="text-center">Detail Laporan</th>
                        </tr>
                    </thead>
                    <?php $no = 1; ?>
                    <tbody>
                        @forelse($laporans as $data)
                        <?php $t->set_date(date('Ymd', strtotime($data->created_at))); ?>
                        <tr>
                            <td class="text-center align-middle ps-4 fw-bold text-muted">{{ $no++ }}</td>
                            <td class="align-middle">
                                <div class="fw-bold text-dark">{{ $data->created_at->isoFormat('dddd') }}</div>
                                <div class="text-muted small">{{ $data->created_at->isoFormat('D MMMM Y') }}</div>
                            </td>
                            <td class="align-middle">
                                <span class="badge bg-light border px-2 py-1">{{ date('H:i', strtotime($data->created_at)) }}</span>
                            </td>
                            <td class="align-middle">
                                <span class="badge bg-primary px-2 py-1 text-uppercase" style="font-size: 0.7rem;">
                                    {{ $data->dinas->dinas ?? '-' }}
                                </span>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 0.75rem; flex-shrink: 0;">
                                        {{ strtoupper(substr($data->pengawas->nama ?? 'P', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $data->pengawas->nama ?? '' }}</div>
                                        <div><span class="badge bg-success" style="font-size: 0.65rem;"><i class="fas fa-check me-1"></i>Terverifikasi</span></div>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <img style="max-width:120px; height:auto;" class="img-fluid rounded border shadow-sm" src="{{asset('signature/'.$data->signature)}}" alt="Tanda Tangan">
                            </td>
                            <td class="align-middle text-center">
                                <div class="d-flex flex-wrap justify-content-center" style="gap: 4px;">
                                    <button value="{{ $data->id }}" class="btn btn-sm btn-danger btn-igd" data-bs-toggle="modal" data-bs-target="#igd" title="IGD">
                                        <i class="fas fa-ambulance me-1"></i>IGD
                                    </button>
                                    <button value="{{ $data->id }}" class="btn btn-sm btn-success btn-umum" data-bs-toggle="modal" data-bs-target="#umum" title="Ruangan">
                                        <i class="fas fa-procedures me-1"></i>Umum
                                    </button>
                                    <button value="{{ $data->id }}" class="btn btn-sm btn-warning text-dark btn-ibs" data-bs-toggle="modal" data-bs-target="#ibs" title="IBS">
                                        <i class="fas fa-syringe me-1"></i>IBS
                                    </button>
                                    @if($data->id_dinas != 3 && $t->check() != true)
                                    <button value="{{ $data->id }}" class="btn btn-sm btn-primary btn-irj" data-bs-toggle="modal" data-bs-target="#irj" title="IRJ">
                                        <i class="fas fa-stethoscope me-1"></i>IRJ
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-folder-open fa-3x mb-3 text-gray-300"></i>
                                    <p class="mb-0 fw-bold">Tidak ada laporan yang sudah diverifikasi dalam sebulan terakhir.</p>
                                    <p class="small">Coba ubah rentang tanggal pencarian di atas.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </x-data-card>

    {{-- MODALS --}}
    <!-- Modal IGD -->
    <div id="igd" class="modal fade" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header pu-card-gradient-header text-white">
                    <h5 class="modal-title fw-bold"><i class="fas fa-ambulance me-2"></i> Detail Laporan — Instalasi Gawat Darurat (IGD)</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light p-4">
                    <div class="tableigd">
                        <div class="text-center py-4"><i class="fas fa-circle-notch fa-spin fa-2x text-primary"></i></div>
                    </div>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Umum/Ruangan -->
    <div id="umum" class="modal fade" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold"><i class="fas fa-procedures me-2"></i> Detail Laporan — Umum / Ruangan</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light p-4">
                    <div class="tableumum">
                        <div class="text-center py-4"><i class="fas fa-circle-notch fa-spin fa-2x text-success"></i></div>
                    </div>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal IBS -->
    <div id="ibs" class="modal fade" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title fw-bold text-dark"><i class="fas fa-syringe me-2"></i> Detail Laporan — Instalasi Bedah Sentral (IBS)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light p-4">
                    <div class="tableibs">
                        <div class="text-center py-4"><i class="fas fa-circle-notch fa-spin fa-2x text-warning"></i></div>
                    </div>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal IRJ -->
    <div id="irj" class="modal fade" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold"><i class="fas fa-stethoscope me-2"></i> Detail Laporan — Instalasi Rawat Jalan (IRJ)</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light p-4">
                    <div class="tableirj">
                        <div class="text-center py-4"><i class="fas fa-circle-notch fa-spin fa-2x text-primary"></i></div>
                    </div>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pasien Istimewa -->
    <div id="istimewa" class="modal fade" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="fas fa-star me-2 text-warning"></i> Catatan Pasien Istimewa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light p-4">
                    <div class="tableistimewa">
                        @livewire('dashboard.catatan-pasien-istimewa-modal', [], key('catatan-pasien-istimewa-sudah'))
                    </div>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pasien Baru -->
    <div id="baru" class="modal fade" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="fas fa-user-plus me-2 text-success"></i> Catatan Pasien Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light p-4">
                    <div class="tablebaru">
                        @livewire('dashboard.catatan-pasien-baru-modal', [], key('catatan-pasien-baru-sudah'))
                    </div>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Permasalahan -->
    <div id="permasalahan" class="modal fade" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="fas fa-exclamation-triangle me-2 text-danger"></i> Permasalahan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light p-4">
                    <div class="tablemasalah">
                        @livewire('dashboard.permasalahan-modal', [], key('catatan-pasien-permasalahan-sudah'))
                    </div>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @stop

    @section('custom_script')
    <script>
        $(function() {
            $("#dataTable").DataTable({
                "ordering": false,
                "language": {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
                },
                "columnDefs": [{
                    "orderable": false,
                    "targets": [0, 6]
                }]
            });

            setTimeout(function() {
                $(".alert-call, .alert-call2, .alert-call3, .alert-call4").fadeOut(500);
            }, 3500);
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        let id1, id2, id3, id4;

        $("#dataTable").on('click', '.btn-igd', function() {
            id1 = $(this).val();
        });
        $("#dataTable").on('click', '.btn-umum', function() {
            id2 = $(this).val();
        });
        $("#dataTable").on('click', '.btn-irj', function() {
            id3 = $(this).val();
        });
        $("#dataTable").on('click', '.btn-ibs', function() {
            id4 = $(this).val();
        });

        function loadModal(selector, url, data) {
            $(selector).html('<div class="text-center py-5"><i class="fas fa-circle-notch fa-spin fa-2x text-primary"></i><p class="mt-3 text-muted">Memuat data...</p></div>');
            $.ajax({
                type: "get",
                url: url,
                data: data,
                success: function(res) {
                    $(selector).html(res);
                }
            });
        }

        $('#igd').on('show.bs.modal', function() {
            if (window.Livewire) {
                Livewire.dispatch('openLaporanDetailModal', {
                    type: 'igd',
                    idlaporan: id1
                });
            } else {
                loadModal('.tableigd', 'refresh-detail-laporan-igd/' + id1, {
                    idlaporan: id1
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
                loadModal('.tableumum', 'refresh-detail-laporan-umum/' + id2, {
                    idlaporan: id2
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
                loadModal('.tableirj', 'refresh-detail-laporan-irj/' + id3, {
                    idlaporan: id3
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
                loadModal('.tableibs', 'refresh-detail-laporan-ibs/' + id4, {
                    idlaporan: id4
                });
            }
        });

        // Filter by date range
        $("#lihat").click(function() {
            if (!$("#tanggal").val() || !$("#tanggal2").val()) {
                alert('Lengkapi tanggal mulai dan tanggal selesai dahulu.');
            } else {
                $(".tablehistory").html('<div class="text-center py-5"><i class="fas fa-circle-notch fa-spin fa-3x text-primary"></i><p class="mt-3 text-muted fw-bold">Sedang memuat data laporan...</p></div>');
                $.ajax({
                    type: "get",
                    url: 'refresh-history/' + $("#tanggal").val() + '/' + $("#tanggal2").val(),
                    data: {
                        tanggal: $("#tanggal").val(),
                        tanggal2: $("#tanggal2").val()
                    },
                    success: function(data) {
                        $(".tablehistory").html(data);
                        // Re-initialize DataTable in the AJAX response if needed
                    }
                });
            }
        });

        // Sub-modal triggers from AJAX-loaded content (use Livewire when available)
        $(document).on('click', "#dataTableRuangan .btn-istimewa", function() {
            let idlaporan = $(this).data('id'),
                ruangan = $(this).data('ruangan');
            if (window.Livewire) {
                Livewire.dispatch('openIstimewaModal', {
                    idlaporan: idlaporan,
                    idruangan: ruangan
                });
                $('#istimewa').modal('show');
            } else {
                loadModal('.tableistimewa', 'refresh-istimewa/' + idlaporan + '/' + ruangan, {
                    idlaporan: idlaporan,
                    idruangan: ruangan
                });
            }
        });

        $(document).on('click', "#dataTableRuangan .btn-baru", function() {
            let idlaporan = $(this).data('id'),
                ruangan = $(this).data('ruangan');
            if (window.Livewire) {
                Livewire.dispatch('openBaruModal', {
                    idlaporan: idlaporan,
                    idruangan: ruangan
                });
                $('#baru').modal('show');
            } else {
                loadModal('.tablebaru', 'refresh-baru/' + idlaporan + '/' + ruangan, {
                    idlaporan: idlaporan,
                    idruangan: ruangan
                });
            }
        });

        $(document).on('click', "#dataTableRuangan .btn-permasalahan", function() {
            let idlaporan = $(this).data('id'),
                ruangan = $(this).data('ruangan');
            if (window.Livewire) {
                Livewire.dispatch('openPermasalahanModal', {
                    idlaporan: idlaporan,
                    idruangan: ruangan
                });
                $('#permasalahan').modal('show');
            } else {
                loadModal('.tablemasalah', 'refresh-permasalahan/' + idlaporan + '/' + ruangan, {
                    idlaporan: idlaporan,
                    idruangan: ruangan
                });
            }
        });
    </script>

</div>
@stop