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

        $this->middleware(['auth:api']);
    }


    public function getOldMessageInChat(Request $request){

        $messages = teamChatMessage::where('to','=',$request->to)
        ->Where('from' ,'=' , $request->from)
        ->orWhere('to' ,'=' , $request->from)
        ->Where('from' ,'=', $request->to)
        ->get();

            // return $messages;

        $to = User::where('id','=',$request->to)->first() ;

        $from = User::where('id','=',$request->from)->first();





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


        $input['send_at'] = Carbon::now()->toDateTimeString();
        $message = teamChatMessage::create($input);

        $to = User::where('id','=',$message->to)->first() ;




        // return $to fire event;
        broadcast(new NewMessage($to,$message))->toOthers();
        // event(new NewMessage($to,$message));

       return response()->json(['success' => true , 'message' =>new message($message),'to' => $to],200);




    }


    public function setReadingMessage (Request $request){

        $validator = validator::make($request->all(), [
            'resever' => 'required',
        ]);


        if($validator->fails()){

            return response()->json(['success' => false, 'message' => $validator->errors()]);
        }

        $input = $request->all();


        //هات الرسايل المسجل دخول يكون قيها المستقبل
        $unReadMessage = teamChatMessage::where('to' ,'=',auth()->user()->id )
        ->where('from','=',$input['resever'])
        ->Where('read','=',false)->get();
            $makeMessageRead = '';
            foreach($unReadMessage as $k => $v){


                if($v['to'] == auth()->user()->id){

                    $makeMessageRead = teamChatMessage::find($v['id']);
                    $makeMessageRead->update([
                        'read' => true,
                        'reading_at' => Carbon::now()->toDateTimeString(),

                    ]);

                }

             }

             if($makeMessageRead){

                return response()->json(['success' => true , 'messages' =>'readed']);

             }





    }


}
