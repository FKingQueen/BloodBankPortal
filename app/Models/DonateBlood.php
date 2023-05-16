<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonateBlood extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'bloodType',
        'address',
        'hourSleep',
        'drugUser',
        'alcoholic',
        'db3',
        'cardHolder',
        'weight'
    ];
}
