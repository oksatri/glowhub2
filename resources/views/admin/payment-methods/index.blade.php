@extends('back._parts.master')
@section('page-title', 'Payment Methods Management')
@section('content')
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-2" style="color: #2D3748; font-weight: 600; letter-spacing: -0.025em;">Payment Methods Management</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0" style="font-size: 0.95rem;">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}" class="text-decoration-none" style="color: #6B7280;">
                            <i class="fas fa-home me-1 opacity-75"></i>Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item active" style="color: #4B5563;">Payment Methods</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.payment-methods.create') }}" class="btn px-4 py-2 rounded-pill shadow-sm text-white"
            style="background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%); border: none; transition: all 0.3s ease;">
            <i class="fas fa-plus-circle me-2"></i>
            Add Payment Method
        </a>
    </div>

    .sortable-item {
        cursor: move;
        transition: all 0.3s ease;
    }

    .sortable-item:hover {
        background-color: #f8f9fa;
    }

    .sortable-item.sortable-ghost {
        opacity: 0.4;
        background: #f0f0f0;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-active {
        background: #d4edda;
        color: #155724;
    }

    .status-inactive {
        background: #f8d7da;
        color: #721c24;
    }

    .action-buttons {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .btn-sm {
        padding: 5px 10px;
        font-size: 12px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-edit {
        background: #007bff;
        color: white;
    }

    .btn-edit:hover {
        background: #0056b3;
    }

    .btn-delete {
        background: #dc3545;
        color: white;
    }

    .btn-delete:hover {
        background: #c82333;
    }

    .btn-toggle {
        background: #6c757d;
        color: white;
    }

    .btn-toggle:hover {
        background: #545b62;
    }

    .drag-handle {
        cursor: move;
        color: #6c757d;
        font-size: 18px;
        margin-right: 10px;
    }

    .instructions-preview {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize sortable
    new Sortable(document.getElementById('payment-methods-list'), {
        handle: '.drag-handle',
        animation: 150,
        ghostClass: 'sortable-ghost',
        onEnd: function(evt) {
            var orders = {};
            var items = document.querySelectorAll('#payment-methods-list tr');
            items.forEach(function(item, index) {
                var id = item.dataset.id;
                orders[index] = id;
            });

            $.ajax({
                url: '{{ route("admin.payment-methods.reorder") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    orders: orders
                },
                success: function(response) {
                    console.log('Order updated successfully');
                },
                error: function(xhr) {
                    console.error('Error updating order:', xhr.responseText);
                }
            });
        }
    });

    // Toggle status
    $('.toggle-status-btn').on('click', function(e) {
        e.preventDefault();
        var btn = $(this);
        var url = btn.attr('href');
        var name = btn.data('name');

        if (confirm('Are you sure you want to toggle the status of "' + name + '"?')) {
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        }
    });

    // Delete confirmation
    $('.delete-btn').on('click', function(e) {
        e.preventDefault();
        var btn = $(this);
        var title = btn.data('title');
        var id = btn.data('id');

        if (confirm('Are you sure you want to delete "' + title + '"? This action cannot be undone.')) {
            // Find the parent form and submit it
            var form = btn.closest('.delete-form');
            if (form) {
                form.submit();
            }
        }
    });
});
</script>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="payment-methods-table">
    <!-- Payment Methods Table -->
    <div class="card border-0 shadow-sm" style="background: white;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
                    <thead style="background: #F8FAFC;">
                        <tr>
                            <th class="px-4 py-3" style="color: #1F2937; font-weight: 600; border-bottom: 2px solid #E5E7EB; width: 80px;">
                                Order
                            </th>
                            <th class="px-4 py-3" style="color: #1F2937; font-weight: 600; border-bottom: 2px solid #E5E7EB;">
                                Payment Method
                            </th>
                            <th class="px-4 py-3" style="color: #1F2937; font-weight: 600; border-bottom: 2px solid #E5E7EB;">
                                Code
                            </th>
                            <th class="px-4 py-3" style="color: #1F2937; font-weight: 600; border-bottom: 2px solid #E5E7EB;">
                                Description
                            </th>
                            <th class="px-4 py-3" style="color: #1F2937; font-weight: 600; border-bottom: 2px solid #E5E7EB;">
                                Instructions
                            </th>
                            <th class="px-4 py-3" style="color: #1F2937; font-weight: 600; border-bottom: 2px solid #E5E7EB; width: 120px;">
                                Status
                            </th>
                            <th class="px-4 py-3 text-end" style="color: #1F2937; font-weight: 600; border-bottom: 2px solid #E5E7EB; width: 200px;">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody id="payment-methods-list">
                        @forelse($paymentMethods as $paymentMethod)
                            <tr class="sortable-item" data-id="{{ $paymentMethod->id }}" style="border-bottom: 1px solid #F3F4F6;">
                                <td class="px-4" style="padding-top: 1rem; padding-bottom: 1rem;">
                                    <div class="d-flex align-items-center">
                                        <span class="drag-handle me-2" style="cursor: move; color: #9CA3AF; font-size: 1.25rem;">☰</span>
                                        <span class="badge rounded-pill px-3 py-2" style="background: #EFF6FF; color: #1E40AF; font-weight: 600; min-width: 32px;">
                                            {{ $paymentMethod->sort_order }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4" style="padding-top: 1rem; padding-bottom: 1rem;">
                                    <div class="d-flex align-items-center py-1">
                                        <div class="payment-icon me-3 rounded-lg d-flex align-items-center justify-content-center"
                                            style="width: 48px; height: 48px; background: #F3F4F6;">
                                            <i class="fas fa-credit-card" style="color: #667EEA !important; font-size: 1.5rem;"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1" style="color: #111827; font-weight: 600; font-size: 0.975rem;">
                                                {{ $paymentMethod->name }}
                                            </h6>
                                            <p class="mb-0 text-muted small">Payment Method</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4">
                                    <code class="px-2 py-1 rounded" style="background: #F3F4F6; color: #374151; font-size: 0.875rem;">
                                        {{ $paymentMethod->code }}
                                    </code>
                                </td>
                                <td class="px-4">
                                    <span style="color: #6B7280; font-size: 0.875rem;">
                                        {{ Str::limit($paymentMethod->description, 60) }}
                                    </span>
                                </td>
                                <td class="px-4">
                                    <div class="instructions-preview" style="max-width: 200px;">
                                        @if(is_array($paymentMethod->instructions))
                                            <span class="text-muted small">
                                                {{ implode(', ', array_keys($paymentMethod->instructions)) }}
                                            </span>
                                        @else
                                            <span class="text-muted small">N/A</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4">
                                    @if($paymentMethod->is_active)
                                        <span class="badge rounded-pill px-3 py-2" style="background: #ECFDF5; color: #065F46; font-weight: 500;">Active</span>
                                    @else
                                        <span class="badge rounded-pill px-3 py-2" style="background: #F3F4F6; color: #374151; font-weight: 500;">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-4 text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.payment-methods.edit', $paymentMethod) }}"
                                            class="btn btn-sm d-inline-flex align-items-center"
                                            style="background: #F9FAFB; border: 1px solid #E5E7EB; color: #374151; font-weight: 500; padding: 0.5rem 1rem;">
                                            <i class="fas fa-edit me-2 opacity-70"></i> Edit
                                        </a>
                                        <a href="{{ route('admin.payment-methods.toggle', $paymentMethod) }}"
                                            class="btn btn-sm d-inline-flex align-items-center toggle-status-btn"
                                            style="background: #FEF3C7; border: 1px solid #D97706; color: #92400E; font-weight: 500; padding: 0.5rem 1rem;"
                                            data-id="{{ $paymentMethod->id }}" data-name="{{ $paymentMethod->name }}">
                                            <i class="fas fa-power-off me-2 opacity-70"></i> Toggle
                                        </a>
                                        <form action="{{ route('admin.payment-methods.destroy', $paymentMethod) }}" method="POST"
                                            class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-sm d-inline-flex align-items-center delete-btn"
                                                style="background: #FEE2E2; border: 1px solid #EF4444; color: #991B1B; font-weight: 500; padding: 0.5rem 1rem;"
                                                data-id="{{ $paymentMethod->id }}" data-title="{{ $paymentMethod->name }}">
                                                <i class="fas fa-trash-alt me-2 opacity-70"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-16">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="empty-state mb-4 p-3 rounded-circle" style="background: #F3F4F6;">
                                            <i class="fas fa-credit-card fa-4x" style="color: #9CA3AF;"></i>
                                        </div>
                                        <h5 class="fw-normal mb-2" style="color: #374151; font-size: 1.25rem;">No Payment Methods Found</h5>
                                        <p style="color: #6B7280; font-size: 1rem;" class="mb-4">Start by adding your first payment method</p>
                                        <a href="{{ route('admin.payment-methods.create') }}"
                                            class="btn px-4 py-2 rounded-pill text-white"
                                            style="background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%); border: none;">
                                            <i class="fas fa-plus me-2"></i> Add Payment Method
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
