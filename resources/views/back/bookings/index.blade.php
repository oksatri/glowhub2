@extends('back._parts.master')

@section('page-title', 'Bookings')
@section('content')
    @php
        $bookingsIndexUrl = route(
            auth()->check() && auth()->user()->role === 'mua' ? 'mua.bookings.index' : 'admin.bookings.index',
        );
        $bookingsUpdateName =
            auth()->check() && auth()->user()->role === 'mua' ? 'mua.bookings.update' : 'admin.bookings.update';
    @endphp
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-2" style="color: #2D3748; font-weight: 600;">Bookings</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0" style="font-size: 0.95rem;">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}" class="text-decoration-none" style="color: #6B7280;">
                            <i class="fas fa-home me-1 opacity-75"></i>Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item active" style="color: #4B5563;">Bookings</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card border-0 shadow-sm mb-4">

        <!-- Search & Filter Card (aligned with content management) -->
        <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(to right, #F9FAFB, #F3F4F6);">
            <div class="card-body px-4 py-4">
                <form method="GET" action="{{ $bookingsIndexUrl }}" class="mb-0">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-5 col-md-6">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-0 ps-4">
                                    <i class="fas fa-search" style="color: #9CA3AF;"></i>
                                </span>
                                <input type="text" name="q" class="form-control border-0 ps-2 shadow-none"
                                    style="background: white; font-size: 0.95rem;"
                                    placeholder="Search by customer, MUA or service..." value="{{ $q ?? '' }}">
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-6">
                            <select name="status" class="form-select shadow-none border-0"
                                style="background: white; height: 48px; font-size: 0.95rem;">
                                <option value="">All Status</option>
                                <option value="pending" {{ isset($status) && $status == 'pending' ? 'selected' : '' }}>
                                    Pending</option>
                                <option value="confirmed" {{ isset($status) && $status == 'confirmed' ? 'selected' : '' }}>
                                    Confirmed</option>
                                <option value="rejected" {{ isset($status) && $status == 'rejected' ? 'selected' : '' }}>
                                    Rejected</option>
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-6">
                            <input type="date" name="date" class="form-control shadow-none border-0"
                                style="height:48px; background:white;" value="{{ $date ?? '' }}">
                        </div>

                        <div class="col-lg-3 col-md-6 d-flex gap-2">
                            <button type="submit" class="btn flex-fill py-2 text-white"
                                style="background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%); border: none; font-size: 0.95rem;">
                                <i class="fas fa-filter me-2 opacity-75"></i>Apply Filter
                            </button>
                            @if (request()->hasAny(['q', 'status', 'date']))
                                <a href="{{ $bookingsIndexUrl }}" class="btn py-2 px-3"
                                    style="background: white; border: 1px solid #E5E7EB; color: #4B5563;">
                                    <i class="fas fa-times opacity-50"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
                    <thead style="background: #F8FAFC;">
                        <tr>
                            <th class="px-4 py-3" style="color: #1F2937; font-weight: 600;">Booking</th>
                            <th class="py-3" style="width: 160px; color: #1F2937; font-weight: 600;">Date / Time</th>
                            <th class="py-3" style="width: 120px; color: #1F2937; font-weight: 600;">Status</th>
                            <th class="py-3 text-end px-4" style="width: 220px; color: #1F2937; font-weight: 600;">Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $b)
                            <tr style="border-bottom: 1px solid #F3F4F6;">
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3 rounded-lg d-flex align-items-center justify-content-center"
                                            style="width:48px; height:48px; background:#F3F4F6;">
                                            <i class="fas fa-user" style="color:#9CA3AF; font-size:1.25rem;"></i>
                                        </div>
                                        <div>
                                            <div style="font-weight:600; color:#111827;">
                                                {{ optional($b->mua)->name ?? 'N/A' }} —
                                                {{ optional($b->service)->service_name ?? '-' }}</div>
                                            <div style="color:#6B7280; font-size:0.9rem;">Customer:
                                                {{ $b->customer_name ?? optional($b->customer)->name }} •
                                                {{ $b->customer_whatsapp ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="d-flex flex-column">
                                        <span
                                            style="color:#374151; font-weight:500;">{{ optional($b->selected_date)->format('M d, Y') }}</span>
                                        <span style="color:#6B7280;">{{ $b->selected_time }}</span>
                                    </div>
                                </td>

                                <td>
                                    @switch($b->status)
                                        @case('pending')
                                            <span class="badge rounded-pill px-3 py-2"
                                                style="background:#FEF3C7; color:#92400E;">Pending</span>
                                        @break

                                        @case('completed')
                                            <span class="badge rounded-pill px-3 py-2"
                                                style="background:#ECFDF5; color:#065F46;">Completed</span>
                                        @break

                                        @case('rejected')
                                            <span class="badge rounded-pill px-3 py-2"
                                                style="background:#FEE2E2; color:#991B1B;">Rejected</span>
                                        @break

                                        @default
                                            <span class="badge rounded-pill px-3 py-2"
                                                style="background:#EFF6FF; color:#1E40AF;">{{ ucfirst($b->status) }}</span>
                                    @endswitch
                                </td>

                                <td class="text-end px-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        @if ($b->status != 'confirmed' && $b->status != 'rejected')
                                            {{-- Accept form: immediately mark as completed (with JS confirm) --}}
                                            <form action="{{ route($bookingsUpdateName, $b->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to approve this request?');">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="confirmed">
                                                <button class="btn btn-sm d-inline-flex align-items-center accept-btn"
                                                    style="background:#ECFDF5; border:1px solid #059669; color:#065F46; padding:0.5rem 1rem; font-weight:500;"><i
                                                        class="fas fa-check-circle me-2 opacity-70"></i> Accept</button>
                                            </form>

                                            {{-- Reject: open modal to capture admin note (with confirm) --}}
                                            <button type="button"
                                                class="btn btn-sm d-inline-flex align-items-center btn-reject"
                                                onclick="$('#rejectModal').modal('show');$('#rejectForm').attr('action', '{{ route($bookingsUpdateName, $b->id) }}');$('#admin_note').val('');"
                                                style="background:#FEE2E2; border:1px solid #EF4444; color:#991B1B; padding:0.5rem 1rem; font-weight:500;">
                                                <i class="fas fa-times-circle me-2 opacity-70"></i> Reject
                                            </button>
                                        @else
                                            <span class="text-muted small">#BK{{ $b->id }}</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-16">
                                        <div class="d-flex flex-column align-items-center">
                                            <div class="empty-state mb-4 p-3 rounded-circle" style="background: #F3F4F6;">
                                                <i class="fas fa-calendar-times fa-4x" style="color: #9CA3AF;"></i>
                                            </div>
                                            <h5 class="fw-normal mb-2" style="color: #374151; font-size: 1.25rem;">No Bookings
                                                Found</h5>
                                            <p style="color: #6B7280; font-size: 1rem;">No booking requests at the moment</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $bookings->links() }}
        </div>

        {{-- Reject modal --}}
        <div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="rejectForm" method="POST" action="#">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="rejected">
                        <div class="modal-header">
                            <h5 class="modal-title">Reject Booking</h5>
                            {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="admin_note" class="form-label">Reason for rejection</label>
                                <textarea name="admin_note" id="admin_note" class="form-control" rows="4" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                onclick="$('#rejectModal').modal('hide')">Cancel</button>
                            <button type="submit" class="btn btn-danger">Reject Booking</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
