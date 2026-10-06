<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Catatanpasien;

class CatatanPasienBaruModal extends Component
{
    public $idlaporan = null;
    public $idruangan = null;
    public $items = [];

    #[On('openBaruModal')]
    public function open($idlaporan = null, $idruangan = null)
    {
        $this->idlaporan = $idlaporan;
        $this->idruangan = $idruangan;
        $this->loadItems();
    }

    protected function loadItems()
    {
        if (!$this->idlaporan || !$this->idruangan) {
            $this->items = [];
            return;
        }

        $this->items = Catatanpasien::where('id_laporan_umum', $this->idlaporan)
            ->where('id_ruangan', $this->idruangan)
            ->where('id_jenis_pasien', 2)
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard.catatan-pasien-baru-modal');
    }
}
