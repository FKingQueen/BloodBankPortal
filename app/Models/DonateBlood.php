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
        'phoneNumber',
        'expireDate',
        'donateDate',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
