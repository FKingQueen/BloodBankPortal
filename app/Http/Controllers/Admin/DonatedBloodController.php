<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DonateBlood;

class DonatedBloodController extends Controller
{
    public function getBloodType(){
        
        $bloodType[0] = DonateBlood::where('bloodType', "A+")->count(); 
        $bloodType[1] = DonateBlood::where('bloodType', "A-")->count(); 
        $bloodType[2] = DonateBlood::where('bloodType', "B+")->count(); 
        $bloodType[3] = DonateBlood::where('bloodType', "B-")->count(); 
        $bloodType[4] = DonateBlood::where('bloodType', "O+")->count(); 
        $bloodType[5] = DonateBlood::where('bloodType', "O-")->count(); 
        $bloodType[6] = DonateBlood::where('bloodType', "AB+")->count(); 
        $bloodType[7] = DonateBlood::where('bloodType', "AB-")->count(); 

        $labels[0] = "A+";
        $labels[1] = "A-";
        $labels[2] = "B+";
        $labels[3] = "B-";
        $labels[4] = "O+";
        $labels[5] = "O-";
        $labels[6] = "AB+";
        $labels[7] = "AB-";


        return response()->json([
            'bloodType'  =>  $bloodType,
            'labels'  =>  $labels,
        ]);
    }

    public function getDonatedB(){
        $data = DonateBlood::all(); 
        $address = DonateBlood::all()->unique('address')->pluck("address");
        // $unique = $data->unique('address')->pluck("address");
        // return $data;
        return response()->json([
            'data'  =>  $data,
            'addresses'  =>  $address,
        ]);
    }
}
