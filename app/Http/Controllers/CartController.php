<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use App\Cart;
use App\Coupon;
use Carbon\Carbon;

class CartController extends Controller
{
    public function index($coupon = "") {
        $error = '';
        $discount_amount = 0;
        if ($coupon == '') {
            $error = '';
        } else {
            if (!Coupon::where('coupon_name', $coupon)->exists()) {
                $error = "Your coupon is invalid.";
            } else {
                if (Carbon::now()->format('Y-m-d') > Coupon::where('coupon_name', $coupon)->first()->validity_till) {
                    $error = "This Coupon has been expired!";
                } else {
                    // echo Coupon::where('coupon_name', $coupon)->first()->minimum_purchase_amount;
                    $subtotal = 0;
                    foreach (CartProducts() as $cart_itme) {
                        $subtotal += ($cart_itme->product->price * $cart_itme->quantity);
                    }
                    if (Coupon::where('coupon_name', $coupon)->first()->minimum_purchase_amount > $subtotal) {
                        $error = "You have to shoping more than or equal : ".Coupon::where('coupon_name', $coupon)->first()->minimum_purchase_amount;
                    } else {
                        $discount_amount = Coupon::where('coupon_name', $coupon)->first()->discount_amount;
                    }
                }
            }
        }
        $valid_coupons = Coupon::whereDate('validity_till', '>=', Carbon::now()->format('Y-m-d'))->get();
        return view('frontend.shop.cart', compact('error', 'discount_amount', 'coupon', 'valid_coupons'));
    }

    public function AddToCart(Request $request)
    {
    	if (Cookie::get('g_cart_id')) {
    		$generated_cart_id = Cookie::get('g_cart_id');
    	} else {
    		$generated_cart_id = Str::random(5).rand(1,1000);
    		Cookie::queue('g_cart_id', $generated_cart_id, 1440);
    	}

    	if (Cart::where('generated_cart_id', $generated_cart_id)->where('product_id', $request->product_id)->exists()) {
    		Cart::where('generated_cart_id', $generated_cart_id)->where('product_id', $request->product_id)->increment('quantity', $request->quantity);
    	} else {
    		Cart::insert([
				'generated_cart_id' => $generated_cart_id,
				'product_id' => $request->product_id,
				'quantity' => $request->quantity,
	    		'created_at' => Carbon::now(),
	    	]);
    	}
    	return back();   	
    }

    public function updateCart(Request $request)
    {
        foreach ($request->product_info as $cart_id => $quantity) {
            Cart::find($cart_id)->update([
                'quantity' => $quantity
            ]); 
        }

        return back()->with('update_status', 'Cart updated successfully!');
    }

    public function destroy($cart_id)
    {
        Cart::find($cart_id)->delete();
        return back()->with('deleted_status', 'Cart deleted successfully.');
    }
}
