<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Laporanigd;
use App\Models\Laporanumum;
use App\Models\Piket;
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

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
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
        Carbon::setTestNow(Carbon::parse('2026-10-03 10:00:00', 'Asia/Jakarta'));

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
        Piket::create([
            'id_pengawas' => $user->id,
            'id_dinas' => $dinasId,
            'tanggal' => '2026-10-03',
        ]);

        // Belum mengisi IGD dan Ruangan, harus gagal
        $response = $this->actingAs($user)->post(route('kirimLaporan'), [
            'dinas' => $dinasId,
        ]);

        $response->assertSessionHas('fail-add', 'Laporan belum dapat dikirim. Lengkapi laporan IGD dan seluruh Ruangan (Rawat Inap) aktif terlebih dahulu.');
    }

    public function test_can_kirim_laporan_if_complete()
    {
        Carbon::setTestNow(Carbon::parse('2026-10-03 10:00:00', 'Asia/Jakarta'));

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
        $forgedDinasId = DB::table('dinas')->insertGetId([
            'dinas' => 'Sore',
            'jam_masuk' => '14:00:00',
            'jam_pulang' => '22:00:00',
        ]);
        Piket::create([
            'id_pengawas' => $user->id,
            'id_dinas' => $dinasId,
            'tanggal' => '2026-10-03',
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
            'dinas' => $forgedDinasId,
            'tanggal_dinas' => '2026-10-02',
            'is_terlambat' => 1,
        ]);

        $response->assertSessionHas('success-add', 'Berhasil Submit Laporan Pengawas Umum');

        // Pastikan status laporan berubah jadi 1
        $this->assertEquals(0, Laporanigd::where('id_pengawas', $user->id)->where('status', 0)->count());
        $this->assertEquals(0, Laporanumum::where('id_pengawas', $user->id)->where('status', 0)->count());

        // Pastikan tabel laporan utama (Laporan) terisi dan token QR ada
        $laporanUtama = DB::table('laporan')->where('id_pengawas', $user->id)->first();
        $this->assertNotNull($laporanUtama);
        $this->assertEquals($dinasId, $laporanUtama->id_dinas);
        $this->assertEquals('2026-10-03', $laporanUtama->tanggal_dinas);
        $this->assertEquals(0, $laporanUtama->is_terlambat);
        $this->assertNotNull($laporanUtama->qr_token);
        $this->assertNotNull($laporanUtama->qr_code);

        // Pastikan file QR svg dibuat di disk public (folder qrcodes/)
        $this->assertFileExists(Storage::disk('public')->path('qrcodes/' . $laporanUtama->qr_code));
    }

    public function test_late_shift_can_open_laporan_without_existing_drafts(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-10-03 15:00:00', 'Asia/Jakarta'));

        $user = User::create([
            'nama' => 'Test Pengawas Terlambat',
            'username' => 'pengawas_terlambat_' . uniqid(),
            'password' => bcrypt('12345678'),
            'id_role' => 2,
            'status' => 1,
        ]);
        $dinasId = DB::table('dinas')->insertGetId([
            'dinas' => 'Pagi',
            'jam_masuk' => '06:45:00',
            'jam_pulang' => '14:15:00',
        ]);
        Piket::create([
            'id_pengawas' => $user->id,
            'id_dinas' => $dinasId,
            'tanggal' => '2026-10-03',
        ]);

        $response = $this->actingAs($user)->get(route('laporan'));

        $response->assertOk();
        $response->assertSee('Waktu dinas PAGI telah habis.');
        $response->assertSee('draft-igd-form');
    }

    public function test_late_complete_report_is_marked_late_from_the_assigned_schedule(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-10-03 15:00:00', 'Asia/Jakarta'));

        $user = User::create([
            'nama' => 'Test Pengawas Terlambat Kirim',
            'username' => 'pengawas_terlambat_kirim_' . uniqid(),
            'password' => bcrypt('12345678'),
            'id_role' => 2,
            'status' => 1,
        ]);
        $dinasId = DB::table('dinas')->insertGetId([
            'dinas' => 'Pagi',
            'jam_masuk' => '06:45:00',
            'jam_pulang' => '14:15:00',
        ]);
        Piket::create([
            'id_pengawas' => $user->id,
            'id_dinas' => $dinasId,
            'tanggal' => '2026-10-03',
        ]);

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
        foreach (Ruangan::where('status', 1)->pluck('id') as $roomId) {
            Laporanumum::create([
                'id_pengawas' => $user->id,
                'id_ruangan' => $roomId,
                'jumlah_pasien_pulang' => 0,
                'status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        $response = $this->actingAs($user)->post(route('kirimLaporan'), []);

        $response->assertSessionHas('success-add', 'Berhasil Submit Laporan Pengawas Umum');
        $this->assertDatabaseHas('laporan', [
            'id_pengawas' => $user->id,
            'id_dinas' => $dinasId,
            'tanggal_dinas' => '2026-10-03',
            'is_terlambat' => 1,
        ]);
    }
}
