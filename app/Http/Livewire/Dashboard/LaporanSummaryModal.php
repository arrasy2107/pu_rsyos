<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Laporan;
use Livewire\Component;
use Livewire\Attributes\On;

class LaporanSummaryModal extends Component
{
    public $idlaporan = null;
    public $laporan = null;

    #[On('openLaporanSummary')]
    public function open($idlaporan = null): void
    {
        $this->idlaporan = $idlaporan;
        $this->laporan = $idlaporan
            ? Laporan::with(['dinas', 'pengawas'])->find($idlaporan)
            : null;
    }

    public function render()
    {
        return view('livewire.dashboard.laporan-summary-modal');
    }
}
