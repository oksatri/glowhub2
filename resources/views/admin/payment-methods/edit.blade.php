@extends('back._parts.master')
@section('page-title', 'Edit Payment Method')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1" style="color: #2D3748; font-weight:600;">Edit Payment Method</h1>
            <p class="text-muted small mb-0">Update an existing payment method — elegant and simple.</p>
        </div>
        <a href="{{ route('admin.payment-methods.index') }}" class="btn px-3 py-2"
            style="background:white; border:1px solid #E5E7EB; color:#374151;">
            <i class="fas fa-arrow-left me-2"></i>Back to list
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body px-4 py-4">
            <form id="payment-method-form" action="{{ route('admin.payment-methods.update', $paymentMethod) }}" method="POST">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: #374151;">Payment Method Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $paymentMethod->name) }}" placeholder="e.g., Bank Transfer - BCA" required
                                   style="border: 1px solid #E5E7EB; font-size: 0.95rem;">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: #374151;">Code <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                                   value="{{ old('code', $paymentMethod->code) }}" placeholder="e.g., bca_va" required
                                   style="border: 1px solid #E5E7EB; font-size: 0.95rem;">
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color: #374151;">Description <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                              rows="3" placeholder="e.g., Transfer ke Virtual Account BCA" required
                              style="border: 1px solid #E5E7EB; font-size: 0.95rem;">{{ old('description', $paymentMethod->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: #374151;">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror"
                                   value="{{ old('sort_order', $paymentMethod->sort_order) }}" min="0" placeholder="0"
                                   style="border: 1px solid #E5E7EB; font-size: 0.95rem;">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                       {{ old('is_active', $paymentMethod->is_active) ? 'checked' : '' }} value="1"
                                       style="border: 1px solid #D1D5DB;">
                                <label class="form-check-label fw-medium" for="is_active" style="color: #374151;">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="mb-3" style="color: #1F2937; font-weight: 600;">📋 Payment Instructions</h5>
                    <p class="text-muted mb-3" style="font-size: 0.95rem;">Kelola instruksi pembayaran step by step untuk memudahkan pelanggan</p>

                    <div id="instructions-container" class="mb-3">
                        @php
                            $instructions = $paymentMethod->instructions ?? [];
                            $index = 0;
                        @endphp

                        @foreach($instructions as $key => $value)
                            <div class="instruction-group p-4 mb-3 rounded border" style="background: #F9FAFB; border: 1px solid #E5E7EB;" id="instruction-{{ $index }}">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0" style="color: #374151; font-weight: 600;">
                                        <i class="fas fa-list-ol me-2 text-primary"></i>Instruksi {{ $index + 1 }}
                                    </h6>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeInstruction({{ $index }})">
                                        <i class="fas fa-trash me-1"></i>Hapus
                                    </button>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label fw-medium text-muted">Kategori</label>
                                        <input type="text" name="instructions[{{ $index }}][key]" class="form-control"
                                               value="{{ is_string($key) ? htmlspecialchars($key, ENT_QUOTES, 'UTF-8') : htmlspecialchars((string)$key, ENT_QUOTES, 'UTF-8') }}"
                                               placeholder="e.g., steps, account_info"
                                               style="border: 1px solid #E5E7EB; font-size: 0.9rem;">
                                        <small class="text-muted">Nama kategori instruksi</small>
                                    </div>
                                    <div class="col-md-9">
                                        <label class="form-label fw-medium text-muted">Tipe Data</label>
                                        <select name="instructions[{{ $index }}][type]" class="form-select" onchange="toggleInstructionType({{ $index }})"
                                                style="border: 1px solid #E5E7EB; font-size: 0.9rem;">
                                            <option value="text" {{ !is_array($value) ? 'selected' : '' }}>Teks Tunggal</option>
                                            <option value="array" {{ is_array($value) ? 'selected' : '' }}>Array/Steps</option>
                                        </select>
                                        <small class="text-muted">Pilih tipe data untuk instruksi ini</small>
                                    </div>
                                </div>

                                <!-- Single Text Value -->
                                <div id="single-value-{{ $index }}" class="{{ is_array($value) ? 'd-none' : '' }}">
                                    <label class="form-label fw-medium text-muted">Nilai</label>
                                    <input type="text" name="instructions[{{ $index }}][single_value]" class="form-control"
                                           value="{{ !is_array($value) ? (is_string($value) ? htmlspecialchars($value, ENT_QUOTES, 'UTF-8') : htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8')) : '' }}"
                                           placeholder="Masukkan nilai instruksi"
                                           style="border: 1px solid #E5E7EB; font-size: 0.9rem;">
                                </div>

                                <!-- Array/Steps Value -->
                                <div id="array-value-{{ $index }}" class="{{ is_array($value) ? '' : 'd-none' }}">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="form-label fw-medium text-muted mb-0">Step-by-Step Instructions</label>
                                        <button type="button" class="btn btn-sm btn-outline-success" onclick="addStep({{ $index }})">
                                            <i class="fas fa-plus me-1"></i>Tambah Step
                                        </button>
                                    </div>

                                    <div id="steps-container-{{ $index }}" class="mb-2">
                                        @if(is_array($value))
                                            @foreach($value as $stepIndex => $stepValue)
                                                <div class="step-item d-flex align-items-center gap-2 mb-2" id="step-{{ $index }}-{{ $stepIndex }}">
                                                    <span class="badge bg-primary rounded-circle" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">{{ $stepIndex + 1 }}</span>
                                                    <input type="text" name="instructions[{{ $index }}][steps][]" class="form-control"
                                                           value="{{ is_string($stepValue) ? htmlspecialchars($stepValue, ENT_QUOTES, 'UTF-8') : htmlspecialchars((string)$stepValue, ENT_QUOTES, 'UTF-8') }}"
                                                           placeholder="Step {{ $stepIndex + 1 }}"
                                                           style="border: 1px solid #E5E7EB; font-size: 0.9rem;">
                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeStep({{ $index }}, {{ $stepIndex }})">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @php($index++)
                        @endforeach
                    </div>

                    <button type="button" id="add-instruction" class="btn px-4 py-2"
                            style="background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%); border: none; color: white; font-weight: 500;">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Kategori Instruksi
                    </button>
                </div>

                <div class="mt-4 d-flex align-items-center gap-2">
                    <button type="submit" class="btn px-4 py-2 rounded-pill text-white"
                        style="background: linear-gradient(135deg,#667EEA 0%,#764BA2 100%); border:none;">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </button>
                    <a href="{{ route('admin.payment-methods.index') }}" class="btn px-4 py-2"
                        style="background:transparent; color:#6B7280; border: 1px solid #E5E7EB;">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    var instructionIndex = {{ count($paymentMethod->instructions ?? []) }};
    var stepCounters = {};

    // Initialize step counters for existing instructions
    @if(is_array($paymentMethod->instructions ?? []))
        @foreach($paymentMethod->instructions as $key => $value)
            @if(is_array($value))
                stepCounters[{{ $loop->index0 }}] = {{ count($value) }};
            @endif
        @endforeach
    @endif

    // Add new instruction
    $('#add-instruction').on('click', function() {
        var html = `
            <div class="instruction-group p-4 mb-3 rounded border" style="background: #F9FAFB; border: 1px solid #E5E7EB;" id="instruction-${instructionIndex}">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0" style="color: #374151; font-weight: 600;">
                        <i class="fas fa-list-ol me-2 text-primary"></i>Instruksi ${instructionIndex + 1}
                    </h6>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeInstruction(${instructionIndex})">
                        <i class="fas fa-trash me-1"></i>Hapus
                    </button>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <label class="form-label fw-medium text-muted">Kategori</label>
                        <input type="text" name="instructions[${instructionIndex}][key]" class="form-control"
                               placeholder="e.g., steps, account_info"
                               style="border: 1px solid #E5E7EB; font-size: 0.9rem;">
                        <small class="text-muted">Nama kategori instruksi</small>
                    </div>
                    <div class="col-md-9">
                        <label class="form-label fw-medium text-muted">Tipe Data</label>
                        <select name="instructions[${instructionIndex}][type]" class="form-select" onchange="toggleInstructionType(${instructionIndex})"
                                style="border: 1px solid #E5E7EB; font-size: 0.9rem;">
                            <option value="text" selected>Teks Tunggal</option>
                            <option value="array">Array/Steps</option>
                        </select>
                        <small class="text-muted">Pilih tipe data untuk instruksi ini</small>
                    </div>
                </div>

                <!-- Single Text Value -->
                <div id="single-value-${instructionIndex}">
                    <label class="form-label fw-medium text-muted">Nilai</label>
                    <input type="text" name="instructions[${instructionIndex}][single_value]" class="form-control"
                           placeholder="Masukkan nilai instruksi"
                           style="border: 1px solid #E5E7EB; font-size: 0.9rem;">
                </div>

                <!-- Array/Steps Value -->
                <div id="array-value-${instructionIndex}" class="d-none">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label fw-medium text-muted mb-0">Step-by-Step Instructions</label>
                        <button type="button" class="btn btn-sm btn-outline-success" onclick="addStep(${instructionIndex})">
                            <i class="fas fa-plus me-1"></i>Tambah Step
                        </button>
                    </div>

                    <div id="steps-container-${instructionIndex}" class="mb-2">
                        <!-- Steps will be added here dynamically -->
                    </div>
                </div>
            </div>
        `;

        $('#instructions-container').append(html);
        stepCounters[instructionIndex] = 0;
        instructionIndex++;
    });

    // Remove instruction
    window.removeInstruction = function(index) {
        $('#instruction-' + index).remove();
    };

    // Toggle instruction type (text vs array)
    window.toggleInstructionType = function(index) {
        var type = $('select[name="instructions[' + index + '][type]"]').val();
        var singleDiv = $('#single-value-' + index);
        var arrayDiv = $('#array-value-' + index);

        if (type === 'array') {
            singleDiv.addClass('d-none');
            arrayDiv.removeClass('d-none');
            // Add initial step if container is empty
            if ($('#steps-container-' + index + ' .step-item').length === 0) {
                addStep(index);
            }
        } else {
            singleDiv.removeClass('d-none');
            arrayDiv.addClass('d-none');
        }
    };

    // Add step to instruction
    window.addStep = function(instructionIndex) {
        var stepIndex = stepCounters[instructionIndex] || 0;
        var html = `
            <div class="step-item d-flex align-items-center gap-2 mb-2" id="step-${instructionIndex}-${stepIndex}">
                <span class="badge bg-primary rounded-circle" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">${stepIndex + 1}</span>
                <input type="text" name="instructions[${instructionIndex}][steps][]" class="form-control"
                       placeholder="Step ${stepIndex + 1}"
                       style="border: 1px solid #E5E7EB; font-size: 0.9rem;">
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeStep(${instructionIndex}, ${stepIndex})">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;

        $('#steps-container-' + instructionIndex).append(html);
        stepCounters[instructionIndex] = stepIndex + 1;
    };

    // Remove step from instruction
    window.removeStep = function(instructionIndex, stepIndex) {
        $('#step-' + instructionIndex + '-' + stepIndex).remove();
        // Renumber remaining steps
        renumberSteps(instructionIndex);
    };

    // Renumber steps after removal
    function renumberSteps(instructionIndex) {
        $('#steps-container-' + instructionIndex + ' .step-item').each(function(index) {
            var newIndex = index;
            var oldId = $(this).attr('id');
            var newId = 'step-' + instructionIndex + '-' + newIndex;

            $(this).attr('id', newId);
            $(this).find('.badge').text(newIndex + 1);
            $(this).find('input').attr('placeholder', 'Step ' + (newIndex + 1));
            $(this).find('button').attr('onclick', 'removeStep(' + instructionIndex + ', ' + newIndex + ')');
        });

        // Update step counter
        stepCounters[instructionIndex] = $('#steps-container-' + instructionIndex + ' .step-item').length;
    }

    // Form validation and submission
    $('#payment-method-form').on('submit', function(e) {
        e.preventDefault();

        var instructions = {};

        // Process each instruction
        $('.instruction-group').each(function(index) {
            var instructionIndex = $(this).attr('id').replace('instruction-', '');
            var key = $('input[name="instructions[' + instructionIndex + '][key]"]').val();
            var type = $('select[name="instructions[' + instructionIndex + '][type]"]').val();

            if (key) {
                if (type === 'array') {
                    // Collect steps into array
                    var steps = [];
                    $('input[name="instructions[' + instructionIndex + '][steps][]"]').each(function() {
                        if ($(this).val()) {
                            steps.push($(this).val());
                        }
                    });
                    instructions[key] = steps;
                } else {
                    // Single value
                    var value = $('input[name="instructions[' + instructionIndex + '][single_value]"]').val();
                    instructions[key] = value;
                }
            }
        });

        // Add hidden field with JSON
        if (!$('input[name="instructions_json"]').length) {
            $('#payment-method-form').append('<input type="hidden" name="instructions_json">');
        }
        $('input[name="instructions_json"]').val(JSON.stringify(instructions));

        // Remove instruction inputs before submission
        $('input[name^="instructions"], select[name^="instructions"]').remove();

        // Submit form
        this.submit();
    });
});
</script>
@endpush
