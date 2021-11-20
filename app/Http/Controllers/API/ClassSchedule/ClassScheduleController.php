<?php

namespace App\Http\Controllers\API\ClassSchedule;

use Carbon\Carbon;
use App\Models\User;
use App\Models\staff;
use Illuminate\Http\Request;
use App\Models\ClassSchedule;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\captainResource;
use App\Models\members_extra_information;
use Illuminate\support\facades\Validator;
use App\Http\Resources\classSceduleResource;
use App\Http\Resources\class_scheduleResource;
use App\Http\Resources\class_scheduleResourceToGetCountMember;

class ClassScheduleController extends Controller
{


    public function index()
    {

        $classes = ClassSchedule::with('captain_relation')->get();
        return response()->json(['success' => true, 'classes' => class_scheduleResource::collection($classes)]);
    }


    public function store(Request $request)
    {




        $validator = validator::make($request->all(), [

            'staffName'   => 'required',
            'days'   => 'required',
            'startingTime'   => 'required',
            'endingTime'   => 'required|after:startingTime',
            'trainingLocation'   => 'required',
            'group_id'   => 'required',

        ]);



        if ($validator->fails()) {

            return response()->json(['success' => false, 'message' => $validator->errors()]);
        }


        $days = [];

        $day = json_decode($request->days, true);
        foreach ($day as $k => $v) {

            $days[] = $v;
        }


        $class = new ClassSchedule();
        $class->staffName = $request->staffName;
        $class->startingTime =  date("h:i:s", strtotime($request->startingTime));
        $class->endingTime = date("h:i:s", strtotime($request->endingTime));
        $class->trainingLocation = $request->trainingLocation;
        $class->group_id = $request->group_id;
        $class->days = $days;
        $class->save();



        return response()->json(['success' => true, 'class' => new class_scheduleResource($class)]);
    }


    public function update(Request $request, $id)
    {

        $validator = validator::make($request->all(), [

            'staffName'   => 'required',
            'days'         => 'required',
            'startingTime'   => 'required',
            'endingTime'   => 'required|after:startingTime',
            'trainingLocation'   => 'required',
            'group_id'   => 'required',


        ]);


        $days = [];

        $day = json_decode($request->days, true);
        foreach ($day as $k => $v) {

            $days[] = $v;
        }


        if ($validator->fails()) {

            return response()->json(['success' => false, 'message' => $validator->errors()]);
        }







        $class =  ClassSchedule::find($id);
        $class->staffName = $request->staffName;
        $class->startingTime = date("h:i:s", strtotime($request->startingTime));
        $class->endingTime = date("h:i:s", strtotime($request->endingTime));
        $class->trainingLocation = $request->trainingLocation;
        $class->group_id = $request->group_id;
        $class->days = $days;
        $class->save();



        return response()->json(['success' => true, 'class' => new class_scheduleResource($class) ]);
    }


    public function getClassById($id)
    {


        $class = ClassSchedule::find($id);

        return response()->json(['success' => true, 'class' => new class_scheduleResource($class)]);
    }


    public function getAllPersonInStaffToCreateClass()
    {

        $staff = User::role('staff')->get();


        return  response()->json(['success' => true, 'staff' =>  captainResource::collection($staff)]);
    }


    public function destroy($id)
    {

        $class =  ClassSchedule::find($id);

        $class->delete();

        return response()->json(['success' => true], 200);
    }



    public function deleteSelectedItem(Request $request)
    {

        $uniqueId =  array_unique($request->all());

        $classes = new ClassSchedule();
        $classes->whereIn('id', $uniqueId)->delete();


        return response()->json(['success' => true], 200);
    }


    public function getClassInDays(){

        $classes = ClassSchedule::all();

        $Saturday=[];
        $Sunday=[];
        $Monday=[];
        $Tuesday=[];
        $Wednesday=[];
        $Thursday=[];
        $Friday=[];

        $cl = [];
        $daysName = [];
        foreach($classes as $k => $va){

            foreach($va['days'] as $kay => $value){


                if($value['name'] == 'Saturday'){

                    $Saturday[] = new classSceduleResource($va);

                }
                 else if($value['name'] == 'Sunday'){

                  $Sunday[]  = new classSceduleResource($va);
                 }
                else if($value['name'] == 'Monday'){
                    $Monday[]  = new classSceduleResource($va);

                }
               else if($value['name'] == 'Tuesday'){
                    $Tuesday[]  = new classSceduleResource($va);

                }
               else if($value['name'] == 'Wednesday'){
                    $Wednesday[]  = new classSceduleResource($va);

                }
               else if($value['name'] == 'Thursday'){
                    $Thursday[]  = new classSceduleResource($va);

                }
               else if($value['name'] == 'Friday'){
                    $Friday[]  = new classSceduleResource($va);

                }

            }



        }




        return response()->json([
            'success'=>true,
            'classes'=>
            ['saturdayClasses' => $Saturday,
            'sundayClasses' => $Sunday,
            'mondayClasses' => $Monday,
            'tuesdayClasses' => $Tuesday,
            'wednesdayClasses' => $Wednesday,
            'thursdayClasses' => $Thursday,
            'fridayClasses' => $Friday,]


        ],200);


    }

    public function getClassToSelect(){

        $classes = ClassSchedule::all();


        foreach($classes as $k => $v){

            $v['countMember'] = count( members_extra_information::where('class_id','=',$v['id'])->get());
        }




        return  response()->json(['success'=>true,'classes'=> class_scheduleResourceToGetCountMember::collection($classes)]);
    }





}
