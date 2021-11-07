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
use App\Models\User;
use Illuminate\Validation\Rule;

class membersController extends Controller
{

    public function index(){

        $members   = User::role('member')->get();



        return response()->json(['success' => true , 'members' => $members],200);
    }


    public function store(Request $request){



                $validator = validator::make($request->all(),[


                    'name'          => 'required',
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
                    'phone'        => 'required',
                    'email'	              => 'required|email|unique:users,email'


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



                //login data
                $LoginInformation                   = new  User();
                $LoginInformation->name        = $request->input('name');
                $LoginInformation->user_name        = $request->input('user_name');
                $LoginInformation->password         = bcrypt($request->input('password'));
                $LoginInformation->profile_picture  = $fileName;
                $LoginInformation->isActive         = $request->input('isActive') == 'true' ? true : false;
                $LoginInformation->email            = $request->input('email');
                $LoginInformation->phone     = $request->input('phone');

                $LoginInformation->save();

                $role  = $request->role;
                $LoginInformation->assignRole($role);



                $MemberId = $LoginInformation->id;



                  // personal data
                $PersonalInformation                   = new  members_personal_information();
                $PersonalInformation->name             = $request->input('name');
                $PersonalInformation->member_id        = $MemberId;
                $PersonalInformation->gender           = $request->input('gender');
                $PersonalInformation->date_of_birth    = $request->input('data_of_birth');
                $PersonalInformation->save();





                // contact data
                $ContactInformation                   = new  members_contact_information();
                $ContactInformation->member_id        = $MemberId;
                $ContactInformation->address          = $request->input('address');
                $ContactInformation->city             = $request->input('city');
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







                DB::commit();
               }
               catch(\Exception $e){
                DB::rollback();
                return $e->getMessage();
               }






                return response()->json(['success' => true],200) ;

    }


    public function getMemberById($id){

        $personalInformation   = members_personal_information::where('member_id','=',$id)->first();
        $loginInformation      = User::where('id','=',$id)->first();
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


            'name'          => 'required',
            'gender'              => 'required',
            'data_of_birth'       => 'required',
            'group_id'            => 'required',
            'class_id'            => 'required',
            'user_name'           =>  ['required',Rule::unique('users')->ignore($id)],
            'confirm_password'    => Rule::requiredIf($required),
            'membership_id'	      => 'required',
            'start_date'	      => 'required',
            'address'	          => 'required',
            'city'                => 'required',
            'phone'               => 'required',
            'email'	              => ['required',Rule::unique('users')->ignore($id)],
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

        'name'   => $input['name'],
        'gender'   => $input['gender'],
        'date_of_birth'   => $input['data_of_birth'],
      ]);

      // contact data
      $ContactInformation       =  members_contact_information::where('member_id','=',$id)->first();
      $ContactInformation->update([
        'address' => $input['address'],
        'city' => $input['city'],
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
      $LoginInformation                   = User::where('id','=',$id)->first();
      $LoginInformation->update($input);

      DB::table('model_has_roles')->where('model_id','=',$id)->delete();



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

        $oldImg = User::where('id','=',$id)->pluck('profile_picture');

        $path =  public_path('profile_pictures\\'.$oldImg[0]);

        if($oldImg[0]){
            if(file_exists($path)){

                unlink($path);
            }
        }

        $member = User::find($id);
        $member->delete();

        return response()->json(['success' => true,'message' => 'member delete successfully']);



    }

}
