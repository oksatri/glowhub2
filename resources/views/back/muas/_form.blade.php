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
            <div class="col-md-4 mb-3">
                <label class="form-label">Province</label>
                @if (!empty($wilayahMissing) || empty($provinces))
                    <div class="alert alert-warning small">Wilayah (province/city/district) data is not available.
                        Please import wilayah data by placing <code>database/sql/wilayah_indonesia_pg.sql</code> in the
                        project and running <code>php artisan db:seed --class=WilayahSeeder</code>, or contact the
                        administrator.</div>
                    <select name="province" id="provinceSelect" class="form-select" disabled>
                        <option value="">No data</option>
                    </select>
                @else
                    <select name="province" id="provinceSelect"
                        class="form-select {{ $errors->has('province') ? 'is-invalid' : '' }}">
                        <option value="">Select Province</option>
                        @foreach ($provinces as $key => $label)
                            <option value="{{ $key }}"
                                {{ old('province', $mua->province ?? '') == $key ? 'selected' : '' }}>
                                {{ $label }}</option>
                        @endforeach
                    </select>
                @endif
                @if ($errors->has('province'))
                    <div class="invalid-feedback d-block">{{ $errors->first('province') }}</div>
                @endif
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">City / Regency</label>
                <select name="city" id="citySelect"
                    class="form-select {{ $errors->has('city') ? 'is-invalid' : '' }}">
                    <option value="">Select City / Regency</option>
                    @php
                        $selectedProvince = old('province', $mua->province ?? '');
                        $initialCities = $cities[$selectedProvince] ?? [];
                    @endphp
                    @foreach ($initialCities as $c)
                        <option value="{{ $c['id'] }}"
                            {{ old('city', $mua->city ?? '') == $c['id'] ? 'selected' : '' }}>{{ $c['name'] }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('city'))
                    <div class="invalid-feedback d-block">{{ $errors->first('city') }}</div>
                @endif
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">District</label>
                <select name="district" id="districtSelect"
                    class="form-select {{ $errors->has('district') ? 'is-invalid' : '' }}">
                    <option value="">Select District</option>
                    @php
                        $selectedCity = old('city', $mua->city ?? '');
                        $initialDistricts = $districts[$selectedCity] ?? [];
                    @endphp
                    @foreach ($initialDistricts as $d)
                        <option value="{{ $d['id'] }}"
                            {{ old('district', $mua->district ?? '') == $d['id'] ? 'selected' : '' }}>
                            {{ $d['name'] }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('district'))
                    <div class="invalid-feedback d-block">{{ $errors->first('district') }}</div>
                @endif
            </div>
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
            const provinceSelect = document.getElementById('provinceSelect');
            const citySelect = document.getElementById('citySelect');
            const districtSelect = document.getElementById('districtSelect');
            const cities = @json($cities ?? []);
            const districts = @json($districts ?? []);
            const userSelect = document.getElementById('userSelect');
            const newUserFields = document.getElementById('newUserFields');

            function populateCities(province) {
                citySelect.innerHTML = '<option value="">Select City / Regency</option>';
                if (!province || !cities[province]) return;
                cities[province].forEach(function(city) {
                    const opt = document.createElement('option');
                    opt.value = city.id;
                    opt.textContent = city.name;
                    citySelect.appendChild(opt);
                });
                // preserve selected city when editing
                const selected = "{{ old('city', $mua->city ?? '') }}";
                if (selected) {
                    citySelect.value = selected;
                }
                // populate districts for the selected city (if any)
                if (selected) populateDistricts(selected);
            }

            function populateDistricts(city) {
                if (!districtSelect) return;
                districtSelect.innerHTML = '<option value="">Select District</option>';
                if (!city || !districts[city]) return;
                districts[city].forEach(function(d) {
                    const opt = document.createElement('option');
                    opt.value = d.id;
                    opt.textContent = d.name;
                    districtSelect.appendChild(opt);
                });
                // preserve selected district when editing
                const sel = "{{ old('district', $mua->district ?? '') }}";
                if (sel) districtSelect.value = sel;
            }

            if (provinceSelect) {
                provinceSelect.addEventListener('change', function() {
                    populateCities(this.value);
                });
                // when city changes, populate districts
                if (citySelect) {
                    citySelect.addEventListener('change', function() {
                        populateDistricts(this.value);
                    });
                }
                // if a province is already selected on load, populate cities
                if (provinceSelect.value) populateCities(provinceSelect.value);
                // also if a city is already selected on load, populate districts
                if (citySelect && citySelect.value) populateDistricts(citySelect.value);
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
