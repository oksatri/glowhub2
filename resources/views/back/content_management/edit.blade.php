@extends('back._parts.master')
@section('page-title', 'Edit Content')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1" style="color: #2D3748; font-weight:600;">Edit Content</h1>
            <p class="text-muted small mb-0">Update an existing content section — elegant and simple.</p>
        </div>
        <a href="{{ url('content-management') }}" class="btn px-3 py-2"
            style="background:white; border:1px solid #E5E7EB; color:#374151;">
            <i class="fas fa-arrow-left me-2"></i>Back to list
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body px-4 py-4">
            @if (session('error'))
                <div class="alert alert-danger">
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
                            })();
                        </script>
                    @endpush


                @endsection

                <div class="mb-3">
                    <label class="form-label small">Excerpt (for SEO)</label>
                    <textarea name="excerpt" rows="3" class="form-control {{ $errors->has('excerpt') ? 'is-invalid' : '' }}">{{ old('excerpt', '') }}</textarea>
                    @if ($errors->has('excerpt'))
                        <div class="invalid-feedback">{{ $errors->first('excerpt') }}</div>
                    @endif
                </div>

                <div class="mb-3 text-muted small">
                    <strong>Tip:</strong> Use buttons to add primary actions. Keep descriptions concise for best
                    results.
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
                buttonsList && buttonsList.addEventListener('click', function(e) {})();
    </script>
@endpush


@endsection
</script>
@endpush

@endsection
