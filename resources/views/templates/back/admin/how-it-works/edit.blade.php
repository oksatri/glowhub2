@extends('templates.back._parts.master')

@section('title', 'Edit Process Step')
@section('page-title', 'Edit Process Step')
@section('page-subtitle', 'Update step: {{ $howItWork->title }}')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">Edit Process Step</h1>
                <p class="mb-0 text-muted">Update step: {{ $howItWork->title }}</p>
            </div>
            <div class="btn-group">
                <a href="{{ route('admin.how-it-works.show', $howItWork) }}" class="btn btn-info">
                    <i class="fas fa-eye me-2"></i>View Step
                </a>
                <a href="{{ route('admin.how-it-works.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Steps
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form action="{{ route('admin.how-it-works.update', $howItWork) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Step Title <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" value="{{ old('title', $howItWork->title) }}"
                                            placeholder="Enter step title" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="step_number" class="form-label">Step Number <span
                                                class="text-danger">*</span></label>
                                        <input type="number"
                                            class="form-control @error('step_number') is-invalid @enderror" id="step_number"
                                            name="step_number" value="{{ old('step_number', $howItWork->step_number) }}"
                                            min="1" required>
                                        @error('step_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror" id="status"
                                            name="status" required>
                                            <option value="active"
                                                {{ old('status', $howItWork->status) == 'active' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="inactive"
                                                {{ old('status', $howItWork->status) == 'inactive' ? 'selected' : '' }}>
                                                Inactive</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="4" placeholder="Describe this step of the process" required>{{ old('description', $howItWork->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="icon" class="form-label">FontAwesome Icon Class</label>
                                        <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                            id="icon" name="icon" value="{{ old('icon', $howItWork->icon) }}"
                                            placeholder="e.g., fas fa-cog, fas fa-user, fas fa-check-circle">
                                        @error('icon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            Visit <a href="https://fontawesome.com/icons" target="_blank">FontAwesome</a>
                                            for icon classes
                                        </div>
                                        @if ($howItWork->icon)
                                            <div class="mt-2">
                                                <i class="{{ $howItWork->icon }} fa-2x text-primary"></i>
                                                <span class="ms-2 text-muted">Current Icon</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Step Image</label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                                            id="image" name="image" accept="image/*">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            Upload a new image to replace the current one (JPG, PNG, GIF - Max: 2MB)
                                        </div>
                                        @if ($howItWork->image)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $howItWork->image) }}"
                                                    alt="{{ $howItWork->title }}" class="img-thumbnail"
                                                    style="max-width: 150px; max-height: 150px;">
                                                <div class="text-muted small mt-1">Current Image</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.how-it-works.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Step
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-info-circle me-2"></i>Step Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="text-primary">Current Status</h6>
                            <p class="small text-muted mb-2">
                                This step is currently
                                @if ($howItWork->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </p>
                        </div>

                        <div class="mb-3">
                            <h6 class="text-primary">Step Ordering</h6>
                            <p class="small text-muted mb-0">
                                Currently step number {{ $howItWork->step_number }}. Steps are displayed in order by step
                                number.
                            </p>
                        </div>

                        <div class="mb-3">
                            <h6 class="text-primary">Media Updates</h6>
                            <p class="small text-muted mb-0">
                                Uploading a new image will replace the current one. Leave empty to keep existing media.
                            </p>
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Note:</strong> Changes will be visible on the frontend immediately after saving.
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-bolt me-2"></i>Quick Actions
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.how-it-works.show', $howItWork) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye me-2"></i>Preview Step
                            </a>
                            <form action="{{ route('admin.how-it-works.destroy', $howItWork) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this step? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm w-100">
                                    <i class="fas fa-trash me-2"></i>Delete Step
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Preview icon when typing
        document.getElementById('icon').addEventListener('input', function() {
            const iconClass = this.value;
            const preview = document.getElementById('icon-preview');

            if (!preview) {
                const previewDiv = document.createElement('div');
                previewDiv.id = 'icon-preview';
                previewDiv.className = 'mt-2';
                this.parentNode.appendChild(previewDiv);
            }

            const previewElement = document.getElementById('icon-preview');
            if (iconClass) {
                previewElement.innerHTML =
                    `<i class="${iconClass} fa-2x text-primary"></i> <span class="ms-2 text-muted">New Preview</span>`;
            } else {
                previewElement.innerHTML = '';
            }
        });

        // Preview image when selected
        document.getElementById('image').addEventListener('change', function() {
            const file = this.files[0];
            const preview = document.getElementById('image-preview');

            if (!preview) {
                const previewDiv = document.createElement('div');
                previewDiv.id = 'image-preview';
                previewDiv.className = 'mt-2';
                this.parentNode.appendChild(previewDiv);
            }

            const previewElement = document.getElementById('image-preview');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewElement.innerHTML = `
                <img src="${e.target.result}" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                <div class="text-muted small mt-1">New Preview</div>
            `;
                };
                reader.readAsDataURL(file);
            } else {
                previewElement.innerHTML = '';
            }
        });
    </script>
@endsection
