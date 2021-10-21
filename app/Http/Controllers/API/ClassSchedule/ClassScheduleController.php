<?php

namespace App\Http\Controllers\API\ClassSchedule;

use Carbon\Carbon;
use App\Models\staff;
use Illuminate\Http\Request;
use App\Models\ClassSchedule;
use App\Http\Controllers\Controller;
use App\Http\Resources\captainResource;
use Illuminate\support\facades\Validator;
use App\Http\Resources\class_scheduleResource;
use Illuminate\Validation\Rule;

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
            'startingTime'   => 'required',
            'endingTime'   => 'required|after:startingTime',
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




        $class = new ClassSchedule();
        $class->className = $request->className;
        $class->captainName = $request->captainName;
        $class->startingTime = $request->startingTime;
        $class->endingTime = $request->endingTime;
        $class->trainingLocation = $request->trainingLocation;
         $class->days = $days;
        $class->save();



       return response()->json(['success' => true , 'class' => $class]);


    }




    public function update(Request $request,$id){



        $validator = validator::make($request->all(),[

            'className'   => ['required',Rule::unique('class_schedules')->ignore($id)],
            'captainName'   => 'required',
            'days'   => 'required',
            'startingTime'   => 'required',
            'endingTime'   => 'required|after:startingTime',
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



        $class =  ClassSchedule::find($id);
        $class->className = $request->className;
        $class->captainName = $request->captainName;
        $class->startingTime = $request->startingTime;
        $class->endingTime = $request->endingTime;
        $class->trainingLocation = $request->trainingLocation;
         $class->days = $days;
        $class->save();



       return response()->json(['success' => true , 'class' => $class]);





    }



    public function getClassById($id){


        $class = ClassSchedule::find($id);

        return response()->json(['success'=>true,'class'=>new class_scheduleResource($class)]);




    }


    public function getAllCaptainToCreateClass(){


        $captain = staff::where('jop','=','Captain')->get();

        return  response()->json(['success'=>true,'captain'=>captainResource::collection($captain)]);


    }



    public function destroy($id){


        $class =  ClassSchedule::find($id);

        $class->delete();

        return response()->json(['success'=>true],200);

    }

}
