@extends('back._parts.master')
@section('page-title', 'User Details')
@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1" style="color: #2D3748; font-weight:600;">User Details</h1>
            <p class="text-muted small mb-0">Full user information.</p>
        </div>
        <div>
            <a href="{{ url('users/' . $user->id . '/edit') }}" class="btn btn-outline-primary">Edit</a>
            <a href="{{ url('users') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body px-4 py-4">
            <div class="row">
                <div class="col-md-3">
                    @if ($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" class="img-fluid rounded mb-3">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3"
                            style="height:160px;"> <i class="fas fa-user fa-3x text-muted"></i></div>
                    @endif
                    <h5 style="font-weight:700">{{ $user->name }}</h5>
                    <div class="text-muted">{{ $user->role }}</div>
                </div>
                <div class="col-md-9">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width:160px">Username</th>
                            <td>{{ $user->username }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $user->phone }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $user->address }}</td>
                        </tr>
                        <tr>
                            <th>Biodata</th>
                            <td>{{ $user->biodata }}</td>
                        </tr>
                        <tr>
                            <th>Registered</th>
                            <td>{{ $user->created_at->toDayDateTimeString() }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
