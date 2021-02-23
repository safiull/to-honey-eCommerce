@extends('layouts.frontend_app')

@section('frontend_content')

<!-- .breadcumb-area start -->
    <div class="breadcumb-area bg-img-4 ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcumb-wrap text-center">
                        <h2>Frequently Asked Questions (FAQ)</h2>
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><span>FAQ</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .breadcumb-area end -->
    <!-- about-area start -->
    <div class="about-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                  <div class="about-wrap text-center">
                    <h3>FAQ</h3>
                  </div>
                  <div class="accordion" id="accordionExample">
                  	@foreach ($faqs as $faq)
                  		<div class="card border-0">
	                      <div class="card-header bg-secondary border-0 p-0 my-3">
	                          <button class="btn collapsed btn-link text-left py-3 w-100 text-white" type="button" data-toggle="collapse" data-target="#faq-{{$faq->id}}" aria-expanded="true" aria-controls="faq-{{$faq->id}}">
	                           {{ $faq->question }}
	                          </button>
	                      </div>

	                      <div id="faq-{{$faq->id}}" class="collapse {{ $faq->id == 1 ? 'show':'' }}" aria-labelledby="faq-{{$faq->id}}" data-parent="#accordionExample">
	                        <div class="card-body">
	                          {{ $faq->answer }}
	                        </div>
	                      </div>
	                    </div>
                  	@endforeach
                  </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about-area end -->

@endsection   