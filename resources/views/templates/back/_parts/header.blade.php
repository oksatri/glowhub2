<div class="admin-header">
    <div class="d-flex align-items-center">
        <!-- Desktop Toggle -->
        <button class="sidebar-toggle d-none d-md-block">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Mobile Toggle -->
        <button class="sidebar-toggle d-md-none" id="mobileSidebarToggle">
            <i class="fas fa-bars"></i>
        </button>

        <div class="ms-3">
            <h5 class="mb-0 d-none d-md-block">@yield('page-title', 'Dashboard')</h5>
            <h6 class="mb-0 d-md-none">@yield('page-title', 'Dashboard')</h6>
            <small class="text-muted d-none d-sm-block">@yield('page-subtitle', 'Welcome to GlowHub Admin')</small>
        </div>
    </div>

    <div class="header-actions">
        <!-- Notifications -->
        <div class="dropdown">
            <button class="btn btn-link text-dark position-relative" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-bell fs-5"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                    style="font-size: 10px;">
                    3
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-end" style="width: 300px;">
                <h6 class="dropdown-header">Notifications</h6>
                <a class="dropdown-item" href="#">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-file-alt text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold">New content published</div>
                            <small class="text-muted">2 minutes ago</small>
                        </div>
                    </div>
                </a>
                <a class="dropdown-item" href="#">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold">New testimonial received</div>
                            <small class="text-muted">1 hour ago</small>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-center" href="#">View all notifications</a>
            </div>
        </div>

        <!-- User Info -->
        <div class="dropdown">
            <button class="btn btn-link text-dark d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                <div class="user-avatar me-2">
                    <i class="fas fa-user"></i>
                </div>
                <div class="user-info d-none d-md-block">
                    <div class="fw-bold">Admin User</div>
                    <small class="text-muted">Administrator</small>
                </div>
                <i class="fas fa-chevron-down ms-2"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user me-2"></i>Profile
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cog me-2"></i>Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a>
            </div>
        </div>
    </div>
</div>
