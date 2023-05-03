<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\DonateBlood;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function storeDonateBlood(Request $request)
    {
        DonateBlood::create([
            'user_id' => Auth::user()->id,
            'bloodType' => $request->bloodType,
            'alcoholic' => $request->alcoholic,
            'cardHolder' => $request->cardHolder,
            'drugUser' => $request->drugUser,
            'hourSleep' => $request->hourSleep,
            'weight' => $request->weight,
        ]);
        return $request->all();
    }
}
