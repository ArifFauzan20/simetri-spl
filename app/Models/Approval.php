<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $table = 't_approval';
    protected $guarded = ['id'];


    public function spl()
    {
        return $this->belongsTo(Spl::class);
    }
}
