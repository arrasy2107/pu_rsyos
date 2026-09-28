<div>
    <x-data-card>
        <div class="row align-items-end mb-4">
            <div class="col-md-3 mb-3 mb-md-0">
                <div class="mb-0">
                    <label class="fw-bold text-gray-700 form-label">Tahun</label>
                    <div wire:ignore class="select2-wrapper">
                    <select id="jadwalTahun" class="form-select jadwal-select2" wire:model.live="tahun" data-livewire-property="tahun">
                        <option value="">Pilih Tahun</option>
                        @foreach($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3 mb-md-0">
                <div class="mb-0">
                    <label class="fw-bold text-gray-700 form-label">Bulan</label>
                    <div wire:ignore class="select2-wrapper">
                    <select id="jadwalBulan" class="form-select jadwal-select2" wire:model.live="bulan" data-livewire-property="bulan">
                        <option value="">Pilih Bulan</option>
                        @foreach($months as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <button wire:click="lihatJadwal" wire:loading.attr="disabled" wire:target="lihatJadwal" class="btn btn-primary w-100" style="height: 42px;" type="button">
                    <span wire:loading.remove wire:target="lihatJadwal">
                        <i class="fas fa-search me-2"></i> Lihat Jadwal
                    </span>
                    <span wire:loading wire:target="lihatJadwal"><i class="fas fa-spinner fa-spin me-2"></i>Memuat...</span>
                </button>
            </div>

            <div class="col-md-3">
                <button wire:click="exportExcel" wire:loading.attr="disabled" wire:target="exportExcel" class="btn btn-success w-100" style="height: 42px;" type="button" @disabled(!$schedule)>
                    <span wire:loading.remove wire:target="exportExcel"><i class="fas fa-file-excel me-2"></i> Ekspor XLSX</span>
                    <span wire:loading wire:target="exportExcel"><i class="fas fa-spinner fa-spin me-2"></i> Mengekspor...</span>
                </button>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-12 tablejadwal">
                @if(!$schedule)
                <x-empty-state
                    icon="fas fa-calendar-alt"
                    title="Pilih Bulan dan Tahun"
                    message="Silakan pilih tahun dan bulan, lalu klik 'Lihat Jadwal' untuk memuat data jadwal dinas." />
                @else
                <div class="mt-5">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                        <h3 class="mb-0">{{ $schedule['monthName'] }} {{ $tahun }}</h3>
                        <div class="jadwal-view-switch" role="group" aria-label="Mode tampilan jadwal">
                            <button type="button" wire:click="$set('viewMode', 'calendar')" aria-pressed="{{ $viewMode === 'calendar' ? 'true' : 'false' }}" class="jadwal-view-option {{ $viewMode === 'calendar' ? 'is-active' : '' }}">
                                <i class="fas fa-calendar-alt me-1"></i> Kalender
                            </button>
                            <button type="button" wire:click="$set('viewMode', 'list')" aria-pressed="{{ $viewMode === 'list' ? 'true' : 'false' }}" class="jadwal-view-option {{ $viewMode === 'list' ? 'is-active' : '' }}">
                                <i class="fas fa-list me-1"></i> Daftar
                            </button>
                        </div>
                    </div>

                    @if($viewMode === 'list')
                    <div wire:key="jadwal-list-view" class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Pengawas</label>
                            <div wire:ignore class="select2-wrapper">
                            <select id="jadwalFilterPengawas" class="form-control select2 jadwal-select2" wire:model.live="filterPengawas" data-livewire-property="filterPengawas">
                                <option value="">Semua Pengawas</option>
                                @foreach($pengawas as $mb)
                                <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                                @endforeach
                            </select>
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Status Jadwal</label>
                            <div wire:ignore class="select2-wrapper">
                            <select id="jadwalFilterStatus" class="form-control select2 jadwal-select2" wire:model.live="filterStatus" data-livewire-property="filterStatus">
                                <option value="all">Semua Status</option>
                                <option value="assigned">Terisi</option>
                                <option value="unassigned">Belum Terisi</option>
                            </select>
                                </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle jadwal-list-table">
                            <thead class="table-primary">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Tanggal</th>
                                    <th>Hari</th>
                                    @foreach($dinas as $shift)
                                    <th class="jadwal-shift-heading text-center">{{ ucfirst($shift->dinas) }}</th>
                                    @endforeach
                                    <th class="text-center">Ringkasan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($schedule['listRecords'] as $index => $dateRecord)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="text-nowrap">
                                        <strong>{{ $dateRecord['tanggal']->format('d/m/Y') }}</strong>
                                        @if($schedule['holidayMap'][$dateRecord['tanggal']->format('Y-m-d')])
                                        <span class="badge bg-danger-subtle text-danger ms-1">Libur</span>
                                        @endif
                                    </td>
                                    <td>{{ $dateRecord['tanggal']->locale('id')->translatedFormat('l') }}</td>
                                    @foreach($dinas as $shift)
                                    @php
                                        $shiftRecord = $dateRecord['shifts']->get($shift->id);
                                        $isVisible = $shiftRecord['matchesFilter'];
                                        $piket = $shiftRecord['piket'];
                                        $irj = $shiftRecord['irj'];
                                        $irjEligible = in_array($shift->id, [1, 2]) && $schedule['holidayMap'][$dateRecord['tanggal']->format('Y-m-d')];
                                    @endphp
                                    <td class="jadwal-shift-cell {{ $isVisible ? ($piket ? 'jadwal-assigned-cell' : 'jadwal-unassigned-cell') : 'jadwal-filtered-cell' }}">
                                        @if($isVisible)
                                        <div class="jadwal-shift-person {{ $piket ? 'jadwal-assigned-text' : 'jadwal-unassigned-text' }}">
                                            <i class="fas fa-{{ $piket ? 'user-check' : 'user-clock' }} me-1"></i>
                                            {{ $piket?->pengawas?->nama ?? 'Belum terisi' }}
                                        </div>
                                        <div class="jadwal-shift-time">{{ substr($shift->jam_masuk, 0, 5) }} - {{ substr($shift->jam_pulang, 0, 5) }}</div>
                                        <div class="jadwal-shift-meta">
                                            @if($piket)
                                            <span class="badge bg-success-subtle text-success">Terisi</span>
                                            @else
                                            <span class="badge bg-warning-subtle text-warning-emphasis">Belum</span>
                                            @endif
                                            @if($irj)
                                            <span class="badge bg-danger-subtle text-danger">IRJ</span>
                                            @endif
                                        </div>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    @endforeach
                                    <td class="text-center text-nowrap">
                                        <strong>{{ $dateRecord['assignedCount'] }}/{{ $dateRecord['totalCount'] }}</strong>
                                        <div class="small text-muted">terisi</div>
                                    </td>
                                    <td>
                                        <button type="button" wire:click="openDayModal('{{ $dateRecord['tanggal']->format('Y-m-d') }}')" class="btn btn-sm btn-outline-primary" title="Kelola jadwal tanggal ini"><i class="fas fa-edit"></i><span class="visually-hidden">Kelola jadwal tanggal ini</span></button>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="{{ $dinas->count() + 5 }}" class="text-center text-muted py-4">Tidak ada data sesuai filter.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @else
                    
                    <div wire:key="jadwal-calendar-view" class="calendar-wrapper">
                        <!-- Calendar Headers -->
                        <div class="calendar-grid-header">
                            <div class="calendar-day-header">Senin</div>
                            <div class="calendar-day-header">Selasa</div>
                            <div class="calendar-day-header">Rabu</div>
                            <div class="calendar-day-header">Kamis</div>
                            <div class="calendar-day-header">Jumat</div>
                            <div class="calendar-day-header text-danger">Sabtu</div>
                            <div class="calendar-day-header text-danger">Minggu</div>
                        </div>
                        
                        <!-- Calendar Body -->
                        <div class="calendar-grid-body">
                            @foreach($schedule['calendarPeriod'] as $tgl)
                            @php
                                $isCurrentMonth = $tgl->format('m') == $schedule['currentMonth'];
                                $isHoliday = $schedule['holidayMap'][$tgl->format('Y-m-d')];
                                $cellClass = $isCurrentMonth ? ($isHoliday ? 'current-month holiday' : 'current-month') : 'other-month';
                            @endphp
                            <div class="calendar-cell {{ $cellClass }}">
                                <div class="calendar-date {{ $isHoliday ? 'text-danger fw-bold' : 'fw-bold' }}">
                                    {{ $tgl->format('d') }}
                                </div>
                                
                                <div class="calendar-dinas-list">
                                    @if($isCurrentMonth)
                                        @foreach($dinas as $data)
                                        @php
                                            $key = $data->id . '_' . $tgl->format('Y-m-d');
                                            $piket = $schedule['piketMap']->get($key);
                                            $irj = $schedule['irjMap']->get($key);
                                            $pengawasNama = $piket ? ($schedule['userNames'][$piket->id_pengawas] ?? null) : null;
                                            $showIrj = $irj ? true : false;
                                            $irjEligible = in_array($data->id, [1, 2]) && $isHoliday;
                                            
                                            if($data->id == 1) $icon = 'morning.png';
                                            elseif($data->id == 2) $icon = 'ocean.png';
                                            else $icon = 'half-moon.png';
                                            
                                            $createAction = "prepareCreate({$data->id}, '{$tgl->format('Y-m-d')}', " . ($irjEligible ? 'true' : 'false') . ")";
                                            $editAction = $piket ? "prepareEdit({$piket->id}, {$data->id}, '{$tgl->format('Y-m-d')}', {$piket->id_pengawas}, " . ($irjEligible ? 'true' : 'false') . ", " . ($showIrj ? 'true' : 'false') . ")" : "";
                                        @endphp
                                        
                                        @if($piket)
                                        <div wire:click.prevent="{{ $editAction }}" class="dinas-item assigned" title="{{ strtoupper($data->dinas) }}">
                                            <div class="dinas-label">
                                                <img wire:loading.remove wire:target="{{ $editAction }}" src="{{ asset('sb-admin/icon/piket/'.$icon) }}">
                                                <i wire:loading wire:target="{{ $editAction }}" class="fas fa-spinner fa-spin text-primary" style="width: 16px; height: 16px; font-size: 14px;"></i>
                                                <span class="pengawas-nama text-primary">{{ $pengawasNama }}</span>
                                            </div>
                                            @if($showIrj)
                                            <span class="badge bg-danger ms-1" style="font-size:0.6rem">IRJ</span>
                                            @endif
                                        </div>
                                        @else
                                        <div wire:click.prevent="{{ $createAction }}" class="dinas-item unassigned" title="{{ strtoupper($data->dinas) }}">
                                            <div class="dinas-label">
                                                <img wire:loading.remove wire:target="{{ $createAction }}" src="{{ asset('sb-admin/icon/piket/'.$icon) }}">
                                                <i wire:loading wire:target="{{ $createAction }}" class="fas fa-spinner fa-spin text-muted" style="width: 16px; height: 16px; font-size: 14px;"></i>
                                                <span class="text-muted">
                                                    <span wire:loading.remove wire:target="{{ $createAction }}"><i class="fa fa-plus"></i> Isi</span>
                                                    <span wire:loading wire:target="{{ $createAction }}">Memuat...</span>
                                                </span>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </x-data-card>

    @if($schedule && $selectedDayDate)
    @php
        $selectedDayRecord = $schedule['listRecords']->first(fn ($record) => $record['tanggal']->format('Y-m-d') === $selectedDayDate);
    @endphp
    <div wire:ignore.self class="modal fade" id="jadwalDayModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="fas fa-calendar-day me-2 text-primary"></i>Jadwal Piket {{ \Carbon\Carbon::parse($selectedDayDate)->locale('id')->translatedFormat('l, d F Y') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="jadwal-day-grid">
                    @foreach($dinas as $shift)
                    @php
                        $shiftRecord = $selectedDayRecord['shifts']->get($shift->id);
                        $piket = $shiftRecord['piket'];
                        $irjEligible = in_array($shift->id, [1, 2]) && ($schedule['holidayMap'][$selectedDayDate] ?? false);
                        $editAction = $piket ? "prepareEdit({$piket->id}, {$shift->id}, '{$selectedDayDate}', {$piket->id_pengawas}, " . ($irjEligible ? 'true' : 'false') . ", " . ($shiftRecord['irj'] ? 'true' : 'false') . ")" : '';
                        $createAction = "prepareCreate({$shift->id}, '{$selectedDayDate}', " . ($irjEligible ? 'true' : 'false') . ")";
                    @endphp
                    <section class="jadwal-day-shift {{ $piket ? 'is-assigned' : 'is-unassigned' }}">
                        <div class="jadwal-day-shift-header">
                            <div><span class="jadwal-day-shift-name">{{ ucfirst($shift->dinas) }}</span><small>{{ substr($shift->jam_masuk, 0, 5) }} - {{ substr($shift->jam_pulang, 0, 5) }}</small></div>
                            @if($piket)
                            <span class="badge bg-success-subtle text-success">Terisi</span>
                            @else
                            <span class="badge bg-warning-subtle text-warning-emphasis">Belum</span>
                            @endif
                        </div>
                        <div class="jadwal-day-shift-person"><i class="fas fa-{{ $piket ? 'user-check' : 'user-clock' }} me-2"></i>{{ $piket?->pengawas?->nama ?? 'Belum terisi' }}</div>
                        @if($shiftRecord['irj'])<span class="badge bg-danger-subtle text-danger mt-2">IRJ Buka</span>@endif
                        <div class="jadwal-day-shift-actions">
                            @if($piket)
                            <button type="button" wire:click.prevent="{{ $editAction }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit me-1"></i>Edit</button>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="PUAlert.confirmAction('Hapus jadwal {{ ucfirst($shift->dinas) }} ini?', () => $wire.deletePiketById({{ $piket->id }}, {{ $shift->id }}, '{{ $selectedDayDate }}', {{ $piket->id_pengawas }}))"><i class="fas fa-trash-alt me-1"></i>Hapus</button>
                            @else
                            <button type="button" wire:click.prevent="{{ $createAction }}" class="btn btn-sm btn-outline-success"><i class="fas fa-plus me-1"></i>Isi Jadwal</button>
                            @endif
                        </div>
                    </section>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div wire:ignore.self class="modal fade" id="jadwalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-calendar-{{ $mode === 'create' ? 'plus' : 'check' }} me-2 text-{{ $mode === 'create' ? 'primary' : 'info' }}"></i>
                        {{ $mode === 'create' ? 'Tambah Jadwal Piket' : 'Ubah Jadwal Piket' }}
                        @if($selectedTanggal)
                        - {{ \Carbon\Carbon::parse($selectedTanggal)->locale('id')->translatedFormat('l, d F Y') }}
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="mb-3">
                        <label class="form-label">Pengawas Umum</label>
                        <div wire:ignore class="select2-wrapper">
                        <select id="jadwalPengawas" class="form-control select2 jadwal-select2" wire:model.live="selectedPengawas" data-livewire-property="selectedPengawas" style="width:100%" required>
                            <option value="">Pilih Pengawas Umum...</option>
                            @foreach($pengawas as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endforeach
                        </select>
                            </div>
                    </div>

                    @if($irjEligible)
                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" id="irjToggle" wire:model="selectedIrj">
                        <label class="form-check-label" for="irjToggle">Status IRJ Buka</label>
                    </div>
                    @endif
                </div>
                <div class="modal-footer justify-content-between">
                    @if($mode === 'edit')
                    <button type="button" wire:loading.attr="disabled" wire:target="deletePiket" onclick="PUAlert.confirmAction('Apakah Anda yakin ingin menghapus jadwal dinas ini?', () => $wire.deletePiket())" class="btn btn-danger">
                        <span wire:loading.remove wire:target="deletePiket"><i class="fas fa-trash-alt me-1"></i> Hapus Jadwal</span>
                        <span wire:loading wire:target="deletePiket"><i class="fas fa-spinner fa-spin me-1"></i> Menghapus...</span>
                    </button>
                    @endif
                    <div>

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" wire:click.prevent="savePiket" wire:loading.attr="disabled" wire:target="savePiket" class="btn btn-{{ $mode === 'create' ? 'primary' : 'info' }}">
                            <span wire:loading.remove wire:target="savePiket"><i class="fas fa-save me-1"></i> Simpan</span>
                            <span wire:loading wire:target="savePiket"><i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<style>
.jadwal-loading-overlay {
    position: fixed;
    inset: 0;
    z-index: 2000;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.62);
    backdrop-filter: blur(2px);
}
.jadwal-loading-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    min-width: 180px;
    padding: 22px 28px;
    border-radius: 8px;
    background: #fff;
    box-shadow: 0 8px 28px rgba(0, 0, 0, 0.16);
    font-weight: 600;
}
.select2-wrapper .select2-container { width: 100% !important; }
.select2-wrapper .select2-container .select2-selection--single {
    height: 38px;
    border: 1px solid #d1d3e2;
    border-radius: .35rem;
}
.select2-wrapper .select2-selection__rendered { line-height: 36px !important; }
.select2-wrapper .select2-selection__arrow { height: 36px !important; }
.select2-wrapper .select2-container--default.select2-container--focus .select2-selection--single {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.2);
}
.jadwal-view-switch {
    display: inline-flex;
    align-items: center;
    gap: 0.15rem;
    padding: 0.2rem;
    border: 1px solid #d7dfeb;
    border-radius: 0.55rem;
    background: #f4f7fb;
}
.jadwal-view-option {
    min-height: 34px;
    padding: 0.4rem 0.8rem;
    border: 0;
    border-radius: 0.4rem;
    background: transparent;
    color: #64748b;
    font-size: 0.78rem;
    font-weight: 600;
    line-height: 1.2;
    white-space: nowrap;
    transition: background-color 0.15s ease, color 0.15s ease, box-shadow 0.15s ease;
}
.jadwal-view-option:hover {
    color: #1d4ed8;
    background: #e8efff;
}
.jadwal-view-option.is-active {
    color: #fff;
    background: #1a3a8f;
    box-shadow: 0 2px 5px rgba(26, 58, 143, 0.2);
}
@media (max-width: 576px) {
    .jadwal-view-switch {
        width: 100%;
    }
    .jadwal-view-option {
        flex: 1;
    }
}
.jadwal-list-table {
    min-width: 980px;
    margin-bottom: 0;
}
.jadwal-list-table th,
.jadwal-list-table td {
    padding: 0.65rem 0.75rem;
    vertical-align: middle;
}
.jadwal-list-table thead th {
    white-space: nowrap;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.02em;
}
.jadwal-list-table > :not(caption) > * > .jadwal-shift-heading {
    min-width: 190px;
    background: #eef4ff;
    color: #23417a;
}
.jadwal-shift-cell {
    min-width: 190px;
    border-left: 3px solid transparent !important;
}
.jadwal-assigned-cell {
    background-color: #edf8f1 !important;
    border-left-color: #2f9e5b !important;
}
.jadwal-unassigned-cell {
    background-color: #fff8e6 !important;
    border-left-color: #e0a100 !important;
}
.jadwal-filtered-cell {
    background-color: #f8f9fb !important;
    text-align: center;
    border-left-color: #d6d9df !important;
}
.jadwal-list-table tbody tr:hover > .jadwal-assigned-cell {
    background-color: #dff3e6 !important;
}
.jadwal-list-table tbody tr:hover > .jadwal-unassigned-cell {
    background-color: #ffefc2 !important;
}
.jadwal-shift-person {
    font-size: 0.82rem;
    font-weight: 600;
    line-height: 1.25;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 190px;
}
.jadwal-assigned-text {
    color: #176b3a;
}
.jadwal-unassigned-text {
    color: #8a5a00;
}
.jadwal-shift-time {
    color: #6c757d;
    font-size: 0.72rem;
    margin-top: 0.2rem;
}
.jadwal-shift-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.25rem;
    margin-top: 0.3rem;
}
.jadwal-shift-meta .badge {
    font-size: 0.65rem;
    font-weight: 600;
}
.jadwal-list-table .badge {
    border: 1px solid transparent;
}
.jadwal-day-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 0.75rem;
}
.jadwal-day-shift {
    min-height: 170px;
    padding: 1rem;
    border: 1px solid #dce3ec;
    border-left: 4px solid transparent;
    border-radius: 0.5rem;
    background: #fff;
}
.jadwal-day-shift.is-assigned {
    background: #edf8f1;
    border-left-color: #2f9e5b;
}
.jadwal-day-shift.is-unassigned {
    background: #fff8e6;
    border-left-color: #e0a100;
}
.jadwal-day-shift-header,
.jadwal-day-shift-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
}
.jadwal-day-shift-header small {
    display: block;
    margin-top: 0.15rem;
    color: #64748b;
    font-size: 0.72rem;
}
.jadwal-day-shift-name {
    color: #1e293b;
    font-weight: 700;
}
.jadwal-day-shift-person {
    min-height: 48px;
    display: flex;
    align-items: center;
    color: #334155;
    font-size: 0.85rem;
    font-weight: 600;
}
.jadwal-day-shift-actions {
    justify-content: flex-start;
    margin-top: 1rem;
}
@media (max-width: 768px) {
    .jadwal-list-table {
        min-width: 900px;
    }
    .jadwal-day-grid {
        grid-template-columns: 1fr;
    }
}
.calendar-wrapper {
    border: 1px solid #e3e6f0;
    border-radius: 0.35rem;
    background: #e3e6f0; 
    overflow-x: auto;
}
.calendar-grid-header, .calendar-grid-body {
    display: grid;
    grid-template-columns: repeat(7, minmax(130px, 1fr));
    gap: 1px;
}
.calendar-day-header {
    background-color: midnightblue;
    color: white;
    text-align: center;
    padding: 10px;
    font-weight: bold;
    font-size: 0.9rem;
}
.calendar-cell {
    background-color: #fff;
    min-height: 120px;
    padding: 8px;
    display: flex;
    flex-direction: column;
}
.calendar-cell.other-month {
    background-color: #f8f9fc;
    color: #b7b9cc;
}
.calendar-cell.holiday {
    background-color: #fff5f5;
}
.calendar-date {
    text-align: right;
    margin-bottom: 8px;
}
.dinas-item {
    margin-bottom: 4px;
    border: 1px solid #eaecf4;
    border-radius: 4px;
    padding: 4px 6px;
    font-size: 0.75rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    transition: all 0.2s;
    background: #fff;
}
.dinas-item:hover {
    background-color: #f8f9fc;
    border-color: #d1d3e2;
}
.dinas-item.assigned {
    background-color: #e8f4f8;
    border-color: #b8daff;
}
.dinas-label {
    display: flex;
    align-items: center;
    gap: 6px;
    overflow: hidden;
}
.dinas-label img {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
}
.pengawas-nama {
    font-weight: bold;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 90px;
}
@media (max-width: 1200px) {
    .pengawas-nama { max-width: 60px; }
}
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    (function () {
        function initJadwalSelect2() {
            if (!window.jQuery) return;

            $('.jadwal-select2').each(function () {
                const $select = $(this);
                if (window.jQuery.fn.select2 && !$select.hasClass('select2-hidden-accessible')) {
                    $select.select2({
                        width: '100%',
                        dropdownParent: $select.closest('.modal').length ? $select.closest('.modal') : $(document.body)
                    });
                }

                if ($select.data('jadwal-bound')) return;

                $select.on('change.jadwal', function () {
                    const property = this.dataset.livewireProperty;
                    const root = this.closest('[wire\\:id]');
                    if (property && root && window.Livewire) {
                        const component = Livewire.find(root.getAttribute('wire:id'));
                        if (component) component.set(property, this.value);
                    }
                });
                $select.data('jadwal-bound', true);
            });
        }

        function syncJadwalSelect(id, value) {
            const select = document.getElementById(id);
            if (select && window.jQuery) $(select).val(value ?? '').trigger('change.select2');
        }

        document.addEventListener('livewire:init', function () {
            initJadwalSelect2();
            Livewire.on('show-jadwal-modal', function (event) {
                syncJadwalSelect('jadwalPengawas', event.pengawas ?? event.detail?.pengawas);
            });

            Livewire.hook('morphed', function () {
                initJadwalSelect2();
            });
        });

        document.addEventListener('livewire:navigated', initJadwalSelect2);
        document.addEventListener('DOMContentLoaded', initJadwalSelect2);
    })();

    function showJadwalFormModal() {
        const modalElement = document.getElementById('jadwalModal');
        if (modalElement && window.bootstrap) {
            bootstrap.Modal.getOrCreateInstance(modalElement).show();
        }
    }

    window.addEventListener('show-jadwal-modal', () => {
        const dayModalElement = document.getElementById('jadwalDayModal');
        const dayModal = dayModalElement && window.bootstrap
            ? bootstrap.Modal.getInstance(dayModalElement)
            : null;

        if (dayModalElement && dayModal && dayModalElement.classList.contains('show')) {
            dayModalElement.addEventListener('hidden.bs.modal', showJadwalFormModal, { once: true });
            dayModal.hide();
            return;
        }

        showJadwalFormModal();
    });

    window.addEventListener('show-jadwal-day-modal', () => {
        const modalElement = document.getElementById('jadwalDayModal');
        if (modalElement && window.bootstrap) {
            bootstrap.Modal.getOrCreateInstance(modalElement).show();
        }
    });

    window.addEventListener('hide-jadwal-day-modal', () => {
        const modalElement = document.getElementById('jadwalDayModal');
        if (modalElement && window.bootstrap) {
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) modal.hide();
        }
    });

    window.addEventListener('hide-jadwal-modal', () => {
        const modalElement = document.getElementById('jadwalModal');
        if (modalElement && window.bootstrap) {
            let modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide();
            }
        }
    });
</script>

</div>