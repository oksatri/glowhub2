@extends('back._parts.master')

@section('title', 'Payment Methods Management')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.css" rel="stylesheet">
<style>
    .payment-methods-table {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .table-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        display: flex;
        justify-content: between;
        align-items: center;
    }

    .table-header h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
    }

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
    $('.btn-toggle').on('click', function(e) {
        e.preventDefault();
        var btn = $(this);
        var url = btn.attr('href');

        if (confirm('Are you sure you want to toggle this payment method status?')) {
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
    $('.btn-delete').on('click', function(e) {
        e.preventDefault();
        var btn = $(this);
        var url = btn.attr('href');

        if (confirm('Are you sure you want to delete this payment method?')) {
            $.ajax({
                url: url,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    btn.closest('tr').fadeOut(300, function() {
                        $(this).remove();
                    });
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
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
                <div class="table-header">
                    <h3>💳 Payment Methods Management</h3>
                    <a href="{{ route('admin.payment-methods.create') }}" class="btn btn-light">
                        <i class="fas fa-plus me-2"></i>Add Payment Method
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">Order</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Description</th>
                                <th>Instructions</th>
                                <th width="100">Status</th>
                                <th width="120">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="payment-methods-list">
                            @foreach($paymentMethods as $paymentMethod)
                                <tr class="sortable-item" data-id="{{ $paymentMethod->id }}">
                                    <td>
                                        <span class="drag-handle">☰</span>
                                        {{ $paymentMethod->sort_order }}
                                    </td>
                                    <td>
                                        <strong>{{ $paymentMethod->name }}</strong>
                                    </td>
                                    <td>
                                        <code>{{ $paymentMethod->code }}</code>
                                    </td>
                                    <td>{{ $paymentMethod->description }}</td>
                                    <td>
                                        <div class="instructions-preview" title="{{ json_encode($paymentMethod->instructions) }}">
                                            {{ is_array($paymentMethod->instructions) ? implode(', ', array_keys($paymentMethod->instructions)) : 'N/A' }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($paymentMethod->is_active)
                                            <span class="status-badge status-active">Active</span>
                                        @else
                                            <span class="status-badge status-inactive">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.payment-methods.edit', $paymentMethod) }}" class="btn-sm btn-edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.payment-methods.toggle', $paymentMethod) }}" class="btn-sm btn-toggle">
                                                <i class="fas fa-power-off"></i>
                                            </a>
                                            <form action="{{ route('admin.payment-methods.destroy', $paymentMethod) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-sm btn-delete" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($paymentMethods->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                            <h5>No payment methods found</h5>
                            <p class="text-muted">Start by adding your first payment method.</p>
                            <a href="{{ route('admin.payment-methods.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Add Payment Method
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
