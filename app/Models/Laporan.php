<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    //use HasFactory;
    protected $table = "laporan";
    protected $primaryKey = "id";
    protected $guarded = ['id'];

    public function dinas()
    {
        return $this->belongsTo(Dinas::class, 'id_dinas', 'id');
    }

    public function pengawas()
    {
        return $this->belongsTo(User::class, 'id_pengawas', 'id');
    }
}
