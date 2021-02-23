@extends('layouts.frontend_app')

@section('frontend_content')

<!-- .breadcumb-area start -->
    <div class="breadcumb-area bg-img-4 ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcumb-wrap text-center">
                        <h2>Checkout</h2>
                        <ul>
                            <li><a href="index.html">Home</a></li>
                            <li><span>Checkout</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .breadcumb-area end -->
    <!-- checkout-area start -->
    <div class="checkout-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="checkout-form form-style">
                        <h3>Billing Details</h3>
                        <form action="{{ url('checkout/post') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <p>Name *</p>
                                    <input type="text" name="name" value="{{ Auth::user()->name }}">
                                </div>
                                <div class="col-sm-6 col-12">
                                    <p>Email Address *</p>
                                    <input type="email" name="email" value="{{ Auth::user()->email }}">
                                </div>
                                <div class="col-sm-6 col-12">
                                    <p>Phone No. *</p>
                                    <input type="text" name="phone_number">
                                </div>
                                <div class="col-6">
                                    <p>Country *</p>
                                    <select id="s_country" class="country_table_1" name="country_id">
                                        <option>Select a country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 col-12 mb-3">
                                    <p>City *</p>
                                    <select class="city_table_1" id="city_list_1" name="city_id">
                                        <option>Select a city</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <p>Your address *</p>
                                    <input type="text" name="address">
                                </div>
                                    <div class="col-12">
                                        <input value="1" name="shipping_diffrent_address" id="toggle2" type="checkbox">
                                        <label class="fontsize" for="toggle2">Ship to a different address?</label>
                                        <div class="row" id="open2">
                                            <div class="col-12">
                                        <p>Name *</p>
                                        <input type="text" name="shipping_name">
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <p>Email Address *</p>
                                        <input type="email" name="shipping_email">
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <p>Phone No. *</p>
                                        <input type="text" name="shipping_phone_number">
                                    </div>
                                    <div class="col-6">
                                        <p>Country *</p>
                                        <select class="country_table_2" id="s_country" name="shipping_country_id">
                                            <option>Select a country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <p>City *</p>
                                        <select id="city_list_2" name="shipping_city_id">
                                            <option>Select a city</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <p>Your address *</p>
                                        <input type="text" name="shipping_address">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <p>Order Notes </p>
                                <textarea name="notes" placeholder="Notes about Your Order, e.g.Special Note for Delivery"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="order-area">
                        <h3>Your Order</h3>
                        <ul class="total-cost">
                        	@foreach (CartProducts() as $cart_item)
                            	<li>{{ $cart_item->product->product_name.' x '.$cart_item->quantity }} <span class="pull-right">${{ $cart_item->quantity * $cart_item->product->price  }}</span></li>
                        	@endforeach
                            <li>Subtotal <span class="pull-right"><strong>$
                                @php
                                    echo session('subtotal_price');
                                @endphp
                            </strong></span></li>
                            <li>Shipping <span class="pull-right">Free</span></li>
                            <li>Discount({{ session('coupon_name') ? session('coupon_name'):"-" }}) <span class="pull-right">$
                                @php
                                    echo session('discount_price');
                                @endphp
                            </span></li>
                            <li>Total<span class="pull-right">$
                                @php
                                    echo session('total_price');
                                @endphp
                            </span></li>
                        </ul>
                            <ul class="payment-method">
                                <li>
                                    <input id="delivery" name="payment_method" type="radio" value="1" checked>
                                    <label for="delivery">Cash on Delivery</label>
                                </li>
                                <li>
                                    <input id="card" name="payment_method" type="radio" value="2">
                                    <label for="card">Credit Card</label>
                                </li>
                            </ul>
                            <button type="submit">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- checkout-area end -->

@endsection

@section('footer_app')

<script>
    $(document).ready(function() {
        $('.country_table_1').select2();
        $('.city_table_1').select2();
        $('.country_table_1').change(function(){
            var country_id = $(this).val();
            // alert(country_id)
            // Setup ajax
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Ajax response
            $.ajax({
                type: 'POST',
                url: 'get/cities',
                data: {country_id: country_id},
                success: function (data) {
                    $('#city_list_1').html(data)
                    // alert(data)
                }
            });
        });
        $('.country_table_2').change(function(){
            var country_id = $(this).val();
            // alert(country_id)
            // Setup ajax
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Ajax response
            $.ajax({
                type: 'POST',
                url: 'get/cities',
                data: {country_id: country_id},
                success: function (data) {
                    $('#city_list_2').html(data)
                    // alert(data)
                }
            });
        });
    });
</script>

@endsection