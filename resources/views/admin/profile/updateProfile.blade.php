@extends('layouts.dashboard_app')

@section('menu_open')
	menu-open
@endsection
@section('title')
	Profile | Dashboard
@endsection
@section('profile')
	active
@endsection


@section('dashboard_content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 ml-4">
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
		<div class="row ml-5">
			<div class="col-6">
				<div class="card">
					<div class="card-header">
						<h5>Change image</h5>
					</div>
					<div class="card-body">
						@if ($errors->all())
							<div class="alert alert-danger">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</div>
						@endif
						@if (session('image_upload_status'))
							<div class="alert alert-success">
								{{ session('image_upload_status') }}
							</div>
						@endif
						<div class="form-group">
							<form action="{{ url('change/image/post') }}" method="post" enctype="multipart/form-data">
								@csrf
								
								<div class="form-group">
									<input type="file" name="image" placeholder="Names" class="form-control" accept="image/*">
								</div>
								<button type="submit" class="btn btn-info text-light">Change profile</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="col-6">
				<div class="card">
					<div class="card-header">
						<h5>Update profile</h5>
					</div>
					<div class="card-body">
						@if (session('profile_update_status'))
							<div class="alert alert-success">
								{{ session('profile_update_status') }}
							</div>
						@endif
						@if (session('profile_update_error'))
							<div class="alert alert-danger">
								{{ session('profile_update_error') }}
							</div>
						@endif
						<div class="form-group">
							<form action="{{ url('edit/profile/post') }}" method="post">
								@csrf
								
								<div class="form-group">
									<input type="text" name="name" placeholder="Names" class="form-control" value="{{ Auth::user()->name }}">
									@error('name')
									    <span class="text-danger">{{ $message }}</span>
									@enderror
								</div>
								<button type="submit" class="btn btn-info text-light">Edit profile</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-5 ml-5">
			<div class="col-6">
				<div class="card">
					<div class="card-header">
						<h3>Change password</h3>
					</div>
					<div class="card-body">
						{{-- @if (session('profile_update_status')) --}}
							{{-- <div class="alert alert-success">
								{{ session('profile_update_status') }}
							</div>
						@endif --}}
						@if (session('change_password_error'))
							<div class="alert alert-danger">
								{{ session('change_password_error') }}
							</div>
						@endif
						@if (session('change_password_status'))
							<div class="alert alert-success">
								{{ session('change_password_status') }}
							</div>
						@endif
						@error ('password')
							<div class="alert alert-danger">
								{{ $message }}
							</div>
						@enderror
						<div class="form-group">
							<form action="{{ url('change/password/post') }}" method="post">
								@csrf
								
								<div class="form-group">
									<input type="text" name="old_password" placeholder="Old password" class="form-control" value="">

									<input type="text" name="password" placeholder="Password" class="form-control mt-3" value="">

									<input type="text" name="password_confirmation" placeholder="Password confirmation" class="form-control mt-3" value="">
									@error('name')
									    <span class="text-danger">{{ $message }}</span>
									@enderror
								</div>
								<button type="submit" class="btn btn-info text-light">Change Password</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</div>
@endsection