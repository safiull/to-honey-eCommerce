@extends('layouts.dashboard_app')

@section('coupon')
	active
@endsection
@section('title')
	Coupon | Dashboard
@endsection
@section('dashboard_content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Coupon</h1>
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
						<div class="card-header">Coupon List(Active)</div>
						<div class="card-body">
							{{-- @if (session('update_status'))
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
							@endif --}}
							<table id="category_table" class="table table-striped table-borderd">
							  <thead>
							    <tr>
							      <th>SL.</th>
							      <th>Coupon Name</th>
							      <th>Image</th>
							      <th>User</th>
							      <th>Action</th>
							    </tr>
							  </thead>
							  <tbody>
							  	@forelse ($coupons as $coupon)		
								    <tr>
								      <td>{{ $loop->index + 1 }}</td>
								      <td>{{ $coupon->coupon_name }}</td>
								      <td>{{ $coupon->discount_amount }}</td>
								      <td>{{ $coupon->minimum_purchase_amount }}</td>
								      <td>{{ $coupon->validity_till }}</td>
								      
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
					<h3>Add Coupon</h3>
				</div>
				<div class="card-body">
				@if (session('added_status'))
					<div class="alert alert-success">
						{{ session('added_status') }}
					</div>
				@endif
					<div class="form-group">
						<form action="{{ route('coupon.store') }}" method="post">
							@csrf
							<div class="form-group">
								<input type="text" name="coupon_name" placeholder="Coupon name" class="form-control" value="{{ old('coupon_name') }}">
								@error('coupon_name')
								    <span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<input type="number" name="discount_amount" placeholder="Discount amount" class="form-control" value="{{ old('discount_amount') }}">
								@error('discount_amount')
								    <span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<input type="number" name="minimum_purchase_amount" placeholder="Minimum purchase amount" class="form-control" value="{{ old('minimum_purchase_amount') }}">
								@error('minimum_purchase_amount')
								    <span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<input type="date" name="validity_till" placeholder="Validity till" class="form-control" value="{{ old('validity_till') }}">
								@error('validity_till')
								    <span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<button type="submit" class="btn btn-info text-light">Add coupon</button>
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