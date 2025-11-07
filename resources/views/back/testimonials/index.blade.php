@extends('back._parts.master')
@section('page-title', 'Testimonials')
@section('content')
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-2" style="color: #2D3748; font-weight: 600; letter-spacing: -0.025em;">Testimonials</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0" style="font-size: 0.95rem;">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}" class="text-decoration-none" style="color: #6B7280;">
                            <i class="fas fa-home me-1 opacity-75"></i>Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item active" style="color: #4B5563;">Testimonials</li>
                </ol>
            </nav>
        </div>
        <a href="{{ url('testimonials/create') }}" class="btn px-4 py-2 rounded-pill shadow-sm text-white"
            style="background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%); border: none; transition: all 0.3s ease;">
            <i class="fas fa-plus-circle me-2"></i>
            Create New Testimonial
        </a>
    </div>

    <!-- Search & Filter Card -->
    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(to right, #F9FAFB, #F3F4F6);">
        <div class="card-body px-4 py-4">
            <form method="GET" action="{{ url('testimonials') }}" class="mb-0">
                <div class="row g-3 align-items-center">
                    <div class="col-lg-5 col-md-6">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-0 ps-4">
                                <i class="fas fa-search" style="color: #9CA3AF;"></i>
                            </span>
                            <input type="text" name="name" class="form-control border-0 ps-2 shadow-none"
                                style="background: white; font-size: 0.95rem;" placeholder="Search by name or quote..."
                                value="{{ request('name') }}">
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <select name="rating" class="form-select shadow-none border-0"
                            style="background: white; height: 48px; font-size: 0.95rem;">
                            <option value="">Any Rating</option>
                            @for ($r = 5; $r >= 1; $r--)
                                <option value="{{ $r }}" {{ request('rating') == $r ? 'selected' : '' }}>
                                    {{ $r }} stars</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <select name="status" class="form-select shadow-none border-0"
                            style="background: white; height: 48px; font-size: 0.95rem;">
                            <option value="">All Status</option>
                            <option value="publish" {{ request('status') == 'publish' ? 'selected' : '' }}>Published
                            </option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="archive" {{ request('status') == 'archive' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex gap-2">
                        <button type="submit" class="btn flex-fill py-2 text-white"
                            style="background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%); border: none; font-size: 0.95rem;">
                            <i class="fas fa-filter me-2 opacity-75"></i>Apply Filter
                        </button>
                        @if (request()->hasAny(['name', 'rating', 'status']))
                            <a href="{{ url('testimonials') }}" class="btn py-2 px-3"
                                style="background: white; border: 1px solid #E5E7EB; color: #4B5563;">
                                <i class="fas fa-times opacity-50"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Testimonials Table -->
    <div class="card border-0 shadow-sm" style="background: white;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
                    <thead style="background: #F8FAFC;">
                        <tr>
                            <th class="px-4 py-3"
                                style="color: #1F2937; font-weight: 600; border-bottom: 2px solid #E5E7EB;">Testimonial</th>
                            <th class="py-3"
                                style="width: 120px; color: #1F2937; font-weight: 600; border-bottom: 2px solid #E5E7EB;">
                                Rating</th>
                            <th class="py-3"
                                style="width: 120px; color: #1F2937; font-weight: 600; border-bottom: 2px solid #E5E7EB;">
                                Status</th>
                            <th class="py-3"
                                style="width: 100px; color: #1F2937; font-weight: 600; border-bottom: 2px solid #E5E7EB;">
                                Order</th>
                            <th class="py-3"
                                style="width: 200px; color: #1F2937; font-weight: 600; border-bottom: 2px solid #E5E7EB;">
                                Last Updated</th>
                            <th class="py-3 text-end px-4"
                                style="width: 200px; color: #1F2937; font-weight: 600; border-bottom: 2px solid #E5E7EB;">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testimonials as $t)
                            <tr style="border-bottom: 1px solid #F3F4F6;">
                                <td class="px-4" style="padding-top: 1rem; padding-bottom: 1rem;">
                                    <div class="d-flex align-items-center py-1">
                                        <div class="content-icon me-3 rounded-lg d-flex align-items-center justify-content-center"
                                            style="width: 48px; height: 48px;margin-right:10px">
                                            @if ($t->image)
                                                <img src="{{ asset('storage/' . $t->image) }}" alt=""
                                                    class="rounded-circle"
                                                    style="width:42px; height:42px; object-fit:cover;">
                                            @else
                                                <i class="fas fa-user"
                                                    style="color: #9CA3AF !important; font-size: 1.25rem;"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-1"
                                                style="color: #111827; font-weight: 600; font-size: 0.975rem;">
                                                {{ $t->name }}</h6>
                                            <p class="mb-0" style="color: #6B7280; font-size: 0.875rem;">
                                                {{ Str::limit($t->quote, 60) }}</p>
                                            <small class="text-muted">{{ $t->role }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">
                                    <div>{{ $t->rating }} / 5</div>
                                </td>
                                <td>
                                    @switch($t->status)
                                        @case('publish')
                                            <span class="badge rounded-pill px-3 py-2"
                                                style="background: #ECFDF5; color: #065F46; font-weight: 500;">Published</span>
                                        @break

                                        @case('draft')
                                            <span class="badge rounded-pill px-3 py-2"
                                                style="background: #FEF3C7; color: #92400E; font-weight: 500;">Draft</span>
                                        @break

                                        @case('archive')
                                            <span class="badge rounded-pill px-3 py-2"
                                                style="background: #F3F4F6; color: #374151; font-weight: 500;">Archived</span>
                                        @break
                                    @endswitch
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="badge rounded-pill px-3 py-2"
                                            style="background: #EFF6FF; color: #1E40AF; font-weight: 600; min-width: 32px;">
                                            {{ $t->order ?? 0 }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span
                                            style="color: #374151; font-size: 0.875rem; font-weight: 500;">{{ $t->updated_at->format('M d, Y') }}</span>
                                        <span
                                            style="color: #6B7280; font-size: 0.813rem;">{{ $t->updated_at->format('h:i A') }}</span>
                                    </div>
                                </td>
                                <td class="text-end px-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ url('testimonials/' . $t->id . '/edit') }}"
                                            class="btn btn-sm d-inline-flex align-items-center"
                                            style="background: #F9FAFB; border: 1px solid #E5E7EB; color: #374151; font-weight: 500; padding: 0.5rem 1rem;">
                                            <i class="fas fa-edit me-2 opacity-70"></i> Edit
                                        </a>

                                        @if ($t->status == 'publish')
                                            <form action="{{ url('testimonials/' . $t->id . '/unpublish') }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm d-inline-flex align-items-center"
                                                    style="background: #FEF3C7; border: 1px solid #D97706; color: #92400E; font-weight: 500; padding: 0.5rem 1rem;"
                                                    onclick="return confirm('Are you sure you want to unpublish this testimonial?')">
                                                    <i class="fas fa-eye-slash me-2 opacity-70"></i> Unpublish
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ url('testimonials/' . $t->id . '/publish') }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm d-inline-flex align-items-center"
                                                    style="background: #ECFDF5; border: 1px solid #059669; color: #065F46; font-weight: 500; padding: 0.5rem 1rem;"
                                                    onclick="return confirm('Are you sure you want to publish this testimonial?')">
                                                    <i class="fas fa-check-circle me-2 opacity-70"></i> Publish
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ url('testimonials/' . $t->id) }}" method="POST"
                                            class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-sm d-inline-flex align-items-center delete-btn"
                                                style="background: #FEE2E2; border: 1px solid #EF4444; color: #991B1B; font-weight: 500; padding: 0.5rem 1rem;"
                                                data-id="{{ $t->id }}" data-title="{{ $t->name }}">
                                                <i class="fas fa-trash-alt me-2 opacity-70"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-16">
                                        <div class="d-flex flex-column align-items-center">
                                            <div class="empty-state mb-4 p-3 rounded-circle" style="background: #F3F4F6;">
                                                <i class="fas fa-quote-right fa-4x" style="color: #9CA3AF;"></i>
                                            </div>
                                            <h5 class="fw-normal mb-2" style="color: #374151; font-size: 1.25rem;">No
                                                Testimonials Found</h5>
                                            <p style="color: #6B7280; font-size: 1rem;" class="mb-4">Start by adding your
                                                first testimonial</p>
                                            <a href="{{ url('testimonials/create') }}"
                                                class="btn px-4 py-2 rounded-pill text-white"
                                                style="background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%); border: none;">
                                                <i class="fas fa-plus me-2"></i> Create New Testimonial
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-between align-items-center">
            <div style="color: #4B5563; font-size: 0.95rem;">
                Showing <span class="fw-medium">{{ $testimonials->firstItem() ?? 0 }}</span> to
                <span class="fw-medium">{{ $testimonials->lastItem() ?? 0 }}</span> of
                <span class="fw-medium">{{ $testimonials->total() ?? 0 }}</span> entries
            </div>
            <div class="pagination-wrapper" style="margin: -0.25rem;">
                {{ $testimonials->appends(request()->query())->links() }}
            </div>
        </div>

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Handle delete button clicks
                    const deleteButtons = document.querySelectorAll('.delete-btn');
                    deleteButtons.forEach(button => {
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            const itemId = this.dataset.id;
                            const itemTitle = this.dataset.title;

                            if (confirm(
                                    `Are you sure you want to delete "${itemTitle}"? This action cannot be undone.`
                                )) {
                                const form = this.closest('.delete-form');
                                if (form) form.submit();
                            }
                        });
                    });

                    // Auto-hide alerts after 5 seconds
                    const alerts = document.querySelectorAll('.alert');
                    alerts.forEach(alert => {
                        setTimeout(() => {
                            const closeButton = alert.querySelector('.btn-close');
                            if (closeButton) closeButton.click();
                        }, 5000);
                    });
                });
            </script>
        @endpush

    @endsection
