<?php

namespace App\Services;

use App\Models\Laporanumum;
use App\Models\Catatanpasien;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class PengawasUmumService
{
    /**
     * Create a new Umum draft report.
     *
     * @param array $data Validated data
     * @return array ['success' => bool, 'message' => string]
     */
    public function createDraft(array $data)
    {
        $pasienLama = Laporanumum::saldoPasienLama((int) $data['inap_ruangan']);
        $total = $pasienLama + ($data['inap_pasien_baru'] ?? 0)
            - ($data['inap_pasien_pindah'] ?? 0) + ($data['inap_pasien_pindahan'] ?? 0)
            - ($data['inap_pasien_meninggal'] ?? 0) - ($data['inap_pasien_pulang'] ?? 0);

        if ($total < 0) {
            return ['success' => false, 'message' => 'Total Pasien tidak boleh di bawah 0, Coba periksa ulang inputan Anda.'];
        }

        if (Laporanumum::where('id_pengawas', Auth::id())
            ->where('id_ruangan', $data['inap_ruangan'])
            ->where('status', 0)
            ->exists()) {
            return ['success' => false, 'message' => 'Draft laporan untuk ruangan ini sudah ada.'];
        }

        $sup = new Laporanumum();
        $sup->id_pengawas = Auth::id();
        $sup->id_ruangan = $data['inap_ruangan'];

        $sup->jumlah_pasien_lama = $pasienLama;
        $sup->jumlah_pasien_baru = $data['inap_pasien_baru'];
        $sup->jumlah_pasien_pindah = $data['inap_pasien_pindah'];
        $sup->jumlah_pasien_pindahan = $data['inap_pasien_pindahan'];
        $sup->jumlah_pasien_meninggal = $data['inap_pasien_meninggal'];
        $sup->jumlah_pasien_pulang = $data['inap_pasien_pulang'];

        $sup->catatan_pasien_istimewa = $data['inap_catatan_istimewa'] ?? null;
        $sup->catatan_pasien_baru = $data['inap_catatan_baru'] ?? null;
        $sup->jumlah_pasien_covid = $data['inap_pasien_covid'] ?? null;
        $sup->jumlah_pasien_suspek_covid = $data['inap_pasien_suspect'] ?? null;
        $sup->jumlah_pasien_restrain = $data['inap_pasien_restrain'] ?? null;
        $sup->jumlah_pasien_perilaku_kekerasan = $data['inap_pasien_kekerasan'] ?? null;
        $sup->jumlah_pasien_keracunan = $data['inap_pasien_keracunan'] ?? null;
        $sup->jumlah_pasien_keterbatasan_bahasa = $data['inap_pasien_bahasa'] ?? null;
        $sup->jumlah_pasien_difabel = $data['inap_pasien_difabel'] ?? null;
        $sup->permasalahan_umum = $data['inap_permasalahan'] ?? null;
        // Data Petugas
        $sup->jumlah_petugas = $data['inap_jumlah_petugas'] ?? 0;
        $sup->jumlah_petugas_perbantuan_masuk = $data['inap_perbantuan_masuk'] ?? 0;
        $sup->id_ruangan_perbantuan_masuk = $data['inap_asal_perbantuan'] ?: null;
        $sup->jumlah_petugas_perbantuan_keluar = $data['inap_perbantuan_keluar'] ?? 0;
        $sup->id_ruangan_perbantuan_keluar = $data['inap_tujuan_perbantuan'] ?: null;
        $sup->catatan_petugas = $data['inap_catatan_petugas'] ?? null;
        
        $sup->jumlah_total_pasien = $total;
        
        date_default_timezone_set('Asia/Jakarta');
        $sup->created_at = date('Y-m-d H:i:s');
        $sup->updated_at = date('Y-m-d H:i:s');
        $sup->save();

        // Tambah Catatan Pasien
        $laporanId = Laporanumum::where('id_ruangan', $data['inap_ruangan'])
            ->where('id_pengawas', Auth::id())
            ->pluck('id')
            ->last();
            
        Catatanpasien::where('id_pengawas', Auth::id())
            ->where('id_ruangan', $data['inap_ruangan'])
            ->where('status', 0)
            ->update([
                'updated_at' => date('Y-m-d H:i:s'), 
                'id_laporan_umum' => $laporanId
            ]);

        $this->logActivity('Tambah Draft', 2);

        return ['success' => true, 'message' => 'Berhasil menambah ke Draf Laporan Rawat Inap'];
    }

    /**
     * Update an existing Umum draft report.
     *
     * @param array $data Validated data
     * @return array ['success' => bool, 'message' => string]
     */
    public function updateDraft(array $data)
    {
        $pasienLama = Laporanumum::saldoPasienLama((int) $data['inap_ruangan']);
        $total = $pasienLama + ($data['inap_pasien_baru'] ?? 0)
            - ($data['inap_pasien_pindah'] ?? 0) + ($data['inap_pasien_pindahan'] ?? 0)
            - ($data['inap_pasien_meninggal'] ?? 0) - ($data['inap_pasien_pulang'] ?? 0);

        if ($total < 0) {
            return ['success' => false, 'message' => 'Total Pasien tidak boleh di bawah 0, Coba periksa ulang inputan Anda.'];
        }

        $sup = Laporanumum::whereKey($data['id'])
            ->where('id_pengawas', Auth::id())
            ->where('status', 0)
            ->firstOrFail();

        $duplicate = Laporanumum::where('id_pengawas', Auth::id())
            ->where('id_ruangan', $data['inap_ruangan'])
            ->where('status', 0)
            ->whereKeyNot($sup->id)
            ->exists();
            
        if ($duplicate) {
            return ['success' => false, 'message' => 'Draft laporan untuk ruangan ini sudah ada.'];
        }

        $sup->id_ruangan = $data['inap_ruangan'];
        $sup->jumlah_pasien_lama = $pasienLama;
        $sup->jumlah_pasien_baru = $data['inap_pasien_baru'];
        $sup->jumlah_pasien_pindah = $data['inap_pasien_pindah'];
        $sup->jumlah_pasien_pindahan = $data['inap_pasien_pindahan'];
        $sup->jumlah_pasien_meninggal = $data['inap_pasien_meninggal'];
        $sup->jumlah_pasien_pulang = $data['inap_pasien_pulang'];
        
        $sup->catatan_pasien_istimewa = $data['inap_catatan_istimewa'] ?? null;
        $sup->catatan_pasien_baru = $data['inap_catatan_baru'] ?? null;
        $sup->jumlah_pasien_covid = $data['inap_pasien_covid'] ?? null;
        $sup->jumlah_pasien_suspek_covid = $data['inap_pasien_suspect'] ?? null;
        $sup->jumlah_pasien_restrain = $data['inap_pasien_restrain'] ?? null;
        $sup->jumlah_pasien_perilaku_kekerasan = $data['inap_pasien_kekerasan'] ?? null;
        $sup->jumlah_pasien_keracunan = $data['inap_pasien_keracunan'] ?? null;
        $sup->jumlah_pasien_keterbatasan_bahasa = $data['inap_pasien_bahasa'] ?? null;
        $sup->jumlah_pasien_difabel = $data['inap_pasien_difabel'] ?? null;
        $sup->permasalahan_umum = $data['inap_permasalahan'] ?? null;
        // Data Petugas
        $sup->jumlah_petugas = $data['inap_jumlah_petugas'] ?? 0;
        $sup->jumlah_petugas_perbantuan_masuk = $data['inap_perbantuan_masuk'] ?? 0;
        $sup->id_ruangan_perbantuan_masuk = $data['inap_asal_perbantuan'] ?: null;
        $sup->jumlah_petugas_perbantuan_keluar = $data['inap_perbantuan_keluar'] ?? 0;
        $sup->id_ruangan_perbantuan_keluar = $data['inap_tujuan_perbantuan'] ?: null;
        $sup->catatan_petugas = $data['inap_catatan_petugas'] ?? null;
        
        $sup->jumlah_total_pasien = $total;
        
        date_default_timezone_set('Asia/Jakarta');
        $sup->created_at = date('Y-m-d H:i:s');
        $sup->updated_at = date('Y-m-d H:i:s');
        $sup->save();

        // Edit Catatan Pasien
        $laporanId = Laporanumum::where('id_ruangan', $data['inap_ruangan'])
            ->where('id_pengawas', Auth::id())
            ->pluck('id')
            ->last();
            
        Catatanpasien::where('id_pengawas', Auth::id())
            ->where('id_ruangan', $data['inap_ruangan'])
            ->where('status', 0)
            ->update([
                'updated_at' => date('Y-m-d H:i:s'), 
                'id_laporan_umum' => $laporanId
            ]);

        $this->logActivity('Edit Draft', 2);

        return ['success' => true, 'message' => 'Berhasil mengubah data Draf Laporan Rawat Inap'];
    }

    /**
     * Delete an existing Umum draft report.
     *
     * @param int $id
     * @return array ['success' => bool, 'message' => string]
     */
    public function deleteDraft(int $id)
    {
        $sup = Laporanumum::whereKey($id)
            ->where('id_pengawas', Auth::id())
            ->where('status', 0)
            ->firstOrFail();
            
        $sup->status = 2; // Delete Laporan
        $sup->save();

        // Hapus Catatan Pasien
        Catatanpasien::where('id_pengawas', Auth::id())
            ->where('id_laporan_umum', $id)
            ->update([
                'updated_at' => date('Y-m-d H:i:s'), 
                'status' => 2
            ]);

        $this->logActivity('Hapus Draft', 2);

        return ['success' => true, 'message' => 'Berhasil menghapus data Draf Laporan Rawat Inap'];
    }

    /**
     * Log activity
     *
     * @param string $keterangan
     * @param int $idJenis
     */
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
