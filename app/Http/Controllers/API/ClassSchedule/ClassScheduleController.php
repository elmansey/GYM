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
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\classSceduleResource;
use App\Http\helperMe\addActivetyLogInHistory;
use App\Http\Resources\class_scheduleResource;
use App\Http\Resources\class_scheduleResourceToGetCountMember;

class ClassScheduleController extends Controller
{

    use addActivetyLogInHistory;

    public function index()
    {

        $classes = ClassSchedule::with('staff_relation')->get();
        return response()->json(['success' => true, 'classes' => class_scheduleResource::collection($classes)]);
    }


    public function store(Request $request)
    {


        
        $request['days'] = json_decode($request->days, true);

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

       
        foreach ($request->days as $k => $v) {

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


        //save logs
        $userId = auth()->user()->id;
        $title  = 'has added a new class ';
        $date = Carbon::now('Africa/Cairo')->format('D, M, d Y H:i:s A');
        $this->saveLogs($userId,$title,$date);


        return response()->json(['success' => true, 'class' => new class_scheduleResource($class)]);
    }


    public function update(Request $request, $id)
    {
        $request['days'] = json_decode($request->days, true);
        $validator = validator::make($request->all(), [

            'staffName'   => 'required',
            'days'         => 'required',
            'startingTime'   => 'required',
            'endingTime'   => 'required|after:startingTime',
            'trainingLocation'   => 'required',
            'group_id'   => 'required',


        ]);


        $days = [];

        foreach ($request->days as $k => $v) {

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



    public function getAllClasseRelatedToThisGroup(Request $request){


        $GroupIdes = [];

        foreach ($request->all() as $k => $v){

            $GroupIdes[] = $v['id'];
        }



        $classes = ClassSchedule::whereIn('group_id',$GroupIdes)->get();
        $members = members_extra_information::all();

        foreach ($classes as $k => $v){
            $v['countMember'] = 0;

            foreach ($members as $key => $value){
                $c = is_array($value['class_id']) ? count($value['class_id']) : 0;

                for ($i=0; $i < $c ; $i++) {
                   if($value['class_id'][$i] == $v['id']){
                    $v['countMember'] += 1;
                   }
                }

            }
        }


        return  response()->json(['success'=>true,'classes'=> class_scheduleResourceToGetCountMember::collection($classes)]);

    }


}
