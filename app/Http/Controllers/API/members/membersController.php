<?php

namespace App\Http\Controllers\API\members;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class membersController extends Controller
{


    public function store(Request $request){

                $validator = validator::make($request->all(),[


                    'first_name'          => 'required',
                    'middle_name'         => 'required',
                    'last_name'           => 'required',
                    'gender'              => 'required',
                    'date_of_birth'       => 'required',
                    'group_id'            => 'required',
                    'class_id'            => 'required',
                    'user_name'           => 'required',
                    'password'            => 'required',
                    'confirm_password'    => 'required',
                    'membership_id'	      => 'required',
                    'start_date'	      => 'required',
                    'address'	          => 'required',
                    'city'                => 'required',
                    'phone_number'        => 'required',
                    'email'	              => 'required'


                ]);

                if($validator->fails()){

                    return response()->json(['success' => false , 'message' => $validator->errors()],200);

                }

                return $request;

    }



}
