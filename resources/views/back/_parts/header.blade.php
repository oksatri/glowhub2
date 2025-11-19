<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-md">
        <div class="navbar-header" data-logobg="skin6">
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                    class="ti-menu ti-close"></i></a>
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <div class="navbar-brand">
                <!-- Logo icon -->
                <a href="{{ route('dashboard') }}" class="navbar-brand">
                    <b class="logo-icon">
                        <img src="{{ asset('images/logo/logo_saja.png') }}" alt="GlowHub" />
                    </b>
                    <span class="logo-text"
                        style="font-family: 'Poppins', sans-serif !important; font-weight: bold; color: #5A189A;">
                        GlowHub
                    </span>
                </a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-left mr-auto ml-3 pl-1">
                <!-- Notification -->
                <li class="nav-item dropdown">
                    @php
                        use App\Models\Booking;
                        $pendingQuery = Booking::where('status', 'pending');
                        if (auth()->check() && auth()->user()->role === 'mua') {
                            $pendingQuery->whereHas('mua', function ($q) {
                                $q->where('user_id', auth()->user()->id);
                            });
                        }
                        $pendingCount = $pendingQuery->count();
                        $recent = (clone $pendingQuery)->latest()->take(5)->get();

                        // choose routes depending on role (admin vs mua)
                        $bookingsIndexRoute =
                            auth()->check() && auth()->user()->role === 'mua'
                                ? route('auth-mua.bookings.index')
                                : route('admin.bookings.index');
                        $bookingsPendingRoute =
                            auth()->check() && auth()->user()->role === 'mua'
                                ? route('auth-mua.bookings.pending')
                                : route('admin.bookings.pending');
                    @endphp
                    <a class="nav-link dropdown-toggle pl-md-3 position-relative" href="#" id="bell"
                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span><i data-feather="bell" class="svg-icon"></i></span>
                        @if ($pendingCount > 0)
                            <span class="badge badge-primary notify-no rounded-circle">{{ $pendingCount }}</span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-left mailbox animated bounceInDown" aria-labelledby="bell">
                        <ul class="list-style-none mb-0">
                            <li>
                                <div class="message-center notifications position-relative">
                                    @forelse($recent as $r)
                                        <div class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                            <div class="btn btn-warning rounded-circle btn-circle">
                                                <i data-feather="calendar" class="text-white"></i>
                                            </div>
                                            <div class="w-75 d-inline-block v-middle pl-2">
                                                <h6 class="message-title mb-0 mt-1">BK #{{ $r->id }}</h6>
                                                <span class="font-12 text-nowrap d-block text-muted">
                                                    {{ $r->customer_name ?? optional($r->customer)->name }}
                                                </span>
                                                <span class="font-12 text-nowrap d-block text-muted">
                                                    {{ optional($r->selected_date)->format('Y-m-d') }}
                                                    {{ $r->selected_time }}
                                                </span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="px-3 py-2 text-muted">No new bookings</div>
                                    @endforelse
                                </div>
                            </li>
                            <li class="text-center">
                                <a href="{{ $bookingsIndexRoute }}" class="d-block mt-2">See all</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- End Notification -->
                <!-- ============================================================== -->
                <!-- create new -->
                <!-- ============================================================== -->

            </ul>
            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-right">
                <!-- ============================================================== -->
                <!-- Search -->
                <!-- ============================================================== -->
                <li class="nav-item d-none d-md-block">
                    <a class="nav-link" href="javascript:void(0)">
                        <form>
                            <div class="customize-input">
                                <input class="form-control custom-shadow custom-radius border-0 bg-white" type="search"
                                    placeholder="Search" aria-label="Search">
                                <i class="form-control-icon" data-feather="search"></i>
                            </div>
                        </form>
                    </a>
                </li>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        @php
                            $user = auth()->user();
                            $profile = $user->profile_image ?? null;
                            if ($profile) {
                                // if it's a full URL use it, otherwise assume it's stored in storage/app/public
                                $src = filter_var($profile, FILTER_VALIDATE_URL)
                                    ? $profile
                                    : asset('uploads/' . ltrim($profile, '/'));
                            } else {
                                $src = asset('admin/assets/images/users/profile-pic.jpg');
                            }
                        @endphp
                        <img src="{{ $src }}" alt="{{ $user->name }}" class="rounded-circle" width="40">
                        <span class="ml-2 d-none d-lg-inline-block"><span>Hello,</span> <span
                                class="text-dark">{{ auth()->user()->name }}</span> <i data-feather="chevron-down"
                                class="svg-icon"></i></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                        <a class="dropdown-item" href="{{ route('profile.edit') }}"><i data-feather="user"
                                class="svg-icon mr-2 ml-1"></i>
                            My Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"><i data-feather="power"
                                class="svg-icon mr-2 ml-1"></i>
                            Logout</a>

                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
            </ul>
        </div>
    </nav>
</header>

@once
    @push('scripts')
        <script>
            (function() {
                // Wait until DOM ready
                document.addEventListener('DOMContentLoaded', function() {
                    var POLL_INTERVAL = 10000; // ms

                    function applyItemsAndCount(data) {
                        try {
                            var count = parseInt(data.count || 0, 10) || 0;

                            // Update badge
                            var badge = document.querySelector('.notify-no');
                            if (count > 0) {
                                if (badge) badge.textContent = count;
                                else {
                                    var bell = document.querySelector('#bell');
                                    if (bell) {
                                        var span = document.createElement('span');
                                        span.className = 'badge badge-primary notify-no rounded-circle';
                                        span.textContent = String(count);
                                        bell.appendChild(span);
                                    }
                                }
                            } else if (badge) {
                                // remove badge when zero
                                badge.remove();
                            }

                            // Replace recent list markup with latest items
                            var container = document.querySelector('.message-center.notifications');
                            if (container) {
                                // clear
                                container.innerHTML = '';

                                if (data.recent && data.recent.length) {
                                    data.recent.forEach(function(item) {
                                        var div = document.createElement('div');
                                        div.className =
                                            'message-item d-flex align-items-center border-bottom px-3 py-2';

                                        var icon = document.createElement('div');
                                        icon.className = 'btn btn-warning rounded-circle btn-circle';
                                        icon.innerHTML =
                                            '<i data-feather="calendar" class="text-white"></i>';

                                        var info = document.createElement('div');
                                        info.className = 'w-75 d-inline-block v-middle pl-2';

                                        var title = document.createElement('h6');
                                        title.className = 'message-title mb-0 mt-1';
                                        title.textContent = 'Booking #' + (item.id || '');

                                        var nameSpan = document.createElement('span');
                                        nameSpan.className = 'font-12 text-nowrap d-block text-muted';
                                        nameSpan.textContent = item.customer_name || '';

                                        var dateSpan = document.createElement('span');
                                        dateSpan.className = 'font-12 text-nowrap d-block text-muted';
                                        var dateText = '';
                                        if (item.selected_date) dateText += item.selected_date;
                                        if (item.selected_time) dateText += ' ' + item.selected_time;
                                        dateSpan.textContent = dateText;

                                        info.appendChild(title);
                                        info.appendChild(nameSpan);
                                        info.appendChild(dateSpan);

                                        div.appendChild(icon);
                                        div.appendChild(info);

                                        container.appendChild(div);
                                    });
                                } else {
                                    var empty = document.createElement('div');
                                    empty.className = 'px-3 py-2 text-muted';
                                    empty.textContent = 'No new bookings';
                                    container.appendChild(empty);
                                }

                                // Update 'Total Pending' text
                                var totalElem = document.querySelector(
                                    '.nav-link.pt-3.text-center.text-dark.mb-0 strong');
                                if (totalElem) totalElem.textContent = 'Total Pending: ' + count;

                                // Refresh feather icons inside the newly built nodes
                                if (window.feather) window.feather.replace();
                            }
                        } catch (err) {
                            console.error('applyItemsAndCount error', err);
                        }
                    }

                    function pollPending() {
                        var url = "{{ $bookingsPendingRoute }}";
                        fetch(url, {
                                credentials: 'same-origin',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(function(res) {
                                return res.json();
                            })
                            .then(function(data) {
                                applyItemsAndCount(data);
                            })
                            .catch(function(err) {
                                // ignore network errors silently
                            });
                    }

                    // If Echo is configured, use real-time listener. Otherwise fallback to polling.
                    if (typeof window.Echo !== 'undefined') {
                        try {
                            window.Echo.channel('bookings').listen('BookingCreated', function(e) {
                                var booking = e.booking || e;

                                // increment badge or create
                                var badge = document.querySelector('.notify-no');
                                var current = badge ? (parseInt(badge.textContent || '0', 10) || 0) : 0;
                                var newCount = current + 1;
                                if (badge) badge.textContent = newCount;
                                else {
                                    var bell = document.querySelector('#bell');
                                    if (bell) {
                                        var span = document.createElement('span');
                                        span.className = 'badge badge-primary notify-no rounded-circle';
                                        span.textContent = String(newCount);
                                        bell.appendChild(span);
                                    }
                                }

                                // prepend item to recent list so user sees it instantly
                                var container = document.querySelector('.message-center.notifications');
                                if (container) {
                                    var div = document.createElement('div');
                                    div.className =
                                        'message-item d-flex align-items-center border-bottom px-3 py-2';

                                    var icon = document.createElement('div');
                                    icon.className = 'btn btn-warning rounded-circle btn-circle';
                                    icon.innerHTML = '<i data-feather="calendar" class="text-white"></i>';

                                    var info = document.createElement('div');
                                    info.className = 'w-75 d-inline-block v-middle pl-2';

                                    var title = document.createElement('h6');
                                    title.className = 'message-title mb-0 mt-1';
                                    title.textContent = 'Booking #' + (booking.id || booking.booking_id ||
                                        '');

                                    var nameSpan = document.createElement('span');
                                    nameSpan.className = 'font-12 text-nowrap d-block text-muted';
                                    nameSpan.textContent = booking.customer_name || '';

                                    var dateSpan = document.createElement('span');
                                    dateSpan.className = 'font-12 text-nowrap d-block text-muted';
                                    var dateText = '';
                                    if (booking.selected_date) dateText += booking.selected_date;
                                    if (booking.selected_time) dateText += ' ' + booking.selected_time;
                                    dateSpan.textContent = dateText;

                                    info.appendChild(title);
                                    info.appendChild(nameSpan);
                                    info.appendChild(dateSpan);

                                    div.appendChild(icon);
                                    div.appendChild(info);

                                    var empty = container.querySelector('.px-3.py-2.text-muted');
                                    if (empty) empty.remove();
                                    if (container.firstChild) container.insertBefore(div, container
                                        .firstChild);
                                    else container.appendChild(div);

                                    var totalElem = document.querySelector(
                                        '.nav-link.pt-3.text-center.text-dark.mb-0 strong');
                                    if (totalElem) {
                                        var cur = parseInt(totalElem.textContent.replace(/[^0-9]/g, ''),
                                            10) || 0;
                                        totalElem.textContent = 'Total Pending: ' + (cur + 1);
                                    }

                                    if (window.feather) window.feather.replace();
                                }
                            });
                        } catch (err) {
                            console.error('Echo booking listener error', err);
                            // if Echo failed for some reason, fall back to polling
                            pollPending();
                            setInterval(pollPending, POLL_INTERVAL);
                        }
                    } else {
                        // Poll every POLL_INTERVAL ms for pending updates if Echo not available
                        pollPending();
                        setInterval(pollPending, POLL_INTERVAL);
                    }
                });
            })
            ();
        </script>
    @endpush
@endonce
