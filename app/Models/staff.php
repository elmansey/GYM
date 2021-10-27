<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class staff extends  Authenticatable implements JWTSubject
{
    use HasFactory ,  HasRoles;
    protected $table = 'staff';
    protected $guard_name = 'api';
    protected $fillable = [
        'firstName',
        'middleName',
        'lastName'	,
        'phone'	,
        'email',
        'avatar',
        'role_id'	,
        'notes',
        'userName',
        'password'
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

}
