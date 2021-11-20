<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'amount_paid'
    ];
}
