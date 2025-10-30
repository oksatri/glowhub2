<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="format-detection" content="telephone=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <title>@yield('title', 'Admin Panel') - GlowHub</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom Admin CSS -->
    <style>
        /* Global Reset */
        * {
            box-sizing: border-box;
        }

        html,
        body {
            overflow-x: hidden;
            width: 100%;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary-color: #ff6b6b;
            --secondary-color: #4ecdc4;
            --success-color: #45b7d1;
            --warning-color: #f9ca24;
            --danger-color: #f0932b;
            --info-color: #6c5ce7;
            --light-color: #f8f9fa;
            --dark-color: #2d3436;
            --sidebar-width: 280px;
            --header-height: 70px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(135deg, var(--primary-color) 0%, #ff8a80 100%);
            color: white;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .sidebar-header h4 {
            margin: 0;
            font-weight: 600;
            transition: opacity 0.3s ease;
        }

        .sidebar.collapsed .sidebar-header h4 {
            opacity: 0;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .sidebar-menu .menu-item {
            margin-bottom: 5px;
        }

        .sidebar-menu .menu-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-menu .menu-link:hover,
        .sidebar-menu .menu-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: white;
        }

        .sidebar-menu .menu-link i {
            width: 20px;
            margin-right: 15px;
            text-align: center;
        }

        .sidebar.collapsed .sidebar-menu .menu-link span {
            display: none;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .sidebar.collapsed~.main-content {
            margin-left: 70px;
        }

        /* Header */
        .admin-header {
            background: white;
            padding: 0 30px;
            height: var(--header-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            color: var(--dark-color);
            font-size: 18px;
            cursor: pointer;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        /* Content Area */
        .content-area {
            padding: 30px;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
        }

        .page-subtitle {
            color: #6c757d;
            margin-top: 5px;
        }

        /* Cards */
        .admin-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: none;
            overflow: hidden;
        }

        .admin-card .card-header {
            background: none;
            border-bottom: 1px solid #e9ecef;
            padding: 20px 25px;
            font-weight: 600;
        }

        .admin-card .card-body {
            padding: 25px;
        }

        /* Buttons */
        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 8px;
            padding: 10px 24px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background: #ff5252;
            border-color: #ff5252;
        }

        .btn-secondary {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
            border-radius: 8px;
        }

        .btn-sm {
            padding: 6px 16px;
            font-size: 14px;
        }

        /* Tables */
        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }

        .table {
            margin: 0;
        }

        .table th {
            background: #f8f9fa;
            border: none;
            font-weight: 600;
            color: var(--dark-color);
            padding: 15px;
        }

        .table td {
            padding: 15px;
            vertical-align: middle;
            border-color: #e9ecef;
        }

        /* Form Elements */
        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #e9ecef;
            padding: 12px 15px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 107, 0.25);
        }

        .form-label {
            font-weight: 500;
            color: var(--dark-color);
            margin-bottom: 8px;
        }

        /* Alerts */
        .alert {
            border-radius: 8px;
            border: none;
        }

        /* Stats Cards */
        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border-left: 4px solid var(--primary-color);
            transition: transform 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-number {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }

        .stats-label {
            color: #6c757d;
            font-size: 14px;
            margin-top: 5px;
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            body {
                overflow-x: hidden;
            }

            .sidebar {
                position: fixed !important;
                top: 0;
                left: -100%;
                height: 100vh;
                width: 280px;
                z-index: 1050;
                transition: left 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
                background: linear-gradient(135deg, var(--primary-color) 0%, #ff8a80 100%);
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
                overflow-y: auto;
                transform: none;
                will-change: left;
            }

            .sidebar.show {
                left: 0 !important;
                transform: none;
            }

            /* Ensure sidebar content is visible on mobile */
            .sidebar .sidebar-header,
            .sidebar .sidebar-menu {
                opacity: 1;
                visibility: visible;
            }

            /* Reset collapsed state on mobile */
            .sidebar.collapsed {
                width: 280px;
            }

            .sidebar.collapsed .sidebar-header h4,
            .sidebar.collapsed .sidebar-menu .menu-link span {
                opacity: 1;
                display: block;
            }

            /* Mobile sidebar toggle button */
            .sidebar-toggle {
                color: var(--dark-color);
                background: none;
                border: none;
                font-size: 1.2rem;
                padding: 0.5rem;
                cursor: pointer;
                transition: color 0.3s ease;
            }

            .sidebar-toggle:hover {
                color: var(--primary-color);
            }

            .main-content {
                margin-left: 0 !important;
                width: 100%;
                padding: 0;
            }

            .content-area {
                padding: 10px;
            }

            .admin-header {
                padding: 0 10px;
                height: 55px;
                width: 100%;
                left: 0;
                border-bottom: 1px solid #e9ecef;
            }

            .admin-header h5,
            .admin-header h6 {
                font-size: 1rem;
                font-weight: 600;
            }

            .admin-header .text-muted {
                font-size: 0.8rem;
            }

            .header-actions {
                gap: 3px;
            }

            .header-actions .btn-link {
                padding: 4px 6px;
                font-size: 1rem;
            }

            .header-actions .dropdown-toggle::after {
                display: none;
            }

            /* Page header dalam content */
            .d-flex.justify-content-between.align-items-center.mb-4 {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 1rem;
            }

            .d-flex.justify-content-between.align-items-center.mb-4>div:first-child h1,
            .d-flex.justify-content-between.align-items-center.mb-4>div:first-child h4 {
                font-size: 1.25rem;
                margin-bottom: 0.25rem;
            }

            .d-flex.justify-content-between.align-items-center.mb-4 .btn {
                width: 100%;
                justify-content: center;
            }

            .user-info .d-none.d-md-block {
                display: none !important;
            }

            /* Page header improvements */
            .page-header {
                padding: 0.5rem 0;
                margin-bottom: 1rem;
            }

            .page-header h1 {
                font-size: 1.25rem;
                margin-bottom: 0.25rem;
            }

            .page-header .btn {
                font-size: 0.875rem;
                padding: 0.375rem 0.75rem;
            }

            /* Container improvements */
            .container-fluid {
                padding-left: 10px;
                padding-right: 10px;
            }

            /* Hide some text on mobile */
            .sidebar-menu .menu-link span {
                display: none;
            }

            .sidebar.show .sidebar-menu .menu-link span {
                display: inline;
            }

            /* Card adjustments */
            .admin-card .card-header {
                padding: 15px 20px;
            }

            .admin-card .card-body {
                padding: 20px;
            }

            /* Table responsive */
            .table-responsive {
                font-size: 14px;
            }

            /* Stats cards */
            .stats-card {
                padding: 20px;
                margin-bottom: 15px;
            }

            .stats-number {
                font-size: 24px;
            }

            /* Form adjustments */
            .form-control,
            .form-select {
                padding: 10px 12px;
            }

            .btn {
                padding: 8px 16px;
            }

            .btn-group-sm .btn {
                padding: 4px 8px;
                font-size: 12px;
            }

            /* Page title */
            .page-title {
                font-size: 24px;
            }

            /* Dropdown adjustments */
            .dropdown-menu {
                font-size: 14px;
            }
        }

        /* Medium screens */
        @media (max-width: 992px) {
            .sidebar {
                width: 250px;
            }

            .main-content {
                margin-left: 250px;
            }

            .sidebar.collapsed~.main-content {
                margin-left: 60px;
            }

            .content-area {
                padding: 25px 20px;
            }

            .admin-card .card-header {
                padding: 18px 22px;
            }

            .admin-card .card-body {
                padding: 22px;
            }
        }

        /* Small mobile */
        @media (max-width: 576px) {
            .content-area {
                padding: 10px 8px;
            }

            .admin-card {
                margin-bottom: 15px;
            }

            .admin-card .card-header {
                padding: 12px 15px;
                font-size: 16px;
            }

            .admin-card .card-body {
                padding: 15px;
            }

            .stats-card {
                padding: 15px;
            }

            .stats-number {
                font-size: 20px;
            }

            .stats-icon {
                width: 45px;
                height: 45px;
                font-size: 18px;
            }

            .page-title {
                font-size: 20px;
            }

            .page-subtitle {
                font-size: 14px;
            }

            /* Hide some columns in tables */
            .table th:nth-child(n+4),
            .table td:nth-child(n+4) {
                display: none;
            }

            /* Adjust buttons */
            .btn-group .btn {
                padding: 6px 10px;
                font-size: 12px;
            }

            /* Form columns on mobile */
            .row.g-3>.col-md-3,
            .row.g-3>.col-md-4 {
                margin-bottom: 15px;
            }
        }

        /* Animation */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Mobile Sidebar Overlay */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1049;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            pointer-events: none;
        }

        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        /* Mobile specific styles */
        @media (max-width: 768px) {
            .sidebar-overlay {
                display: block;
            }
        }

        @media (min-width: 769px) {
            .sidebar-overlay {
                display: none !important;
            }
        }

        /* Mobile Table Responsiveness - Hide table, show cards */
        @media (max-width: 767px) {

            /* Hide table on mobile */
            .table-responsive table {
                display: none;
            }

            /* Show mobile card view */
            .mobile-card-view {
                display: block !important;
            }

            .mobile-item-card {
                background: white;
                border: 1px solid #e9ecef;
                border-radius: 8px;
                padding: 1rem;
                margin-bottom: 1rem;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }

            .mobile-item-card .item-header {
                display: flex;
                justify-content: between;
                align-items: flex-start;
                margin-bottom: 0.5rem;
            }

            .mobile-item-card .item-title {
                font-weight: 600;
                font-size: 1rem;
                margin-bottom: 0.25rem;
                color: #2c3e50;
            }

            .mobile-item-card .item-meta {
                font-size: 0.875rem;
                color: #6c757d;
                margin-bottom: 0.75rem;
            }

            .mobile-item-card .item-actions {
                display: flex;
                gap: 0.5rem;
                flex-wrap: wrap;
            }

            .mobile-item-card .btn {
                padding: 0.375rem 0.75rem;
                font-size: 0.8rem;
                flex: 1;
                min-width: auto;
            }

            .admin-card .card-body {
                padding: 0.75rem;
            }

            /* Page header adjustments */
            .page-header h1 {
                font-size: 1.25rem;
            }

            .page-header .btn {
                font-size: 0.875rem;
                padding: 0.5rem 1rem;
            }

            /* Pagination improvements */
            .pagination {
                font-size: 0.875rem;
            }

            .pagination .page-link {
                padding: 0.375rem 0.75rem;
            }
        }

        /* Desktop - hide mobile cards */
        @media (min-width: 768px) {
            .mobile-card-view {
                display: none !important;
            }
        }

        /* Extra small devices (phones, 576px and down) */
        @media (max-width: 575px) {
            .container-fluid {
                padding-left: 8px;
                padding-right: 8px;
            }

            .admin-card {
                margin-bottom: 1rem;
                border-radius: 8px;
            }

            .admin-card .card-header {
                padding: 0.75rem 1rem;
            }

            .admin-card .card-header h5 {
                font-size: 1rem;
                margin-bottom: 0;
            }

            .admin-card .card-body {
                padding: 1rem;
            }

            .form-control,
            .form-select,
            .form-control:focus,
            .form-select:focus {
                font-size: 16px;
                /* Prevent zoom on iOS */
                border-radius: 6px;
            }

            .btn {
                font-size: 0.875rem;
                border-radius: 6px;
                padding: 0.5rem 1rem;
            }

            .btn-sm {
                padding: 0.375rem 0.75rem;
                font-size: 0.8rem;
            }

            /* Form improvements */
            .form-label {
                font-weight: 600;
                margin-bottom: 0.5rem;
            }

            .form-text {
                font-size: 0.8rem;
            }

            /* Row spacing */
            .row.g-3>* {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
                margin-bottom: 0.75rem;
            }

            /* Filter section stacking */
            .row.g-3 .d-flex.flex-column.flex-lg-row {
                flex-direction: column !important;
                gap: 0.5rem;
            }

            .row.g-3 .w-100.w-lg-auto {
                width: 100% !important;
            }

            /* Modal improvements */
            .modal-dialog {
                margin: 1rem 0.5rem;
            }

            .modal-content {
                border-radius: 8px;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    @include('templates.back._parts.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        @include('templates.back._parts.header')

        <!-- Content Area -->
        <div class="content-area fade-in">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script>
        // Sidebar Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            function isMobileDevice() {
                return window.innerWidth <= 768;
            }

            function closeMobileSidebar() {
                if (sidebar && overlay) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    document.body.style.overflow = '';
                }
            }

            function openMobileSidebar() {
                if (sidebar && overlay) {
                    sidebar.classList.add('show');
                    overlay.classList.add('show');
                    document.body.style.overflow = 'hidden';
                }
            }

            // Desktop sidebar toggle
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (!isMobileDevice()) {
                        sidebar.classList.toggle('collapsed');
                        localStorage.setItem('sidebar-collapsed', sidebar.classList.contains('collapsed'));
                    } else {
                        // Mobile toggle
                        if (sidebar.classList.contains('show')) {
                            closeMobileSidebar();
                        } else {
                            openMobileSidebar();
                        }
                    }
                });
            }

            // Mobile sidebar toggle
            if (mobileSidebarToggle) {
                mobileSidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (sidebar.classList.contains('show')) {
                        closeMobileSidebar();
                    } else {
                        openMobileSidebar();
                    }
                });
            }

            // Restore sidebar state for desktop
            if (!isMobileDevice() && localStorage.getItem('sidebar-collapsed') === 'true') {
                sidebar.classList.add('collapsed');
            }

            // Desktop sidebar toggle (for non-mobile)
            const desktopToggle = document.querySelector('.sidebar-toggle.d-none.d-md-block');
            if (desktopToggle) {
                desktopToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                    localStorage.setItem('sidebar-collapsed', sidebar.classList.contains('collapsed'));
                });
            }

            // Close mobile sidebar when overlay is clicked
            if (overlay) {
                overlay.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    closeMobileSidebar();
                });
            }

            // Close mobile sidebar when menu link is clicked
            const menuLinks = document.querySelectorAll('.sidebar-menu .menu-link');
            menuLinks.forEach(function(link) {
                link.addEventListener('click', function() {
                    if (isMobileDevice()) {
                        setTimeout(closeMobileSidebar, 150); // Small delay for better UX
                    }
                });
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (!isMobileDevice()) {
                    closeMobileSidebar();
                    // Restore collapsed state for desktop
                    if (localStorage.getItem('sidebar-collapsed') === 'true') {
                        sidebar.classList.add('collapsed');
                    }
                } else {
                    // Remove collapsed class on mobile
                    sidebar.classList.remove('collapsed');
                }
            });

            // Handle escape key to close mobile sidebar
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && isMobileDevice() && sidebar.classList.contains('show')) {
                    closeMobileSidebar();
                }
            }); // Auto-hide alerts
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });

        // CSRF Token for AJAX
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };
    </script>

    @stack('scripts')
</body>

</html>
