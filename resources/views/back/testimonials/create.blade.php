@extends('back._parts.master')
@section('page-title', 'Create Testimonial')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">Create Testimonial</h1>
            <p class="text-muted small mb-0">Add a testimonial entry (this form follows the content-management style).</p>
        </div>
        <a href="{{ url('testimonials') }}" class="btn px-3 py-2"
            style="background:white; border:1px solid #E5E7EB; color:#374151;">Back to list</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body px-4 py-4">
            <form action="{{ url('testimonials') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @include('back.testimonials._form', [
                    'testimonial' => null,
                    'submitLabel' => 'Create Testimonial',
                ])
            </form>
        </div>
    </div>
@endsection
@extends('back._parts.master')
@section('page-title', 'Create Testimonial')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        @extends('back._parts.master')
    @section('page-title', 'Create Testimonial')
    @section('content')
        <a href="{{ url('testimonials') }}" class="btn px-3 py-2"
            style="background:white; border:1px solid #E5E7EB; color:#374151;">Back to list</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body px-4 py-4">
            <form action="{{ url('testimonials') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row gx-4">
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name"
                                class="form-control form-control-lg {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                placeholder="Person name" value="{{ old('name') }}" required>
                            @if ($errors->has('name'))
                                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label">Role / Title</label>
                                <input type="text" name="role"
                                    class="form-control {{ $errors->has('role') ? 'is-invalid' : '' }}"
                                    placeholder="e.g. Bride, Corporate Event" value="{{ old('role') }}">
                            </div>

                            <div class="row gx-2">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Rating</label>
                                    <input type="number" name="rating" min="1" max="5"
                                        class="form-control {{ $errors->has('rating') ? 'is-invalid' : '' }}"
                                        value="{{ old('rating', 5) }}">
                                    @if ($errors->has('rating'))
                                        <div class="invalid-feedback">{{ $errors->first('rating') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status"
                                        class="form-select {{ $errors->has('status') ? 'is-invalid' : '' }}">
                                        <option value="publish" {{ old('status') == 'publish' ? 'selected' : '' }}>Publish
                                        </option>
                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft
                                        </option>
                                        <option value="archive" {{ old('status') == 'archive' ? 'selected' : '' }}>Archive
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Order</label>
                                    <input type="number" name="order" class="form-control"
                                        value="{{ old('order', 0) }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Quote / Testimonial</label>
                                <textarea name="quote" rows="4" class="form-control {{ $errors->has('quote') ? 'is-invalid' : '' }}"
                                    placeholder="The testimonial text...">{{ old('quote') }}</textarea>
                                @if ($errors->has('quote'))
                                    <div class="invalid-feedback">{{ $errors->first('quote') }}</div>
                                @endif
                            </div>

                            <div class="mt-4 d-flex align-items-center gap-2">
                                <button class="btn px-4 py-2 rounded-pill text-white"
                                    style="background: linear-gradient(135deg,#667EEA 0%,#764BA2 100%); border:none;">Create
                                    Testimonial</button>
                                <a href="{{ url('testimonials') }}" class="btn"
                                    style="background:transparent; color:#6B7280;">Cancel</a>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="card-title" style="color:#111827; font-weight:600;">Image / Avatar</h6>
                                    <p class="text-muted small">Upload an avatar or image for this testimonial (optional).
                                    </p>
                                    <div class="mb-3">
                                        <input type="file" name="image"
                                            class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}">
                                        @if ($errors->has('image'))
                                            <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                                        @endif
                                    </div>

                                    <hr>

                                    <h6 class="card-title" style="color:#111827; font-weight:600;">Meta</h6>
                                    <div class="mb-3">
                                        <label class="form-label small">Slug (optional)</label>
                                        <input type="text" name="slug" class="form-control"
                                            placeholder="(optional) not required">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label small">Short excerpt</label>
                                        <textarea name="excerpt" rows="2" class="form-control"></textarea>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
@endsection
