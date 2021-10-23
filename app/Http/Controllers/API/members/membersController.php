<?php

namespace App\Http\Controllers\API\members;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\members_contact_information;
use App\Models\members_extra_information;
use App\Models\members_login_information;
use App\Models\members_personal_information;
use Illuminate\Support\Facades\Validator;

class membersController extends Controller
{


    public function store(Request $request){

                $validator = validator::make($request->all(),[


                    'first_name'          => 'required|unique:members_personal_informations,first_name',
                    'middle_name'         => 'required',
                    'last_name'           => 'required',
                    'gender'              => 'required',
                    'data_of_birth'       => 'required',
                    'group_id'            => 'required',
                    'class_id'            => 'required',
                    'user_name'           => 'required',
                    'password'            => 'required|same:confirm_password',
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



              DB::beginTransaction();

               try{




                if($request->hasFile('profile_picture')){

                    $file = $request->file('profile_picture');
                    $extension = $file->extension();

                    $fileName = md5(time().now().rand(1,10)).'.'.$extension;

                    $file->move(public_path('member_profile_pictures'),$fileName);

                }


               $request->password = bcrypt($request->password);


                  // personal data
                $PersonalInformation                   = new  members_personal_information();
                $PersonalInformation->first_name       = $request->input('first_name');
                $PersonalInformation->middle_name      = $request->input('middle_name');
                $PersonalInformation->last_name        = $request->input('last_name');
                $PersonalInformation->gender           = $request->input('gender');
                $PersonalInformation->date_of_birth    = $request->input('data_of_birth');
                $PersonalInformation->save();


                $MemberId = $PersonalInformation->id;


                // contact data
                $ContactInformation                   = new  members_contact_information();
                $ContactInformation->member_id        = $MemberId;
                $ContactInformation->address          = $request->input('address');
                $ContactInformation->city             = $request->input('city');
                $ContactInformation->phone_number     = $request->input('phone_number');
                $ContactInformation->email            = $request->input('email');
                $ContactInformation->save();


                // extra data
                $ExtraInformation                   = new  members_extra_information();
                $ExtraInformation->member_id        = $MemberId;
                $ExtraInformation->interested_area  = $request->input('interested_area');
                $ExtraInformation->source           = $request->input('source');
                $ExtraInformation->membership_id    = $request->input('membership_id');
                $ExtraInformation->group_id         = $request->input('group_id');
                $ExtraInformation->class_id         = $request->input('class_id');
                $ExtraInformation->start_date       = $request->input('start_date');
                $ExtraInformation->save();



                //login data
                $LoginInformation                   = new  members_login_information();
                $LoginInformation->member_id        = $MemberId;
                $LoginInformation->user_name        = $request->input('user_name');
                $LoginInformation->password         = $request->input('password');
                $LoginInformation->profile_picture  = $fileName;
                $LoginInformation->save();



                DB::commit();
               }
               catch(\Exception $e){
                DB::rollback();
                return $e->getMessage();
               }






                return response()->json(['success' => true],200) ;

    }



}
