<?php

namespace App\Http\Controllers\API\staff;

use App\Models\staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\RolesResource;
use App\Http\Resources\staffResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\VarDumper\VarDumper;

class staffController extends Controller
{
    public function index(){

        $staff = staff::all();

        return response()->json(['success' => true, 'staff' => staffResource::collection($staff)],200);
    }

    public function store(Request $request){


        $validator = validator::make($request->all(), [

            'firstName'        => 'required',
            'middleName'        => 'required',
            'lastName'        => 'required',
            'phone'        => 'required',
            'role'        => 'required',


        ]);



        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()]);
        }

        if(isset($request->password) && isset($request->confirm_Password)){

                if($request->password != $request->confirm_Password){

                    return response()->json(['success' => false, 'message' => ['confirm_Password' => 'the confirm password failde must same password failde']]);
                }
        }

        $input  = $request->all();

        if($input['password']){

            $input['password'] = bcrypt($input['password']);

        }


            if($request->file('profile_picture')){

                $file = $request->file('profile_picture');
                $extension = $file->extension();

                $fileName = md5(time().now().rand(1,10)).'.'.$extension;

                $file->move(public_path('profile_pictures'),$fileName);

            }


        $input['profile_picture'] = $fileName;

        $staff = staff::create($input);

       $input['role'] = json_decode($input['role'],true);
        $staff->assignRole($input['role']['name']);


        return  response()->json(['success' => true,'message' => 'staff add successfully']);

    }


    public function getItemFromStaffById($id){

        $staffPerson = staff::find($id);



        if($staffPerson){

            return response()->json(['success' => true, 'staff' => new staffResource($staffPerson)]);

        }else{
            return response()->json(['success' => false, 'status' => 404]);

        }


    }

    public function getStaffRole(){

        $role = Role::where('guard_name','=','staff')->get();
        return response()->json(['success'=>true ,'staffRole'=>  RolesResource::collection($role)] ,200);

    }



    public function update(Request $request, $id)
    {

        // return $request;
        $validator = validator::make($request->all(), [

            'firstName'        => 'required',
            'middleName'        => 'required',
            'lastName'        => 'required',
            'phone'        => 'required',
            'role'        => 'required',


        ]);



        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()]);
        }


        if(isset($request->password) && isset($request->confirm_Password)){

            if($request->password != $request->confirm_Password){

                return response()->json(['success' => false, 'message' => ['confirm_Password' => 'the confirm password failde must same password failde']]);
            }
        }


        $input  = $request->all();

        if(!empty($input['password'])){

            $input['password'] = bcrypt($input['password']);

        }else{

        $input =  Arr::except($input,array('password'));
        }



        $fileName = '';



            if($request->file('profile_picture')){

                $file = $request->file('profile_picture');
                $extension = $file->extension();

                $fileName = md5(time().now().rand(1,10)).'.'.$extension;

                $file->move(public_path('profile_pictures'),$fileName);
                $input['profile_picture'] = $fileName;

            }else{

                $input = Arr::except($input,array('profile_picture'));
            }



       $staff = staff::find($id);
        $staff->update($input);

        DB::table('model_has_roles')->where([['model_id','=',$id],['model_type','=','APP\Models\staff']])->delete();

        $roleDetails = json_decode($request->role,true) ;
        $role = [];

        foreach ($roleDetails  as $k => $v){

            $role[] = $v['name'];

        }
        $staff->assignRole($role);


        return  response()->json(['success' => true,'message' => 'staff person updated successfully']);





    }


    public function destroy($id)
    {

        $oldImg = staff::where('id','=',$id)->pluck('profile_picture');

        $path =  public_path('profile_pictures\\'.$oldImg[0]);

        if($oldImg[0]){
            if(file_exists($path)){

                unlink($path);
            }
        }


        $staff = staff::find($id);
        $staff->delete();
        return response()->json(['success' => true, 'message' => 'deleted successfully']);
    }

}
