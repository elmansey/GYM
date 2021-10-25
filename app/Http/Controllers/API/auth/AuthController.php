<?php

namespace App\Http\Controllers\API\auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RolesResource;
use App\Http\Resources\UsersResource;
use App\Http\Resources\UserToRoleResource;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(['JWTchecker'])->except(['login']);
    }



    public function login(Request $request)
    {

        $validator = validator::make($request->all(), [

            'email'     => 'required|email',
            'password'  =>  'required'

        ]);


        if ($validator->fails()) {

            return response()->json(['success' => false, 'message' => $validator->errors(), 'status' => '400']);
        } else {




                if (!$token = auth()->guard()->attempt($request->only(['email', 'password']))) {

                    return response()->json(['success' => false, 'message' => 'Unauthorized', 'status' => '401']);
                } else {

                    return Response()->json(['success' => true, 'data' => $this->CreateNewToken($token)]);
                }






        }
    }



    public function info(Request $request)
    {

        try {
                $stillValid = auth()->guard()->check();



        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            auth()->refresh();
        }



        $user = auth()->user();

        $roles = RolesResource::collection($user['roles']);

        $permission = Permission::all();


        $role = [];



        foreach ($roles as $k => $v) {

            $roleAndPermission[] = ['id' => $v->id, 'role' => $v->name, 'permission' => PermissionResource::collection(Permission::join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                ->where('role_has_permissions.role_id', $v->id)->get())];
        }


        return response()->json(['success' => true, 'data' =>  new UserToRoleResource(auth()->user()), 'roleAndPermission' => $roleAndPermission], 200);
    }


    //    public function refresh()
    //    {
    //        return $this->respondWithToken($this->guard()->refresh());
    //    }



    public function logout(Request $request)
    {
        auth()->guard()->logout();
        return response()->json(['success' => true, 'message' => 'Successfully logged out']);
    }





    public function CreateNewToken($token)
    {

        return ([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->guard()->factory()->getTTL() * 10080,
            'user'         =>  auth()->guard()->user()

        ]);
    }




}
