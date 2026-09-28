<?php

namespace Tests\Feature;

use App\Models\Laporanumum;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class LaporanUmumSaldoPasienLamaTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $this->app['db']->purge('sqlite');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->unsignedInteger('id_role')->default(2);
            $table->unsignedInteger('status')->default(1);
            $table->text('akses_menu')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('ruangan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ruangan')->nullable();
            $table->unsignedInteger('status')->default(1);
        });

        Schema::create('laporan_umum', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_pengawas')->nullable();
            $table->unsignedInteger('id_ruangan')->nullable();
            $table->unsignedInteger('id_laporan')->nullable();
            $table->integer('jumlah_pasien_lama')->nullable();
            $table->integer('jumlah_pasien_baru')->nullable();
            $table->integer('jumlah_pasien_pindah')->nullable();
            $table->integer('jumlah_pasien_pindahan')->nullable();
            $table->integer('jumlah_pasien_meninggal')->nullable();
            $table->integer('jumlah_pasien_pulang')->nullable();
            $table->text('catatan_pasien_istimewa')->nullable();
            $table->text('catatan_pasien_baru')->nullable();
            $table->integer('jumlah_pasien_covid')->nullable();
            $table->integer('jumlah_pasien_suspek_covid')->nullable();
            $table->integer('jumlah_pasien_restrain')->nullable();
            $table->integer('jumlah_pasien_perilaku_kekerasan')->nullable();
            $table->integer('jumlah_pasien_keracunan')->nullable();
            $table->integer('jumlah_pasien_keterbatasan_bahasa')->nullable();
            $table->integer('jumlah_pasien_difabel')->nullable();
            $table->text('permasalahan_umum')->nullable();
            $table->integer('jumlah_total_pasien')->nullable();
            $table->integer('status')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create('catatan_pasien', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_pengawas')->nullable();
            $table->unsignedInteger('id_ruangan')->nullable();
            $table->unsignedInteger('id_jenis_pasien')->nullable();
            $table->unsignedInteger('status')->default(0);
            $table->unsignedInteger('id_laporan_umum')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create('log', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_user')->nullable();
            $table->unsignedInteger('id_log_jenis')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function test_it_returns_zero_when_no_submitted_report_exists(): void
    {
        $this->assertSame(0, Laporanumum::saldoPasienLama(10, 5));
    }

    public function test_it_returns_latest_submitted_total_for_same_room_only(): void
    {
        Laporanumum::insert([
            [
                'id_pengawas' => 1,
                'id_ruangan' => 5,
                'id_laporan' => 1,
                'jumlah_pasien_lama' => 21,
                'jumlah_total_pasien' => 21,
                'status' => 1,
                'created_at' => '2024-01-01 08:00:00',
                'updated_at' => '2024-01-01 08:00:00',
            ],
            [
                'id_pengawas' => 2,
                'id_ruangan' => 5,
                'id_laporan' => 2,
                'jumlah_pasien_lama' => 12,
                'jumlah_total_pasien' => 12,
                'status' => 1,
                'created_at' => '2024-01-02 08:00:00',
                'updated_at' => '2024-01-02 08:00:00',
            ],
            [
                'id_pengawas' => 3,
                'id_ruangan' => 7,
                'id_laporan' => 3,
                'jumlah_pasien_lama' => 99,
                'jumlah_total_pasien' => 99,
                'status' => 1,
                'created_at' => '2024-01-03 08:00:00',
                'updated_at' => '2024-01-03 08:00:00',
            ],
            [
                'id_pengawas' => 2,
                'id_ruangan' => 5,
                'id_laporan' => null,
                'jumlah_pasien_lama' => 999,
                'jumlah_total_pasien' => 999,
                'status' => 0,
                'created_at' => '2024-01-04 08:00:00',
                'updated_at' => '2024-01-04 08:00:00',
            ],
            [
                'id_pengawas' => 4,
                'id_ruangan' => 5,
                'id_laporan' => 4,
                'jumlah_pasien_lama' => 50,
                'jumlah_total_pasien' => 50,
                'status' => Laporanumum::STATUS_DELETED,
                'created_at' => '2024-01-05 08:00:00',
                'updated_at' => '2024-01-05 08:00:00',
            ],
            [
                'id_pengawas' => 5,
                'id_ruangan' => 5,
                'id_laporan' => null,
                'jumlah_pasien_lama' => 700,
                'jumlah_total_pasien' => 700,
                'status' => Laporanumum::STATUS_RETURNED,
                'created_at' => '2024-01-06 08:00:00',
                'updated_at' => '2024-01-06 08:00:00',
            ],
            [
                'id_pengawas' => 6,
                'id_ruangan' => 5,
                'id_laporan' => null,
                'jumlah_pasien_lama' => 800,
                'jumlah_total_pasien' => 800,
                'status' => Laporanumum::STATUS_ARCHIVED,
                'created_at' => '2024-01-07 08:00:00',
                'updated_at' => '2024-01-07 08:00:00',
            ],
        ]);

        $this->assertSame(12, Laporanumum::saldoPasienLama(5));
        $this->assertSame(0, Laporanumum::saldoPasienLama(999));
    }

    public function test_create_ignores_forged_old_patient_value(): void
    {
        $user = User::create([
            'nama' => 'Pengawas Test',
            'username' => 'pengawas-create',
            'email' => 'create@example.test',
            'password' => 'password',
            'id_role' => 2,
            'status' => 1,
        ]);
        $room = Schema::getConnection()->table('ruangan')->insertGetId([
            'nama_ruangan' => 'Ruangan Create',
            'status' => 1,
        ]);

        Laporanumum::insert([
            'id_pengawas' => 99,
            'id_ruangan' => $room,
            'id_laporan' => 10,
            'jumlah_pasien_lama' => 20,
            'jumlah_total_pasien' => 21,
            'status' => Laporanumum::STATUS_SUBMITTED,
            'updated_at' => '2024-01-01 08:00:00',
        ]);

        $response = $this->actingAs($user)->post(route('draftlaporanUmum'), [
            'inap_ruangan' => $room,
            'inap_pasien_lama' => 999,
            'inap_pasien_baru' => 5,
            'inap_pasien_pindah' => 2,
            'inap_pasien_pindahan' => 1,
            'inap_pasien_meninggal' => 0,
            'inap_pasien_pulang' => 3,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('laporan_umum', [
            'id_pengawas' => $user->id,
            'id_ruangan' => $room,
            'jumlah_pasien_lama' => 21,
            'jumlah_total_pasien' => 22,
            'status' => Laporanumum::STATUS_DRAFT,
        ]);
    }

    public function test_edit_recalculates_old_patient_value_after_room_change(): void
    {
        $user = User::create([
            'nama' => 'Pengawas Edit Test',
            'username' => 'pengawas-edit',
            'email' => 'edit@example.test',
            'password' => 'password',
            'id_role' => 2,
            'status' => 1,
        ]);
        $sourceRoom = Schema::getConnection()->table('ruangan')->insertGetId([
            'nama_ruangan' => 'Ruangan Source',
            'status' => 1,
        ]);
        $targetRoom = Schema::getConnection()->table('ruangan')->insertGetId([
            'nama_ruangan' => 'Ruangan Target',
            'status' => 1,
        ]);

        Laporanumum::insert([
            'id_pengawas' => 99,
            'id_ruangan' => $targetRoom,
            'id_laporan' => 11,
            'jumlah_pasien_lama' => 30,
            'jumlah_total_pasien' => 30,
            'status' => Laporanumum::STATUS_SUBMITTED,
            'updated_at' => '2024-01-01 08:00:00',
        ]);
        $draftId = Laporanumum::insertGetId([
            'id_pengawas' => $user->id,
            'id_ruangan' => $sourceRoom,
            'jumlah_pasien_lama' => 0,
            'jumlah_total_pasien' => 0,
            'status' => Laporanumum::STATUS_DRAFT,
            'updated_at' => '2024-01-02 08:00:00',
        ]);

        $response = $this->actingAs($user)->put(route('editDraftlaporanUmum'), [
            'id' => $draftId,
            'inap_ruangan' => $targetRoom,
            'inap_pasien_lama' => 999,
            'inap_pasien_baru' => 1,
            'inap_pasien_pindah' => 0,
            'inap_pasien_pindahan' => 0,
            'inap_pasien_meninggal' => 0,
            'inap_pasien_pulang' => 0,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('laporan_umum', [
            'id' => $draftId,
            'id_ruangan' => $targetRoom,
            'jumlah_pasien_lama' => 30,
            'jumlah_total_pasien' => 31,
            'status' => Laporanumum::STATUS_DRAFT,
        ]);
    }

    public function test_new_report_ajax_renders_server_calculated_old_patient_value(): void
    {
        $user = User::create([
            'nama' => 'Pengawas Ajax',
            'username' => 'pengawas-ajax',
            'email' => 'ajax@example.test',
            'password' => 'password',
            'id_role' => 2,
            'status' => 1,
        ]);
        $room = Schema::getConnection()->table('ruangan')->insertGetId([
            'nama_ruangan' => 'Ruangan Ajax',
            'status' => 1,
        ]);

        Laporanumum::insert([
            'id_ruangan' => $room,
            'jumlah_total_pasien' => 21,
            'status' => Laporanumum::STATUS_SUBMITTED,
            'updated_at' => '2024-01-01 08:00:00',
        ]);

        $response = $this->actingAs($user)->get("/refresh-laporan-ruangan/{$room}");

        $response->assertOk()
            ->assertSee('name="inap_ruangan"', false)
            ->assertSee('name="inap_pasien_lama"', false)
            ->assertSee('value="21"', false);
    }

    public function test_draft_ajax_renders_draft_form_with_server_calculated_old_patient_value(): void
    {
        $user = User::create([
            'nama' => 'Pengawas Draft Ajax',
            'username' => 'pengawas-draft-ajax',
            'email' => 'draft-ajax@example.test',
            'password' => 'password',
            'id_role' => 2,
            'status' => 1,
        ]);
        $room = Schema::getConnection()->table('ruangan')->insertGetId([
            'nama_ruangan' => 'Ruangan Draft Ajax',
            'status' => 1,
        ]);

        Laporanumum::insert([
            'id_ruangan' => $room,
            'jumlah_total_pasien' => 34,
            'status' => Laporanumum::STATUS_SUBMITTED,
            'updated_at' => '2024-01-01 08:00:00',
        ]);
        Laporanumum::insert([
            'id_pengawas' => $user->id,
            'id_ruangan' => $room,
            'jumlah_pasien_lama' => 999,
            'jumlah_total_pasien' => 999,
            'status' => Laporanumum::STATUS_DRAFT,
            'updated_at' => '2024-01-02 08:00:00',
        ]);

        $response = $this->actingAs($user)->get("/refresh-laporan-ruangan-draf/{$room}");

        $response->assertOk()
            ->assertSee('action="' . route('editDraftlaporanUmum') . '"', false)
            ->assertSee('name="inap_pasien_lama" id="inap_pasien_lama" autocomplete="off" value="34" readonly', false);
    }
}
