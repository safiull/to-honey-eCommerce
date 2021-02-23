@extends('layouts.dashboard_app')
@section('category')
	active
@endsection
@section('title')
	Edit Category | Dashboard
@endsection
@section('dashboard_content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Update Profile</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
          <li class="breadcrumb-item active">Home</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
	<div class="container">
		<div class="row">
			<div class="col-6">
				<div class="card">
					<div class="card-header bg-primary">
						<h3>Edit category</h3>
					</div>
					<div class="card-body">
						<nav aria-label="breadcrumb">
						  <ol class="breadcrumb">
						    <li class="breadcrumb-item"><a href="{{ url('/add/category') }}">Add Category</a></li>
						    <li class="breadcrumb-item active" aria-current="page">Edit category</li>
						  </ol>
						</nav>
						<div class="form-group">
							<form action="{{ url('edit/category/post') }}" method="post" enctype="multipart/form-data">
								@csrf
								
								<div class="form-group">
									<input type="hidden" name="category_id" value="{{ $category_info->id }}">
									<input type="text" name="category_name" placeholder="Category name" class="form-control" value="{{ $category_info->category_name }}">
									@error('category_name')
									    <span class="text-danger">{{ $message }}</span>
									@enderror
								</div>
								<div class="form-group">
									<input type="file" name="category_photo" class="form-control">
									@error('category_photo')
									    <span class="text-danger">{{ $message }}</span>
									@enderror
								</div>
								<div class="form-group">
									<textarea placeholder="Category description" name="category_description" class="form-control">{{ $category_info->category_description }}</textarea>
									@error('category_description')
									    <span class="text-danger">{{ $message }}</span>
									@enderror
								</div>
								
								<button type="submit" class="btn btn-primary text-light">Edit category</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</div>
@endsection