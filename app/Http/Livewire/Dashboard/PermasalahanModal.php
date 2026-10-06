<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Catatanpasien;

class PermasalahanModal extends Component
{
    public $idlaporan = null;
    public $idruangan = null;
    public $items = [];

    #[On('openPermasalahanModal')]
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
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard.permasalahan-modal');
    }
}
