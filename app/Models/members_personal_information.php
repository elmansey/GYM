<?php

namespace App\Models;

use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class members_personal_information extends Model
{
    use HasFactory;

    protected $table = 'members_personal_informations';
    protected $fillable = [


        'name',
        'gender',
        'date_of_birth',
    ];




}
