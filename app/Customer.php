<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    protected $fillable = [
    	'first_name','last_name','phone','email','street','city','state','zip_code'
    ];
    protected $primaryKey = 'customer_id';
    public $timestamps = false;
}
