<?php

namespace App\Http\Livewire\Pengawas;

use App\Models\Laporanibsdetail;
use Livewire\Component;

class IbsDetail extends Component
{
    protected $listeners = ['refreshIbsDetail' => '$refresh'];

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
