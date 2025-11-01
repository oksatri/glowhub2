@extends('back._parts.master')
@section('page-title', 'Create Content')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1" style="color: #2D3748; font-weight:600;">Create Content</h1>
            <p class="text-muted small mb-0">Create a new content section for the front page — elegant and simple.</p>
        </div>
        <a href="{{ url('content-management') }}" class="btn px-3 py-2" style="background:white; border:1px solid #E5E7EB; color:#374151;">
            <i class="fas fa-arrow-left me-2"></i>Back to list
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body px-4 py-4">
            <form action="{{ url('content-management') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row gx-4">
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title"
                                class="form-control form-control-lg {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                placeholder="Section title" value="{{ old('title') }}" required>
                            @if ($errors->has('title'))
                                <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="6" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                                placeholder="Short description or HTML (light)">{{ old('description') }}</textarea>
                            @if ($errors->has('description'))
                                <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                            @endif
                        </div>

                        <div class="row gx-2">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Section Type</label>
                                <select name="section_type"
                                    class="form-select {{ $errors->has('section_type') ? 'is-invalid' : '' }}">
                                    <option value="content" {{ old('section_type') == 'content' ? 'selected' : '' }}>
                                        Content</option>
                                    <option value="product" {{ old('section_type') == 'product' ? 'selected' : '' }}>
                                        Product</option>
                                    <option value="testimonials"
                                        {{ old('section_type') == 'testimonials' ? 'selected' : '' }}>Testimonials</option>
                                    <option value="contact" {{ old('section_type') == 'contact' ? 'selected' : '' }}>
                                        Contact</option>
                                    <option value="hero" {{ old('section_type') == 'hero' ? 'selected' : '' }}>Hero
                                    </option>
                                </select>
                                @if ($errors->has('section_type'))
                                    <div class="invalid-feedback d-block">{{ $errors->first('section_type') }}</div>
                                @endif
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status"
                                    class="form-select {{ $errors->has('status') ? 'is-invalid' : '' }}">
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="publish" {{ old('status') == 'publish' ? 'selected' : '' }}>Publish
                                    </option>
                                    <option value="archive" {{ old('status') == 'archive' ? 'selected' : '' }}>Archive
                                    </option>
                                </select>
                                @if ($errors->has('status'))
                                    <div class="invalid-feedback d-block">{{ $errors->first('status') }}</div>
                                @endif
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Order</label>
                                <input type="number" name="order"
                                    class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}"
                                    value="{{ old('order', 0) }}">
                                @if ($errors->has('order'))
                                    <div class="invalid-feedback">{{ $errors->first('order') }}</div>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="has_button" name="has_button" value="1"
                                {{ old('has_button') ? 'checked' : '' }}>
                            <label class="form-check-label" for="has_button">Include buttons (CTA)</label>
                        </div>

                        <div id="buttons-area" style="display: {{ old('has_button') ? 'block' : 'none' }};">
                            <div class="mb-3 d-flex gap-2 align-items-center">
                                <label class="form-label mb-0">Buttons count</label>
                                <input type="number" id="buttons_count" name="buttons_count"
                                    class="form-control w-auto ms-2 {{ $errors->has('buttons_count') ? 'is-invalid' : '' }}"
                                    value="{{ old('buttons_count', 0) }}" min="0">
                                <button type="button" id="generate-buttons"
                                    class="btn btn-sm btn-outline-primary ms-2">Generate</button>
                                @if ($errors->has('buttons_count'))
                                    <div class="invalid-feedback d-block ms-3">{{ $errors->first('buttons_count') }}</div>
                                @endif
                            </div>

                            <div id="buttons-list" class="mb-3">
                                <!-- dynamic button inputs will be injected here -->
                                @if (old('buttons'))
                                    @foreach (old('buttons') as $i => $b)
                                        <div class="row g-2 align-items-center mb-2 button-row">
                                            <div class="col-md-5">
                                                <input type="text" name="buttons[{{ $i }}][label]"
                                                    class="form-control {{ $errors->has("buttons.$i.label") ? 'is-invalid' : '' }}"
                                                    placeholder="Label" value="{{ $b['label'] ?? '' }}">
                                                @if ($errors->has("buttons.$i.label"))
                                                    <div class="invalid-feedback">{{ $errors->first("buttons.$i.label") }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="buttons[{{ $i }}][url]"
                                                    class="form-control {{ $errors->has("buttons.$i.url") ? 'is-invalid' : '' }}"
                                                    placeholder="URL" value="{{ $b['url'] ?? '' }}">
                                                @if ($errors->has("buttons.$i.url"))
                                                    <div class="invalid-feedback">{{ $errors->first("buttons.$i.url") }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-1 text-end">
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger remove-button">×</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                @if ($errors->has('buttons'))
                                    <div class="text-danger small mt-2">{{ $errors->first('buttons') }}</div>
                                @endif
                            </div>
                        </div>

                        <!-- Content Details: shown only when section_type == content -->
                        <div id="details-area" style="display: {{ old('section_type') == 'content' ? 'block' : 'none' }};">
                            <hr>
                            <h5>Section Details</h5>
                            <p class="text-muted small">Add one or more detail rows for this content section. For category
                                "about" you'll provide an image instead of an icon and may add additional JSON/text.</p>

                            <div class="mb-3 d-flex gap-2 align-items-center">
                                <button type="button" id="add-detail" class="btn btn-sm btn-outline-primary">Add
                                    Detail</button>
                            </div>

                            <div id="details-list">
                                @if (old('details'))
                                    @foreach (old('details') as $i => $det)
                                        <div class="card mb-2 detail-row">
                                            <div class="card-header d-flex justify-content-between align-items-center p-2">
                                                <div>
                                                    <strong class="detail-title">{{ $det['title'] ?? 'Detail' }}</strong>
                                                    <small class="text-muted ms-2">({{ $det['category'] ?? 'feature' }})</small>
                                                </div>
                                                <div>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary me-1 toggle-detail">Toggle</button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger remove-detail">×</button>
                                                </div>
                                            </div>
                                            <div class="card-body p-3 detail-body">
                                                <div class="row g-2 align-items-start">
                                                    <div class="col-md-3">
                                                        <label class="form-label small">Category</label>
                                                        <select name="details[{{ $i }}][category]" class="form-select detail-category">
                                                            <option value="about" {{ isset($det['category']) && $det['category'] == 'about' ? 'selected' : '' }}>About</option>
                                                            <option value="feature" {{ isset($det['category']) && $det['category'] == 'feature' ? 'selected' : '' }}>Feature</option>
                                                            <option value="team" {{ isset($det['category']) && $det['category'] == 'team' ? 'selected' : '' }}>Team</option>
                                                            <option value="faq" {{ isset($det['category']) && $det['category'] == 'faq' ? 'selected' : '' }}>FAQ</option>
                                                            <option value="custom" {{ isset($det['category']) && $det['category'] == 'custom' ? 'selected' : '' }}>Custom</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3 detail-icon-col">
                                                        <label class="form-label small">Icon (font class)</label>
                                                        <input type="text" name="details[{{ $i }}][icon]" class="form-control" value="{{ $det['icon'] ?? '' }}" placeholder="e.g. fa fa-star">
                                                    </div>

                                                    <div class="col-md-4 detail-image-col" style="display: none;">
                                                        <label class="form-label small">Image (for About)</label>
                                                        <input type="file" name="details[{{ $i }}][image]" class="form-control">
                                                    </div>

                                                    <div class="col-md-6 mt-2">
                                                        <label class="form-label small">Title</label>
                                                        <input type="text" name="details[{{ $i }}][title]" class="form-control" value="{{ $det['title'] ?? '' }}">
                                                    </div>

                                                    <div class="col-md-6 mt-2">
                                                        <label class="form-label small">Order</label>
                                                        <input type="number" name="details[{{ $i }}][order]" class="form-control" value="{{ $det['order'] ?? 0 }}">
                                                    </div>

                                                    <div class="col-12 mt-2">
                                                        <label class="form-label small">Description</label>
                                                        <textarea name="details[{{ $i }}][description]" rows="2" class="form-control">{{ $det['description'] ?? '' }}</textarea>
                                                    </div>

                                                    <div class="col-12 mt-2 detail-additional-col" style="display: none;">
                                                        <label class="form-label small">Additional (JSON or text)</label>
                                                        <textarea name="details[{{ $i }}][additional]" rows="2" class="form-control">{{ $det['additional'] ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            @if ($errors->has('details'))
                                <div class="text-danger small mt-2">{{ $errors->first('details') }}</div>
                            @endif
                        </div>

                        <div class="mt-4 d-flex align-items-center gap-2">
                            <button class="btn px-4 py-2 rounded-pill text-white" style="background: linear-gradient(135deg,#667EEA 0%,#764BA2 100%); border:none;">Create Content</button>
                            <a href="{{ url('content-management') }}" class="btn" style="background:transparent; color:#6B7280;">Cancel</a>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title" style="color:#111827; font-weight:600;">Image / Media</h6>
                                <p class="text-muted small">Upload an image that represents this section. Ideal size depends on your layout.</p>
                                <div class="mb-3">
                                    <input type="file" name="image" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}">
                                    @if ($errors->has('image'))
                                        <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                                    @endif
                                </div>

                                <hr>

                                <h6 class="card-title" style="color:#111827; font-weight:600;">Meta & Settings</h6>
                                <div class="mb-3">
                                    <label class="form-label small">Slug (optional)</label>
                                    <input type="text" name="slug" class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" value="{{ old('slug') }}" placeholder="auto-generated from title">
                                    @if ($errors->has('slug'))
                                        <div class="invalid-feedback">{{ $errors->first('slug') }}</div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small">Excerpt (for SEO)</label>
                                    <textarea name="excerpt" rows="3" class="form-control {{ $errors->has('excerpt') ? 'is-invalid' : '' }}">{{ old('excerpt') }}</textarea>
                                    @if ($errors->has('excerpt'))
                                        <div class="invalid-feedback">{{ $errors->first('excerpt') }}</div>
                                    @endif
                                </div>

                                <div class="mb-3 text-muted small">
                                    <strong>Tip:</strong> Use buttons to add primary actions. Keep descriptions concise for best results.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            (function() {
                // Buttons area
                const hasButtonEl = document.getElementById('has_button');
                const buttonsArea = document.getElementById('buttons-area');
                const generateBtn = document.getElementById('generate-buttons');
                const buttonsCountEl = document.getElementById('buttons_count');
                const buttonsList = document.getElementById('buttons-list');

                if (hasButtonEl) {
                    hasButtonEl.addEventListener('change', function() {
                        buttonsArea.style.display = this.checked ? 'block' : 'none';
                    });
                }

                function createButtonRow(idx, label = '', url = '') {
                    const row = document.createElement('div');
                    row.className = 'row g-2 align-items-center mb-2 button-row';
                    row.innerHTML = `
                    <div class="col-md-5">
                        <input type="text" name="buttons[${idx}][label]" class="form-control" placeholder="Label" value="${label}">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="buttons[${idx}][url]" class="form-control" placeholder="URL" value="${url}">
                    </div>
                    <div class="col-md-1 text-end">
                        <button type="button" class="btn btn-sm btn-outline-danger remove-button">×</button>
                    </div>
                `;
                    return row;
                }

                generateBtn && generateBtn.addEventListener('click', function() {
                    const count = parseInt(buttonsCountEl.value) || 0;
                    buttonsList.innerHTML = '';
                    for (let i = 0; i < count; i++) {
                        buttonsList.appendChild(createButtonRow(i));
                    }
                });

                // delegate remove for buttons
                buttonsList && buttonsList.addEventListener('click', function(e) {
                    if (e.target && e.target.classList.contains('remove-button')) {
                        e.target.closest('.button-row').remove();
                    }
                });

                // -- Details area handling --
                const sectionTypeEl = document.querySelector('select[name="section_type"]');
                const detailsArea = document.getElementById('details-area');
                const addDetailBtn = document.getElementById('add-detail');
                const detailsList = document.getElementById('details-list');

                // show/hide details area when section type changes
                if (sectionTypeEl) {
                    sectionTypeEl.addEventListener('change', function() {
                        detailsArea.style.display = this.value === 'content' ? 'block' : 'none';
                    });
                }

                let detailIndex = (function() {
                    // compute starting index based on existing rows
                    const rows = detailsList ? detailsList.querySelectorAll('.detail-row') : [];
                    return rows.length;
                })();

                function makeDetailRow(idx, values = {}) {
                    const category = values.category || 'feature';
                    const title = values.title || '';
                    const desc = values.description || '';
                    const icon = values.icon || '';
                    const order = values.order || 0;
                    const additional = values.additional || '';

                    const wrapper = document.createElement('div');
                    wrapper.className = 'card mb-2 detail-row';
                    wrapper.innerHTML = `
                        <div class="card-header d-flex justify-content-between align-items-center p-2">
                            <div>
                                <strong class="detail-title">${title || 'Detail'}</strong>
                                <small class="text-muted ms-2">(${category})</small>
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-secondary me-1 toggle-detail">Toggle</button>
                                <button type="button" class="btn btn-sm btn-outline-danger remove-detail">×</button>
                            </div>
                        </div>
                        <div class="card-body p-3 detail-body">
                            <div class="row g-2 align-items-start">
                                <div class="col-md-3">
                                    <label class="form-label small">Category</label>
                                    <select name="details[${idx}][category]" class="form-select detail-category">
                                        <option value="about" ${category==='about'? 'selected':''}>About</option>
                                        <option value="feature" ${category==='feature'? 'selected':''}>Feature</option>
                                        <option value="team" ${category==='team'? 'selected':''}>Team</option>
                                        <option value="faq" ${category==='faq'? 'selected':''}>FAQ</option>
                                        <option value="custom" ${category==='custom'? 'selected':''}>Custom</option>
                                    </select>
                                </div>

                                <div class="col-md-3 detail-icon-col">
                                    <label class="form-label small">Icon (font class)</label>
                                    <input type="text" name="details[${idx}][icon]" class="form-control" value="${icon}" placeholder="e.g. fa fa-star">
                                </div>

                                <div class="col-md-4 detail-image-col" style="display: none;">
                                    <label class="form-label small">Image (for About)</label>
                                    <input type="file" name="details[${idx}][image]" class="form-control">
                                </div>

                                <div class="col-md-6 mt-2">
                                    <label class="form-label small">Title</label>
                                    <input type="text" name="details[${idx}][title]" class="form-control" value="${title}">
                                </div>

                                <div class="col-md-6 mt-2">
                                    <label class="form-label small">Order</label>
                                    <input type="number" name="details[${idx}][order]" class="form-control" value="${order}">
                                </div>

                                <div class="col-12 mt-2">
                                    <label class="form-label small">Description</label>
                                    <textarea name="details[${idx}][description]" rows="2" class="form-control">${desc}</textarea>
                                </div>

                                <div class="col-12 mt-2 detail-additional-col" style="display: none;">
                                    <label class="form-label small">Additional (JSON or text)</label>
                                    <textarea name="details[${idx}][additional]" rows="2" class="form-control">${additional}</textarea>
                                </div>
                            </div>
                        </div>
                    `;

                    toggleDetailFields(wrapper, category);
                    return wrapper;
                }

                function toggleDetailFields(cardEl, category) {
                    const iconCol = cardEl.querySelector('.detail-icon-col');
                    const imgCol = cardEl.querySelector('.detail-image-col');
                    const addCol = cardEl.querySelector('.detail-additional-col');

                    if (category === 'about') {
                        if (iconCol) iconCol.style.display = 'none';
                        if (imgCol) imgCol.style.display = 'block';
                        if (addCol) addCol.style.display = 'block';
                    } else {
                        if (iconCol) iconCol.style.display = 'block';
                        if (imgCol) imgCol.style.display = 'none';
                        if (addCol) addCol.style.display = 'none';
                    }
                }

                // Add detail
                addDetailBtn && addDetailBtn.addEventListener('click', function() {
                    const row = makeDetailRow(detailIndex++);
                    detailsList.appendChild(row);
                });

                // Delegate events: remove, category change, toggle
                detailsList && detailsList.addEventListener('click', function(e) {
                    if (e.target && e.target.classList.contains('remove-detail')) {
                        const card = e.target.closest('.detail-row');
                        card && card.remove();
                    }

                    if (e.target && e.target.classList.contains('toggle-detail')) {
                        const card = e.target.closest('.detail-row');
                        if (!card) return;
                        const body = card.querySelector('.detail-body');
                        if (!body) return;
                        body.style.display = body.style.display === 'none' ? 'block' : 'none';
                    }
                });

                detailsList && detailsList.addEventListener('change', function(e) {
                    const target = e.target;
                    if (target && target.classList && target.classList.contains('detail-category')) {
                        const card = target.closest('.detail-row');
                        toggleDetailFields(card, target.value);
                    }
                });

                // On initial load, ensure existing rows have correct icon/image visibility
                (function initExistingDetailRows() {
                    if (!detailsList) return;
                    const rows = detailsList.querySelectorAll('.detail-row');
                    rows.forEach(function(row, idx) {
                        const sel = row.querySelector('.detail-category');
                        const category = sel ? sel.value : 'feature';
                        toggleDetailFields(row, category);
                    });
                })();
            })();
        </script>
    @endpush

@endsection
