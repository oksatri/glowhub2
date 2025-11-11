<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ route('dashboard') }}"
                        aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span
                            class="hide-menu">Dashboard</span></a>
                </li>
                {{-- <li class="list-divider"></li> --}}
                {{-- <li class="nav-small-cap"><span class="hide-menu">Mater Data</span></li> --}}
                @switch(auth()->user()->role)
                    @case('admin')
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->is('content-management*') ? 'active' : '' }}"
                                href="{{ url('content-management') }}" aria-expanded="false">
                                <i data-feather="file-text" class="feather-icon"></i>
                                <span class="hide-menu">Content Management</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->is('testimonials*') ? 'active' : '' }}"
                                href="{{ url('testimonials') }}" aria-expanded="false">
                                <i data-feather="star" class="feather-icon"></i>
                                <span class="hide-menu">Testimonials</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->is('muas*') ? 'active' : '' }}" href="{{ url('muas') }}"
                                aria-expanded="false">
                                <i data-feather="box" class="feather-icon"></i>
                                <span class="hide-menu">MUA Management</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            @php
                                $pendingCount = App\Models\Booking::with(['mua'])->where('status', 'pending');
                                if (auth()->user() && auth()->user()->role !== 'admin') {
                                    $pendingCount->whereHas('mua', function ($q) {
                                        $q->where('user_id', auth()->user()->id);
                                    });
                                }
                                $pendingCount = $pendingCount->count();
                                $bookingsRoute =
                                    auth()->check() && auth()->user()->role === 'mua'
                                        ? route('auth-mua.bookings.index')
                                        : route('admin.bookings.index');
                            @endphp
                            <a class="sidebar-link {{ request()->is('bookings*') || request()->is('mua/bookings*') ? 'active' : '' }}"
                                href="{{ $bookingsRoute }}" aria-expanded="false">
                                <i data-feather="calendar" class="feather-icon"></i>
                                <span class="hide-menu">Bookings</span>
                                @if ($pendingCount > 0)
                                    <span class="badge bg-danger text-white rounded-pill ms-2">{{ $pendingCount }}</span>
                                @endif
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->is('users*') ? 'active' : '' }}" href="{{ url('users') }}"
                                aria-expanded="false">
                                <i data-feather="users" class="feather-icon"></i>
                                <span class="hide-menu">User Management</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->is('settings') || request()->is('settings/*') ? 'active' : '' }}"
                                href="{{ url('settings') }}" aria-expanded="false">
                                <i data-feather="settings" class="feather-icon"></i>
                                <span class="hide-menu">Settings</span>
                            </a>
                        </li>
                    @break

                    @case('mua')
                        @php
                            $mua = \App\Models\Mua::where('user_id', auth()->user()->id)->first();
                        @endphp
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->is('muas*') ? 'active' : '' }}"
                                href="{{ $mua ? url('muas/' . $mua->id . '/edit') : url('muas/create') }}"
                                aria-expanded="false">
                                <i data-feather="box" class="feather-icon"></i>
                                <span class="hide-menu">MUA Management</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            @php
                                $pendingCount = App\Models\Booking::with(['mua'])->where('status', 'pending');
                                if (auth()->user() && auth()->user()->role !== 'admin') {
                                    $pendingCount->whereHas('mua', function ($q) {
                                        $q->where('user_id', auth()->user()->id);
                                    });
                                }
                                $pendingCount = $pendingCount->count();
                                $bookingsRoute =
                                    auth()->check() && auth()->user()->role === 'mua'
                                        ? route('auth-mua.bookings.index')
                                        : route('admin.bookings.index');
                            @endphp
                            <a class="sidebar-link {{ request()->is('bookings*') || request()->is('mua/bookings*') ? 'active' : '' }}"
                                href="{{ $bookingsRoute }}" aria-expanded="false">
                                <i data-feather="calendar" class="feather-icon"></i>
                                <span class="hide-menu">Bookings</span>
                                @if ($pendingCount > 0)
                                    <span class="badge bg-danger text-white rounded-pill ms-2">{{ $pendingCount }}</span>
                                @endif
                            </a>
                        </li>
                    @break

                @endswitch


                <li class="list-divider"></li>

                <li class="sidebar-item">
                    <a class="sidebar-link" target="_blank" href="{{ url('/') }}" aria-expanded="false">
                        <i data-feather="external-link" class="feather-icon"></i>
                        <span class="hide-menu">Visit Website</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
