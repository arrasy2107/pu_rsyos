<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Catatanpasien;

class CatatanPasienModal extends Component
{
    public $type = null; // 'istimewa'|'baru'|'permasalahan'
    public $idlaporan = null;
    public $idruangan = null;
    public $items = [];

    protected $listeners = ['openCatatanModal' => 'open'];

    public function open($payload)
    {
        $this->type = $payload['type'] ?? null;
        $this->idlaporan = $payload['idlaporan'] ?? null;
        $this->idruangan = $payload['idruangan'] ?? null;
        $this->loadItems();
    }

    protected function loadItems()
    {
        if (!$this->idlaporan || !$this->idruangan) {
            $this->items = [];
            return;
        }

        if ($this->type === 'istimewa') {
            $this->items = Catatanpasien::where('id_laporan_umum', $this->idlaporan)
                ->where('id_ruangan', $this->idruangan)
                ->where('id_jenis_pasien', 1)
                ->get();
        } elseif ($this->type === 'baru') {
            $this->items = Catatanpasien::where('id_laporan_umum', $this->idlaporan)
                ->where('id_ruangan', $this->idruangan)
                ->where('id_jenis_pasien', 2)
                ->get();
        } elseif ($this->type === 'permasalahan') {
            // permasalahan is stored on Laporanumum->permasalahan_umum but existing ajax returned a list; we'll load related notes if any
            $this->items = Catatanpasien::where('id_laporan_umum', $this->idlaporan)
                ->where('id_ruangan', $this->idruangan)
                ->get();
        } else {
            $this->items = [];
        }
    }

    public function render()
    {
        return view('livewire.dashboard.catatan-pasien-modal');
    }
}
