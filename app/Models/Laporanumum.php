<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporanumum extends Model
{
    //use HasFactory;
    public const STATUS_DRAFT = 0;
    public const STATUS_SUBMITTED = 1;
    public const STATUS_DELETED = 2;
    public const STATUS_RETURNED = 3;
    public const STATUS_ARCHIVED = 4;

    protected $table = "laporan_umum";
    protected $primaryKey = "id";
    protected $guarded = ['id'];

    public static function saldoPasienLama(int $ruanganId): int
    {
        return (int) (static::query()
            ->where('id_ruangan', $ruanganId)
            ->where('status', self::STATUS_SUBMITTED)
            ->latest('updated_at')
            ->latest('id')
            ->value('jumlah_total_pasien') ?? 0);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id');
    }

    public function ruanganPerbantuanMasuk()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan_perbantuan_masuk', 'id');
    }

    public function ruanganPerbantuanKeluar()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan_perbantuan_keluar', 'id');
    }
}

