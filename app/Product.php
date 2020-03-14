<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $fillable = [
    	'product_id','category_id','product_name','product_price','product_stock','explanation'
    ];
    protected $primaryKey = 'product_id';
    public $timestamps = false;
    protected $attributes = [
        'explanation' => "Tidak ada deskripsi untuk produk ini."
    ];
}
