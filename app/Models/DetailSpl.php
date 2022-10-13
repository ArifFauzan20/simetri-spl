<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSpl extends Model
{
    use HasFactory;

    protected $table = 't_detail_spl';
    protected $guarded = ['id'];


    public function spl()
    {
        return $this->belongsTo(Spl::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
