@extends('layouts.dashboard_app')

@section('home')
  active
@endsection
@section('dashboard_content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Home</h1>
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

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <!-- =========================================================== -->
        <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <a class="btn btn-success" href="{{ url('send/mail') }}">Send mail to subsicribers</a>
                @if (session('subscribers_mail_status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('subscribers_mail_status') }}
                    </div>
                @endif
              </div>
            </div>
              <div class="card">
                  <div class="card-header">{{ __('Dashboard') }}
                    <h1>Total users: ({{ $total_users }})</h1></div>

                  <div class="card-body">
                      @if (session('status'))
                          <div class="alert alert-success" role="alert">
                              {{ session('status') }}
                          </div>
                      @endif

                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Sl. No.</th>
                            <th scope="col">Id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Created At</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($users as $user)
                              <tr>
                                {{-- <th>{{ $loop->index + 1 }}</th> --}}
                                <th>{{ $users->firstItem() + $loop->index }}</th>
                                <th>{{ $user->id }}</th>
                                <th>{{ Str::title($user->name) }}</th>
                                <th>{{ $user->email }}</th>
                                <th>
                                  <li>{{ $user->created_at->format("d-m-Y") }}</li>
                                  <li>{{ $user->created_at->timezone("Asia/Dhaka")->format("h:i:s A") }}</li>
                                  <li>{{ $user->created_at->diffForHumans() }}</li>
                                </th>
                              </tr>
                          @endforeach
                        </tbody>
                      </table>
                      {{ $users->links() }}
                  </div>
              </div>
          </div>
        </div>
        <!-- =========================================================== -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection