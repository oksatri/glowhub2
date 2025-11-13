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
                <div class="col-md-10">
                    <nav id="navbar" class="collapse collapse-horizontal" id="navbarMenu">
                        <div class="main-menu stellarnav">
                            <ul class="menu-list d-flex flex-column flex-md-row list-unstyled mb-0">
                                @php
                                    $isHomePage =
                                        request()->is('/') ||
                                        request()->routeIs('home') ||
                                        request()->url() === url('/');
                                @endphp

                                <li class="menu-item me-md-3 mb-2 mb-md-0">
                                    <a href="{{ $isHomePage ? '#home' : url('/#home') }}"
                                        class="nav-link d-block py-2">Home</a>
                                </li>
                                <li class="menu-item me-md-3 mb-2 mb-md-0">
                                    <a href="{{ $isHomePage ? '#how-it-works' : url('/#how-it-works') }}"
                                        class="nav-link d-block py-2">How It Works</a>
                                </li>
                                <li class="menu-item me-md-3 mb-2 mb-md-0">
                                    <a href="{{ $isHomePage ? '#find-mua' : url('/#find-mua') }}"
                                        class="nav-link d-block py-2">Find
                                        MUA</a>
                                </li>
                                <li class="menu-item me-md-3 mb-2 mb-md-0">
                                    <a href="{{ $isHomePage ? '#services' : url('/#services') }}"
                                        class="nav-link d-block py-2">For
                                        MUA</a>
                                </li>
                                <li class="menu-item mb-2 mb-md-0">
                                    <a href="{{ $isHomePage ? '#contact' : url('/#contact') }}"
                                        class="nav-link d-block py-2">Contact
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
        @media (max-width: 767.98px) {
            #navbarMenu {
                background: #f8f9fa;
                border-top: 1px solid #e9ecef;
                margin-top: 10px;
            }

            .menu-list {
                padding: 10px 0 !important;
            }

            .menu-item a {
                padding-left: 15px !important;
                padding-right: 15px !important;
                color: #3d2a33 !important;
                font-weight: 500;
            }

            .menu-item a:hover {
                background: rgba(132, 93, 112, 0.1);
                border-radius: 4px;
                color: #845d70 !important;
            }
        }
    </style>
</div>
