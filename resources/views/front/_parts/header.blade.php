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
                                    <div class="custom-translate-wrapper">
                                        <select id="customLanguageSelector" class="custom-language-select">
                                            <option value="en">🇬🇧 English</option>
                                            <option value="id">🇮🇩 Bahasa</option>
                                            <option value="zh-CN">🇨🇳 中文</option>
                                            <option value="ja">🇯🇵 日本語</option>
                                            <option value="ko">🇰🇷 한국어</option>
                                            <option value="th">🇹🇭 ไทย</option>
                                            <option value="vi">🇻🇳 Tiếng Việt</option>
                                            <option value="ms">🇲🇾 Bahasa Melayu</option>
                                            <option value="tl">🇵🇭 Filipino</option>
                                            <option value="fr">🇫🇷 Français</option>
                                            <option value="de">🇩🇪 Deutsch</option>
                                            <option value="es">🇪🇸 Español</option>
                                            <option value="pt">🇵🇹 Português</option>
                                            <option value="ru">🇷🇺 Русский</option>
                                            <option value="ar">🇸🇦 العربية</option>
                                        </select>
                                        <div id="google_translate_element" style="display: none;"></div>
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
                                        <div class="custom-translate-wrapper-mobile">
                                            <select id="customLanguageSelectorMobile" class="custom-language-select-mobile">
                                                <option value="en">🌐 English</option>
                                                <option value="id">🇮🇩 Bahasa Indonesia</option>
                                                <option value="zh-CN">🇨🇳 中文</option>
                                                <option value="ja">🇯🇵 日本語</option>
                                                <option value="ko">🇰🇷 한국어</option>
                                                <option value="th">🇹🇭 ไทย</option>
                                                <option value="vi">🇻🇳 Tiếng Việt</option>
                                                <option value="ms">🇲🇾 Bahasa Melayu</option>
                                                <option value="tl">🇵🇭 Filipino</option>
                                                <option value="fr">🇫🇷 Français</option>
                                                <option value="de">🇩🇪 Deutsch</option>
                                                <option value="es">🇪🇸 Español</option>
                                                <option value="pt">🇵🇹 Português</option>
                                                <option value="ru">🇷🇺 Русский</option>
                                                <option value="ar">🇸🇦 العربية</option>
                                            </select>
                                            <div id="google_translate_element_mobile" style="display: none;"></div>
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

        /* Custom Language Selector Styling */
        .custom-translate-wrapper {
            display: flex;
            align-items: center;
            padding: 2px 0;
            position: relative;
        }

        .custom-translate-wrapper::before {
            content: '';
            position: absolute;
            left: -6px;
            top: 50%;
            transform: translateY(-50%);
            width: 1px;
            height: 16px;
            background: linear-gradient(to bottom, transparent, rgba(132, 93, 112, 0.2), transparent);
        }

        .custom-language-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding: 6px 24px 6px 8px;
            border: 1px solid transparent;
            border-radius: 6px;
            background: linear-gradient(135deg, rgba(132, 93, 112, 0.03) 0%, rgba(132, 93, 112, 0.06) 100%);
            color: var(--primary-color);
            font-family: 'Poppins', sans-serif;
            font-size: 0.75rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-width: 100px;
            max-width: 120px;
            position: relative;
            outline: none;
        }

        .custom-language-select:hover {
            background: linear-gradient(135deg, rgba(132, 93, 112, 0.08) 0%, rgba(132, 93, 112, 0.12) 100%);
            border-color: rgba(132, 93, 112, 0.2);
            transform: translateY(-0.5px);
            box-shadow: 0 2px 6px rgba(132, 93, 112, 0.1);
        }

        .custom-language-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(132, 93, 112, 0.15);
            background: white;
        }

        .custom-language-select:active {
            transform: translateY(0);
        }

        /* Custom dropdown arrow */
        .custom-language-select {
            background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23845d70'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 6px center;
            background-size: 16px;
        }

        .custom-language-select:hover {
            background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%236d4c5a'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
        }

        /* Custom language icon - smaller and more subtle */
        .custom-translate-wrapper::after {
            content: '';
            position: absolute;
            right: -20px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            background: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23845d70' opacity='0.4'%3E%3Cpath d='M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z'/%3E%3C/svg%3E") no-repeat center;
            background-size: contain;
            opacity: 0.5;
            transition: all 0.3s ease;
        }

        .custom-translate-wrapper:hover::after {
            opacity: 0.8;
            transform: translateY(-50%) scale(1.05);
        }

        /* Mobile Version - more compact */
        .custom-translate-wrapper-mobile {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 20px;
            border-top: 1px solid #e9ecef;
            background: linear-gradient(135deg, rgba(132, 93, 112, 0.02) 0%, rgba(132, 93, 112, 0.05) 100%);
        }

        .custom-language-select-mobile {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 100%;
            padding: 10px 32px 10px 12px;
            border: 1px solid rgba(132, 93, 112, 0.15);
            border-radius: 8px;
            background: white;
            color: var(--primary-color);
            font-family: 'Poppins', sans-serif;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .custom-language-select-mobile:hover {
            border-color: rgba(132, 93, 112, 0.3);
            box-shadow: 0 2px 6px rgba(132, 93, 112, 0.1);
            transform: translateY(-0.5px);
        }

        .custom-language-select-mobile:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(132, 93, 112, 0.15);
        }

        /* Mobile dropdown arrow */
        .custom-language-select-mobile {
            background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23845d70'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 18px;
        }

        /* Option styling - more compact */
        .custom-language-select option,
        .custom-language-select-mobile option {
            padding: 8px 12px;
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            background: white;
            color: #3d2a33;
            font-size: 0.8rem;
        }

        .custom-language-select option:hover,
        .custom-language-select-mobile option:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Loading state */
        .custom-language-select.loading,
        .custom-language-select-mobile.loading {
            animation: pulse 1.5s ease-in-out infinite;
            pointer-events: none;
            opacity: 0.7;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        /* Accessibility */
        .custom-language-select:focus-visible,
        .custom-language-select-mobile:focus-visible {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        /* Mobile responsive */
        @media (max-width: 767px) {
            .custom-translate-wrapper::after {
                display: none;
            }
        }

        /* High contrast support */
        @media (prefers-contrast: high) {
            .custom-language-select,
            .custom-language-select-mobile {
                border: 2px solid #000;
                background: white;
                color: #000;
            }
        }

        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            .custom-language-select,
            .custom-language-select-mobile {
                transition: none;
            }

            .custom-translate-wrapper::after {
                transition: none;
            }
        }
    </style>
</div>

@push('scripts')
<!-- Enhanced Google Translate with comprehensive error handling -->
<script>
    // Intercept and block problematic Google Translate requests
    (function() {
        // Store original fetch
        const originalFetch = window.fetch;
        const originalXHROpen = XMLHttpRequest.prototype.open;

        // Intercept fetch requests
        window.fetch = function(url, options) {
            if (url && typeof url === 'string') {
                if (url.includes('translate.googleapis.com') ||
                    url.includes('element/log') ||
                    url.includes('translate.google.com')) {
                    console.log('Blocking Google Translate analytics request:', url);
                    return Promise.reject(new Error('Request blocked by custom handler'));
                }
            }
            return originalFetch.apply(this, arguments);
        };

        // Intercept XMLHttpRequest
        XMLHttpRequest.prototype.open = function(method, url, async, user, password) {
            if (url && typeof url === 'string') {
                if (url.includes('translate.googleapis.com') ||
                    url.includes('element/log') ||
                    url.includes('translate.google.com')) {
                    console.log('Blocking Google Translate XHR request:', url);
                    // Don't actually open the request
                    return;
                }
            }
            return originalXHROpen.apply(this, arguments);
        };
    })();

    // Enhanced CSP meta tag
    (function() {
        const meta = document.createElement('meta');
        meta.httpEquiv = 'Content-Security-Policy';
        meta.content = `
            script-src 'self' 'unsafe-inline' 'unsafe-eval' https://translate.google.com https://ssl.gstatic.com https://www.gstatic.com;
            connect-src 'self' https://translate.googleapis.com;
            img-src 'self' data: https: https://ssl.gstatic.com https://www.gstatic.com;
            style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://ssl.gstatic.com;
            font-src 'self' https://fonts.gstatic.com;
        `.replace(/\s+/g, ' ').trim();

        // Only add if not already present
        if (!document.querySelector('meta[http-equiv="Content-Security-Policy"]')) {
            document.head.appendChild(meta);
        }
    })();

    // Fallback function for loading Google Translate
    function loadGoogleTranslate() {
        const script = document.createElement('script');
        script.type = 'text/javascript';
        script.async = true;

        // Try primary source first
        script.src = '//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';

        // Add error handling
        script.onerror = function() {
            console.warn('Primary Google Translate source failed, trying alternative...');
            // Try alternative source
            const fallbackScript = document.createElement('script');
            fallbackScript.type = 'text/javascript';
            fallbackScript.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
            fallbackScript.onerror = function() {
                console.warn('Alternative Google Translate source failed, using local fallback...');
                // Initialize local fallback
                initLocalFallback();
            };
            document.head.appendChild(fallbackScript);
        };

        document.head.appendChild(script);
    }

    // Local fallback language switcher
    function initLocalFallback() {
        console.log('Using local language fallback');
        // Show a simple language selector without Google Translate
        const selectors = document.querySelectorAll('.custom-language-select, .custom-language-select-mobile');
        selectors.forEach(function(selector) {
            selector.addEventListener('change', function() {
                // Store preference
                localStorage.setItem('preferredLanguage', this.value);
                // Show notification
                showTranslationNotification(this.value);
            });
        });
    }

    function showTranslationNotification(language) {
        const languageNames = {
            'en': 'English',
            'id': 'Bahasa Indonesia',
            'zh-CN': '中文',
            'ja': '日本語',
            'ko': '한국어',
            'th': 'ไทย',
            'vi': 'Tiếng Việt',
            'ms': 'Bahasa Melayu',
            'tl': 'Filipino',
            'fr': 'Français',
            'de': 'Deutsch',
            'es': 'Español',
            'pt': 'Português',
            'ru': 'Русский',
            'ar': 'العربية'
        };

        // Create notification
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--primary-color);
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            z-index: 9999;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            animation: slideIn 0.3s ease;
        `;
        notification.innerHTML = `
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-info-circle"></i>
                <span>Language set to ${languageNames[language] || language}</span>
            </div>
        `;

        document.body.appendChild(notification);

        // Remove after 3 seconds
        setTimeout(function() {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(function() {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }

    // Add animation styles
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);

    // Initialize Google Translate with fallback
    let googleTranslateElement = null;
    let googleTranslateElementMobile = null;
    let googleTranslateLoaded = false;

    function googleTranslateElementInit() {
        try {
            googleTranslateLoaded = true;
            console.log('Google Translate loaded successfully');

            // Initialize hidden Google Translate elements
            googleTranslateElement = new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'en,id,zh-CN,ja,ko,th,vi,ms,tl,fr,de,es,pt,ru,ar',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false,
                multilanguagePage: true
            }, 'google_translate_element');

            googleTranslateElementMobile = new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'en,id,zh-CN,ja,ko,th,vi,ms,tl,fr,de,es,pt,ru,ar',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false,
                multilanguagePage: true
            }, 'google_translate_element_mobile');

            // Setup custom selectors after Google Translate loads
            setTimeout(setupCustomSelectors, 1000);
        } catch (error) {
            console.error('Google Translate initialization failed:', error);
            initLocalFallback();
        }
    }

    function setupCustomSelectors() {
        // Desktop selector
        const desktopSelector = document.getElementById('customLanguageSelector');
        const mobileSelector = document.getElementById('customLanguageSelectorMobile');

        if (desktopSelector) {
            desktopSelector.addEventListener('change', function() {
                if (googleTranslateLoaded) {
                    changeLanguage(this.value);
                } else {
                    initLocalFallback();
                    localStorage.setItem('preferredLanguage', this.value);
                    showTranslationNotification(this.value);
                }
                // Sync mobile selector
                if (mobileSelector) {
                    mobileSelector.value = this.value;
                }
            });
        }

        if (mobileSelector) {
            mobileSelector.addEventListener('change', function() {
                if (googleTranslateLoaded) {
                    changeLanguage(this.value);
                } else {
                    initLocalFallback();
                    localStorage.setItem('preferredLanguage', this.value);
                    showTranslationNotification(this.value);
                }
                // Sync desktop selector
                if (desktopSelector) {
                    desktopSelector.value = this.value;
                }
            });
        }

        // Detect current language and set selector value
        detectCurrentLanguage();
    }

    function changeLanguage(languageCode) {
        if (!googleTranslateLoaded) {
            showTranslationNotification(languageCode);
            return;
        }

        // Add loading state
        document.querySelectorAll('.custom-language-select, .custom-language-select-mobile').forEach(function(select) {
            select.classList.add('loading');
        });

        // Find the Google Translate dropdown and change its value
        const googleDropdown = document.querySelector('.goog-te-combo');
        if (googleDropdown) {
            googleDropdown.value = languageCode;
            googleDropdown.dispatchEvent(new Event('change'));
        }

        // Remove loading state after a delay
        setTimeout(function() {
            document.querySelectorAll('.custom-language-select, .custom-language-select-mobile').forEach(function(select) {
                select.classList.remove('loading');
            });
        }, 1500);

        // Save language preference
        localStorage.setItem('preferredLanguage', languageCode);

        // Add smooth transition effect
        document.body.style.opacity = '0.95';
        setTimeout(function() {
            document.body.style.opacity = '1';
        }, 300);
    }

    function detectCurrentLanguage() {
        // Check if page is translated
        const body = document.body;
        let currentLang = 'en';

        if (body.classList.contains('translated-ltr') && googleTranslateLoaded) {
            // Try to detect current language from Google Translate
            const googleDropdown = document.querySelector('.goog-te-combo');
            if (googleDropdown && googleDropdown.value) {
                currentLang = googleDropdown.value;
            }
        }

        // Check saved preference
        const savedLang = localStorage.getItem('preferredLanguage');
        if (savedLang && savedLang !== 'en') {
            currentLang = savedLang;
        }

        // Set both selectors to current language
        const desktopSelector = document.getElementById('customLanguageSelector');
        const mobileSelector = document.getElementById('customLanguageSelectorMobile');

        if (desktopSelector) desktopSelector.value = currentLang;
        if (mobileSelector) mobileSelector.value = currentLang;
    }

    // Load Google Translate with fallback
    document.addEventListener('DOMContentLoaded', function() {
        // Load Google Translate
        loadGoogleTranslate();

        // Setup other functionality
        setupEnhancedFeatures();
    });

    function setupEnhancedFeatures() {
        // Hide all Google Translate elements
        function hideGoogleElements() {
            const elementsToHide = [
                '.goog-te-banner-frame',
                '.goog-te-gadget > span:first-child',
                '.goog-te-gadget .goog-te-combo + span',
                '.goog-tooltip'
            ];

            elementsToHide.forEach(function(selector) {
                const elements = document.querySelectorAll(selector);
                elements.forEach(function(element) {
                    element.style.display = 'none';
                });
            });

            // Ensure Google Translate dropdown is hidden
            const googleDropdowns = document.querySelectorAll('.goog-te-combo');
            googleDropdowns.forEach(function(dropdown) {
                dropdown.style.display = 'none';
            });
        }

        // Initial hide
        hideGoogleElements();

        // Periodic hiding to handle dynamic changes
        setInterval(hideGoogleElements, 2000);

        // Final hide after page loads
        window.addEventListener('load', function() {
            setTimeout(hideGoogleElements, 1000);
        });

        // Add keyboard navigation
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + L to focus language selector
            if ((e.ctrlKey || e.metaKey) && e.key === 'l') {
                e.preventDefault();
                const desktopSelector = document.getElementById('customLanguageSelector');
                if (desktopSelector) {
                    desktopSelector.focus();
                    desktopSelector.click();
                }
            }
        });

        // Add smooth scroll when language changes
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

                        // Update selectors to reflect new language
                        detectCurrentLanguage();
                    }
                }
            });
        });

        observer.observe(document.body, {
            attributes: true,
            attributeFilter: ['class']
        });

        // Add hover effects
        const customSelects = document.querySelectorAll('.custom-language-select, .custom-language-select-mobile');
        customSelects.forEach(function(select) {
            select.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-0.5px)';
            });

            select.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Add focus effects
        customSelects.forEach(function(select) {
            select.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.01)';
            });

            select.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    }

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function() {
        detectCurrentLanguage();
    });

    // Handle page visibility changes
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            detectCurrentLanguage();
        }
    });
</script>
@endpush
