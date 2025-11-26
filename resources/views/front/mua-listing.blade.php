@extends('front._parts.master')
@section('meta_title', 'Find MUAs - ' . ($siteSetting->site_name ?? 'GlowHub'))
@section('meta_description',
    $siteSetting->meta_description ??
    ($siteSetting->site_tagline ??
    'Find professional makeup
    artists in your area.'))
@section('content')
    <style>
        /* === RESPONSIVE MUA LISTING IMPROVEMENTS === */

        /* Beautiful Title Animations */
        @keyframes sparkle {
            0%, 100% {
                transform: scale(1) rotate(0deg);
                opacity: 0.8;
            }
            50% {
                transform: scale(1.1) rotate(5deg);
                opacity: 1;
            }
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.7;
            }
            50% {
                transform: scale(1.2);
                opacity: 1;
            }
        }

        /* Hero Section Improvements */
        .hero-section {
            padding: 3rem 0;
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 2rem 0;
            }
        }

        .decorative-elements {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 1rem;
        }

        .decorative-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }

        @media (max-width: 768px) {
            .decorative-elements {
                gap: 8px;
            }
            .decorative-dot {
                width: 6px;
                height: 6px;
            }
        }

        .highlight-text {
            position: relative;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .highlight-text:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(132, 93, 112, 0.2);
        }

        /* Filter Container */
        .filter-container {
            position: relative;
            overflow: hidden;
            padding: 1.5rem;
            border-radius: 15px;
            background: linear-gradient(145deg, rgba(255,255,255,0.95) 0%, rgba(248,187,189,0.1) 100%);
            backdrop-filter: blur(10px);
            box-shadow: 0 6px 24px rgba(132, 93, 112, 0.12);
            border: 1px solid rgba(255,255,255,0.2);
        }

        @media (max-width: 768px) {
            .filter-container {
                margin: 0.5rem;
                padding: 1rem;
            }
        }

        .filter-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(132,93,112,0.05)"/><circle cx="75" cy="75" r="1" fill="rgba(132,93,112,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            pointer-events: none;
            opacity: 0.3;
        }

        .custom-select-wrapper {
            position: relative;
        }

        .custom-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid #f8bbbd;
            border-radius: 15px;
            padding: 0.75rem 1rem;
            background: rgba(255,255,255,0.9);
            color: #3d2a33;
            font-weight: 500;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .custom-select {
                padding: 0.6rem 0.8rem;
                font-size: 0.85rem;
            }
        }

        .custom-select:focus {
            border-color: var(--bs-primary) !important;
            box-shadow: 0 0 0 0.2rem rgba(var(--bs-primary), 0.15) !important;
            transform: translateY(-2px);
        }

        .custom-select:hover {
            border-color: var(--bs-primary) !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(var(--bs-primary), 0.15);
        }

        /* Filter Actions */
        .filter-actions {
            margin-top: 1.5rem;
        }

        @media (max-width: 768px) {
            .filter-actions {
                margin-top: 1rem;
            }
        }

        .btn-search {
            background: linear-gradient(135deg, var(--bs-primary) 0%, #6d4c5a 100%);
            border: none;
            border-radius: 20px;
            padding: 0.75rem 1.5rem;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .btn-search {
                padding: 0.6rem 1.2rem;
                font-size: 0.85rem;
            }
        }

        .btn-search:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 25px rgba(var(--bs-primary), 0.4) !important;
        }

        .btn-reset {
            background: transparent;
            border: 2px solid #f8bbbd;
            border-radius: 20px;
            padding: 0.75rem 1.5rem;
            color: var(--bs-primary);
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .btn-reset {
                padding: 0.6rem 1.2rem;
                font-size: 0.85rem;
            }
        }

        .btn-reset:hover {
            background: #f8bbbd !important;
            border-color: var(--bs-primary) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(248, 187, 189, 0.4);
        }

        /* MUA Cards Grid */
        .mua-grid {
            display: grid;
            gap: 1.5rem;
        }

        @media (max-width: 768px) {
            .mua-grid {
                gap: 1rem;
            }
        }

        .mua-card {
            background-color: #FDE1E1;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .mua-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .mua-card-body {
            padding: 1rem;
            background-color: #F7BCC6;
        }

        @media (max-width: 768px) {
            .mua-card-body {
                padding: 0.75rem;
            }
        }

        /* MUA Card Content */
        .mua-name {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        @media (max-width: 768px) {
            .mua-name {
                font-size: 0.85rem;
            }
        }

        .mua-location {
            font-size: 0.78rem;
            color: #333;
        }

        .mua-category {
            font-size: 0.74rem;
            color: #666;
        }

        .mua-rating {
            font-size: 0.78rem;
        }

        .mua-price {
            font-size: 0.9rem;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .mua-price {
                font-size: 0.85rem;
            }
        }

        /* Responsive Typography */
        h1.display-4 {
            font-size: 2.5rem;
        }

        @media (max-width: 768px) {
            h1.display-4 {
                font-size: 1.8rem !important;
            }
        }

        .subtitle-wrapper p {
            font-size: 1.1rem;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .subtitle-wrapper p {
                font-size: 1rem !important;
                padding: 0 1rem;
            }
        }

        /* Pagination */
        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            color: var(--bs-primary);
            border: 1px solid var(--bs-primary);
            border-radius: 10px;
            margin: 0 2px;
            padding: 0.5rem 0.75rem;
            transition: all 0.3s ease;
        }

        .page-link:hover {
            background-color: var(--bs-primary);
            color: white;
        }

        .page-item.active .page-link {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
        }

        /* Button improvements */
        .btn-outline-danger {
            border-color: var(--bs-primary);
            color: var(--bs-primary);
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .btn-outline-danger:hover {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
        }

        @media (max-width: 768px) {
            .btn-outline-danger {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
            }
        }

        /* Heart button */
        .btn-heart {
            background: transparent;
            border: none;
            padding: 0.25rem;
            transition: all 0.3s ease;
        }

        .btn-heart:hover {
            transform: scale(1.2);
        }

        .btn-heart .fa-heart {
            color: #e74c3c;
            transition: all 0.3s ease;
        }

        /* Section spacing */
        .section-bg-light {
            padding: 3rem 0;
        }

        @media (max-width: 768px) {
            .section-bg-light {
                padding: 2rem 0;
            }
        }

        /* Utility classes */
        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Responsive grid adjustments */
        @media (max-width: 576px) {
            .col-6 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        @media (min-width: 577px) and (max-width: 768px) {
            .col-md-4 {
                flex: 0 0 33.333333%;
                max-width: 33.333333%;
            }
        }
    </style>
    <!-- Hero Section -->
    <section class="hero-section" style="background: linear-gradient(135deg, var(--bs-light) 0%, #fff4ed 100%);">
        <div class="container">
            <!-- Page Title -->
            <div class="text-center mb-4">
                <!-- Main Title -->
                <h1 class="fw-bold mb-3 display-4"
                    style="background: linear-gradient(135deg, var(--bs-primary) 0%, #ff6b9d 50%, var(--bs-primary) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-size: 200% 200%; animation: gradientShift 3s ease-in-out infinite; text-shadow: 0 4px 8px rgba(var(--bs-primary), 0.1);">
                    ✨ Find Your Perfect MUA ✨
                </h1>

                <!-- Subtitle -->
                <div class="subtitle-wrapper mb-3">
                    <p class="lead text-muted">
                        <span class="highlight-text"
                            style="background: linear-gradient(120deg, rgba(248, 187, 189, 0.3) 0%, rgba(var(--bs-primary), 0.1) 100%); padding: 2px 8px; border-radius: 6px; font-weight: 500;">Temukan
                            makeup artist</span>
                        profesional di dekatmu. Lihat portofolio, review, dan harga secara transparan sebelum booking.
                    </p>
                </div>
            </div>

            <!-- Elegant Filter Section -->
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="filter-container">
                        <!-- Filter Form -->
                        <form class="filter-form" method="GET" action="{{ route('mua.listing') }}">
                            <div class="row g-3">
                                <!-- Event Type Filter -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="filter-group">
                                        <div class="custom-select-wrapper">
                                            <select name="event_type" class="form-select custom-select">
                                                <option value="" selected>🎉 Semua jenis acara...</option>
                                                @foreach ($filterOptions['events'] as $event)
                                                    <option value="{{ $event }}"
                                                        {{ $request->event_type === $event ? 'selected' : '' }}>
                                                        {{ $event }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Date Filter -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="filter-group">
                                        <div class="custom-select-wrapper">
                                            <input type="date" name="date" class="form-control custom-select"
                                                id="dateSelect"
                                                min="{{ date('Y-m-d') }}" value="{{ $request->date ?? date('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Time Filter -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="filter-group">
                                        <div class="custom-select-wrapper">
                                            <select name="time" class="form-select custom-select">
                                                <option value="" selected>⏰ Jam acara kamu</option>
                                                @foreach ($filterOptions['times'] as $time)
                                                    <option value="{{ $time }}"
                                                        {{ $request->time === $time ? 'selected' : '' }}>{{ $time }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- City Filter -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="filter-group">
                                        <div class="custom-select-wrapper">
                                            <select name="regency_id" class="form-select custom-select" id="citySelect">
                                                <option value="" selected>📍 Semua Kota/Kabupaten...</option>
                                                @if (is_array($filterOptions['cities']) && count($filterOptions['cities']) > 0)
                                                    @foreach ($filterOptions['cities'] as $provinceId => $citiesByProvince)
                                                        @foreach ($citiesByProvince as $c)
                                                            <option value="{{ $c['id'] }}"
                                                                {{ isset($request->regency_id) && $request->regency_id == $c['id'] ? 'selected' : '' }}>
                                                                {{ $c['name'] }}
                                                            </option>
                                                        @endforeach
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="filter-actions">
                                <div class="d-flex gap-2 justify-content-center">
                                    <button type="submit" class="btn btn-search">
                                        <i class="fas fa-search me-1"></i>Search MUAs
                                    </button>
                                    <button class="btn btn-reset" type="button">
                                        <i class="fas fa-redo me-2"></i>Reset
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MUA Listing Section -->
    <section id="mua-results" class="section-bg-light">
        <div class="container">
            <div class="row g-3 g-md-4">
                @foreach ($items as $mua)
                    <!-- MUA Card -->
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="h-100 mua-card">
                            <!-- Heart Icon -->
                            <div class="position-absolute top-0 end-0 p-2" style="z-index: 10;">
                                <button type="button" class="btn btn-heart">
                                    <i class="far fa-heart" style="color:#333; font-size:1.1rem;"></i>
                                </button>
                            </div>

                            <!-- MUA Image -->
                            <div class="w-100" style="aspect-ratio: 3 / 4; overflow:hidden;">
                                <img src="{{ $mua['image'] }}" alt="{{ $mua['name'] }}"
                                    style="width:100%; height:100%; object-fit:cover;">
                            </div>

                            <!-- Card Body -->
                            <div class="mua-card-body">
                                <!-- Service Name -->
                                <div class="mb-2">
                                    <h6 class="mua-name text-truncate" title="{{ $mua['name'] }}">
                                        {{ $mua['name'] }}
                                    </h6>
                                </div>

                                <!-- Location -->
                                <div class="d-flex align-items-center mb-2 mua-location">
                                    <i class="fas fa-map-marker-alt me-1" style="color:#D23B3B;"></i>
                                    <span class="text-dark text-truncate fw-semibold" title="{{ $mua['location'] }}">
                                        {{ $mua['location'] ?: '-' }}</span>
                                </div>

                                <!-- Category -->
                                <div class="mb-1">
                                    @if (!empty($mua['category']))
                                        <div class="mua-category text-truncate" title="{{ $mua['category'] }}">
                                            {{ $mua['category'] }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Rating -->
                                <div class="d-flex justify-content-between align-items-center mua-rating mb-1">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-star me-1" style="color:#FFB800;"></i>
                                        <span>
                                            {{ $mua['rating'] ? number_format($mua['rating'], 1, ',', '.') : 'Baru' }}
                                            @if ($mua['reviews_count'] > 0)
                                                <span class="text-muted">({{ $mua['reviews_count'] }})</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-1">
                                    <small class="text-muted" style="font-size: 0.8rem;">Mulai dari</small>
                                    <strong class="mua-price text-dark">
                                        {{ $mua['price'] ? 'Rp. ' . number_format($mua['price'], 0, ',', '.') : '-' }}
                                    </strong>
                                </div>

                                <div class="mt-2 text-center">
                                    <a href="{{ route('mua.detail', ['id' => $mua['id'], 'service_id' => $mua['service_id'] ?? null]) }}" class="btn btn-outline-danger btn-sm">
                                        View Porto
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <nav aria-label="MUA pagination" class="mt-4">
                <ul class="pagination justify-content-center">
                    <!-- Previous Button -->
                    <li class="page-item {{ $pagination['current_page'] == 1 ? 'disabled' : '' }}">
                        <a class="page-link"
                            href="{{ $pagination['current_page'] > 1 ? '?page=' . ($pagination['current_page'] - 1) : '#' }}">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>

                    <!-- Page Numbers -->
                    @for ($i = 1; $i <= $pagination['last_page']; $i++)
                        <li class="page-item {{ $pagination['current_page'] == $i ? 'active' : '' }}">
                            <a class="page-link" href="?page={{ $i }}">
                                {{ $i }}
                            </a>
                        </li>
                    @endfor

                    <!-- Next Button -->
                    <li class="page-item {{ $pagination['current_page'] >= $pagination['last_page'] ? 'disabled' : '' }}">
                        <a class="page-link"
                            href="{{ $pagination['current_page'] < $pagination['last_page'] ? '?page=' . ($pagination['current_page'] + 1) : '#' }}">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>

                <!-- Pagination Info -->
                <div class="text-center mt-3">
                    <small class="text-muted">
                        Showing {{ ($pagination['current_page'] - 1) * $pagination['per_page'] + 1 }}
                        to {{ min($pagination['current_page'] * $pagination['per_page'], $pagination['total']) }}
                        of {{ $pagination['total'] }} results
                    </small>
                </div>
            </nav>
        </div>
    </section>

    <!-- Section Separator -->
    <div class="geometric-separator">
        <div class="geometric-pattern">
            <div class="diamond"></div>
            <div class="diamond"></div>
            <div class="diamond"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Preloaded hierarchical locations (provinces -> regencies -> districts)
            const citySelect = document.getElementById('citySelect');
            const cities = @json($filterOptions['cities'] ?? []);

            // preserve selected city when editing/filtering
            if (citySelect) {
                const selected = "{{ isset($request->regency_id) ? $request->regency_id : '' }}";
                if (selected) citySelect.value = selected;
            }

            function loadingPage() {
                var btn_submit = $('.btn-search');
                var btn_reset = $('.btn-reset');
                btn_submit.html('<i class="fas fa-spinner fa-spin me-2"></i>Searching...');
                btn_submit.prop('disabled', true);
                btn_reset.prop('disabled', true);
            }

            // Intercept form submit to show a brief UI feedback then navigate (GET)
            $('.filter-form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                loadingPage();
                // Build url and navigate (GET)
                var url = form.attr('action') || window.location.pathname;
                var queryString = form.serialize();
                setTimeout(() => {
                    window.location.href = url + '?' + queryString;
                }, 1000);
            });

            $('.btn-reset').on('click', function() {
                loadingPage();
                setTimeout(() => {
                    window.location.href = "{{ route('mua.listing') }}";
                }, 1000);
            });
        });
    </script>
@endpush
