@extends('layouts.frontend_app')

@section('frontend_content')

<!-- .breadcumb-area start -->
    <div class="breadcumb-area bg-img-4 ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcumb-wrap text-center">
                        <h2>Shop Page</h2>
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><span>{{ $product_info->slug }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .breadcumb-area end -->
    <!-- single-product-area start-->
    <div class="single-product-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product-single-img">
                        <div class="product-active owl-carousel">
                            <div class="item">
                                <img src="{{ asset('dashboard_asset/photo/product_photo') }}/{{ $product_info->product_photo }}" alt="Not found">
                            </div>
                            @foreach ($product_info->ProductMultiplePhoto as $single_photo)
                                <div class="item">
                                    <img src="{{ asset('dashboard_asset/photo/multiple_photos') }}/{{ $single_photo->product_multiple_photos }}" alt="Not found">
                                </div>
                            @endforeach
                        </div>
                        <div class="product-thumbnil-active  owl-carousel">
                            <div class="item">
                                <img src="{{ asset('dashboard_asset/photo/product_photo') }}/{{ $product_info->product_photo }}" alt="">
                            </div>
                            @foreach ($product_info->ProductMultiplePhoto as $single_photo)
                                <div class="item">
                                    <img src="{{ asset('dashboard_asset/photo/multiple_photos') }}/{{ $single_photo->product_multiple_photos }}" alt="">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product-single-content">
                        <h3>{{ $product_info->product_name }}</h3>
                        <div class="rating-wrap fix">
                            <span class="pull-left">${{ $product_info->price }}</span>
                            <ul class="rating pull-right">
                                @if (avarage_review_in_product_details($product_info->id) == 0)
                                    No review yet
                                @endif
                                @for ($i = 1; $i <= avarage_review_in_product_details($product_info->id); $i++)
                                    <li><i class="fa fa-star"></i></li>
                                @endfor
                                <li>({{ review_in_product_details($product_info->id) }} Customar Review)</li>
                            </ul>
                        </div>
                        <p>{!! $product_info->long_description !!}</p>
                        <ul class="input-style">
                            <form action="{{ url('add/cart') }}" method="POST">
                                @csrf
                                <input type="hidden" value="{{ $product_info->id }}" name="product_id">
                                <li class="quantity cart-plus-minus">
                                    <input type="text" value="1" name="quantity" />
                                </li>
                                <li><button type="submit" class="btn btn-danger">Add to Cart</button></li>
                            </form>
                        </ul>
                        <ul class="cetagory">
                            <li>Categories:</li>
                            <li><a href="#">{{ $product_info->withCategoryTable->category_name }}</a></li>
                        </ul>
                        <ul class="socil-icon">
                            <li>Share :</li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row mt-60">
                <div class="col-12">
                    <div class="single-product-menu">
                        <ul class="nav">
                            <li><a class="active" data-toggle="tab" href="#description">Description</a> </li>
                            <li><a data-toggle="tab" href="#tag">Faq</a></li>
                            <li><a data-toggle="tab" href="#review">Review</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12">
                    <div class="tab-content">
                        <div class="tab-pane active" id="description">
                            <div class="description-wrap">
                                <p>{{ $product_info->short_description }}</p>
                                <p>{!! $product_info->long_description !!}</p>
                            </div>
                        </div>
                        <div class="tab-pane" id="tag">
                            <div class="faq-wrap" id="accordion">
                                @foreach ($faqs as $faq)
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h5><button data-toggle="collapse" data-target="#collapse-{{$faq->id}}" aria-expanded="true" aria-controls="collapseOne">{{ $faq->question }}</button> </h5>
                                        </div>
                                        <div id="collapse-{{$faq->id}}" class="collapse {{ $faq->id == 1 ? 'show':'' }}" aria-labelledby="headingOne" data-parent="#accordion">
                                            <div class="card-body">
                                                {{ $faq->answer }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane" id="review">
                            <div class="review-wrap">
                                <ul>
                                    @foreach ($reviews as $review)
                                    <li class="review-items">
                                        <div class="review-img">
                                            <img src="assets/images/comment/1.png" alt="">
                                        </div>
                                        <div class="review-content">
                                            <h3><a href="#">{{ App\User::find($review->user_id)->name }}</a></h3>
                                            <span>{{ $review->created_at }}</span>
                                            <p>{{ $review->review }}</p>
                                            <ul class="rating">
                                                @for ($i = 1; $i <= $review->stars; $i++)
                                                    <li><i class="fa fa-star"></i></li>
                                                @endfor
                                            </ul>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @auth
                                @if ($product_purchased == 1)
                                   <div class="add-review">
                                        <h4>Add A Review</h4>
                                        <form action="{{ url('customer/review') }}" method="POST">
                                            @csrf
                                        <div class="ratting-wrap">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>task</th>
                                                        <th>1 Star</th>
                                                        <th>2 Star</th>
                                                        <th>3 Star</th>
                                                        <th>4 Star</th>
                                                        <th>5 Star</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    <tr>
                                                        <td>How Many Stars? </td>
                                                        <td>
                                                            <input type="radio" value="1" name="review" />
                                                        </td>
                                                        <td>
                                                            <input type="radio" value="2" name="review" />
                                                        </td>
                                                        <td>
                                                            <input type="radio" value="3" name="review" />
                                                        </td>
                                                        <td>
                                                            <input type="radio" value="4" name="review" />
                                                        </td>
                                                        <td>
                                                            <input type="radio" value="5" name="review" />
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4>Your Review:</h4>
                                                <input type="hidden" name="order_details_id" value="{{ $order_details_id }}">
                                                <textarea name="massage" id="massage" cols="30" rows="10" placeholder="Your review here..."></textarea>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn-style">Submit</button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- single-product-area end-->
    <!-- featured-product-area start -->
    <div class="featured-product-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-left">
                        <h2>Related Product</h2>
                    </div>
                </div>
            </div>
            <div class="row">
            	@foreach ($releted_products as $releted_product)
	                <div class="col-lg-3 col-sm-6 col-12">
	                    <div class="featured-product-wrap">
	                        <div class="featured-product-img">
	                            <img src="{{ asset('dashboard_asset/photo/product_photo') }}/{{ $releted_product->product_photo }}" alt="">
	                        </div>
	                        <div class="featured-product-content">
	                            <div class="row">
	                                <div class="col-7">
	                                    <h3><a href="{{ url('product/details') }}/{{ $releted_product->slug }}">{{ $releted_product->product_name }}</a></h3>
	                                    <p>${{ $releted_product->price }}</p>
	                                </div>
	                                <div class="col-5 text-right">
	                                    <ul>
	                                        <li><a href="cart.html"><i class="fa fa-shopping-cart"></i></a></li>
	                                        <li><a href="cart.html"><i class="fa fa-heart"></i></a></li>
	                                    </ul>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- featured-product-area end -->

@endsection   