<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teamChatMessage extends Model
{
    use HasFactory;
    public $table = 'team_chat_message';
    protected $fillable = ['from','to','message'];
}
