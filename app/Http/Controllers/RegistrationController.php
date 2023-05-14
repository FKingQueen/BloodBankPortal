<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserApproval;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function uploadid(Request $request){
        $request->validate([
            'file' => 'required'
        ]); 
        $idPic = time().'.'.$request->file->extension();
        $request->file->move(public_path('id'),$idPic);
        return $idPic;
    }

    public function deleteImageReg(Request $request){
        $fileName = $request->imageName;
        $this->deleteFileFromServe($fileName);
        return 'done';
    }

    public function deleteFileFromServe($fileName){
        $filePath = public_path().'/id/'.$fileName;
        if(file_exists($filePath)){
            @unlink($filePath);
        }
        return;
    }

    public function register(Request $request){
        $validated = $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'middleInitial' => 'required',
            'address' => 'required',
            'idPic' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'bloodType' => 'required',
            'phoneNumber' => 'required|min:11|max:11',
            'email' => 'required|email|unique:users|unique:user_approvals',
            'passwd' => 'required|min:8',
        ]);

        $password = Hash::make($request->passwd);

        UserApproval::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'middleInitial' => $request->middleInitial,
            'address' => $request->address,
            'idPicName' => $request->idPic,
            'gender' => $request->gender,
            'age' => $request->age,
            'bloodType' => $request->bloodType,
            'phoneNumber' => $request->phoneNumber,
            'email' => $request->email,
            'password' => $password,
        ]);
        return $request->all();
    }
}



