<?php

namespace App\Http\Controllers\API\auth;

use App\Models\User;
use http\Env\Response;
use App\Mail\resetPassword;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\RolesResource;
use App\Http\Resources\UsersResource;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\UserToRoleResource;

class AuthController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['JWTchecker'])->except(['login','resetPassword']);
        $this->middleware(['auth:admin,staff'])->except(['login','resetPassword']);

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




                if ($token = Auth::guard('admin')->attempt($request->only(['email', 'password']))) {
                    // return 'admin';
                    return Response()->json(['success' => true, 'data' => $this->adminCreateNewToken($token)]);

                } else if($token = Auth::guard('staff')->attempt($request->only(['email', 'password']))) {
                        // return 'saff';
                    return Response()->json(['success' => true, 'data' => $this->staffCreateNewToken($token)]);


                }else if($token = Auth::guard('member')->attempt($request->only(['email', 'password']))) {

                    // return 'member';
                return Response()->json(['success' => true, 'data' => $this->memberCreateNewToken($token)]);


                }else{
                    return response()->json(['success' => false, 'message' => 'Unauthorized', 'status' => '401']);
                }
        }
    }



    public function info(Request $request)
    {
        if (auth('admin')->check()){

            $user = Auth::guard('admin')->user()->roles;

            $roles = RolesResource::collection($user);

            $permission = Permission::all();


            $role = [];


            $roleAndPermission = [];

            for ($i = 0 ; $i < count($roles) ; $i++) {
                $role[] = $roles[$i];
            }

            foreach ($role as $kay => $val){
                // return $val['id'];
                $roleAndPermission[] = ['id' => $val->id, 'role' => $val->name, 'permission' => PermissionResource::collection(Permission::join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                ->where('role_has_permissions.role_id','=', $val->id)->get())];
            }



            return response()->json(['success' => true, 'data' =>  new UserToRoleResource(Auth::guard('admin')->user()), 'roleAndPermission' => $roleAndPermission], 200);

        }
        else if(auth('staff')->check()){

            $user = Auth::guard('staff')->user()->roles;


            $roles = RolesResource::collection($user);

            $permission = Permission::all();


            $role = [];


            $roleAndPermission = [];

            for ($i = 0 ; $i < count($roles) ; $i++) {
                $role[] = $roles[$i];
            }

            foreach ($role as $kay => $val){
                // return $val['id'];
                $roleAndPermission[] = ['id' => $val->id, 'role' => $val->name, 'permission' => PermissionResource::collection(Permission::join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                ->where('role_has_permissions.role_id','=', $val->id)->get())];
            }



            return response()->json(['success' => true, 'data' =>  Auth::guard('staff')->user(), 'roleAndPermission' => $roleAndPermission], 200);

        }

        else if(auth('member')->check()){

            $user = Auth::guard('member')->user()->roles;


            $roles = RolesResource::collection($user);

            $permission = Permission::all();


            $role = [];


            $roleAndPermission = [];

            for ($i = 0 ; $i < count($roles) ; $i++) {
                $role[] = $roles[$i];
            }

            foreach ($role as $kay => $val){
                // return $val['id'];
                $roleAndPermission[] = ['id' => $val->id, 'role' => $val->name, 'permission' => PermissionResource::collection(Permission::join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                ->where('role_has_permissions.role_id','=', $val->id)->get())];
            }



            return response()->json(['success' => true, 'data' =>  Auth::guard('member')->user(), 'roleAndPermission' => $roleAndPermission], 200);
        }else{
            auth()->refresh();
        }







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






    public function adminCreateNewToken($token)
    {

        return ([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => Auth::guard('admin')->factory()->getTTL() * 10080,
            'user'         =>  Auth::guard('admin')->user()

        ]);
    }

    public function staffCreateNewToken($token)
    {

        return ([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => Auth::guard('staff')->factory()->getTTL() * 10080,
            'user'         =>  Auth::guard('staff')->user()

        ]);
    }

    public function memberCreateNewToken($token)
    {

        return ([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => Auth::guard('member')->factory()->getTTL() * 10080,
            'user'         =>  Auth::guard('member')->user()

        ]);
    }







}
