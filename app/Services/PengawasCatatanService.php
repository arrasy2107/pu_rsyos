<?php

namespace App\Services;

use App\Models\Catatanpasien;
use App\Models\Laporanumum;
use App\Models\Jenispasien;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class PengawasCatatanService
{
    public function createCatatan(array $data)
    {
        $sup = new Catatanpasien();
        $sup->id_pengawas = Auth::id();

        $laporanUmumId = Laporanumum::where('id_ruangan', $data['ruangan'])
            ->where('status', 0)
            ->where('id_pengawas', Auth::id())
            ->pluck('id')
            ->last();

        if ($laporanUmumId) {
            $sup->id_laporan_umum = $laporanUmumId;
        }

        $sup->id_jenis_pasien = $data['jenis_pasien'];
        $sup->id_ruangan = $data['ruangan'];
        $sup->kamar = $data['kamar'];
        $sup->nama = $data['nama'];
        $sup->rm = $data['rm'];
        $sup->diagnosa = $data['diagnosa'];
        $sup->dpjp = $data['dpjp'];
        $sup->kondisi = $data['kondisi'];
      
        date_default_timezone_set('Asia/Jakarta');
        $sup->created_at = date('Y-m-d H:i:s');
        $sup->updated_at = date('Y-m-d H:i:s');
        $sup->save();

        $jenisPasienName = Jenispasien::where('id', $data['jenis_pasien'])->pluck('jenis')->first();
        $this->logActivity('Tambah Catatan Pasien ' . $jenisPasienName, 18);

        return [
            'success' => true, 
            'message' => 'Berhasil menambah data Catatan Pasien ' . $jenisPasienName
        ];
    }

    public function updateCatatan(array $data)
    {
        $sup = Catatanpasien::whereKey($data['id'])
            ->where('id_pengawas', Auth::id())
            ->where('status', 0)
            ->firstOrFail();

        $laporanUmumId = Laporanumum::where('id_ruangan', $data['ruangan'])
            ->where('status', 0)
            ->where('id_pengawas', Auth::id())
            ->pluck('id')
            ->last();

        if ($laporanUmumId) {
            $sup->id_laporan_umum = $laporanUmumId;
        }

        $sup->id_jenis_pasien = $data['jenis_pasien'];
        $sup->id_ruangan = $data['ruangan'];
        $sup->kamar = $data['kamar'];
        $sup->nama = $data['nama'];
        $sup->rm = $data['rm'];
        $sup->diagnosa = $data['diagnosa'];
        $sup->dpjp = $data['dpjp'];
        $sup->kondisi = $data['kondisi'];
        
        date_default_timezone_set('Asia/Jakarta');
        $sup->updated_at = date('Y-m-d H:i:s');
        $sup->save();

        $jenisPasienName = Jenispasien::where('id', $data['jenis_pasien'])->pluck('jenis')->first();
        $this->logActivity('Ubah Catatan Pasien ' . $jenisPasienName, 18);

        return [
            'success' => true, 
            'message' => 'Berhasil mengubah data Catatan Pasien ' . $jenisPasienName
        ];
    }

    public function deleteCatatan(int $id, int $jenisPasienId)
    {
        $sup = Catatanpasien::whereKey($id)
            ->where('id_pengawas', Auth::id())
            ->where('status', 0)
            ->firstOrFail();
            
        $sup->delete();

        $jenisPasienName = Jenispasien::where('id', $jenisPasienId)->pluck('jenis')->first();
        $this->logActivity('Hapus Data Catatan Pasien ' . $jenisPasienName, 18);

        return [
            'success' => true, 
            'message' => 'Berhasil menghapus data Catatan Pasien ' . $jenisPasienName
        ];
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
