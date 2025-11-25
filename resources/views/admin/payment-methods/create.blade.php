@extends('back._parts.master')
@section('page-title', 'Add Payment Method')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1" style="color: #2D3748; font-weight:600;">Add Payment Method</h1>
            <p class="text-muted small mb-0">Create a new payment method for booking transactions — elegant and simple.</p>
        </div>
        <a href="{{ route('admin.payment-methods.index') }}" class="btn px-3 py-2"
            style="background:white; border:1px solid #E5E7EB; color:#374151;">
            <i class="fas fa-arrow-left me-2"></i>Back to list
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body px-4 py-4">
            <form id="payment-method-form" action="{{ route('admin.payment-methods.store') }}" method="POST">
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

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: #374151;">Payment Method Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" placeholder="e.g., Bank Transfer - BCA" required
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
                                   value="{{ old('code') }}" placeholder="e.g., bca_va" required
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
                              style="border: 1px solid #E5E7EB; font-size: 0.95rem;">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: #374151;">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror"
                                   value="{{ old('sort_order', 0) }}" min="0" placeholder="0"
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
                                       {{ old('is_active', true) ? 'checked' : '' }} value="1"
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
                    <p class="text-muted mb-3" style="font-size: 0.95rem;">Add key-value pairs for payment instructions (e.g., account_name, bank_name, steps)</p>

                    <div id="instructions-container" class="mb-3">
                        <div class="instruction-group p-3 mb-3 rounded" style="background: #F9FAFB; border: 1px solid #E5E7EB;" id="instruction-0">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0" style="color: #374151; font-weight: 500;">Instruction 1</h6>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeInstruction(0)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label class="form-label small fw-medium">Key</label>
                                    <input type="text" name="instructions[0][key]" class="form-control form-control-sm" placeholder="e.g., account_name"
                                           style="border: 1px solid #E5E7EB; font-size: 0.875rem;">
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label small fw-medium">Value</label>
                                    <input type="text" name="instructions[0][value]" class="form-control form-control-sm" placeholder="e.g., PT GlowHub Indonesia"
                                           style="border: 1px solid #E5E7EB; font-size: 0.875rem;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="add-instruction" class="btn px-3 py-2"
                            style="background: #ECFDF5; border: 1px solid #059669; color: #065F46; font-weight: 500;">
                        <i class="fas fa-plus me-2"></i>Add Instruction
                    </button>
                </div>

                <div class="mt-4 d-flex align-items-center gap-2">
                    <button type="submit" class="btn px-4 py-2 rounded-pill text-white"
                        style="background: linear-gradient(135deg,#667EEA 0%,#764BA2 100%); border:none;">
                        <i class="fas fa-save me-2"></i>Create Payment Method
                    </button>
                    <a href="{{ route('admin.payment-methods.index') }}" class="btn px-4 py-2"
                        style="background:transparent; color:#6B7280; border: 1px solid #E5E7EB;">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script>
$(document).ready(function() {
    var instructionIndex = 1;

    // Add instruction
    $('#add-instruction').on('click', function() {
        var html = `
            <div class="instruction-group p-3 mb-3 rounded" style="background: #F9FAFB; border: 1px solid #E5E7EB;" id="instruction-${instructionIndex}">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0" style="color: #374151; font-weight: 500;">Instruction ${instructionIndex + 1}</h6>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeInstruction(${instructionIndex})">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="row g-2">
                    <div class="col-md-4">
                        <label class="form-label small fw-medium">Key</label>
                        <input type="text" name="instructions[${instructionIndex}][key]" class="form-control form-control-sm" placeholder="e.g., account_name"
                               style="border: 1px solid #E5E7EB; font-size: 0.875rem;">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label small fw-medium">Value</label>
                        <input type="text" name="instructions[${instructionIndex}][value]" class="form-control form-control-sm" placeholder="e.g., PT GlowHub Indonesia"
                               style="border: 1px solid #E5E7EB; font-size: 0.875rem;">
                    </div>
                </div>
            </div>
        `;

        $('#instructions-container').append(html);
        instructionIndex++;
    });

    // Remove instruction
    window.removeInstruction = function(index) {
        $('#instruction-' + index).remove();
    };

    // Form validation
    $('#payment-method-form').on('submit', function(e) {
        var instructions = {};
        $('input[name^="instructions"]').each(function() {
            var name = $(this).attr('name');
            var matches = name.match(/instructions\[(\d+)\]\[(\w+)\]/);
            if (matches) {
                var index = matches[1];
                var key = matches[2];
                if (!instructions[index]) {
                    instructions[index] = {};
                }
                instructions[index][key] = $(this).val();
            }
        });

        // Convert to JSON
        var instructionsJson = {};
        Object.keys(instructions).forEach(function(index) {
            var instruction = instructions[index];
            if (instruction.key && instruction.value) {
                instructionsJson[instruction.key] = instruction.value;
            }
        });

        // Add hidden field with JSON
        if (!$('input[name="instructions_json"]').length) {
            $('#payment-method-form').append('<input type="hidden" name="instructions_json">');
        }
        $('input[name="instructions_json"]').val(JSON.stringify(instructionsJson));

        // Remove instruction inputs before submission
        $('input[name^="instructions"]').remove();
    });
});
</script>
@endpush
