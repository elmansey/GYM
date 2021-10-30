<?php

namespace App\Http\Controllers\API\members;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\members_extra_information;
use App\Models\members_login_information;
use Illuminate\Support\Facades\Validator;
use App\Models\members_contact_information;
use phpDocumentor\Reflection\Types\Boolean;
use App\Models\members_personal_information;
use Illuminate\Validation\Rule;

class membersController extends Controller
{

    public function index(){

        $members_login_information    = members_login_information::with('personalTableRelation')->get();


        return response()->json(['success' => true , 'members' => $members_login_information],200);
    }


    public function store(Request $request){



                $validator = validator::make($request->all(),[


                    'first_name'          => 'required',
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
                    'email'	              => 'required|email|unique:users,email|unique:staff,email|unique:members_login_informations,email'


                ]);



                if($validator->fails()){

                    return response()->json(['success' => false , 'message' => $validator->errors()],200);

                }




              DB::beginTransaction();

               try{



                $fileName = null;
                if($request->hasFile('profile_picture')){

                    $file = $request->file('profile_picture');
                    $extension = $file->extension();

                    $fileName = md5(time().now().rand(1,10)).'.'.$extension;

                    $file->move(public_path('profile_pictures'),$fileName);

                }


               $request->role     = json_decode($request->role,true);


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
                $LoginInformation->password         = bcrypt($request->input('password'));
                $LoginInformation->profile_picture  = $fileName;
                $LoginInformation->isActive         = $request->input('isActive') == 'true' ? true : false;
                $LoginInformation->email            = $request->input('email');
                $LoginInformation->save();

                $role  = $request->role;
                $LoginInformation->assignRole($role);




                DB::commit();
               }
               catch(\Exception $e){
                DB::rollback();
                return $e->getMessage();
               }






                return response()->json(['success' => true],200) ;

    }


    public function getMemberById($id){

        $personalInformation   = members_personal_information::where('id','=',$id)->first();
        $loginInformation      = members_login_information::where('member_id','=',$id)->first();
        $contentInformation    = members_contact_information::where('member_id','=',$id)->first();
        $extraInformation      = members_extra_information::where('member_id','=',$id)->first();


        return response()->json([
             'success'  => true  ,
             'personalInformation' => $personalInformation,
             'loginInformation'    => $loginInformation  ,
             'contentInformation'  => $contentInformation ,
             'extraInformation'    => $extraInformation]);
    }


    public function update(Request $request, $id){



        if($request['password']){

            $required = true;


        }else{

            $required = false;

        }

        $validator = validator::make($request->all(),[


            'first_name'          => 'required',
            'middle_name'         => 'required',
            'last_name'           => 'required',
            'gender'              => 'required',
            'data_of_birth'       => 'required',
            'group_id'            => 'required',
            'class_id'            => 'required',
            'user_name'           =>  ['required',Rule::unique('members_login_informations')->ignore($id)],
            'confirm_password'    => Rule::requiredIf($required),
            'membership_id'	      => 'required',
            'start_date'	      => 'required',
            'address'	          => 'required',
            'city'                => 'required',
            'phone_number'        => 'required',
            'email'	              => 'required|email|unique:users,email|unique:staff,email|unique:members_login_informations,email,'.$id,
            'role'                 => 'required'

        ]);



        if($validator->fails()){

            return response()->json(['success' => false , 'message' => $validator->errors()],200);

        }


        $input = $request->all();

      DB::beginTransaction();

       try{



        $fileName = null;
        if($request->hasFile('profile_picture')){

            $file = $request->file('profile_picture');
            $extension = $file->extension();

            $fileName = md5(time().now().rand(1,10)).'.'.$extension;

            $file->move(public_path('profile_pictures'),$fileName);

            $input['profile_picture'] = $fileName;

        }else{
            $input =  Arr::except($input,array('profile_picture'));
        }



        if(!empty($input['password'])){

            $input['password'] = bcrypt($input['password']);

        }else{

        $input =  Arr::except($input,array('password'));
        }





        // personal data
      $PersonalInformation              = members_personal_information::where('id','=',$id);
      $PersonalInformation ->update([

        'first_name'   => $input['first_name'],
        'middle_name'   => $input['middle_name'],
        'last_name'   => $input['last_name'],
        'gender'   => $input['gender'],
        'date_of_birth'   => $input['data_of_birth'],
      ]);

      // contact data
      $ContactInformation       =  members_contact_information::where('member_id','=',$id)->first();
      $ContactInformation->update([
        'address' => $input['address'],
        'city' => $input['city'],
        'phone_number' => $input['phone_number'],
      ]);



      // extra data
      $ExtraInformation          =  members_extra_information::where('member_id','=',$id)->first();
      $ExtraInformation->update([

        'interested_area'   => $input['interested_area'],
        'source'   => $input['source'],
        'membership_id'   => $input['membership_id'],
        'group_id'   => $input['group_id'],
        'class_id'   => $input['class_id'],
        'start_date'   => $input['start_date'],

      ]);




      $input['isActive'] =  $input['isActive'] == 'true' ? true : false;
      //login data
      $LoginInformation                   = members_login_information::where('member_id','=',$id)->first();
      $LoginInformation->update($input);

      DB::table('model_has_roles')->where([['model_id','=',$id],['model_type','=','APP\Models\members_login_information']])->delete();



      $LoginInformation->assignRole(json_decode($input['role'],true));


        DB::commit();
       }
       catch(\Exception $e){
        DB::rollback();
        return $e->getMessage();
       }

        return response()->json(['success' => true,'message' => 'member updated successfully'],200) ;


    }



    public function destroy($id){

        $oldImg = members_login_information::where('member_id','=',$id)->pluck('profile_picture');

        $path =  public_path('profile_pictures\\'.$oldImg[0]);

        if($oldImg[0]){
            if(file_exists($path)){

                unlink($path);
            }
        }

        $member = members_personal_information::find($id);
        $member->delete();

        return response()->json(['success' => true,'message' => 'member delete successfully']);



    }

}
