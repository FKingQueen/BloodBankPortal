<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodInventory extends Model
{
    use HasFactory;
    protected $fillable = [
        'firstName',
        'lastName',
        'middleInitial',
        'age',
        'birthDate',
        'address',
        'gender',
        'bloodType',
        'expireDate',
        'donateDate',
    ];
}