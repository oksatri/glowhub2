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
            <div class="row">

                <div class="col-md-2">
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

                <div class="col-md-10">

                    <nav id="navbar">
                        <div class="main-menu stellarnav">
                            <ul class="menu-list">
                                @php
                                    $isHomePage =
                                        request()->is('/') ||
                                        request()->routeIs('home') ||
                                        request()->url() === url('/');
                                @endphp

                                <li class="menu-item">
                                    <a href="{{ $isHomePage ? '#home' : url('/#home') }}">Home</a>
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
</div>
