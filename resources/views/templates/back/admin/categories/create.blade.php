@extends('templates.back._parts.master')

@section('title', 'Create Category')
@section('page-title', 'Create New Category')
@section('page-subtitle', 'Add a new content category')

@section('content')
    <form action="{{ route('admin.categories.store') }}" method="POST" id="categoryForm">
        @csrf

        <div class="row">
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Basic Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                name="slug" value="{{ old('slug') }}" placeholder="Auto-generated from name">
                            <small class="form-text text-muted">Leave empty to auto-generate from name</small>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="4" placeholder="Brief description of this category">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Settings -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-cog me-2"></i>
                            Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Status -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                    value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active Category
                                </label>
                            </div>
                            <small class="form-text text-muted">Inactive categories won't appear in selections</small>
                        </div>

                        <!-- Sort Order -->
                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                            <small class="form-text text-muted">Lower numbers appear first</small>
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Appearance -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-palette me-2"></i>
                            Appearance
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Icon -->
                        <div class="mb-3">
                            <label for="icon" class="form-label">Icon</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i id="iconPreview" class="{{ old('icon', 'fas fa-folder') }}"></i>
                                </span>
                                <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                    id="icon" name="icon" value="{{ old('icon') }}" placeholder="fas fa-folder">
                            </div>
                            <small class="form-text text-muted">FontAwesome icon class (e.g., fas fa-folder)</small>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Color -->
                        <div class="mb-3">
                            <label for="color" class="form-label">Color</label>
                            <div class="input-group">
                                <input type="color"
                                    class="form-control form-control-color @error('color') is-invalid @enderror"
                                    id="color" name="color" value="{{ old('color', '#6c757d') }}"
                                    style="width: 60px;">
                                <input type="text" class="form-control" id="colorHex"
                                    value="{{ old('color', '#6c757d') }}" readonly>
                            </div>
                            <small class="form-text text-muted">Pick a color for this category</small>
                            @error('color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Preview -->
                        <div class="mb-3">
                            <label class="form-label">Preview</label>
                            <div id="categoryPreview" class="d-flex align-items-center p-3 border rounded">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width: 40px; height: 40px; background-color: #6c757d;">
                                    <i class="fas fa-folder text-white"></i>
                                </div>
                                <div>
                                    <strong id="previewName">Category Name</strong>
                                    <div class="small text-muted" id="previewDesc">Category description</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="admin-card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Category
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        // Auto-generate slug from name
        document.getElementById('name').addEventListener('input', function() {
            const name = this.value;
            const slug = name.toLowerCase()
                .replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');

            document.getElementById('slug').value = slug;
            updatePreview();
        });

        // Update icon preview
        document.getElementById('icon').addEventListener('input', function() {
            const iconClass = this.value || 'fas fa-folder';
            document.getElementById('iconPreview').className = iconClass;
            updatePreview();
        });

        // Update color preview
        document.getElementById('color').addEventListener('input', function() {
            const color = this.value;
            document.getElementById('colorHex').value = color;
            updatePreview();
        });

        // Update description preview
        document.getElementById('description').addEventListener('input', function() {
            updatePreview();
        });

        function updatePreview() {
            const name = document.getElementById('name').value || 'Category Name';
            const description = document.getElementById('description').value || 'Category description';
            const icon = document.getElementById('icon').value || 'fas fa-folder';
            const color = document.getElementById('color').value || '#6c757d';

            // Update preview
            document.getElementById('previewName').textContent = name;
            document.getElementById('previewDesc').textContent = description;

            const preview = document.getElementById('categoryPreview');
            const iconElement = preview.querySelector('i');
            const colorDiv = preview.querySelector('.rounded-circle');

            iconElement.className = icon + ' text-white';
            colorDiv.style.backgroundColor = color;
        }

        // Common icon suggestions
        const iconSuggestions = [
            'fas fa-folder',
            'fas fa-star',
            'fas fa-heart',
            'fas fa-palette',
            'fas fa-image',
            'fas fa-video',
            'fas fa-music',
            'fas fa-book',
            'fas fa-graduation-cap',
            'fas fa-briefcase',
            'fas fa-home',
            'fas fa-car',
            'fas fa-plane',
            'fas fa-camera',
            'fas fa-shopping-bag'
        ];

        // Add icon suggestions
        document.getElementById('icon').addEventListener('focus', function() {
            // You can implement icon picker here
        });

        // Form validation
        document.getElementById('categoryForm').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            if (!name) {
                e.preventDefault();
                alert('Please enter a category name');
                document.getElementById('name').focus();
                return false;
            }
        });
    </script>
@endpush
