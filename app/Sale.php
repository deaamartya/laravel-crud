<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sales';
    protected $fillable = [
    	'nota_id','customer_id','user_id','nota_date','total_payment'
    ];
    protected $primaryKey = 'nota_id';
    public $incrementing = false;
    public $timestamps = false;
}
