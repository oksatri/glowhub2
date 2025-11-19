<div class="row gx-4">
    <div class="col-lg-8">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name"
                class="form-control form-control-lg {{ $errors->has('name') ? 'is-invalid' : '' }}"
                placeholder="Person name" value="{{ old('name', $testimonial->name ?? '') }}" required>
            @if ($errors->has('name'))
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Role / Title</label>
            <input type="text" name="role" class="form-control {{ $errors->has('role') ? 'is-invalid' : '' }}"
                placeholder="e.g. Bride, Corporate Event" value="{{ old('role', $testimonial->role ?? '') }}">
        </div>

        <div class="row gx-2">
            <div class="col-md-4 mb-3">
                <label class="form-label">Rating</label>
                <input type="number" name="rating" min="1" max="5"
                    class="form-control {{ $errors->has('rating') ? 'is-invalid' : '' }}"
                    value="{{ old('rating', $testimonial->rating ?? 5) }}">
                @if ($errors->has('rating'))
                    <div class="invalid-feedback">{{ $errors->first('rating') }}</div>
                @endif
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select {{ $errors->has('status') ? 'is-invalid' : '' }}">
                    <option value="publish"
                        {{ old('status', $testimonial->status ?? '') == 'publish' ? 'selected' : '' }}>Publish</option>
                    <option value="draft"
                        {{ old('status', $testimonial->status ?? '') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="archive"
                        {{ old('status', $testimonial->status ?? '') == 'archive' ? 'selected' : '' }}>Archive</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Order</label>
                <input type="number" name="order" class="form-control"
                    value="{{ old('order', $testimonial->order ?? 0) }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Quote / Testimonial</label>
            <textarea name="quote" rows="4" class="form-control {{ $errors->has('quote') ? 'is-invalid' : '' }}"
                placeholder="The testimonial text...">{{ old('quote', $testimonial->quote ?? '') }}</textarea>
            @if ($errors->has('quote'))
                <div class="invalid-feedback">{{ $errors->first('quote') }}</div>
            @endif
        </div>

        <div class="mt-4 d-flex align-items-center gap-2">
            <button class="btn px-4 py-2 rounded-pill text-white"
                style="background: linear-gradient(135deg,#667EEA 0%,#764BA2 100%); border:none;">
                {{ $submitLabel ?? 'Save' }}
            </button>
            <a href="{{ url('testimonials') }}" class="btn"
                style="background:transparent; color:#6B7280;">Cancel</a>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="card-title" style="color:#111827; font-weight:600;">Image / Avatar</h6>
                <p class="text-muted small">Upload an avatar or image for this testimonial (optional).</p>
                <div class="mb-3">
                    <input type="file" name="image"
                        class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}">
                    @if ($errors->has('image'))
                        <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                    @endif
                    @if (!empty($testimonial->image))
                        <div class="mt-2"><img src="{{ asset('uploads/' . $testimonial->image) }}" width="120"
                                alt=""></div>
                    @endif
                </div>

                <hr>

                <h6 class="card-title" style="color:#111827; font-weight:600;">Meta</h6>
                <div class="mb-3">
                    <label class="form-label small">Slug (optional)</label>
                    <input type="text" name="slug" class="form-control"
                        value="{{ old('slug', $testimonial->slug ?? '') }}" placeholder="(optional) not required">
                </div>

                <div class="mb-3">
                    <label class="form-label small">Short excerpt</label>
                    <textarea name="excerpt" rows="2" class="form-control">{{ old('excerpt', $testimonial->excerpt ?? '') }}</textarea>
                </div>

            </div>
        </div>
    </div>
</div>
