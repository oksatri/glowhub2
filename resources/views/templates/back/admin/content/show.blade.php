@extends('templates.back._parts.master')

@section('title', 'View Content')
@section('page-title', $content->title)
@section('page-subtitle', 'Content details and preview')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <!-- Content Preview -->
            <div class="admin-card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-eye me-2"></i>
                        Content Preview
                    </h5>
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('admin.content.edit', $content) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <button type="button" class="btn btn-outline-danger" onclick="deleteContent()">
                            <i class="fas fa-trash me-1"></i>Delete
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if ($content->image)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $content->image) }}" alt="{{ $content->title }}"
                                class="img-fluid rounded">
                        </div>
                    @endif

                    <h1 class="mb-3">{{ $content->title }}</h1>

                    @if ($content->excerpt)
                        <div class="lead mb-4 text-muted">
                            {{ $content->excerpt }}
                        </div>
                    @endif

                    @if ($content->content)
                        <div class="content-body">
                            {!! $content->content !!}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Content Meta -->
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Content Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="fw-bold">ID:</td>
                                    <td>{{ $content->id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Slug:</td>
                                    <td><code>{{ $content->slug }}</code></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Type:</td>
                                    <td><span class="badge bg-info">{{ ucfirst($content->type) }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Category:</td>
                                    <td>
                                        @if ($content->category)
                                            <span class="badge bg-secondary">{{ $content->category->name }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Featured:</td>
                                    <td>
                                        @if ($content->is_featured)
                                            <span class="badge bg-warning">Yes</span>
                                        @else
                                            <span class="badge bg-light text-dark">No</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="fw-bold">Status:</td>
                                    <td>
                                        @if ($content->status === 'published')
                                            <span class="badge bg-success">Published</span>
                                        @elseif($content->status === 'draft')
                                            <span class="badge bg-warning">Draft</span>
                                        @else
                                            <span class="badge bg-secondary">Archived</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Sort Order:</td>
                                    <td>{{ $content->sort_order }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Created:</td>
                                    <td>{{ $content->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Updated:</td>
                                    <td>{{ $content->updated_at->format('M d, Y H:i') }}</td>
                                </tr>
                                @if ($content->published_at)
                                    <tr>
                                        <td class="fw-bold">Published:</td>
                                        <td>{{ $content->published_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Actions -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-cog me-2"></i>
                        Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.content.edit', $content) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit Content
                        </a>

                        @if ($content->status === 'published')
                            <button type="button" class="btn btn-outline-warning" onclick="changeStatus('draft')">
                                <i class="fas fa-eye-slash me-2"></i>Move to Draft
                            </button>
                        @else
                            <button type="button" class="btn btn-outline-success" onclick="changeStatus('published')">
                                <i class="fas fa-eye me-2"></i>Publish
                            </button>
                        @endif

                        <button type="button" class="btn btn-outline-info" onclick="duplicateContent()">
                            <i class="fas fa-copy me-2"></i>Duplicate
                        </button>

                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-h me-2"></i>More Actions
                            </button>
                            <ul class="dropdown-menu w-100">
                                <li><a class="dropdown-item" href="#" onclick="toggleFeatured()">
                                        <i class="fas fa-star me-2"></i>
                                        {{ $content->is_featured ? 'Remove from Featured' : 'Mark as Featured' }}
                                    </a></li>
                                <li><a class="dropdown-item" href="#" onclick="changeStatus('archived')">
                                        <i class="fas fa-archive me-2"></i>Archive
                                    </a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteContent()">
                                        <i class="fas fa-trash me-2"></i>Delete
                                    </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Information -->
            @if ($content->meta_title || $content->meta_description)
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-search me-2"></i>
                            SEO Information
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($content->meta_title)
                            <div class="mb-3">
                                <label class="form-label fw-bold">Meta Title:</label>
                                <p class="mb-0">{{ $content->meta_title }}</p>
                                <small class="text-muted">{{ strlen($content->meta_title) }} characters</small>
                            </div>
                        @endif

                        @if ($content->meta_description)
                            <div class="mb-0">
                                <label class="form-label fw-bold">Meta Description:</label>
                                <p class="mb-0">{{ $content->meta_description }}</p>
                                <small class="text-muted">{{ strlen($content->meta_description) }} characters</small>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Navigation -->
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-navigation me-2"></i>
                        Navigation
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.content.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Content List
                        </a>

                        @if ($content->status === 'published')
                            <a href="#" class="btn btn-outline-info" target="_blank">
                                <i class="fas fa-external-link-alt me-2"></i>View on Website
                            </a>
                        @endif

                        <a href="{{ route('admin.content.create') }}" class="btn btn-outline-success">
                            <i class="fas fa-plus me-2"></i>Create New Content
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this content?</p>
                    <div class="alert alert-warning">
                        <strong>Warning:</strong> This action cannot be undone. The content and any associated images will
                        be permanently deleted.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.content.destroy', $content) }}" method="POST"
                        style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Content</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Change Form -->
    <form id="statusForm" action="{{ route('admin.content.update', $content) }}" method="POST" style="display: none;">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" id="newStatus">
        <input type="hidden" name="title" value="{{ $content->title }}">
        <input type="hidden" name="type" value="{{ $content->type }}">
    </form>

    <!-- Feature Toggle Form -->
    <form id="featureForm" action="{{ route('admin.content.update', $content) }}" method="POST"
        style="display: none;">
        @csrf
        @method('PUT')
        <input type="hidden" name="is_featured" id="newFeatured">
        <input type="hidden" name="title" value="{{ $content->title }}">
        <input type="hidden" name="type" value="{{ $content->type }}">
        <input type="hidden" name="status" value="{{ $content->status }}">
    </form>
@endsection

@push('styles')
    <style>
        .content-body {
            line-height: 1.6;
        }

        .content-body h1,
        .content-body h2,
        .content-body h3,
        .content-body h4,
        .content-body h5,
        .content-body h6 {
            margin-top: 1.5rem;
            margin-bottom: 1rem;
        }

        .content-body p {
            margin-bottom: 1rem;
        }

        .content-body img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .content-body blockquote {
            border-left: 4px solid var(--primary-color);
            padding-left: 1rem;
            margin: 1.5rem 0;
            font-style: italic;
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 0 8px 8px 0;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function deleteContent() {
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }

        function changeStatus(status) {
            if (confirm(`Are you sure you want to change the status to ${status}?`)) {
                document.getElementById('newStatus').value = status;
                document.getElementById('statusForm').submit();
            }
        }

        function toggleFeatured() {
            const currentFeatured = {{ $content->is_featured ? 'true' : 'false' }};
            const newFeatured = currentFeatured ? '0' : '1';

            if (confirm(`Are you sure you want to ${currentFeatured ? 'remove this from' : 'mark this as'} featured?`)) {
                document.getElementById('newFeatured').value = newFeatured;
                document.getElementById('featureForm').submit();
            }
        }

        function duplicateContent() {
            if (confirm('Are you sure you want to duplicate this content?')) {
                // Here you would implement the duplication logic
                // For now, redirect to create with query params
                const title = '{{ $content->title }}';
                const url = '{{ route('admin.content.create') }}' + '?duplicate=' + {{ $content->id }};
                window.location.href = url;
            }
        }
    </script>
@endpush
