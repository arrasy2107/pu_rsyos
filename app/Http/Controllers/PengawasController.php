<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PengawasController extends Controller
{
    private function _getTimeRange()
    {
        date_default_timezone_set('Asia/Jakarta');
        setlocale(LC_TIME, 'id_ID');
        \Carbon\Carbon::setLocale('id');

        $today = \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y');
        $cekhariini = \Carbon\Carbon::now()->format('Ymd');
        $t = new \Grei\TanggalMerah();
        $t->set_date($cekhariini);

        $now = \Carbon\Carbon::now();
        $ltime = date('H:i:s');
        $hariini = date('Y-m-d');
        $nowTime = $now->hour . ':' . $now->minute . ':' . $now->second;

        $start1Value = \App\Models\Dinas::where('id', 1)->value('jam_masuk');
        $end1Value = \App\Models\Dinas::where('id', 1)->value('jam_pulang');
        $start2Value = \App\Models\Dinas::where('id', 2)->value('jam_masuk');
        $end2Value = \App\Models\Dinas::where('id', 2)->value('jam_pulang');

        $start1 = $start1Value ? \Carbon\Carbon::createFromTimeString($start1Value) : \Carbon\Carbon::now()->startOfDay();
        $end1 = $end1Value ? \Carbon\Carbon::createFromTimeString($end1Value) : \Carbon\Carbon::now()->endOfDay();
        $start2 = $start2Value ? \Carbon\Carbon::createFromTimeString($start2Value) : \Carbon\Carbon::now()->startOfDay();
        $end2 = $end2Value ? \Carbon\Carbon::createFromTimeString($end2Value) : \Carbon\Carbon::now()->endOfDay();

        if (\App\Models\Irjbuka::where('tanggal', $hariini)->first()) {
            $cekdinaspagi = \App\Models\Irjbuka::where('tanggal', $hariini)->where('id_dinas', 1)->first();
            $cekdinassore = \App\Models\Irjbuka::where('tanggal', $hariini)->where('id_dinas', 2)->first();

            if ($cekdinaspagi && $cekdinassore) {
                $start = $start1;
                $end = $end2;
            } else if ($cekdinaspagi) {
                $start = $start1;
                $end = $end1;
            } else {
                $start = $start2;
                $end = $end2;
            }
        } else {
            $start = $start1;
            $end = $end2;
        }

        return compact('today', 'hariini', 'nowTime', 'start', 'end', 't');
    }

    public function laporan()
    {
        $timeVars = $this->_getTimeRange();
        extract($timeVars);

        $igdLaporan = \App\Models\Laporanigd::where('status', 0)->where('id_pengawas', \Auth::user()->id)->first();
        $dokters = \App\Models\Dokter::where('status', 1)
            ->where('id_sdmk_jenis', 1)
            ->get();
        $visitedRooms = \App\Models\Laporanumum::where('status', 0)->where('id_pengawas', \Auth::user()->id)->count();
        $visitedRoomIds = \App\Models\Laporanumum::where('status', 0)->where('id_pengawas', \Auth::user()->id)->pluck('id_ruangan')->toArray();
        $totalRooms = \App\Models\Ruangan::where('status', 1)->count();
        $allVisited = ($visitedRooms == $totalRooms && $totalRooms > 0);
        $ruangans = \App\Models\Ruangan::where('status', 1)->get();
        $ibsLaporan = \App\Models\Laporanibs::where('status', 0)->where('id_pengawas', \Auth::user()->id)->first();
        $ibsDetailCount = \App\Models\Laporanibsdetail::where('id_pengawas', \Auth::user()->id)->where('status', 0)->count();
        $irjLaporan = \App\Models\Laporanirj::where('status', 0)->where('id_pengawas', \Auth::user()->id)->first();
        $irjDetailTotal = \App\Models\Laporanirjdetail::where('id_pengawas', \Auth::user()->id)->where('status', 0)->pluck('pasien_total')->sum();

        return view('pengawas.laporan.laporan', compact(
            'today', 'hariini', 'nowTime', 'start', 'end', 't',
            'igdLaporan', 'dokters', 'visitedRooms', 'visitedRoomIds', 'totalRooms', 'allVisited', 'ruangans',
            'ibsLaporan', 'ibsDetailCount', 'irjLaporan', 'irjDetailTotal'
        ));
    }

    public function drafLaporan()
    {
        $timeVars = $this->_getTimeRange();
        extract($timeVars);

        $igdDraf = \App\Models\Laporanigd::where('id_pengawas', \Auth::user()->id)->where('status', 0)->first();
        $dokters = \App\Models\Dokter::where('status', 1)
            ->where('id_sdmk_jenis', 1)
            ->get();
        
        $visitedRoomIdsDraf = \App\Models\Laporanumum::where('status', 0)->where('id_pengawas', \Auth::user()->id)->pluck('id_ruangan')->toArray();
        $visitedRoomIdsDraf = array_values(array_unique($visitedRoomIdsDraf));
        $visitedRoomsDraf = count($visitedRoomIdsDraf);
        $totalRoomsDraf = \App\Models\Ruangan::where('status', 1)->count();
        $totalPasienDraf = \App\Models\Laporanumum::where('status', 0)->where('id_pengawas', \Auth::user()->id)->pluck('jumlah_total_pasien')->sum();
        $ruangans = \App\Models\Ruangan::where('status', 1)->get();

        $ibsDraf = \App\Models\Laporanibs::where('status', 0)->where('id_pengawas', \Auth::user()->id)->first();
        $ibsDrafDetailCount = \App\Models\Laporanibsdetail::where('id_pengawas', \Auth::user()->id)->where('status', 0)->count();
        $ibsDrafDetails = \App\Models\Laporanibsdetail::where('id_pengawas', \Auth::user()->id)->where('status', 0)->get();

        $irjDraf = \App\Models\Laporanirj::where('id_pengawas', \Auth::user()->id)->where('status', 0)->first();
        $irjDrafDetails = \App\Models\Laporanirjdetail::where('id_pengawas', \Auth::user()->id)->where('status', 0)->get();
        $irjDrafDetailTotal = $irjDrafDetails->sum('pasien_total');
        $irjDrafDetailCount = $irjDrafDetails->count();

        $dinasList = \App\Models\Dinas::all();
        $visitedRoomsCount = $visitedRoomsDraf;
        $totalRoomsCount = $totalRoomsDraf;
        $hasIgdReport = ($igdDraf != null);

        return view('pengawas.draf-laporan.draf-laporan', compact(
            'today', 'hariini', 'nowTime', 'start', 'end', 't',
            'igdDraf', 'dokters', 'visitedRoomsDraf', 'visitedRoomIdsDraf', 'totalRoomsDraf', 'totalPasienDraf', 'ruangans',
            'ibsDraf', 'ibsDrafDetailCount', 'ibsDrafDetails',
            'irjDraf', 'irjDrafDetails', 'irjDrafDetailTotal', 'irjDrafDetailCount',
            'dinasList', 'visitedRoomsCount', 'totalRoomsCount', 'hasIgdReport'
        ));
    }

    //LAPORAN IGD
    public function draftlaporanIGD(Request $r)
    {
        $r->validate([
            'igd_pasien' => ['required', 'integer', 'min:0'],
            'igd_pasien_rawat' => ['required', 'integer', 'min:0'],
            'igd_pasien_emergency' => ['required', 'integer', 'min:0'],
            'igd_pasien_tidak_rawat' => ['required', 'integer', 'min:0'],
            'igd_pasien_doa' => ['required', 'integer', 'min:0'],
            'igd_pasien_sisrute' => ['required', 'integer', 'min:0'],
            'igd_pasien_sisrute_diterima' => ['required', 'integer', 'min:0'],
            'igd_dokterjaga' => ['required', 'array', 'min:1'],
            'igd_dokterjaga.*' => ['integer', 'exists:dokter,id,status,1,id_sdmk_jenis,1'],
            'igd_alasan' => ['nullable', 'string'],
            'igd_permasalahan' => ['nullable', 'string'],
            'igd_lainlain' => ['nullable', 'string'],
        ]);

        if (\App\Models\Laporanigd::where('status', 0)->where('id_pengawas', \Auth::id())->exists()) {
            return redirect()->route('draf-laporan')->with('fail-add', 'Laporan IGD aktif sudah ada. Silakan ubah melalui Draf Laporan.');
        }

        if($r->igd_pasien - $r->igd_pasien_rawat < 0){
            return redirect()->back()->with('fail-add', 'Jumlah kunjungan pasien tidak boleh LEBIH KECIL dari jumlah pasien rawat');
        }
        else if($r->igd_pasien - $r->igd_pasien_emergency < 0){
            return redirect()->back()->with('fail-add', 'Jumlah kunjungan pasien tidak boleh LEBIH KECIL dari jumlah pasien Emergency');
        }
        else if($r->igd_pasien_sisrute - $r->igd_pasien_sisrute_diterima < 0){
            return redirect()->back()->with('fail-add', 'Jumlah Rujukan SISRUTE tidak boleh LEBIH KECIL dari jumlah pasien SISRUTE yang diterima');
        }
        else{
            $sup = new \App\Models\Laporanigd;
            $sup->id_pengawas = \Auth::user()->id;
            $sup->id_dokter = implode(',', $r->igd_dokterjaga);
            
            $sup->jumlah_pasien = $r->igd_pasien;
            $sup->jumlah_pasien_rawat = $r->igd_pasien_rawat ;	
            $sup->jumlah_pasien_pulang	= $r->igd_pasien - $r->igd_pasien_rawat;
            $sup->jumlah_pasien_emergency = $r->igd_pasien_emergency;	
            $sup->jumlah_pasien_non_emergency = $r->igd_pasien - $r->igd_pasien_emergency;
            $sup->jumlah_pasien_tidak_bisa_rawat= $r->igd_pasien_tidak_rawat ;
            // SISRUTE
            $sup->jumlah_pasien_sisrute= $r->igd_pasien_sisrute ;
            $sup->jumlah_pasien_sisrute_diterima= $r->igd_pasien_sisrute_diterima ;
            $sup->jumlah_pasien_sisrute_ditolak= $r->igd_pasien_sisrute - $r->igd_pasien_sisrute_diterima ;
            
            $sup->alasan_tidak_bisa_rawat= $r->igd_alasan ;	
            $sup->jumlah_pasien_doa= $r->igd_pasien_doa;	
            $sup->permasalahan = $r->igd_permasalahan ;
            $sup->lain_lain = $r->igd_lainlain ;
            $date = date_default_timezone_set('Asia/Jakarta');
            $sup->created_at = date('Y-m-d H:i:s');
            $sup->updated_at =  date('Y-m-d H:i:s');
            $sup->save();
    
            //log data
            $log = new \App\Models\Log;
            $log->id_user = \Auth::user()->id;
            $log->id_log_jenis = 1;
            $log->keterangan = 'Tambah Draft';
            $log->created_at = date('Y-m-d H:i:s');
            $log->updated_at =  date('Y-m-d H:i:s');
            $log->save();
    
            return redirect()->back()->with('success-add', 'Berhasil menambah ke Draft Laporan IGD');
        }
        
    }

    public function editDraftlaporanIGD(Request $r)
    {
        $r->validate([
            'id' => ['required', 'integer'],
            'igd_pasien' => ['required', 'integer', 'min:0'],
            'igd_pasien_rawat' => ['required', 'integer', 'min:0'],
            'igd_pasien_emergency' => ['required', 'integer', 'min:0'],
            'igd_pasien_tidak_rawat' => ['required', 'integer', 'min:0'],
            'igd_pasien_doa' => ['required', 'integer', 'min:0'],
            'igd_pasien_sisrute' => ['required', 'integer', 'min:0'],
            'igd_pasien_sisrute_diterima' => ['required', 'integer', 'min:0'],
            'igd_dokterjaga' => ['required', 'array', 'min:1'],
            'igd_dokterjaga.*' => ['integer', 'exists:dokter,id,status,1,id_sdmk_jenis,1'],
            'igd_alasan' => ['nullable', 'string'],
            'igd_permasalahan' => ['nullable', 'string'],
            'igd_lainlain' => ['nullable', 'string'],
        ]);

        if($r->igd_pasien - $r->igd_pasien_rawat < 0){
            return redirect()->back()->with('fail-add', 'Jumlah kunjungan pasien tidak boleh LEBIH KECIL dari jumlah pasien rawat');
        }
        else if($r->igd_pasien - $r->igd_pasien_emergency < 0){
            return redirect()->back()->with('fail-add', 'Jumlah kunjungan pasien tidak boleh LEBIH KECIL dari jumlah pasien Emergency');
        }
        else if($r->igd_pasien_sisrute - $r->igd_pasien_sisrute_diterima < 0){
            return redirect()->back()->with('fail-add', 'Jumlah Rujukan SISRUTE tidak boleh LEBIH KECIL dari jumlah pasien SISRUTE yang diterima');
        }
        else{
            $sup = \App\Models\Laporanigd::where('id', $r->id)
                ->where('id_pengawas', \Auth::id())
                ->where('status', 0)
                ->firstOrFail();
            $sup->id_dokter = implode(',', $r->igd_dokterjaga);
            
            $sup->jumlah_pasien = $r->igd_pasien;
            $sup->jumlah_pasien_rawat = $r->igd_pasien_rawat ;	
            $sup->jumlah_pasien_pulang	= $r->igd_pasien - $r->igd_pasien_rawat;
            $sup->jumlah_pasien_emergency = $r->igd_pasien_emergency;	
            $sup->jumlah_pasien_non_emergency = $r->igd_pasien - $r->igd_pasien_emergency;
            $sup->jumlah_pasien_tidak_bisa_rawat= $r->igd_pasien_tidak_rawat ;
            // SISRUTE
            $sup->jumlah_pasien_sisrute= $r->igd_pasien_sisrute ;
            $sup->jumlah_pasien_sisrute_diterima= $r->igd_pasien_sisrute_diterima ;
            $sup->jumlah_pasien_sisrute_ditolak= $r->igd_pasien_sisrute - $r->igd_pasien_sisrute_diterima ;
            
            $sup->alasan_tidak_bisa_rawat= $r->igd_alasan ;	
            $sup->jumlah_pasien_doa= $r->igd_pasien_doa;	
            $sup->permasalahan = $r->igd_permasalahan ;
            $sup->lain_lain = $r->igd_lainlain ;
            $date = date_default_timezone_set('Asia/Jakarta');
            $sup->updated_at =  date('Y-m-d H:i:s');
            $sup->save();

            //log data
            $log = new \App\Models\Log;
            $log->id_user = \Auth::user()->id;
            $log->id_log_jenis = 1;
            $log->keterangan = 'Edit Draft';
            $log->created_at = date('Y-m-d H:i:s');
            $log->updated_at =  date('Y-m-d H:i:s');
            $log->save();

            return redirect()->back()->with('success-add', 'Berhasil mengubah data Draft Laporan IGD');
        }
    }

    public function deleteDraftlaporanIGD($id)
    {

        $sup = \App\Models\Laporanigd::where('id', $id)
            ->where('id_pengawas', \Auth::id())
            ->where('status', 0)
            ->firstOrFail();
        $sup->status = 2; //Delete Laporan
        $sup->save();

        //log data
        $log = new \App\Models\Log;
        $log->id_user = \Auth::user()->id;
        $log->id_log_jenis = 1;
        $log->keterangan = 'Hapus Draft';
        $log->created_at = date('Y-m-d H:i:s');
        $log->updated_at =  date('Y-m-d H:i:s');
        $log->save();

        return redirect()->back()->with('success-add', 'Berhasil menghapus data draf Laporan IGD');
    }

    //LAPORAN UMUM
    public function draftlaporanUmum(Request $r)
    {
        if(($r->inap_pasien_lama + $r->inap_pasien_baru - $r->inap_pasien_pindah + $r->inap_pasien_pindahan - $r->inap_pasien_meninggal - $r->inap_pasien_pulang) < 0){
            return redirect()->back()->with('fail-add', 'Total Pasien tidak boleh di bawah 0, Coba periksa ulang inputan Anda.');
        }
        else{
            $sup = new \App\Models\Laporanumum;
            $sup->id_pengawas = \Auth::user()->id;
            $sup->id_ruangan = $r->inap_ruangan;

            $sup->jumlah_pasien_lama = $r->inap_pasien_lama;
            $sup->jumlah_pasien_baru = $r->inap_pasien_baru;
            $sup->jumlah_pasien_pindah = $r->inap_pasien_pindah;
            $sup->jumlah_pasien_pindahan = $r->inap_pasien_pindahan;
            $sup->jumlah_pasien_meninggal = $r->inap_pasien_meninggal;
            $sup->jumlah_pasien_pulang = $r->inap_pasien_pulang;

            $sup->catatan_pasien_istimewa = $r->inap_catatan_istimewa;
            $sup->catatan_pasien_baru = $r->inap_catatan_baru;
            $sup->jumlah_pasien_covid = $r->inap_pasien_covid;
            $sup->jumlah_pasien_suspek_covid = $r->inap_pasien_suspect;
            $sup->jumlah_pasien_restrain = $r->inap_pasien_restrain;
            $sup->jumlah_pasien_perilaku_kekerasan = $r->inap_pasien_kekerasan;
            $sup->jumlah_pasien_keracunan = $r->inap_pasien_keracunan;
            $sup->jumlah_pasien_keterbatasan_bahasa = $r->inap_pasien_bahasa;
            $sup->jumlah_pasien_difabel = $r->inap_pasien_difabel;
            $sup->permasalahan_umum = $r->inap_permasalahan;
            
            $sup->jumlah_total_pasien = $r->inap_pasien_lama + $r->inap_pasien_baru - $r->inap_pasien_pindah + $r->inap_pasien_pindahan - $r->inap_pasien_meninggal - $r->inap_pasien_pulang;/// 
            
            $date = date_default_timezone_set('Asia/Jakarta');
            $sup->created_at = date('Y-m-d H:i:s');
            $sup->updated_at =  date('Y-m-d H:i:s');
            $sup->save();

            // Tambah Catatan Pasien
            $catatanpasien = \App\Models\Catatanpasien::where('id_pengawas',\Auth::user()->id)->where('id_ruangan',$r->inap_ruangan)->where('status',0)->update(['updated_at' => date('Y-m-d H:i:s'), 'id_laporan_umum' => \App\Models\Laporanumum::where('id_ruangan',$r->inap_ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('id')->last()]);

            //log data
            $log = new \App\Models\Log;
            $log->id_user = \Auth::user()->id;
            $log->id_log_jenis = 2;
            $log->keterangan = 'Tambah Draft';
            $log->created_at = date('Y-m-d H:i:s');
            $log->updated_at =  date('Y-m-d H:i:s');
            $log->save();

            return redirect()->back()->with('success-add', 'Berhasil menambah ke Draf Laporan Rawat Inap');
        }
    }

    public function editDraftlaporanUmum(Request $r)
    {
        if(($r->inap_pasien_lama + $r->inap_pasien_baru - $r->inap_pasien_pindah + $r->inap_pasien_pindahan - $r->inap_pasien_meninggal - $r->inap_pasien_pulang) < 0){
            return redirect()->back()->with('fail-add', 'Total Pasien tidak boleh di bawah 0, Coba periksa ulang inputan Anda.');
        }
        else{
            $sup = \App\Models\Laporanumum::where('id',$r->id)->first();
            $sup->id_pengawas = \Auth::user()->id;
            $sup->id_ruangan = $r->inap_ruangan;

            $sup->jumlah_pasien_lama = $r->inap_pasien_lama;
            $sup->jumlah_pasien_baru = $r->inap_pasien_baru;
            $sup->jumlah_pasien_pindah = $r->inap_pasien_pindah;
            $sup->jumlah_pasien_pindahan = $r->inap_pasien_pindahan;
            $sup->jumlah_pasien_meninggal = $r->inap_pasien_meninggal;
            $sup->jumlah_pasien_pulang = $r->inap_pasien_pulang;
            
            $sup->catatan_pasien_istimewa = $r->inap_catatan_istimewa;
            $sup->catatan_pasien_baru = $r->inap_catatan_baru;
            $sup->jumlah_pasien_covid = $r->inap_pasien_covid;
            $sup->jumlah_pasien_suspek_covid = $r->inap_pasien_suspect;
            $sup->jumlah_pasien_restrain = $r->inap_pasien_restrain;
            $sup->jumlah_pasien_perilaku_kekerasan = $r->inap_pasien_kekerasan;
            $sup->jumlah_pasien_keracunan = $r->inap_pasien_keracunan;
            $sup->jumlah_pasien_keterbatasan_bahasa = $r->inap_pasien_bahasa;
            $sup->jumlah_pasien_difabel = $r->inap_pasien_difabel;
            $sup->permasalahan_umum = $r->inap_permasalahan;
            
            $sup->jumlah_total_pasien = $r->inap_pasien_lama + $r->inap_pasien_baru - $r->inap_pasien_pindah + $r->inap_pasien_pindahan - $r->inap_pasien_meninggal - $r->inap_pasien_pulang;/// 
            
            $date = date_default_timezone_set('Asia/Jakarta');
            $sup->created_at = date('Y-m-d H:i:s');
            $sup->updated_at =  date('Y-m-d H:i:s');
            $sup->save();

             // Edit Catatan Pasien
             $catatanpasien = \App\Models\Catatanpasien::where('id_pengawas',\Auth::user()->id)->where('id_ruangan',$r->inap_ruangan)->where('status',0)->update(['updated_at' => date('Y-m-d H:i:s'), 'id_laporan_umum' => \App\Models\Laporanumum::where('id_ruangan',$r->inap_ruangan)->where('id_pengawas',\Auth::user()->id)->pluck('id')->last()]);


            //log data
            $log = new \App\Models\Log;
            $log->id_user = \Auth::user()->id;
            $log->id_log_jenis = 2;
            $log->keterangan = 'Edit Draft';
            $log->created_at = date('Y-m-d H:i:s');
            $log->updated_at =  date('Y-m-d H:i:s');
            $log->save();

            return redirect()->back()->with('success-add', 'Berhasil mengubah data Draf Laporan Rawat Inap');
        }
    }

    public function deleteDraftlaporanUmum($id)
    {

        $sup = \App\Models\Laporanumum::where('id',$id)->first();
        $sup->status = 2; //Delete Laporan
        $sup->save();

         // Hapus Catatan Pasien
         $catatanpasien = \App\Models\Catatanpasien::where('id_pengawas',\Auth::user()->id)->where('id_laporan_umum',$id)->update(['updated_at' => date('Y-m-d H:i:s'), 'status' => 2]);


        //log data
        $log = new \App\Models\Log;
        $log->id_user = \Auth::user()->id;
        $log->id_log_jenis = 2;
        $log->keterangan = 'Hapus Draft';
        $log->created_at = date('Y-m-d H:i:s');
        $log->updated_at =  date('Y-m-d H:i:s');
        $log->save();

        return redirect()->back()->with('success-add', 'Berhasil menghapus data Draf Laporan Rawat Inap');
    }



    //IRJ
    public function tambahirjdetail(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'id_dokter_irj' => ['required', 'integer', 'exists:dokter_irj,id'],
            'pasien_lama' => ['required', 'integer', 'min:0'],
            'pasien_baru' => ['required', 'integer', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        if (!\App\Models\Dokterirj::whereKey($r->integer('id_dokter_irj'))->where('status', 1)->exists()) {
            return response()->json(['success' => false, 'message' => 'Dokter yang dipilih tidak aktif atau tidak tersedia.']);
        }

        if (\App\Models\Laporanirjdetail::where('id_pengawas', \Auth::id())->where('status', 0)->where('id_dokter_irj', $r->integer('id_dokter_irj'))->exists()) {
            return response()->json(['success' => false, 'message' => 'Data pasien untuk dokter tersebut sudah ada.']);
        }

                $sup = new \App\Models\Laporanirjdetail();
                $sup->id_dokter_irj = $r->integer('id_dokter_irj');
                $sup->id_pengawas = \Auth::id();
                $sup->pasien_lama = $r->integer('pasien_lama');
                $sup->pasien_baru = $r->integer('pasien_baru');
                $sup->pasien_total = $sup->pasien_lama + $sup->pasien_baru;
                $sup->pasien_rawat = 0;
                $date = date_default_timezone_set('Asia/Jakarta');
                $sup->created_at = date('Y-m-d H:i:s');
                $sup->updated_at =  date('Y-m-d H:i:s');
                $sup->save();

                //log data
                $log = new \App\Models\Log;
                $log->id_user = \Auth::user()->id;
                $log->id_log_jenis = 4;
                $log->keterangan = 'Tambah Data Keterangan menurut Dokter IRJ';
                $log->created_at = date('Y-m-d H:i:s');
                $log->updated_at =  date('Y-m-d H:i:s');
                $log->save();
        
                return response()->json(
                    [
                    'success' => true,
                    'message' => 'Berhasil menambah data keterangan pasien menurut dokter'
                    ]
            );
    }
  
    public function editirjdetail(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'id' => ['required', 'integer'],
            'id_dokter_irj' => ['required', 'integer', 'exists:dokter_irj,id'],
            'pasien_lama' => ['required', 'integer', 'min:0'],
            'pasien_baru' => ['required', 'integer', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        $sup = \App\Models\Laporanirjdetail::whereKey($r->integer('id'))->where('id_pengawas', \Auth::id())->where('status', 0)->first();
        if (!$sup) {
            return response()->json(['success' => false, 'message' => 'Data IRJ tidak ditemukan atau tidak dapat diubah.']);
        }

        if (!\App\Models\Dokterirj::whereKey($r->integer('id_dokter_irj'))->where('status', 1)->exists()) {
            return response()->json(['success' => false, 'message' => 'Dokter yang dipilih tidak aktif atau tidak tersedia.']);
        }

        if (\App\Models\Laporanirjdetail::where('id_pengawas', \Auth::id())->where('status', 0)->where('id_dokter_irj', $r->integer('id_dokter_irj'))->whereKeyNot($sup->id)->exists()) {
            return response()->json(['success' => false, 'message' => 'Data pasien untuk dokter tersebut sudah ada.']);
        }

            $sup->id_dokter_irj = $r->integer('id_dokter_irj');
            $sup->pasien_lama = $r->integer('pasien_lama');
            $sup->pasien_baru = $r->integer('pasien_baru');
            $sup->pasien_total = $sup->pasien_lama + $sup->pasien_baru;
            $date = date_default_timezone_set('Asia/Jakarta');
            $sup->updated_at =  date('Y-m-d H:i:s');
            $sup->save();
    
            //log data
            $log = new \App\Models\Log;
            $log->id_user = \Auth::user()->id;
            $log->id_log_jenis = 4;
            $log->keterangan = 'Edit Data Keterangan menurut Dokter IRJ';
            $log->created_at = date('Y-m-d H:i:s');
            $log->updated_at =  date('Y-m-d H:i:s');
            $log->save();
      
            return response()->json(
                [
                  'success' => true,
                  'message' => 'Berhasil mengubah data keterangan pasien menurut dokter'
                ]
           );
    }
  
    public function deleteirjdetail(Request $r)
    {
      $sup = \App\Models\Laporanirjdetail::whereKey($r->integer('id'))->where('id_pengawas', \Auth::id())->where('status', 0)->first();
      if (!$sup) {
          return response()->json(['success' => false, 'message' => 'Data IRJ tidak ditemukan atau tidak dapat dihapus.']);
      }

      $sup->delete();
    
      //log data
      $log = new \App\Models\Log;
      $log->id_user = \Auth::user()->id;
      $log->id_log_jenis = 4;
      $log->keterangan = 'Hapus Data Keterangan menurut Dokter IRJ';
      $log->created_at = date('Y-m-d H:i:s');
      $log->updated_at =  date('Y-m-d H:i:s');
      $log->save();

      return response()->json(
        [
          'success' => true,
          'message' => 'Berhasil menghapus data keterangan pasien menurut dokter'
        ]
        );
    }
  


    public function draftlaporanIRJ(Request $r){
        $sp = \App\Models\Laporanirjdetail::where('id_pengawas',\Auth::user()->id)->where('status',0)->first();
 
        if (!$sp) {
          return redirect()->back()->with('fail-add', 'Jumlah pasien menurut Dokter masih kosong, silahkan isi terlebih dahulu');
        } else {
            $sup = new \App\Models\Laporanirj;
            $sup->id_pengawas = \Auth::user()->id;
            $sup->masalah = $r->irj_masalah;
            $sup->langkah_atasi_masalah = $r->irj_langkah;
            $date = date_default_timezone_set('Asia/Jakarta');
            $sup->created_at = date('Y-m-d H:i:s');
            $sup->updated_at =  date('Y-m-d H:i:s');
            $sup->save();

            //log data
            $log = new \App\Models\Log;
            $log->id_user = \Auth::user()->id;
            $log->id_log_jenis = 3;
            $log->keterangan = 'Tambah Draft';
            $log->created_at = date('Y-m-d H:i:s');
            $log->updated_at =  date('Y-m-d H:i:s');
            $log->save();

        return redirect()->back()->with('success-add', 'Berhasil menambah ke Draft Laporan IRJ');
        }

    }
    public function editDraftlaporanIRJ(Request $r){
        $sp = \App\Models\Laporanirjdetail::where('id_pengawas',\Auth::user()->id)->where('status',0)->first();
 
        if (!$sp) {
          return redirect()->back()->with('fail-add', 'Jumlah pasien menurut Dokter masih kosong, silahkan isi terlebih dahulu');
        } else {
            $sup = \App\Models\Laporanirj::where('id',$r->id)->first();
            $sup->id_pengawas = \Auth::user()->id;
            $sup->masalah = $r->irj_masalah;
            $sup->langkah_atasi_masalah = $r->irj_langkah;
            
            $date = date_default_timezone_set('Asia/Jakarta');
            $sup->updated_at =  date('Y-m-d H:i:s');
            $sup->save();

            //log data
            $log = new \App\Models\Log;
            $log->id_user = \Auth::user()->id;
            $log->id_log_jenis = 3;
            $log->keterangan = 'Edit Draft';
            $log->created_at = date('Y-m-d H:i:s');
            $log->updated_at =  date('Y-m-d H:i:s');
            $log->save();

            return redirect()->back()->with('success-add', 'Berhasil menambah ke Draft Laporan IRJ');
        }
    }
    public function deleteDraftlaporanIRJ($id){
        $sup = \App\Models\Laporanirj::where('id',$id)->first();
        $sup->status = 2; //Delete Laporan
        $sup->save();

        //hapus detail
        \App\Models\Laporanirjdetail::where('status', 0)->where('id_pengawas',\Auth::user()->id)->delete();

        //log data
        $log = new \App\Models\Log;
        $log->id_user = \Auth::user()->id;
        $log->id_log_jenis = 3;
        $log->keterangan = 'Hapus Draft';
        $log->created_at = date('Y-m-d H:i:s');
        $log->updated_at =  date('Y-m-d H:i:s');
        $log->save();

        return redirect()->back()->with('success-add', 'Berhasil menghapus data draf Laporan IRJ');
    }


    //IBS
    public function tambahibsdetail(Request $r)
    {
        if( $r->nama == '' || $r->rm == '' || $r->id_dokter_operasi == '' || $r->id_dokter_anestesi == '' || $r->id_ruangan=='' || $r->jam_mulai=='' || $r->jam_selesai=='' || $r->diagnosapre=='' || $r->diagnosapost=='')
        {
            return response()->json(
                [
                  'success' => false,
                  'message' => 'Lengkapi data terlebih dahulu'
                ]
           );
        }
        else{
                $sup = new \App\Models\Laporanibsdetail();
                $sup->id_pengawas =\Auth::user()->id;
                $sup->nama = $r->nama;
                $sup->rm = $r->rm;
                $sup->id_dokter_operasi = implode(",",$r->id_dokter_operasi);
                $sup->id_dokter_anestesi = $r->id_dokter_anestesi;
                $sup->pendamping = $r->pendamping;
                $sup->id_ruangan = $r->id_ruangan;
                $sup->jam_mulai = $r->jam_mulai;
                $sup->jam_selesai = $r->jam_selesai;
                $sup->diagnosa_pre = $r->diagnosapre;
                $sup->diagnosa_post = $r->diagnosapost;

                $date = date_default_timezone_set('Asia/Jakarta');
                $sup->created_at = date('Y-m-d H:i:s');
                $sup->updated_at =  date('Y-m-d H:i:s');
                $sup->save();

                //log data
                $log = new \App\Models\Log;
                $log->id_user = \Auth::user()->id;
                $log->id_log_jenis = 17;
                $log->keterangan = 'Tambah Data Keterangan menurut Dokter IBS';
                $log->created_at = date('Y-m-d H:i:s');
                $log->updated_at =  date('Y-m-d H:i:s');
                $log->save();
        
                return response()->json(
                    [
                    'success' => true,
                    'message' => 'Berhasil menambah data keterangan pasien operasi menurut dokter'
                    ]
            );
        }
            
    }
  
    public function editibsdetail(Request $r)
    {
 
        if( $r->nama == '' || $r->rm == '' || $r->id_dokter_operasi == '' || $r->id_dokter_anestesi == '' || $r->id_ruangan=='' || $r->jam_mulai=='' || $r->jam_selesai=='' || $r->diagnosapre=='' || $r->diagnosapost=='')
        {
            return response()->json(
                [
                  'success' => false,
                  'message' => 'Lengkapi data terlebih dahulu'
                ]
           );
        }
        
        else{
            $sup = \App\Models\Laporanibsdetail::where('id', $r->id)->first();
            $sup->id_pengawas =\Auth::user()->id;
            $sup->nama = $r->nama;
            $sup->rm = $r->rm;
            $sup->id_dokter_operasi = implode(",",$r->id_dokter_operasi);
            $sup->id_dokter_anestesi = $r->id_dokter_anestesi;
            $sup->pendamping = $r->pendamping;
            $sup->id_ruangan = $r->id_ruangan;
            $sup->jam_mulai = $r->jam_mulai;
            $sup->jam_selesai = $r->jam_selesai;
            $sup->diagnosa_pre = $r->diagnosapre;
            $sup->diagnosa_post = $r->diagnosapost;
            $date = date_default_timezone_set('Asia/Jakarta');
            $sup->updated_at =  date('Y-m-d H:i:s');
            $sup->save();
    
            //log data
            $log = new \App\Models\Log;
            $log->id_user = \Auth::user()->id;
            $log->id_log_jenis = 17;
            $log->keterangan = 'Edit Data Keterangan menurut Dokter IBS';
            $log->created_at = date('Y-m-d H:i:s');
            $log->updated_at =  date('Y-m-d H:i:s');
            $log->save();
      
            return response()->json(
                [
                  'success' => true,
                  'message' => 'Berhasil mengubah data keterangan pasien menurut dokter IBS'
                ]
           );
        }
        
      
    }
  
    public function deleteibsdetail(Request $r)
    {
  
      $sup = \App\Models\Laporanibsdetail::where('id', $r->id)->first()->delete();
    
      //log data
      $log = new \App\Models\Log;
      $log->id_user = \Auth::user()->id;
      $log->id_log_jenis = 17;
      $log->keterangan = 'Hapus Data Keterangan menurut Dokter IBS';
      $log->created_at = date('Y-m-d H:i:s');
      $log->updated_at =  date('Y-m-d H:i:s');
      $log->save();

      return response()->json(
        [
          'success' => true,
          'message' => 'Berhasil menghapus data keterangan pasien menurut dokter IBS'
        ]
        );
    }
  


    public function draftlaporanIBS(Request $r){
        $sp = \App\Models\Laporanibsdetail::where('id_pengawas',\Auth::user()->id)->where('status',0)->first();
 
        if (!$sp) {
          return redirect()->back()->with('fail-add', 'Jumlah pasien menurut Dokter IBS masih kosong, silahkan isi terlebih dahulu');
        } else {
            $sup = new \App\Models\Laporanibs;
            $sup->id_pengawas = \Auth::user()->id;
            $sup->total_pasien = \App\Models\Laporanibsdetail::where('id_pengawas',\Auth::user()->id)->where('status',0)->count();
            $sup->catatan = $r->ibs_catatan;
            $date = date_default_timezone_set('Asia/Jakarta');
            $sup->created_at = date('Y-m-d H:i:s');
            $sup->updated_at =  date('Y-m-d H:i:s');
            $sup->save();

            //log data
            $log = new \App\Models\Log;
            $log->id_user = \Auth::user()->id;
            $log->id_log_jenis = 16;
            $log->keterangan = 'Tambah Draft';
            $log->created_at = date('Y-m-d H:i:s');
            $log->updated_at =  date('Y-m-d H:i:s');
            $log->save();

        return redirect()->back()->with('success-add', 'Berhasil menambah ke Draft Laporan IBS');
        }

    }
    public function editDraftlaporanIBS(Request $r){
        $sp = \App\Models\Laporanibsdetail::where('id_pengawas',\Auth::user()->id)->where('status',0)->first();
 
        if (!$sp) {
          return redirect()->back()->with('fail-add', 'Jumlah pasien menurut Dokter IBS masih kosong, silahkan isi terlebih dahulu');
        } else {
            $sup = \App\Models\Laporanibs::where('id',$r->idibs)->first();
            $sup->id_pengawas = \Auth::user()->id;
            $sup->total_pasien = \App\Models\Laporanibsdetail::where('id_pengawas',\Auth::user()->id)->where('status',0)->count();
            $sup->catatan = $r->ibs_catatan;
            
            $date = date_default_timezone_set('Asia/Jakarta');
            $sup->updated_at =  date('Y-m-d H:i:s');
            $sup->save();

            //log data
            $log = new \App\Models\Log;
            $log->id_user = \Auth::user()->id;
            $log->id_log_jenis = 16;
            $log->keterangan = 'Edit Draft';
            $log->created_at = date('Y-m-d H:i:s');
            $log->updated_at =  date('Y-m-d H:i:s');
            $log->save();

            return redirect()->back()->with('success-add', 'Berhasil menambah ke Draft Laporan IBS');
        }
    }
    public function deleteDraftlaporanIBS($id){
        $sup = \App\Models\Laporanibs::where('id',$id)->first();
        $sup->status = 2; //Delete Laporan
        $sup->save();

        //hapus detail
        \App\Models\Laporanibsdetail::where('status', 0)->where('id_pengawas',\Auth::user()->id)->delete();

        //log data
        $log = new \App\Models\Log;
        $log->id_user = \Auth::user()->id;
        $log->id_log_jenis = 16;
        $log->keterangan = 'Hapus Draft';
        $log->created_at = date('Y-m-d H:i:s');
        $log->updated_at =  date('Y-m-d H:i:s');
        $log->save();

        return redirect()->back()->with('success-add', 'Berhasil menghapus data draf Laporan IBS');
    }

    // Catatan PASIEN

    public function tambahcatatanpasien(Request $r)
    {
        if( $r->kamar == '' || $r->nama == '' || $r->rm == '' || $r->diagnosa == '' || $r->dpjp=='' || $r->kondisi=='' || $r->jenis_pasien==''|| $r->ruangan=='')
        {
            return response()->json(
                [
                  'success' => false,
                  'message' => 'Lengkapi data terlebih dahulu'
                ]
           );
        }
        else{
                $sup = new \App\Models\Catatanpasien();
                $sup->id_pengawas =\Auth::user()->id;

                if(\App\Models\Laporanumum::where('id_ruangan',$r->ruangan)->where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('id')->last())
                {
                    $sup->id_laporan_umum = \App\Models\Laporanumum::where('id_ruangan',$r->ruangan)->where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('id')->last();
                }

                $sup->id_jenis_pasien = $r->jenis_pasien;
                $sup->id_ruangan = $r->ruangan;
                $sup->kamar = $r->kamar;
                $sup->nama = $r->nama;
                $sup->rm = $r->rm;
                $sup->diagnosa = $r->diagnosa;
                $sup->dpjp = $r->dpjp;
                $sup->kondisi = $r->kondisi;
              
                $date = date_default_timezone_set('Asia/Jakarta');
                $sup->created_at = date('Y-m-d H:i:s');
                $sup->updated_at =  date('Y-m-d H:i:s');
                $sup->save();

                //log data
                $log = new \App\Models\Log;
                $log->id_user = \Auth::user()->id;
                $log->id_log_jenis = 18;
                $log->keterangan = 'Tambah Catatan Pasien '.\App\Models\Jenispasien::where('id',$r->jenis_pasien)->pluck('jenis')->first();
                $log->created_at = date('Y-m-d H:i:s');
                $log->updated_at =  date('Y-m-d H:i:s');
                $log->save();
        
                return response()->json(
                    [
                    'success' => true,
                    'message' => 'Berhasil menambah data Catatan Pasien '.\App\Models\Jenispasien::where('id',$r->jenis_pasien)->pluck('jenis')->first()
                    ]
            );
        }
            
    }
  
    public function editcatatanpasien(Request $r)
    {
 
        if( $r->kamar == '' || $r->nama == '' || $r->rm == '' || $r->diagnosa == '' || $r->dpjp=='' || $r->kondisi=='' || $r->jenis_pasien==''|| $r->ruangan=='')
        {
            return response()->json(
                [
                  'success' => false,
                  'message' => 'Lengkapi data terlebih dahulu'
                ]
           );
        }
        
        else{
            $sup = \App\Models\Catatanpasien::where('id', $r->id)->first();
            $sup->id_pengawas =\Auth::user()->id;

            if(\App\Models\Laporanumum::where('id_ruangan',$r->ruangan)->where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('id')->last())
            {
                $sup->id_laporan_umum = \App\Models\Laporanumum::where('id_ruangan',$r->ruangan)->where('status',0)->where('id_pengawas',\Auth::user()->id)->pluck('id')->last();
            }

            $sup->id_jenis_pasien = $r->jenis_pasien;
            $sup->id_ruangan = $r->ruangan;
            $sup->kamar = $r->kamar;
            $sup->nama = $r->nama;
            $sup->rm = $r->rm;
            $sup->diagnosa = $r->diagnosa;
            $sup->dpjp = $r->dpjp;
            $sup->kondisi = $r->kondisi;
            $date = date_default_timezone_set('Asia/Jakarta');
            $sup->updated_at =  date('Y-m-d H:i:s');
            $sup->save();
    
            //log data
            $log = new \App\Models\Log;
            $log->id_user = \Auth::user()->id;
            $log->id_log_jenis = 18;
            $log->keterangan = 'Ubah Catatan Pasien '.\App\Models\Jenispasien::where('id',$r->jenis_pasien)->pluck('jenis')->first();
            $log->created_at = date('Y-m-d H:i:s');
            $log->updated_at =  date('Y-m-d H:i:s');
            $log->save();
    
            return response()->json(
                [
                'success' => true,
                'message' => 'Berhasil mengubah data Catatan Pasien '.\App\Models\Jenispasien::where('id',$r->jenis_pasien)->pluck('jenis')->first()
                ]
           );
        }
        
      
    }
  
    public function deletecatatanpasien(Request $r)
    {
  
      $sup = \App\Models\Catatanpasien::where('id', $r->id)->first()->delete();
    
      //log data
      $log = new \App\Models\Log;
      $log->id_user = \Auth::user()->id;
      $log->id_log_jenis = 18;
      $log->keterangan = 'Hapus Data Catatan Pasien '.\App\Models\Jenispasien::where('id',$r->jenis_pasien)->pluck('jenis')->first();
      $log->created_at = date('Y-m-d H:i:s');
      $log->updated_at =  date('Y-m-d H:i:s');
      $log->save();

      return response()->json(
        [
          'success' => true,
          'message' => 'Berhasil menghapus data Catatan Pasien '.\App\Models\Jenispasien::where('id',$r->jenis_pasien)->pluck('jenis')->first()
        ]
        );
    }

    public function kirimLaporan(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'dinas' => ['required', 'integer', 'exists:dinas,id'],
            'signed' => ['required', 'string', 'regex:/^data:image\/(png|jpeg);base64,/'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('fail-add', $validator->errors()->first());
        }

        $userId = \Auth::id();
        $igd = \App\Models\Laporanigd::where('status', 0)->where('id_pengawas', $userId)->first();
        $activeRoomIds = \App\Models\Ruangan::where('status', 1)->pluck('id');
        $visitedRoomIds = \App\Models\Laporanumum::where('status', 0)
            ->where('id_pengawas', $userId)
            ->whereIn('id_ruangan', $activeRoomIds)
            ->distinct()
            ->pluck('id_ruangan');

        if (!$igd || $activeRoomIds->diff($visitedRoomIds)->isNotEmpty()) {
            return redirect()->back()->with('fail-add', 'Laporan belum dapat dikirim. Lengkapi laporan IGD dan seluruh Ruangan (Rawat Inap) aktif terlebih dahulu.');
        }

        $folderPath = public_path('signature/');
        File::ensureDirectoryExists($folderPath);
        $image_parts = explode(";base64,", $r->signed);
        if (count($image_parts) !== 2) {
            return redirect()->back()->with('fail-add', 'Format tanda tangan tidak valid. Silakan tanda tangani kembali.');
        }
        $image_type_aux = explode("image/", $image_parts[0]);
        if (count($image_type_aux) !== 2) {
            return redirect()->back()->with('fail-add', 'Format tanda tangan tidak valid. Silakan tanda tangani kembali.');
        }
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        if ($image_base64 === false) {
            return redirect()->back()->with('fail-add', 'Tanda tangan tidak dapat diproses. Silakan tanda tangani kembali.');
        }
        $namafile = uniqid() . '.'.$image_type;
        $file = $folderPath . $namafile;
        if (file_put_contents($file, $image_base64) === false) {
            return redirect()->back()->with('fail-add', 'Tanda tangan gagal disimpan. Silakan coba kembali.');
        }

        DB::transaction(function () use ($r, $userId, $igd, $namafile) {
        date_default_timezone_set('Asia/Jakarta');
        $sup = new \App\Models\Laporan;
        $sup->id_pengawas = $userId;
        $sup->id_dinas = $r->dinas;
        $sup->signature = $namafile;
        $sup->created_at = date('Y-m-d H:i:s');
        $sup->updated_at = date('Y-m-d H:i:s');
        $sup->save();
        $laporanId = $sup->id;

        //Update Laporan IGD
        $igd->id_laporan = $laporanId;
        $igd->status = 1;
        
        $igd->updated_at = date('Y-m-d H:i:s');
        $igd->save();

        //Update Laporan Umum
        $umum = \App\Models\Laporanumum::where('id_pengawas',$userId)->where('status',0)->update(['id_laporan' => $laporanId, 'updated_at' => date('Y-m-d H:i:s'), 'status' => 1]);
        $catatanpasien = \App\Models\Catatanpasien::where('id_pengawas',$userId)->where('status',0)->update(['updated_at' => date('Y-m-d H:i:s'), 'status' => 1]);
        //Update Laporan IRJ
        $irj = \App\Models\Laporanirj::where('id_pengawas',$userId)->where('status',0)->update(['id_laporan' => $laporanId, 'updated_at' => date('Y-m-d H:i:s'), 'status' => 1]);
        $irjdetail = \App\Models\Laporanirjdetail::where('id_pengawas',$userId)->where('status',0)->update(['id_laporan_irj' => \App\Models\Laporanirj::where('id_pengawas',$userId)->pluck('id')->last(), 'status' => 1]);

        //Update Laporan IBS
        $ibs = \App\Models\Laporanibs::where('id_pengawas',$userId)->where('status',0)->update(['id_laporan' => $laporanId, 'updated_at' => date('Y-m-d H:i:s'), 'status' => 1]);
        $ibsdetail = \App\Models\Laporanibsdetail::where('id_pengawas',$userId)->where('status',0)->update(['id_laporan_ibs' => \App\Models\Laporanibs::where('id_pengawas',$userId)->pluck('id')->last(), 'status' => 1]);


        //log data
        $log = new \App\Models\Log;
        $log->id_user = $userId;
        $log->id_log_jenis = 5;
        $log->keterangan = 'Kirim Laporan ke Direktur untuk diverifikasi';
        $log->created_at = date('Y-m-d H:i:s');
        $log->updated_at =  date('Y-m-d H:i:s');
        $log->save();
        });

        return redirect()->back()->with('success-add', 'Berhasil Submit Laporan Pengawas Umum');
    }
}
