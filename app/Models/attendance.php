<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendance extends Model
{
    use HasFactory;

    protected $table = 'attendance';
    protected $fillable = [
        'user_id',
        'date',
        'come_time',
        'leave_time'
    ];

    public function userRelation (){

        return $this->belongsTo(User::class,'user_id');
    }

}
