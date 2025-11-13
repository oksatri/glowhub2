@extends('front._parts.master')
@section('meta_title', 'Find MUAs - ' . ($siteSetting->site_name ?? 'GlowHub'))
@section('meta_description',
    $siteSetting->meta_description ??
    ($siteSetting->site_tagline ??
    'Find professional makeup
    artists in your area.'))
@section('content')
    <style>
        /* Beautiful Title Animations */
        @keyframes sparkle {

            0%,
            100% {
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

            0%,
            100% {
                transform: scale(1);
                opacity: 0.7;
            }

            50% {
                transform: scale(1.2);
                opacity: 1;
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

        .highlight-text {
            position: relative;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .highlight-text:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(132, 93, 112, 0.2);
        }

        .title-icon {
            position: relative;
        }

        .subtitle-wrapper {
            max-width: 600px;
            margin: 0 auto;
        }

        /* Enhanced hover effects for title */
        h1:hover {
            transform: translateY(-3px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Elegant Filter Styles */
        .filter-container {
            position: relative;
            overflow: hidden;
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
        }

        .custom-select:focus {
            border-color: #845d70 !important;
            box-shadow: 0 0 0 0.2rem rgba(132, 93, 112, 0.15) !important;
            transform: translateY(-2px);
        }

        .custom-select:hover {
            border-color: #845d70 !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(132, 93, 112, 0.15);
        }

        .filter-label {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
        }

        .btn-search:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 25px rgba(132, 93, 112, 0.4) !important;
            background: linear-gradient(135deg, #6d4c5a 0%, #845d70 100%) !important;
        }

        .btn-reset:hover {
            background: #f8bbbd !important;
            border-color: #845d70 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(248, 187, 189, 0.4);
        }

        /* Floating Animation */
        .filter-container {
            animation: float 6s ease-in-out infinite;
        }



        /* Responsive adjustments */
        @media (max-width: 768px) {
            .filter-container {
                margin: 1rem;
                padding: 1.5rem !important;
            }

            .custom-select {
                padding: 10px 14px !important;
                font-size: 0.9rem;
            }

            /* Mobile title adjustments */
            .title-icon i {
                font-size: 2rem !important;
            }

            h1.display-4 {
                font-size: 1.8rem !important;
            }

            .subtitle-wrapper p {
                font-size: 1rem !important;
                padding: 0 1rem;
            }

            .decorative-elements {
                gap: 8px;
            }

            .decorative-dot {
                width: 6px;
                height: 6px;
            }
        }
    </style>
    <!-- Hero Section -->
    <section class="py-5" style="background: linear-gradient(135deg, var(--bs-light) 0%, #fff4ed 100%);">
        <div class="container">
            <!-- Page Title -->
            <div class="text-center mb-5">
                <!-- Main Title -->
                <h1 class="fw-bold mb-3"
                    style="background: linear-gradient(135deg, #845d70 0%, #ff6b9d 50%, #845d70 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-size: 200% 200%; animation: gradientShift 3s ease-in-out infinite; text-shadow: 0 4px 8px rgba(132, 93, 112, 0.1);">
                    ✨ Find Your Perfect MUA ✨
                </h1>

                <!-- Subtitle -->
                <div class="subtitle-wrapper mb-4">
                    <p class="lead text-muted" style="font-size: 1.1rem; line-height: 1.6;">
                        <span class="highlight-text"
                            style="background: linear-gradient(120deg, rgba(248, 187, 189, 0.3) 0%, rgba(132, 93, 112, 0.1) 100%); padding: 2px 8px; border-radius: 6px; font-weight: 500;">Temukan
                            makeup artist</span>
                        profesional di dekatmu. Lihat portofolio, review, dan harga secara transparan sebelum booking.
                    </p>
                </div>
            </div>

            <!-- Elegant Filter Section -->
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="filter-container"
                        style="background: linear-gradient(145deg, rgba(255,255,255,0.95) 0%, rgba(248,187,189,0.1) 100%); backdrop-filter: blur(10px); border-radius: 15px; box-shadow: 0 6px 24px rgba(132, 93, 112, 0.12); border: 1px solid rgba(255,255,255,0.2); padding: 1.5rem;">
                        <!-- Filter Form -->
                        <form class="filter-form" method="GET" action="{{ route('mua.listing') }}"
                            style="margin-bottom: 0px !important">
                            <div class="row">
                                <!-- Event Type Filter -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="filter-group">
                                        <div class="custom-select-wrapper">
                                            <select name="event_type" class="form-select custom-select"
                                                style="border: 2px solid #f8bbbd; border-radius: 15px; padding: 10px 14px; background: rgba(255,255,255,0.9); color: #3d2a33; font-weight: 500; font-size: 0.9rem;">
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

                                <!-- Date Filter (use date input to prevent past dates) -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="filter-group">
                                        <div class="custom-select-wrapper">
                                            <input type="date" name="date" class="form-control custom-select"
                                                id="dateSelect"
                                                style="border: 2px solid #f8bbbd; border-radius: 15px; padding: 10px 14px; background: rgba(255,255,255,0.9); color: #3d2a33; font-weight: 500; font-size: 0.9rem;"
                                                min="{{ date('Y-m-d') }}" value="{{ $request->date ?? date('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Time Filter -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="filter-group">
                                        <div class="custom-select-wrapper">
                                            <select name="time" class="form-select custom-select"
                                                style="border: 2px solid #f8bbbd; border-radius: 15px; padding: 10px 14px; background: rgba(255,255,255,0.9); color: #3d2a33; font-weight: 500; font-size: 0.9rem;">
                                                <option value="" selected>⏰ Jam acara kamu</option>
                                                @foreach ($filterOptions['times'] as $time)
                                                    <option value="{{ $time }}"
                                                        {{ $request->time === $time ? 'selected' : '' }}>{{ $time }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <code>Jam yang kamu pilih adalah waktu selesai makeup</code>
                                        </div>
                                    </div>
                                </div>

                                <!-- City Filter -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="filter-group">
                                        <div class="custom-select-wrapper">
                                            <select name="province_id" class="form-select custom-select" id="provinceSelect"
                                                style="border: 2px solid #f8bbbd; border-radius: 15px; padding: 10px 14px; background: rgba(255,255,255,0.9); color: #3d2a33; font-weight: 500; font-size: 0.9rem;">
                                                <option value="" selected>📍 Semua Provinsi...</option>
                                                @foreach ($filterOptions['provinces'] as $key => $province)
                                                    <option value="{{ $key }}"
                                                        {{ isset($request->province_id) && $request->province_id == $key ? 'selected' : '' }}>
                                                        {{ $province }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6">
                                    <div class="filter-group">
                                        <div class="custom-select-wrapper">
                                            <select name="regency_id" class="form-select custom-select" id="citySelect"
                                                style="border: 2px solid #f8bbbd; border-radius: 15px; padding: 10px 14px; background: rgba(255,255,255,0.9); color: #3d2a33; font-weight: 500; font-size: 0.9rem;">
                                                <option value="" selected>📍 Semua Kota/Kabupaten...</option>
                                                @php
                                                    $selectedProvince = isset($request->province_id)
                                                        ? $request->province_id
                                                        : '';
                                                    $initialCities = $filterOptions['cities'][$selectedProvince] ?? [];
                                                @endphp
                                                @foreach ($initialCities as $c)
                                                    <option value="{{ $c['id'] }}"
                                                        {{ isset($request->regency_id) && $request->regency_id == $c['id'] ? 'selected' : '' }}>
                                                        {{ $c['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6">
                                    <div class="filter-group">
                                        <div class="custom-select-wrapper">
                                            <select name="district_id" class="form-select custom-select" id="districtSelect"
                                                style="border: 2px solid #f8bbbd; border-radius: 15px; padding: 10px 14px; background: rgba(255,255,255,0.9); color: #3d2a33; font-weight: 500; font-size: 0.9rem;">
                                                <option value="" selected>📍 Semua Kecamatan...</option>
                                                @php
                                                    $selectedRegency = isset($request->regency_id)
                                                        ? $request->regency_id
                                                        : '';
                                                    $initialDistricts =
                                                        $filterOptions['districts'][$selectedRegency] ?? [];
                                                @endphp
                                                @foreach ($initialDistricts as $d)
                                                    <option value="{{ $d['id'] }}"
                                                        {{ isset($request->district_id) && $request->district_id == $d['id'] ? 'selected' : '' }}>
                                                        {{ $d['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="filter-actions">
                                <div class="d-flex gap-2 justify-content-center">
                                    <button type="submit" class="btn btn-search"
                                        style="background: linear-gradient(135deg, #845d70 0%, #6d4c5a 100%); border: none; border-radius: 20px; padding: 0px 20px; color: white; font-weight: 600; box-shadow: 0 4px 15px rgba(132, 93, 112, 0.3); transition: all 0.3s ease; font-size: 0.9rem;">
                                        <i class="fas fa-search me-1"></i>Search MUAs
                                    </button>
                                    <button class="btn btn-reset" type="button"
                                        style="background: transparent; border: 2px solid #f8bbbd; border-radius: 20px; padding: 0px 20px; color: #845d70; font-weight: 600; transition: all 0.3s ease; font-size: 0.9rem;">
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
    <section id="mua-results" class="py-5 section-bg-light">
        <div class="container">
            <div class="row g-4">
                @foreach ($items as $mua)
                    <!-- MUA Card -->
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0 position-relative">
                            <!-- Heart Icon -->
                            <div class="position-absolute top-0 end-0 p-3" style="z-index: 10;">
                                <i class="far fa-heart text-primary" style="font-size: 1.2rem; cursor: pointer;"></i>
                            </div>

                            <!-- MUA Image -->
                            <div class="position-relative">
                                <img src="{{ $mua['image'] }}" alt="{{ $mua['name'] }}" class="card-img-top"
                                    style="height: 200px; object-fit: cover;">
                            </div>

                            <!-- Card Body -->
                            <div class="card-body text-center p-4">
                                <h5 class="fw-bold">{{ $mua['name'] }}</h5>
                                <p class="text-primary mb-2">{{ $mua['speciality'] }} • {{ $mua['location'] }}</p>

                                <!-- Rating -->
                                <div class="mb-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= floor($mua['rating']))
                                            <i class="fas fa-star text-warning" style="font-size: 0.9rem;"></i>
                                        @elseif($i <= $mua['rating'])
                                            <i class="fas fa-star-half-alt text-warning" style="font-size: 0.9rem;"></i>
                                        @else
                                            <i class="far fa-star text-warning" style="font-size: 0.9rem;"></i>
                                        @endif
                                    @endfor
                                    <span class="text-muted small ms-2">{{ $mua['rating'] }} ({{ $mua['reviews_count'] }}
                                        reviews)</span>
                                </div>

                                <p class="text-muted small mb-3">From Rp. {{ number_format($mua['price'], 0, ',', '.') }}
                                </p>
                                <a href="{{ route('mua.detail', $mua['id']) }}"
                                    class="btn btn-outline-primary btn-sm">View
                                    Profile</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- "Lihat lebih banyak" Section -->
            {{-- <div class="text-center mt-5">
                <hr style="border-top: 2px solid #845d70; width: 100px; margin: 0 auto;">
                <p class="my-3 text-muted fw-bold">Lihat lebih banyak</p>
            </div> --}}

            <!-- Pagination -->
            <nav aria-label="MUA pagination" class="mt-4">
                <ul class="pagination justify-content-center">
                    <!-- Previous Button -->
                    <li class="page-item {{ $pagination['current_page'] == 1 ? 'disabled' : '' }}">
                        <a class="page-link"
                            href="{{ $pagination['current_page'] > 1 ? '?page=' . ($pagination['current_page'] - 1) : '#' }}"
                            style="color: #845d70; border: 1px solid #845d70; border-radius: 10px; margin: 0 2px;">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>

                    <!-- Page Numbers -->
                    @for ($i = 1; $i <= $pagination['last_page']; $i++)
                        <li class="page-item {{ $pagination['current_page'] == $i ? 'active' : '' }}">
                            <a class="page-link" href="?page={{ $i }}"
                                style="{{ $pagination['current_page'] == $i ? 'background-color: #845d70; border-color: #845d70;' : 'color: #845d70; border: 1px solid #845d70;' }} border-radius: 10px; margin: 0 2px;">
                                {{ $i }}
                            </a>
                        </li>
                    @endfor

                    <!-- Next Button -->
                    <li class="page-item {{ $pagination['current_page'] >= $pagination['last_page'] ? 'disabled' : '' }}">
                        <a class="page-link"
                            href="{{ $pagination['current_page'] < $pagination['last_page'] ? '?page=' . ($pagination['current_page'] + 1) : '#' }}"
                            style="color: #845d70; border: 1px solid #845d70; border-radius: 10px; margin: 0 2px;">
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
            const provinceSelect = document.getElementById('provinceSelect');
            const citySelect = document.getElementById('citySelect');
            const districtSelect = document.getElementById('districtSelect');
            const cities = @json($filterOptions['cities'] ?? []);
            const districts = @json($filterOptions['districts'] ?? []);

            function populateCities(province) {
                citySelect.innerHTML = '<option value="">📍 Semua Kota/Kabupaten...</option>';
                if (!province || !cities[province]) return;

                cities[province].forEach(function(city) {
                    const opt = document.createElement('option');
                    opt.value = city.id;
                    opt.textContent = city.name;
                    citySelect.appendChild(opt);
                });
            }

            function populateDistricts(city) {
                if (!districtSelect) return;
                districtSelect.innerHTML = '<option value="">📍 Semua Kecamatan...</option>';
                if (!city || !districts[city]) return;
                districts[city].forEach(function(d) {
                    const opt = document.createElement('option');
                    opt.value = d.id;
                    opt.textContent = d.name;
                    districtSelect.appendChild(opt);
                });
            }


            if (provinceSelect) {
                provinceSelect.addEventListener('change', function() {
                    populateCities(this.value);
                });
                // when city changes, populate districts
                if (citySelect) {
                    citySelect.addEventListener('change', function() {
                        populateDistricts(this.value);
                    });
                }
                // if a province is already selected on load, populate cities
                if (provinceSelect.value) populateCities(provinceSelect.value);
                // also if a city is already selected on load, populate districts
                if (citySelect && citySelect.value) populateDistricts(citySelect.value);
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
