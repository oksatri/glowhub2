@extends('templates.back._parts.master')

@section('title', 'Services')
@section('page-title', 'Services')
@section('page-subtitle', 'Manage your services')

@section('content')
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Services</h1>
            <p class="text-muted mb-0">Manage your service offerings</p>
        </div>
        <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Service
        </a>
    </div>

    <!-- Filters -->
    <div class="admin-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.services.index') }}" class="row g-3">
                <div class="col-12 col-sm-6 col-lg-4">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Search services..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-12 col-lg-5 d-flex flex-column flex-lg-row align-items-end gap-2">
                    <button type="submit" class="btn btn-outline-primary w-100 w-lg-auto">
                        <i class="fas fa-filter me-1"></i>Filter
                    </button>
                    <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary w-100 w-lg-auto">
                        <i class="fas fa-times me-1"></i>Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Services Cards -->
    <div class="row g-4">
        @forelse($services as $service)
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="admin-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center">
                                @if ($service->icon)
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);">
                                        <i class="{{ $service->icon }} text-white fs-4"></i>
                                    </div>
                                @elseif($service->image)
                                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}"
                                        class="rounded-circle me-3" width="50" height="50"
                                        style="object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3"
                                        style="width: 50px; height: 50px;">
                                        <i class="fas fa-cog text-white"></i>
                                    </div>
                                @endif
                                <div>
                                    <h5 class="mb-1">{{ $service->title }}</h5>
                                    <small class="text-muted">Order: {{ $service->sort_order ?? 0 }}</small>
                                </div>
                            </div>
                            <span class="badge bg-{{ $service->status === 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($service->status) }}
                            </span>
                        </div>

                        <p class="text-muted mb-3">{{ Str::limit($service->description, 100) }}</p>

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.services.show', $service) }}"
                                class="btn btn-outline-info btn-sm flex-fill">
                                <i class="fas fa-eye me-1"></i>View
                            </a>
                            <a href="{{ route('admin.services.edit', $service) }}"
                                class="btn btn-outline-primary btn-sm flex-fill">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                            <button type="button" class="btn btn-outline-danger btn-sm flex-fill"
                                onclick="confirmDelete({{ $service->id }}, '{{ $service->title }}')">
                                <i class="fas fa-trash me-1"></i>Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-cog fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No services found</h5>
                    <p class="text-muted">
                        @if (request()->hasAny(['search', 'status']))
                            No services match your search criteria.
                        @else
                            Start by creating your first service.
                        @endif
                    </p>
                    @if (!request()->hasAny(['search', 'status']))
                        <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Create First Service
                        </a>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($services->hasPages())
        <div class="mt-4">
            {{ $services->links() }}
        </div>
    @endif

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete "<span id="serviceName"></span>"?</p>
                    <p class="text-muted small">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function confirmDelete(id, name) {
            document.getElementById('serviceName').textContent = name;
            document.getElementById('deleteForm').action = `/admin/services/${id}`;
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }
    </script>
@endpush
