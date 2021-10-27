<?php

namespace App\Http\Controllers\API\staff;

use App\Models\staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\RolesResource;
use App\Http\Resources\staffResource;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\VarDumper\VarDumper;

class staffController extends Controller
{
    public function index(){

        $staff = staff::all();

        return response()->json(['success' => true, 'staff' => staffResource::collection($staff)],200);
    }

    public function store(Request $request){

        $validator = validator::make($request->all(), [

            'firstName'        => 'required',
            'middleName'        => 'required',
            'lastName'        => 'required',
            'phone'        => 'required',
            'role_id'        => 'required',


        ]);



        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()]);
        }

        if(isset($request->password) && isset($request->confirm_Password)){

                if($request->password != $request->confirm_Password){

                    return response()->json(['success' => false, 'message' => ['confirm_Password' => 'the confirm password failde must same password failde']]);
                }
        }
        $input  = $request->all();

        if($input['password']){

            $input['password'] = bcrypt($input['password']);

        }
        $role = json_decode($input['role_id'],true);
        $input['role_id'] = $role['id'];

        $fileName = '';
        try{

            DB::beginTransaction();
            if($request->file('avatar')){

                $file = $request->file('avatar');
                $extension = $file->extension();

                $fileName = md5(time().now().rand(1,10)).'.'.$extension;

                $file->move(public_path('profile_pictures'),$fileName);


            }
            DB::commit();

        }catch(\Exception $e){

            DB::rollBack();

       }

       $input['avatar'] = $fileName;

        $staff = staff::create($input);

        $staff->assignRole(json_decode($request->role_id,true));


        return  response()->json(['success' => true,'message' => 'staff add successfully']);

    }


    public function getItemFromStaffById($id){

        $staffPerson = staff::find($id);


        if($staffPerson){

            return response()->json(['success' => true, 'staff' => new staffResource($staffPerson)]);

        }else{
            return response()->json(['success' => false, 'status' => 404]);

        }


    }







    public function getStaffRole(){

        $role = Role::where('name','=','staff')->get();
        return response()->json(['success'=>true ,'staffRole'=>  RolesResource::collection($role)] ,200);

    }
}
