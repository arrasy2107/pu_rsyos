<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporanirjdetail extends Model
{
    //use HasFactory;
    protected $table = "laporan_irj_detail";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
    public $timestamps = false;
}
