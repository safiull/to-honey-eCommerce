<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Billing;
use App\Shipping;
use App\Country;
use App\City;
use App\Product;
use App\Order;
use App\Order_details;
use Carbon\Carbon;
use Auth;
use App\Mail\PurchaseConfirmMail;
use Mail;
use PDF;


class CheckoutController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	return view('frontend.checkout',[
    		'countries' => Country::all()
    	]);
    }

    public function CheckoutPost(Request $request)
    {
    	if ($request->shipping_diffrent_address) {
    		$shippingId = Shipping::insertGetId([
	    		'name' => $request->shipping_name,
	    		'email' => $request->shipping_email,
	    		'phone_number' => $request->shipping_phone_number,
	    		'country_id' => $request->shipping_country_id,
	    		'city_id' => $request->shipping_city_id,
	    		'address' => $request->shipping_address,
	    		'created_at' => Carbon::now()
	    	]);
    	} else {
    		$shippingId = Shipping::insertGetId([
	    		'name' => $request->name,
	    		'email' => $request->email,
	    		'phone_number' => $request->phone_number,
	    		'country_id' => $request->country_id,
	    		'city_id' => $request->city_id,
	    		'address' => $request->address,
	    		'created_at' => Carbon::now()
	    	]);
    	}
    	$billingId = Billing::insertGetId([
    		'name' => $request->name,
    		'email' => $request->email,
    		'phone_number' => $request->phone_number,
    		'country_id' => $request->country_id,
    		'city_id' => $request->city_id,
    		'address' => $request->address,
    		'notes' => $request->notes,
    		'created_at' => Carbon::now()
    	]);
        $OrderId = Order::insertGetId([
            'user_id' => Auth::id(),
            'sub_total' => session('subtotal_price'),
            'discount_amount' => session('discount_price'),
            'coupon_name' => session('coupon_name'),
            'total' => session('total_price'),
            'payment_option' => $request->payment_method,
            'billing_id' => $billingId,
            'shipping_id' => $shippingId,
            'created_at' => Carbon::now()
        ]);
        foreach (CartProducts() as $CartProduct) {
            Order_details::insertGetId([
                'order_id' => $OrderId,
                'product_id' => $CartProduct->product_id,
                'product_quantity' => $CartProduct->quantity,
                'product_price' => $CartProduct->product->price,
                'created_at' => Carbon::now()
            ]);
            // Decrement product when a user purchase a product
            Product::find($CartProduct->product_id)->decrement('alert_stock', $CartProduct->quantity);
            //Delete data from card table@
            $CartProduct->delete();
        }
		$invoice = Order_details::where('order_id', $OrderId)->get();
        Mail::to($request->email)->send(new PurchaseConfirmMail($invoice));
    	if($request->payment_method == 2) {
			session(['order_id' => $OrderId]);
			return redirect('stripe');
		}
    	return redirect('go_to_cart');
    }

    public function GetCities(Request $request)
    {
    	$options = '';
    	$cities = City::where('country_id', $request->country_id)->get();
    	foreach ($cities as $city) {
    		// $options .= $city;
    		$options .= "<option value='". $city->id ."'>". $city->name ."</option>";
    	}
    	return $options;
    }

	public function OrderInvoiceDownload($order_id) {
		$order_infos = Order_details::where('order_id', $order_id)->get();
		$pdf = PDF::loadView('orders.InvoicePdf', compact('order_infos'));
		return $pdf->download('invoice'.$order_id.'.pdf');
	}
}
