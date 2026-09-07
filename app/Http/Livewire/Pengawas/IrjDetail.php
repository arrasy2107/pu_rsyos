<?php

namespace App\Http\Livewire\Pengawas;

use App\Models\Laporanirjdetail;
use Livewire\Component;

class IrjDetail extends Component
{
    protected $listeners = ['refreshIrjDetail' => '$refresh'];

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
