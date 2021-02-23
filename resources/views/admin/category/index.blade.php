@extends('layouts.dashboard_app')

@section('category')
	active
@endsection
@section('title')
	Category | Dashboard
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
	<div class="row mt-4">
		<div class="col-8">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">Category List(Active)</div>
						<div class="card-body">
							@if (session('update_status'))
								<div class="alert alert-success">
									{{ session('update_status') }}
								</div>
							@endif
							@if (session('delete_status'))
								<div class="alert alert-danger">
									{{ session('delete_status') }}
								</div>
							@endif
							@if (session('deleted_status'))
								<div class="alert alert-danger">
									{{ session('deleted_status') }}
								</div>
							@endif
							<form action="{{ url('mark/delete') }}" method="post">
								@csrf
								<table id="category_table" class="table table-striped table-borderd">
								  <thead>
								    <tr>
								      <th>Mark</th>
								      <th scope="col">SL.</th>
								      <th scope="col">Name</th>
								      <th scope="col">Image</th>
								      <th scope="col">User</th>
								      <th scope="col">Action</th>
								    </tr>
								  </thead>
								  <tbody>
								  	@forelse ($categories as $category)		
									    <tr>
									      <td>
									      	<input type="checkbox" name="category_id[]" value="{{ $category->id }}">
									      </td>
									      <td>{{ $loop->index + 1 }}</td>
									      <td>{{ $category->category_name }}</td>
									      <td>
									      	<img src="{{ asset('dashboard_asset/photo/category_photo') }}/{{ $category->cat_photo }}" alt="Not found" width="50">
									      </td>
									      <td>{{ App\User::find($category->user_id)->name }}</td>
									      <td>
									      	<div class="btn-group" role="group" aria-label="Basic example">
											  <a href="{{ url('/edit/category') }}/{{$category->id}}" type="button" class="btn btn-info btn-xs">Edit</a>
											  <a href="{{ url('/delete') }}/{{$category->id}}" type="button" class="btn btn-danger btn-xs">Delete</a>
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
								@if ($categories->count() > 0)
									<button type="submit" class="btn btn-danger">Delete all</button>
								@endif
							</form>
						</div>
					</div>
				</div>
				<div class="col-12 mt-5">
					<div class="card">
						<div class="card-header bg-danger">Category List(Recycle bin)</div>
						<div class="card-body">
							@if (session('restore_status'))
								<div class="alert alert-success">
									{{ session('restore_status') }}
								</div>
							@endif
							@if (session('forcedelete_status'))
								<div class="alert alert-danger">
									{{ session('forcedelete_status') }}
								</div>
							@endif
							<table id="deleted-table" class="table table-striped ">
							  <thead>
							    <tr>
							      <th scope="col">SL.</th>
							      <th scope="col">Name</th>
							      <th scope="col">Category Description</th>
							      <th scope="col">User</th>
							      <th scope="col">Created at</th>
							      <th scope="col">Action</th>
							    </tr>
							  </thead>
							  <tbody>
							  	@forelse ($deleted_categories as $deleted_category)		
								    <tr>
								      <td>{{ $loop->index + 1 }}</td>
								      <td>{{ $deleted_category->category_name }}</td>
								      <td>{{ $deleted_category->category_description }}</td>
								      <td>{{ App\User::find($deleted_category->user_id)->name }}</td>
								      <td>{{ $deleted_category->created_at }}</td>
								      <td>
								      	<div class="btn-group" role="group" aria-label="Basic example">
										  <a href="{{ url('/restore/category') }}/{{$deleted_category->id}}" type="button" class="btn btn-info">Restore</a>
										  <a href="{{ url('forcedelete') }}/{{$deleted_category->id}}" type="button" class="btn btn-danger">F.D</a>
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
					<h3>Add category</h3>
				</div>
				<div class="card-body">
				@if (session('image_upload_status'))
					<div class="alert alert-success">
						{{ session('image_upload_status') }}
					</div>
				@endif
					<div class="form-group">
						<form action="{{ url('add/category/post') }}" method="post" enctype="multipart/form-data">
							@csrf
							
							<div class="form-group">
								<input type="text" name="category_name" placeholder="Category name" class="form-control" value="{{ old('category_name') }}">
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
								<textarea name="category_description" placeholder="Category description" class="form-control">{{ old('category_description') }}</textarea>
								@error('category_description')
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
    $('#deleted-table').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
    });
  });
</script>
@endsection