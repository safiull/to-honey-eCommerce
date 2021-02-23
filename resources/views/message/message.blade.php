@extends('layouts.dashboard_app')

@section('message')
  active
@endsection
@section('dashboard_content')
@section('title')
	Category | Dashboard
@endsection
@section('dashboard_content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Inbox</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
          <li class="breadcrumb-item active">Inbox</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<div class="container">
	<div class="row">
		<div class="col-12">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">Message (Active)</div>
						<div class="card-body">
							<table id="message" class="table table-striped table-borderd">
							  <thead>
							    <tr>
							      <th>SL.</th>
							      <th>Name</th>
							      <th>Email</th>
							      <th>Subject</th>
							      <th>Message</th>
							      <th>Download/View</th>
							    </tr>
							  </thead>
							  <tbody>
							  	@forelse ($messages as $message)		
								    <tr>
								      <td>{{ $loop->index + 1 }}</td>
								      <td>{{ $message->name }}</td>
								      <td>{{ $message->email }}</td>
								      <td>{{ $message->subject }}</td>
								      <td>{{ $message->message }}</td>
								      <td>
								      	@if ($message->attachment_file)
								      		<a href="{{ url('contact/attachment/download') }}/{{ $message->id }}">
								      		<i class="fa fa-download"></i>
								      		||
								      		<a target="_blank" href="{{ asset('storage') }}/{{ $message->attachment_file }}">
								      			<i class="fas fa-file-video"></i>
								      		</a>
								      	</a>
								      	@endif
								      </td>
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
	</div>
</div>
@endsection

@section('footer_app')
<!-- page script -->
<script>
  $(function () {
    $("#message").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
</script>

@endsection