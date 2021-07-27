<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    //use HasFactory;
    protected $table = "dokter";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
    public $timestamps = false;
}
