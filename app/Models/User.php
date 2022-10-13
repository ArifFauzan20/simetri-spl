<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 't_user_login';
    protected $guarded = ['id'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
