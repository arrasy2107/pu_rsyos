<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Kasur;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class FasilitasController extends Controller
{
    private function authorizeFacilityAccess()
    {
        if (!Auth::check() || !in_array((int) Auth::user()->id_role, [0, 1, 3], true)) {
            abort(403);
        }
    }

    private function authorizeAdmin()
    {
        if (!Auth::check() || !in_array((int) Auth::user()->id_role, [0, 1], true)) {
            abort(403);
        }
    }

    private function authorizeKasurAccess()
    {
        if (!Auth::check() || !in_array((int) Auth::user()->id_role, [0, 1, 2, 3], true)) {
            abort(403);
        }
    }

    private function authorizeKasurUpdate()
    {
        if (!Auth::check() || !in_array((int) Auth::user()->id_role, [0, 1, 2], true)) {
            abort(403);
        }
    }

    public function kamar()
    {
        $this->authorizeFacilityAccess();

        return view('admin.konten.kamar', [
            'ruangans' => Ruangan::orderBy('nama_ruangan')->get(),
            'kamars' => Kamar::with('ruangan')->orderBy('id_ruangan')->orderBy('nama_kamar')->get(),
        ]);
    }

    public function tambahKamar(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'id_ruangan' => ['required', 'integer', Rule::exists('ruangan', 'id')->where('status', 1)],
            'nama_kamar' => ['required', 'string', 'max:100'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        Kamar::create($data);

        return back()->with('success-add', 'Berhasil menambah data kamar');
    }

    public function editKamar(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'id' => ['required', 'integer', 'exists:kamar,id'],
            'id_ruangan' => ['required', 'integer', Rule::exists('ruangan', 'id')->where('status', 1)],
            'nama_kamar' => ['required', 'string', 'max:100'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        $kamar = Kamar::findOrFail($data['id']);
        $kamar->update(collect($data)->except('id')->all());

        return back()->with('success-add', 'Berhasil mengubah data kamar');
    }

    public function toggleKamar(Kamar $kamar)
    {
        $this->authorizeAdmin();
        $kamar->update(['status' => !$kamar->status]);

        if (!$kamar->status) {
            $kamar->kasur()->update(['status' => false]);
        }

        return back()->with('success-add', 'Status kamar berhasil diubah');
    }

    public function bulkStatusKamar(Request $request)
    {
        $this->authorizeAdmin();
        $status = $request->boolean('status');

        Kamar::query()->update(['status' => $status]);
        if (!$status) {
            Kasur::query()->update(['status' => false]);
        }

        return back()->with('success-add', 'Status seluruh kamar berhasil diubah');
    }

    public function deleteKamar(Kamar $kamar)
    {
        $this->authorizeAdmin();
        $kamar->update(['status' => false]);
        $kamar->kasur()->update(['status' => false]);

        return back()->with('success-delete', 'Kamar berhasil dinonaktifkan');
    }

    public function kasur(Request $request)
    {
        $this->authorizeKasurAccess();

        if ($request->query('reset') == '1') {
            session()->forget('kasur_ruangan_filter');
            session()->forget('kasur_kamar_filter');
        }

        $data = [
            'kamars' => Kamar::with('ruangan')->orderBy('id_ruangan')->orderBy('nama_kamar')->get(),
            'kasurs' => Kasur::with('kamar.ruangan')->orderBy('id_kamar')->orderBy('kode_kasur')->get(),
        ];

        if (Auth::check() && (int) Auth::user()->id_role === 2) {
            return view('pengawas.kasur', array_merge($data, [
                'filterRuangan' => session('kasur_ruangan_filter', ''),
                'filterKamar' => session('kasur_kamar_filter', ''),
            ]));
        }

        return view('admin.konten.kasur', $data);
    }

    public function tambahKasur(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'id_kamar' => ['required', 'integer', Rule::exists('kamar', 'id')->where('status', 1)],
            'kode_kasur' => ['required', 'string', 'max:100'],
            'status_operasional' => ['required', Rule::in(['available', 'occupied', 'maintenance', 'reserved', 'cleaning'])],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        Kasur::create($data);

        return back()->with('success-add', 'Berhasil menambah data kasur');
    }

    public function editKasur(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'id' => ['required', 'integer', 'exists:kasur,id'],
            'id_kamar' => ['required', 'integer', Rule::exists('kamar', 'id')->where('status', 1)],
            'kode_kasur' => ['required', 'string', 'max:100'],
            'status_operasional' => ['required', Rule::in(['available', 'occupied', 'maintenance', 'reserved', 'cleaning'])],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        $kasur = Kasur::findOrFail($data['id']);
        $kasur->update(collect($data)->except('id')->all());

        return back()->with('success-add', 'Berhasil mengubah data kasur');
    }

    public function toggleKasur(Kasur $kasur)
    {
        $this->authorizeAdmin();
        $kasur->update(['status' => !$kasur->status]);

        return back()->with('success-add', 'Status kasur berhasil diubah');
    }

    public function bulkStatusKasur(Request $request)
    {
        $this->authorizeAdmin();
        Kasur::query()->update(['status' => $request->boolean('status')]);

        return back()->with('success-add', 'Status seluruh kasur berhasil diubah');
    }

    public function deleteKasur(Kasur $kasur)
    {
        $this->authorizeAdmin();
        $kasur->update(['status' => false]);

        return back()->with('success-delete', 'Kasur berhasil dinonaktifkan');
    }

    public function updateKeteranganKasur(Request $request, Kasur $kasur)
    {
        $this->authorizeKasurUpdate();

        if ($request->filled('filter_ruangan')) {
            session()->put('kasur_ruangan_filter', $request->input('filter_ruangan'));
        }

        if ($request->filled('filter_kamar')) {
            session()->put('kasur_kamar_filter', $request->input('filter_kamar'));
        }

        $data = $request->validate([
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        $kasur->update([
            'keterangan' => $data['keterangan'] ?? null,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Keterangan kasur berhasil diubah',
            ]);
        }

        return back()->with('success-add', 'Keterangan kasur berhasil diubah');
    }

    public function updateStatusKasur(Request $request, Kasur $kasur)
    {
        $this->authorizeKasurUpdate();

        if ($request->filled('filter_ruangan')) {
            session()->put('kasur_ruangan_filter', $request->input('filter_ruangan'));
        }

        if ($request->filled('filter_kamar')) {
            session()->put('kasur_kamar_filter', $request->input('filter_kamar'));
        }

        $data = $request->validate([
            'status_operasional' => ['required', Rule::in(['available', 'occupied', 'maintenance', 'reserved', 'cleaning'])],
        ]);

        $kasur->update($data);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Keterangan ketersediaan kasur berhasil diubah',
            ]);
        }

        return back()->with('success-add', 'Keterangan ketersediaan kasur berhasil diubah');
    }
}
