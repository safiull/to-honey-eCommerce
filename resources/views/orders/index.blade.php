@extends('layouts.dashboard_app')

@section('orders')
	active
@endsection
@section('title')
	Order | Dashboard
@endsection
@section('dashboard_content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Orders</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
          <li class="breadcrumb-item active">Orders</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<div class="container">
	<div class="row mt-4">
		<div class="col-12">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>SERIAL NO.</th>
						<th>DATE</th>
						<th>PAYMENT METHOD</th>
						<th>SUB TOTAL</th>
						<th>DISCOUNT AMOUNT</th>
						<th>COUPON NAME</th>
						<th>TOTAL</th>
						<th>Payment status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($orders as $order)			
						<tr>
							<td>{{ $loop->index + 1 }}</td>
							<td>{{ $order->created_at }}</td>
							<td>
								@if($order->payment_option == 1)
									<span class="badge badge-warning">Cash on delivery</span>
								@else
									<span class="badge badge-success">Card</span>
								@endif
							</td>
							<td>{{ $order->sub_total }}</td>
							<td>{{ $order->discount_amount }}</td>
							<td>{{ $order->coupon_name }}</td>
							<td>{{ $order->total }}</td>
							<td>
								@if($order->payment_status == 1)
									<span class="badge badge-danger">Due</span>
								@else
									<span class="badge badge-success">Paid</span>
								@endif
							</td>
							<td>
								<a href="{{ url('order/invoice/download') }}/{{ $order->id }}">
									<i class="fa fa-download"> Download invoice</i>
							</td>
						</tr>
						<tr>
							<td colspan="50">
								{{-- <p>{{ $order->order_details }}</p> --}}
								@foreach ($order->order_details as $order_detail)
									<p>{{ $order_detail->product->product_name }}</p>
								@endforeach
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

@endsection