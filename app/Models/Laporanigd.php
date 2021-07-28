<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporanigd extends Model
{
    //use HasFactory;
    protected $table = "laporan_igd";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
}
