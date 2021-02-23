<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.index');
});

Route::get('/login', function () {
    return view('auth.login');
});

Auth::routes(['verify' => true]);


Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::get('/send/mail', 'HomeController@sendMailToSubscirbers');

// Category Controller
Route::get('/add/category', 'CategoryController@index');
Route::post('/add/category/post', 'CategoryController@storeCategory');
Route::get('/delete/{category_id}', 'CategoryController@destroyCategory');
Route::get('/edit/category/{category_id}', 'CategoryController@showCategory');
Route::post('/edit/category/post', 'CategoryController@editCategory');
Route::get('/restore/category/{category_id}', 'CategoryController@restoreCategory');
Route::get('/forcedelete/{category_id}', 'CategoryController@forcedeleteCategory');
Route::post('/mark/delete', 'CategoryController@markDeleteCategory');

// ProfileController
Route::get('/profile/edit/', 'ProfileController@profileEditCategory');
Route::post('/edit/profile/post', 'ProfileController@profileEditPostCategory');
Route::post('/change/password/post', 'ProfileController@ChangePasswordPost');
Route::post('/change/image/post', 'ProfileController@changeImagePost');

// ProductController
Route::resource('product', 'ProductController');

// CouponController
Route::resource('coupon', 'CouponController');

// Frontend Controller
Route::get('/', 'FrontendController@eCommerceHome');
Route::get('/contact', 'FrontendController@contact');
Route::get('/product/details/{slug}', 'FrontendController@productDetails');
// Review
Route::post('/customer/review', 'FrontendController@CustomerReview');


// FAQ page.
Route::get('/faq', 'FrontendController@faq');
// Shop page
Route::get('/shop', 'FrontendController@shop');
// Customer login
Route::get('/customer/login', 'FrontendController@CustomerLogin');
Route::post('/customer/login/post', 'FrontendController@CustomerLoginPost');



// Message Controller
Route::get('/message', 'MessageController@message');
Route::post('/send/message', 'MessageController@sendMessage');
Route::get('/contact/attachment/download/{msg_id}', 'MessageController@attachmentDownload');

// Faq controller 
Route::get('/backend/faq', 'FaqController@index');
Route::post('/add-faq', 'FaqController@addFaq');
Route::get('/faq/delete/{faq_id}', 'FaqController@destroy');

// Cart controller
Route::post('/add/cart', 'CartController@AddToCart');
Route::get('/go_to_cart', 'CartController@index');
Route::get('/go_to_cart/{coupon}', 'CartController@index');
Route::get('/delete/cart/{cart_id}', 'CartController@destroy');
Route::post('/update/cart', 'CartController@updateCart');

// Customer controller
Route::get('/customer/home', 'CustomerController@home');


// GithubController
Route::get('login/github/callback', 'GithubController@handleProviderCallback');
Route::get('login/github', 'GithubController@redirectToProvider');

// CheckoutController
Route::get('/checkout', 'CheckoutController@index');
Route::post('/checkout/post', 'CheckoutController@CheckoutPost');
Route::post('/get/cities', 'CheckoutController@GetCities');
Route::get('/order/invoice/download/{order_id}', 'CheckoutController@OrderInvoiceDownload');

// OrderController
Route::get('/orders', 'OrderController@orders');

// StripePaymentController
Route::get('stripe', 'StripePaymentController@stripe');
Route::post('stripe', 'StripePaymentController@stripePost')->name('stripe.post');