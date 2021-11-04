<?php

namespace App\Events;

use App\Models\staff;
use App\Models\teamChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $user;


    public function __construct( $user, $message )
    {
        $this->message = $message;
         $this->user = $user;

    }



    // public function __construct(  $message )
    // {
    //     $this->message = $message;


    // }

    // public function broadcastOn()
    // {
    //     return new Channel('chat');
    // }





    public function broadcastOn()
    {
        return new PrivateChannel('chat_message.'.$this->user->Personal_uuid); // recever uu id
    }

    public function broadcastWith(){

        return ['message' => $this->message];
    }
    // public function broadcastAs(){

    //     return 'chatting_team';
    // }




}
