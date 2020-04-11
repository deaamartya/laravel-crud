<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Sale extends Model
{
	use SoftDeletes;
    protected $table = 'sales';
    protected $fillable = [
    	'nota_id','customer_id','user_id','nota_date','total_payment'
    ];
    protected $primaryKey = 'nota_id';
    public $incrementing = false;
}
