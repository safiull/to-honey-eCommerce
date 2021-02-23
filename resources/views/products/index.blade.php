@extends('layouts.dashboard_app')

@section('product')
	active
@endsection
@section('title')
	Product | Dashboard
@endsection
@section('dashboard_content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Product</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Product</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<div class="container">
	<div class="row mt-4">
		<div class="col-8">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">Products List</div>
						<div class="card-body">
							@if (session('delete_status'))
								<div class="alert alert-danger">
									{{ session('delete_status') }}
								</div>
							@endif
							@if (session('updated_status'))
								<div class="alert alert-success">
									{{ session('updated_status') }}
								</div>
							@endif
							<table id="category_table" class="table table-striped table-borderd">
							  <thead>
							    <tr>
							      <th>SL.</th>
							      <th>Name</th>
							      <th>Category name</th>
							      <th>Image</th>
							      <th>Price</th>
							      <th>Quantity</th>
							      <th>Action</th>
							    </tr>
							  </thead>
							  <tbody>
							  	@forelse ($products as $product)		
								    <tr>
								      <td>{{ $loop->index + 1 }}</td>
								      <td>{{ $product->product_name }}</td>
								      <td>{{ $product->withCategoryTable->category_name }}</td>
								      <td>
								      	<img src="{{ asset('dashboard_asset/photo/product_photo') }}/{{ $product->product_photo }}" alt="Not found" width="50">
								      </td>
								      <td>{{ $product->price }}</td>
								      <td>{{ $product->alert_stock }}</td>
								      <td>
								      	<div class="btn-group" role="group" aria-label="Basic example">
									  		<a href="{{ route('product.edit', $product->id) }}" type="button" class="btn btn-info btn-xs">Edit</a>
									  	<form action="{{ route('product.destroy', $product->id) }}" method="POST">
											@csrf
											@method('DELETE')
									  		<button type="submit" class="btn btn-danger btn-xs">Delete</button>
									  	</form>
										</div>
								      </td>
								    </tr>
								@empty
									<tr>
										<td colspan="50" class="text-danger text-center">No data available.</td>
									</tr>
							  	@endforelse
							  </tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-4">
			<div class="card">
				<div class="card-header">
					<h3>Add product</h3>
				</div>
				<div class="card-body">
				@if (session('image_upload_status'))
					<div class="alert alert-success">
						{{ session('image_upload_status') }}
					</div>
				@endif
				@if (session('created_status'))
					<div class="alert alert-success">
						{{ session('created_status') }}
					</div>
				@endif
					<div class="form-group">
						<form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
							@csrf
							
							<div class="form-group">
								<input type="text" name="product_name" placeholder="Product name" class="form-control" value="{{ old('product_name') }}">
								@error('product_name')
								    <span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<input type="text" name="supplier_name" placeholder="Supplier name" class="form-control" value="{{ old('supplier_name') }}">
								@error('supplier_name')
								    <span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<input type="number" name="alert_stock" placeholder="Alert stock quantity" class="form-control" value="{{ old('alert_stock') }}">
								@error('alert_stock')
								    <span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<input type="number" name="price" placeholder="Price" class="form-control" value="{{ old('price') }}">
								@error('alert_stock')
								    <span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<input type="text" name="brand" placeholder="Brand" class="form-control" value="{{ old('brand') }}">
								@error('brand')
								    <span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<select class="form-control" name="category_id">
									<option value="">--Select--</option>
									@foreach ($categories as $category)
										<option value="{{ $category->id }}">{{ App\Category::find($category->id)->category_name }}</option>
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
								<label>Product multiple photos</label>
								<input type="file" name="product_multiple_photos[]" class="form-control" multiple>
								@error('product_multiple_photos')
								    <span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<textarea id="long_description" name="long_description" placeholder="Product long description" class="form-control">{{ old('long_description') }}</textarea>
								@error('long_description')
								    <span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<textarea name="short_description" placeholder="Product short description" class="form-control">{{ old('short_description') }}</textarea>
								@error('short_description')
								    <span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<button type="submit" class="btn btn-info text-light">Add category</button>
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
<script>
  $(function () {
    $("#category_table").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    ClassicEditor
        .create( document.querySelector( '#long_description' ) )
        .catch( error => {
            console.error( error );
        } );
  });
</script>
@endsection