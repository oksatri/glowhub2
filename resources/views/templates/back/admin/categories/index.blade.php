@extends('templates.back._parts.master')

@section('title', 'Categories Management')
@section('page-title', 'Categories')
@section('page-subtitle', 'Manage content categories')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0">All Categories</h4>
            <small class="text-muted">{{ $categories->total() }} total categories</small>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Category
        </a>
    </div>

    <!-- Filters -->
    <div class="admin-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.categories.index') }}" class="row g-3">
                <div class="col-12 col-sm-6 col-lg-4">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Search categories..."
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
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary w-100 w-lg-auto">
                        <i class="fas fa-times me-1"></i>Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Categories Cards -->
    <div class="row g-4">
        @forelse($categories as $category)
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="admin-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center">
                                @if ($category->icon)
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 50px; height: 50px; background-color: {{ $category->color ?? '#6c757d' }};">
                                        <i class="{{ $category->icon }} text-white"></i>
                                    </div>
                                @else
                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3"
                                        style="width: 50px; height: 50px;">
                                        <i class="fas fa-folder text-white"></i>
                                    </div>
                                @endif
                                <div>
                                    <h5 class="mb-1">{{ $category->name }}</h5>
                                    <small class="text-muted">{{ $category->contents_count }} contents</small>
                                </div>
                            </div>

                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a href="{{ route('admin.categories.show', $category) }}" class="dropdown-item">
                                        <i class="fas fa-eye me-2"></i>View
                                    </a>
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="dropdown-item">
                                        <i class="fas fa-edit me-2"></i>Edit
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item text-danger"
                                        onclick="deleteCategory({{ $category->id }})">
                                        <i class="fas fa-trash me-2"></i>Delete
                                    </button>
                                </div>
                            </div>
                        </div>

                        @if ($category->description)
                            <p class="text-muted mb-3">{{ Str::limit($category->description, 100) }}</p>
                        @endif

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                <small class="text-muted ms-2">Order: {{ $category->sort_order }}</small>
                            </div>

                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-outline-info"
                                    title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline-primary"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-folder text-muted" style="font-size: 64px;"></i>
                    <h4 class="mt-3 text-muted">No categories found</h4>
                    @if (request()->hasAny(['search', 'status']))
                        <p class="text-muted">Try adjusting your filters</p>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-times me-2"></i>Clear Filters
                        </a>
                    @else
                        <p class="text-muted">Start by creating your first category</p>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Create Category
                        </a>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($categories->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $categories->links() }}
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
                    <p>Are you sure you want to delete this category?</p>
                    <div class="alert alert-warning">
                        <strong>Warning:</strong> If this category has contents, you won't be able to delete it until you
                        move or delete those contents first.
                    </div>
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
        function deleteCategory(id) {
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            const form = document.getElementById('deleteForm');
            form.action = `{{ route('admin.categories.index') }}/${id}`;
            modal.show();
        }
    </script>
@endpush
