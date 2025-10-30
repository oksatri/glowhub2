@extends('templates.back._parts.master')

@section('title', 'Edit Service')
@section('page-title', 'Edit Service')
@section('page-subtitle', 'Update service information')

@section('content')
    <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data" id="serviceForm">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-12 col-lg-8">
                <!-- Main Service Card -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-cog me-2"></i>
                            Service Details
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title', $service->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                name="slug" value="{{ old('slug', $service->slug) }}"
                                placeholder="Auto-generated from title">
                            <small class="form-text text-muted">Leave empty to auto-generate from title</small>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="6" required>{{ old('description', $service->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Icon -->
                        <div class="mb-3">
                            <label for="icon" class="form-label">Icon Class</label>
                            <input type="text" class="form-control @error('icon') is-invalid @enderror" id="icon"
                                name="icon" value="{{ old('icon', $service->icon) }}"
                                placeholder="e.g., fas fa-laptop-code">
                            <small class="form-text text-muted">
                                Use Font Awesome classes (e.g., fas fa-laptop-code, fas fa-mobile-alt)
                                <a href="https://fontawesome.com/icons" target="_blank">Browse icons</a>
                            </small>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Image -->
                        @if ($service->image)
                            <div class="mb-3">
                                <label class="form-label">Current Image</label>
                                <div>
                                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}"
                                        class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            </div>
                        @endif

                        <!-- Image Upload -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Service Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image" accept="image/*">
                            <small class="form-text text-muted">
                                Optional. Upload new image to replace current one. Supported formats: JPEG, PNG, JPG, GIF.
                                Max size: 2MB
                            </small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Image Preview -->
                        <div id="imagePreview" class="mb-3" style="display: none;">
                            <label class="form-label">New Image Preview</label>
                            <div>
                                <img id="previewImg" src="" alt="Preview" class="img-thumbnail"
                                    style="max-width: 200px;">
                                <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="removeImage()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <!-- Publish Settings -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-cog me-2"></i>
                            Service Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                                required>
                                <option value="active"
                                    {{ old('status', $service->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive"
                                    {{ old('status', $service->status) === 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Sort Order -->
                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                id="sort_order" name="sort_order"
                                value="{{ old('sort_order', $service->sort_order ?? 0) }}" min="0">
                            <small class="form-text text-muted">Lower numbers appear first</small>
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Service Info -->
                        <div class="mb-3">
                            <label class="form-label">Service Info</label>
                            <div class="small text-muted">
                                <div><strong>Created:</strong> {{ $service->created_at->format('M d, Y H:i') }}</div>
                                <div><strong>Updated:</strong> {{ $service->updated_at->format('M d, Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="admin-card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Service
                            </button>
                            <a href="{{ route('admin.services.show', $service) }}" class="btn btn-outline-info">
                                <i class="fas fa-eye me-2"></i>View Service
                            </a>
                            <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Services
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
        // Auto-generate slug from title
        document.getElementById('title').addEventListener('input', function() {
            const title = this.value;
            const slug = title.toLowerCase()
                .replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            document.getElementById('slug').value = slug;
        });

        // Image preview
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        function removeImage() {
            document.getElementById('image').value = '';
            document.getElementById('imagePreview').style.display = 'none';
        }

        // Form validation
        document.getElementById('serviceForm').addEventListener('submit', function(e) {
            const title = document.getElementById('title').value.trim();
            const description = document.getElementById('description').value.trim();

            if (!title) {
                e.preventDefault();
                alert('Please enter a service title');
                document.getElementById('title').focus();
                return false;
            }

            if (!description) {
                e.preventDefault();
                alert('Please enter a service description');
                document.getElementById('description').focus();
                return false;
            }
        });
    </script>
@endpush
