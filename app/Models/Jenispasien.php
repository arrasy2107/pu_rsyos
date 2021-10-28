<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenispasien extends Model
{
    protected $table = "jenis_pasien";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
    public $timestamps = false;
}
