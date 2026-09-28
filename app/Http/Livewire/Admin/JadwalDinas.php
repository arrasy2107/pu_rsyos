<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Dinas;
use App\Models\Irjbuka;
use App\Models\Log;
use App\Models\Piket;
use App\Models\User;
use App\Exports\JadwalDinasExport;

class JadwalDinas extends Component
{
    public $tahun;
    public $bulan;
    public $selectedDinas;
    public $selectedTanggal;
    public $selectedPiketId;
    public $selectedPengawas;
    public $selectedIrj = false;
    public $mode = 'create';
    public $readyToLoad = false;
    public $irjEligible = false;
    public $viewMode = 'calendar';
    public $filterPengawas = '';
    public $filterStatus = 'all';
    public $selectedDayDate;

    protected $rules = [
        'tahun' => 'required|integer|min:2000|max:2100',
        'bulan' => 'required|date_format:m',
        'selectedDinas' => 'required|exists:dinas,id',
        'selectedTanggal' => 'required|date_format:Y-m-d',
        'selectedPengawas' => 'required|exists:users,id',
        'selectedIrj' => 'boolean',
    ];

    public function mount()
    {
        Carbon::setLocale('id');
    }

    public function getYearsProperty()
    {
        $currentYear = now()->year;
        return range($currentYear, $currentYear + 5);
    }

    public function getMonthOptionsProperty()
    {
        return [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];
    }

    public function render()
    {
        $dinas = Dinas::orderBy('id')->get();
        $pengawas = User::where('id_role', 2)->where('status', 1)->get();
        $schedule = null;

        if ($this->readyToLoad && $this->tahun && $this->bulan) {
            $from = Carbon::createFromFormat('Y-m-d', "$this->tahun-$this->bulan-01");
            $to = $from->copy()->endOfMonth();
            
            // Calculate grid range for the calendar (start on Monday, end on Sunday)
            $startGrid = $from->copy()->startOfWeek(Carbon::MONDAY);
            $endGrid = $to->copy()->endOfWeek(Carbon::SUNDAY);
            
            $calendarPeriod = new CarbonPeriod($startGrid, '1 day', $endGrid);

            // Fetch records for the selected month
            $piketRecords = Piket::with(['pengawas', 'dinas'])
                ->whereBetween('tanggal', [$from->format('Y-m-d'), $to->format('Y-m-d')])
                ->get();
            $irjRecords = Irjbuka::whereBetween('tanggal', [$from->format('Y-m-d'), $to->format('Y-m-d')])->get();
            $piketMap = $piketRecords->keyBy(fn($item) => $this->scheduleKey($item->id_dinas, $item->tanggal));
            $irjMap = $irjRecords->keyBy(fn($item) => $this->scheduleKey($item->id_dinas, $item->tanggal));
            $userNames = User::whereIn('id', $piketRecords->pluck('id_pengawas')->unique())->pluck('nama', 'id')->toArray();

            $t = new \Grei\TanggalMerah();
            $holidayMap = [];
            foreach ($calendarPeriod as $date) {
                $t->set_date($date->format('Ymd'));
                $holidayMap[$date->format('Y-m-d')] = $t->is_holiday();
            }

            $schedule = [
                'monthName' => $from->isoFormat('MMMM'),
                'currentMonth' => $from->format('m'),
                'calendarPeriod' => $calendarPeriod,
                'holidayMap' => $holidayMap,
                'piketMap' => $piketMap,
                'irjMap' => $irjMap,
                'userNames' => $userNames,
                'listRecords' => $this->buildListRecords($from, $to, $dinas, $piketMap, $irjMap),
            ];
        }

        return view('livewire.admin.jadwal-dinas', [
            'years' => $this->years,
            'months' => $this->monthOptions,
            'dinas' => $dinas,
            'pengawas' => $pengawas,
            'schedule' => $schedule,
        ]);
    }

    public function validateYearMonth()
    {
        $this->validateOnly('tahun');
        $this->validateOnly('bulan');
    }

    public function lihatJadwal()
    {
        if (!$this->validateYearMonthState()) {
            $this->dispatch('pu-alert', ['icon' => 'warning', 'message' => 'Lengkapi pilihan tahun dan bulan terlebih dahulu.']);
            return;
        }

        $this->readyToLoad = true;
    }

    public function updatedViewMode($value)
    {
        if (!in_array($value, ['calendar', 'list'], true)) {
            $this->viewMode = 'calendar';
        }
    }

    public function exportExcel()
    {
        if (!$this->validateYearMonthState()) {
            $this->dispatch('pu-alert', ['icon' => 'warning', 'message' => 'Pilih tahun dan bulan terlebih dahulu.']);
            return;
        }

        return Excel::download(
            new JadwalDinasExport((int) $this->tahun, (int) $this->bulan, (string) $this->filterPengawas, (string) $this->filterStatus),
            sprintf('jadwal-dinas-%s-%s.xlsx', $this->tahun, $this->bulan)
        );
    }

    protected function validateYearMonthState(): bool
    {
        try {
            $this->validateOnly('tahun');
            $this->validateOnly('bulan');
        } catch (\Illuminate\Validation\ValidationException) {
            return false;
        }

        return true;
    }

    public function prepareCreate($dinasId, $tanggal, $irjEligible)
    {
        $this->dispatch('hide-jadwal-day-modal');
        $this->mode = 'create';
        $this->selectedPiketId = null;
        $this->selectedDinas = $dinasId;
        $this->selectedTanggal = $tanggal;
        $this->selectedPengawas = null;
        $this->selectedIrj = false;
        $this->irjEligible = $irjEligible;
        $this->dispatch('show-jadwal-modal', pengawas: $this->selectedPengawas);
    }

    public function prepareEdit($piketId, $dinasId, $tanggal, $pengawasId, $irjEligible, $irj)
    {
        $this->dispatch('hide-jadwal-day-modal');
        $this->mode = 'edit';
        $this->selectedPiketId = $piketId;
        $this->selectedDinas = $dinasId;
        $this->selectedTanggal = $tanggal;
        $this->selectedPengawas = $pengawasId;
        $this->selectedIrj = $irj;
        $this->irjEligible = $irjEligible;
        $this->dispatch('show-jadwal-modal', pengawas: $this->selectedPengawas);
    }

    public function openDayModal($tanggal)
    {
        $this->selectedDayDate = Carbon::parse($tanggal)->format('Y-m-d');
        $this->dispatch('show-jadwal-day-modal');
    }

    public function deletePiketById($piketId, $dinasId, $tanggal, $pengawasId)
    {
        $this->selectedPiketId = $piketId;
        $this->selectedDinas = $dinasId;
        $this->selectedTanggal = $tanggal;
        $this->selectedPengawas = $pengawasId;
        $this->deletePiket();
    }

    public function savePiket()
    {
        $this->validate();

        $piket = $this->mode === 'edit' ? Piket::find($this->selectedPiketId) : new Piket();
        if ($this->mode === 'edit' && !$piket) {
            $this->dispatch('pu-alert', ['icon' => 'error', 'message' => 'Data jadwal tidak ditemukan.']);
            return;
        }

        $duplicate = Piket::where('id_dinas', $this->selectedDinas)
            ->whereDate('tanggal', $this->selectedTanggal)
            ->when($this->mode === 'edit', fn ($query) => $query->where('id', '!=', $this->selectedPiketId))
            ->exists();
        if ($duplicate) {
            $this->dispatch('pu-alert', ['icon' => 'warning', 'message' => 'Jadwal untuk shift dan tanggal tersebut sudah tersedia.']);
            return;
        }

        $oldDinas = $piket->id_dinas;
        $oldTanggal = $piket->getRawOriginal('tanggal');

        DB::transaction(function () use ($piket, $oldDinas, $oldTanggal) {
            $piket->fill([
                'id_pengawas' => $this->selectedPengawas,
                'id_dinas' => $this->selectedDinas,
                'tanggal' => $this->selectedTanggal,
            ]);
            $piket->save();

            if ($this->mode === 'edit' && ($oldDinas != $this->selectedDinas || $oldTanggal != $this->selectedTanggal)) {
                Irjbuka::where('id_dinas', $oldDinas)->where('tanggal', $oldTanggal)->delete();
            }

            $irjQuery = Irjbuka::where('id_dinas', $this->selectedDinas)
                ->where('tanggal', $this->selectedTanggal);
            if ($this->irjEligible && $this->selectedIrj) {
                Irjbuka::firstOrCreate([
                    'id_dinas' => $this->selectedDinas,
                    'tanggal' => $this->selectedTanggal,
                ]);
            } else {
                $irjQuery->delete();
            }
        });

        $this->writeLog($this->mode === 'create' ? 'Tambah Jadwal Piket' : 'Edit Jadwal Piket');
        $message = $this->mode === 'create' ? 'Berhasil menambah data jadwal' : 'Berhasil mengubah data jadwal';

        $this->dispatch('hide-jadwal-modal');
        $this->dispatch('pu-alert', ['icon' => 'success', 'message' => $message]);
    }

    public function deletePiket()
    {
        $piket = Piket::find($this->selectedPiketId);
        if (!$piket) {
            $this->dispatch('pu-alert', ['icon' => 'error', 'message' => 'Data jadwal tidak ditemukan.']);
            return;
        }

        Irjbuka::where('id_dinas', $piket->id_dinas)
            ->where('tanggal', $piket->tanggal)
            ->delete();

        $piket->delete();

        $this->writeLog('Hapus Jadwal Piket');
        $this->dispatch('hide-jadwal-day-modal');
        $this->dispatch('hide-jadwal-modal');
        $this->dispatch('pu-alert', ['icon' => 'success', 'message' => 'Berhasil menghapus data jadwal']);
    }

    protected function writeLog($action)
    {
        $userName = User::where('id', $this->selectedPengawas)->value('nama');
        $dinasName = Dinas::where('id', $this->selectedDinas)->value('dinas');

        $log = new Log();
        $log->id_user = Auth::id();
        $log->id_log_jenis = 6;
        $log->keterangan = sprintf('%s : %s (Dinas : %s, Tanggal : %s)', $action, $userName, $dinasName, $this->selectedTanggal);
        $log->created_at = now();
        $log->updated_at = now();
        $log->save();
    }

    protected function buildListRecords($from, $to, $dinas, $piketMap, $irjMap)
    {
        $records = collect();

        foreach (CarbonPeriod::create($from, $to) as $date) {
            $dateRecords = collect();

            foreach ($dinas as $shift) {
                $key = $shift->id . '_' . $date->format('Y-m-d');
                $piket = $piketMap->get($key);
                $irj = $irjMap->get($key);

                $matchesFilter = (!$this->filterPengawas || ($piket && (string) $piket->id_pengawas === (string) $this->filterPengawas))
                    && ($this->filterStatus === 'all'
                        || ($this->filterStatus === 'assigned' && $piket)
                        || ($this->filterStatus === 'unassigned' && !$piket));

                $dateRecords->put($shift->id, [
                    'piket' => $piket,
                    'dinas' => $shift,
                    'irj' => (bool) $irj,
                    'matchesFilter' => $matchesFilter,
                ]);
            }

            if ($dateRecords->contains(fn ($record) => $record['matchesFilter'])) {
                $records->push([
                    'tanggal' => $date->copy(),
                    'shifts' => $dateRecords,
                    'assignedCount' => $dateRecords->whereNotNull('piket')->count(),
                    'totalCount' => $dateRecords->count(),
                ]);
            }
        }

        return $records;
    }

    protected function scheduleKey($dinasId, $tanggal)
    {
        return $dinasId . '_' . Carbon::parse($tanggal)->format('Y-m-d');
    }
}
