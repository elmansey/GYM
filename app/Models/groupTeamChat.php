<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class groupTeamChat extends Model
{
    use HasFactory;
    protected $table = 'group_team_chat';
    public $timestamps = false;
    protected $fillable = ['from','message','room_id','send_at'];


    public function relationByUser(){

        return $this->belongsTo(User::class,'from');
    }
}
