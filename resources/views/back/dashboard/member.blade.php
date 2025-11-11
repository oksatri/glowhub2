@php
    // Member dashboard partial: focused on user's upcoming bookings and quick actions
    $user = auth()->user();
    $myBookings = collect($recentBookings ?? [])->filter(function($b) use ($user) {
        // try matching by user id or customer email/name
        if (isset($b->user_id) && $b->user_id == $user->id) return true;
        if (isset($b->customer_email) && $b->customer_email == $user->email) return true;
        if (isset($b->customer_name) && strtolower($b->customer_name) == strtolower($user->name)) return true;
        return false;
    });
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-1" style="color: #2D3748; font-weight:600;">Member Dashboard</h1>
        <p class="text-muted small mb-0">Your bookings, favorites and quick profile actions.</p>
    </div>
    <a href="{{ url('profile') }}" class="btn px-3 py-2" style="background:white; border:1px solid #E5E7EB; color:#374151;">
        <i class="fas fa-user me-2"></i>Edit Profile
    </a>
</div>

<div class="card-group mb-4">
    <div class="card">
        <div class="card-body">
            <h5 class="mb-1">Upcoming</h5>
            <h3 class="mb-0">{{ number_format($myBookings->count()) }}</h3>
            <p class="text-muted small mt-2">Your next appointments.</p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="mb-1">Favorites</h5>
            <h3 class="mb-0">—</h3>
            <p class="text-muted small mt-2">Your favorited MUAs.</p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="mb-1">Credits</h5>
            <h3 class="mb-0">—</h3>
            <p class="text-muted small mt-2">Available credits or promos.</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Your Upcoming Bookings</h4>
                <div class="mt-3">
                    @forelse($myBookings as $b)
                        <div class="d-flex align-items-start border-left-line pb-3 mb-2">
                            <div>
                                <a href="{{ route('back.bookings.show', $b->id) }}" class="btn btn-info btn-circle mb-2 btn-item"><i data-feather="calendar"></i></a>
                            </div>
                            <div class="ml-3 mt-2">
                                <h5 class="text-dark font-weight-medium mb-1">{{ $b->customer_name ?? '—' }}</h5>
                                <p class="text-muted mb-1">{{ $b->selected_date ?? '' }} {{ $b->selected_time ?? '' }} — <strong class="text-capitalize">{{ $b->status }}</strong></p>
                                <span class="font-14 text-muted">Booked on {{ optional($b->created_at)->format('d M Y') }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted">No upcoming bookings</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Quick Actions</h4>
                <div class="d-grid gap-2">
                    <a href="{{ url('bookings/create') }}" class="btn btn-primary">Book a MUA</a>
                    <a href="{{ url('mua-listing') }}" class="btn btn-outline-secondary">Browse MUAs</a>
                    <a href="{{ url('profile') }}" class="btn btn-outline-secondary">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>
