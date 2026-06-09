<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'nim',
        'nama',
        'status',
        'quota_sks',
        'used_sks'
    ];
}