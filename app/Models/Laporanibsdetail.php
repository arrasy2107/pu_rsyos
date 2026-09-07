<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporanibsdetail extends Model
{
    protected $table = "laporan_ibs_detail";
    protected $primaryKey = "id";
    protected $guarded = ['id'];

    public function dokter()
    {
        return $this->belongsTo(Dokterirj::class, 'id_dokter', 'id');
    }

    public function dokterOperasi()
    {
        return $this->belongsTo(Dokterirj::class, 'id_dokter_operasi', 'id');
    }

    public function dokterAnestesi()
    {
        return $this->belongsTo(Dokterirj::class, 'id_dokter_anestesi', 'id');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id');
    }
}
