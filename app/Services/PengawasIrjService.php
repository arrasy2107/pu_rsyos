<?php

namespace App\Services;

use App\Models\Laporanirj;
use App\Models\Laporanirjdetail;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class PengawasIrjService
{
    public function createDraft(array $data)
    {
        $sp = Laporanirjdetail::where('id_pengawas', Auth::id())->where('status', 0)->first();
 
        if (!$sp) {
            return ['success' => false, 'message' => 'Jumlah pasien menurut Dokter masih kosong, silahkan isi terlebih dahulu'];
        }

        $sup = new Laporanirj();
        $sup->id_pengawas = Auth::id();
        $sup->masalah = $data['irj_masalah'];
        $sup->langkah_atasi_masalah = $data['irj_langkah'];
        
        date_default_timezone_set('Asia/Jakarta');
        $sup->created_at = date('Y-m-d H:i:s');
        $sup->updated_at = date('Y-m-d H:i:s');
        $sup->save();

        $this->logActivity('Tambah Draft', 3);

        return ['success' => true, 'message' => 'Berhasil menambah ke Draft Laporan IRJ'];
    }

    public function updateDraft(array $data)
    {
        $sp = Laporanirjdetail::where('id_pengawas', Auth::id())->where('status', 0)->first();
 
        if (!$sp) {
            return ['success' => false, 'message' => 'Jumlah pasien menurut Dokter masih kosong, silahkan isi terlebih dahulu'];
        }

        $sup = Laporanirj::whereKey($data['id'])
            ->where('id_pengawas', Auth::id())
            ->where('status', 0)
            ->firstOrFail();
            
        $sup->masalah = $data['irj_masalah'];
        $sup->langkah_atasi_masalah = $data['irj_langkah'];
        
        date_default_timezone_set('Asia/Jakarta');
        $sup->updated_at = date('Y-m-d H:i:s');
        $sup->save();

        $this->logActivity('Edit Draft', 3);

        return ['success' => true, 'message' => 'Berhasil menambah ke Draft Laporan IRJ'];
    }

    public function deleteDraft(int $id)
    {
        $sup = Laporanirj::whereKey($id)
            ->where('id_pengawas', Auth::id())
            ->where('status', 0)
            ->firstOrFail();
            
        $sup->status = 2; // Delete Laporan
        $sup->save();

        // Hapus detail
        Laporanirjdetail::where('status', 0)->where('id_pengawas', Auth::id())->delete();

        $this->logActivity('Hapus Draft', 3);

        return ['success' => true, 'message' => 'Berhasil menghapus data draf Laporan IRJ'];
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
