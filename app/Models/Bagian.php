<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bagian extends Model
{
    protected $table = 'r_bagian';
    protected $guarded = ['id'];
    use HasFactory;

    public function karyawan()
    {
        return $this->hasMany(Karyawan::class, 'id_bagian');
    }
}
