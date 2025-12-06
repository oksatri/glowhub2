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
                <label class="form-label">Primary City / Regency</label>
                <select name="city" id="primaryCitySelect"
                    class="form-select {{ $errors->has('city') ? 'is-invalid' : '' }}">
                    <option value="">Select Primary City / Regency</option>
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

                <label class="form-label mt-3">Operational Hours</label>
                <input type="text" name="operational_hours"
                    class="form-control {{ $errors->has('operational_hours') ? 'is-invalid' : '' }}"
                    value="{{ old('operational_hours', $mua->operational_hours ?? '') }}"
                    placeholder="e.g. 09:00 - 18:00">
                @if ($errors->has('operational_hours'))
                    <div class="invalid-feedback">{{ $errors->first('operational_hours') }}</div>
                @endif

                <label class="form-label mt-3">Link Map</label>
                <input type="text" name="link_map"
                    class="form-control {{ $errors->has('link_map') ? 'is-invalid' : '' }}"
                    value="{{ old('link_map', $mua->link_map ?? '') }}" placeholder="e.g. Google Maps link">
                @if ($errors->has('link_map'))
                    <div class="invalid-feedback">{{ $errors->first('link_map') }}</div>
                @endif
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Service Area Cities</label>
                <select name="service_cities[]" id="serviceCitiesSelect" multiple
                    class="form-select {{ $errors->has('service_cities') ? 'is-invalid' : '' }}" style="height: 150px !important;">
                    @if (is_array($cities) && count($cities) > 0)
                        @foreach ($cities as $provinceId => $citiesByProvince)
                            @foreach ($citiesByProvince as $c)
                                <option value="{{ $c['id'] }}"
                                    {{ (is_array(old('service_cities', $mua->service_cities ?? [])) && in_array($c['id'], old('service_cities', $mua->service_cities ?? []))) ? 'selected' : '' }}>
                                    {{ $c['name'] }}
                                </option>
                            @endforeach
                        @endforeach
                    @endif
                </select>
                <small class="text-muted">Hold Ctrl/Cmd and click to select multiple cities</small>

                <div class="mt-2" id="selectedServiceCities">
                    <small class="text-muted"><strong>Selected Service Areas:</strong></small>
                    <div class="d-flex flex-wrap gap-1 mt-1" id="selectedCitiesList">
                        <!-- Selected cities will be displayed here -->
                    </div>
                </div>

                @if ($errors->has('service_cities'))
                    <div class="invalid-feedback d-block">{{ $errors->first('service_cities') }}</div>
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
            <div class="input-group mb-3">
                <span class="input-group-text">Rp</span>
                <input type="number" name="additional_charge"
                    class="form-control {{ $errors->has('additional_charge') ? 'is-invalid' : '' }}"
                    value="{{ old('additional_charge', isset($mua) ? $mua->additional_charge : '') }}"
                    min="0" step="1"
                    placeholder="e.g. 50000">
            </div>
            @if ($errors->has('additional_charge'))
                <div class="invalid-feedback">{{ $errors->first('additional_charge') }}</div>
            @endif
        </div>
        <!-- Availability Management Panel -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white">
                <h5 class="text-primary mb-0">
                    <i class="fas fa-calendar-times me-2"></i>Ketersediaan Jam
                </h5>
                <small class="text-muted">Tambahkan jam yang tidak tersedia karena booking di luar platform</small>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAvailabilityModal">
                        <i class="fas fa-plus me-2"></i>Tambah Jam Tidak Tersedia
                    </button>
                </div>
                
                <div id="availabilityList" class="row g-2">
                    @php
                        $availabilityHours = $mua->availability_hours ?? [];
                        if (!is_array($availabilityHours)) {
                            $availabilityHours = json_decode($availabilityHours, true) ?? [];
                        }
                    @endphp
                    @if (!empty($availabilityHours))
                        @foreach ($availabilityHours as $index => $slot)
                            <div class="col-12 col-md-6">
                                <div class="card border-left-danger h-100">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="card-title mb-1">{{ \Carbon\Carbon::parse($slot['date'])->format('d M Y') }}</h6>
                                                <p class="mb-1"><strong>{{ $slot['start_time'] }} - {{ $slot['end_time'] }}</strong></p>
                                                @if (!empty($slot['reason']))
                                                    <small class="text-muted d-block">{{ $slot['reason'] }}</small>
                                                @endif
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-danger remove-availability" 
                                                    data-index="{{ $index }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-calendar-check fa-2x mb-2"></i>
                                <p class="mb-0">Belum ada jam yang tidak tersedia</p>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Hidden input to store availability data -->
                <input type="hidden" name="availability_hours" id="availabilityHoursInput" 
                    value="{{ old('availability_hours', json_encode($availabilityHours ?? [])) }}">
            </div>
        </div>
    </div>
</div>



<!-- Add Availability Modal -->
<div class="modal fade" id="addAvailabilityModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Jam Tidak Tersedia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" class="form-control form-control-sm" id="availabilityDate" required>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label">Jam Mulai</label>
                        <input type="time" class="form-control form-control-sm" id="availabilityStartTime" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Jam Selesai</label>
                        <input type="time" class="form-control form-control-sm" id="availabilityEndTime" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alasan (opsional)</label>
                    <textarea class="form-control form-control-sm" id="availabilityReason" rows="2" 
                              placeholder="e.g. Booking di luar platform, event pribadi, dll"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-sm" id="saveAvailability">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <style>
        .border-left-danger {
            border-left: 4px solid #dc3545 !important;
        }
        .border-left-danger .card-title {
            color: #dc3545;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userSelect = document.getElementById('userSelect');
            const newUserFields = document.getElementById('newUserFields');
            const serviceCitiesSelect = document.getElementById('serviceCitiesSelect');
            const selectedCitiesList = document.getElementById('selectedCitiesList');
            
            // Modal trigger using jQuery
            $(document).on('click', '[data-bs-target="#addAvailabilityModal"]', function(e) {
                e.preventDefault();
                console.log('Modal trigger clicked'); // Debug
                $('#addAvailabilityModal').modal('show');
            });
            
            // Availability Management
            const availabilityHoursInput = document.getElementById('availabilityHoursInput');
            const availabilityList = document.getElementById('availabilityList');
            const saveAvailabilityBtn = document.getElementById('saveAvailability');
            const addAvailabilityModal = document.getElementById('addAvailabilityModal');
            
            console.log('Availability elements:', {
                availabilityHoursInput,
                availabilityList,
                saveAvailabilityBtn,
                addAvailabilityModal
            }); // Debug
            
            let availabilityData = [];
            
            // Load existing availability data
            try {
                availabilityData = JSON.parse(availabilityHoursInput.value || '[]');
            } catch (e) {
                availabilityData = [];
            }
            
            // Function to render availability list
            function renderAvailabilityList() {
                if (!availabilityList) return;
                
                if (availabilityData.length === 0) {
                    availabilityList.innerHTML = `
                        <div class="col-12">
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-calendar-check fa-3x mb-3"></i>
                                <p>Belum ada jam yang tidak tersedia</p>
                            </div>
                        </div>
                    `;
                    return;
                }
                
                availabilityList.innerHTML = availabilityData.map((slot, index) => {
                    const date = new Date(slot.date);
                    const formattedDate = date.toLocaleDateString('id-ID', { 
                        day: 'numeric', 
                        month: 'short', 
                        year: 'numeric' 
                    });
                    
                    return `
                        <div class="col-md-6">
                            <div class="card border-left-danger">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="card-title mb-1">${formattedDate}</h6>
                                            <p class="mb-1"><strong>${slot.start_time} - ${slot.end_time}</strong></p>
                                            ${slot.reason ? `<small class="text-muted">${slot.reason}</small>` : ''}
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-availability" 
                                                data-index="${index}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');
                
                // Update hidden input
                availabilityHoursInput.value = JSON.stringify(availabilityData);
                
                // Add event listeners to remove buttons
                availabilityList.querySelectorAll('.remove-availability').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.dataset.index);
                        availabilityData.splice(index, 1);
                        renderAvailabilityList();
                    });
                });
            }
            
            // Save availability
            if (saveAvailabilityBtn) {
                saveAvailabilityBtn.addEventListener('click', function() {
                    console.log('Save availability clicked'); // Debug
                    
                    const date = document.getElementById('availabilityDate').value;
                    const startTime = document.getElementById('availabilityStartTime').value;
                    const endTime = document.getElementById('availabilityEndTime').value;
                    const reason = document.getElementById('availabilityReason').value;
                    
                    console.log('Form data:', { date, startTime, endTime, reason }); // Debug
                    
                    if (!date || !startTime || !endTime) {
                        alert('Mohon lengkapi semua field yang wajib diisi');
                        return;
                    }
                    
                    if (startTime >= endTime) {
                        alert('Jam mulai harus lebih awal dari jam selesai');
                        return;
                    }
                    
                    const newSlot = {
                        id: Date.now().toString(),
                        date: date,
                        start_time: startTime,
                        end_time: endTime,
                        reason: reason,
                        created_at: new Date().toISOString()
                    };
                    
                    console.log('New slot:', newSlot); // Debug
                    
                    availabilityData.push(newSlot);
                    renderAvailabilityList();
                    
                    // Reset form and close modal
                    document.getElementById('availabilityDate').value = '';
                    document.getElementById('availabilityStartTime').value = '';
                    document.getElementById('availabilityEndTime').value = '';
                    document.getElementById('availabilityReason').value = '';
                    
                    // Close modal using Bootstrap 4 (jQuery)
                    $('#addAvailabilityModal').modal('hide');
                });
            } else {
                console.log('Save availability button not found'); // Debug
            }
            
            // Ensure availability data is saved before form submission
            const form = document.querySelector('form[method="POST"]');
            if (form) {
                form.addEventListener('submit', function(e) {
                    console.log('Form submitting, availability data:', availabilityData); // Debug
                    availabilityHoursInput.value = JSON.stringify(availabilityData);
                });
            }
            
            // Initial render
            renderAvailabilityList();

            // Function to update selected cities display
            function updateSelectedCities() {
                if (!serviceCitiesSelect || !selectedCitiesList) return;

                const selectedOptions = Array.from(serviceCitiesSelect.selectedOptions);
                const cityNames = selectedOptions.map(option => option.textContent);

                if (cityNames.length > 0) {
                    selectedCitiesList.innerHTML = cityNames.map(city =>
                        `<span class="badge bg-primary me-1 text-white" style="margin:5px;">${city}</span>`
                    ).join('');
                } else {
                    selectedCitiesList.innerHTML = '<span class="text-muted">No cities selected</span>';
                }
            }

            // Initial display
            updateSelectedCities();

            // Update on change
            if (serviceCitiesSelect) {
                serviceCitiesSelect.addEventListener('change', updateSelectedCities);
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
