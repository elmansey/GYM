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
use App\Models\model_has_permissions;


class AuthController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['JWTchecker'])->except(['login','resetPassword']);
        $this->middleware(['auth:api'])->except(['login','resetPassword']);

    }



    public function login(Request $request)
    {



        $validator = validator::make($request->all(), [

            'email'     => 'required|email',
            'password'  =>  'required'

        ]);


        if ($validator->fails()) {

            return response()->json(['success' => false, 'message' => $validator->errors(), 'status' => '400']);
        }




                if ($token = Auth::guard()->attempt($request->only(['email', 'password']))) {
                    // return 'admin';
                    return Response()->json(['success' => true, 'data' => $this->CreateNewToken($token)]);

                }else{
                    return response()->json(['success' => false, 'message' => 'Unauthorized', 'status' => '401']);
                }
    }



    public function info(Request $request)
    {


            $user = Auth::guard()->user()->roles;

            $roles = RolesResource::collection($user);

            $permission = Permission::all();


            $role = [];


            $roleAndPermission = [];
            $customPermission = model_has_permissions::with('permissionRelassion')->where('model_id','=',Auth()->user()->id)->get();


            for ($i = 0 ; $i < count($roles) ; $i++) {
                $role[] = $roles[$i];
            }

            foreach ($role as $kay => $val){
                // return $val['id'];
                $roleAndPermission[] = ['id' => $val->id, 'role' => $val->name, 'permission' => PermissionResource::collection(Permission::join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                ->where('role_has_permissions.role_id','=', $val->id)->get())];
                
            }





            return response()->json(['success' => true, 'data' =>  new UserToRoleResource(Auth::guard()->user()), 'roleAndPermission' => $roleAndPermission,'customPermission' => $customPermission], 200);

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
            'expires_in'   => Auth::guard()->factory()->getTTL() * 10080,
            'user'         =>  Auth::guard()->user()

        ]);
    }











}
