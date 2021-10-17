<?php

namespace App\Http\Controllers\API\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RolesResource;
use App\Http\Resources\UsersResource;
use App\Http\Resources\UserToRoleResource;
use App\Models\User;
use http\Env\Response;
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

        $request['role'] = json_decode($request['role'],true);


        $validator = validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'password' => 'required|same:confirm_password',
            'confirm_password' => 'required',
            'role' => 'required',
            'profile_picture' => 'mimes:jpg,jpeg,png'

        ]);



        if($validator->fails()){

            return response()->json(['success'=>false,'message'=>$validator->errors()],200);

        }

        try{

            DB::beginTransaction();
            if($request->file('profile_picture')){

                $file = $request->file('profile_picture');
                $extension = $file->extension();

                $fileName = md5(time().now().rand(1,10)).'.'.$extension;

                $file->move(public_path('profile_pictures'),$fileName);


            }
            DB::commit();

        }catch(\Exception $e){

            DB::rollBack();

       }


            $input = $request->all();
            $input['password']  = bcrypt($input['password']);
            $input['profile_picture'] = $input['profile_picture'] ? $fileName : null;

        $user =  User::create($input);

        $role = [];


        foreach ($request['role'] as $k => $v){

            $role[] = $v['name'];

        }


        $user->assignRole($role); // بيحطها في جدول الرول

        return response()->json(['success'=>true,'message'=>'User created successfully','user'=>new UsersResource($user)],200);

    }

    public function show($id)
    {
        $user = User::find($id);
        return response()->json(['success'=>true ,'user'=> $user] ,200);
    }




    public function update(Request $request,$id)
    {

        $request['role'] = json_decode($request['role'],true);

        if(!empty($request->input('password'))){

            $required = true;


        }else{

            $required = false;

        }

            $validator = validator::make($request->all(), [
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm_password',
            'confirm_password' => Rule::requiredIf($required),
             'role' => 'required',

        ]);



        if($validator->fails()){

            return response()->json(['success'=>false,'message'=>$validator->errors()],200);

        }


        $input = $request->all();

        try{

            DB::beginTransaction();
            if($input->profile_picture){

                if($request->file('profile_picture')){


                    $file = $request->file('profile_picture');
                    $extension = $file->extension();

                    $fileName = md5(time().now().rand(1,10)).'.'.$extension;

                    $file->move(public_path('profile_pictures'),$fileName);

                }


            }else{

                $input = Arr::except($input,$input->profile_picture);
            }

            DB::commit();

        }catch(\Exception $e){

            DB::rollBack();

        }

        $input['profile_picture'] = $input['profile_picture'] ? $fileName : null;

        if(!empty($input['password'])){

            $input['password'] = bcrypt($input['password']);

        }else{

            $input = Arr::except($input,array('password'));
        }


        $user = User::find($id);
        $user->update($input);

        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $role = [];

        foreach ($request['role'] as $k => $v){

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
