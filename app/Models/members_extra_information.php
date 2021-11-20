<?php

namespace App\Models;

use App\Models\Groups;
use App\Models\ClassSchedule;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class members_extra_information extends Model
{
    use HasFactory;
    protected $table = 'members_extra_informations';
    protected $fillable = [

        'member_id' ,
        'interested_area' ,
        'source' ,
        'membership_id' ,
        'group_id' ,
        'class_id' ,
        'start_date' ,
        'amount_paid',
        'Subscription_status',
        'period_Expiry',
        'Subscription_period',
        'gender',
        'data_of_birth',
        'address',
        'city',
        'qr_code'
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
}
