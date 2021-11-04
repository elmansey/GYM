<?php

namespace App\Http\Controllers\API\chat;

use Carbon\Carbon;
use App\Models\User;
use App\Models\staff;
use App\Events\NewMessage;
use Illuminate\Http\Request;
use Faker\Provider\UserAgent;
use App\Http\Resources\message;
use App\Models\teamChatMessage;
use App\Http\Controllers\Controller;
use App\Http\Resources\staffResource;
use App\Http\Resources\UsersResource;
use Illuminate\support\facades\Validator;

class teamChatController extends Controller
{


    public function __construct(){

        $this->middleware(['auth:admin,staff']);
    }


    public function getOldMessageInChat(Request $request){

        $messages = teamChatMessage::where('to','=',$request->to)
        ->Where('from' ,'=' , $request->from)
        ->orWhere('to' ,'=' , $request->from)
        ->Where('from' ,'=', $request->to)
        ->get();

            // return $messages;

        $to = staff::where('Personal_uuid','=',$request->to)->first() ?
        staff::where('Personal_uuid','=',$request->to)->first() :
        $to = User::where('Personal_uuid','=',$request->to)->first();


        $from = User::where('Personal_uuid','=',$request->from)->first() ?
        User::where('Personal_uuid','=',$request->from)->first() :
        $from = staff::where('Personal_uuid','=',$request->from)->first();




        return response()->json(['success' => true , 'messages' => message::collection($messages ), 'to' => $to , 'from' => $from]);




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

        $input['time'] = Carbon::now()->toDateTimeString();
        $message = teamChatMessage::create($input);

        $to = staff::where('Personal_uuid','=',$message->to)->first() ?
        staff::where('Personal_uuid','=',$message->to)->first():
         User::where('Personal_uuid','=',$message->to)->first();

    

        // return $to fire event;
        broadcast(new NewMessage($to,$message))->toOthers();
        // event(new NewMessage($to,$message));
        // event(new NewMessage($message));

       return response()->json(['success' => true , 'message' =>new message($message),'to' => $to],200);




    }
}
