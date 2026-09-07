<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Laporan;
use App\Models\Laporanigd;
use App\Models\Laporanumum;
use App\Models\Laporanirj;
use App\Models\Laporanirjdetail;
use App\Models\Laporanibs;
use App\Models\Laporanibsdetail;
use App\Models\Dinas;

class LaporanDetailModal extends Component
{
    public $modalType = null;
    public $idlaporan = null;
    public $laporan = null;
    public $rows = [];
    public $extra = [];

    protected $listeners = ['openLaporanDetailModal' => 'open'];

    public function mount($modalType = null)
    {
        $this->modalType = $modalType;
    }

    public function open($type = null, $idlaporan = null)
    {
        if ($type !== $this->modalType || !$idlaporan) {
            return;
        }

        $this->idlaporan = $idlaporan;
        $this->loadData();
    }

    protected function loadData()
    {
        $this->laporan = Laporan::find($this->idlaporan);
        $this->rows = [];
        $this->extra = [];

        if (!$this->laporan) {
            return;
        }

        if ($this->modalType === 'igd') {
            $this->rows = Laporanigd::where('id_laporan', $this->idlaporan)->get();
            $this->extra['alasan'] = Laporanigd::where('id_laporan', $this->idlaporan)->pluck('alasan_tidak_bisa_rawat')->first();
            $this->extra['permasalahan'] = Laporanigd::where('id_laporan', $this->idlaporan)->pluck('permasalahan')->first();
            $this->extra['lain_lain'] = Laporanigd::where('id_laporan', $this->idlaporan)->pluck('lain_lain')->first();
        } elseif ($this->modalType === 'umum') {
            $this->rows = Laporanumum::with('ruangan')->where('id_laporan', $this->idlaporan)->get();
        } elseif ($this->modalType === 'irj') {
            $laporanIrj = Laporanirj::where('id_laporan', $this->idlaporan)->first();
            $this->rows = $laporanIrj
                ? Laporanirjdetail::with('dokter.jenisSdmk')->where('status', 1)->where('id_laporan_irj', $laporanIrj->id)->get()
                : collect();
            $this->extra['masalah'] = optional($laporanIrj)->masalah;
            $this->extra['langkah'] = optional($laporanIrj)->langkah_atasi_masalah;
        } elseif ($this->modalType === 'ibs') {
            $laporanIbs = Laporanibs::where('id_laporan', $this->idlaporan)->first();
            $this->rows = $laporanIbs
                ? Laporanibsdetail::with(['dokterOperasi', 'dokterAnestesi', 'ruangan'])->where('status', 1)->where('id_laporan_ibs', $laporanIbs->id)->get()
                : collect();
            $this->extra['catatan'] = optional($laporanIbs)->catatan;
        }
    }

    public function render()
    {
        return view('livewire.dashboard.laporan-detail-modal');
    }
}
