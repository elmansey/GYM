<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activity_logs extends Model
{
    use HasFactory;
    protected $table = 'activity_logs';
    protected $fillable = ['user_id', 'title', 'date'];



    public function  userRelation()
    {

        return $this->belongsTo(User::class, 'user_id');
    }
}
