<div id="header-wrap">
    {{-- <div class="top-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="social-links">
                        <ul>
                            <li>
                                <a href="#"><i class="icon icon-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="icon icon-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="icon icon-youtube-play"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="icon icon-behance-square"></i></a>
                            </li>
                        </ul>
                    </div>
                    <!--social-links-->
                </div>
                <div class="col-md-6">
                    <div class="right-element">
                        <a href="#" class="user-account for-buy"><i
                                class="icon icon-user"></i><span>Account</span></a>
                        <a href="#" class="cart for-buy"><i class="icon icon-clipboard"></i><span>Cart:(0
                                $)</span></a>

                        <div class="action-menu">

                            <div class="search-bar">
                                <a href="#" class="search-button search-toggle" data-selector="#header-wrap">
                                    <i class="icon icon-search"></i>
                                </a>
                                <form role="search" method="get" class="search-box">
                                    <input class="search-field text search-input" placeholder="Search" type="search">
                                </form>
                            </div>
                        </div>

                    </div><!--top-right-->
                </div>

            </div>
        </div>
    </div> --}}
    <!--top-content-->

    <header id="header" style="padding: 10px 0px !important">
        <div class="container-fluid">
            <div class="row align-items-center">
                <!-- Logo -->
                <div class="col-6 col-md-2">
                    <div class="main-logo">
                        <a href="{{ url('/') }}">
                            @php
                                $logoUrl = null;
                                if (isset($siteSetting) && !empty($siteSetting->logo)) {
                                    $logoUrl = asset('storage/' . $siteSetting->logo);
                                } else {
                                    $logoUrl = asset('images/logo/logo_saja.png');
                                }
                            @endphp
                            <img src="{{ $logoUrl }}" alt="{{ $siteSetting->site_name ?? 'GlowHub' }}"
                                style="max-width: 100%; height: auto; max-height: 50px;">
                        </a>
                    </div>
                </div>

                <!-- Mobile Menu Toggle -->
                <div class="col-6 d-md-none text-end">
                    <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>

                <!-- Navigation -->
                <div class="col-12 col-md-10 d-md-block">
                    <nav id="navbar" class="navbar-menu collapse navbar-collapse" id="navbarMenu">
                        <div class="main-menu stellarnav">
                            <ul class="menu-list list-unstyled mb-0 d-flex flex-column flex-md-row">
                                @php
                                    $isHomePage =
                                        request()->is('/') ||
                                        request()->routeIs('home') ||
                                        request()->url() === url('/');
                                @endphp

                                <li class="menu-item">
                                    <a href="{{ $isHomePage ? '#home' : url('/#home') }}" class="nav-link">Home</a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ $isHomePage ? '#how-it-works' : url('/#how-it-works') }}"
                                        class="nav-link">How It Works</a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ $isHomePage ? '#find-mua' : url('/#find-mua') }}" class="nav-link">Find
                                        MUA</a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ $isHomePage ? '#services' : url('/#services') }}" class="nav-link">For
                                        MUA</a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ $isHomePage ? '#contact' : url('/#contact') }}" class="nav-link">Contact
                                        Us</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <style>
        /* Desktop Menu */
        .navbar-menu {
            display: block !important;
        }

        .menu-list {
            gap: 0;
        }

        .menu-item {
            display: list-item;
        }

        .menu-item .nav-link {
            display: inline-block;
            padding: 8px 12px;
            color: #3d2a33;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .menu-item .nav-link:hover {
            color: #845d70;
        }

        /* Mobile Menu */
        @media (max-width: 767.98px) {
            .navbar-menu {
                display: none !important;
            }

            .navbar-menu.show {
                display: block !important;
            }

            #navbarMenu {
                background: #f8f9fa;
                border-top: 1px solid #e9ecef;
                margin-top: 10px;
                padding: 10px 0;
            }

            .menu-list {
                flex-direction: column;
                padding: 0;
            }

            .menu-item {
                display: block;
                border-bottom: 1px solid #e9ecef;
            }

            .menu-item:last-child {
                border-bottom: none;
            }

            .menu-item .nav-link {
                display: block;
                padding: 12px 15px;
                color: #3d2a33;
                width: 100%;
            }

            .menu-item .nav-link:hover {
                background: rgba(132, 93, 112, 0.1);
                color: #845d70;
            }
        }
    </style>
</div>
