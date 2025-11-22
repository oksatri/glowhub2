<div class="row gx-4">
    <div class="col-sm-8">
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
                
            </div>
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
    <div class="col-sm-4">
        <div class="card p-3">
            <h4 class="text-primary mb-3">Home Service</h4>
            <label class="form-label">Max Distance (km)</label>
            <input type="number" name="max_distance"
                class="mb-3 form-control {{ $errors->has('max_distance') ? 'is-invalid' : '' }}"
                value="{{ old('max_distance', $mua->max_distance ?? '') }}" min="0"
                placeholder="e.g. 20">
            @if ($errors->has('max_distance'))
                <div class="invalid-feedback">{{ $errors->first('max_distance') }}</div>
            @endif
            <label class="form-label">Additional Charge</label>
            <input type="number" name="additional_charge"
                class="mb-3 form-control {{ $errors->has('additional_charge') ? 'is-invalid' : '' }}"
                value="{{ old('additional_charge', $mua->additional_charge ?? '') }}" min="0"
                placeholder="e.g. 50000">
            @if ($errors->has('additional_charge'))
                <div class="invalid-feedback">{{ $errors->first('additional_charge') }}</div>
            @endif
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
