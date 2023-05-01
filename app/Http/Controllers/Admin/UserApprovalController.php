<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserApproval;
use App\Models\User;

class UserApprovalController extends Controller
{
    public function getUserApproval ()
    {
        return UserApproval::orderBy('id', 'desc')->get();
    }

    public function userApproved ($id)
    {
        $newUser = UserApproval::find($id);
        $newUser->userType = 'User';
        $status = User::create([
            'userType' => $newUser->userType,
            'firstName' => $newUser->firstName,
            'lastName' => $newUser->lastName,
            'middleInitial' => $newUser->middleInitial,
            'address' => $newUser->address,
            'idPicName' => $newUser->idPicName,
            'gender' => $newUser->gender,
            'age' => $newUser->age,
            'bloodType' => $newUser->bloodType,
            'phoneNumber' => $newUser->phoneNumber,
            'email' => $newUser->email,
            'password' => $newUser->password,
        ]);

        if($status){
            $User = UserApproval::find($id);
            $User->delete();
        }

        return;
    }

    public function userDisapproved ($id){
        $User = UserApproval::find($id);
        $User->delete();
        return;
    }
}
