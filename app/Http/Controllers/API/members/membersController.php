<?php

namespace App\Http\Controllers\API\members;

use QRCode;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Groups;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\ClassSchedule;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResource;
use App\Http\Resources\groupsResource;
use App\Models\members_extra_information;
use App\Models\members_login_information;
use Illuminate\Support\Facades\Validator;
use App\Models\members_contact_information;
use Illuminate\Validation\Rules\RequiredIf;
use phpDocumentor\Reflection\Types\Boolean;
use App\Http\Resources\class_scheduleResource;
use App\Http\helperMe\addActivetyLogInHistory;


class membersController extends Controller
{
    use addActivetyLogInHistory;

    public function index(){

        $members   = members_extra_information::with('memberShipsRelation')
        ->where('Account_freeze' ,'=', null)->get();
        return response()->json(['success' => true , 'members' => $members],200);
    }

    public function freezeAccountOnly(){

        $members   = members_extra_information::with('memberShipsRelation')
        ->where('Account_freeze' ,'!=', null)->get();
        return response()->json(['success' => true , 'members' => $members],200);
    }


    public function store(Request $request){



                $allowed = $request['Membership_choose_allow_private_Features'] == 'true'  ? true  : false;

                $request['class_id'] =  json_decode($request['class_id'] ,true);
                $request['group_id'] =  json_decode($request['group_id'] ,true);
                $request['source']   = $request['source']  ? "null" : null;
                $request['interested_area']   = $request['interested_area']  ? "null" : null;
                $groupIdes= [];
                if($request['group_id']){

                        foreach ($request['group_id'] as $k => $v ){

                            $groupIdes[] = $v['id'];
                        }
                    $request['group_id'] = $groupIdes;
                }




                $validator = validator::make($request->all(),[


                    'name'          => 'required',
                    'gender'              => 'required',
                    'date_of_birth'       => 'required',
                    'group_id'            => Rule::RequiredIf($allowed),
                    'class_id'            => Rule::RequiredIf($allowed),
                    'membership_id'	      => 'required',
                    'start_date'	      => 'required',
                    'address'	          => 'required',
                    'city'                => 'required',
                    'phone'        => 'required',
                    'period_Expiry'            => 'required',
                    'Subscription_period'        => 'required',
                    'RF_code'            => 'required',
                    'payment'            => 'required',
                    'membership_price'  => 'required',
                    'total_payment'  => 'required',

                ]);



                if($validator->fails()){

                    return response()->json(['success' => false , 'message' => $validator->errors()],200);

                }



              DB::beginTransaction();

               try{

                $fileName = '';
                if($request->file('profile_picture')){

                    $file = $request->file('profile_picture');
                    $extension = $file->extension();

                    $fileName = md5(time().now().rand(1,10)).'.'.$extension;

                    $file->move('profile_pictures/',$fileName);
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
                $ExtraInformation->period_Expiry       = $request->input('period_Expiry');
                $ExtraInformation->payment      = $request->input('payment');
                $ExtraInformation->gender           = $request->input('gender');
                $ExtraInformation->date_of_birth    = $request->input('date_of_birth');
                $ExtraInformation->address          = $request->input('address');
                $ExtraInformation->city             = $request->input('city');
                $ExtraInformation->RF_code             = $request->input('RF_code');
                $ExtraInformation->total_payment             = $request->input('total_payment');
                $ExtraInformation->membership_price             = $request->input('membership_price');
                $ExtraInformation->Subscription_period             = $request->input('Subscription_period');
                $ExtraInformation->profile_picture             = $fileName ? $fileName : null ;
                $ExtraInformation->phone             = $request->input('phone');
                $ExtraInformation->save();

                $id = $ExtraInformation->id;
                $dataQR =  $ExtraInformation['Personal_uuid'];
                $QRName = 'profile_QR/'.md5($ExtraInformation['Personal_uuid']) . '.png';
                $qr =  QRCode::text($dataQR)->setOutfile($QRName)->png();
                $update = members_extra_information::where('id',$id)->with('memberShipsRelation')->first();
                $update->update(
                    ['qr_code' =>  $QRName ]
                );



                DB::commit();
               }
               catch(\Exception $e){
                DB::rollback();
                return $e->getMessage();
               }


                $userId = auth()->user()->id;
                $title  = 'has added a  new member';
                $date = Carbon::now('Africa/Cairo')->format('D, M, d Y H:i:s A');
                $this->saveLogs($userId,$title,$date);



            return response()->json(['success' => true ,'added_by' => new UsersResource(auth()->user()) , 'member' => $update],200) ;

    }


    public function getMemberById($id){


        $extraInformation      = members_extra_information::where('id','=',$id)->with('memberShipsRelation')->first();



          $groups = Groups::whereIn('id', $extraInformation['group_id'])->get();
        //   $class = ClassSchedule::whereIn('id', $extraInformation['class_id'])->get();
          $extraInformation['group_id'] = groupsResource::collection($groups);
        //   $extraInformation['class_id'] = class_scheduleResource::collection($class);

        return response()->json([
             'success'  => true  ,
             'extraInformation'    => $extraInformation
            ]);
    }


    public function update(Request $request, $id){


        $allowed = $request['Membership_choose_allow_private_Features'] == 'true' ? true  : false;

        $request['class_id'] =  json_decode($request['class_id'] ,true);
        $request['group_id'] =  json_decode($request['group_id'] ,true);
        $request['source']   = $request['source']  ? "null" : null;
        $request['interested_area']   = $request['interested_area']  ? "null" : null;
        $groupIdes= [];
        if($request['group_id']){

                foreach ($request['group_id'] as $k => $v ){

                    $groupIdes[] = $v['id'];
                }
            $request['group_id'] = $groupIdes;
        }



        $validator = validator::make($request->all(),[


            'name'          => 'required',
            'gender'              => 'required',
            'date_of_birth'       => 'required',
            'group_id'            => Rule::RequiredIf($allowed),
            'class_id'            => Rule::RequiredIf($allowed),
            'membership_id'	      => 'required',
            'start_date'	      => 'required',
            'address'	          => 'required',
            'city'                => 'required',
            'phone'        => 'required',
            'period_Expiry'            => 'required',
            'Subscription_period'        => 'required',
            'RF_code'            => 'required',
            'payment'            => 'required',
            'membership_price'  => 'required',
            'total_payment'  => 'required',

        ]);



        if($validator->fails()){

            return response()->json(['success' => false , 'message' => $validator->errors()],200);

        }


        $input = $request->all();

      DB::beginTransaction();

       try{



        if($request->hasFile('profile_picture')){

            $oldImg = members_extra_information::where('id','=',$id)->pluck('profile_picture');

            $path =  'profile_pictures\\'.$oldImg[0];
            if($oldImg[0]){
                if(file_exists($path)){

                    unlink($path);
                }
            }


            $file = $request->file('profile_picture');
            $extension = $file->extension();

            $fileName = md5(time().now().rand(1,10)).'.'.$extension;

            $file->move('profile_pictures/',$fileName);

            $input['profile_picture'] = $input['profile_picture'] ? $fileName : null;

        }else{
           $input =  Arr::except($input,array('profile_picture'));
        }


      // extra data
      $ExtraInformation          =  members_extra_information::where('id','=',$id)->first();

      $ExtraInformation->update($input);


        DB::commit();
       }
       catch(\Exception $e){
        DB::rollback();
        return $e->getMessage();
       }


       $userId = auth()->user()->id;
       $title  = 'has edit  in   '. $ExtraInformation['Personal_uuid'] .  " account";
       $date = Carbon::now('Africa/Cairo')->format('D, M, d Y H:i:s A');
       $this->saveLogs($userId,$title,$date);




        return response()->json(['success' => true,'message' => 'member updated successfully'],200) ;


    }



    public function destroy($id){

        $member = members_extra_information::find($id);
        $member->delete();

        $userId = auth()->user()->id;
        $title  = 'has deleted  ' . $member['Personal_uuid'] .  " account";
        $date = Carbon::now('Africa/Cairo')->format('D, M, d Y H:i:s A');
        $this->saveLogs($userId,$title,$date);

        return response()->json(['success' => true,'message' => 'member delete successfully']);



    }


    public function freezeThisAccount($id){

        $member = members_extra_information::find($id);
        $date =  Carbon::now('Africa/Cairo')->toDateString();
         $fDate =  Carbon::now('Africa/Cairo')->format('Y-m-d h:i:s');
        $today =  strtotime($date);
        $period_Expiry =  strtotime($member['period_Expiry']);

        $b = $period_Expiry - $today;

            // //    1 day = 24 hours
            // //    1 hour = 60 minute
            // //    1 minute = 60 seconds

            // //     24 * 60 * 60 = 86400 seconds
            // //     abs return postive number
            // //     ceil return الي عدد صحيح

           $countDaysLeft = ceil(abs($b  / 86400 )); # 86400 seconds to 1 day
           $logs =  $member['log'];
           $logs = collect($logs)->push([ 'key' => 'Freeze' , 'value' => $fDate, ]);

        $member->update(['log' => $logs , 'Account_freeze' => $date, 'days_left_before_freezing' => $countDaysLeft]);


        $userId = auth()->user()->id;
        $title  = 'has freeze  ' . $member['Personal_uuid'] .  " account";
        $date = Carbon::now('Africa/Cairo')->format('D, M, d Y H:i:s A');
        $this->saveLogs($userId,$title,$date);


            return response()->json(['success' => true , 'message' , 'account freezeing succefully'],200);

    }

    public function unFreezeThisAccount($id){

        $member = members_extra_information::find($id);
        $date =  Carbon::now('Africa/Cairo');
        $unFreezeDate = Carbon::now('Africa/Cairo')->toDateString();
        $New_period_Expiry =  $date->addDays((int)$member['days_left_before_freezing']);
        $New_period_Expiry =  $New_period_Expiry->format('Y-m-d');
        $logs =  $member['log'];
         $fDate =  Carbon::now('Africa/Cairo')->format('Y-m-d h:i:s');
        $logs =collect($logs)->push(['key' => 'unFreeze' , 'value' => $fDate]);
        $member->update(['log' => $logs ,'unFreeze_in' => $unFreezeDate, 'status' => 'unFreeze','Account_freeze' => null , 'period_Expiry' => $New_period_Expiry ]);



        $userId = auth()->user()->id;
        $title  = 'has unfreeze  ' . $member['Personal_uuid'] .  " account";
        $date = Carbon::now('Africa/Cairo')->format('D, M, d Y H:i:s A');
        $this->saveLogs($userId,$title,$date);


        return response()->json(['success' => true , 'message' => 'unFreeze successfully'],200);
    }

}
