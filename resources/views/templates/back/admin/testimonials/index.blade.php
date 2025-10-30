@extends('templates.back._parts.master')

@section('title', 'Testimonials')
@section('page-title', 'Testimonials')
@section('page-subtitle', 'Manage customer testimonials')

@section('content')
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Testimonials</h1>
            <p class="text-muted mb-0">Manage customer feedback and reviews</p>
        </div>
        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Testimonial
        </a>
    </div>

    <!-- Testimonials Cards -->
    <div class="row g-4">
        @forelse($testimonials as $testimonial)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="admin-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            @if ($testimonial->image)
                                <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->name }}"
                                    class="rounded-circle me-3" width="50" height="50" style="object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $testimonial->name }}</h6>
                                @if ($testimonial->position)
                                    <small class="text-muted">{{ $testimonial->position }}</small>
                                @endif
                                @if ($testimonial->company)
                                    <small class="text-muted d-block">{{ $testimonial->company }}</small>
                                @endif
                            </div>
                            <span class="badge bg-{{ $testimonial->status === 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($testimonial->status) }}
                            </span>
                        </div>

                        <div class="mb-3">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                            <span class="ms-1 small text-muted">({{ $testimonial->rating }}/5)</span>
                        </div>

                        <p class="text-muted mb-3">{{ Str::limit($testimonial->content, 120) }}</p>

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.testimonials.show', $testimonial) }}"
                                class="btn btn-outline-info btn-sm flex-fill">
                                <i class="fas fa-eye me-1"></i>View
                            </a>
                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}"
                                class="btn btn-outline-primary btn-sm flex-fill">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                            <button type="button" class="btn btn-outline-danger btn-sm flex-fill"
                                onclick="confirmDelete({{ $testimonial->id }}, '{{ $testimonial->name }}')">
                                <i class="fas fa-trash me-1"></i>Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-star fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No testimonials found</h5>
                    <p class="text-muted">Start by adding customer testimonials.</p>
                    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add First Testimonial
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($testimonials->hasPages())
        <div class="mt-4">
            {{ $testimonials->links() }}
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
                    <p>Are you sure you want to delete testimonial from "<span id="testimonialName"></span>"?</p>
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
            document.getElementById('testimonialName').textContent = name;
            document.getElementById('deleteForm').action = `/admin/testimonials/${id}`;
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }
    </script>
@endpush
