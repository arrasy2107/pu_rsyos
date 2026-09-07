@extends('master.master')

@section('page_title', 'Riwayat Laporan Belum Diverifikasi')

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
</style>
@stop

@section('content')

<x-alert />

<?php


setlocale(LC_TIME, 'id_ID');
\Carbon\Carbon::setLocale('id');
$t = new Grei\TanggalMerah();
$hariini = date('Y-m-d');


?>

<x-page-header title="Riwayat Laporan" subtitle="Daftar laporan yang menunggu verifikasi" />

<x-data-card title="Menunggu Verifikasi" icon="fas fa-clock" class="border-left-warning shadow-sm">
    <?php
    $belumVerif = \App\Models\Laporan::with(['dinas', 'pengawas'])->where('id_pengawas', \Auth::user()->id)->where('verified', 0)->orderBy('created_at', 'DESC')->where('status', 1)->get();
    ?>
    <div class="table-responsive bg-white p-3 rounded border border-gray-200">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead class="thead-light">
                <tr>
                    <th width="7%">No</th>
                    <th width="15%">Tanggal</th>
                    <th width="10%">Jam</th>
                    <th>Dinas</th>
                    <th>Pengawas Umum</th>
                    <th width="20%">Tanda Tangan</th>
                    <th width="20%">Laporan</th>

                </tr>
            </thead>

            <?php
            $no = 1;
            ?>

            <tbody>
                <?php $no = 1; ?>
                @foreach($belumVerif as $data)
                <?php
                $t->set_date(date('Ymd', strtotime($data->created_at)));
                ?>
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{$data->created_at->isoFormat('dddd, D MMMM Y') }}</td>
                    <td>{{ date('H:i:s', strtotime($data->created_at)) }}</td>

                    <td class="align-middle">
                        {{ strtoupper($data->dinas->dinas ?? '') }}
                    </td>
                    <td class="align-middle">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 0.75rem; flex-shrink: 0;">
                                {{ strtoupper(substr($data->pengawas->nama ?? 'P', 0, 1)) }}
                            </div>
                            <span class="fw-bold">{{ $data->pengawas->nama ?? '' }}</span>
                        </div>
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
                @livewire('dashboard.catatan-pasien-istimewa-modal', [], key('catatan-pasien-istimewa'))
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
                @livewire('dashboard.catatan-pasien-baru-modal', [], key('catatan-pasien-baru'))
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
                @livewire('dashboard.permasalahan-modal', [], key('catatan-pasien-permasalahan'))
            </div>
        </div>
    </div>
</div>

@stop

@section('custom_script')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $("#dataTable").DataTable({
        "ordering": false
    });



    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        }
    });




    // Samakan mekanisme pemuatan detail dengan halaman riwayat PU.
    // `relatedTarget` adalah tombol IGD/Umum/IRJ/IBS yang membuka modal.
    function loadLaporanDetail(type, event, selector, endpoint) {
        const idlaporan = $(event.relatedTarget).val();

        if (!idlaporan) {
            return;
        }

        if (window.Livewire) {
            Livewire.dispatch('openLaporanDetailModal', {
                type: type,
                idlaporan: idlaporan
            });
            return;
        }

        $(selector).html('<div class="text-center py-5"><i class="fas fa-circle-notch fa-spin fa-3x text-primary mb-3"></i><p>Memuat data...</p></div>');
        $.ajax({
            type: 'get',
            url: endpoint + idlaporan,
            data: {
                idlaporan: idlaporan
            },
            success: function(data) {
                $(selector).html(data);
            }
        });
    }

    $('#igd').on('show.bs.modal', function(event) {
        loadLaporanDetail('igd', event, '.tableigd', 'refresh-detail-laporan-igd/');
    });
    $('#umum').on('show.bs.modal', function(event) {
        loadLaporanDetail('umum', event, '.tableumum', 'refresh-detail-laporan-umum/');
    });
    $('#irj').on('show.bs.modal', function(event) {
        loadLaporanDetail('irj', event, '.tableirj', 'refresh-detail-laporan-irj/');
    });
    $('#ibs').on('show.bs.modal', function(event) {
        loadLaporanDetail('ibs', event, '.tableibs', 'refresh-detail-laporan-ibs/');
    });


    // 
    $("#dataTableRuangan").on('click', '.btn-istimewa', function() {
        idlaporan = $(this).data('id');
        ruangan = $(this).data('ruangan');
        if (window.Livewire) {
            Livewire.dispatch('openIstimewaModal', {
                idlaporan: idlaporan,
                idruangan: ruangan
            });
            $('#istimewa').modal('show');
        } else {
            $(".tableistimewa").html('<h4>Mohon Tunggu...</h4>');
            $.ajax({
                type: "get",
                url: 'refresh-istimewa/' + idlaporan + '/' + ruangan,
                data: {
                    "_token": "{{ csrf_token() }}",
                    idlaporan: idlaporan,
                    idruangan: ruangan
                },
                success: function(data) {
                    $(".tableistimewa").html(data);
                }
            });
        }

    });

    $("#dataTableRuangan").on('click', '.btn-baru', function() {
        idlaporan = $(this).data('id');
        ruangan = $(this).data('ruangan');
        if (window.Livewire) {
            Livewire.dispatch('openBaruModal', {
                idlaporan: idlaporan,
                idruangan: ruangan
            });
            $('#baru').modal('show');
        } else {
            $(".tablebaru").html('<h4>Mohon Tunggu...</h4>');
            $.ajax({
                type: "get",
                url: 'refresh-baru/' + idlaporan + '/' + ruangan,
                data: {
                    "_token": "{{ csrf_token() }}",
                    idlaporan: idlaporan,
                    idruangan: ruangan
                },
                success: function(data) {
                    $(".tablebaru").html(data);
                }
            });
        }

    });

    $("#dataTableRuangan").on('click', '.btn-permasalahan', function() {
        idlaporan = $(this).data('id');
        ruangan = $(this).data('ruangan');
        if (window.Livewire) {
            Livewire.dispatch('openPermasalahanModal', {
                idlaporan: idlaporan,
                idruangan: ruangan
            });
            $('#permasalahan').modal('show');
        } else {
            $(".tablemasalah").html('<h4>Mohon Tunggu...</h4>');
            $.ajax({
                type: "get",
                url: 'refresh-permasalahan/' + idlaporan + '/' + ruangan,
                data: {
                    "_token": "{{ csrf_token() }}",
                    idlaporan: idlaporan,
                    idruangan: ruangan
                },
                success: function(data) {
                    $(".tablemasalah").html(data);
                }
            });
        }

    });


    (function($) {
        $(".alert-call").fadeOut(2500);
        $(".alert-call2").fadeOut(2500);
        $(".alert-call3").fadeOut(2500);
        $(".alert-call4").fadeOut(2500);
    })(jQuery);
</script>

@stop