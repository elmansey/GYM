<?php

namespace App\Models;

use App\Models\Groups;
use App\Models\Memberships;
use Illuminate\Support\Str;
use App\Models\ClassSchedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class members_extra_information extends Model
{
    use HasFactory;
    protected $table = 'members_extra_informations';
    protected $fillable = [



        'interested_area',
        'name',
        'qr_code',
        'RF_code',
        'phone',
        'membership_id',
        'group_id',
        'class_id',
        'amount_paid',
        'Subscription_status',
        'start_date',
        'period_Expiry',
        'Subscription_period',
        'gender',
        'date_of_birth',
        'address',
        'city',
        'profile_picture',
        'source',
        'Account_freeze',
        'days_left_before_freezing',
        'status',
        'unFreeze_in',
        'log'

    ];

    protected $casts = [
        'log' => 'array'
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


    public function groupRelation(){
        return $this->belongsTo(Groups::class,'group_id');
    }

    public function classRelation(){
        return $this->belongsTo(ClassSchedule::class,'class_id');
    }

    public function memberShipsRelation(){
        return $this->belongsTo(Memberships::class,'membership_id');
    }
}
