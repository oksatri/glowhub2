<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo/logo_saja.png') }}">
    <title>Admin GlowHub - @yield('page-title', 'Dashboard')</title>
    <!-- Custom CSS -->
    <link href="{{ asset('admin/assets/extra-libs/c3/c3.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet">
    <!-- Load Font Awesome from CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link href="{{ asset('admin/dist/css/style.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/dist/css/custom-admin-override.css') }}" rel="stylesheet">

    <style>
        /* Fix for Font Awesome icons */
        .fas, .far, .fa, .fab {
            font-family: "Font Awesome 6 Free" !important;
        }

        /* Logo responsiveness fixes */
        .navbar-brand {
            display: flex;
            align-items: center;
            padding: 0 !important;
            margin: 0;
        }

        .logo-icon {
            display: inline-flex;
            align-items: center;
            padding: 0 10px;
        }

        .logo-icon img {
            max-width: 40px !important;
            width: auto !important;
            height: auto;
        }

        .logo-text {
            font-size: 1.2rem;
            margin-left: 5px;
        }

        @media (max-width: 768px) {
            .navbar-header {
                padding: 0 10px;
            }
            .logo-icon img {
                max-width: 30px !important;
            }
            .logo-text {
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .logo-icon img {
                max-width: 25px !important;
            }
            .logo-text {
                font-size: 0.9rem;
            }
        }

        .fab {
            font-family: "Font Awesome 6 Brands" !important;
        }

        /* Mobile responsiveness fixes */
        @media (max-width: 768px) {
            .container-fluid {
                padding: 1rem !important;
            }
            .card-body {
                padding: 1.25rem !important;
            }
            .page-wrapper > .container-fluid {
                min-height: calc(100vh - 180px);
            }
        }
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

        @include('back._parts.header')

        @include('back._parts.sidebar')

        <div class="page-wrapper">

            <div class="container-fluid">
                @yield('content')
            </div>

            @include('back._parts.footer')

        </div>

    </div>
    <!-- ============================================================== -->
    <script src="{{ asset('admin/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- apps -->
    <!-- apps -->
    <script src="{{ asset('admin/dist/js/app-style-switcher.js') }}"></script>
    <script src="{{ asset('admin/dist/js/feather.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('admin/dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('admin/dist/js/custom.min.js') }}"></script>
    <!--This page JavaScript -->
    <script src="{{ asset('admin/assets/extra-libs/c3/d3.min.js') }}"></script>
    <script src="{{ asset('admin/assets/extra-libs/c3/c3.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/chartist/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <script src="{{ asset('admin/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('admin/assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('admin/dist/js/pages/dashboards/dashboard1.min.js') }}"></script>
    {{-- Place for page-specific pushed scripts --}}
    @stack('scripts')
</body>

</html>
