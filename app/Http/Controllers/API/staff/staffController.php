<?php

namespace App\Http\Controllers\API\staff;

use App\Http\Controllers\Controller;
use App\Http\Resources\staffResource;
use App\Models\staff;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class staffController extends Controller
{
    public function index(){

        $staff = staff::all();

        return response()->json(['success'=>true,'staff'=> staffResource::collection($staff)],200);


    }


    public function store(Request $request){

        $validator = validator::make($request->all(),[

            'firstName'   => 'required',
            'middleName'   => 'required',
            'lastName'   => 'required',
            'phone'	   => 'required',
            'jop'   => 'required',

        ]);


        if($validator->fails()){

            return response()->json(['success'=>false,'message'=>$validator->errors()]);

        }




        try{

            DB::beginTransaction();
            if($request->file('avatar')){

                $file = $request->file('avatar');
                $extension = $file->extension();

                $fileName = md5(time().now().rand(1,10)).'.'.$extension;

                $file->move(public_path('staff_pictures'),$fileName);


            }
            DB::commit();

        }catch(\Exception $e){

            DB::rollBack();

        }


        $input = $request->all();
        $input['avatar'] = $input['avatar'] ? $fileName : null;

        $staff =  staff::create($input);

        return response()->json(['success'=>true,'staffNew'=>new staffResource($staff)],200);




    }

    public function update(Request $request , $id){

        $validator = validator::make($request->all(),[

            'firstName'   => 'required',
            'middleName'   => 'required',
            'lastName'   => 'required',
            'phone'	   => 'required',
            'jop'   => 'required',

        ]);


        if($validator->fails()){

            return response()->json(['success'=>false,'message'=>$validator->errors()]);

        }



        $input = $request->all();

        if($request->file('avatar')){

            $oldImg = staff::where('id','=',$id)->pluck('avatar');

            $path =  public_path('staff_pictures\\'.$oldImg[0]);
            if($oldImg[0]){
                if(file_exists($path)){

                    unlink($path);
                }
            }



            $file = $request->file('staff_picture');
            $extension = $file->extension();

            $fileName = md5(time().now().rand(1,10)).'.'.$extension;

            $file->move(public_path('staff_pictures'),$fileName);

            $input['avatar'] = $input['avatar'] ? $fileName : null;

        }else{
            $input =  Arr::except($input,array('avatar'));
        }



        $staff = staff::find($id);
        $staff->update($input);


        return response()->json(['success'=>true ,'message'=> 'updated successfully','staff'=>new staffResource($staff)] ,200);

    }


    public function getItemFromStaffById($id){


        $staff = staff::find($id);
        $staff = new staffResource($staff);

        $role= [];


        return response()->json(['success'=>true, 'staff'=>  $staff],200);







    }
}
