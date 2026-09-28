<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $table = 'kamar';
    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }

    public function kasur()
    {
        return $this->hasMany(Kasur::class, 'id_kamar');
    }
}
