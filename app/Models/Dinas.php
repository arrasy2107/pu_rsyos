<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dinas extends Model
{
    //use HasFactory;
    protected $table = "dinas";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
    public $timestamps = false;
}
