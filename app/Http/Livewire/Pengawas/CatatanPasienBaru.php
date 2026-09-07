<?php

namespace App\Http\Livewire\Pengawas;

use App\Models\Catatanpasien;
use Livewire\Component;

class CatatanPasienBaru extends Component
{
    public $ruangan;

    protected $listeners = ['refreshCatatanBaru' => '$refresh'];

    public function mount($ruangan = null)
    {
        $this->ruangan = $ruangan;
    }

    public function render()
    {
        $items = Catatanpasien::where('status', 0)
            ->where('id_ruangan', $this->ruangan)
            ->where('id_jenis_pasien', 2)
            ->where('id_pengawas', auth()->id())
            ->get();

        return view('livewire.pengawas.catatan-pasien-baru', [
            'items' => $items,
        ]);
    }
}
