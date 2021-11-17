<?php

namespace App\Http\Controllers\API\attendancce;

use Carbon\Carbon;
use App\Models\User;
use App\Models\attendance;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Exports\attendanceExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\attendanceResource;

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



             $find = attendance::where('user_id','=',$user_id)->where('date','=',$request->date)->first();

                // return $find->count() > 0 ? 'true' : 'false';

            if($find){

                if( $find['come_time'] != null && $find['leave_time'] == null && $find['date'] == $request['date'] ){

                    $date = $request->date;
                    $time = Carbon::now('Africa/Cairo')->toTimeString();


                    $saveAttendance = $find;
                    $saveAttendance->update([

                        'leave_time' => $time,
                        'date' => $date
                    ]);

                return response()->json(['success' => true , 'attendance' => new attendanceResource($saveAttendance)],200);

                }else{

                    return response()->json([ 'status' => '400', 'message' => 'attendance already taken']);

                }

            }else{

                    $date = $request->date;
                    $time = Carbon::now('Africa/Cairo')->toTimeString();


                    $saveAttendance = attendance::create([
                        'user_id' =>  $user_id,
                        'come_time' => $time,
                        'date' => $date
                    ]);

                    return response()->json(['success' => true , 'attendance' => new attendanceResource($saveAttendance)],200);

            }

        }
    }

    public function attendanceSelectedToDelete(Request $request){


        $uniqueId =  array_unique($request->all());

        $attendance = new attendance();
        $attendance->whereIn('id', $uniqueId)->delete();


        return response()->json(['success' => true], 200);

    }


    public function attendanceFilter(Request $request){


        if($request->from &&  !$request->to){

            $attendance = attendance::where('date','=',$request->from)->get();

        }

        if($request->to && !$request->from){

            $attendance = attendance::where('date','=',$request->to)->get();

        }


        if($request->from && $request->to){

            $attendance = attendance::whereBetween('date',[$request->from,$request->to])->get();

        }


        return response()->json(['success' => true, 'attendance' => attendanceResource::collection($attendance)],200);

    }
}
