<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserApproval extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'firstName',
        'lastName',
        'middleInitial',
        'age',
        'birthDate',
        'email',
        'address',
        'gender',
        'bloodType',
        'phoneNumber',
        'idPicName',
        'password'
    ];
}
