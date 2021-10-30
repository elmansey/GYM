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
        'className',
        'staffName',
        'days',
        'startingTime',
         'endingTime',
         'trainingLocation'
        ];






    protected $casts = [
        'days' => 'array'
    ];






    public function captain_relation(){

        return $this->belongsTo(staff::class,'staffName');

    }
}
