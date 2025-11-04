@extends('back._parts.master')
@section('page-title', 'Users')
@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1" style="color: #2D3748; font-weight:600;">Users</h1>
            <p class="text-muted small mb-0">Manage application users — minimal fields are used here; users can complete
                their profile later.</p>
        </div>
        <a href="{{ url('users/create') }}" class="btn px-4 py-2 rounded-pill text-white"
            style="background: linear-gradient(135deg,#6D28D9,#2563EB); border: none;"><i
                class="fas fa-user-plus me-2"></i>New User</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body px-4 py-4">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if ($user->profile_image)
                                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt=""
                                            class="rounded-circle me-2" style="width:36px; height:36px; object-fit:cover;">
                                    @else
                                        <div class="rounded-circle bg-light me-2"
                                            style="width:36px; height:36px; display:flex; align-items:center; justify-content:center;">
                                            <i class="fas fa-user" style="color:#9CA3AF"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div style="font-weight:600">{{ $user->name }}</div>
                                        <div class="text-muted small">{{ $user->phone }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                            <td class="text-end">
                                <a href="{{ url('users/' . $user->id) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                <a href="{{ url('users/' . $user->id . '/edit') }}"
                                    class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ url('users/' . $user->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>

@endsection
