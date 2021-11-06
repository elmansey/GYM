<?php

namespace App\Models;

use App\Events\NewMessage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teamChatMessage extends Model
{
    use HasFactory;
    public $table = 'team_chat_message';
    protected $fillable = ['from','to','message','time'];

    // protected $dispatchesEvents = [

    //     'NewMessage' => NewMessage::class,

    // ];
}
