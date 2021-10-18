<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporanibsdetail extends Model
{
    protected $table = "laporan_ibs_detail";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
}
