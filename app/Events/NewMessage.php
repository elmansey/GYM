<?php

namespace App\Events;

use App\Models\User;
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


    public function __construct(User $user, $message )
    {
        $this->message = $message;
         $this->user = $user;

    }


    public function broadcastOn()
    {
        return new PrivateChannel('team_chat.'.$this->user->id); // recever uu id
    }



    public function broadcastWith(){

        return ['message' => $this->message];
    }







}
