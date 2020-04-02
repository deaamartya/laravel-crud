<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'categories';
    protected $fillable = ['category_name','status'];
    protected $primaryKey = 'category_id';
    public $timestamps = false;
    protected $attributes = [
        'category_name' => 'DEFAULT',
    ];
}