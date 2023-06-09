<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\DonateBlood;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function storeDonateBlood(Request $request)
    {
        // return $request->all();
        $donateDate = today();
        $expireDate = Carbon::now()->addDays(35);
        DonateBlood::create([
            'user_id' => Auth::user()->id,
            'address' => Auth::user()->address,
            'phoneNumber' => Auth::user()->phoneNumber,
            'bloodType' => $request->bloodType,
            'donateDate' => $donateDate->format('m-d-Y'),
            'expireDate' => $expireDate->format('m-d-Y'),
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
