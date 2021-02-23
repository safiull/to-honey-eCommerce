<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Cart extends Model
{
	protected $guarded = [];
    function product(){
    	return $this->belongsTo('App\Product');
    }
}
