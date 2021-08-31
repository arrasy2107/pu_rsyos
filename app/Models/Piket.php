<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piket extends Model
{
    //use HasFactory;
    protected $table = "piket";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
    public $timestamps = false;
}
