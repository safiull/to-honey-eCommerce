@extends('layouts.frontend_app')

@section('frontend_content')

<!-- .breadcumb-area start -->
    <div class="breadcumb-area bg-img-4 ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcumb-wrap text-center">
                        <h2>Shopping Cart</h2>
                        <ul>
                            <li><a href="index.html">Home</a></li>
                            <li><span>Shopping Cart</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .breadcumb-area end -->
    <!-- cart-area start -->
    <div class="cart-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                	@if (session('deleted_status'))
						<div class="alert alert-warning">
							{{ session('deleted_status') }}
						</div>
					@endif
                    @if (session('update_status'))
                        <div class="alert alert-success">
                            {{ session('update_status') }}
                        </div>
                    @endif
                    @if ($error != '')
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endif
                    @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif
                    {{-- @php
                        print_r(session()->all())
                    @endphp --}}
                    <table class="table-responsive cart-wrap">
                        <thead>
                            <tr>
                                <th class="images">Image</th>
                                <th class="product">Product</th>
                                <th class="ptice">Price</th>
                                <th class="quantity">Quantity</th>
                                <th class="total">Total</th>
                                <th class="remove">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                        <form action="{{ url('/update/cart') }}" method="post">
                            @csrf
                        	@php
                                $subtotal = 0;
                                $flag = 0;
                            @endphp
                        	@forelse (CartProducts() as $cart_item)
                            <tr class="{{ $cart_item->quantity > $cart_item->product->alert_stock ? 'bg-danger':'' }}">
                                <td class="images"><img src="{{ asset('dashboard_asset/photo/product_photo') }}/{{ $cart_item->product->product_photo }}" width="70" alt="Not found"></td>
                                <td class="product"><a href="{{ url('product/details/') }}/{{ $cart_item->product->slug }}">{{ $cart_item->product->product_name }}</a>
                                    <span class="badge {{ $cart_item->product->alert_stock > 0 ? 'badge-success': 'badge-danger' }}">Available({{ $cart_item->product->alert_stock }})</span>
                                </td>
                                <td class="ptice">${{ $cart_item->product->price }}</td>
                                <td class="quantity cart-plus-minus">
                                    <input type="text" name="product_info[{{ $cart_item->id }}]" value="{{ $cart_item->quantity }}" />
                                </td>
                                <td class="total">${{ $cart_item->product->price * $cart_item->quantity }}</td>
                                <td class="remove"><a class="btn btn-sm btn-danger" href="{{ url('delete/cart') }}/{{ $cart_item->id }}"><i class="fa fa-times"></i></a></td>
                            </tr>
                            @php
                                $subtotal+= $cart_item->product->price * $cart_item->quantity
                            @endphp
                                @if ($cart_item->quantity > $cart_item->product->alert_stock)
                                    @php
                                        $flag = 1;
                                    @endphp
                                @endif
                            @empty 
                            	<td colspan="0" class="text-danger">No data available</td>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="row mt-60">
                        <div class="col-xl-4 col-lg-5 col-md-6 ">
                            <div class="cartcupon-wrap">
                                <ul class="d-flex">
                                    <li>
                                        <button type="submit">Update Cart</button>
                                    </li>
                                </form>
                                    <li><a href="{{ url('shop') }}">Continue Shopping</a></li>
                                </ul>
                                <h3>Cupon</h3>
                                <p>Enter Your Cupon Code if You Have One</p>
                                <div class="cupon-wrap">
                                    <input type="text" value="{{ $coupon }}" id="coupon" placeholder="Cupon Code">
                                    <button type="button" id="coupon_btn">Apply Cupon</button>
                                </div>
                                @foreach ($valid_coupons as $valid_coupon)
                                    <button value="{{ $valid_coupon->coupon_name }}" type="button" class="badge badge-info">{{ $valid_coupon->coupon_name }} - You have to shop more than or equal {{ $valid_coupon->minimum_purchase_amount }}</button>
                                @endforeach
                            </div>
                        </div>
                        @php
                            session(['subtotal_price' => $subtotal]);
                            session(['discount_price' => ($subtotal / 100) * $discount_amount]);
                            session(['total_price' => ($subtotal - ($subtotal / 100) * $discount_amount)]);
                            session(['coupon_name' => $coupon]);

                        @endphp
                        <div class="col-xl-3 offset-xl-5 col-lg-4 offset-lg-3 col-md-6">
                            <div class="cart-total text-right">
                                <h3>Cart Totals</h3>
                                <ul>
                                    <li><span class="pull-left">Subtotal </span>${{ $subtotal }}</li>
                                    <li><span class="pull-left">Discount(%) </span>{{ $discount_amount }} %</li>
                                    <li><span class="pull-left">Discount({{ $coupon ? $coupon:'-' }}) </span>${{ ($subtotal / 100) * $discount_amount }} </li>
                                    <li><span class="pull-left"> Total </span> ${{ $subtotal - ($subtotal / 100) * $discount_amount }}</li>
                                </ul>
                                @if ($flag == 1)
                                    <a>Please solve the issue.</a>
                                @else
                                    <a href="{{ url('checkout') }}">Proceed to Checkout</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cart-area end -->

@endsection

@section('footer_app') 

<script>
    $(document).ready(function(){
      $("#coupon_btn").click(function(){
        var coupon = $("#coupon").val();
        var link_to_go = "{{ url('go_to_cart/') }}/"+coupon;
        window.location.href = link_to_go;
      });
      $(".badge").click(function(){
        $("#coupon").val($(this).val());
      });
    });
</script>

@endsection