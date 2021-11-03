<?php

namespace App\Models;


use Illuminate\Support\Str;
use App\Models\teamChatMessage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class staff extends  Authenticatable implements JWTSubject
{
    use HasFactory ,HasApiTokens, HasFactory,  HasRoles;
    protected $table = 'staff';
    protected $guard_name = 'staff';
    protected $fillable = [
        'firstName',
        'middleName',
        'lastName'	,
        'phone'	,
        'email',
        'profile_picture',
        'notes',
        'userName',
        'password',
        'isActive'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


   public function getJWTCustomClaims()
    {
        return [];
    }

    protected static function boot()
    {

        parent::boot();


        static::creating(function($model){

            if(empty($model->Personal_uuid)){
                $model->Personal_uuid = Str::uuid();
            }

        });

    }


    public  function teamMessages(){

        return $this->hasMany(teamChatMessage::class);
    }

}
