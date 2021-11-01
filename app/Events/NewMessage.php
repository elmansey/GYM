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
    public $uuid;


    public function __construct(staff $uuid,$message)
    {
        $this->$message = $message;
        $this->$uuid = $uuid;
    }


    public function broadcastOn()
    {
        return new PrivateChannel('chat_message.'.$this->uuid);
    }




}
