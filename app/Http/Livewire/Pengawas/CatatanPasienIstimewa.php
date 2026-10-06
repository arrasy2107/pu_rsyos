<?php

namespace App\Http\Livewire\Pengawas;

use App\Models\Catatanpasien;
use Livewire\Component;
use Livewire\Attributes\On;

class CatatanPasienIstimewa extends Component
{
    public $ruangan;

    public function mount($ruangan = null)
    {
        $this->ruangan = $ruangan;
    }

    #[On('refreshCatatanIstimewa')]
    public function refresh(): void
    {
        // Livewire v4: re-render is triggered automatically after this method runs
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
