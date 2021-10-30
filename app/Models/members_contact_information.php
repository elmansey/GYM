<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class members_contact_information extends Model
{
    use HasFactory;
    protected $table = 'members_contact_informations';
    protected $fillable = [


        'member_id',
        'address',
        'city',
        'phone_number',
    ];
}
