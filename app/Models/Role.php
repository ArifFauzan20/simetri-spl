<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'r_role_user';
    protected $guarded = ['id'];
    use HasFactory;

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
