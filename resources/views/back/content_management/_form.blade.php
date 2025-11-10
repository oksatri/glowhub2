<div class="row gx-4">
    <div class="col-lg-8">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title"
                class="form-control form-control-lg {{ $errors->has('title') ? 'is-invalid' : '' }}"
                placeholder="Section title" value="{{ old('title', $content->title ?? '') }}" required>
            @if ($errors->has('title'))
                <div class="invalid-feedback">{{ $errors->first('title') }}</div>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="6" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                placeholder="Short description or HTML (light)">{{ old('description', $content->description ?? '') }}</textarea>
            @if ($errors->has('description'))
                <div class="invalid-feedback">{{ $errors->first('description') }}</div>
            @endif
        </div>

        <div class="row gx-2">
            <div class="col-md-6 mb-3">
                <label class="form-label">Section Type</label>
                <select name="section_type" class="form-select {{ $errors->has('section_type') ? 'is-invalid' : '' }}">
                    <option value="">None</option>
                    @php $types = ['content','product','testimonials','contact','hero']; @endphp
                    @foreach ($types as $t)
                        <option value="{{ $t }}"
                            {{ old('section_type', $content->section_type ?? '') == $t ? 'selected' : '' }}>
                            {{ ucfirst($t) }}</option>
                    @endforeach
                </select>
                @if ($errors->has('section_type'))
                    <div class="invalid-feedback d-block">{{ $errors->first('section_type') }}</div>
                @endif
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select {{ $errors->has('status') ? 'is-invalid' : '' }}">
                    <option value="draft" {{ old('status', $content->status ?? '') == 'draft' ? 'selected' : '' }}>
                        Draft</option>
                    <option value="publish" {{ old('status', $content->status ?? '') == 'publish' ? 'selected' : '' }}>
                        Publish</option>
                    <option value="archive" {{ old('status', $content->status ?? '') == 'archive' ? 'selected' : '' }}>
                        Archive</option>
                </select>
                @if ($errors->has('status'))
                    <div class="invalid-feedback d-block">{{ $errors->first('status') }}</div>
                @endif
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Order</label>
                <input type="number" name="order"
                    class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}"
                    value="{{ old('order', $content->order ?? 0) }}">
                @if ($errors->has('order'))
                    <div class="invalid-feedback">{{ $errors->first('order') }}</div>
                @endif
            </div>
        </div>

        <hr>

        <div class="mb-3 form-check form-switch">
            <input class="form-check-input" type="checkbox" id="has_button" name="has_button" value="1"
                {{ old('has_button', $content->has_button ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="has_button">Include buttons (CTA)</label>
        </div>

        <div id="buttons-area"
            style="display: {{ old('has_button', $content->has_button ?? false) ? 'block' : 'none' }};">
            <div class="mb-3 d-flex gap-2 align-items-center">
                <label class="form-label mb-0">Buttons count</label>
                <input type="number" id="buttons_count" name="buttons_count" class="form-control w-auto ms-2"
                    value="{{ old('buttons_count', 0) }}" min="0">
                <button type="button" id="generate-buttons"
                    class="btn btn-sm btn-outline-primary ms-2">Generate</button>
            </div>

            <div id="buttons-list" class="mb-3">
                @if (old('buttons'))
                    @foreach (old('buttons') as $i => $b)
                        <div class="row g-2 align-items-center mb-2 button-row">
                            <div class="col-md-5">
                                <input type="text" name="buttons[{{ $i }}][label]" class="form-control"
                                    placeholder="Label" value="{{ $b['label'] ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="buttons[{{ $i }}][url]" class="form-control"
                                    placeholder="URL" value="{{ $b['url'] ?? '' }}">
                            </div>
                            <div class="col-md-1 text-end">
                                <button type="button" class="btn btn-sm btn-outline-danger remove-button">×</button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Details area kept inline in main view if needed -->
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="card-title" style="color:#111827; font-weight:600;">Meta & Image</h6>
                <p class="text-muted small">Upload image and optional metadata for this section.</p>

                <div class="mb-3">
                    <label class="form-label small">Image</label>
                    <input type="file" name="image"
                        class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}">
                    @if ($errors->has('image'))
                        <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                    @endif

                    @if (!empty($content->image))
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $content->image) }}" alt="Image Preview"
                                class="img-fluid rounded" style="max-height: 180px;">
                        </div>
                    @endif
                </div>

                <hr>

                <div class="mb-3">
                    <label class="form-label small">Slug (optional)</label>
                    <input type="text" name="slug" class="form-control"
                        value="{{ old('slug', $content->slug ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label small">Short excerpt</label>
                    <textarea name="excerpt" rows="2" class="form-control">{{ old('excerpt', $content->excerpt ?? '') }}</textarea>
                </div>

            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hasButton = document.getElementById('has_button');
            const buttonsArea = document.getElementById('buttons-area');
            const generateBtn = document.getElementById('generate-buttons');
            const buttonsCount = document.getElementById('buttons_count');
            const buttonsList = document.getElementById('buttons-list');

            if (hasButton) {
                hasButton.addEventListener('change', function() {
                    buttonsArea.style.display = this.checked ? 'block' : 'none';
                });
            }

            if (generateBtn) {
                generateBtn.addEventListener('click', function() {
                    const count = parseInt(buttonsCount.value) || 0;
                    buttonsList.innerHTML = '';
                    for (let i = 0; i < count; i++) {
                        const row = document.createElement('div');
                        row.className = 'row g-2 align-items-center mb-2 button-row';
                        row.innerHTML = `
                            <div class="col-md-5">
                                <input type="text" name="buttons[${i}][label]" class="form-control" placeholder="Label">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="buttons[${i}][url]" class="form-control" placeholder="URL">
                            </div>
                            <div class="col-md-1 text-end">
                                <button type="button" class="btn btn-sm btn-outline-danger remove-button">×</button>
                            </div>
                        `;
                        buttonsList.appendChild(row);
                    }
                });
            }

            // delegate remove button
            document.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-button')) {
                    const row = e.target.closest('.button-row');
                    if (row) row.remove();
                }
            });
        });
    </script>
@endpush
