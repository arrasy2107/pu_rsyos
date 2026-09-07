<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Dinas;
use App\Models\Irjbuka;
use App\Models\Log;
use App\Models\Piket;
use App\Models\User;

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

    protected $rules = [
        'selectedPengawas' => 'required|exists:users,id',
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
            $piketRecords = Piket::whereBetween('tanggal', [$from->format('Y-m-d'), $to->format('Y-m-d')])->get();
            $irjRecords = Irjbuka::whereBetween('tanggal', [$from->format('Y-m-d'), $to->format('Y-m-d')])->get();
            $piketMap = $piketRecords->keyBy(fn($item) => $item->id_dinas . '_' . $item->tanggal);
            $irjMap = $irjRecords->keyBy(fn($item) => $item->id_dinas . '_' . $item->tanggal);
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
        if (!$this->tahun || !$this->bulan) {
            $this->dispatch('pu-alert', ['icon' => 'warning', 'message' => 'Lengkapi pilihan tahun dan bulan terlebih dahulu.']);
            return;
        }

        $this->readyToLoad = true;
    }

    public function prepareCreate($dinasId, $tanggal, $irjEligible)
    {
        $this->mode = 'create';
        $this->selectedPiketId = null;
        $this->selectedDinas = $dinasId;
        $this->selectedTanggal = $tanggal;
        $this->selectedPengawas = null;
        $this->selectedIrj = false;
        $this->irjEligible = $irjEligible;
        $this->dispatch('show-jadwal-modal');
    }

    public function prepareEdit($piketId, $dinasId, $tanggal, $pengawasId, $irjEligible, $irj)
    {
        $this->mode = 'edit';
        $this->selectedPiketId = $piketId;
        $this->selectedDinas = $dinasId;
        $this->selectedTanggal = $tanggal;
        $this->selectedPengawas = $pengawasId;
        $this->selectedIrj = $irj;
        $this->irjEligible = $irjEligible;
        $this->dispatch('show-jadwal-modal');
    }

    public function savePiket()
    {
        $this->validate();

        if ($this->mode === 'create') {
            $piket = new Piket();
            $piket->id_pengawas = $this->selectedPengawas;
            $piket->id_dinas = $this->selectedDinas;
            $piket->tanggal = $this->selectedTanggal;
            $piket->save();

            if ($this->irjEligible && $this->selectedIrj) {
                Irjbuka::firstOrCreate([
                    'id_dinas' => $this->selectedDinas,
                    'tanggal' => $this->selectedTanggal,
                ]);
            }

            $this->writeLog('Tambah Jadwal Piket');
            $message = 'Berhasil menambah data jadwal';
        } else {
            $piket = Piket::find($this->selectedPiketId);
            if (!$piket) {
                $this->dispatch('pu-alert', ['icon' => 'error', 'message' => 'Data jadwal tidak ditemukan.']);
                return;
            }

            $piket->id_pengawas = $this->selectedPengawas;
            $piket->id_dinas = $this->selectedDinas;
            $piket->tanggal = $this->selectedTanggal;
            $piket->save();

            if ($this->irjEligible && $this->selectedIrj) {
                Irjbuka::firstOrCreate([
                    'id_dinas' => $this->selectedDinas,
                    'tanggal' => $this->selectedTanggal,
                ]);
            } else {
                Irjbuka::where('id_dinas', $this->selectedDinas)
                    ->where('tanggal', $this->selectedTanggal)
                    ->delete();
            }

            $this->writeLog('Edit Jadwal Piket');
            $message = 'Berhasil mengubah data jadwal';
        }

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
        $this->dispatch('hide-jadwal-modal');
        $this->dispatch('pu-alert', ['icon' => 'success', 'message' => 'Berhasil menghapus data jadwal']);
    }

    protected function writeLog($action)
    {
        $userName = User::where('id', $this->selectedPengawas)->value('nama');
        $dinasName = Dinas::where('id', $this->selectedDinas)->value('dinas');

        $log = new Log();
        $log->id_user = auth()->id();
        $log->id_log_jenis = 6;
        $log->keterangan = sprintf('%s : %s (Dinas : %s, Tanggal : %s)', $action, $userName, $dinasName, $this->selectedTanggal);
        $log->created_at = now();
        $log->updated_at = now();
        $log->save();
    }
}
