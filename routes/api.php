<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\auth\AuthController;
use App\Http\Controllers\API\user\RoleController;
use App\Http\Controllers\API\user\UserController;
use App\Http\Controllers\API\staff\staffController;
use App\Http\Controllers\API\chat\teamChatController;
use App\Http\Controllers\API\Groups\GroupsController;
use App\Http\Controllers\API\members\membersController;
use App\Http\Controllers\API\setting\settingController;
use App\Http\Controllers\API\products\productController;
use App\Http\Controllers\API\auth\resetPasswordController;
use App\Http\Controllers\API\statistics\statisticsController;
use App\Http\Controllers\API\attendancce\attendanceController;
use App\Http\Controllers\API\Memberships\MembershipsController;
use App\Http\Controllers\API\ClassSchedule\ClassScheduleController;
use App\Http\Controllers\API\History\activityLogsController;
use App\Http\Controllers\API\product_invoice\product_invoiceController;

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
Route::post('/login', [AuthController::class, 'login'])->name('login');



Route::post('forgetPassword', [resetPasswordController::class, 'forgetPassword']);
Route::post('resetPassword', [resetPasswordController::class, 'resetPassword']);



// auth route
Route::group(['middleware' => ['auth:api',]], function () {





    Route::get('info', [AuthController::class, 'info'])->name('info');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');



    // role
    Route::resource('roles', RoleController::class);


    //user
    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::get('getAllPersonToAttendance', [UserController::class, 'getAllPersonToAttendance'])->name('getAllPersonToAttendance');
    Route::get('getUserToChatIgnoreMe/{email}', [UserController::class, 'getUserToChatIgnoreMe'])->name('getUserToChatIgnoreMe');
    Route::post('adminAdd', [UserController::class, 'store'])->name('adminAdd');
    Route::get('createUser', [UserController::class, 'create'])->name('createUser');
    Route::post('userUpdate/{id}', [UserController::class, 'update'])->name('userUpdate');
    Route::get('userDelete/{id}', [UserController::class, 'destroy'])->name('userDelete');
    Route::get('getUserById/{id}', [UserController::class, 'getUserById'])->name('getUserById');
    Route::post('updateProfileInfo/{id}', [UserController::class, 'updateProfileInfo'])->name('updateProfileInfo');


    //role
    Route::get('roles', [RoleController::class, 'index'])->name('roles');
    Route::get('createRole', [RoleController::class, 'create'])->name('create');
    Route::post('roleAdd', [RoleController::class, 'store'])->name('roleAdd');
    Route::post('roleUpdate', [RoleController::class, 'update'])->name('roleUpdate');
    Route::get('roleDelete/{id}', [RoleController::class, 'destroy'])->name('roleDelete');
    Route::get('getRoleById/{id}', [RoleController::class, 'getRoleById'])->name('getRoleById');
    Route::get('getAllUserToCustomPermission', [RoleController::class, 'getAllUserToCustomPermission'])->name('getAllUserToCustomPermission');
    Route::post('assignCustomPermissions', [RoleController::class, 'assignCustomPermissions']);
    Route::get('getOldCustomPermission/{id}', [RoleController::class, 'getOldCustomPermission']);



    //memberships
    Route::get('memberships', [MembershipsController::class, 'index']);
    Route::post('addMemberships', [MembershipsController::class, 'store']);
    Route::get('getMembershipsById/{id}', [MembershipsController::class, 'getMembershipsById']);
    Route::post('updateMemberships/{id}', [MembershipsController::class, 'update']);
    Route::get('deleteMemberships/{id}', [MembershipsController::class, 'destroy']);
    Route::get('getClassToSelect', [ClassScheduleController::class, 'getClassToSelect']);
    Route::get('IsAllowFuatureInThisMembership/{id}', [MembershipsController::class, 'IsAllowFuatureInThisMembership']);


    //groups

    Route::get('groups', [GroupsController::class, 'index']);
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
    Route::get('getAllPersonInStaffToCreateClass', [ClassScheduleController::class, 'getAllPersonInStaffToCreateClass']);
    Route::post('deleteSelectedItem', [ClassScheduleController::class, 'deleteSelectedItem']);
    Route::get('getClassInDays', [ClassScheduleController::class, 'getClassInDays']);
    Route::post('getAllClasseRelatedToThisGroup', [ClassScheduleController::class, 'getAllClasseRelatedToThisGroup']);


    //staff
    Route::get('staff', [staffController::class, 'index']);
    Route::get('getStaffToChatIgnoreMe/{email}', [staffController::class, 'getStaffToChatIgnoreMe']);
    Route::post('addInStaff', [staffController::class, 'store']);
    Route::get('getItemFromStaffById/{id}', [staffController::class, 'getItemFromStaffById']);
    Route::post('updateInStaff/{id}', [staffController::class, 'update']);
    Route::get('deleteItemInStaff/{id}', [staffController::class, 'destroy']);
    Route::get('getStaffRole', [staffController::class, 'getStaffRole']);






    //members should auth
    Route::get('members', [membersController::class, 'index']);
    Route::get('freezeAccountOnly', [membersController::class, 'freezeAccountOnly']);
    Route::get('getMemberById/{id}', [membersController::class, 'getMemberById']);
    Route::post('updateMember/{id}', [membersController::class, 'update']);
    Route::get('deleteMember/{id}', [membersController::class, 'destroy']);
    Route::post('addMember', [membersController::class, 'store']);
    Route::get('freezeThisAccount/{id}', [membersController::class, 'freezeThisAccount']);
    Route::get('unFreezeThisAccount/{id}', [membersController::class, 'unFreezeThisAccount']);
    Route::get('Subscription_Expiry', [membersController::class, 'Subscription_Expiry']);






    // chat
    Route::post('addMessageInTeamChat', [teamChatController::class, 'store']);
    Route::post('getOldMessageInChat', [teamChatController::class, 'getOldMessageInChat']);
    Route::post('setReadingMessage', [teamChatController::class, 'setReadingMessage']);




    //products

    Route::get('products', [productController::class, 'index']);
    Route::post('add_product', [productController::class, 'store']);
    Route::get('getProductById/{id}', [productController::class, 'getProductById']);
    Route::post('edit_product/{id}', [productController::class, 'update']);
    Route::get('deleteProduct/{id}', [productController::class, 'destroy']);


    //product invoices
    Route::get('product_invoices', [product_invoiceController::class, 'index']);
    Route::post('add_product_invoice', [product_invoiceController::class, 'store']);
    Route::get('getInvoiceById/{id}', [product_invoiceController::class, 'getInvoiceById']);
    Route::get('deleteThisInvoice/{id}', [product_invoiceController::class, 'destroy']);
    Route::get('archivedThisInvoice/{id}', [product_invoiceController::class, 'archivedThisInvoice']);
    Route::get('product_invoicesOnlyArchived', [product_invoiceController::class, 'product_invoicesOnlyArchived']);
    Route::get('restoreInvoiceInvoice/{id}', [product_invoiceController::class, 'restoreInvoiceInvoice']);



    //attendance

    Route::post('saveAttendance', [attendanceController::class, 'store']);
    Route::get('attendance', [attendanceController::class, 'index']);
    Route::post('attendanceFilter', [attendanceController::class, 'attendanceFilter']);
    Route::post('attendanceSelectedToDelete', [attendanceController::class, 'attendanceSelectedToDelete']);





    //setting data
    Route::get('allSetting', [settingController::class, 'index']);
    Route::post('editSetting', [settingController::class, 'update']);



    //statistics
    Route::get('statistics', [statisticsController::class, 'index']);





    // history || activity logs

    Route::get('history', [activityLogsController::class, 'index']);
    Route::get('lastLogs', [activityLogsController::class, 'lastLogs']);
    // Route::post('addActivityLogs' , [activityLogsController::class, 'store']);




});
