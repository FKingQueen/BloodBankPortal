<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ArticleController;  
use App\Http\Controllers\Admin\UserApprovalController;  
use App\Http\Controllers\Home\HomeController;  
use App\Http\Controllers\RegistrationController;  

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Login
Route::post('/login', [AdminController::class, 'login']);
Route::get('/getsomething', [AdminController::class, 'getsomething']);
// Logout
Route::post('/logout', [AdminController::class, 'logout'])->middleware('auth:sanctum');
// Regitration
Route::post('/register', [RegistrationController::class, 'register']);

Route::group(['prefix' => 'admin','middleware' => 'auth:sanctum'], function() {
    Route::get('/getAuth', [UserController::class, 'getAuth']);
    // Admin 
    Route::get('/getUser', [UserController::class, 'getUser']);
    Route::post('/storeUser', [UserController::class, 'storeUser']);
    Route::post('/deleteUser/{id}', [UserController::class, 'deleteUser']);
    Route::get('/getUserEdit/{id}', [UserController::class, 'getUserEdit']);
    Route::post('/updateUser', [UserController::class, 'updateUser']);
    Route::post('/updatePassword', [UserController::class, 'updatePassword']);
    Route::get('/getUserApproval', [UserApprovalController::class, 'getUserApproval']);
    Route::post('/userApproved/{id}', [UserApprovalController::class, 'userApproved']);
    Route::post('/userDisapproved/{id}', [UserApprovalController::class, 'userDisapproved']);

    // User
    Route::post('/storeDonateBlood', [HomeController::class, 'storeDonateBlood']);
    Route::post('/getDonatedBlood', [HomeController::class, 'getDonatedBlood']);
});


// Project

Route::post('/uploadid', [RegistrationController::class, 'uploadid']);
Route::post('/deleteImageReg', [RegistrationController::class, 'deleteImageReg']);




