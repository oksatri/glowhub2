@extends('back._parts.master')
@section('page-title', 'Content Management')
@section('content')
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-2" style="color: #2D3748; font-weight: 600; letter-spacing: -0.025em;">Content Management</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0" style="font-size: 0.95rem;">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}" class="text-decoration-none" style="color: #6B7280;">
                            <i class="fas fa-home me-1 opacity-75"></i>Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item active" style="color: #4B5563;">Content Management</li>
                </ol>
            </nav>
        </div>
        <a href="{{ url('content-management/create') }}"
           class="btn px-4 py-2 rounded-pill shadow-sm text-white"
           style="background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%); border: none; transition: all 0.3s ease;">
            <i class="fas fa-plus-circle me-2"></i>
            Create New Content
        </a>
    </div>

    <!-- Search & Filter Card -->
    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(to right, #F9FAFB, #F3F4F6);">
        <div class="card-body px-4 py-4">
            <form method="GET" action="{{ url('content-management') }}" class="mb-0">
                <div class="row g-3 align-items-center">
                    <div class="col-lg-5 col-md-6">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-0 ps-4">
                                <i class="fas fa-search" style="color: #9CA3AF;"></i>
                            </span>
                            <input type="text" name="title"
                                   class="form-control border-0 ps-2 shadow-none"
                                   style="background: white; font-size: 0.95rem;"
                                   placeholder="Search content..."
                                   value="{{ request('title') }}">
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <select name="section_type" class="form-select shadow-none border-0"
                                style="background: white; height: 48px; font-size: 0.95rem;">
                            <option value="">Content Type</option>
                            <option value="content" {{ request('section_type') == 'content' ? 'selected' : '' }}>Content Section</option>
                            <option value="hero" {{ request('section_type') == 'hero' ? 'selected' : '' }}>Hero Banner</option>
                            <option value="product" {{ request('section_type') == 'product' ? 'selected' : '' }}>Product</option>
                            <option value="testimonials" {{ request('section_type') == 'testimonials' ? 'selected' : '' }}>Testimonials</option>
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <select name="status" class="form-select shadow-none border-0"
                                style="background: white; height: 48px; font-size: 0.95rem;">
                            <option value="">All Status</option>
                            <option value="publish" {{ request('status') == 'publish' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="archive" {{ request('status') == 'archive' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex gap-2">
                        <button type="submit" class="btn flex-fill py-2 text-white"
                                style="background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%); border: none; font-size: 0.95rem;">
                            <i class="fas fa-filter me-2 opacity-75"></i>Apply Filter
                        </button>
                        @if(request()->hasAny(['title', 'section_type', 'status']))
                            <a href="{{ url('content-management') }}"
                               class="btn py-2 px-3"
                               style="background: white; border: 1px solid #E5E7EB; color: #4B5563;">
                                <i class="fas fa-times opacity-50"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Content Table -->
    <div class="card border-0 shadow-sm" style="background: white;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
                    <thead style="background: #F8FAFC;">
                        <tr>
                            <th class="px-4 py-3" style="color: #1F2937; font-weight: 600; border-bottom: 2px solid #E5E7EB;">Content Details</th>
                            <th class="py-3" style="width: 150px; color: #1F2937; font-weight: 600; border-bottom: 2px solid #E5E7EB;">Type</th>
                            <th class="py-3" style="width: 120px; color: #1F2937; font-weight: 600; border-bottom: 2px solid #E5E7EB;">Status</th>
                            <th class="py-3" style="width: 100px; color: #1F2937; font-weight: 600; border-bottom: 2px solid #E5E7EB;">Order</th>
                            <th class="py-3" style="width: 200px; color: #1F2937; font-weight: 600; border-bottom: 2px solid #E5E7EB;">Last Updated</th>
                            <th class="py-3 text-end px-4" style="width: 200px; color: #1F2937; font-weight: 600; border-bottom: 2px solid #E5E7EB;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contents as $content)
                            <tr style="border-bottom: 1px solid #F3F4F6;">
                                <td class="px-4" style="padding-top: 1rem; padding-bottom: 1rem;">
                                    <div class="d-flex align-items-center py-1">
                                        <div class="content-icon me-3 rounded-lg d-flex align-items-center justify-content-center"
                                             style="width: 48px; height: 48px;margin-right:10px">
                                            @switch($content->section_type)
                                                @case('hero')
                                                    <i class="fas fa-star" style="color: #FBBF24 !important; font-size: 2.25rem;"></i>
                                                    @break
                                                @case('product')
                                                    <i class="fas fa-box" style="color: #3B82F6 !important; font-size: 2.25rem;"></i>
                                                    @break
                                                @case('testimonials')
                                                    <i class="fas fa-quote-right" style="color: #10B981 !important; font-size: 2.25rem;"></i>
                                                    @break
                                                @default
                                                    <i class="fas fa-file-alt" style="color: #60A5FA !important; font-size: 2.25rem;"></i>
                                            @endswitch
                                        </div>
                                        <div>
                                            <h6 class="mb-1" style="color: #111827; font-weight: 600; font-size: 0.975rem;">{{ $content->title }}</h6>
                                            <p class="mb-0" style="color: #6B7280; font-size: 0.875rem;">{{ Str::limit($content->description, 50) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">
                                    <span class="text-capitalize" style="color: #374151; font-weight: 500;">{{ $content->section_type }}</span>
                                </td>
                                <td>
                                    @switch($content->status)
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
                                            {{ $content->order ?? 0 }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span style="color: #374151; font-size: 0.875rem; font-weight: 500;">{{ $content->updated_at->format('M d, Y') }}</span>
                                        <span style="color: #6B7280; font-size: 0.813rem;">{{ $content->updated_at->format('h:i A') }}</span>
                                    </div>
                                </td>
                                <td class="text-end px-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ url('content-management/' . $content->id . '/edit') }}"
                                           class="btn btn-sm d-inline-flex align-items-center"
                                           style="background: #F9FAFB; border: 1px solid #E5E7EB; color: #374151; font-weight: 500; padding: 0.5rem 1rem;">
                                            <i class="fas fa-edit me-2 opacity-70"></i> Edit
                                        </a>

                                        @if ($content->status == 'publish')
                                            <form action="{{ url('content-management/' . $content->id . '/unpublish') }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm d-inline-flex align-items-center"
                                                        style="background: #FEF3C7; border: 1px solid #D97706; color: #92400E; font-weight: 500; padding: 0.5rem 1rem;"
                                                        onclick="return confirm('Are you sure you want to unpublish this content?')">
                                                    <i class="fas fa-eye-slash me-2 opacity-70"></i> Unpublish
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ url('content-management/' . $content->id . '/publish') }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm d-inline-flex align-items-center"
                                                        style="background: #ECFDF5; border: 1px solid #059669; color: #065F46; font-weight: 500; padding: 0.5rem 1rem;"
                                                        onclick="return confirm('Are you sure you want to publish this content?')">
                                                    <i class="fas fa-check-circle me-2 opacity-70"></i> Publish
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ url('content-management/' . $content->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm d-inline-flex align-items-center"
                                                    style="background: #FEE2E2; border: 1px solid #EF4444; color: #991B1B; font-weight: 500; padding: 0.5rem 1rem;"
                                                    onclick="return confirm('Are you sure you want to delete this content? This action cannot be undone.')">
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
                                            <i class="fas fa-file-alt fa-4x" style="color: #9CA3AF;"></i>
                                        </div>
                                        <h5 class="fw-normal mb-2" style="color: #374151; font-size: 1.25rem;">No Content Found</h5>
                                        <p style="color: #6B7280; font-size: 1rem;" class="mb-4">Start by adding your first content section</p>
                                        <a href="{{ url('content-management/create') }}" class="btn px-4 py-2 rounded-pill text-white" style="background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%); border: none;">
                                            <i class="fas fa-plus me-2"></i> Create New Content
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
            Showing <span class="fw-medium">{{ $contents->firstItem() ?? 0 }}</span> to
            <span class="fw-medium">{{ $contents->lastItem() ?? 0 }}</span> of
            <span class="fw-medium">{{ $contents->total() ?? 0 }}</span> entries
        </div>
        <div class="pagination-wrapper" style="margin: -0.25rem;">
            {{ $contents->appends(request()->query())->links() }}
        </div>
    </div>

@endsection
