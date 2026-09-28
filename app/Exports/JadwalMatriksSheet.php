<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class JadwalMatriksSheet implements FromCollection, ShouldAutoSize, WithHeadings, WithTitle
{
    public function __construct(
        protected Collection $rows,
        protected Collection $shifts,
        protected Carbon $month
    ) {
    }

    public function collection(): Collection
    {
        return $this->rows->groupBy('tanggal')->map(function ($dateRows, $date) {
            $result = [$date, Carbon::parse($date)->locale('id')->translatedFormat('l')];
            foreach ($this->shifts as $shift) {
                $row = $dateRows->firstWhere('shift', ucfirst($shift->dinas));
                $result[] = $row['pengawas'] ?? '';
            }
            return $result;
        })->values();
    }

    public function headings(): array
    {
        return array_merge(['Tanggal', 'Hari'], $this->shifts->pluck('dinas')->map(fn ($name) => ucfirst($name))->all());
    }

    public function title(): string
    {
        return 'Matriks Jadwal';
    }
}