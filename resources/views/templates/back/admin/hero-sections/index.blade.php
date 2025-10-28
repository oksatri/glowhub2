@extends('templates.back._parts.master')

@section('title', 'Hero Sections')
@section('page-title', 'Hero Sections')
@section('page-subtitle', 'Manage homepage hero sections')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Hero Sections</h1>
            <p class="text-muted mb-0">Manage your homepage hero banners</p>
        </div>
        <a href="{{ route('admin.hero-sections.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Hero Section
        </a>
    </div>

    <div class="row g-4">
        @forelse($heroSections as $hero)
            <div class="col-12">
                <div class="admin-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                @if ($hero->background_image)
                                    <img src="{{ asset('storage/' . $hero->background_image) }}" alt="{{ $hero->title }}"
                                        class="img-fluid rounded">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                        style="height: 80px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <h5 class="mb-1">{{ $hero->title }}</h5>
                                @if ($hero->subtitle)
                                    <p class="text-muted mb-2">{{ $hero->subtitle }}</p>
                                @endif
                                @if ($hero->description)
                                    <p class="small mb-2">{{ Str::limit($hero->description, 100) }}</p>
                                @endif
                                @if ($hero->button_text)
                                    <span class="badge bg-info">Button: {{ $hero->button_text }}</span>
                                @endif
                                <span class="badge bg-{{ $hero->status === 'active' ? 'success' : 'secondary' }} ms-1">
                                    {{ ucfirst($hero->status) }}
                                </span>
                                <span class="badge bg-light text-dark ms-1">Order: {{ $hero->sort_order ?? 0 }}</span>
                            </div>
                            <div class="col-md-2 text-end">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.hero-sections.edit', $hero) }}"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="confirmDelete({{ $hero->id }}, '{{ $hero->title }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-image fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No hero sections found</h5>
                    <a href="{{ route('admin.hero-sections.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create First Hero Section
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    @if ($heroSections->hasPages())
        <div class="mt-4">{{ $heroSections->links() }}</div>
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
                    <p>Delete hero section "<span id="heroName"></span>"?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf @method('DELETE')
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
            document.getElementById('heroName').textContent = name;
            document.getElementById('deleteForm').action = `/admin/hero-sections/${id}`;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
    </script>
@endpush
