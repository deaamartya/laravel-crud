<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    protected $table = 'sales_detail';
    
    protected $fillable = [
    	'nota_id','product_id','quantity','selling_price','discount','total_price'
    ];

    public $timestamps = false;
    
    public $incrementing = false;
}
