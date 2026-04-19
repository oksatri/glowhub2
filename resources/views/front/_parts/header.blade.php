<div id="header-wrap">
    <header id="header" class="main-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <!-- Logo -->
                <div class="col-6 col-md-3">
                    <div class="main-logo">
                        <a href="{{ url('/') }}">
                            @php
                                $logoUrl = null;
                                if (isset($siteSetting) && !empty($siteSetting->logo)) {
                                    $logoUrl = asset('uploads/' . $siteSetting->logo);
                                } else {
                                    $logoUrl = asset('images/logo/logo_saja.png');
                                }
                            @endphp
                            <img src="{{ $logoUrl }}" alt="{{ $siteSetting->site_name ?? 'GlowHub' }}"
                                style="max-width: 100%; height: auto; max-height: 50px;">
                        </a>
                    </div>
                </div>

                <!-- Navigation for Desktop -->
                <div class="col-md-9 d-none d-md-block ms-auto">
                    <nav id="navbar">
                        <div class="main-menu">
                            <ul class="menu-list">
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

                <!-- Mobile Menu Toggle -->
                <div class="col-6 d-md-none text-end">
                    <span class="bg-primary text-white" data-bs-toggle="collapse"
                        data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-expanded="false"
                        aria-label="Toggle navigation" style="padding: 4px 8px; font-size: 0.75rem;">
                        <i class="fas fa-bars"></i>
                    </span>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="collapse" id="mobileMenu">
                <div class="row">
                    <div class="col-12">
                        <nav id="navbar-mobile">
                            <div class="main-menu">
                                <ul class="menu-list-mobile">
                                    @php
                                        $isHomePage =
                                            request()->is('/') ||
                                            request()->routeIs('home') ||
                                            request()->url() === url('/');
                                    @endphp

                                    <li class="menu-item-mobile">
                                        <a href="{{ $isHomePage ? '#home' : url('/#home') }}"
                                            class="nav-link-mobile">Home</a>
                                    </li>
                                    <li class="menu-item-mobile">
                                        <a href="{{ $isHomePage ? '#how-it-works' : url('/#how-it-works') }}"
                                            class="nav-link-mobile">How It Works</a>
                                    </li>
                                    <li class="menu-item-mobile">
                                        <a href="{{ $isHomePage ? '#find-mua' : url('/#find-mua') }}"
                                            class="nav-link-mobile">Find MUA</a>
                                    </li>
                                    <li class="menu-item-mobile">
                                        <a href="{{ $isHomePage ? '#services' : url('/#services') }}"
                                            class="nav-link-mobile">For MUA</a>
                                    </li>
                                    <li class="menu-item-mobile">
                                        <a href="{{ $isHomePage ? '#contact' : url('/#contact') }}"
                                            class="nav-link-mobile">Contact Us</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <style>
        /* Header */         .main-header {
            padding: 2px 0 !important;
        }

        @media (max-width: 767px) {
            .main-header {
                padding: 0px !important;
            }
            .main-logo img {
                max-height: 35px !important;
            }
            #mobileMenu {
                margin-top: 2px;
            }
            .nav-link-mobile {
                padding: 6px 12px;
                font-size: 0.85rem;
            }
        }

        /* Desktop Menu */
        .menu-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 2px;
            align-items: center;
            justify-content: flex-end;
        }

        .menu-item {
            display: inline-block;
        }

        .nav-link {
            display: inline-block;
            padding: 6px 12px;
            color: #3d2a33;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .nav-link:hover {
            color: #845d70;
        }

        /* Mobile Menu */
        .menu-list-mobile {
            list-style: none;
            margin: 0;
            padding: 3px 0;
            display: flex;
            flex-direction: column;
        }

        .menu-item-mobile {
            display: block;
            border-bottom: 1px solid #e9ecef;
        }

        .menu-item-mobile:last-child {
            border-bottom: none;
        }

        .nav-link-mobile {
            display: block;
            padding: 5px 15px;
            color: #3d2a33;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            font-size: 0.85rem;
        }

        .nav-link-mobile:hover {
            background: rgba(132, 93, 112, 0.1);
            color: #845d70;
            padding-left: 20px;
        }

        #mobileMenu {
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
            margin-top: 0px;
            border-radius: 4px;
        }

        @media (min-width: 768px) {
            #mobileMenu {
                display: none !important;
            }
        }
    </style>
</div>
