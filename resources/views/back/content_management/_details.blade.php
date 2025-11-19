<div id="details-area"
    style="display: {{ old('section_type', $content->section_type ?? '') == 'content' ? 'block' : 'none' }};">
    <hr>
    <h5>Section Details</h5>
    <p class="text-muted small">Add one or more detail rows for this content section. For category
        "about" you'll provide an image instead of an icon and may add additional JSON/text.</p>

    <div class="mb-3 d-flex gap-2 align-items-center">
        <button type="button" id="add-detail" class="btn btn-sm btn-outline-primary">Add
            Detail</button>
    </div>

    <div id="details-list">
        @php
            $existing = old('details');
            if (empty($existing)) {
                // fallback to model details when editing
                $existing = isset($content) && $content && isset($content->details) ? $content->details->toArray() : [];
            }
        @endphp

        @if ($existing)
            @foreach ($existing as $i => $det)
                <div class="card mb-2 detail-row">
                    @if (is_array($det) && isset($det['id']))
                        <input type="hidden" name="details[{{ $i }}][id]" value="{{ $det['id'] ?? '' }}">
                    @endif
                    <div class="card-header d-flex justify-content-between align-items-center p-2">
                        <div>
                            <strong class="detail-title">{{ $det['title'] ?? 'Detail' }}</strong>
                            <small class="text-muted ms-2">({{ $det['category'] ?? 'feature' }})</small>
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm btn-outline-secondary me-1 toggle-detail"><i
                                    class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-detail"><i
                                    class="fas fa-trash"></i></button>
                        </div>
                    </div>
                    <div class="card-body p-3 detail-body">
                        <div class="row g-2 align-items-start">
                            <div class="col-md-3">
                                <label class="form-label small">Category</label>
                                <select name="details[{{ $i }}][category]"
                                    class="form-select detail-category">
                                    <option value="about"
                                        {{ isset($det['category']) && $det['category'] == 'about' ? 'selected' : '' }}>
                                        About</option>
                                    <option value="feature"
                                        {{ isset($det['category']) && $det['category'] == 'feature' ? 'selected' : '' }}>
                                        Feature</option>
                                </select>
                            </div>

                            <div class="col-md-3 detail-icon-col">
                                <label class="form-label small">Icon (font class)</label>
                                <input type="text" name="details[{{ $i }}][icon]" class="form-control"
                                    value="{{ $det['icon'] ?? '' }}" placeholder="e.g. fa fa-star">
                            </div>

                            <div class="col-md-4 detail-image-col" style="display: none;">
                                <label class="form-label small">Image (for About)</label>
                                <input type="file" name="details[{{ $i }}][image]" class="form-control">
                                @if (!empty($det['image']))
                                    <div class="small mt-1">
                                        <span>Preview:</span><br>
                                        <img src="{{ asset('uploads/' . $det['image']) }}" alt="Image Preview"
                                            style="max-width: 120px; max-height: 80px;">
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="form-label small">Title</label>
                                <input type="text" name="details[{{ $i }}][title]" class="form-control"
                                    value="{{ $det['title'] ?? '' }}">
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="form-label small">Order</label>
                                <input type="number" name="details[{{ $i }}][order]" class="form-control"
                                    value="{{ $det['order'] ?? 0 }}">
                            </div>

                            <div class="col-12 mt-2">
                                <label class="form-label small">Description</label>
                                <textarea name="details[{{ $i }}][description]" rows="2" class="form-control">{{ $det['description'] ?? '' }}</textarea>
                            </div>

                            <div class="col-12 mt-2 detail-additional-col" style="display: none;">
                                <label class="form-label small">Additional (JSON or text)</label>
                                <textarea name="details[{{ $i }}][additional]" rows="2" class="form-control">{{ is_array($det['additional'] ?? null) ? json_encode($det['additional']) : $det['additional'] ?? '' }}</textarea>
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

@push('scripts')
    <script>
        (function() {
            const sectionTypeEl = document.querySelector('select[name="section_type"]');
            const detailsArea = document.getElementById('details-area');
            const addDetailBtn = document.getElementById('add-detail');
            const detailsList = document.getElementById('details-list');

            // show/hide details area when section type changes
            if (sectionTypeEl) {
                sectionTypeEl.addEventListener('change', function() {
                    if (!detailsArea) return;
                    detailsArea.style.display = this.value === 'content' ? 'block' : 'none';
                });
            }

            let detailIndex = (function() {
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
                                <button type="button" class="btn btn-sm btn-outline-secondary me-1 toggle-detail"><i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-danger remove-detail"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                        <div class="card-body p-3 detail-body">
                            <div class="row g-2 align-items-start">
                                <div class="col-md-3">
                                    <label class="form-label small">Category</label>
                                    <select name="details[${idx}][category]" class="form-select detail-category">
                                        <option value="about" ${category==='about'? 'selected':''}>About</option>
                                        <option value="feature" ${category==='feature'? 'selected':''}>Feature</option>
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
</div>
