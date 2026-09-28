<?php

namespace App\Services;

use App\Models\Laporanibs;
use App\Models\Laporanibsdetail;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class PengawasIbsService
{
    public function createDraft(array $data)
    {
        $sp = Laporanibsdetail::where('id_pengawas', Auth::id())->where('status', 0)->first();
 
        if (!$sp) {
            return ['success' => false, 'message' => 'Jumlah pasien menurut Dokter IBS masih kosong, silahkan isi terlebih dahulu'];
        }

        $sup = new Laporanibs();
        $sup->id_pengawas = Auth::id();
        $sup->total_pasien = Laporanibsdetail::where('id_pengawas', Auth::id())->where('status', 0)->count();
        $sup->catatan = $data['ibs_catatan'] ?? null;
        
        date_default_timezone_set('Asia/Jakarta');
        $sup->created_at = date('Y-m-d H:i:s');
        $sup->updated_at = date('Y-m-d H:i:s');
        $sup->save();

        $this->logActivity('Tambah Draft', 16);

        return ['success' => true, 'message' => 'Berhasil menambah ke Draft Laporan IBS'];
    }

    public function updateDraft(array $data)
    {
        $sp = Laporanibsdetail::where('id_pengawas', Auth::id())->where('status', 0)->first();
 
        if (!$sp) {
            return ['success' => false, 'message' => 'Jumlah pasien menurut Dokter IBS masih kosong, silahkan isi terlebih dahulu'];
        }

        $sup = Laporanibs::whereKey($data['idibs'])
            ->where('id_pengawas', Auth::id())
            ->where('status', 0)
            ->firstOrFail();
            
        $sup->total_pasien = Laporanibsdetail::where('id_pengawas', Auth::id())->where('status', 0)->count();
        $sup->catatan = $data['ibs_catatan'] ?? null;
        
        date_default_timezone_set('Asia/Jakarta');
        $sup->updated_at = date('Y-m-d H:i:s');
        $sup->save();

        $this->logActivity('Edit Draft', 16);

        return ['success' => true, 'message' => 'Berhasil menambah ke Draft Laporan IBS'];
    }

    public function deleteDraft(int $id)
    {
        $sup = Laporanibs::whereKey($id)
            ->where('id_pengawas', Auth::id())
            ->where('status', 0)
            ->firstOrFail();
            
        $sup->status = 2; // Delete Laporan
        $sup->save();

        // hapus detail
        Laporanibsdetail::where('status', 0)->where('id_pengawas', Auth::id())->delete();

        $this->logActivity('Hapus Draft', 16);

        return ['success' => true, 'message' => 'Berhasil menghapus data draf Laporan IBS'];
    }

    private function logActivity(string $keterangan, int $idJenis)
    {
        date_default_timezone_set('Asia/Jakarta');
        $log = new Log();
        $log->id_user = Auth::id();
        $log->id_log_jenis = $idJenis;
        $log->keterangan = $keterangan;
        $log->created_at = date('Y-m-d H:i:s');
        $log->updated_at = date('Y-m-d H:i:s');
        $log->save();
    }
}
