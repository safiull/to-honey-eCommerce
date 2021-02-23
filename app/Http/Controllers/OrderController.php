<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
class OrderController extends Controller
{
    
    public function orders()
    {
    	return view('orders.index',[
    		'orders' => Order::with('order_details')->get()
    	]);
    }
}
