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
        'payment',
        'amount_paid',
        'start_date',
        'period_Expiry',
        'Subscription_period',
        'subscription_status',
        'gender',
        'membership_price',
        'date_of_birth',
        'address',
        'city',
        'profile_picture',
        'source',
        'Account_freeze',
        'days_left_before_freezing',
        'source',
        'unFreeze_in',
        'log',
        'total_payment',

    ];

    protected $casts = [
        'log' => 'array',
        'group_id' => 'array',
        'class_id' => 'array'
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




    public function memberShipsRelation(){
        return $this->belongsTo(Memberships::class,'membership_id');
    }
}
