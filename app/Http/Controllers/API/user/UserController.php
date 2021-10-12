<?php

namespace App\Http\Controllers\API\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = User::all();
        return response()->json(['success'=>true ,'users'=> UsersResource::collection($data)] ,200);
    }


    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return response()->json(['success'=>true ,'roles'=> $roles] ,200);
    }


    public function store(Request $request)
    {
        $validator = validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);


        if($validator->fails()){

            return response()->json(['success'=>false,'message'=>$validator->errors()],200);


        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles')); // بيحطها في جدول الرول

        return response()->json(['success'=>true,'message'=>'User created successfully','user'=>new UsersResource($user)],200);

    }

    public function show($id)
    {
        $user = User::find($id);
        return response()->json(['success'=>true ,'user'=> $user] ,200);
    }



    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all(); // all role to  mind change
        $userRole = $user->roles->pluck('name','name')->all(); //role related this user

        return response()->json(['success'=>true ,'data'=> [
            'user'                  => $user,
            'allRoles'              => $roles,
            'roleRelatedThisUser'   => $userRole

        ]] ,200);
    }




    public function update(Request $request)
    {
        $validator = validator::make($request->all(), [
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,'.$request->id,
            'password' => 'required|same:confirm-password',
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

        $user->assignRole($request->input('roles'));

        return response()->json(['success'=>true ,'message'=> 'updated successfully','user'=>new UsersResource($user)] ,200);

    }



    public function destroy(Request $request)
    {
        User::find($request->id)->delete();
        return response()->json(['success'=>true ,'message'=> 'deleted successfully'] ,200);

    }

}
