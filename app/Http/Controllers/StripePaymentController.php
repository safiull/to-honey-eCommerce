<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Stripe;
use App\Order;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        if(session('order_id')) {
            return view('payment.stripe');
            // echo session('order_id');
        }
        abort(404);
    }
  
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => 1000 * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Payment from ironman. Order ID -> ".session('order_id')  
        ]);
  
        Session::flash('success', 'Payment successful!');
        Order::find(session('order_id'))->update([
            'payment_status' => 2
        ]);
        session([
            'subtotal_price' => '',
            'discount_price' => '',
            'total_price' => '',
            'coupon_name' => '',
        ]);
        return redirect('go_to_cart');
    }
}
