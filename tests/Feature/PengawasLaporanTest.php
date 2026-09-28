<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Laporanigd;
use App\Models\Laporanumum;
use App\Models\Ruangan;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PengawasLaporanTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        Storage::disk('public')->makeDirectory('qrcodes');
    }

    public function test_cannot_kirim_laporan_without_dinas_id()
    {
        $user = User::create([
            'nama' => 'Test Pengawas',
            'username' => 'pengawas_' . uniqid(),
            'password' => bcrypt('12345678'),
            'id_role' => 2, // Pengawas Umum
            'status' => 1
        ]);

        $response = $this->actingAs($user)->post(route('kirimLaporan'), []);

        $response->assertSessionHas('fail-add');
    }

    public function test_cannot_kirim_laporan_if_incomplete()
    {
        $user = User::create([
            'nama' => 'Test Pengawas',
            'username' => 'pengawas_' . uniqid(),
            'password' => bcrypt('12345678'),
            'id_role' => 2,
            'status' => 1
        ]);

        // Insert mock dinas
        $dinasId = DB::table('dinas')->insertGetId([
            'dinas' => 'Pagi',
            'jam_masuk' => '07:00:00',
            'jam_pulang' => '14:00:00',
        ]);

        // Belum mengisi IGD dan Ruangan, harus gagal
        $response = $this->actingAs($user)->post(route('kirimLaporan'), [
            'dinas' => $dinasId,
        ]);

        $response->assertSessionHas('fail-add', 'Laporan belum dapat dikirim. Lengkapi laporan IGD dan seluruh Ruangan (Rawat Inap) aktif terlebih dahulu.');
    }

    public function test_can_kirim_laporan_if_complete()
    {
        $user = User::create([
            'nama' => 'Test Pengawas',
            'username' => 'pengawas_' . uniqid(),
            'password' => bcrypt('12345678'),
            'id_role' => 2,
            'status' => 1
        ]);

        $dinasId = DB::table('dinas')->insertGetId([
            'dinas' => 'Pagi',
            'jam_masuk' => '07:00:00',
            'jam_pulang' => '14:00:00',
        ]);

        // Lengkapi laporan IGD
        Laporanigd::create([
            'id_pengawas' => $user->id,
            'jumlah_pasien' => 5,
            'jumlah_pasien_sisrute' => 1,
            'jumlah_pasien_sisrute_diterima' => 1,
            'jumlah_pasien_sisrute_ditolak' => 0,
            'status' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Lengkapi semua ruangan aktif
        $activeRooms = Ruangan::where('status', 1)->pluck('id');
        foreach ($activeRooms as $roomId) {
            Laporanumum::create([
                'id_pengawas' => $user->id,
                'id_ruangan' => $roomId,
                'jumlah_pasien_pulang' => 0,
                'status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        $response = $this->actingAs($user)->post(route('kirimLaporan'), [
            'dinas' => $dinasId,
        ]);

        $response->assertSessionHas('success-add', 'Berhasil Submit Laporan Pengawas Umum');

        // Pastikan status laporan berubah jadi 1
        $this->assertEquals(0, Laporanigd::where('id_pengawas', $user->id)->where('status', 0)->count());
        $this->assertEquals(0, Laporanumum::where('id_pengawas', $user->id)->where('status', 0)->count());

        // Pastikan tabel laporan utama (Laporan) terisi dan token QR ada
        $laporanUtama = DB::table('laporan')->where('id_pengawas', $user->id)->first();
        $this->assertNotNull($laporanUtama);
        $this->assertNotNull($laporanUtama->qr_token);
        $this->assertNotNull($laporanUtama->qr_code);

        // Pastikan file QR svg dibuat di disk public (folder qrcodes/)
        $this->assertFileExists(Storage::disk('public')->path('qrcodes/' . $laporanUtama->qr_code));
    }
}
