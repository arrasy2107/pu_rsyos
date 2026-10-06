<?php

namespace App\Http\Livewire\Pengawas;

use App\Models\Laporanumum;
use Livewire\Component;
use Livewire\Attributes\On;

class RuanganLaporan extends Component
{
    public $ruangan = null;

    public function mount($ruangan = null)
    {
        $this->ruangan = $ruangan;
    }

    #[On('setRuangan')]
    public function setRuangan($ruangan)
    {
        if (is_array($ruangan) && array_key_exists('value', $ruangan)) {
            $ruangan = $ruangan['value'];
        }

        $this->ruangan = $ruangan ?: null;
    }

    public function updatedRuangan($value)
    {
        $this->ruangan = $value ?: null;
    }

    public function render()
    {
        return view('livewire.pengawas.ruangan-laporan', [
            'ruangan' => $this->ruangan,
            'pasienLama' => $this->ruangan
                ? Laporanumum::saldoPasienLama((int) $this->ruangan)
                : 0,
        ]);
    }
}
