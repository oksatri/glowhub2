@php
    // MUA dashboard partial: focused on the MUA's bookings, earnings and profile quick actions
    $user = auth()->user();
    $myBookings = collect($recentBookings ?? [])->filter(function($b) use ($user) {
        return isset($b->mua_id) && $b->mua_id == $user->id;
    });
    $mua = \App\Models\Mua::where('user_id', auth()->user()->id)->first();
    $muaBase = auth()->check() && auth()->user()->role === 'admin' ? 'admin/muas' : 'muas';
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-1" style="color: #2D3748; font-weight:600;">MUA Dashboard</h1>
        <p class="text-muted small mb-0">Quick overview of your bookings, earnings and schedule.</p>
    </div>
    <a href="{{ url('content-management') }}" class="btn px-3 py-2" style="background:white; border:1px solid #E5E7EB; color:#374151;">
        <i class="fas fa-user-cog me-2"></i>Manage Profile
    </a>
</div>

<div class="card-group mb-4">
    <div class="card">
        <div class="card-body">
            <h5 class="mb-1">My Bookings</h5>
            <h3 class="mb-0">{{ number_format($myBookings->count()) }}</h3>
            <p class="text-muted small mt-2">Recent & upcoming bookings assigned to you.</p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="mb-1">Pending</h5>
            <h3 class="mb-0">{{ number_format(collect($myBookings)->filter(fn($b)=> $b->status==='pending')->count()) }}</h3>
            <p class="text-muted small mt-2">Bookings awaiting your confirmation.</p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="mb-1">Earnings (est.)</h5>
            <h3 class="mb-0">Rp. —</h3>
            <p class="text-muted small mt-2">Estimated earnings this month (placeholder).</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Upcoming Bookings</h4>
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
                        <div class="text-muted">No bookings assigned to you.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Actions</h4>
                <div class="d-grid gap-2">
                    <a href="{{ route('auth-mua.bookings.index') }}" class="btn btn-primary">Manage all bookings</a>
                    <a href="{{ $mua ? url($muaBase . '/' . $mua->id . '/edit') : url($muaBase . '/create') }}" class="btn btn-outline-secondary">Manage Services</a>
                </div>
            </div>
        </div>
    </div>
</div>
