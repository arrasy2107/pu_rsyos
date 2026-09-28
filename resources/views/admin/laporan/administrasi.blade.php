@extends('master.master')

@section('page_title', 'Administrasi Laporan')

@section('custom_style')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<style>
    .admin-report-filter {
        background: var(--color-neutral-50);
        border: 1px solid var(--color-neutral-200);
        border-radius: var(--radius-md);
        padding: 1.25rem;
    }

    .admin-report-table th {
        white-space: nowrap;
    }

    .admin-report-table td {
        vertical-align: middle;
    }

    .admin-report-table .btn {
        white-space: nowrap;
    }

</style>
@stop

@section('content')
<x-alert />

<x-page-header title="Administrasi Laporan" subtitle="Kelola pengembalian laporan tanpa melakukan verifikasi">
    <x-slot name="actions">
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">
            <i class="fas fa-user-shield me-1"></i> Super Admin
        </span>
    </x-slot>
</x-page-header>

<x-data-card title="Daftar Laporan Terkirim" icon="fas fa-file-signature" class="border-left-primary shadow-sm">
    <form method="GET" action="{{ route('administrasi-laporan') }}" class="admin-report-filter mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="tanggal_mulai" class="form-label small fw-bold">Tanggal Mulai</label>
                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
            </div>
            <div class="col-md-3">
                <label for="tanggal_selesai" class="form-label small fw-bold">Tanggal Selesai</label>
                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}">
            </div>
            <div class="col-md-3">
                <label for="status_verifikasi" class="form-label small fw-bold">Status Verifikasi</label>
                <select class="form-select" id="status_verifikasi" name="status_verifikasi">
                    <option value="">Semua Status</option>
                    <option value="belum_bidang" @selected(request('status_verifikasi') === 'belum_bidang')>Menunggu Bidang</option>
                    <option value="belum_direktur" @selected(request('status_verifikasi') === 'belum_direktur')>Menunggu Direktur</option>
                    <option value="selesai" @selected(request('status_verifikasi') === 'selesai')>Selesai Diverifikasi</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <a href="{{ route('administrasi-laporan') }}" class="btn btn-outline-secondary" title="Reset filter" aria-label="Reset filter">
                    <i class="fas fa-undo"></i>
                </a>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover admin-report-table" id="administrasiLaporanTable">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Waktu Laporan</th>
                    <th>Dinas</th>
                    <th>Pengawas</th>
                    <th>Verifikasi Bidang</th>
                    <th>Verifikasi Direktur</th>
                    <th width="15%" class="text-center">Aksi Administratif</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporans as $index => $laporan)
                <tr>
                    <td>{{ $laporans->firstItem() + $index }}</td>
                    <td>
                        <div class="fw-semibold">{{ $laporan->created_at->isoFormat('D MMMM Y') }}</div>
                        <small class="text-muted">{{ $laporan->created_at->format('H:i:s') }}</small>
                    </td>
                    <td><span class="badge bg-secondary">{{ strtoupper($laporan->dinas->dinas ?? '-') }}</span></td>
                    <td class="fw-semibold"><span class="badge bg-primary">{{ $laporan->pengawas->nama ?? '-' }}</span></td>
                    <td>
                        @if($laporan->verified_bidang)
                            <span class="badge bg-success"><i class="fas fa-check me-1"></i>Selesai</span>
                        @else
                            <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Menunggu</span>
                        @endif
                    </td>
                    <td>
                        @if($laporan->verified)
                            <span class="badge bg-success"><i class="fas fa-check-double me-1"></i>Selesai</span>
                        @else
                            <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Menunggu</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger btn-kembalikan"
                            data-bs-toggle="modal" data-bs-target="#kembalikanLaporanModal"
                            data-action="{{ route('administrasi-laporan.kembalikan', $laporan->id) }}"
                            data-pengawas="{{ $laporan->pengawas->nama ?? 'pengawas' }}">
                            <i class="fas fa-undo me-1"></i>Kembalikan
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fas fa-folder-open d-block fs-2 mb-2 text-secondary"></i>
                        Tidak ada laporan sesuai filter.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($laporans->hasPages())
    <div class="mt-3">
        {{ $laporans->links() }}
    </div>
    @endif

    <div class="alert alert-info mt-4 mb-0">
        <i class="fas fa-info-circle me-2"></i>
        Pengembalian akan membatalkan status verifikasi dan mengembalikan seluruh detail laporan ke draft pengawas. Verifikasi tetap hanya dapat dilakukan oleh role 1 dan role 3.
    </div>
</x-data-card>

<div class="modal fade" id="kembalikanLaporanModal" tabindex="-1" aria-labelledby="kembalikanLaporanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="kembalikanLaporanModalLabel"><i class="fas fa-undo me-2"></i>Kembalikan Laporan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form method="POST" id="kembalikanLaporanForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <p>Laporan akan dikembalikan kepada <strong id="namaPengawas">pengawas</strong> untuk diperbaiki.</p>
                    <label for="alasan" class="form-label fw-semibold">Alasan pengembalian</label>
                    <textarea class="form-control" id="alasan" name="alasan" rows="4" minlength="10" maxlength="1000" required placeholder="Jelaskan data yang perlu diperbaiki..."></textarea>
                    <div class="form-text">Minimal 10 karakter. Alasan akan dicatat pada log aktivitas.</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger"><i class="fas fa-undo me-1"></i>Ya, kembalikan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('custom_script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('kembalikanLaporanModal');
        var form = document.getElementById('kembalikanLaporanForm');
        var namaPengawas = document.getElementById('namaPengawas');
        var alasan = document.getElementById('alasan');

        document.querySelectorAll('.btn-kembalikan').forEach(function(button) {
            button.addEventListener('click', function() {
                form.action = this.dataset.action;
                namaPengawas.textContent = this.dataset.pengawas;
                alasan.value = '';
            });
        });

        form.addEventListener('submit', function(event) {
            if (alasan.value.trim().length < 10) {
                event.preventDefault();
                alasan.focus();
            }
        });
    });
</script>
@stop
