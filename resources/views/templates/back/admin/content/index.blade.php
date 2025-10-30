@extends('templates.back._parts.master')

@section('title', 'Content Management')
@section('page-title', 'Content Management')
@section('page-subtitle', 'Manage all your website content')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0">All Contents</h4>
            <small class="text-muted">{{ $contents->total() }} total contents</small>
        </div>
        <a href="{{ route('admin.content.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Content
        </a>
    </div>

    <!-- Filters -->
    <div class="admin-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.content.index') }}" class="row g-3">
                <div class="col-12 col-sm-6 col-lg-3">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Search content..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-12 col-sm-6 col-lg-2">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-lg-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published
                        </option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-lg-2">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        <option value="page" {{ request('type') === 'page' ? 'selected' : '' }}>Page</option>
                        <option value="article" {{ request('type') === 'article' ? 'selected' : '' }}>Article</option>
                        <option value="service" {{ request('type') === 'service' ? 'selected' : '' }}>Service</option>
                        <option value="portfolio" {{ request('type') === 'portfolio' ? 'selected' : '' }}>Portfolio
                        </option>
                        <option value="other" {{ request('type') === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="col-12 col-lg-3 d-flex flex-column flex-lg-row align-items-end gap-2">
                    <button type="submit" class="btn btn-outline-primary w-100 w-lg-auto">
                        <i class="fas fa-filter me-1"></i>Filter
                    </button>
                    <a href="{{ route('admin.content.index') }}" class="btn btn-outline-secondary w-100 w-lg-auto">
                        <i class="fas fa-times me-1"></i>Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Content Table -->
    <div class="admin-card">
        <div class="card-body p-0">
            @if ($contents->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th width="5%">
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                </th>
                                <th>Content</th>
                                <th width="15%">Category</th>
                                <th width="10%">Type</th>
                                <th width="10%">Status</th>
                                <th width="12%">Created</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contents as $content)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input content-checkbox"
                                            value="{{ $content->id }}">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($content->image)
                                                <img src="{{ asset('storage/' . $content->image) }}"
                                                    alt="{{ $content->title }}" class="rounded me-3" width="50"
                                                    height="50" style="object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                                    style="width: 50px; height: 50px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-1">
                                                    {{ $content->title }}
                                                    @if ($content->is_featured)
                                                        <span class="badge bg-warning ms-1">Featured</span>
                                                    @endif
                                                </h6>
                                                <small class="text-muted">{{ Str::limit($content->excerpt, 50) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($content->category)
                                            <span class="badge bg-secondary">{{ $content->category->name }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($content->type) }}</span>
                                    </td>
                                    <td>
                                        @if ($content->status === 'published')
                                            <span class="badge bg-success">Published</span>
                                        @elseif($content->status === 'draft')
                                            <span class="badge bg-warning">Draft</span>
                                        @else
                                            <span class="badge bg-secondary">Archived</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $content->created_at->format('M d, Y') }}<br>
                                            {{ $content->created_at->format('H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.content.show', $content) }}"
                                                class="btn btn-outline-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.content.edit', $content) }}"
                                                class="btn btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" title="Delete"
                                                onclick="deleteContent({{ $content->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="mobile-card-view" style="display: none;">
                    @foreach ($contents as $content)
                        <div class="mobile-item-card">
                            <div class="item-header">
                                <div class="flex-grow-1">
                                    <div class="item-title">{{ $content->title }}</div>
                                    <div class="item-meta">
                                        <span class="badge bg-info me-2">{{ ucfirst($content->type) }}</span>
                                        @if ($content->status === 'published')
                                            <span class="badge bg-success me-2">Published</span>
                                        @elseif($content->status === 'draft')
                                            <span class="badge bg-warning me-2">Draft</span>
                                        @else
                                            <span class="badge bg-secondary me-2">Archived</span>
                                        @endif
                                        @if ($content->category)
                                            <span class="badge bg-secondary me-2">{{ $content->category->name }}</span>
                                        @endif
                                        @if ($content->is_featured)
                                            <span class="badge bg-warning">Featured</span>
                                        @endif
                                    </div>
                                    @if ($content->excerpt)
                                        <div class="text-muted small mt-2">{{ Str::limit($content->excerpt, 80) }}</div>
                                    @endif
                                    <div class="text-muted small mt-1">
                                        Created: {{ $content->created_at->format('M d, Y H:i') }}
                                    </div>
                                </div>
                                <input type="checkbox" class="form-check-input content-checkbox"
                                    value="{{ $content->id }}">
                            </div>
                            <div class="item-actions mt-2">
                                <a href="{{ route('admin.content.show', $content) }}"
                                    class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('admin.content.edit', $content) }}"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                    onclick="confirmDelete({{ $content->id }}, '{{ $content->title }}')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center p-3 border-top">
                    <div class="text-muted small">
                        Showing {{ $contents->firstItem() }} to {{ $contents->lastItem() }}
                        of {{ $contents->total() }} results
                    </div>
                    {{ $contents->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-file-alt text-muted" style="font-size: 64px;"></i>
                    <h4 class="mt-3 text-muted">No contents found</h4>
                    @if (request()->hasAny(['search', 'category', 'status', 'type']))
                        <p class="text-muted">Try adjusting your filters or search terms</p>
                        <a href="{{ route('admin.content.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-times me-2"></i>Clear Filters
                        </a>
                    @else
                        <p class="text-muted">Start by creating your first content</p>
                        <a href="{{ route('admin.content.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Create Content
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Bulk Actions (if contents exist) -->
    @if ($contents->count() > 0)
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="bulk-actions" style="display: none;">
                <select class="form-select form-select-sm d-inline-block w-auto me-2" id="bulkAction">
                    <option value="">Bulk Actions</option>
                    <option value="publish">Publish Selected</option>
                    <option value="draft">Move to Draft</option>
                    <option value="archive">Archive Selected</option>
                    <option value="delete">Delete Selected</option>
                </select>
                <button class="btn btn-sm btn-outline-primary" onclick="executeBulkAction()">Apply</button>
            </div>
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
                    Are you sure you want to delete this content? This action cannot be undone.
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
        // Select All functionality
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.content-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            toggleBulkActions();
        });

        // Individual checkbox functionality
        document.querySelectorAll('.content-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', toggleBulkActions);
        });

        function toggleBulkActions() {
            const checkedBoxes = document.querySelectorAll('.content-checkbox:checked');
            const bulkActions = document.querySelector('.bulk-actions');

            if (checkedBoxes.length > 0) {
                bulkActions.style.display = 'block';
            } else {
                bulkActions.style.display = 'none';
            }
        }

        // Delete content
        function deleteContent(id) {
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            const form = document.getElementById('deleteForm');
            form.action = `{{ route('admin.content.index') }}/${id}`;
            modal.show();
        }

        // Bulk actions
        function executeBulkAction() {
            const action = document.getElementById('bulkAction').value;
            const checkedBoxes = document.querySelectorAll('.content-checkbox:checked');

            if (!action) {
                alert('Please select an action');
                return;
            }

            if (checkedBoxes.length === 0) {
                alert('Please select at least one content');
                return;
            }

            const ids = Array.from(checkedBoxes).map(cb => cb.value);

            if (action === 'delete') {
                if (!confirm('Are you sure you want to delete the selected contents?')) {
                    return;
                }
            }

            // Here you would implement the actual bulk action logic
            console.log('Bulk action:', action, 'for IDs:', ids);
            // You can add AJAX call or form submission here
        }
    </script>
@endpush
