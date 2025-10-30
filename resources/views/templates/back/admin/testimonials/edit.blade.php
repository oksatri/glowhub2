@extends('templates.back._parts.master')

@section('title', 'Edit Testimonial')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Edit Testimonial</h4>
                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Testimonials
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="client_name" class="form-label">Client Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('client_name') is-invalid @enderror"
                                                    id="client_name" name="client_name"
                                                    value="{{ old('client_name', $testimonial->client_name) }}" required>
                                                @error('client_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="client_position" class="form-label">Client Position</label>
                                                <input type="text"
                                                    class="form-control @error('client_position') is-invalid @enderror"
                                                    id="client_position" name="client_position"
                                                    value="{{ old('client_position', $testimonial->client_position) }}">
                                                @error('client_position')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="testimonial_text" class="form-label">Testimonial Text <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control @error('testimonial_text') is-invalid @enderror" id="testimonial_text"
                                            name="testimonial_text" rows="5" required>{{ old('testimonial_text', $testimonial->testimonial_text) }}</textarea>
                                        @error('testimonial_text')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="rating" class="form-label">Rating</label>
                                        <select class="form-select @error('rating') is-invalid @enderror" id="rating"
                                            name="rating">
                                            <option value="">Select Rating</option>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <option value="{{ $i }}"
                                                    {{ old('rating', $testimonial->rating) == $i ? 'selected' : '' }}>
                                                    {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('rating')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="client_photo" class="form-label">Client Photo</label>
                                        <input type="file"
                                            class="form-control @error('client_photo') is-invalid @enderror"
                                            id="client_photo" name="client_photo" accept="image/*">
                                        @error('client_photo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if ($testimonial->client_photo)
                                            <div class="mt-2">
                                                <small class="text-muted">Current photo:</small><br>
                                                <img src="{{ Storage::url($testimonial->client_photo) }}"
                                                    alt="Current Photo" class="img-thumbnail" style="max-width: 150px;">
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label for="sort_order" class="form-label">Sort Order</label>
                                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                            id="sort_order" name="sort_order"
                                            value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}">
                                        @error('sort_order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_featured"
                                                name="is_featured" value="1"
                                                {{ old('is_featured', $testimonial->is_featured) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_featured">
                                                Featured Testimonial
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                                value="1"
                                                {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}>
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
                                        <i class="fas fa-save"></i> Update Testimonial
                                    </button>
                                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">
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

@push('styles')
    <style>
        .img-thumbnail {
            border-radius: 50%;
        }
    </style>
@endpush
