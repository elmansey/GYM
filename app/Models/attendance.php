<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendance extends Model
{
    use HasFactory;

    protected $table = 'attendance';
    protected $fillable = [
        'RF_code',
        'date',
        'come_time',
        'leave_time'
    ];



}
