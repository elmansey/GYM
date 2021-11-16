<?php

namespace App\Http\Controllers\API\attendancce;

use Carbon\Carbon;
use App\Models\User;
use App\Models\attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\attendanceResource;

class attendanceController extends Controller
{


    public function index(){

        $attendance = attendance::all();

        return response()->json(['success' => true , 'attendance' => attendanceResource::collection($attendance)]);
    }


    public function store (Request $request){

        $input = json_decode($request->name,true);

        if(!empty($input)){

                $user_id= $input['id'];
        }

        if (!empty($request->RF_Person_Code)){

            $input = User::where('RF_code','=',$request->RF_Person_Code)->first();
            $user_id = $input['id'];
        }

        if(!empty($user_id)){


            $date = $request->date;
            $time = Carbon::now()->toTimeString();


            $saveAttendance = attendance::create([
                'user_id' =>  $user_id,
                'time' => $time,
                'date' => $date
            ]);


            return response()->json(['success' => true , 'attendance' => new attendanceResource($saveAttendance)],200);

        }



    }
}
