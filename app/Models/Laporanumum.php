<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporanumum extends Model
{
    //use HasFactory;
    protected $table = "laporan_umum";
    protected $primaryKey = "id";
    protected $guarded = ['id'];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id');
    }
}
