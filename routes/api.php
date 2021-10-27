<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\auth\AuthController;
use App\Http\Controllers\API\user\RoleController;
use App\Http\Controllers\API\user\UserController;
use App\Http\Controllers\API\staff\staffController;
use App\Http\Controllers\API\Groups\GroupsController;
use App\Http\Controllers\API\members\membersController;
use App\Http\Controllers\API\auth\resetPasswordController;
use App\Http\Controllers\API\Memberships\MembershipsController;
use App\Http\Controllers\API\ClassSchedule\ClassScheduleController;

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







    /// global route
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('memberships', [MembershipsController::class, 'index']);
    Route::get('groups', [GroupsController::class, 'index']);
    Route::get('getClassToSelect',[ClassScheduleController::class, 'getClassToSelect']);
    Route::post('addMember',[membersController::class,'store']);

    Route::post('forgetPassword', [resetPasswordController::class, 'forgetPassword']);
    Route::post('resetPassword', [resetPasswordController::class, 'resetPassword']);



// auth route
     Route::group(['middleware' => ['JWTchecker',]], function () {

        Route::get('info', [AuthController::class, 'info'])->name('info');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');



        // role
        Route::resource('roles', RoleController::class);


        //user
        Route::get('users', [UserController::class, 'index'])->name('users');
        Route::post('adminAdd', [UserController::class, 'store'])->name('adminAdd');
        Route::get('createUser', [UserController::class, 'create'])->name('createUser');
        Route::post('userUpdate/{id}', [UserController::class, 'update'])->name('userUpdate');
        Route::get('userDelete/{id}', [UserController::class, 'destroy'])->name('userDelete');
        Route::get('getUserById/{id}', [UserController::class, 'getUserById'])->name('getUserById');


        //role
        Route::get('roles', [RoleController::class, 'index'])->name('roles');
        Route::get('createRole', [RoleController::class, 'create'])->name('create');
        Route::post('roleAdd', [RoleController::class, 'store'])->name('roleAdd');
        Route::post('roleUpdate', [RoleController::class, 'update'])->name('roleUpdate');
        Route::get('roleDelete/{id}', [RoleController::class, 'destroy'])->name('roleDelete');
        Route::get('getRoleById/{id}', [RoleController::class, 'getRoleById'])->name('getRoleById');


        //memberships
        Route::post('addMemberships', [MembershipsController::class, 'store']);
        Route::get('getMembershipsById/{id}', [MembershipsController::class, 'getMembershipsById']);
        Route::post('updateMemberships/{id}', [MembershipsController::class, 'update']);
        Route::get('deleteMemberships/{id}', [MembershipsController::class, 'destroy']);


        //groups
        Route::post('addGroup', [GroupsController::class, 'store']);
        Route::get('getGroupsById/{id}', [GroupsController::class, 'getGroupsById']);
        Route::post('updateGroup/{id}', [GroupsController::class, 'update']);
        Route::get('deleteGroup/{id}', [GroupsController::class, 'destroy']);





        //class_schedules
        Route::get('classes', [ClassScheduleController::class, 'index']);
        Route::post('addClass', [ClassScheduleController::class, 'store']);
        Route::get('getClassById/{id}', [ClassScheduleController::class, 'getClassById']);
        Route::post('updateClass/{id}', [ClassScheduleController::class, 'update']);
        Route::get('deleteClass/{id}', [ClassScheduleController::class, 'destroy']);
        Route::get('getAllCaptainToCreateClass', [ClassScheduleController::class, 'getAllCaptainToCreateClass']);
        Route::post('deleteSelectedItem', [ClassScheduleController::class, 'deleteSelectedItem']);
        Route::get('getClassInDays',[ClassScheduleController::class, 'getClassInDays']);



        //staff
        Route::get('staff', [staffController::class, 'index']);
        Route::post('addInStaff', [staffController::class, 'store']);
        Route::get('getItemFromStaffById/{id}', [staffController::class, 'getItemFromStaffById']);
        Route::post('updateInStaff/{id}', [staffController::class, 'update']);
        Route::get('deleteItemInStaff/{id}', [staffController::class, 'destroy']);
        Route::get('getStaffRole', [staffController::class, 'getStaffRole']);






        //members
        Route::get('members',[membersController::class,'index']);



    });






