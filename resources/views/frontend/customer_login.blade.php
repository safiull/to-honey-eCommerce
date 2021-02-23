@extends('layouts.frontend_app')

@section('frontend_content')

 <!-- .breadcumb-area start -->
    <div class="breadcumb-area bg-img-4 ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcumb-wrap text-center">
                        <h2>Account</h2>
                        <ul>
                            <li><a href="index.html">Home</a></li>
                            <li><span>Register</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .breadcumb-area end -->
    <!-- checkout-area start -->
    <div class="account-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12">
                    <div class="account-form form-style">
                    	<form action="{{ url('/customer/login/post') }}" method="post">
                    		@csrf
	                        <label>Name *</label>
	                        <input type="text" name="name">
	                        @error('name')
							    <span class="text-danger">{{ $message }}</span>
							@enderror
	                        <label>Email Address *</label>
	                        <input type="email" name="email">
	                        @error('email')
							    <span class="text-danger">{{ $message }}</span>
							@enderror
	                        <p>Password *</p>
	                        <input type="password" name="password">
	                        @error('password')
							    <span class="text-danger">{{ $message }}</span>
							@enderror
	                        <p>Confirm Password *</p>
	                        <input type="password" name="password_confirmation">
	                        @error('password_confirmation')
							    <span class="text-danger">{{ $message }}</span>
							@enderror
	                        <button type="submit">Register</button>
	                        <div class="text-center">
	                            <a href="{{ url('login') }}">Or Login</a>
	                        </div>
	                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- checkout-area end -->

@endsection