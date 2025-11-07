@extends('back._parts.master')
@section('page-title', 'Create Content')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1" style="color: #2D3748; font-weight:600;">Create Content</h1>
            <p class="text-muted small mb-0">Create a new content section for the front page — elegant and simple.</p>
        </div>
        <a href="{{ url('content-management') }}" class="btn px-3 py-2"
            style="background:white; border:1px solid #E5E7EB; color:#374151;">
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

                @include('back.content_management._form')
                <!-- Content Details: extracted to partial -->
                @include('back.content_management._details', ['content' => null])

                <div class="mt-4 d-flex align-items-center gap-2">
                    <button class="btn px-4 py-2 rounded-pill text-white"
                        style="background: linear-gradient(135deg,#667EEA 0%,#764BA2 100%); border:none;">Create
                        Content</button>
                    <a href="{{ url('content-management') }}" class="btn"
                        style="background:transparent; color:#6B7280;">Cancel</a>
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
            })();
        </script>
    @endpush


@endsection
