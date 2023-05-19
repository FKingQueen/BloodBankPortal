<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DonateBlood;
use App\Models\BloodInventory;
use App\Models\User;
use Carbon\Carbon;
use DB;

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


        return response()->json([
            'quantity'  =>  $quantity,
            'address'  =>  $address,
            'quantityCount'  =>  $quantityCount,
            'sample'  =>   $bloodType,
        ]);
    }

    public function getBInventory(){
        return BloodInventory::orderBy('bloodType')->get();
    }

    public function storeBloodInventory(Request $request){
        $donateDate = today();
        $expireDate = Carbon::now()->addDays(35);
        $age = Carbon::parse($request->birthDate)->age;

        BloodInventory::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'middleInitial' => $request->middleInitial,
            'address' => $request->address,
            'gender' => $request->gender,
            'age' => $age,
            'birthDate' => $request->birthDate,
            'bloodType' => $request->bloodType,
            'donateDate' => $donateDate->format('m-d-Y'),
            'expireDate' => $expireDate->format('m-d-Y'),
        ]);
        return "success";
    }

    public function deleteBloodInventory($id) {
        $BloodInventory = BloodInventory::find($id);
        $BloodInventory->delete();
        return;
    }

    public function getBloodInventoryEdit($id){
        return BloodInventory::find($id);
    }

    public function updateBloodInventory(Request $request){
        $donateDate = today();
        $expireDate = Carbon::now()->addDays(35);
        $age = Carbon::parse($request->birthDate)->age;

        DB::table('blood_inventories')
        ->where('id', $request->id)
        ->update([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'middleInitial' => $request->middleInitial,
            'address' => $request->address,
            'gender' => $request->gender,
            'age' => $age,
            'birthDate' => $request->birthDate,
            'bloodType' => $request->bloodType,
            'donateDate' => $donateDate->format('m-d-Y'),
            'expireDate' => $expireDate->format('m-d-Y'),
        ]);
        return;
    }
}
