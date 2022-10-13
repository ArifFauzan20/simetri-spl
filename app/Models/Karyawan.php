<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 't_karyawan';
    protected $guarded = ['id'];
    use HasFactory;

    public function bagian()
    {
        return $this->belongsTo(Bagian::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function detailspl()
    {
        return $this->hasMany(DetailSpl::class);
    }

    public function upload()
    {
        return $this->hasMany(Upload::class);
    }
}
