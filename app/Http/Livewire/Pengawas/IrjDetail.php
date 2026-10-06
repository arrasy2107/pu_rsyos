<?php

namespace App\Http\Livewire\Pengawas;

use App\Models\Laporanirjdetail;
use Livewire\Component;
use Livewire\Attributes\On;

class IrjDetail extends Component
{
    #[On('refreshIrjDetail')]
    public function refresh(): void
    {
        // Livewire v4: re-render is triggered automatically after this method runs
    }

    public function render()
    {
        $items = Laporanirjdetail::with(['dokter'])
            ->where('status', 0)
            ->where('id_pengawas', auth()->id())
            ->get();

        return view('livewire.pengawas.irj-detail', [
            'items' => $items,
        ]);
    }
}
