<?php

use App\Http\Controllers\API\auth\AuthController;
use App\Http\Controllers\API\user\RoleController;
use App\Http\Controllers\API\user\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});





Route::post('/login',[AuthController::class,'login']);

Route::group(['middleware'=>'JWTchecker'],function (){

    Route::get('info',[AuthController::class,'info'])->name('info');
    Route::post('logout',[AuthController::class,'logout'])->name('logout');



    // role
    Route::resource('roles', RoleController::class);

    //user
    Route::post('users',[UserController::class,'index'])->name('users');
    Route::post('userAdd',[UserController::class,'store'])->name('userAdd');
    Route::post('userUpdate',[UserController::class,'update'])->name('userUpdate');
    Route::post('userDelete',[UserController::class,'destroy'])->name('userDelete');


    //role
    Route::get('roles',[RoleController::class,'index'])->name('roles');
    Route::get('createRole',[RoleController::class,'create'])->name('create');
    Route::post('roleAdd',[RoleController::class,'store'])->name('roleAdd');
    Route::post('roleUpdate',[RoleController::class,'update'])->name('roleUpdate');
    Route::post('roleDelete',[RoleController::class,'destroy'])->name('roleDelete');



});
