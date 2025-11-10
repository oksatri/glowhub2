@extends('back._parts.master')
@section('page-title', 'MUAs')
@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1" style="color: #2D3748; font-weight:600;">MUAs</h1>
            <p class="text-muted small mb-0">Manage Makeup Artists — add services and portfolio images.</p>
        </div>
        <a href="{{ url('muas/create') }}" class="btn px-4 py-2 rounded-pill text-white"
            style="background: linear-gradient(135deg,#6D28D9,#2563EB); border: none;"><i class="fas fa-plus me-2"></i> Create
            New
            MUA</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body px-4 py-4">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Search & Filter Card -->
            <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(to right, #F9FAFB, #F3F4F6);">
                <div class="card-body px-4 py-4">
                    <form method="GET" action="{{ url('muas') }}" class="mb-0">
                        <div class="row g-3 align-items-center">
                            <div class="col-lg-5 col-md-6">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-white border-0 ps-4">
                                        <i class="fas fa-search" style="color: #9CA3AF;"></i>
                                    </span>
                                    <input type="text" name="q" class="form-control border-0 ps-2 shadow-none"
                                        style="background: white; font-size: 0.95rem;"
                                        placeholder="Search by MUA name or specialty..." value="{{ request('q') }}">
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-6">
                                <select name="specialty" class="form-select shadow-none border-0"
                                    style="background: white; height: 48px; font-size: 0.95rem;">
                                    <option value="">All Specialties</option>
                                    {{-- Optional fixed specialty list; adapt as needed --}}
                                    <option value="bridal" {{ request('specialty') == 'bridal' ? 'selected' : '' }}>Bridal
                                    </option>
                                    <option value="editorial" {{ request('specialty') == 'editorial' ? 'selected' : '' }}>
                                        Editorial</option>
                                    <option value="natural" {{ request('specialty') == 'natural' ? 'selected' : '' }}>
                                        Natural
                                    </option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-6 d-flex gap-2">
                                <button type="submit" class="btn flex-fill py-2 text-white"
                                    style="background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%); border: none; font-size: 0.95rem;">
                                    <i class="fas fa-filter me-2 opacity-75"></i>Apply Filter
                                </button>
                                @if (request()->hasAny(['q', 'specialty']))
                                    <a href="{{ url('muas') }}" class="btn py-2 px-3"
                                        style="background: white; border: 1px solid #E5E7EB; color: #4B5563;">
                                        <i class="fas fa-times opacity-50"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Specialty</th>
                            <th>Location</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($muas as $mua)
                            <tr>
                                <td>{{ $mua->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if ($mua->image)
                                            <img src="{{ asset('storage/' . $mua->image) }}" alt=""
                                                class="rounded-circle me-2"
                                                style="width:48px; height:48px; object-fit:cover;">
                                        @else
                                            <div class="rounded-circle bg-light me-2"
                                                style="width:48px; height:48px; display:flex; align-items:center; justify-content:center;">
                                                <i class="fas fa-user" style="color:#9CA3AF"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div style="font-weight:600">{{ $mua->name }}</div>
                                            @if ($mua->user)
                                                <div class="text-muted small">By: {{ $mua->user->name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $mua->specialty }}</td>
                                <td>
                                    @if ($mua->district)
                                        {{ App\Models\RegDistrict::find($mua->district)->name ?? $mua->district }},
                                    @endif
                                    @if ($mua->city)
                                        {{ App\Models\RegRegency::find($mua->city)->name ?? $mua->city }},
                                    @endif
                                    @if ($mua->province)
                                        {{ App\Models\RegProvince::find($mua->province)->name ?? $mua->province }}
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ url('muas/' . $mua->id . '/edit') }}"
                                        class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form action="{{ url('muas/' . $mua->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Delete this MUA?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-16">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="empty-state mb-4 p-3 rounded-circle" style="background: #F3F4F6;">
                                            <i class="fas fa-file-alt fa-4x" style="color: #9CA3AF;"></i>
                                        </div>
                                        <h5 class="fw-normal mb-2" style="color: #374151; font-size: 1.25rem;">No MUA Found
                                        </h5>
                                        <p style="color: #6B7280; font-size: 1rem;" class="mb-4">Start by adding your
                                            first
                                            MUA</p>
                                        <a href="{{ url('muas/create') }}" class="btn px-4 py-2 rounded-pill text-white"
                                            style="background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%); border: none;">
                                            <i class="fas fa-plus me-2"></i> Create New MUA
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-between align-items-center">
                <div style="color: #4B5563; font-size: 0.95rem;">
                    Showing <span class="fw-medium">{{ $muas->firstItem() ?? 0 }}</span> to
                    <span class="fw-medium">{{ $muas->lastItem() ?? 0 }}</span> of
                    <span class="fw-medium">{{ $muas->total() ?? 0 }}</span> entries
                </div>
                <div class="pagination-wrapper" style="margin: -0.25rem;">
                    {{ $muas->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
