<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h4><i class="fas fa-gem me-2"></i>GlowHub</h4>
        <small class="d-block text-light" style="opacity: 0.7;">Admin Panel</small>
    </div>

    <div class="sidebar-menu">
        <div class="menu-item">
            <a href="{{ route('admin.dashboard') }}"
                class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{ route('admin.content.index') }}"
                class="menu-link {{ request()->routeIs('admin.content.*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i>
                <span>Content</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{ route('admin.categories.index') }}"
                class="menu-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-folder"></i>
                <span>Categories</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{ route('admin.services.index') }}"
                class="menu-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                <i class="fas fa-concierge-bell"></i>
                <span>Services</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{ route('admin.testimonials.index') }}"
                class="menu-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                <i class="fas fa-star"></i>
                <span>Testimonials</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{ route('admin.hero-sections.index') }}"
                class="menu-link {{ request()->routeIs('admin.hero-sections.*') ? 'active' : '' }}">
                <i class="fas fa-image"></i>
                <span>Hero Sections</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{ route('admin.how-it-works.index') }}"
                class="menu-link {{ request()->routeIs('admin.how-it-works.*') ? 'active' : '' }}">
                <i class="fas fa-list-ol"></i>
                <span>How It Works</span>
            </a>
        </div>

        <hr style="border-color: rgba(255,255,255,0.1); margin: 20px 0;">

        <div class="menu-item">
            <a href="{{ url('/') }}" class="menu-link" target="_blank">
                <i class="fas fa-external-link-alt"></i>
                <span>View Website</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="#" class="menu-link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>
</div>

<form id="logout-form" action="#" method="POST" style="display: none;">
    @csrf
</form>
