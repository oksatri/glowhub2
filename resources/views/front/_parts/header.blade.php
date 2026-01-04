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
                                <li class="menu-item">
                                    <div class="google-translate-wrapper">
                                        <div id="google_translate_element"></div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>

                <!-- Mobile Menu Toggle -->
                <div class="col-6 d-md-none text-end">
                    <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse"
                        data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                    </button>
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
                                    <li class="menu-item-mobile">
                                        <div class="google-translate-wrapper-mobile">
                                            <div id="google_translate_element_mobile"></div>
                                        </div>
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
            padding: 6px 0 !important;
        }

        @media (max-width: 767px) {
            .main-header {
                padding: 0px !important;
            }
            .main-logo img {
                max-height: 40px !important;
            }
            #mobileMenu {
                margin-top: 5px;
            }
            .nav-link-mobile {
                padding: 8px 15px;
                font-size: 0.9rem;
            }
        }

        /* Desktop Menu */
        .menu-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 5px;
            align-items: center;
            justify-content: flex-end;
        }

        .menu-item {
            display: inline-block;
        }

        .nav-link {
            display: inline-block;
            padding: 8px 15px;
            color: #3d2a33;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .nav-link:hover {
            color: #845d70;
        }

        /* Mobile Menu */
        .menu-list-mobile {
            list-style: none;
            margin: 0;
            padding: 10px 0;
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
            padding: 12px 20px;
            color: #3d2a33;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .nav-link-mobile:hover {
            background: rgba(132, 93, 112, 0.1);
            color: #845d70;
            padding-left: 25px;
        }

        #mobileMenu {
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
            margin-top: 10px;
            border-radius: 4px;
        }

        @media (min-width: 768px) {
            #mobileMenu {
                display: none !important;
            }
        }

        /* Google Translate Styling */
        .google-translate-wrapper {
            display: flex;
            align-items: center;
            padding: 4px 0;
        }

        .google-translate-wrapper-mobile {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border-top: 1px solid #e9ecef;
        }

        /* Hide Google Translate branding and customize appearance */
        .goog-te-banner-frame.skiptranslate {
            display: none !important;
        }

        body {
            top: 0px !important;
        }

        .goog-te-gadget {
            font-family: inherit !important;
            font-size: 0.85rem !important;
            color: #3d2a33 !important;
        }

        .goog-te-gadget .goog-te-combo {
            margin: 0 !important;
            padding: 4px 8px !important;
            border: 1px solid #dee2e6 !important;
            border-radius: 4px !important;
            background: white !important;
            color: #3d2a33 !important;
            font-size: 0.8rem !important;
            font-weight: 500 !important;
            outline: none !important;
            transition: all 0.3s ease !important;
        }

        .goog-te-gadget .goog-te-combo:hover {
            border-color: #845d70 !important;
            box-shadow: 0 2px 4px rgba(132, 93, 112, 0.1) !important;
        }

        .goog-te-gadget .goog-te-combo:focus {
            border-color: #845d70 !important;
            box-shadow: 0 0 0 2px rgba(132, 93, 112, 0.2) !important;
        }

        /* Hide "Powered by Google" text */
        .goog-te-gadget > span > span:first-child {
            display: none !important;
        }

        /* Mobile specific styling */
        @media (max-width: 767px) {
            .goog-te-gadget {
                font-size: 0.9rem !important;
            }

            .goog-te-gadget .goog-te-combo {
                width: 100% !important;
                padding: 8px 12px !important;
                font-size: 0.9rem !important;
            }
        }
    </style>
</div>

@push('scripts')
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script>
    function googleTranslateElementInit() {
        // Desktop translate element
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,id,zh-CN,ja,ko,th,vi,ms,tl,fr,de,es,pt,ru,ar',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            autoDisplay: false
        }, 'google_translate_element');

        // Mobile translate element
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,id,zh-CN,ja,ko,th,vi,ms,tl,fr,de,es,pt,ru,ar',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            autoDisplay: false
        }, 'google_translate_element_mobile');
    }

    // Add custom styling after Google Translate loads
    window.addEventListener('load', function() {
        setTimeout(function() {
            // Hide the "Select Language" text
            const googGadgets = document.querySelectorAll('.goog-te-gadget');
            googGadgets.forEach(function(gadget) {
                const firstChild = gadget.querySelector('span:first-child');
                if (firstChild && firstChild.textContent.includes('Select Language')) {
                    firstChild.style.display = 'none';
                }
            });
        }, 1000);
    });
</script>
@endpush
