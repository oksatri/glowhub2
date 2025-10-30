@extends('templates.back._parts.master')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Overview of your GlowHub content management')

@section('content')
    <div class="row g-4 mb-4">
        <!-- Stats Cards -->
        <div class="col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="stats-number">{{ $stats['contents'] }}</h3>
                        <p class="stats-label">Total Contents</p>
                        <small class="text-success">
                            <i class="fas fa-arrow-up"></i>
                            {{ $stats['published_contents'] }} Published
                        </small>
                    </div>
                    <div class="stats-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="stats-number">{{ $stats['categories'] }}</h3>
                        <p class="stats-label">Categories</p>
                        <small class="text-info">
                            <i class="fas fa-folder"></i>
                            Content organization
                        </small>
                    </div>
                    <div class="stats-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <i class="fas fa-folder"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="stats-number">{{ $stats['testimonials'] }}</h3>
                        <p class="stats-label">Testimonials</p>
                        <small class="text-warning">
                            <i class="fas fa-star"></i>
                            Customer feedback
                        </small>
                    </div>
                    <div class="stats-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="stats-number">{{ $stats['services'] }}</h3>
                        <p class="stats-label">Services</p>
                        <small class="text-success">
                            <i class="fas fa-concierge-bell"></i>
                            Available services
                        </small>
                    </div>
                    <div class="stats-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                        <i class="fas fa-concierge-bell"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Contents -->
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-file-alt me-2"></i>
                        Recent Contents
                    </h5>
                    <a href="{{ route('admin.content.index') }}" class="btn btn-sm btn-outline-primary">
                        View All
                    </a>
                </div>
                <div class="card-body p-0">
                    @if ($recentContents->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentContents as $content)
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong>{{ $content->title }}</strong>
                                                    @if ($content->is_featured)
                                                        <span class="badge bg-warning ms-2">Featured</span>
                                                    @endif
                                                </div>
                                                <small class="text-muted">{{ $content->type }}</small>
                                            </td>
                                            <td>
                                                @if ($content->category)
                                                    <span class="badge bg-secondary">{{ $content->category->name }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
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
                                                <small
                                                    class="text-muted">{{ $content->created_at->diffForHumans() }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-alt text-muted" style="font-size: 48px;"></i>
                            <h5 class="mt-3 text-muted">No contents yet</h5>
                            <p class="text-muted">Start by creating your first content</p>
                            <a href="{{ route('admin.content.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Create Content
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Testimonials -->
        <div class="col-lg-4">
            <div class="admin-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-star me-2"></i>
                        Recent Testimonials
                    </h5>
                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-sm btn-outline-primary">
                        View All
                    </a>
                </div>
                <div class="card-body">
                    @if ($recentTestimonials->count() > 0)
                        @foreach ($recentTestimonials as $testimonial)
                            <div class="d-flex mb-3 @if (!$loop->last) pb-3 border-bottom @endif">
                                <div class="flex-shrink-0">
                                    @if ($testimonial->image)
                                        <img src="{{ asset('storage/' . $testimonial->image) }}"
                                            alt="{{ $testimonial->name }}" class="rounded-circle" width="45"
                                            height="45" style="object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center"
                                            style="width: 45px; height: 45px;">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">{{ $testimonial->name }}</h6>
                                    <div class="mb-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-warning' : 'text-muted' }}"
                                                style="font-size: 12px;"></i>
                                        @endfor
                                    </div>
                                    <p class="mb-0 text-muted small">{{ Str::limit($testimonial->message, 80) }}</p>
                                    <small class="text-muted">{{ $testimonial->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-star text-muted" style="font-size: 36px;"></i>
                            <h6 class="mt-3 text-muted">No testimonials yet</h6>
                            <p class="text-muted small">Add customer testimonials</p>
                            <a href="{{ route('admin.testimonials.create') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus me-1"></i>Add Testimonial
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="admin-card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.content.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-2"></i>New Content
                        </a>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-folder-plus me-2"></i>New Category
                        </a>
                        <a href="{{ route('admin.services.create') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-concierge-bell me-2"></i>New Service
                        </a>
                        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-star me-2"></i>New Testimonial
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats Row -->
    <div class="row g-4 mt-2">
        <div class="col-md-6">
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-image me-2"></i>
                        Hero Sections
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="text-primary mb-0">{{ $stats['hero_sections'] }}</h4>
                            <small class="text-muted">Active hero sections</small>
                        </div>
                        <a href="{{ route('admin.hero-sections.index') }}" class="btn btn-outline-primary btn-sm">
                            Manage
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-list-ol me-2"></i>
                        How It Works Steps
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="text-primary mb-0">{{ $stats['how_it_works'] }}</h4>
                            <small class="text-muted">Process steps</small>
                        </div>
                        <a href="{{ route('admin.how-it-works.index') }}" class="btn btn-outline-primary btn-sm">
                            Manage
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Dashboard specific JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            // Add any dashboard specific functionality here
            console.log('Dashboard loaded');
        });
    </script>
@endpush
