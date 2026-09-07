<div>
    <x-data-card>
        <div class="row align-items-end mb-4">
            <div class="col-md-3 mb-3 mb-md-0">
                <div class="mb-0">
                    <label class="fw-bold text-gray-700 form-label">Tahun</label>
                    <select wire:model="tahun" class="form-select" style="height: 42px;">
                        <option value="">Pilih Tahun</option>
                        @foreach($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3 mb-3 mb-md-0">
                <div class="mb-0">
                    <label class="fw-bold text-gray-700 form-label">Bulan</label>
                    <select wire:model="bulan" class="form-select" style="height: 42px;">
                        <option value="">Pilih Bulan</option>
                        @foreach($months as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <button wire:click="lihatJadwal" wire:loading.attr="disabled" wire:target="lihatJadwal" class="btn btn-primary w-100" style="height: 42px;" type="button">
                    <span wire:loading.remove wire:target="lihatJadwal">
                        <i class="fas fa-search me-2"></i> Lihat Jadwal
                    </span>
                    <span wire:loading wire:target="lihatJadwal">
                        <i class="fas fa-spinner fa-spin me-2"></i> Memuat...
                    </span>
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
                    <h3 class="mb-4">{{ $schedule['monthName'] }} {{ $tahun }}</h3>
                    
                    <div class="calendar-wrapper">
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
                </div>
                @endif
            </div>
        </div>
    </x-data-card>

    <div wire:ignore.self class="modal fade" id="jadwalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-calendar-{{ $mode === 'create' ? 'plus' : 'check' }} me-2 text-{{ $mode === 'create' ? 'primary' : 'info' }}"></i>
                        {{ $mode === 'create' ? 'Pilih Jadwal Piket' : 'Ubah Jadwal Piket' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="mb-3">
                        <label class="form-label">Pengawas Umum</label>
                        <select wire:model="selectedPengawas" class="form-select" style="width:100%" required>
                            <option value="">Pilih Pengawas Umum...</option>
                            @foreach($pengawas as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endforeach
                        </select>
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
                    <button type="button" onclick="PUAlert.confirmAction('Apakah Anda yakin ingin menghapus jadwal dinas ini?', () => $wire.deletePiket())" class="btn btn-danger"><i class="fas fa-trash-alt me-1"></i> Hapus Jadwal</button>
                    @endif
                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" wire:click.prevent="savePiket" class="btn btn-{{ $mode === 'create' ? 'primary' : 'info' }}"><i class="fas fa-save me-1"></i> Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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

<script>
    window.addEventListener('show-jadwal-modal', () => {
        const modalElement = document.getElementById('jadwalModal');
        if (modalElement && window.bootstrap) {
            let modal = bootstrap.Modal.getOrCreateInstance(modalElement);
            modal.show();
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