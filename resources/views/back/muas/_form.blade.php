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
                    @if (is_array($cities) && count($cities) > 0)
                        @foreach ($cities as $provinceId => $citiesByProvince)
                            @foreach ($citiesByProvince as $c)
                                <option value="{{ $c['id'] }}"
                                    {{ old('city', $mua->city ?? '') == $c['id'] ? 'selected' : '' }}>
                                    {{ $c['name'] }}
                                </option>
                            @endforeach
                        @endforeach
                    @endif
                </select>
                @if ($errors->has('city'))
                    <div class="invalid-feedback d-block">{{ $errors->first('city') }}</div>
                @endif
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Max Distance (km)</label>
                <input type="number" name="max_distance"
                    class="form-control {{ $errors->has('max_distance') ? 'is-invalid' : '' }}"
                    value="{{ old('max_distance', $mua->max_distance ?? '') }}" min="0"
                    placeholder="e.g. 20">
                @if ($errors->has('max_distance'))
                    <div class="invalid-feedback">{{ $errors->first('max_distance') }}</div>
                @endif
            </div>
        </div>

        <div class="row gx-2">
            <div class="col-md-6 mb-3">
                <label class="form-label">Operational Hours</label>
                <input type="text" name="operational_hours"
                    class="form-control {{ $errors->has('operational_hours') ? 'is-invalid' : '' }}"
                    value="{{ old('operational_hours', $mua->operational_hours ?? '') }}"
                    placeholder="e.g. 09:00 - 18:00">
                @if ($errors->has('operational_hours'))
                    <div class="invalid-feedback">{{ $errors->first('operational_hours') }}</div>
                @endif
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Additional Charge</label>
                <input type="number" step="0.01" name="additional_charge"
                    class="form-control {{ $errors->has('additional_charge') ? 'is-invalid' : '' }}"
                    value="{{ old('additional_charge', $mua->additional_charge ?? '') }}" min="0"
                    placeholder="e.g. 50000">
                @if ($errors->has('additional_charge'))
                    <div class="invalid-feedback">{{ $errors->first('additional_charge') }}</div>
                @endif
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Occasions</label>
            @php
                $occasionOptions = [
                    'Akad',
                    'Wedding (Resepsi)',
                    'Prewedding',
                    '⁠⁠Engagement/Lamaran',
                    'Wedding Guest',
                    'Party',
                    'Bridesmaid',
                    'Graduation',
                    'Graduation Companion',
                    'Maternity Shoot',
                    'Photoshoot',
                    'Family Makeup',
                    'Event',
                ];
                $selectedOccasions = old('categori_service', $mua->categori_service ?? []);
                if (!is_array($selectedOccasions)) {
                    $selectedOccasions = (array) $selectedOccasions;
                }
            @endphp
            <select name="categori_service[]" class="form-select" multiple size="6">
                @foreach ($occasionOptions as $opt)
                    <option value="{{ $opt }}" {{ in_array($opt, $selectedOccasions, true) ? 'selected' : '' }}>
                        {{ $opt }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted d-block mt-1">Hold Ctrl/Command to select more than one occasion.</small>
            @if ($errors->has('categori_service'))
                <div class="invalid-feedback d-block">{{ $errors->first('categori_service') }}</div>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Availability Hours</label>
            <input type="text" name="availability_hours"
                class="form-control {{ $errors->has('availability_hours') ? 'is-invalid' : '' }}"
                value="{{ old('availability_hours', $mua->availability_hours ?? '') }}"
                placeholder="e.g. Weekdays only, Weekend">
            @if ($errors->has('availability_hours'))
                <div class="invalid-feedback">{{ $errors->first('availability_hours') }}</div>
            @endif
        </div>

        <div class="row gx-2">
            <div class="col-md-12 mb-3">
                <label class="form-label">Link Map</label>
                <input type="text" name="link_map"
                    class="form-control {{ $errors->has('link_map') ? 'is-invalid' : '' }}"
                    value="{{ old('link_map', $mua->link_map ?? '') }}" placeholder="e.g. Google Maps link">
                @if ($errors->has('link_map'))
                    <div class="invalid-feedback">{{ $errors->first('link_map') }}</div>
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
            const userSelect = document.getElementById('userSelect');
            const newUserFields = document.getElementById('newUserFields');

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
