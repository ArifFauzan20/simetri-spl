<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HariKerja extends Model
{
    use HasFactory;

    protected $table = 'r_poin_h_kerja';
    protected $guarded = ['id'];
}
