<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('meta_title', $siteSetting->meta_title ?? ($siteSetting->site_name ?? 'GlowHub'))</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="author" content="{{ $siteSetting->site_name ?? '' }}">
    <meta name="keywords" content="@yield('meta_keywords', $siteSetting->meta_keywords ?? '')">
    <meta name="description" content="@yield('meta_description', $siteSetting->meta_description ?? ($siteSetting->site_tagline ?? ''))">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    @php
        // Prefer the shared $siteSetting (provided by AppServiceProvider). If not available,
        // fall back to loading the first SiteSetting record.
        $settings = isset($siteSetting) ? $siteSetting : \App\Models\SiteSetting::first();
        if ($settings && !empty($settings->favicon)) {
            $favicon = asset('uploads/' . $settings->favicon);
        } elseif ($settings && !empty($settings->logo)) {
            $favicon = asset('uploads/' . $settings->logo);
        } else {
            $favicon = asset('images/logo/logo_saja.png');
        }
    @endphp
    <link rel="icon" type="image/png" href="{{ $favicon }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ $favicon }}">
    <link rel="apple-touch-icon" href="{{ $favicon }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Animate.css -->

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('icomoon/icomoon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/vendor.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('style.css') }}">
    @php
        // Determine primary color from site settings; normalize hex if needed and provide fallback.
        $primary = null;
        if (isset($siteSetting) && !empty($siteSetting->primary_color)) {
            $primary = trim($siteSetting->primary_color);
        } elseif (isset($settings) && !empty($settings->primary_color)) {
            $primary = trim($settings->primary_color);
        }
        if (empty($primary)) {
            $primary = '#845d70';
        }
        // Normalize: add '#' if value is 6 hex chars without leading '#'
        if (!preg_match('/^#/', $primary) && preg_match('/^[0-9A-Fa-f]{6}$/', $primary)) {
            $primary = '#' . $primary;
        }
    @endphp

    <style>
        :root {
            --bs-primary: {{ $primary }};
            --primary-color: {{ $primary }};
        }

        /* Quick overrides to make sure Bootstrap components use the admin primary color */
        .bg-primary {
            background-color: var(--bs-primary) !important;
        }

        .btn-primary {
            background-color: var(--bs-primary) !important;
            border-color: var(--bs-primary) !important;
        }

        /* === RESPONSIVE & USER-FRIENDLY IMPROVEMENTS === */

        /* Global spacing improvements */
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.5;
        }

        /* Container improvements */
        .container {
            max-width: 1200px;
            padding-left: 12px;
            padding-right: 12px;
        }

        @media (max-width: 768px) {
            .container {
                padding-left: 8px;
                padding-right: 8px;
            }
        }

        /* Card spacing improvements */
        .card {
            margin-bottom: 1rem;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .card-body {
            padding: 1rem;
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 0.75rem;
            }
        }

        /* Form improvements */
        .form-control, .form-select {
            border-radius: 6px;
            padding: 0.6rem;
            font-size: 0.9rem;
            border: 1px solid #dee2e6;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--bs-primary);
            box-shadow: 0 0 0 0.2rem rgba(var(--bs-primary), 0.25);
        }

        /* Button improvements */
        .btn {
            border-radius: 6px;
            padding: 0.6rem 1.2rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        @media (max-width: 576px) {
            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
            }
        }

        /* Alert improvements */
        .alert {
            border-radius: 6px;
            margin-bottom: 0.75rem;
            padding: 0.75rem;
        }

        /* Section spacing */
        section {
            padding: 2rem 0;
        }

        @media (max-width: 768px) {
            section {
                padding: 1.5rem 0;
            }
        }

        /* Row spacing */
        .row {
            margin-bottom: 0.75rem;
        }

        .row:last-child {
            margin-bottom: 0;
        }

        /* Column spacing */
        [class*="col-"] {
            padding: 0.5rem;
        }

        @media (max-width: 768px) {
            [class*="col-"] {
                padding: 0.375rem;
            }
        }

        /* Form label improvements */
        .form-label {
            font-weight: 500;
            margin-bottom: 0.375rem;
            color: #495057;
        }

        /* Helper text improvements */
        .form-text, .text-muted {
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        /* Modal improvements */
        .modal-content {
            border-radius: 10px;
            border: none;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .modal-header {
            border-bottom: 1px solid #dee2e6;
            padding: 1rem;
        }

        .modal-body {
            padding: 1rem;
        }

        @media (max-width: 768px) {
            .modal-header, .modal-body {
                padding: 0.75rem;
            }
        }

        /* Badge improvements */
        .badge {
            border-radius: 4px;
            font-weight: 500;
            padding: 0.375rem 0.625rem;
        }

        /* Breadcrumb improvements */
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 0.75rem;
        }

        /* Pagination improvements */
        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            border-radius: 4px;
            margin: 0 1px;
            border: 1px solid #dee2e6;
        }

        /* Table improvements */
        .table {
            margin-bottom: 0;
        }

        .table th {
            font-weight: 600;
            border-top: none;
        }

        /* Loading states */
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        /* Responsive typography */
        h1 { font-size: 2.25rem; }
        h2 { font-size: 1.875rem; }
        h3 { font-size: 1.5rem; }
        h4 { font-size: 1.25rem; }
        h5 { font-size: 1.125rem; }
        h6 { font-size: 1rem; }

        @media (max-width: 768px) {
            h1 { font-size: 1.875rem; }
            h2 { font-size: 1.5rem; }
            h3 { font-size: 1.25rem; }
            h4 { font-size: 1.125rem; }
            h5 { font-size: 1rem; }
            h6 { font-size: 0.925rem; }
        }

        /* Utility classes for better spacing */
        .mb-4 { margin-bottom: 1rem !important; }
        .mt-4 { margin-top: 1rem !important; }
        .py-4 { padding-top: 1rem !important; padding-bottom: 1rem !important; }
        .mb-3 { margin-bottom: 0.75rem !important; }
        .mt-3 { margin-top: 0.75rem !important; }
        .py-3 { padding-top: 0.75rem !important; padding-bottom: 0.75rem !important; }
        .mb-2 { margin-bottom: 0.5rem !important; }
        .mt-2 { margin-top: 0.5rem !important; }
        .py-2 { padding-top: 0.5rem !important; padding-bottom: 0.5rem !important; }

        @media (max-width: 768px) {
            .mb-4 { margin-bottom: 0.75rem !important; }
            .mt-4 { margin-top: 0.75rem !important; }
            .py-4 { padding-top: 0.75rem !important; padding-bottom: 0.75rem !important; }
            .mb-3 { margin-bottom: 0.5rem !important; }
            .mt-3 { margin-top: 0.5rem !important; }
            .py-3 { padding-top: 0.5rem !important; padding-bottom: 0.5rem !important; }
        }

        /* Remove unnecessary margins on mobile */
        @media (max-width: 768px) {
            .mb-md-0 { margin-bottom: 0 !important; }
            .mt-md-0 { margin-top: 0 !important; }
        }
    </style>
    @stack('style')
</head>

<body data-bs-spy="scroll" data-bs-target="#header" tabindex="0">
    @include('front._parts.header')
    @yield('content')
    @include('front._parts.footer')

    <!-- Scroll to Top Button -->
    <div id="scrollToTop" class="scroll-to-top">
        <i class="fas fa-chevron-up"></i>
    </div>

    <script src="{{ asset('js/jquery-1.11.0.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>

    <!-- Custom MUA JavaScript -->
    <script>
        $(document).ready(function() {
            // Smooth scrolling for navigation links
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if (target.length) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 80
                    }, 1000);
                }
            });

            // Add animation on scroll
            function animateOnScroll() {
                $('.mua-finder-card, .testimonial-card, .process-step').each(function() {
                    var elementTop = $(this).offset().top;
                    var elementBottom = elementTop + $(this).outerHeight();
                    var viewportTop = $(window).scrollTop();
                    var viewportBottom = viewportTop + $(window).height();

                    if (elementBottom > viewportTop && elementTop < viewportBottom) {
                        $(this).addClass('animate__animated animate__fadeInUp');
                    }
                });
            }

            // Trigger animation on page load and scroll
            animateOnScroll();
            $(window).scroll(function() {
                animateOnScroll();

                // Show/hide scroll to top button
                if ($(this).scrollTop() > 300) {
                    $('#scrollToTop').addClass('show');
                } else {
                    $('#scrollToTop').removeClass('show');
                }
            });

            // Scroll to top functionality
            $('#scrollToTop').on('click', function() {
                $('html, body').animate({
                    scrollTop: 0
                }, 800, 'easeInOutCubic');
            });

            // Tab functionality for services
            $('.tab-item').click(function() {
                var tab = $(this).data('tab');

                // Remove active class from all tabs and content
                $('.tab-item').removeClass('active');
                $('.tab-content').removeClass('active');

                // Add active class to clicked tab
                $(this).addClass('active');
                $('#' + tab).addClass('active');
            });

            // Heart icon toggle with elegant animation
            $('.fa-heart').on('click', function() {
                const heart = $(this);
                if (heart.hasClass('far')) {
                    heart.removeClass('far').addClass('fas').css('color', '#ff6b6b');
                    // Add heartbeat animation
                    heart.addClass('animate__animated animate__heartBeat');
                    setTimeout(() => heart.removeClass('animate__animated animate__heartBeat'), 1000);
                } else {
                    heart.removeClass('fas').addClass('far').css('color', '#845d70');
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
