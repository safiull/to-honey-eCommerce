<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // protected $fillable = [
    //     'product_name', 'supplier_name', 'alert_stock', 'price', 'brand', 'category_id', 'long_description', 'short_description', 'product_photo',
    // ];
    protected $guarded = [];

    public function withCategoryTable() 
    {
    	return $this->hasOne('App\Category', 'id', 'category_id')->withTrashed();
    }
    public function ProductMultiplePhoto() 
    {
    	return $this->hasMany('App\ProductMultiplePhoto', 'product_id', 'id');
    }
}
