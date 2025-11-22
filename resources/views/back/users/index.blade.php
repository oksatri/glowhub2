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
            style="background: linear-gradient(135deg,#6D28D9,#2563EB); border: none;"><i class="fas fa-user-plus me-2"></i>
            Create New User</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body px-4 py-4">
            <!-- Search & Filter Card -->
            <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(to right, #F9FAFB, #F3F4F6);">
                <div class="card-body px-4 py-4">
                    <form method="GET" action="{{ url('users') }}" class="mb-0">
                        <div class="row g-3 align-items-center">
                            <div class="col-lg-5 col-md-6">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-white border-0 ps-4">
                                        <i class="fas fa-search" style="color: #9CA3AF;"></i>
                                    </span>
                                    <input type="text" name="name" class="form-control border-0 ps-2 shadow-none"
                                        style="background: white; font-size: 0.95rem;"
                                        placeholder="Search by name, username, or email..." value="{{ request('name') }}">
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-6">
                                <select name="role" class="form-select shadow-none border-0"
                                    style="background: white; height: 48px; font-size: 0.95rem;">
                                    <option value="">All Roles</option>
                                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="mua" {{ request('role') == 'mua' ? 'selected' : '' }}>MUA</option>
                                    <option value="member" {{ request('role') == 'member' ? 'selected' : '' }}>Member
                                    </option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-6 d-flex gap-2">
                                <button type="submit" class="btn flex-fill py-2 text-white"
                                    style="background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%); border: none; font-size: 0.95rem;">
                                    <i class="fas fa-filter me-2 opacity-75"></i>Apply Filter
                                </button>
                                @if (request()->hasAny(['name', 'role']))
                                    <a href="{{ url('users') }}" class="btn py-2 px-3"
                                        style="background: white; border: 1px solid #E5E7EB; color: #4B5563;">
                                        <i class="fas fa-times opacity-50"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

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
                                        <img src="{{ asset('uploads/' . $user->profile_image) }}" alt=""
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
                                @if($user->role !== 'admin')
                                <a href="{{ url('users/' . $user->id . '/edit') }}"
                                    class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ url('users/' . $user->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-16">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="empty-state mb-4 p-3 rounded-circle" style="background: #F3F4F6;">
                                        <i class="fas fa-file-alt fa-4x" style="color: #9CA3AF;"></i>
                                    </div>
                                    <h5 class="fw-normal mb-2" style="color: #374151; font-size: 1.25rem;">No User Found
                                    </h5>
                                    <p style="color: #6B7280; font-size: 1rem;" class="mb-4">Start by adding your first
                                        User</p>
                                    <a href="{{ url('users/create') }}" class="btn px-4 py-2 rounded-pill text-white"
                                        style="background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%); border: none;">
                                        <i class="fas fa-plus me-2"></i> Create New User
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4 d-flex justify-content-between align-items-center">
                <div style="color: #4B5563; font-size: 0.95rem;">
                    Showing <span class="fw-medium">{{ $users->firstItem() ?? 0 }}</span> to
                    <span class="fw-medium">{{ $users->lastItem() ?? 0 }}</span> of
                    <span class="fw-medium">{{ $users->total() ?? 0 }}</span> entries
                </div>
                <div class="pagination-wrapper" style="margin: -0.25rem;">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
