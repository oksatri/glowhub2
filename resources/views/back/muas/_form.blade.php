<div class="row gx-4">
    <div class="col-lg-8">
        <div class="mb-3">
            <label class="form-label">MUA Name</label>
            <input type="text" name="name"
                class="form-control form-control-lg {{ $errors->has('name') ? 'is-invalid' : '' }}"
                placeholder="Makeup Artist name" value="{{ old('name', $mua->name ?? '') }}" required>
            @if ($errors->has('name'))
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="6" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                placeholder="Short description about the MUA">{{ old('description', $mua->description ?? '') }}</textarea>
            @if ($errors->has('description'))
                <div class="invalid-feedback">{{ $errors->first('description') }}</div>
            @endif
        </div>

        <div class="row gx-2">
            <div class="col-md-6 mb-3">
                <label class="form-label">City / Regency</label>
                <select name="city" id="citySelect"
                    class="form-select {{ $errors->has('city') ? 'is-invalid' : '' }}">
                    <option value="">Select City / Regency</option>
                    @foreach ($filterOptions['cities'] ?? [] as $c)
                        <option value="{{ $c['id'] }}"
                            {{ old('city', $mua->city ?? '') == $c['id'] ? 'selected' : '' }}>
                            {{ $c['name'] }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('city'))
                    <div class="invalid-feedback d-block">{{ $errors->first('city') }}</div>
                @endif
            </div>

            <div class="col-md-6 mb-3"></div>
        </div>

        <div class="mb-3">
            <label class="form-label">Specialty</label>
            <input list="specialties" name="specialty"
                class="form-control {{ $errors->has('specialty') ? 'is-invalid' : '' }}"
                value="{{ old('specialty', $mua->specialty ?? '') }}" placeholder="e.g. bridal, editorial">
            <datalist id="specialties">
                @foreach ($specialties ?? [] as $s)
                    <option value="{{ $s }}"></option>
                @endforeach
            </datalist>
            <small class="form-text text-muted">Choose existing specialty or type a new one.</small>
            @if ($errors->has('specialty'))
                <div class="invalid-feedback">{{ $errors->first('specialty') }}</div>
            @endif
        </div>

        <div class="row gx-2">
            <div class="col-md-12 mb-3">
                <label class="form-label">Experience</label>
                <input type="text" name="experience"
                    class="form-control {{ $errors->has('experience') ? 'is-invalid' : '' }}"
                    value="{{ old('experience', $mua->experience ?? '') }}" placeholder="e.g. 3+ years">
                @if ($errors->has('experience'))
                    <div class="invalid-feedback">{{ $errors->first('experience') }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label small">Linked User</label>
                    <div class="d-flex gap-2 align-items-start">
                        <select name="user_id" id="userSelect"
                            class="form-select {{ $errors->has('user_id') ? 'is-invalid' : '' }}">
                            <option value="">-- None --</option>
                            @foreach ($users ?? [] as $u)
                                <option value="{{ $u->id }}"
                                    {{ old('user_id', $mua->user_id ?? '') == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }} ({{ $u->email }})
                                </option>
                            @endforeach
                            <option value="new" {{ old('user_id') === 'new' ? 'selected' : '' }}>+ Add new user...
                            </option>
                        </select>
                    </div>
                    @if ($errors->has('user_id'))
                        <div class="invalid-feedback d-block">{{ $errors->first('user_id') }}</div>
                    @endif

                    <div id="newUserFields" style="display: none; margin-top: .75rem;">
                        <div class="mb-2">
                            <input type="text" name="new_user_name" placeholder="User full name"
                                class="form-control {{ $errors->has('new_user_name') ? 'is-invalid' : '' }}"
                                value="{{ old('new_user_name') }}">
                            @if ($errors->has('new_user_name'))
                                <div class="invalid-feedback">{{ $errors->first('new_user_name') }}</div>
                            @endif
                        </div>
                        <div class="mb-2">
                            <input type="text" name="new_user_username" placeholder="Username"
                                class="form-control {{ $errors->has('new_user_username') ? 'is-invalid' : '' }}"
                                value="{{ old('new_user_username') }}">
                            @if ($errors->has('new_user_username'))
                                <div class="invalid-feedback">{{ $errors->first('new_user_username') }}</div>
                            @endif
                        </div>
                        <div class="mb-2">
                            <input type="email" name="new_user_email" placeholder="Email"
                                class="form-control {{ $errors->has('new_user_email') ? 'is-invalid' : '' }}"
                                value="{{ old('new_user_email') }}">
                            @if ($errors->has('new_user_email'))
                                <div class="invalid-feedback">{{ $errors->first('new_user_email') }}</div>
                            @endif
                        </div>
                        <div class="mb-2">
                            <input type="password" name="new_user_password" placeholder="Password"
                                class="form-control {{ $errors->has('new_user_password') ? 'is-invalid' : '' }}">
                            @if ($errors->has('new_user_password'))
                                <div class="invalid-feedback">{{ $errors->first('new_user_password') }}</div>
                            @endif
                        </div>
                        <small class="text-muted">New user will be created with role=MUA.</small>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const citySelect = document.getElementById('citySelect');
            const cities = @json($cities ?? []);
            const userSelect = document.getElementById('userSelect');
            const newUserFields = document.getElementById('newUserFields');

            // No province/district hierarchy any more. Cities are preloaded.
            // Preserve selection when editing
            if (citySelect) {
                const selected = "{{ old('city', $mua->city ?? '') }}";
                if (selected) citySelect.value = selected;
            }

            // toggle new user fields when admin selects "Add new user..."
            function toggleNewUserFields() {
                if (!userSelect || !newUserFields) return;
                if (userSelect.value === 'new') {
                    newUserFields.style.display = '';
                } else {
                    newUserFields.style.display = 'none';
                }
            }

            if (userSelect) {
                userSelect.addEventListener('change', toggleNewUserFields);
                // show on load if 'new' was selected previously
                toggleNewUserFields();
            }
        });
    </script>
@endpush
