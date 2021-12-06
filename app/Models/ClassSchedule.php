<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\staff;

class ClassSchedule extends Model
{
    use HasFactory;

    protected $table= 'class_schedules';

    protected $fillable = [

        'staffName',
        'days',
        'startingTime',
         'endingTime',
         'trainingLocation'
        ];






    protected $casts = [
        'days' => 'array'
    ];






    public function staff_relation(){

        return $this->belongsTo(User::class,'staffName');

    }

    public function group_relation(){

        return $this->belongsTo(Groups::class,'group_id');

    }
}
