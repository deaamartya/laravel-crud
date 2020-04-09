<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
	use SoftDeletes;
    protected $table = 'product';
    protected $fillable = [
    	'product_id','category_id','product_name','product_price','product_stock','explanation'
    ];
    protected $primaryKey = 'product_id';
}
