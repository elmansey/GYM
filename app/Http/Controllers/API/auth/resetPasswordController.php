<?php

namespace App\Http\Controllers\API\auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\staff;
use App\Mail\resetPassword;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\members_login_information;
use Illuminate\Support\Facades\Validator;

class resetPasswordController extends Controller
{



    public function  forgetPassword(Request $request)
    {

        $validator = validator::make($request->all(),[
            'email' => ['required','email'],
        ]);

        if($validator->fails()){

            return response()->json(['success' => false , 'message' => $validator->errors()]);

        }





        $user = User::where('email','=',$request->email)->get();


        if(count($user) > 0){

            $token = Str::random(64);

            DB::table('password_resets')->insert([

                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()

              ]);



                mail::to($request->email)->send(new resetPassword($token,$request->email));
                // Mail::send(new resetPassword,['token',$token],function($message) use ($request){

                //         $message->to($request->email);
                //         $message->subject('reset password');

                // });

                return response()->json(['success' => true,'message' => 'sending mail successfully'],200);


        }else{
            return response()->json(['success' => false , 'status' => 404 ,'message' => ['email'=> 'the email is not valid']]);
        }



    }

    public function resetPassword(Request $request){




        $validator = validator::make($request->all(),[

            'email'    => ['required','email'],
            'token'    => 'required',
            'password'    => 'required|min:6',
            'confirm_password'    => 'required|same:password'

        ]);


        if($validator->fails()){
            return response()->json(['success' => false , 'message' => $validator->errors()]);
        }


            $updatePassword = DB::table('password_resets')
            ->where(['email'=> $request->email ,'token' => $request->token])->first();


            if(!$updatePassword){

                return response()->json(['success' => false , 'status' => 404]);
            }

            $request['password'] = bcrypt($request['password']);

            $user = User::where('email','=',$request->email)->first();

            $user->password = $request['password'];
            $user->update();


            DB::table('password_resets')->where('email' ,'=', $request->email)->delete();
            return response()->json(['success' => true , 'message' => 'password reset successfully']);



        }



}
