<?php

namespace App\Http\Controllers\API\Memberships;

use App\Http\Controllers\Controller;
use App\Models\Memberships;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\MembershipsRersource;
use Illuminate\Validation\Rule;

class MembershipsController extends Controller
{

    public function index(){

        $memberShips = Memberships::all();
            return response()->json(['success'=>true,'memberships'=>$memberShips],200);

    }

    public function store(Request $request){


        $validator = validator::make($request->all(),[
            'name' => 'required|max:25|unique:memberships,name'
        ]);

        if($validator->fails()){
            return response()->json(['success'=>false,'message'=>$validator->errors(),'status'=>'400'],200);
        }

        $membership = $request->all();
        $membership = Memberships::create($membership);


        return  response()->json(['success'=> true,'membership'=>$membership],200);


    }

       public function getMembershipsById($id){

                $membership = Memberships::find($id);

                return response()->json(['success'=>true,'membership'=> new  MembershipsRersource($membership)]);


        }

        public function update(Request $request,$id){

            $validator = validator::make($request->all(),[
                'name' => ['required','max:25',Rule::unique('memberships')->ignore($id)]
            ]);

            if($validator->fails()){
                return response()->json(['success'=>false,'message'=>$validator->errors(),'status'=>'400'],200);
            }


            $membership = Memberships::find($id);
            $membership->update($request->all());


            return  response()->json(['success'=> true,'membership'=>$membership],200);



        }

        public function destroy($id){

        $membership = Memberships::find($id);
            $membership->delete();
            return response()->json(['success'=>true],200);
        }

}