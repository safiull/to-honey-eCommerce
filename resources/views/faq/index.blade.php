@extends('layouts.dashboard_app')

@section('faq')
	active
@endsection
@section('title')
	Faq | Dashboard
@endsection
@section('dashboard_content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Faq</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
          <li class="breadcrumb-item active">Faq</li>
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
						<div class="card-header">Faq(Active)</div>
						<div class="card-body">
							@if (session('delete_status'))
								<div class="alert alert-success">
									{{ session('delete_status') }}
								</div>
							@endif
							<form action="{{ url('add-faq') }}" method="post">
								@csrf
								<table id="faq_table" class="table table-striped table-borderd">
								  <thead>
								    <tr>
								      <th>SL.</th>
								      <th>Question</th>
								      <th>Answer</th>
								      <th>Action</th>
								    </tr>
								  </thead>
								  <tbody>
								  	@forelse ($faqs as $faq)		
									    <tr>
									      <td>{{ $loop->index + 1 }}</td>
									      <td>{{ $faq->question }}</td>
									      <td>{{ $faq->answer }}</td>
									      <td>
									      	<div class="btn-group" role="group" aria-label="Basic example">
											  <a href="{{ url('/faq/delete') }}/{{$faq->id}}" type="button" class="btn btn-danger btn-xs">Delete</a>
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
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-4">
			<div class="card">
				<div class="card-header">
					<h3>Add FAQ</h3>
				</div>
				<div class="card-body">
				@if (session('insert-faq'))
					<div class="alert alert-success">
						{{ session('insert-faq') }}
					</div>
				@endif
					<div class="form-group">
						<form action="{{ url('add-faq') }}" method="post">
							@csrf
							
							<div class="form-group">
								<input type="text" name="question" placeholder="Question" class="form-control" value="{{ old('question') }}">
								@error('question')
								    <span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<textarea name="answer" placeholder="Answer" class="form-control">{{ old('answer') }}</textarea>
								@error('answer')
								    <span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<button type="submit" class="btn btn-info text-light">Add FAQ</button>
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
    $("#faq_table").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
</script>
@endsection