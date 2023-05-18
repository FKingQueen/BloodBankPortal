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
        $quantityCount = DonateBlood::all()->groupBy('bloodType')->values();

        $address = DonateBlood::all()->groupBy('address')->values();
        $sample = DonateBlood::all()->groupBy('address')->values();
        $quantity = DonateBlood::select('bloodType')->distinct()->get();


        $bloodType = [];
        $sample[0]->unique('bloodType')->values();

        for($i = 0; $i < $sample->count();$i++){
            $bloodType[$i] = $sample[$i]->unique('bloodType')->values();
        }
        

        // $quantityCount[0] = DonateBlood::where('bloodType', "A+")->count(); 
        // $quantityCount[1] = DonateBlood::where('bloodType', "A-")->count(); 
        // $quantityCount[2] = DonateBlood::where('bloodType', "B+")->count(); 
        // $quantityCount[3] = DonateBlood::where('bloodType', "B-")->count(); 
        // $quantityCount[4] = DonateBlood::where('bloodType', "O+")->count(); 
        // $quantityCount[5] = DonateBlood::where('bloodType', "O-")->count(); 
        // $quantityCount[6] = DonateBlood::where('bloodType', "AB+")->count(); 
        // $quantityCount[7] = DonateBlood::where('bloodType', "AB-")->count(); 

        // $i = 0;
        // $quantity = [];

        // foreach($data as $key => $dt){
        //     if($address[$key] == $dt->address){
        //         $quantity[$key] = DonateBlood::where('address', $address[$key])->where('bloodType', 'A+')->count(); 
        //     }
        // }


        return response()->json([
            'quantity'  =>  $quantity,
            'address'  =>  $address,
            'quantityCount'  =>  $quantityCount,
            'sample'  =>   $bloodType,
        ]);
    }
}
