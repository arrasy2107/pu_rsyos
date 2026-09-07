<?php

namespace App\Http\Livewire\Pengawas;

use App\Models\Catatanpasien;
use Livewire\Component;

class CatatanPasienIstimewa extends Component
{
    public $ruangan;

    protected $listeners = ['refreshCatatanIstimewa' => '$refresh'];

    public function mount($ruangan = null)
    {
        $this->ruangan = $ruangan;
    }

    public function render()
    {
        $items = Catatanpasien::where('status', 0)
            ->where('id_ruangan', $this->ruangan)
            ->where('id_jenis_pasien', 1)
            ->where('id_pengawas', auth()->id())
            ->get();

        return view('livewire.pengawas.catatan-pasien-istimewa', [
            'items' => $items,
        ]);
    }
}
