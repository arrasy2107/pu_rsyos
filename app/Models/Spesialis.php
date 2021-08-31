<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spesialis extends Model
{
    //use HasFactory;
    protected $table = "spesialis";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
    public $timestamps = false;
}
