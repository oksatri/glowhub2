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
            position: relative;
        }

        .google-translate-wrapper::before {
            content: '';
            position: absolute;
            left: -8px;
            top: 50%;
            transform: translateY(-50%);
            width: 1px;
            height: 20px;
            background: linear-gradient(to bottom, transparent, rgba(132, 93, 112, 0.3), transparent);
        }

        .google-translate-wrapper-mobile {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px 20px;
            border-top: 1px solid #e9ecef;
            background: linear-gradient(135deg, rgba(132, 93, 112, 0.02) 0%, rgba(132, 93, 112, 0.05) 100%);
        }

        .google-translate-wrapper-mobile::before {
            content: '🌐';
            margin-right: 10px;
            font-size: 1.1rem;
            opacity: 0.7;
        }

        /* Hide Google Translate branding and customize appearance */
        .goog-te-banner-frame.skiptranslate {
            display: none !important;
        }

        body {
            top: 0px !important;
        }

        .goog-te-gadget {
            font-family: 'Poppins', sans-serif !important;
            font-size: 0.8rem !important;
            color: var(--primary-color) !important;
            font-weight: 500 !important;
        }

        .goog-te-gadget .goog-te-combo {
            margin: 0 !important;
            padding: 8px 12px !important;
            border: 2px solid transparent !important;
            border-radius: 8px !important;
            background: linear-gradient(135deg, rgba(132, 93, 112, 0.05) 0%, rgba(132, 93, 112, 0.1) 100%) !important;
            color: var(--primary-color) !important;
            font-size: 0.8rem !important;
            font-weight: 500 !important;
            font-family: 'Poppins', sans-serif !important;
            outline: none !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            cursor: pointer !important;
            min-width: 120px !important;
            position: relative !important;
        }

        .goog-te-gadget .goog-te-combo:hover {
            background: linear-gradient(135deg, rgba(132, 93, 112, 0.1) 0%, rgba(132, 93, 112, 0.15) 100%) !important;
            border-color: rgba(132, 93, 112, 0.3) !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 12px rgba(132, 93, 112, 0.15) !important;
        }

        .goog-te-gadget .goog-te-combo:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 3px rgba(132, 93, 112, 0.2) !important;
            background: white !important;
        }

        .goog-te-gadget .goog-te-combo:active {
            transform: translateY(0) !important;
        }

        /* Custom dropdown arrow */
        .goog-te-gadget .goog-te-combo {
            appearance: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23845d70'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: right 8px center !important;
            background-size: 20px !important;
            padding-right: 32px !important;
        }

        /* Hide "Powered by Google" text */
        .goog-te-gadget > span > span:first-child {
            display: none !important;
        }

        /* Hide Google Translate tooltip */
        .goog-tooltip {
            display: none !important;
        }

        .goog-tooltip:hover {
            display: none !important;
        }

        /* Custom language icon for desktop */
        .google-translate-wrapper::after {
            content: '🌐';
            position: absolute;
            right: -25px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.9rem;
            opacity: 0.6;
            transition: all 0.3s ease;
        }

        .google-translate-wrapper:hover::after {
            opacity: 1;
            transform: translateY(-50%) scale(1.1);
        }

        /* Mobile specific styling */
        @media (max-width: 767px) {
            .goog-te-gadget {
                font-size: 0.9rem !important;
                width: 100% !important;
            }

            .goog-te-gadget .goog-te-combo {
                width: 100% !important;
                padding: 10px 16px !important;
                font-size: 0.9rem !important;
                background: white !important;
                border: 2px solid rgba(132, 93, 112, 0.2) !important;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08) !important;
            }

            .goog-te-gadget .goog-te-combo:hover {
                border-color: var(--primary-color) !important;
                box-shadow: 0 4px 12px rgba(132, 93, 112, 0.15) !important;
            }

            .google-translate-wrapper-mobile::after {
                content: '';
                display: none;
            }
        }

        /* Loading animation */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.6;
            }
        }

        .goog-te-gadget.loading .goog-te-combo {
            animation: pulse 1.5s ease-in-out infinite;
        }

        /* Focus states for accessibility */
        .goog-te-gadget .goog-te-combo:focus-visible {
            outline: 2px solid var(--primary-color) !important;
            outline-offset: 2px !important;
        }

        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .goog-te-gadget .goog-te-combo {
                border: 2px solid #000 !important;
                background: white !important;
                color: #000 !important;
            }
        }

        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            .goog-te-gadget .goog-te-combo {
                transition: none !important;
            }

            .google-translate-wrapper::after {
                transition: none !important;
            }
        }
    </style>
</div>

@push('scripts')
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script>
    function googleTranslateElementInit() {
        // Add loading state
        document.querySelectorAll('.google-translate-wrapper, .google-translate-wrapper-mobile').forEach(function(wrapper) {
            wrapper.classList.add('loading');
        });

        // Desktop translate element
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,id,zh-CN,ja,ko,th,vi,ms,tl,fr,de,es,pt,ru,ar',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            autoDisplay: false,
            multilanguagePage: true
        }, 'google_translate_element');

        // Mobile translate element
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,id,zh-CN,ja,ko,th,vi,ms,tl,fr,de,es,pt,ru,ar',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            autoDisplay: false,
            multilanguagePage: true
        }, 'google_translate_element_mobile');

        // Remove loading state after initialization
        setTimeout(function() {
            document.querySelectorAll('.google-translate-wrapper, .google-translate-wrapper-mobile').forEach(function(wrapper) {
                wrapper.classList.remove('loading');
            });
        }, 1500);
    }

    // Enhanced styling after Google Translate loads
    document.addEventListener('DOMContentLoaded', function() {
        // Custom styling function
        function customizeGoogleTranslate() {
            // Hide the "Select Language" text and other unwanted elements
            const unwantedSelectors = [
                '.goog-te-gadget > span:first-child',
                '.goog-te-gadget .goog-te-combo + span',
                '.goog-te-banner-frame',
                '.goog-tooltip'
            ];

            unwantedSelectors.forEach(function(selector) {
                const elements = document.querySelectorAll(selector);
                elements.forEach(function(element) {
                    if (element && (element.textContent.includes('Select Language') ||
                                   element.textContent.includes('Powered by'))) {
                        element.style.display = 'none';
                    }
                });
            });

            // Add custom dropdown styling
            const dropdowns = document.querySelectorAll('.goog-te-combo');
            dropdowns.forEach(function(dropdown) {
                // Add custom class for enhanced styling
                dropdown.classList.add('custom-translate-dropdown');

                // Add change event listener for smooth transitions
                dropdown.addEventListener('change', function() {
                    // Add a subtle loading effect when language changes
                    document.body.style.opacity = '0.95';
                    setTimeout(function() {
                        document.body.style.opacity = '1';
                    }, 300);
                });

                // Add hover sound effect (optional)
                dropdown.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-1px)';
                });

                dropdown.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Add custom styling to the language selection
            const style = document.createElement('style');
            style.textContent = `
                .custom-translate-dropdown option {
                    padding: 8px 12px !important;
                    font-family: 'Poppins', sans-serif !important;
                    font-weight: 400 !important;
                }

                .custom-translate-dropdown option:hover {
                    background: var(--primary-color) !important;
                    color: white !important;
                }
            `;
            document.head.appendChild(style);
        }

        // Initial customization
        customizeGoogleTranslate();

        // Re-apply customization periodically to handle dynamic changes
        setInterval(customizeGoogleTranslate, 2000);

        // Final customization after page fully loads
        window.addEventListener('load', function() {
            setTimeout(customizeGoogleTranslate, 1000);
        });
    });

    // Add keyboard navigation support
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + L to focus language selector
        if ((e.ctrlKey || e.metaKey) && e.key === 'l') {
            e.preventDefault();
            const dropdown = document.querySelector('.goog-te-combo');
            if (dropdown) {
                dropdown.focus();
                dropdown.click();
            }
        }
    });

    // Add smooth scroll behavior when language changes
    let currentLanguage = 'en';
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                const body = document.body;
                if (body.classList.contains('translated-ltr')) {
                    // Language changed, scroll to top smoothly
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });

    observer.observe(document.body, {
        attributes: true,
        attributeFilter: ['class']
    });
</script>
@endpush
