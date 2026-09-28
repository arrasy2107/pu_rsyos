<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    //use HasFactory;
    protected $table = "ruangan";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
    public $timestamps = false;

    protected $casts = [
        'status' => 'boolean',
    ];

    public function kamar()
    {
        return $this->hasMany(Kamar::class, 'id_ruangan');
    }
}
