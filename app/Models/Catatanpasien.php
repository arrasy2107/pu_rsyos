<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catatanpasien extends Model
{
    protected $table = "catatan_pasien";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
}
