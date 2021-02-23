<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\FAQ;
use App\User;
use App\Order_details;
use Carbon\Carbon;
use Hash;
use Auth;

class FrontendController extends Controller
{
    public function eCommerceHome()
    {
        return view('frontend.index', [
            'categories' => Category::all(),
            'products' =>Product::latest()->limit(8)->get()
        ]);
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function productDetails($slug) 
    {
    	$product_info = Product::where('slug', $slug)->firstOrFail();
    	$releted_product = Product::where('category_id', $product_info->category_id)->where('id', '!=', $product_info->id)->get();

        $product_purchased = 0;
        if (Order_details::where('user_id', Auth::id())->where('product_id', $product_info->id)->whereNull('stars')->exists()) {
            $product_purchased = 1;
            $order_details_id = Order_details::where('user_id', Auth::id())->where('product_id', $product_info->id)->whereNull('stars')->first()->id;
        } else {
            $order_details_id = 0;
        }
        $reviews = Order_details::where('user_id', Auth::id())->where('product_id', $product_info->id)->whereNotNull('stars')->get();
    	return view('frontend.productDetails', [
            'product_info' => $product_info,
            'releted_products' => $releted_product,
            'faqs' => FAQ::all(),
            'product_purchased' => $product_purchased,
            'order_details_id' => $order_details_id,
            'reviews' => $reviews
        ]);
    }

    // FAQ
    public function faq() 
    {
        return view('frontend.faq.index', [
            'faqs' => FAQ::all()
        ]);    
    }

    public function shop() 
    {
        return view('frontend.shop.shop', [
            'products' => Product::all(),
            'categories' => Category::all()
        ]);
    }
    public function CustomerLogin() 
    {
        return view('frontend.customer_login');
    }
    public function CustomerLoginPost(Request $request) 
    {
        // print_r($request->all());
        $validatedData = $request->validate([
            'name' => 'required|min:2|max:255',
            'email' => 'email:rfc,dns',
            'password' => 'required|confirmed|min:6',
        ]);

        User::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now(),
            'role' => 2
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('customer/home');
        }
    }

    public function CustomerReview(Request $request) 
    {
        Order_details::find($request->order_details_id)->update([
            'stars' => $request->review,
            'review' => $request->massage
        ]);
        return back();
    }
}
