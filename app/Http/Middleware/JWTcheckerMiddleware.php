<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JWTcheckerMiddleware
{

    public function handle(Request $request, Closure $next)
    {


        try{


                $user = JWTAuth::parseToken()->authenticate();

        }catch(\Exception $e){

            if($e instanceof TokenInvalidException){

                return response()->json(['success'=>false],['message'=>'the token is invalid']);

            }else if($e instanceof TokenExpiredException){

                return response()->json(['success'=>false],['message'=>'the token is Expired']);
            }else{

                return response()->json(['success'=>false],['message'=>'the token not found']);

            }



        }







        return $next($request);
    }
}
