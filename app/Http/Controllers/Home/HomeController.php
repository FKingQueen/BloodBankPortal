<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\DonateBlood;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function storeDonateBlood(Request $request)
    {
        DonateBlood::create([
            'user_id' => Auth::user()->id,
            'address' => Auth::user()->address,
            'bloodType' => $request->bloodType,
            'alcoholic' => $request->alcoholic,
            'cardHolder' => $request->cardHolder,
            'drugUser' => $request->drugUser,
            'hourSleep' => $request->hourSleep,
            'weight' => $request->weight,
        ]);
        return $request->all();
    }

    public function getDonatedBlood(Request $request){
        $donatedBlood = DonateBlood::where('user_id', '!=' , Auth::user()->id)->where('address', $request->address)->where('bloodType', $request->bloodType)->get();
        return $donatedBlood;
    }

    public function checkDonatedBlood(){
        $donatedBlood =  DonateBlood::where('user_id', Auth::user()->id)->get();

        return $donatedBlood;
    }
}
