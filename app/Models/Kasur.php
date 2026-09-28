<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kasur extends Model
{
    protected $table = 'kasur';
    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'id_kamar');
    }

    public function isAvailable()
    {
        return $this->status && $this->status_operasional === 'available';
    }
}
