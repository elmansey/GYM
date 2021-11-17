<?php

namespace App\Http\Controllers\API\attendancce;

use Carbon\Carbon;
use App\Models\User;
use App\Models\attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\attendanceResource;
use Illuminate\Validation\Rule;
class attendanceController extends Controller
{


    public function index(){

        $attendance = attendance::all();

        return response()->json(['success' => true , 'attendance' => attendanceResource::collection($attendance)]);
    }


    public function store (Request $request){


        $validator = validator::make($request->all(), [

            'date' => 'required',
            'type' => 'required',


        ]);



        if($validator->fails()){

            return response()->json(['success' => false, 'message' => $validator->errors()]);
        }


       $input = json_decode($request->name,true) ;



        if( !empty($input)  && count($input) > 0){

                $user_id= $input['id'];
        }


        if (!empty($request->RF_Person_Code)){

            $input = User::where('RF_code','=',$request->RF_Person_Code)->first();
            $user_id = $input['id'];
        }




        if($user_id){



               $find = attendance::where('user_id','=',$user_id)->get();

            if(count($find) < 1){

                     $date = $request->date;
                    $time = Carbon::now('Africa/Cairo')->toTimeString();


                    $saveAttendance = attendance::create([
                        'user_id' =>  $user_id,
                        'come_time' => $time,
                        'date' => $date
                    ]);

                    return response()->json(['success' => true , 'attendance' => new attendanceResource($saveAttendance)],200);


            }

            if($find){

                $saveAttendance = '';



                foreach ($find as $k => $v){

                    if( $v['come_time'] != null && $v['leave_time'] != null ){



                        if($v['date'] != $request->date){

                            $date = $request->date;
                            $time = Carbon::now('Africa/Cairo')->toTimeString();


                            $saveAttendance = attendance::create([
                                'user_id' =>  $user_id,
                                'come_time' => $time,
                                'date' => $date
                            ]);


                        }else{

                            return response()->json([ 'status' => '400', 'message' => 'attendance already taken']);
                        }

                    }

                     if( $v['come_time'] != null && $v['leave_time'] == null && $v['date'] == $request['date'] ){

                        $date = $request->date;
                        $time = Carbon::now('Africa/Cairo')->toTimeString();


                        $saveAttendance = attendance::where('user_id','=',$v['user_id'])->where('id','=',$v['id'])->first();
                        $saveAttendance->update([

                            'leave_time' => $time,
                            'date' => $date
                        ]);

                    }
                }

                if($saveAttendance != ''){

                    return response()->json(['success' => true , 'attendance' => new attendanceResource($saveAttendance)],200);

                }


            }









        }



    }



    public function attendanceFilter(Request $request){



    }
}
