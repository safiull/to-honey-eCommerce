<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    function order_details()
    {
    	return $this->hasMany('App\Order_details');
    }
} 
