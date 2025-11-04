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
