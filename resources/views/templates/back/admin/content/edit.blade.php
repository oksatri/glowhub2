@extends('templates.back._parts.master')

@section('title', 'Edit Content')
@section('page-title', 'Edit Content')
@section('page-subtitle', 'Update content information')

@section('content')
    <form action="{{ route('admin.content.update', $content) }}" method="POST" enctype="multipart/form-data" id="contentForm">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-12 col-lg-8">
                <!-- Main Content Card -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-edit me-2"></i>
                            Content Details
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title', $content->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                name="slug" value="{{ old('slug', $content->slug) }}"
                                placeholder="Auto-generated from title">
                            <small class="form-text text-muted">Leave empty to auto-generate from title</small>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Excerpt -->
                        <div class="mb-3">
                            <label for="excerpt" class="form-label">Excerpt</label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror" id="excerpt" name="excerpt" rows="3"
                                placeholder="Brief description of the content">{{ old('excerpt', $content->excerpt) }}</textarea>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="15">{{ old('content', $content->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-search me-2"></i>
                            SEO Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Meta Title -->
                        <div class="mb-3">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                id="meta_title" name="meta_title" value="{{ old('meta_title', $content->meta_title) }}"
                                maxlength="60">
                            <small class="form-text text-muted">Recommended: 50-60 characters</small>
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Meta Description -->
                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description"
                                name="meta_description" rows="3" maxlength="160">{{ old('meta_description', $content->meta_description) }}</textarea>
                            <small class="form-text text-muted">Recommended: 150-160 characters</small>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                            Publish Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                                required>
                                <option value="draft" {{ old('status', $content->status) === 'draft' ? 'selected' : '' }}>
                                    Draft</option>
                                <option value="published"
                                    {{ old('status', $content->status) === 'published' ? 'selected' : '' }}>Published
                                </option>
                                <option value="archived"
                                    {{ old('status', $content->status) === 'archived' ? 'selected' : '' }}>Archived
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Type -->
                        <div class="mb-3">
                            <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type"
                                required>
                                <option value="article" {{ old('type', $content->type) === 'article' ? 'selected' : '' }}>
                                    Article</option>
                                <option value="page" {{ old('type', $content->type) === 'page' ? 'selected' : '' }}>Page
                                </option>
                                <option value="service" {{ old('type', $content->type) === 'service' ? 'selected' : '' }}>
                                    Service</option>
                                <option value="portfolio"
                                    {{ old('type', $content->type) === 'portfolio' ? 'selected' : '' }}>Portfolio</option>
                                <option value="other" {{ old('type', $content->type) === 'other' ? 'selected' : '' }}>
                                    Other</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                                name="category_id">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $content->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Featured -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured"
                                    value="1" {{ old('is_featured', $content->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    Featured Content
                                </label>
                            </div>
                            <small class="form-text text-muted">Featured content appears prominently on the website</small>
                        </div>

                        <!-- Sort Order -->
                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                id="sort_order" name="sort_order" value="{{ old('sort_order', $content->sort_order) }}"
                                min="0">
                            <small class="form-text text-muted">Lower numbers appear first</small>
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-image me-2"></i>
                            Featured Image
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($content->image)
                            <div class="current-image mb-3">
                                <img src="{{ asset('storage/' . $content->image) }}" alt="{{ $content->title }}"
                                    class="img-fluid rounded" style="max-height: 200px;">
                                <div class="mt-2">
                                    <small class="text-muted">Current image</small>
                                    <button type="button" class="btn btn-sm btn-outline-danger ms-2"
                                        onclick="removeCurrentImage()">
                                        <i class="fas fa-times me-1"></i>Remove
                                    </button>
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Upload new image to replace current one</small>
                        </div>

                        <!-- Image Preview -->
                        <div id="imagePreview" style="display: none;">
                            <img id="previewImg" src="" alt="Preview" class="img-fluid rounded"
                                style="max-height: 200px;">
                            <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="removeImage()">
                                <i class="fas fa-times me-1"></i>Remove
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="admin-card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Content
                            </button>
                            <button type="submit" name="save_and_continue" value="1"
                                class="btn btn-outline-primary">
                                <i class="fas fa-save me-2"></i>Save & Continue Editing
                            </button>
                            <a href="{{ route('admin.content.show', $content) }}" class="btn btn-outline-info">
                                <i class="fas fa-eye me-2"></i>View Content
                            </a>
                            <a href="{{ route('admin.content.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        // Initialize TinyMCE
        tinymce.init({
            selector: '#content',
            height: 400,
            menubar: false,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; }'
        });

        // Auto-generate slug from title (only if slug is empty)
        document.getElementById('title').addEventListener('input', function() {
            const slugField = document.getElementById('slug');
            if (!slugField.value) {
                const title = this.value;
                const slug = title.toLowerCase()
                    .replace(/[^a-z0-9 -]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .trim('-');

                slugField.value = slug;
            }
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

        function removeCurrentImage() {
            if (confirm('Are you sure you want to remove the current image?')) {
                // Add hidden input to mark for deletion
                const form = document.getElementById('contentForm');
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'remove_image';
                hiddenInput.value = '1';
                form.appendChild(hiddenInput);

                // Hide current image display
                document.querySelector('.current-image').style.display = 'none';
            }
        }

        // Form validation
        document.getElementById('contentForm').addEventListener('submit', function(e) {
            const title = document.getElementById('title').value.trim();
            if (!title) {
                e.preventDefault();
                alert('Please enter a title');
                document.getElementById('title').focus();
                return false;
            }
        });
    </script>
@endpush
