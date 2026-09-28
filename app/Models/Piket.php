<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Piket extends Model
{
    protected $table = "piket";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
    public $timestamps = false;

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function pengawas()
    {
        return $this->belongsTo(User::class, 'id_pengawas');
    }

    public function dinas()
    {
        return $this->belongsTo(Dinas::class, 'id_dinas');
    }
}
