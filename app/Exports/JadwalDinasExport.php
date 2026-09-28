<?php

namespace App\Exports;

use App\Models\Dinas;
use App\Models\Irjbuka;
use App\Models\Piket;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Maatwebsite\Excel\Concerns\Export;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class JadwalDinasExport implements Export, WithMultipleSheets
{
    public function __construct(
        protected int $year,
        protected int $month,
        protected string $filterPengawas = '',
        protected string $filterStatus = 'all'
    ) {
    }

    public function sheets(): array
    {
        $from = Carbon::create($this->year, $this->month, 1)->startOfDay();
        $to = $from->copy()->endOfMonth()->endOfDay();
        $shifts = Dinas::orderBy('id')->get();
        $piket = Piket::with('pengawas')
            ->whereBetween('tanggal', [$from->toDateString(), $to->toDateString()])
            ->get()
            ->keyBy(fn ($item) => $item->id_dinas . '_' . $item->tanggal->format('Y-m-d'));
        $irj = Irjbuka::whereBetween('tanggal', [$from->toDateString(), $to->toDateString()])
            ->get()
            ->keyBy(fn ($item) => $item->id_dinas . '_' . Carbon::parse($item->tanggal)->format('Y-m-d'));

        $rows = collect();
        foreach (CarbonPeriod::create($from, $to) as $date) {
            foreach ($shifts as $shift) {
                $key = $shift->id . '_' . $date->toDateString();
                $record = $piket->get($key);
                if ($this->filterPengawas && (!$record || (string) $record->id_pengawas !== $this->filterPengawas)) {
                    continue;
                }
                if ($this->filterStatus === 'assigned' && !$record) {
                    continue;
                }
                if ($this->filterStatus === 'unassigned' && $record) {
                    continue;
                }
                $rows->push([
                    'tanggal' => $date->toDateString(),
                    'hari' => $date->locale('id')->translatedFormat('l'),
                    'shift' => ucfirst($shift->dinas),
                    'jam_masuk' => $shift->jam_masuk,
                    'jam_pulang' => $shift->jam_pulang,
                    'pengawas' => $record?->pengawas?->nama ?? '',
                    'nip' => $record?->pengawas?->nip ?? '',
                    'status_irj' => $irj->has($key) ? 'Buka' : 'Normal',
                    'status_jadwal' => $record ? 'Terisi' : 'Belum terisi',
                ]);
            }
        }

        return [
            new JadwalDetailSheet($rows, $from),
            new JadwalMatriksSheet($rows, $shifts, $from),
            new JadwalRekapSheet($rows, $from),
        ];
    }
}