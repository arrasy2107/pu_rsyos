<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class JadwalRekapSheet implements FromCollection, ShouldAutoSize, WithHeadings, WithTitle
{
    public function __construct(protected Collection $rows, protected Carbon $month)
    {
    }

    public function collection(): Collection
    {
        return $this->rows->filter(fn ($row) => $row['pengawas'] !== '')
            ->groupBy('pengawas')
            ->map(function ($personRows, $name) {
                return [
                    $name,
                    $personRows->where('shift', 'Pagi')->count(),
                    $personRows->where('shift', 'Sore')->count(),
                    $personRows->where('shift', 'Malam')->count(),
                    $personRows->count(),
                    $personRows->where('status_irj', 'Buka')->count(),
                ];
            })->values();
    }

    public function headings(): array
    {
        return ['Pengawas', 'Pagi', 'Sore', 'Malam', 'Total', 'Hari IRJ'];
    }

    public function title(): string
    {
        return 'Rekap Pengawas';
    }
}