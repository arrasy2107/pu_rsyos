<?php

namespace App\Services;

use App\Models\Laporanigd;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class PengawasIgdService
{
    /**
     * Create a new IGD draft report.
     *
     * @param array $data Validated data
     * @return array ['success' => bool, 'message' => string]
     */
    public function createDraft(array $data)
    {
        if (Laporanigd::where('status', 0)->where('id_pengawas', Auth::id())->exists()) {
            return ['success' => false, 'message' => 'Laporan IGD aktif sudah ada. Silakan ubah melalui Draf Laporan.'];
        }

        if ($data['igd_pasien'] - $data['igd_pasien_rawat'] < 0) {
            return ['success' => false, 'message' => 'Jumlah kunjungan pasien tidak boleh LEBIH KECIL dari jumlah pasien rawat'];
        }

        if ($data['igd_pasien'] - $data['igd_pasien_emergency'] < 0) {
            return ['success' => false, 'message' => 'Jumlah kunjungan pasien tidak boleh LEBIH KECIL dari jumlah pasien Emergency'];
        }

        if ($data['igd_pasien_sisrute'] - $data['igd_pasien_sisrute_diterima'] < 0) {
            return ['success' => false, 'message' => 'Jumlah Rujukan SISRUTE tidak boleh LEBIH KECIL dari jumlah pasien SISRUTE yang diterima'];
        }

        $sup = new Laporanigd();
        $sup->id_pengawas = Auth::id();
        $sup->id_dokter = implode(',', $data['igd_dokterjaga']);
        $sup->jumlah_pasien = $data['igd_pasien'];
        $sup->jumlah_pasien_rawat = $data['igd_pasien_rawat'];
        $sup->jumlah_pasien_pulang = $data['igd_pasien'] - $data['igd_pasien_rawat'];
        $sup->jumlah_pasien_emergency = $data['igd_pasien_emergency'];
        $sup->jumlah_pasien_non_emergency = $data['igd_pasien'] - $data['igd_pasien_emergency'];
        $sup->jumlah_pasien_tidak_bisa_rawat = $data['igd_pasien_tidak_rawat'];
        $sup->jumlah_pasien_sisrute = $data['igd_pasien_sisrute'];
        $sup->jumlah_pasien_sisrute_diterima = $data['igd_pasien_sisrute_diterima'];
        $sup->jumlah_pasien_sisrute_ditolak = $data['igd_pasien_sisrute'] - $data['igd_pasien_sisrute_diterima'];
        $sup->alasan_tidak_bisa_rawat = $data['igd_alasan'] ?? null;
        $sup->jumlah_pasien_doa = $data['igd_pasien_doa'];
        $sup->permasalahan = $data['igd_permasalahan'] ?? null;
        $sup->lain_lain = $data['igd_lainlain'] ?? null;
        
        date_default_timezone_set('Asia/Jakarta');
        $sup->created_at = date('Y-m-d H:i:s');
        $sup->updated_at = date('Y-m-d H:i:s');
        $sup->save();

        $this->logActivity('Tambah Draft', 1);

        return ['success' => true, 'message' => 'Berhasil menambah ke Draft Laporan IGD'];
    }

    /**
     * Update an existing IGD draft report.
     *
     * @param array $data Validated data
     * @return array ['success' => bool, 'message' => string]
     */
    public function updateDraft(array $data)
    {
        if ($data['igd_pasien'] - $data['igd_pasien_rawat'] < 0) {
            return ['success' => false, 'message' => 'Jumlah kunjungan pasien tidak boleh LEBIH KECIL dari jumlah pasien rawat'];
        }

        if ($data['igd_pasien'] - $data['igd_pasien_emergency'] < 0) {
            return ['success' => false, 'message' => 'Jumlah kunjungan pasien tidak boleh LEBIH KECIL dari jumlah pasien Emergency'];
        }

        if ($data['igd_pasien_sisrute'] - $data['igd_pasien_sisrute_diterima'] < 0) {
            return ['success' => false, 'message' => 'Jumlah Rujukan SISRUTE tidak boleh LEBIH KECIL dari jumlah pasien SISRUTE yang diterima'];
        }

        $sup = Laporanigd::where('id', $data['id'])
            ->where('id_pengawas', Auth::id())
            ->where('status', 0)
            ->firstOrFail();

        $sup->id_dokter = implode(',', $data['igd_dokterjaga']);
        $sup->jumlah_pasien = $data['igd_pasien'];
        $sup->jumlah_pasien_rawat = $data['igd_pasien_rawat'];
        $sup->jumlah_pasien_pulang = $data['igd_pasien'] - $data['igd_pasien_rawat'];
        $sup->jumlah_pasien_emergency = $data['igd_pasien_emergency'];
        $sup->jumlah_pasien_non_emergency = $data['igd_pasien'] - $data['igd_pasien_emergency'];
        $sup->jumlah_pasien_tidak_bisa_rawat = $data['igd_pasien_tidak_rawat'];
        $sup->jumlah_pasien_sisrute = $data['igd_pasien_sisrute'];
        $sup->jumlah_pasien_sisrute_diterima = $data['igd_pasien_sisrute_diterima'];
        $sup->jumlah_pasien_sisrute_ditolak = $data['igd_pasien_sisrute'] - $data['igd_pasien_sisrute_diterima'];
        $sup->alasan_tidak_bisa_rawat = $data['igd_alasan'] ?? null;
        $sup->jumlah_pasien_doa = $data['igd_pasien_doa'];
        $sup->permasalahan = $data['igd_permasalahan'] ?? null;
        $sup->lain_lain = $data['igd_lainlain'] ?? null;
        
        date_default_timezone_set('Asia/Jakarta');
        $sup->updated_at = date('Y-m-d H:i:s');
        $sup->save();

        $this->logActivity('Edit Draft', 1);

        return ['success' => true, 'message' => 'Berhasil mengubah data Draft Laporan IGD'];
    }

    /**
     * Delete an existing IGD draft report.
     *
     * @param int $id
     * @return array ['success' => bool, 'message' => string]
     */
    public function deleteDraft(int $id)
    {
        $sup = Laporanigd::where('id', $id)
            ->where('id_pengawas', Auth::id())
            ->where('status', 0)
            ->firstOrFail();
            
        $sup->status = 2; // Delete Laporan
        $sup->save();

        $this->logActivity('Hapus Draft', 1);

        return ['success' => true, 'message' => 'Berhasil menghapus data draf Laporan IGD'];
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
