<?php

namespace App\Http\Livewire\Pengawas;

use App\Models\Catatanpasien;
use Livewire\Component;
use Livewire\Attributes\On;

class CatatanPasienBaru extends Component
{
    public $ruangan;

    public function mount($ruangan = null)
    {
        $this->ruangan = $ruangan;
    }

    #[On('refreshCatatanBaru')]
    public function refresh(): void
    {
        // Livewire v4: re-render is triggered automatically after this method runs
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
