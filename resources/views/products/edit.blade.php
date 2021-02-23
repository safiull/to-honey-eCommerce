@extends('layouts.dashboard_app')

@section('product')
	active
@endsection
@section('title')
	Product edit | Dashboard
@endsection
@section('dashboard_content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Product edit</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Product edit</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<div class="container">
	<div class="row mt-4">
		<div class="col-6 m-auto">
			<div class="card">
				<div class="card-header">
					<h3>Edit product</h3>
				</div>
				<div class="card-body">
				{{-- @if (session('image_upload_status'))
					<div class="alert alert-success">
						{{ session('image_upload_status') }}
					</div>
				@endif --}}
					<div class="form-group">
						<form action="{{ route('product.update', $products->id) }}" method="post" enctype="multipart/form-data">
							@csrf
							@method('PATCH')
							<div class="form-group">
								<input type="text" name="product_name" placeholder="Product name" class="form-control" value="{{ $products->product_name }}">
								@error('product_name')
								    <span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<input type="text" name="supplier_name" placeholder="Supplier name" class="form-control" value="{{ $products->supplier_name }}">
								@error('supplier_name')
								    <span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<input type="number" name="alert_stock" placeholder="Alert stock quantity" class="form-control" value="{{ $products->alert_stock }}">
								@error('alert_stock')
								    <span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<input type="number" name="price" placeholder="Price" class="form-control" value="{{ $products->alert_stock }}">
								@error('alert_stock')
								    <span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<input type="text" name="brand" placeholder="Brand" class="form-control" value="{{ $products->brand }}">
								@error('brand')
								    <span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<select class="form-control" name="category_id">
									<option value="">--Select--</option>
									@foreach ($categories as $category)
										<option {{ ($category->id == $products->category_id ? "selected":"") }} value="{{ $category->id }}">{{ App\Category::find($category->id)->category_name }}</option>
									@endforeach
								</select>
								@error('category_name')
								    <span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<input type="file" name="product_photo" class="form-control">
								@error('product_photo')
								    <span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<textarea name="long_description" placeholder="Product long description" class="form-control">{{ $products->long_description }}</textarea>
								@error('long_description')
								    <span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<textarea name="short_description" placeholder="Product short description" class="form-control">{{ $products->short_description }}</textarea>
								@error('short_description')
								    <span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<button type="submit" class="btn btn-info text-light">Update category</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('footer_app')
<!-- page script -->
@endsection