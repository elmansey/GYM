<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
class model_has_permissions extends Model
{
    use HasFactory;
    protected  $table  =  'model_has_permissions';

    public function permissionRelassion(){

        return $this->belongsTo(Permission::class,'permission_id')->select('id','name');

    }



}
