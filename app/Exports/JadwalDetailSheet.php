<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class JadwalDetailSheet implements FromCollection, ShouldAutoSize, WithHeadings, WithTitle
{
    public function __construct(protected Collection $rows, protected Carbon $month)
    {
    }

    public function collection(): Collection
    {
        return $this->rows->map(fn ($row) => array_values($row));
    }

    public function headings(): array
    {
        return ['Tanggal', 'Hari', 'Shift', 'Jam Masuk', 'Jam Pulang', 'Pengawas', 'NIP', 'Status IRJ', 'Status Jadwal'];
    }

    public function title(): string
    {
        return 'Jadwal Detail';
    }
}