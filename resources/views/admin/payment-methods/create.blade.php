@extends('back._parts.master')

@section('title', 'Add Payment Method')

@push('styles')
<style>
    .form-container {
        background: white;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .form-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 30px;
        margin: -30px -30px 30px -30px;
        border-radius: 10px 10px 0 0;
    }

    .form-header h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
    }

    .instruction-group {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        background: #f8f9fa;
    }

    .instruction-group h5 {
        color: #667eea;
        margin: 0 0 10px;
        font-size: 16px;
    }

    .btn-remove-instruction {
        background: #dc3545;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 12px;
    }

    .btn-remove-instruction:hover {
        background: #c82333;
    }

    .btn-add-instruction {
        background: #28a745;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        margin-top: 10px;
    }

    .btn-add-instruction:hover {
        background: #218838;
    }

    .form-actions {
        background: #f8f9fa;
        padding: 20px;
        margin: 30px -30px -30px -30px;
        border-radius: 0 0 10px 10px;
        text-align: right;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    var instructionIndex = {{ count($instructions ?? []) }};

    // Add instruction
    $('#add-instruction').on('click', function() {
        var html = `
            <div class="instruction-group" id="instruction-${instructionIndex}">
                <h5>Instruction ${instructionIndex + 1}</h5>
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Key</label>
                        <input type="text" name="instructions[${instructionIndex}][key]" class="form-control" placeholder="e.g., account_name">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Value</label>
                        <input type="text" name="instructions[${instructionIndex}][value]" class="form-control" placeholder="e.g., PT GlowHub Indonesia">
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">&nbsp;</label><br>
                        <button type="button" class="btn-remove-instruction" onclick="removeInstruction(${instructionIndex})">
                            <i class="fas fa-trash"></i>
                        </button>
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

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-container">
                <div class="form-header">
                    <h3>➕ Add Payment Method</h3>
                </div>

                <form id="payment-method-form" action="{{ route('admin.payment-methods.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Payment Method Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" placeholder="e.g., Bank Transfer - BCA" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Code <span class="text-danger">*</span></label>
                                <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                                       value="{{ old('code') }}" placeholder="e.g., bca_va" required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                  rows="3" placeholder="e.g., Transfer ke Virtual Account BCA" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror"
                                       value="{{ old('sort_order', 0) }}" min="0" placeholder="0">
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                           {{ old('is_active', true) ? 'checked' : '' }} value="1">
                                    <label class="form-check-label" for="is_active">
                                        Active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>📋 Instructions</h5>
                        <p class="text-muted">Add key-value pairs for payment instructions (e.g., account_name, bank_name, steps)</p>

                        <div id="instructions-container">
                            <!-- Default instructions will be added here -->
                            <div class="instruction-group" id="instruction-0">
                                <h5>Instruction 1</h5>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">Key</label>
                                        <input type="text" name="instructions[0][key]" class="form-control" placeholder="e.g., account_name">
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label">Value</label>
                                        <input type="text" name="instructions[0][value]" class="form-control" placeholder="e.g., PT GlowHub Indonesia">
                                    </div>
                                    <div class="col-md-1">
                                        <label class="form-label">&nbsp;</label><br>
                                        <button type="button" class="btn-remove-instruction" onclick="removeInstruction(0)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="add-instruction" class="btn-add-instruction">
                            <i class="fas fa-plus me-2"></i>Add Instruction
                        </button>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.payment-methods.index') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Payment Method
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
