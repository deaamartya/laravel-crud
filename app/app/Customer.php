<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
	
class Customer extends Model
{
	use SoftDeletes;
    protected $table = 'customer';
    protected $fillable = [
    	'first_name','last_name','phone','email','street','city','state','zip_code'
    ];
    protected $primaryKey = 'customer_id';
    public $incrementing = false;
}
