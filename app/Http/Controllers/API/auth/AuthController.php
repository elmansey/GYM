<?php

namespace App\Http\Controllers\API\auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResource;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
   public function __construct()
   {
       $this->middleware(['JWTchecker'])->except(['login']);
   }



   public function login(Request $request){

       $validator = validator::make($request->all(),[

           'email'     => 'required|email',
           'password'  =>  'required'

       ]);


       if($validator->fails()){

           return response()->json(['success'=>false,'message'=>$validator->errors(),'status'=>'400']);

       }else{

           if(!$token = auth()->guard('api')->attempt($request->only(['email','password']))){

               return response()->json(['success'=>false,'message'=>'Unauthorized','status'=>'401']);

           }else{

               return Response()->json(['success'=>true,'data'=>$this->CreateNewToken($token)]);
           }

       }

   }



   public function info(Request $request){

       try{
           $stillValid = auth('api')->check();
       }catch(\Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
           auth()->refresh();
       }

       return response()->json(['success'=>true, 'data'=>  new UsersResource(auth()->user())],200);

   }


//    public function refresh()
//    {
//        return $this->respondWithToken($this->guard()->refresh());
//    }



   public function logout(Request $request){

       auth()->guard('api')->logout();
       return response()->json(['success' =>true ,'message' => 'Successfully logged out']);
   }





   public function CreateNewToken($token){

       return ([
           'access_token' => $token,
           'token_type'   => 'bearer',
           'expires_in'   => auth('api')->factory()->getTTL() * 10080 ,
           'user'         => auth()->guard('api')->user()

       ]);
   }
}
