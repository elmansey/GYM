<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chatRoom extends Model
{
    use HasFactory;
    protected $table = 'chat_rooms';
    public $timestamps = false;
    public $fillable = ['name'];
}
