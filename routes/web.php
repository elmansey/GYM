<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/ResetPassword',function(){

//         return view('emails.resetNewPassword');

// });







Route::get('{path}',function(){

    return view('layouts.app');

})->where('path','.*');
