<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UangMakan extends Model
{
    use HasFactory;
    protected $table = 'r_uang_makan';
    protected $guarded = ['id'];
}
