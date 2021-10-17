<?php

namespace App\Http\Controllers\API\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RolesResource;
use App\Http\Resources\UsersResource;
use App\Http\Resources\UserToRoleResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = User::all();
        return response()->json(['success'=>true ,'admins'=> UsersResource::collection($data)] ,200);
    }


    public function create()
    {
        $roles = Role::all();
        return response()->json(['success'=>true ,'roles'=> RolesResource::collection($roles)] ,200);
    }


    public function store(Request $request)
    {


        return  $request;

//        $validator = validator::make($request->all(), [
//            'name' => 'required',
//            'email' => 'required|email|unique:users,email',
//            'phone' => 'required',
//            'password' => 'required|same:confirm_password',
//            'confirm_password' => 'required',
//            'roles' => 'required'
//        ]);
//
//
//
//        if($validator->fails()){
//
//            return response()->json(['success'=>false,'message'=>$validator->errors()],200);
//
//
//        }
//
//        $input = $request->all();
//        $input['password']  = bcrypt($input['password']);
//
//
//
//        $user =  User::create($input);
//
//        $role = [];
//
//        foreach ($request->roles as $k => $v){
//
//            $role[] = $v['name'];
//
//        }
//
//
//        $user->assignRole($role); // بيحطها في جدول الرول
//
//        return response()->json(['success'=>true,'message'=>'User created successfully','user'=>new UsersResource($user)],200);

    }

    public function show($id)
    {
        $user = User::find($id);
        return response()->json(['success'=>true ,'user'=> $user] ,200);
    }




    public function update(Request $request)
    {

        if($request->input('password')){

            $required = true;


        }else{
            $required = false;

        }

            $validator = validator::make($request->all(), [
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,'.$request->id,
            'password' => 'same:confirm_password',
            'confirm_password' => Rule::requiredIf($required),
            'roles'    => 'required'
        ]);



        if($validator->fails()){

            return response()->json(['success'=>false,'message'=>$validator->errors()],200);

        }


        $input = $request->all();

        if(!empty($input['password'])){

            $input['password'] = bcrypt($input['password']);

        }else{

            $input = Arr::except($input,array('password'));
        }


        $user = User::find($request->id);
        $user->update($input);

        DB::table('model_has_roles')->where('model_id',$request->id)->delete();

        $role = [];

        foreach ($request->roles as $k => $v){

            $role[] = $v['name'];
        }
        $user->assignRole($role);

        return response()->json(['success'=>true ,'message'=> 'updated successfully','user'=>new UsersResource($user)] ,200);

    }


    public function getUserById($id){

        $user = User::find($id);
        $roles = RolesResource::collection($user['roles']);

        $role= [];


        return response()->json(['success'=>true, 'data'=>  new UserToRoleResource($user),'role'=>RolesResource::collection($roles)],200);




    }



    public function destroy($id)
    {

       $user =  User::find($id);
       $user->delete();
        return response()->json(['success'=>true ,'message'=> 'deleted successfully'] ,200);

    }

}
