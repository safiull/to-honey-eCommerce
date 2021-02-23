<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_details extends Model
{
	protected $guarded = [];
    function product()
    {
    	return $this->belongsTo('App\Product', 'product_id', 'id');
    }
}
