<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Laporan;
use App\Models\Laporanumum;

class RuanganReport extends Component
{
    public $ruangan = null;

    protected $listeners = ['ruanganChanged' => 'setRuangan'];

    public function mount($ruangan = null)
    {
        $this->ruangan = $ruangan;
    }

    public function setRuangan($id = null)
    {
        $this->ruangan = $id;
    }

    public function render()
    {
        $lastIDLaporan = Laporan::latest('id')->value('id');

        $data = null;
        if ($this->ruangan && $lastIDLaporan) {
            $data = Laporanumum::where('id_laporan', $lastIDLaporan)
                ->where('id_ruangan', $this->ruangan)
                ->first();
        }

        return view('livewire.dashboard.ruangan-report', [
            'data' => $data,
            'lastIDLaporan' => $lastIDLaporan,
        ]);
    }
}
