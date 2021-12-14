<?php

namespace App\Http\Controllers\API\attendancce;

use DateTime;
use DateInterval;
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
    public function index()
    {
        $attendance = attendance::all();

        return response()->json(['success' => true , 'attendance' => attendanceResource::collection($attendance)]);
    }


    public function store(Request $request)
    {
        if ($request->type == 'select') {


            if ($request->name && $request->time && $request->date) {

                $RF_code =  json_decode($request->name, true)['RF_code'];

                if (!empty($RF_code)) {

                    $input = User::where('RF_code', '=', $RF_code)->first() ?
                        User::where('RF_code', '=', $RF_code)->first() :
                        members_extra_information::where('RF_code', '=', $RF_code)->first();

                        if($input['period_Expiry'] && $input['subscription_status'] ){
                            $today = Carbon::now('Africa/Cairo')->toDateString();
                            if($input['period_Expiry'] <= $today && $input['subscription_status'] == 'expired'){
    
                                return response()->json(['success' => true , 'status' => 'expire' ]);
                            }
                        }
                        
                        
                    $find = attendance::where('RF_code', '=', $input['RF_code'])->latest()->get()->first();


                    if ($find) {

                        $dateTime = $request->date .' '. $request->time;
                        $diffInHours =  Carbon::parse($find['come_dateTime'])->diffInHours(Carbon::parse($dateTime));


                        if ($find['come_dateTime'] != null && $find['leave_dateTime'] == null && $diffInHours <= 6) {
                            $saveAttendance = $find;
                            $saveAttendance->update([

                                    'leave_dateTime' =>  $dateTime

                                ]);

                            return response()->json(['success' => true , 'attendance' => new attendanceResource($saveAttendance),'status' => 'leave','how'=> $input], 200);

                        } else if ($find['come_dateTime'] != null && $find['leave_dateTime'] != null  && $diffInHours > 6) {
                            $dateTime = $request->date .' '. $request->time;

                            $saveAttendance = attendance::create([
                                    'RF_code' => $RF_code,
                                    'come_dateTime' => $dateTime,

                                ]);

                            return response()->json(['success' => true , 'attendance' => new attendanceResource($saveAttendance),'status' => 'come','how'=> $input], 200);

                        }else if ($find['come_dateTime'] != null && $find['leave_dateTime'] == null  && $diffInHours > 6) {
                            $dateTime = $request->date .' '. $request->time;

                            $saveAttendance = attendance::create([
                                    'RF_code' => $RF_code,
                                    'come_dateTime' => $dateTime,

                                ]);

                            return response()->json(['success' => true , 'attendance' => new attendanceResource($saveAttendance),'status' => 'come','how'=> $input], 200);

                        } else {
                            return response()->json([ 'status' => '400', 'message' => 'attendance already taken']);
                        }
                    } else {

                        $dateTime = $request->date .' '. $request->time;

                        $saveAttendance = attendance::create([
                                'RF_code' => $RF_code,
                                'come_dateTime' => $dateTime
                            ]);

                        return response()->json(['success' => true , 'attendance' => new attendanceResource($saveAttendance),'status' => 'come','how'=> $input], 200);

                    }

                }
            }

        } elseif ($request->type == 'scan') {

            if ($request->RF_code) {

                $RF_code = $request->RF_code;

                $input = User::where('RF_code', '=', $RF_code)->first() ?
                    User::where('RF_code', '=', $RF_code)->first() :
                    members_extra_information::where('RF_code', '=', $RF_code)->first();



                    if($input['period_Expiry'] && $input['subscription_status'] ){
                        $today = Carbon::now('Africa/Cairo')->toDateString();
                        if($input['period_Expiry'] <= $today && $input['subscription_status'] == 'expired'){

                            return response()->json(['success' => true , 'status' => 'expire' ]);
                        }
                    }


                $date = Carbon::now('Africa/Cairo')->toDateString();
                $time = date("H:i:s", strtotime(Carbon::now('Africa/Cairo')->toTimeString())) ;


                $find = attendance::where('RF_code', '=', $input['RF_code'])->latest()->get()->first();


                if ($find) {

                            $date = Carbon::now('Africa/Cairo')->toDateString();
                            $time = date("H:i:s", strtotime(Carbon::now('Africa/Cairo')->toTimeString())) ;

                            $dateTime = $date .' '. $time;


                            $diffInHours =  Carbon::parse($find['come_dateTime'])->diffInHours(Carbon::parse($dateTime));


                            if ($find['come_dateTime'] != null && $find['leave_dateTime'] == null   && $diffInHours <= 6) {
                                $saveAttendance = $find;
                                $saveAttendance->update([

                                            'leave_dateTime' =>  $dateTime

                                            ]);

                                return response()->json(['success' => true , 'attendance' => new attendanceResource($saveAttendance),'status' => 'leave','how'=> $input], 200);

                            } else if ($find['come_dateTime'] != null && $find['leave_dateTime'] != null   && $diffInHours > 6) {
                                $RF_code = $request->RF_code;

                                $date = Carbon::now('Africa/Cairo')->toDateString();
                                $time = date("H:i:s", strtotime(Carbon::now('Africa/Cairo')->toTimeString())) ;

                                $dateTime = $date .' '. $time;



                                $saveAttendance = attendance::create([
                                                'RF_code' => $RF_code,
                                                'come_dateTime' => $dateTime
                                            ]);

                                return response()->json(['success' => true , 'attendance' => new attendanceResource($saveAttendance),'status' => 'come','how'=> $input], 200);

                            }else if ($find['come_dateTime'] != null && $find['leave_dateTime'] != null  && $diffInHours > 6) {
                                    $dateTime = $date .' '. $time;

                                    $saveAttendance = attendance::create([
                                            'RF_code' => $RF_code,
                                            'come_dateTime' => $dateTime,

                                        ]);

                                    return response()->json(['success' => true , 'attendance' => new attendanceResource($saveAttendance),'status' => 'come','how'=> $input], 200);

                            }else if ($find['come_dateTime'] != null && $find['leave_dateTime'] == null  && $diffInHours > 6) {
                                     $dateTime = $date .' '. $time;
                                    $saveAttendance = attendance::create([
                                            'RF_code' => $RF_code,
                                            'come_dateTime' => $dateTime,

                                        ]);

                                    return response()->json(['success' => true , 'attendance' => new attendanceResource($saveAttendance),'status' => 'come','how'=> $input], 200);

                            } else {

                                    return response()->json([ 'status' => '400', 'message' => 'attendance already taken']);

                            }

                } else {

                    $RF_code = $request->RF_code;

                    $date = Carbon::now('Africa/Cairo')->toDateString();
                    $time = date("H:i:s", strtotime(Carbon::now('Africa/Cairo')->toTimeString())) ;

                    $dateTime = $date .' '. $time;



                    $saveAttendance = attendance::create([
                                'RF_code' => $RF_code,
                                'come_dateTime' => $dateTime
                            ]);

                    return response()->json(['success' => true , 'attendance' => new attendanceResource($saveAttendance),'status' => 'come','how'=> $input], 200);

                }
            }
        }

    }

    public function attendanceSelectedToDelete(Request $request)
    {
        $uniqueId =  array_unique($request->all());

        $attendance = new attendance();
        $attendance->whereIn('id', $uniqueId)->delete();


        return response()->json(['success' => true], 200);
    }



}
