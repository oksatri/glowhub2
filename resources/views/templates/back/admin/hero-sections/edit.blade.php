@extends('templates.back._parts.master')

@section('title', 'Edit Hero Section')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Edit Hero Section</h4>
                        <a href="{{ route('admin.hero-sections.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Hero Sections
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.hero-sections.update', $heroSection->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" value="{{ old('title', $heroSection->title) }}"
                                            required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="subtitle" class="form-label">Subtitle</label>
                                        <input type="text" class="form-control @error('subtitle') is-invalid @enderror"
                                            id="subtitle" name="subtitle"
                                            value="{{ old('subtitle', $heroSection->subtitle) }}">
                                        @error('subtitle')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                            rows="4">{{ old('description', $heroSection->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="button_text" class="form-label">Button Text</label>
                                                <input type="text"
                                                    class="form-control @error('button_text') is-invalid @enderror"
                                                    id="button_text" name="button_text"
                                                    value="{{ old('button_text', $heroSection->button_text) }}">
                                                @error('button_text')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="button_url" class="form-label">Button URL</label>
                                                <input type="url"
                                                    class="form-control @error('button_url') is-invalid @enderror"
                                                    id="button_url" name="button_url"
                                                    value="{{ old('button_url', $heroSection->button_url) }}">
                                                @error('button_url')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="background_image" class="form-label">Background Image</label>
                                        <input type="file"
                                            class="form-control @error('background_image') is-invalid @enderror"
                                            id="background_image" name="background_image" accept="image/*">
                                        @error('background_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if ($heroSection->background_image)
                                            <div class="mt-2">
                                                <small class="text-muted">Current image:</small><br>
                                                <img src="{{ Storage::url($heroSection->background_image) }}"
                                                    alt="Current Background" class="img-thumbnail"
                                                    style="max-width: 200px;">
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label for="sort_order" class="form-label">Sort Order</label>
                                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                            id="sort_order" name="sort_order"
                                            value="{{ old('sort_order', $heroSection->sort_order ?? 0) }}">
                                        @error('sort_order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                                value="1"
                                                {{ old('is_active', $heroSection->is_active) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">
                                                Active
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Hero Section
                                    </button>
                                    <a href="{{ route('admin.hero-sections.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
