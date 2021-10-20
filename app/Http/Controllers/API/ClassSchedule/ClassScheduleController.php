<?php

namespace App\Http\Controllers\API\ClassSchedule;

use App\Models\staff;
use Illuminate\Http\Request;
use App\Models\ClassSchedule;
use App\Http\Controllers\Controller;
use App\Http\Resources\captainResource;
use App\Http\Resources\class_scheduleResource;
use Carbon\Carbon;
use Illuminate\support\facades\Validator;


class ClassScheduleController extends Controller
{






    public function index(){

        $classes = ClassSchedule::with('captain_relation')->get();
        return response()->json(['success' => true,'classes' => $classes]);




    }


    public function store(Request $request){

        $validator = validator::make($request->all(),[

            'className'   => 'required|unique:class_schedules',
            'captainName'   => 'required',
            'days'   => 'required',
            'startingTime'   => 'required|date_format:H:i',
            'endingTime'   => 'required|date_format:H:i|after:startingTime',
            'trainingLocation'   => 'required'

        ]);

        if($validator->fails()){

            return response()->json(['success'=> false,'message'=> $validator->errors()]);
        }


        $days = [];

        $day = json_decode($request->days,true);
        foreach($day as $k => $v){

                $days[] = $v;
        }

      $statTime =  date("g:i a", strtotime($request->startingTime));
      $endTime =  date("g:i a", strtotime($request->endingTime));



        $class = new ClassSchedule();
        $class->className = $request->className;
        $class->captainName = $request->captainName;
        $class->startingTime = $statTime;
        $class->endingTime = $endTime;
        $class->trainingLocation = $request->trainingLocation;
         $class->days = $days;
        $class->save();



       return response()->json(['success' => true , 'class' => $class]);


    }




    public function update(Request $request,$id){



        $validator = validator::make($request->all(),[

            'className'   => 'required|unique:class_schedules,'.$id,
            'captainName'   => 'required',
            'days'   => 'required',
            'startingTime'   => 'required|date_format:H:i',
            'endingTime'   => 'required|date_format:H:i|after:startingTime',
            'trainingLocation'   => 'required'

        ]);



        if($validator->fails()){

            return response()->json(['success'=> false,'message'=> $validator->errors()]);
        }





    }



    public function getClassById($id){


        $class = ClassSchedule::find($id);

        return response()->json(['success'=>true,'class'=>new class_scheduleResource($class)]);




    }


    public function getAllCaptainToCreateClass(){


        $captain = staff::where('jop','=','Captain')->get();

        return  response()->json(['success'=>true,'captain'=>captainResource::collection($captain)]);


    }


}
