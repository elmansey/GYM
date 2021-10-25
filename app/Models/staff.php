<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class staff extends Model
{
    use HasFactory;
    protected $table = 'staff';
    protected $fillable = [
        'firstName',
        'middleName',
        'lastName'	,
        'phone'	,
        'email',
        'avatar',
        'jop'	,
        'notes'
    ];



    protected static function boot()
    {

        parent::boot();


        static::creating(function($model){

            if(empty($model->Personal_uuid)){
                $model->Personal_uuid = Str::uuid();
            }

        });

    }

}
