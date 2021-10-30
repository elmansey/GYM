<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

use Illuminate\Foundation\Auth\User as Authenticatable;
class members_login_information extends Authenticatable implements JWTSubject
{
    use HasFactory ,HasApiTokens, HasFactory,  HasRoles;

    protected $table = 'members_login_informations';
    protected $guard_name = 'member';
    protected $fillable = [
            'member_id' ,
        	'user_name' ,
            'email' ,
            'password' ,
            'profile_picture' ,
            'isActive' ,
    ];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


   public function getJWTCustomClaims()
    {
        return [];
    }


    public function personalTableRelation(){
        return $this->belongsTo(members_personal_information::class,'member_id');
    }

}
