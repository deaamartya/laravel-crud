<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
	
class Category extends Model
{
	use SoftDeletes;
	protected $table = 'categories';
    protected $fillable = ['category_id','category_name','status'];
    protected $primaryKey = 'category_id';
}