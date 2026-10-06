<?php

namespace App\Http\Livewire\Pengawas;

use App\Models\Laporanibsdetail;
use Livewire\Component;
use Livewire\Attributes\On;

class IbsDetail extends Component
{
    #[On('refreshIbsDetail')]
    public function refresh(): void
    {
        // Livewire v4: re-render is triggered automatically after this method runs
    }

    public function render()
    {
        $items = Laporanibsdetail::with(['dokterAnestesi', 'ruangan'])
            ->where('status', 0)
            ->where('id_pengawas', auth()->id())
            ->get();

        return view('livewire.pengawas.ibs-detail', [
            'items' => $items,
        ]);
    }
}
