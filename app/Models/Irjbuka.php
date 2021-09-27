<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Irjbuka extends Model
{
    protected $table = "irj_buka";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
    public $timestamps = false;
}
