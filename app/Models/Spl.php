<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spl extends Model
{
    use HasFactory;
    protected $table = 't_spl';
    protected $guarded = ['id'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function detailspl()
    {
        return $this->hasMany(DetailSpl::class);
    }

    public function approval()
    {
        return $this->hasOne(Approval::class);
    }
}
