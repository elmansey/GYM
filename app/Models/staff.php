<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class staff extends Model
{
    use HasFactory;
    protected $table = 'staff';
    protected $fillable = [
        'firstName',
        'middleName',
        'lastName'	,
        'phone'	,
        'email',
        'avatar',
        'jop'	,
        'notes'
    ];
}
