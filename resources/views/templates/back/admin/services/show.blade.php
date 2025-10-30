@extends('templates.back._parts.master')

@section('title', 'View Service')
@section('page-title', $service->title)
@section('page-subtitle', 'Service details')

@section('content')
    <div class="row">
        <div class="col-12 col-lg-8">
            <!-- Service Details -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-cog me-2"></i>
                        Service Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h2 class="mb-3">{{ $service->title }}</h2>

                            @if ($service->slug)
                                <div class="mb-3">
                                    <strong>Slug:</strong>
                                    <code>{{ $service->slug }}</code>
                                </div>
                            @endif

                            <div class="mb-4">
                                <h5>Description</h5>
                                <div class="border rounded p-3 bg-light">
                                    {!! nl2br(e($service->description)) !!}
                                </div>
                            </div>

                            @if ($service->icon)
                                <div class="mb-3">
                                    <strong>Icon:</strong>
                                    <i class="{{ $service->icon }} me-2"></i>
                                    <code>{{ $service->icon }}</code>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            @if ($service->image)
                                <div class="text-center">
                                    <h6>Service Image</h6>
                                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}"
                                        class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                                </div>
                            @elseif($service->icon)
                                <div class="text-center">
                                    <h6>Service Icon</h6>
                                    <div class="rounded d-flex align-items-center justify-content-center mx-auto"
                                        style="width: 150px; height: 150px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);">
                                        <i class="{{ $service->icon }} text-white" style="font-size: 4rem;"></i>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <!-- Service Status -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Service Status
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Status:</strong>
                        <span class="badge bg-{{ $service->status === 'active' ? 'success' : 'secondary' }} ms-2">
                            {{ ucfirst($service->status) }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <strong>Sort Order:</strong>
                        <span class="badge bg-info ms-2">{{ $service->sort_order ?? 0 }}</span>
                    </div>

                    <div class="mb-3">
                        <strong>Created:</strong><br>
                        <small class="text-muted">{{ $service->created_at->format('M d, Y \a\t H:i') }}</small>
                    </div>

                    <div class="mb-3">
                        <strong>Last Updated:</strong><br>
                        <small class="text-muted">{{ $service->updated_at->format('M d, Y \a\t H:i') }}</small>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit Service
                        </a>

                        @if ($service->status === 'active')
                            <form action="{{ route('admin.services.update', $service) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="title" value="{{ $service->title }}">
                                <input type="hidden" name="slug" value="{{ $service->slug }}">
                                <input type="hidden" name="description" value="{{ $service->description }}">
                                <input type="hidden" name="icon" value="{{ $service->icon }}">
                                <input type="hidden" name="sort_order" value="{{ $service->sort_order }}">
                                <input type="hidden" name="status" value="inactive">
                                <button type="submit" class="btn btn-outline-warning w-100">
                                    <i class="fas fa-pause me-2"></i>Deactivate
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.services.update', $service) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="title" value="{{ $service->title }}">
                                <input type="hidden" name="slug" value="{{ $service->slug }}">
                                <input type="hidden" name="description" value="{{ $service->description }}">
                                <input type="hidden" name="icon" value="{{ $service->icon }}">
                                <input type="hidden" name="sort_order" value="{{ $service->sort_order }}">
                                <input type="hidden" name="status" value="active">
                                <button type="submit" class="btn btn-outline-success w-100">
                                    <i class="fas fa-play me-2"></i>Activate
                                </button>
                            </form>
                        @endif

                        <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                            <i class="fas fa-trash me-2"></i>Delete Service
                        </button>

                        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Services
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
                    <p>Are you sure you want to delete "<strong>{{ $service->title }}</strong>"?</p>
                    <p class="text-muted small">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST"
                        style="display: inline;">
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
        function confirmDelete() {
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }
    </script>
@endpush
