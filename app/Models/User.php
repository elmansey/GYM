<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\teamChatMessage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $guard_name = 'api';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'profile_picture',
        'user_name',
        'isActive',
        'qr_code',
        'RF_code',
        'device_key'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',

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



    public function messageTeamRelationTo(){

        return $this->hasMany(teamChatMessage::class,'from');

    }






}
