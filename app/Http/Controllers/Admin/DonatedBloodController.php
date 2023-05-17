<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DonateBlood;

class DonatedBloodController extends Controller
{
    public function getBloodType(){
        $bloodType[0] = DonatedBlood::where('bloodType', 'A+')->count(); 
        $bloodType[1] = DonatedBlood::where('bloodType', 'A-')->count(); 
        $bloodType[2] = DonatedBlood::where('bloodType', 'B+')->count(); 
        $bloodType[3] = DonatedBlood::where('bloodType', 'B-')->count(); 
        $bloodType[4] = DonatedBlood::where('bloodType', 'O+')->count(); 
        $bloodType[5] = DonatedBlood::where('bloodType', 'O-')->count(); 
        $bloodType[6] = DonatedBlood::where('bloodType', 'AB+')->count(); 
        $bloodType[7] = DonatedBlood::where('bloodType', 'AB-')->count(); 

        return $bloodType;
    }
}
