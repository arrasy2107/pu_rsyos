<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporanibs extends Model
{
    protected $table = "laporan_ibs";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
}
