<?php

function ProductCount()
{
	return App\Product::count();
}
function CartProductCount()
{
	return App\Cart::where('generated_cart_id', Cookie::get('g_cart_id'))->count();
}
function CartProducts()
{
	return App\Cart::where('generated_cart_id', Cookie::get('g_cart_id'))->get();
}
function review_in_product_details($product_id)
{
	return App\Order_details::where('product_id', $product_id)->whereNotNull('stars')->count();
}
function avarage_review_in_product_details($product_id)
{
	$total_review = App\Order_details::where('product_id', $product_id)->whereNotNull('stars')->count();
	$summation_review = App\Order_details::where('product_id', $product_id)->whereNotNull('stars')->sum('stars');
	if ($summation_review == 0) {
		return 0;
	} else {
		return round($summation_review / $total_review);
	}
}