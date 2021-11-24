<?php

namespace App\Http\Controllers\API\attendancce;

use Carbon\Carbon;
use App\Models\User;
use App\Models\attendance;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Exports\attendanceExport;
use App\Http\Controllers\Controller;
use App\Models\members_extra_information;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\attendanceResource;

class attendanceController extends Controller
{


    public function index(){

        $attendance = attendance::all();

        return response()->json(['success' => true , 'attendance' => attendanceResource::collection($attendance)]);
    }


    public function store (Request $request){

        if($request->type == 'select'){
            if ($request->name && $request->time && $request->date) {
                $RF_code =  json_decode($request->name, true)['RF_code'];

                if (!empty($RF_code)) {
                    $input = User::where('RF_code', '=', $RF_code)->first() ?
                        User::where('RF_code', '=', $RF_code)->first() :
                        members_extra_information::where('RF_code', '=', $RF_code)->first();


                    $find = attendance::where('RF_code', '=', $input['RF_code'])
                        ->where('date', '=', $request->date)->first();


                    if ($find) {
                        if ($find['come_time'] != null && $find['leave_time'] == null && $find['date'] == $request['date']) {
                            $saveAttendance = $find;
                            $saveAttendance->update([

                                    'leave_time' =>  date("h:i:s A", strtotime($request->time)),
                                    'date' => $request->date

                                ]);

                            return response()->json(['success' => true , 'attendance' => new attendanceResource($saveAttendance),'status' => 'leave','how'=> $input], 200);
                        } else {
                            return response()->json([ 'status' => '400', 'message' => 'attendance already taken']);
                        }
                    } else {
                        $date = $request->date;
                        $time = date("h:i:s A", strtotime($request->time));


                        $saveAttendance = attendance::create([
                                'RF_code' => $RF_code,
                                'come_time' => $time,
                                'date' => $date
                            ]);

                        return response()->json(['success' => true , 'attendance' => new attendanceResource($saveAttendance),'status' => 'come','how'=> $input], 200);
                    }
                }
            }
        }else if($request->type == 'scan'){

            if($request->RF_code){
                $RF_code = $request->RF_code;

                $input = User::where('RF_code', '=', $RF_code)->first() ?
                    User::where('RF_code', '=', $RF_code)->first() :
                    members_extra_information::where('RF_code', '=', $RF_code)->first();

                    $date = Carbon::now('Africa/Cairo')->toDateString();
                    $time = date("h:i:s A", strtotime(Carbon::now('Africa/Cairo')->toTimeString())) ;

                     $find = attendance::where('RF_code','=', $input['RF_code'])
                    ->where('date','=',$date)->get();



                    if (count($find) > 0)  {


                        foreach ($find as $k => $v){

                            $date = Carbon::now('Africa/Cairo')->toDateString();
                            $time = date("h:i:s A", strtotime(Carbon::now('Africa/Cairo')->toTimeString())) ;

                            $comeTimePlusSixHour = date("h:i:s A", strtotime(Carbon::parse($v['come_time'])->addHours(6)));


                            if ($v['come_time'] != null && $v['leave_time'] == null && $v['date'] == $date &&   $time < $comeTimePlusSixHour  ) {

                                $saveAttendance = $v;
                                $saveAttendance->update([

                                        'leave_time' =>  $time,
                                        'date' => $date

                                    ]);

                                return response()->json(['success' => true , 'attendance' => new attendanceResource($saveAttendance),'status' => 'leave','how'=> $input], 200);

                            }else if($v['come_time'] != null && $v['leave_time'] != null && $v['date'] == $date &&  $time > $comeTimePlusSixHour ){
                                    return $time .' ' . $comeTimePlusSixHour;
                                $RF_code = $request->RF_code;

                                $date = Carbon::now('Africa/Cairo')->toDateString();
                                $time = date("h:i:s A", strtotime(Carbon::now('Africa/Cairo')->toTimeString())) ;

                                $saveAttendance = attendance::create([
                                        'RF_code' => $RF_code,
                                        'come_time' => $time,
                                        'date' => $date
                                    ]);

                                return response()->json(['success' => true , 'attendance' => new attendanceResource($saveAttendance),'status' => 'come','how' => $input], 200);

                            }else{

                                return response()->json([ 'status' => '400', 'message' => 'attendance already taken']);

                            }




                        }














                        // else if($find['come_time'] != null && $find['leave_time'] == null && $find['date'] == $date && $time >= $timeAfterSixHour ){

                        //     $RF_code = $request->RF_code;

                        //     $date = Carbon::now('Africa/Cairo')->toDateString();
                        //     $time = date("h:i:s A", strtotime(Carbon::now('Africa/Cairo')->toTimeString())) ;

                        //     $saveAttendance = attendance::create([
                        //             'RF_code' => $RF_code,
                        //             'come_time' => $time,
                        //             'date' => $date
                        //         ]);

                        //     return response()->json(['success' => true , 'attendance' => new attendanceResource($saveAttendance),'status' => 'come','how' => $input], 200);

                        // }else if($find['come_time'] != null && $find['leave_time'] != null && $find['date'] == $date && $time >= $timeAfterSixHour ){

                        //     $RF_code = $request->RF_code;

                        //     $date = Carbon::now('Africa/Cairo')->toDateString();
                        //     $time = date("h:i:s A", strtotime(Carbon::now('Africa/Cairo')->toTimeString())) ;

                        //     $saveAttendance = attendance::create([
                        //             'RF_code' => $RF_code,
                        //             'come_time' => $time,
                        //             'date' => $date
                        //         ]);

                        //     return response()->json(['success' => true , 'attendance' => new attendanceResource($saveAttendance),'status' => 'come','how' => $input], 200);

                        // }else{

                        //     return response()->json([ 'status' => '400', 'message' => 'attendance already taken']);

                        // }







                    } else {

                        $RF_code = $request->RF_code;

                        $date = Carbon::now('Africa/Cairo')->toDateString();
                        $time = date("h:i:s A", strtotime(Carbon::now('Africa/Cairo')->toTimeString())) ;

                        $saveAttendance = attendance::create([
                                'RF_code' => $RF_code,
                                'come_time' => $time,
                                'date' => $date
                            ]);

                        return response()->json(['success' => true , 'attendance' => new attendanceResource($saveAttendance),'status' => 'come','how' => $input], 200);
                    }

            }
        }












        // if($user_id){



        //      $find = attendance::where('user_id','=',$user_id)->where('date','=',$request->date)->first();

        //         // return $find->count() > 0 ? 'true' : 'false';

        //     if($find){

        //         if( $find['come_time'] != null && $find['leave_time'] == null && $find['date'] == $request['date'] ){

        //             $date = $request->date;
        //             $time = Carbon::now('Africa/Cairo')->toTimeString();


        //             $saveAttendance = $find;
        //             $saveAttendance->update([

        //                 'leave_time' => $time,
        //                 'date' => $date
        //             ]);

        //         return response()->json(['success' => true , 'attendance' => new attendanceResource($saveAttendance)],200);

        //         }else{

        //             return response()->json([ 'status' => '400', 'message' => 'attendance already taken']);

        //         }

        //     }else{

        //             $date = $request->date;
        //             $time = Carbon::now('Africa/Cairo')->toTimeString();


        //             $saveAttendance = attendance::create([
        //                 'user_id' =>  $user_id,
        //                 'come_time' => $time,
        //                 'date' => $date
        //             ]);

        //             return response()->json(['success' => true , 'attendance' => new attendanceResource($saveAttendance)],200);

        //     }

        // }
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
