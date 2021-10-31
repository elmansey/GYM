<?php

namespace App\Http\Controllers\API\chat;

use App\Models\User;
use App\Models\staff;
use Illuminate\Http\Request;
use App\Models\teamChatMessage;
use App\Http\Controllers\Controller;
use Illuminate\support\facades\Validator;
use App\Http\Resources\staffResource;
use App\Http\Resources\UsersResource;

class teamChatController extends Controller
{

    public function getOldMessageInChat(Request $request){

        $messages = teamChatMessage::where('from','=',$request->from)
        ->where('to' ,'=' , $request->to)
        ->orWhere('to' ,'=' , $request->from)
        ->Where('from' ,'=', $request->to)
        ->get();



        $to = staff::where('Personal_uuid','=',$request->to)->first() ?
        staff::where('Personal_uuid','=',$request->to)->first() :
        $to = User::where('Personal_uuid','=',$request->to)->first();


        $from = User::where('Personal_uuid','=',$request->from)->first() ?
        User::where('Personal_uuid','=',$request->from)->first() :
        $from = staff::where('Personal_uuid','=',$request->from)->first();




        return response()->json(['success' => true , 'messages' =>$messages , 'to' => $to , 'from' => $from]);




    }
    public function store(Request $request){

        $validator = validator::make($request->all(), [
            'from' => 'required',
            'to' => 'required',
            'message'  => 'required'
        ]);


        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()]);
        }


        $input  = $request->all();
        $message = teamChatMessage::create($input);






    }
}
