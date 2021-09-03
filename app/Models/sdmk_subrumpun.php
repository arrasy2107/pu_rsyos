<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sdmk_subrumpun extends Model
{
    //use HasFactory;
    protected $table = "sdmk_subrumpun";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
    public $timestamps = false;
}
