<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
    public function draftlaporanIGD(Request $r, \App\Services\PengawasIgdService $igdService)
    {
        $validated = $r->validate([
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

        $result = $igdService->createDraft($validated);

        if (!$result['success']) {
            return redirect()->back()->with('fail-add', $result['message']);
        }

        return redirect()->back()->with('success-add', $result['message']);
    }

    public function editDraftlaporanIGD(Request $r, \App\Services\PengawasIgdService $igdService)
    {
        $validated = $r->validate([
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

        $result = $igdService->updateDraft($validated);

        if (!$result['success']) {
            return redirect()->back()->with('fail-add', $result['message']);
        }

        return redirect()->back()->with('success-add', $result['message']);
    }

    public function deleteDraftlaporanIGD($id, \App\Services\PengawasIgdService $igdService)
    {
        $result = $igdService->deleteDraft((int) $id);

        return redirect()->back()->with('success-add', $result['message']);
    }

    //LAPORAN UMUM
    public function draftlaporanUmum(Request $r, \App\Services\PengawasUmumService $umumService)
    {
        $validated = $r->validate([
            'inap_ruangan' => ['required', 'integer', 'exists:ruangan,id,status,1'],
            'inap_pasien_baru' => ['required', 'integer', 'min:0'],
            'inap_pasien_pindah' => ['required', 'integer', 'min:0'],
            'inap_pasien_pindahan' => ['required', 'integer', 'min:0'],
            'inap_pasien_meninggal' => ['required', 'integer', 'min:0'],
            'inap_pasien_pulang' => ['required', 'integer', 'min:0'],
            'inap_pasien_covid' => ['nullable', 'integer', 'min:0'],
            'inap_pasien_suspect' => ['nullable', 'integer', 'min:0'],
            'inap_pasien_restrain' => ['nullable', 'integer', 'min:0'],
            'inap_pasien_kekerasan' => ['nullable', 'integer', 'min:0'],
            'inap_pasien_keracunan' => ['nullable', 'integer', 'min:0'],
            'inap_pasien_bahasa' => ['nullable', 'integer', 'min:0'],
            'inap_pasien_difabel' => ['nullable', 'integer', 'min:0'],
            'inap_catatan_istimewa' => ['nullable', 'string', 'max:5000'],
            'inap_catatan_baru' => ['nullable', 'string', 'max:5000'],
            'inap_permasalahan' => ['nullable', 'string', 'max:5000'],
        ], [
            'inap_pasien_baru.required' => 'Jumlah pasien baru wajib diisi.',
            'inap_pasien_pindah.required' => 'Jumlah pasien pindah wajib diisi.',
            'inap_pasien_pindahan.required' => 'Jumlah pasien pindahan wajib diisi.',
            'inap_pasien_meninggal.required' => 'Jumlah pasien meninggal wajib diisi.',
            'inap_pasien_pulang.required' => 'Jumlah pasien pulang wajib diisi.',
        ]);

        $result = $umumService->createDraft($validated);

        if (!$result['success']) {
            return redirect()->back()->with('fail-add', $result['message']);
        }

        return redirect()->back()->with('success-add', $result['message']);
    }

    public function editDraftlaporanUmum(Request $r, \App\Services\PengawasUmumService $umumService)
    {
        $validated = $r->validate([
            'id' => ['required', 'integer'],
            'inap_ruangan' => ['required', 'integer', 'exists:ruangan,id,status,1'],
            'inap_pasien_baru' => ['required', 'integer', 'min:0'],
            'inap_pasien_pindah' => ['required', 'integer', 'min:0'],
            'inap_pasien_pindahan' => ['required', 'integer', 'min:0'],
            'inap_pasien_meninggal' => ['required', 'integer', 'min:0'],
            'inap_pasien_pulang' => ['required', 'integer', 'min:0'],
            'inap_pasien_covid' => ['nullable', 'integer', 'min:0'],
            'inap_pasien_suspect' => ['nullable', 'integer', 'min:0'],
            'inap_pasien_restrain' => ['nullable', 'integer', 'min:0'],
            'inap_pasien_kekerasan' => ['nullable', 'integer', 'min:0'],
            'inap_pasien_keracunan' => ['nullable', 'integer', 'min:0'],
            'inap_pasien_bahasa' => ['nullable', 'integer', 'min:0'],
            'inap_pasien_difabel' => ['nullable', 'integer', 'min:0'],
            'inap_catatan_istimewa' => ['nullable', 'string', 'max:5000'],
            'inap_catatan_baru' => ['nullable', 'string', 'max:5000'],
            'inap_permasalahan' => ['nullable', 'string', 'max:5000'],
        ], [
            'inap_pasien_baru.required' => 'Jumlah pasien baru wajib diisi.',
            'inap_pasien_pindah.required' => 'Jumlah pasien pindah wajib diisi.',
            'inap_pasien_pindahan.required' => 'Jumlah pasien pindahan wajib diisi.',
            'inap_pasien_meninggal.required' => 'Jumlah pasien meninggal wajib diisi.',
            'inap_pasien_pulang.required' => 'Jumlah pasien pulang wajib diisi.',
        ]);

        $result = $umumService->updateDraft($validated);

        if (!$result['success']) {
            return redirect()->back()->with('fail-add', $result['message']);
        }

        return redirect()->back()->with('success-add', $result['message']);
    }

    public function deleteDraftlaporanUmum($id, \App\Services\PengawasUmumService $umumService)
    {
        $result = $umumService->deleteDraft((int) $id);
        
        return redirect()->back()->with('success-add', $result['message']);
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
  


    public function draftlaporanIRJ(Request $r, \App\Services\PengawasIrjService $irjService){
        $result = $irjService->createDraft($r->all());

        if (!$result['success']) {
            return redirect()->back()->with('fail-add', $result['message']);
        }

        return redirect()->back()->with('success-add', $result['message']);
    }
    public function editDraftlaporanIRJ(Request $r, \App\Services\PengawasIrjService $irjService){
        $result = $irjService->updateDraft($r->all());

        if (!$result['success']) {
            return redirect()->back()->with('fail-add', $result['message']);
        }

        return redirect()->back()->with('success-add', $result['message']);
    }
    public function deleteDraftlaporanIRJ($id, \App\Services\PengawasIrjService $irjService){
        $result = $irjService->deleteDraft((int) $id);
        
        return redirect()->back()->with('success-add', $result['message']);
    }


    //IBS
    public function tambahibsdetail(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'nama' => ['required', 'string', 'max:1000'],
            'rm' => ['required', 'string', 'max:1000'],
            'id_dokter_operasi' => ['required', 'array', 'min:1'],
            'id_dokter_operasi.*' => ['integer', 'distinct', 'exists:dokter_irj,id,status,1'],
            'id_dokter_anestesi' => ['required', 'integer', 'exists:dokter_irj,id,status,1,id_sdmk_jenis,8'],
            'id_ruangan' => ['required', 'integer', 'exists:ruangan,id,status,1'],
            'pendamping' => ['required', 'string', 'max:1000'],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after_or_equal:jam_mulai'],
            'diagnosapre' => ['required', 'string', 'max:5000'],
            'diagnosapost' => ['required', 'string', 'max:5000'],
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $validated = $validator->validated();
        if (\App\Models\Laporanibsdetail::where('id_pengawas', \Auth::id())
            ->where('status', 0)
            ->where('nama', $validated['nama'])
            ->where('rm', $validated['rm'])
            ->exists()) {
            return response()->json(['success' => false, 'message' => 'Data pasien IBS dengan nama dan RM tersebut sudah ada.'], 422);
        }

        {
                $sup = new \App\Models\Laporanibsdetail();
                $sup->id_pengawas =\Auth::user()->id;
                $sup->nama = $validated['nama'];
                $sup->rm = $validated['rm'];
                $sup->id_dokter_operasi = implode(',', $validated['id_dokter_operasi']);
                $sup->id_dokter_anestesi = $validated['id_dokter_anestesi'];
                $sup->pendamping = $validated['pendamping'];
                $sup->id_ruangan = $validated['id_ruangan'];
                $sup->jam_mulai = $validated['jam_mulai'];
                $sup->jam_selesai = $validated['jam_selesai'];
                $sup->diagnosa_pre = $validated['diagnosapre'];
                $sup->diagnosa_post = $validated['diagnosapost'];

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
        $validator = Validator::make($r->all(), [
            'id' => ['required', 'integer'],
            'nama' => ['required', 'string', 'max:1000'],
            'rm' => ['required', 'string', 'max:1000'],
            'id_dokter_operasi' => ['required', 'array', 'min:1'],
            'id_dokter_operasi.*' => ['integer', 'distinct', 'exists:dokter_irj,id,status,1'],
            'id_dokter_anestesi' => ['required', 'integer', 'exists:dokter_irj,id,status,1,id_sdmk_jenis,8'],
            'id_ruangan' => ['required', 'integer', 'exists:ruangan,id,status,1'],
            'pendamping' => ['required', 'string', 'max:1000'],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after_or_equal:jam_mulai'],
            'diagnosapre' => ['required', 'string', 'max:5000'],
            'diagnosapost' => ['required', 'string', 'max:5000'],
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $validated = $validator->validated();
        {
            $sup = \App\Models\Laporanibsdetail::whereKey($r->integer('id'))
                ->where('id_pengawas', \Auth::id())
                ->where('status', 0)
                ->firstOrFail();
            $duplicate = \App\Models\Laporanibsdetail::where('id_pengawas', \Auth::id())
                ->where('status', 0)
                ->where('nama', $validated['nama'])
                ->where('rm', $validated['rm'])
                ->whereKeyNot($sup->id)
                ->exists();
            if ($duplicate) {
                return response()->json(['success' => false, 'message' => 'Data pasien IBS dengan nama dan RM tersebut sudah ada.'], 422);
            }
            $sup->nama = $validated['nama'];
            $sup->rm = $validated['rm'];
            $sup->id_dokter_operasi = implode(',', $validated['id_dokter_operasi']);
            $sup->id_dokter_anestesi = $validated['id_dokter_anestesi'];
            $sup->pendamping = $validated['pendamping'];
            $sup->id_ruangan = $validated['id_ruangan'];
            $sup->jam_mulai = $validated['jam_mulai'];
            $sup->jam_selesai = $validated['jam_selesai'];
            $sup->diagnosa_pre = $validated['diagnosapre'];
            $sup->diagnosa_post = $validated['diagnosapost'];
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
  
      $sup = \App\Models\Laporanibsdetail::whereKey($r->integer('id'))
          ->where('id_pengawas', \Auth::id())
          ->where('status', 0)
          ->firstOrFail();
      $sup->delete();
    
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
  


    public function draftlaporanIBS(Request $r, \App\Services\PengawasIbsService $ibsService){
        $validated = $r->validate([
            'ibs_catatan' => ['nullable', 'string', 'max:5000'],
        ]);
        
        $result = $ibsService->createDraft($validated);

        if (!$result['success']) {
            return redirect()->back()->with('fail-add', $result['message']);
        }

        return redirect()->back()->with('success-add', $result['message']);
    }
    public function editDraftlaporanIBS(Request $r, \App\Services\PengawasIbsService $ibsService){
        $validated = $r->validate([
            'idibs' => ['required', 'integer'],
            'ibs_catatan' => ['nullable', 'string', 'max:5000'],
        ]);
        
        $result = $ibsService->updateDraft($validated);

        if (!$result['success']) {
            return redirect()->back()->with('fail-add', $result['message']);
        }

        return redirect()->back()->with('success-add', $result['message']);
    }
    public function deleteDraftlaporanIBS($id, \App\Services\PengawasIbsService $ibsService){
        $result = $ibsService->deleteDraft((int) $id);
        
        return redirect()->back()->with('success-add', $result['message']);
    }

    // Catatan PASIEN

    public function tambahcatatanpasien(Request $r, \App\Services\PengawasCatatanService $catatanService)
    {
        $validator = Validator::make($r->all(), [
            'kamar' => ['required', 'string', 'max:100'],
            'nama' => ['required', 'string', 'max:1000'],
            'rm' => ['required', 'string', 'max:1000'],
            'diagnosa' => ['required', 'string', 'max:5000'],
            'dpjp' => ['required', 'integer', 'exists:dokter_irj,id,status,1'],
            'kondisi' => ['required', 'string', 'max:5000'],
            'jenis_pasien' => ['required', 'integer', 'in:1,2'],
            'ruangan' => ['required', 'integer', 'exists:ruangan,id,status,1'],
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $result = $catatanService->createCatatan($validator->validated());

        return response()->json($result);
    }
  
    public function editcatatanpasien(Request $r, \App\Services\PengawasCatatanService $catatanService)
    {
        $validator = Validator::make($r->all(), [
            'id' => ['required', 'integer'],
            'kamar' => ['required', 'string', 'max:100'],
            'nama' => ['required', 'string', 'max:1000'],
            'rm' => ['required', 'string', 'max:1000'],
            'diagnosa' => ['required', 'string', 'max:5000'],
            'dpjp' => ['required', 'integer', 'exists:dokter_irj,id,status,1'],
            'kondisi' => ['required', 'string', 'max:5000'],
            'jenis_pasien' => ['required', 'integer', 'in:1,2'],
            'ruangan' => ['required', 'integer', 'exists:ruangan,id,status,1'],
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $result = $catatanService->updateCatatan($validator->validated());

        return response()->json($result);
    }
  
    public function deletecatatanpasien(Request $r, \App\Services\PengawasCatatanService $catatanService)
    {
        $result = $catatanService->deleteCatatan((int) $r->integer('id'), (int) $r->jenis_pasien);

        return response()->json($result);
    }

    public function kirimLaporan(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'dinas' => ['required', 'integer', 'exists:dinas,id'],
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

        DB::transaction(function () use ($r, $userId, $igd) {
            date_default_timezone_set('Asia/Jakarta');
            $now = date('Y-m-d H:i:s');

            // Simpan laporan utama
            $sup = new \App\Models\Laporan;
            $sup->id_pengawas = $userId;
            $sup->id_dinas    = $r->dinas;
            $sup->created_at  = $now;
            $sup->updated_at  = $now;
            $sup->save();
            $laporanId = $sup->id;

            // Generate HMAC-SHA256 token yang terikat ke id laporan + id pengawas
            $token = hash_hmac('sha256', $laporanId . '|' . $userId . '|' . $now, config('app.key'));

            // Generate QR Code mengarah ke halaman verifikasi publik
            $verifyUrl  = route('verifikasi.laporan', ['token' => $token]);
            $qrFilename = 'qr_' . $laporanId . '.svg';
            $qrPath     = 'qrcodes/' . $qrFilename;
            QrCode::format('svg')
                ->size(300)
                ->margin(1)
                ->generate($verifyUrl, Storage::disk('public')->path($qrPath));

            // Update laporan dengan token dan nama file QR
            $sup->qr_token = $token;
            $sup->qr_code  = $qrFilename;
            $sup->save();

            // Update Laporan IGD
            $igd->id_laporan = $laporanId;
            $igd->status     = 1;
            $igd->updated_at = $now;
            $igd->save();

            // Update Laporan Umum
            \App\Models\Laporanumum::where('id_pengawas', $userId)->where('status', 0)
                ->update(['id_laporan' => $laporanId, 'updated_at' => $now, 'status' => 1]);
            \App\Models\Catatanpasien::where('id_pengawas', $userId)->where('status', 0)
                ->update(['updated_at' => $now, 'status' => 1]);

            // Update Laporan IRJ
            \App\Models\Laporanirj::where('id_pengawas', $userId)->where('status', 0)
                ->update(['id_laporan' => $laporanId, 'updated_at' => $now, 'status' => 1]);
            $lastIrjId = \App\Models\Laporanirj::where('id_pengawas', $userId)->pluck('id')->last();
            \App\Models\Laporanirjdetail::where('id_pengawas', $userId)->where('status', 0)
                ->update(['id_laporan_irj' => $lastIrjId, 'status' => 1]);

            // Update Laporan IBS
            \App\Models\Laporanibs::where('id_pengawas', $userId)->where('status', 0)
                ->update(['id_laporan' => $laporanId, 'updated_at' => $now, 'status' => 1]);
            $lastIbsId = \App\Models\Laporanibs::where('id_pengawas', $userId)->pluck('id')->last();
            \App\Models\Laporanibsdetail::where('id_pengawas', $userId)->where('status', 0)
                ->update(['id_laporan_ibs' => $lastIbsId, 'status' => 1]);

            // Log aktivitas
            $log             = new \App\Models\Log;
            $log->id_user    = $userId;
            $log->id_log_jenis = 5;
            $log->keterangan = 'Kirim Laporan ke Direktur untuk diverifikasi';
            $log->created_at = $now;
            $log->updated_at = $now;
            $log->save();
        });

        return redirect()->back()->with('success-add', 'Berhasil Submit Laporan Pengawas Umum');
    }
}
