<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SaleDetail extends Model
{
	use SoftDeletes;
    protected $table = 'sales_detail';
    
    protected $fillable = [
    	'nota_id','product_id','quantity','selling_price','discount','total_price'
    ];
    
    public $incrementing = false;
}
