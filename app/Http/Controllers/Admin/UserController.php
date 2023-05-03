<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use DB;

class UserController extends Controller
{
    // User 
    public function getUser()
    {
        return User::orderBy('id', 'desc')->get();
    }

    public function getAuth()
    {
        return Auth::user();
    }

    public function storeUser(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'userType' => 'required',
            'passwd' => 'required|min:8',
        ]);

        $password = Hash::make($request->passwd);
        // return $request;
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'userType' => $request->userType,
            'password' => $password,
        ]);

        return $validated;
    }

    public function deleteUser($id){
        $User = User::find($id);
        $User->delete();
        return;
    }

    public function getUserEdit($id)
    {
        return User::find($id);
    }

    public function updateUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => "required|email|unique:users,email,$request->id",
            'userType' => 'required',
        ]);

        DB::table('users')
        ->where('id', $request->id)
        ->update([
        'name' => $request->name,
        'userType' => $request->userType,
        'email' => $request->email
        ]);
        return $request->all();
    }
    
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'passwd' => 'required|min:8',
        ]);
        $password = bcrypt($request->passwd);
        DB::table('users')
        ->where('id', $request->id)
        ->update([
        'password' => $password
        ]);
        return;
    }
}
