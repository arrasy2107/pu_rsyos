<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokterirj extends Model
{
    //use HasFactory;
    protected $table = "dokter_irj";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
    public $timestamps = false;
}
