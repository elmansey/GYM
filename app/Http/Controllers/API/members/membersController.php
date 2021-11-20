<?php

namespace App\Http\Controllers\API\members;

use QRCode;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\members_extra_information;
use App\Models\members_login_information;
use Illuminate\Support\Facades\Validator;
use App\Models\members_contact_information;
use Illuminate\Validation\Rules\RequiredIf;
use phpDocumentor\Reflection\Types\Boolean;


class membersController extends Controller
{

    public function index(){

        $members   = members_extra_information::with('groupRelation','classRelation')->get();
        return response()->json(['success' => true , 'members' => $members],200);
    }


    public function store(Request $request){


                $allowed = $request['Membership_choose_allow_private_Features'] == 'true'  ? true  : false;

                $validator = validator::make($request->all(),[


                    'name'          => 'required',
                    'gender'              => 'required',
                    'data_of_birth'       => 'required',
                    'group_id'            => Rule::RequiredIf($allowed),
                    'class_id'            => Rule::RequiredIf($allowed),
                    'membership_id'	      => 'required',
                    'start_date'	      => 'required',
                    'address'	          => 'required',
                    'city'                => 'required',
                    'phone'        => 'required',
                    'amount_paid'            => 'required',
                    'period_Expiry'            => 'required',
                    'Subscription_status'            => 'required',
                    'Subscription_period'        => 'required',
                    'RF_code'            => 'required',
                    'isActive'            => 'required',
                    'profile_picture'            => 'required',




                ]);



                if($validator->fails()){

                    return response()->json(['success' => false , 'message' => $validator->errors()],200);

                }

            $request['isActive'] =  $request['isActive'] == 'true' || true || 1 || '1'? true : false;


              DB::beginTransaction();

               try{

                $fileName = '';
                if($request->file('profile_picture')){

                    $file = $request->file('profile_picture');
                    $extension = $file->extension();

                    $fileName = md5(time().now().rand(1,10)).'.'.$extension;

                    $file->move(public_path('profile_pictures'),$fileName);
                    $request['profile_picture'] = $fileName;

                }


                // extra data
                $ExtraInformation                   = new  members_extra_information();
                $ExtraInformation->interested_area  = $request->input('interested_area');
                $ExtraInformation->source           = $request->input('source');
                $ExtraInformation->membership_id    = $request->input('membership_id');
                $ExtraInformation->group_id         = $request->input('group_id');
                $ExtraInformation->class_id         = $request->input('class_id');
                $ExtraInformation->name         = $request->input('name');
                $ExtraInformation->start_date       = $request->input('start_date');
                $ExtraInformation->amount_paid       = $request->input('amount_paid');
                $ExtraInformation->period_Expiry       = $request->input('period_Expiry');
                $ExtraInformation->Subscription_status      = $request->input('Subscription_status');
                $ExtraInformation->Subscription_period      = $request->input('Subscription_period');
                $ExtraInformation->gender           = $request->input('gender');
                $ExtraInformation->date_of_birth    = $request->input('data_of_birth');
                $ExtraInformation->address          = $request->input('address');
                $ExtraInformation->city             = $request->input('city');
                $ExtraInformation->RF_code             = $request->input('RF_code');
                $ExtraInformation->isActive             = $request->input('isActive');
                $ExtraInformation->profile_picture             = $fileName ? $fileName : null ;
                $ExtraInformation->phone             = $request->input('phone');
                $ExtraInformation->save();

                $id = $ExtraInformation->id;
                $dataQR =  $ExtraInformation['Personal_uuid'];
                $QRName = 'profile_QR/'.md5($ExtraInformation['Personal_uuid']) . '.png';
                $qr =  QRCode::text($dataQR)->setOutfile(public_path($QRName))->png();
                $update = members_extra_information::where('id',$id)->first();
                $update->update(
                    ['qr_code' =>  $QRName ]
                );



                DB::commit();
               }
               catch(\Exception $e){
                DB::rollback();
                return $e->getMessage();
               }






                return response()->json(['success' => true],200) ;

    }


    public function getMemberById($id){


        $extraInformation      = members_extra_information::where('id','=',$id)->first();


        return response()->json([
             'success'  => true  ,
             'extraInformation'    => $extraInformation
            ]);
    }


    public function update(Request $request, $id){


        $allowed = $request['Membership_choose_allow_private_Features'] == 'true' ? true  : false;


        if($request['password']){

            $required = true;


        }else{

            $required = false;

        }

        $validator = validator::make($request->all(),[


            'name'          => 'required',
            'gender'              => 'required',
            'data_of_birth'       => 'required',
            'group_id'            => Rule::RequiredIf($allowed),
            'class_id'            => Rule::RequiredIf($allowed),
            'membership_id'	      => 'required',
            'start_date'	      => 'required',
            'address'	          => 'required',
            'city'                => 'required',
            'phone'               => 'required',
            'amount_paid'            => 'required',
            'period_Expiry'            => 'required',
            'Subscription_status'        => 'required',
            'Subscription_period'        => 'required',
            'isActive'   => 'required',
            'phone'  => 'required',
            'RF_code'            => 'required',
            'isActive'            => 'required',
            'profile_picture'            => 'required',



        ]);



        if($validator->fails()){

            return response()->json(['success' => false , 'message' => $validator->errors()],200);

        }


        $input = $request->all();

      DB::beginTransaction();

       try{



        if($request->file('profile_picture')){

            $oldImg = members_extra_information::where('id','=',$id)->pluck('profile_picture');

            $path =  public_path('profile_pictures\\'.$oldImg[0]);
            if($oldImg[0]){
                if(file_exists($path)){

                    unlink($path);
                }
            }


            $file = $request->file('profile_picture');
            $extension = $file->extension();

            $fileName = md5(time().now().rand(1,10)).'.'.$extension;

            $file->move(public_path('profile_pictures'),$fileName);

            $input['profile_picture'] = $input['profile_picture'] ? $fileName : null;

        }else{
           $input =  Arr::except($input,array('profile_picture'));
        }

        $input['isActive'] =  $input['isActive'] == 'true' || true || 1 || '1'? true : false;

      // extra data
      $ExtraInformation          =  members_extra_information::where('id','=',$id)->first();

      $ExtraInformation->update($input);


        DB::commit();
       }
       catch(\Exception $e){
        DB::rollback();
        return $e->getMessage();
       }

        return response()->json(['success' => true,'message' => 'member updated successfully'],200) ;


    }



    public function destroy($id){

        $member = members_extra_information::find($id);
        $member->delete();

        return response()->json(['success' => true,'message' => 'member delete successfully']);



    }

}
