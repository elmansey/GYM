<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class product_invoices extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = ['invoice_number','seller','invoice_details','invoice_total','time', 'date'];


    protected $casts = [
        'invoice_details' => 'array',
    ];



    public function sellerRelation(){

        return $this->belongsTo(User::class,'seller');
    }

}
