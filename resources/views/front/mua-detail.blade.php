@extends('front._parts.master')
@section('meta_title', ($mua['location'] ?? 'MUA Profile') . ' - ' . ($siteSetting->site_name ?? 'GlowHub'))
@section('meta_description', ($mua['description'] ?? '') . ' • ' . ($siteSetting->meta_description ??
    ($siteSetting->site_tagline ?? '')))
@section('content')
    <style>
        /* === CLEAN & PROFESSIONAL STYLING === */
        .hero-gradient {
            background: linear-gradient(135deg, #ffd6e8 0%, #ffe9f2 100%) !important;
            padding: 1.5rem 0 !important;
        }

        @media (max-width: 768px) {
            .hero-gradient {
                padding: 1rem 0 !important;
            }
        }

        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
        }

        .floating-circle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .circle-1 {
            width: 60px;
            height: 60px;
            top: 20%;
            left: 10%;
        }

        .circle-2 {
            width: 80px;
            height: 80px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .circle-3 {
            width: 50px;
            height: 50px;
            top: 40%;
            left: 70%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-15px);
            }
        }

        .breadcrumb-elegant {
            background: none !important;
            padding: 0;
            margin-bottom: 0.75rem !important;
        }

        .breadcrumb-elegant .breadcrumb-item+.breadcrumb-item::before {
            color: rgba(255, 255, 255, 0.7);
            content: "›";
        }

        .hover-opacity:hover {
            opacity: 1 !important;
        }

        .badge-glass {
            background: rgba(255, 255, 255, 0.2) !important;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white !important;
        }

        .text-glow {
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
        }

        /* === MUA DETAIL SPECIFIC IMPROVEMENTS === */

        /* Profile Section */
        .profile-section {
            margin-bottom: 1rem;
        }

        .profile-image-container {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
        }

        .profile-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Location Badge */
        .location-badge {
            position: absolute;
            bottom: 0.75rem;
            left: 0.75rem;
            background: rgba(255, 255, 255, 0.95);
            color: var(--bs-primary);
            padding: 0.375rem 0.75rem;
            border-radius: 16px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        /* Rating Stars */
        .rating {
            color: #ffc107;
            margin-bottom: 0.375rem;
        }

        /* Portfolio Grid */
        .portfolio-item {
            position: relative;
            border-radius: 6px;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s ease;
            margin-bottom: 0.75rem;
        }

        .portfolio-item:hover {
            transform: scale(1.05);
        }

        .portfolio-item img {
            width: 100%;
            height: 100px;
            object-fit: cover;
        }

        /* Booking Card */
        .booking-card {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }

        .booking-card .card-header {
            background: var(--bs-primary);
            color: white;
            text-align: center;
        }

        /* Services Section */
        .services-section {
            margin-bottom: 1rem;
        }

        .form-check {
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
            background-color: white; /* Default white background */
        }

        .form-check:hover {
            border-color: var(--bs-primary);
            background-color: rgba(var(--bs-primary), 0.05);
        }

        .form-check-input:checked ~ .form-check-label {
            color: var(--bs-primary);
            font-weight: 600;
        }

        .form-check-input:checked {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
        }

        /* When checkbox is checked, change background to light primary */
        .form-check:has(.form-check-input:checked) {
            background-color: rgba(var(--bs-primary), 0.1);
            border-color: var(--bs-primary);
        }

        /* Fallback for browsers that don't support :has() */
        .form-check.checked {
            background-color: rgba(var(--bs-primary), 0.1);
            border-color: var(--bs-primary);
        }

        /* Alert Info Box */
        .alert-info {
            border-radius: 6px;
            padding: 0.75rem;
            margin-bottom: 0.75rem;
        }

        /* Simple Interactions */
        .day-btn:hover:not(.btn-primary) {
            background-color: var(--bs-primary) !important;
            color: white !important;
        }

        .time-slot:hover:not(:disabled):not(.btn-primary) {
            background-color: var(--bs-primary) !important;
            color: white !important;
        }

        /* Responsive adjustments for MUA detail */
        @media (max-width: 768px) {
            .profile-section .row.g-3 {
                gap: 0.5rem !important;
            }

            .portfolio-item img {
                height: 80px;
            }

            .form-check {
                padding: 0.6rem;
            }

            .booking-card {
                margin-top: 0.75rem;
            }
        }

        @media (max-width: 576px) {
            .location-badge {
                bottom: 0.5rem;
                left: 0.5rem;
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }

            .alert-info {
                padding: 0.5rem;
                font-size: 0.8rem;
            }
        }
    </style>
    <!-- Hero Section -->
    <section class="hero-gradient position-relative overflow-hidden">
        <!-- Animated Background Elements -->
        <div class="floating-elements">
            <div class="floating-circle circle-1"></div>
            <div class="floating-circle circle-2"></div>
            <div class="floating-circle circle-3"></div>
        </div>

        <div class="container position-relative">
            <!-- Elegant Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-elegant">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"
                            class="text-danger text-decoration-none opacity-75 hover-opacity">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/mua-listing') }}"
                            class="text-danger text-decoration-none opacity-75 hover-opacity">Find MUA</a></li>
                    <li class="breadcrumb-item active text-danger fw-bold" aria-current="page">{{ $mua['location'] }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- MUA Detail Section -->
    <section class="py-3" style="background-color:#FFF4ED;">
        <div class="container">
            <div class="row g-2">
                <!-- Left Column - Profile & Portfolio -->
                <div class="col-lg-6">
                    <div class="profile-section">
                        <!-- Profile Card -->
                        <div class="card shadow-sm border-0 mb-2"
                            style="background-color:#FDE1E1; border-radius:8px; overflow:hidden;">
                            <!-- Profile Image -->
                            <div class="position-relative profile-image-container">
                                <div style="width:100%; aspect-ratio:3/4; overflow:hidden;">
                                    <img src="{{ $mua['image'] }}" alt="{{ $mua['service_name'] ?? $mua['name'] }}"
                                        style="width:100%; height:100%; object-fit:cover;">
                                </div>
                                <!-- Location Badge -->
                                <div class="location-badge text-danger">
                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $mua['location'] }}
                                </div>
                            </div>

                            <!-- Profile Info -->
                            <div class="card-body p-2">
                                <!-- Service Name & MUA Name -->
                                <div class="text-center mb-2">
                                    <h6 class="mb-1 fw-bold">
                                        {{ $mua['service_name'] ?? 'Service Available' }}
                                    </h6>
                                </div>

                                <div class="text-center mb-2">
                                    <p class="text-muted mb-1 small">
                                        @if (!empty($mua['max_distance']))
                                            Available within {{ $mua['max_distance'] }} km radius
                                        @else
                                            Service area available
                                        @endif
                                    </p>
                                    <p class="small text-black fst-italic mb-0">
                                        {{ $mua['description'] }}
                                    </p>
                                </div>

                                <!-- Rating & Reviews -->
                                <div class="text-center mb-2">
                                    <div class="rating mb-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($mua['rating']))
                                                <i class="fas fa-star text-warning"></i>
                                            @elseif ($i <= $mua['rating'])
                                                <i class="fas fa-star-half-alt text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <p class="small text-muted mb-0">
                                        <strong>{{ $mua['rating'] }}/5</strong> ({{ $mua['reviews'] ?? '150' }} ulasan)
                                    </p>
                                </div>

                                <!-- Services & Price -->
                                <div class="row text-center">
                                    <div class="col-6">
                                        <div class="border-end">
                                            <h6 class="fw-bold mb-1 small">Starting From</h6>
                                            <p class="small text-success fw-bold mb-0">Rp
                                                {{ number_format($mua['price'], 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <h6 class="fw-bold mb-1 small">Schedule</h6>
                                        <p class="small fw-semibold text-dark mb-0">
                                            @if (!empty($mua['operational_hours']))
                                                <i class="fas fa-clock me-1"></i>{{ $mua['operational_hours'] }}
                                            @endif
                                        </p>
                                        @if (!empty($mua['availability_hours']))
                                            @php
                                                $availabilityHours = is_array($mua['availability_hours']) ? 
                                                    $mua['availability_hours'] : 
                                                    json_decode($mua['availability_hours'], true) ?? [];
                                            @endphp
                                            @if (!empty($availabilityHours))
                                                <div class="mt-2">
                                                    <small class="text-muted d-block mb-1">
                                                        <i class="fas fa-calendar-times me-1"></i>Jam tidak tersedia:
                                                    </small>
                                                    @foreach ($availabilityHours as $slot)
                                                        @php
                                                            $slotDate = \Carbon\Carbon::parse($slot['date']);
                                                            $isToday = $slotDate->isToday();
                                                            $isPast = $slotDate->isPast();
                                                        @endphp
                                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                                            <small class="{{ $isPast ? 'text-muted text-decoration-line-through' : 'text-warning' }}">
                                                                {{ $isToday ? 'Hari ini' : $slotDate->format('d M Y') }}
                                                            </small>
                                                            <small class="{{ $isPast ? 'text-muted' : 'text-danger' }}">
                                                                {{ $slot['start_time'] }} - {{ $slot['end_time'] }}
                                                            </small>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endif
                                        @if (empty($mua['operational_hours']) && empty($mua['availability_hours']))
                                            <span class="text-muted">—</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Availability Section -->
                        @if (!empty($mua['availability_hours']))
                            @php
                                $availabilityHours = is_array($mua['availability_hours']) ? 
                                    $mua['availability_hours'] : 
                                    json_decode($mua['availability_hours'], true) ?? [];
                                
                                // Filter hanya yang akan datang
                                $upcomingSlots = array_filter($availabilityHours, function($slot) {
                                    $slotDate = \Carbon\Carbon::parse($slot['date']);
                                    return $slotDate->isToday() || $slotDate->isFuture();
                                });
                            @endphp
                            @if (!empty($upcomingSlots))
                                <div class="card shadow-sm border-0 mt-3">
                                    <div class="card-body p-3">
                                        <h6 class="fw-bold mb-3">
                                            <i class="fas fa-calendar-times me-2 text-warning"></i>Ketersediaan Jam
                                        </h6>
                                        <div class="small text-muted mb-2">
                                            Jam berikut tidak tersedia karena booking di luar platform:
                                        </div>
                                        @foreach ($upcomingSlots as $slot)
                                            @php
                                                $slotDate = \Carbon\Carbon::parse($slot['date']);
                                                $isToday = $slotDate->isToday();
                                            @endphp
                                            <div class="d-flex justify-content-between align-items-center p-2 mb-2 bg-light rounded">
                                                <div>
                                                    <span class="badge {{ $isToday ? 'bg-warning' : 'bg-secondary' }} me-2">
                                                        {{ $isToday ? 'Hari ini' : $slotDate->format('d M') }}
                                                    </span>
                                                    <small class="fw-semibold">{{ $slot['start_time'] }} - {{ $slot['end_time'] }}</small>
                                                    @if (!empty($slot['reason']))
                                                        <small class="text-muted ms-2">({{ $slot['reason'] }})</small>
                                                    @endif
                                                </div>
                                                <i class="fas fa-ban text-danger small"></i>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif

                        <!-- Portfolio Section -->
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-2">
                                <h6 class="fw-bold mb-2">
                                    <i class="fas fa-images me-2"></i>Portfolio
                                </h6>
                                <div class="row g-1">
                                    @php
                                        $badgeClasses = [
                                            'bg-primary',
                                            'bg-success',
                                            'bg-danger',
                                            'bg-warning',
                                            'bg-info',
                                            'bg-secondary',
                                        ];
                                    @endphp
                                    @if (isset($portfolio) && !empty($portfolio) && count($portfolio) > 0)
                                        @foreach ($portfolio as $index => $item)
                                            <div class="col-6">
                                                <div class="portfolio-item" data-bs-toggle="modal" data-bs-target="#portfolioModal" data-image-index="{{ $index }}">
                                                    <img src="{{ $item['image'] }}" alt="Portfolio" class="img-fluid rounded">
                                                    <div class="position-absolute top-0 start-0 m-1">
                                                        <span class="badge {{ $badgeClasses[array_rand($badgeClasses)] }} small">{{ $item['service_name'] ?? 'Portfolio' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center py-3">
                                            <i class="fas fa-camera fa-2x text-muted mb-2"></i>
                                            <p class="text-muted small">Portfolio will be available soon.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Booking Form -->
                <div class="col-lg-6">
                    <!-- Booking Card -->
                    <div class="booking-card">
                        <div class="card-header" style="padding: 10px !important;">
                            <h6 class="mb-0">
                                <i class="fas fa-calendar-alt me-2"></i>Book Your Session
                            </h6>
                            <p class="mb-0 small opacity-75">Choose your preferred date and time</p>
                        </div>

                        <div class="card-body p-3">
                            <!-- Simple Date & Time Selection -->
                            <div class="calendar-section">
                                <div class="alert alert-info small">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Booking Information:</strong> Selected time = makeup completion time.
                                    MUA arrives 1.5 hours before completion time.
                                    If you book 06:00, then 04:30 (travel) and 06:00 (completion) will be blocked.
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <label class="form-label small">Select Date</label>
                                        <input type="date" class="form-control" id="bk_date">
                                    </div>

                                    <!-- Time Slots -->
                                    <div class="col-md-6">
                                        <label class="form-label small">Available Times</label>
                                        @php
                                            $timeSlots = [];
                                            $selectedTime = null;

                                            // Generate time slots every 30 minutes based on operational_hours if possible
                                            $op = $mua['operational_hours'] ?? '';
                                            if (!empty($op) && preg_match('/(\d{1,2})[:\.](\d{2}).*?(\d{1,2})[:\.](\d{2})/u', $op, $m)) {
                                                try {
                                                    $start = new \DateTime($m[1] . ':' . $m[2]);
                                                    $end = new \DateTime($m[3] . ':' . $m[4]);
                                                    while ($start <= $end) {
                                                        $timeSlots[] = $start->format('H:i');
                                                        $start->modify('+30 minutes');
                                                    }
                                                } catch (\Exception $e) {
                                                    $timeSlots = [];
                                                }
                                            }

                                            // Fallback: if no valid slots from operational_hours, use default 09:00-19:00
                                            if (empty($timeSlots)) {
                                                $fallbackStart = new \DateTime('09:00');
                                                $fallbackEnd = new \DateTime('19:00');
                                                while ($fallbackStart < $fallbackEnd) {
                                                    $timeSlots[] = $fallbackStart->format('H:i');
                                                    $fallbackStart->modify('+30 minutes');
                                                }
                                            }

                                            $selectedTime = $timeSlots[0] ?? null;
                                        @endphp
                                        <select class="form-control" id="bk_time">
                                            <option value="">Select time</option>
                                            @foreach ($timeSlots as $time)
                                                <option value="{{ $time }}" {{ $time == $selectedTime ? 'selected' : '' }}>
                                                    {{ $time }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Features Selection for the active service -->
                            <div class="services-section">
                                <h6 class="fw-bold mb-2 text-danger">Select Features for This Service</h6>
                                <div class="g-1">
                                    @php
                                        $features = $features ?? [];
                                    @endphp

                                    @foreach ($features as $idx => $feature)
                                        @php
                                            $hasPriceRange = (!empty($feature['min_price']) && $feature['min_price'] > 0) || (!empty($feature['max_price']) && $feature['max_price'] > 0);
                                        @endphp

                                            <div
                                                class="form-check p-2 border rounded {{ !$hasPriceRange ? 'bg-light' : '' }}">
                                                <input class="form-check-input service-checkbox" type="checkbox"
                                                    name="feature_names[]" value="{{ $feature['name'] }}"
                                                    data-price="{{ $feature['min_price'] ?? $feature['max_price'] ?? $feature['extra_price'] ?? 0 }}"
                                                    data-service-id="{{ $activeService->id ?? null }}"
                                                    id="feature{{ $idx }}"
                                                    @if (!$hasPriceRange)
                                                        checked disabled
                                                    @endif>
                                                <label class="form-check-label d-flex justify-content-between w-100 {{ !$hasPriceRange ? 'text-muted' : '' }}"
                                                    for="feature{{ $idx }}">
                                                    <span class="fw-semibold small">
                                                        {{ $feature['name'] }}
                                                    </span>
                                                    @if ($hasPriceRange)
                                                        <span class="text-success small">
                                                            @if (!empty($feature['min_price']) && !empty($feature['max_price']))
                                                                Rp {{ number_format($feature['min_price'], 0, ',', '.') }} - {{ number_format($feature['max_price'], 0, ',', '.') }}
                                                            @elseif (!empty($feature['min_price']))
                                                                Mulai Rp {{ number_format($feature['min_price'], 0, ',', '.') }}
                                                            @elseif (!empty($feature['max_price']))
                                                                Hingga Rp {{ number_format($feature['max_price'], 0, ',', '.') }}
                                                            @endif
                                                        </span>
                                                    @else
                                                        <span class="text-muted small">Included</span>
                                                    @endif
                                                </label>
                                            </div>

                                    @endforeach
                                </div>
                            </div>


                            <!-- Booking Form -->
                            <form id="bookingForm" method="POST" action="{{ route('mua.book', $mua['id']) }}">
                                @csrf

                                <!-- Contact fields (prefilled if authenticated) -->
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <label class="form-label small">Your name</label>
                                        <input type="text" name="name" id="bk_name" class="form-control"
                                            value="{{ optional(auth()->user())->name ?? '' }}" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label small">WhatsApp</label>
                                        <input type="text" name="whatsapp" id="bk_whatsapp" class="form-control"
                                        value="{{ optional(auth()->user())->phone ?? '' }}" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small">Email</label>
                                        <input type="email" name="email" id="bk_email" class="form-control"
                                            value="{{ optional(auth()->user())->email ?? '' }}" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small">Address</label>
                                        <input type="text" name="address" id="bk_address" class="form-control" required>
                                        @if (!empty($mua['max_distance']) && !empty($mua['additional_charge']))
                                            <small class="text-muted d-block mt-1">
                                                Locations beyond {{ $mua['max_distance'] }} km from the MUA may incur an
                                                additional charge of Rp {{ number_format($mua['additional_charge'], 0, ',', '.') }}
                                                per km.
                                            </small>
                                        @endif
                                    </div>
                                </div>

                                <!-- Distance Check Section -->
                                @if (!empty($mua['link_map']))
                                <div class="row mb-2">
                                    <div class="col-md-4">
                                        <a href="{{ $mua['link_map'] }}" target="_blank" class="btn btn-primary w-100">
                                            <i class="fas fa-route me-1"></i> Check
                                        </a>
                                    </div>
                                    <div class="col-md-8">
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            Click "Check" to calculate distance from MUA location
                                        </small>
                                    </div>
                                </div>
                                @endif

                                <div class="row g-2 mb-2">
                                    <div class="col-12">
                                        <label class="form-label small">Estimated Distance (km)</label>
                                        <input type="number" min="0" class="form-control" id="bk_distance_input"
                                            placeholder="e.g. 5" inputmode="decimal">
                                    </div>
                                </div>

                                <!-- Hidden inputs populated by JS -->
                                <input type="hidden" name="distance" id="bk_distance">
                                <input type="hidden" name="services" id="bk_services">
                                <input type="hidden" name="mua_service_id" id="bk_mua_service_id">

                                <!-- Estimated Price -->
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <div class="fw-semibold small">Estimated Price</div>
                                        <div class="small text-muted">Final price confirmed after MUA approval</div>
                                    </div>
                                    <h5 id="estimatedPriceDisplay" class="text-primary mb-0">
                                        Rp 0
                                    </h5>
                                </div>

                                <button type="button" id="bookNowBtn" class="btn w-100 fw-bold"
                                    style="background: linear-gradient(135deg, #845d70 0%, #6d4c5a 100%); color: white; border: none; border-radius: 20px; padding: 12px;">
                                    <i class="fas fa-calendar-check me-2"></i>Send Request
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Gallery Modal -->
    <div class="modal fade" id="portfolioModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen modal-dialog-centered">
            <div class="modal-content bg-dark">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-white" id="modalTitle">Portfolio Gallery</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <!-- Carousel -->
                    <div id="portfolioCarousel" class="carousel slide h-100" data-bs-ride="carousel">
                        <!-- Carousel Indicators -->
                        <div class="carousel-indicators position-absolute top-0" style="bottom: auto; margin-top: 1rem;">
                            @if (isset($portfolio) && !empty($portfolio))
                                @foreach ($portfolio as $index => $item)
                                    <button type="button" data-bs-target="#portfolioCarousel" data-bs-slide-to="{{ $index }}"
                                            class="{{ $index == 0 ? 'active' : '' }}"></button>
                                @endforeach
                            @endif
                        </div>

                        <!-- Carousel Inner -->
                        <div class="carousel-inner h-100">
                            @if (isset($portfolio) && !empty($portfolio))
                                @foreach ($portfolio as $index => $item)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <div class="d-flex justify-content-center align-items-center h-100">
                                            <img src="{{ $item['image'] }}" class="img-fluid" alt="Portfolio {{ $index + 1 }}"
                                                 style="max-height: 90vh; max-width: 100%; object-fit: contain;"
                                                 onerror="this.src='{{ asset('images/product-item1.jpg') }}'; console.log('Image failed to load:', '{{ $item['image'] }}');">
                                        </div>
                                        <div class="carousel-caption d-none d-md-block">
                                            <h5>{{ $item['service_name'] ?? 'Portfolio ' . ($index + 1) }}</h5>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="carousel-item active">
                                    <div class="d-flex justify-content-center align-items-center h-100">
                                        <div class="text-center text-white">
                                            <i class="fas fa-camera fa-4x mb-3"></i>
                                            <h4>No Portfolio Available</h4>
                                            <p>Portfolio images will be available soon</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Carousel Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#portfolioCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#portfolioCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .flatpickr-calendar {
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .flatpickr-months .flatpickr-month {
            background: linear-gradient(135deg, var(--bs-primary) 0%, #ffe9f2 100%);
            color: #ffffff;
        }

        .flatpickr-weekday {
            color: var(--bs-primary);
            font-weight: 600;
        }

        .flatpickr-day.selected,
        .flatpickr-day.startRange,
        .flatpickr-day.endRange,
        .flatpickr-day.selected.inRange,
        .flatpickr-day.startRange.inRange,
        .flatpickr-day.endRange.inRange,
        .flatpickr-day.selected:focus,
        .flatpickr-day.startRange:focus,
        .flatpickr-day.endRange:focus,
        .flatpickr-day.selected:hover,
        .flatpickr-day.startRange:hover,
        .flatpickr-day.endRange:hover {
            background: var(--bs-primary);
            border-color: var(--bs-primary);
            color: #ffffff;
        }

        .flatpickr-day.today {
            border-color: var(--bs-primary);
            color: var(--bs-primary);
        }

        .flatpickr-day.booked-date {
            background-color: #f8d7da !important;
            color: #721c24 !important;
            border-color: #f5c6cb !important;
            cursor: not-allowed !important;
            opacity: 0.7;
        }

        .flatpickr-day.booked-date:hover {
            background-color: #f8d7da !important;
            color: #721c24 !important;
        }

        .flatpickr-day.past-date {
            background-color: #e9ecef !important;
            color: #6c757d !important;
            border-color: #dee2e6 !important;
            cursor: not-allowed !important;
            opacity: 0.5;
        }

        .flatpickr-day.past-date:hover {
            background-color: #e9ecef !important;
            color: #6c757d !important;
        }

        .flatpickr-day.today-date {
            background-color: #e7f3ff !important;
            color: #0066cc !important;
            border-color: #0066cc !important;
            font-weight: bold;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $(document).ready(function() {
            var maxDistance = {{ $mua['max_distance'] ?? 'null' }};
            var additionalPerKm = {{ $mua['additional_charge'] ?? 'null' }};
            var basePrice = {{ $mua['price'] ?? 0 }};
            window.activeServiceId = {{ $activeService->id ?? 'null' }};
            function formatRupiah(num) {
                num = num || 0;
                return 'Rp ' + num.toLocaleString('id-ID');
            }

            // Portfolio Gallery Modal - Initialize after DOM is ready
            setTimeout(function() {
                const portfolioModal = document.getElementById('portfolioModal');
                const portfolioCarousel = document.getElementById('portfolioCarousel');

                // Debug: Check portfolio data
                const portfolioData = @json($portfolio ?? []);
                console.log('Portfolio data from server:', portfolioData);
                console.log('Portfolio data length:', portfolioData.length);

                if (portfolioModal && portfolioCarousel) {
                    console.log('Portfolio modal and carousel found');

                    // Remove existing event listeners to prevent duplicates
                    const newModal = portfolioModal.cloneNode(true);
                    portfolioModal.parentNode.replaceChild(newModal, portfolioModal);

                    // Initialize carousel first
                    const carousel = new bootstrap.Carousel(portfolioCarousel, {
                        interval: false, // Don't auto-slide
                        keyboard: true,  // Allow keyboard navigation
                        ride: false
                    });

                    // When portfolio item is clicked, set the carousel to the correct image
                    newModal.addEventListener('show.bs.modal', function(event) {
                        console.log('Modal is being shown');
                        const button = event.relatedTarget;
                        const imageIndex = parseInt(button.getAttribute('data-image-index'));

                        console.log('Image index:', imageIndex);

                        // Update modal title with service name
                        const modalTitle = document.getElementById('modalTitle');
                        if (modalTitle) {
                            const serviceName = button.querySelector('.badge')?.textContent || 'Portfolio Gallery';
                            modalTitle.textContent = serviceName;
                        }

                        // Go to the specific slide
                        setTimeout(function() {
                            carousel.to(imageIndex);
                        }, 100);
                    });

                    // Keyboard navigation
                    document.addEventListener('keydown', function(e) {
                        if (newModal.classList.contains('show')) {
                            if (e.key === 'ArrowLeft') {
                                carousel.prev();
                            } else if (e.key === 'ArrowRight') {
                                carousel.next();
                            } else if (e.key === 'Escape') {
                                bootstrap.Modal.getInstance(newModal).hide();
                            }
                        }
                    });

                    // Touch/swipe support for mobile
                    let touchStartX = 0;
                    let touchEndX = 0;

                    portfolioCarousel.addEventListener('touchstart', function(e) {
                        touchStartX = e.changedTouches[0].screenX;
                    });

                    portfolioCarousel.addEventListener('touchend', function(e) {
                        touchEndX = e.changedTouches[0].screenX;
                        handleSwipe();
                    });

                    function handleSwipe() {
                        if (touchEndX < touchStartX - 50) {
                            carousel.next(); // Swipe left - next image
                        }
                        if (touchEndX > touchStartX + 50) {
                            carousel.prev(); // Swipe right - previous image
                        }
                    }
                } else {
                    console.log('Portfolio modal or carousel not found');
                }
            }, 500); // Delay to ensure DOM is ready

            // jQuery fallback for portfolio click - with event cleanup
            $('.portfolio-item').off('click').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const imageIndex = $(this).data('image-index');
                const serviceName = $(this).find('.badge').text() || 'Portfolio Gallery';

                console.log('jQuery click handler - Image index:', imageIndex);

                // Update modal title
                $('#modalTitle').text(serviceName);

                // Show modal
                $('#portfolioModal').modal('show');

                // Go to specific slide after modal is shown - remove previous handler first
                $('#portfolioModal').off('shown.bs.modal').on('shown.bs.modal', function() {
                    const carousel = bootstrap.Carousel.getInstance(document.getElementById('portfolioCarousel'));
                    if (carousel) {
                        carousel.to(imageIndex);
                    }
                    // Remove this handler after execution
                    $(this).off('shown.bs.modal');
                });
            });

            // Handle feature checkbox changes for visual feedback
            $('.service-checkbox').on('change', function() {
                const $formCheck = $(this).closest('.form-check');

                if ($(this).is(':checked')) {
                    // Add checked class for fallback
                    $formCheck.addClass('checked');
                } else {
                    // Remove checked class
                    $formCheck.removeClass('checked');
                }
            });

            // Initialize checkbox states on page load
            $('.service-checkbox').each(function() {
                const $formCheck = $(this).closest('.form-check');
                if ($(this).is(':checked')) {
                    $formCheck.addClass('checked');
                }
            });

            // initialize datepicker for booking date
            if (typeof flatpickr !== 'undefined') {
                // Prepare array of booked dates
                var bookedDates = [];
                @if (isset($existingBookings) && $existingBookings->count() > 0)
                    @foreach ($existingBookings as $booking)
                        bookedDates.push('{{ $booking->selected_date->format('Y-m-d') }}');
                    @endforeach
                @endif

                // Find first available date (today or next available)
                function findFirstAvailableDate() {
                    var today = new Date();
                    var currentDate = new Date(today);

                    // Check up to 30 days ahead
                    for (var i = 0; i < 30; i++) {
                        var dateStr = currentDate.getFullYear() + '-' +
                            String(currentDate.getMonth() + 1).padStart(2, '0') + '-' +
                            String(currentDate.getDate()).padStart(2, '0');

                        if (!bookedDates.includes(dateStr)) {
                            return currentDate;
                        }
                        currentDate.setDate(currentDate.getDate() + 1);
                    }
                    return today; // fallback to today if no available date found
                }

                var firstAvailableDate = findFirstAvailableDate();

                flatpickr('#bk_date', {
                    minDate: 'today',
                    maxDate: new Date().fp_incr(30), // Limit to 30 days ahead
                    dateFormat: 'Y-m-d',
                    defaultDate: firstAvailableDate,
                    locale: {
                        firstDayOfWeek: 1,
                        weekdays: {
                            shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                            longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
                        },
                        months: {
                            shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                            longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
                        }
                    },
                    onChange: function(selectedDates, dateStr, instance) {
                        // Update time slots dynamically when date changes
                        updateTimeSlots(dateStr);
                    },
                    onReady: function(selectedDates, dateStr, instance) {
                        // Initialize time slots for the default selected date
                        if (selectedDates.length > 0) {
                            var initialDate = instance.formatDate(selectedDates[0], 'Y-m-d');
                            updateTimeSlots(initialDate);
                        }
                    }
                });
            }

            function updateTimeSlots(selectedDate) {
                if (!selectedDate) return;

                // Get existing bookings for selected date
                var blockedTimes = [];
                @if (isset($existingBookings) && $existingBookings->count() > 0)
                    @foreach ($existingBookings as $booking)
                        if ('{{ $booking->selected_date->format('Y-m-d') }}' === selectedDate) {
                            var bookingTime = '{{ $booking->selected_time }}';
                            // Parse booking time (HH:MM format) - this is COMPLETION time
                            var bookingDateTime = new Date('2000-01-01T' + bookingTime + ':00');

                            // Block 1.5 hours BEFORE completion time (90 minutes = 3 slots of 30 minutes each)
                            // If completion time is 06:00, block: 04:30, 05:00, 05:30, and 06:00
                            for (var i = 3; i >= 0; i--) {
                                var blockedTime = new Date(bookingDateTime);
                                blockedTime.setMinutes(blockedTime.getMinutes() - (i * 30));

                                var blockedTimeStr = blockedTime.getHours().toString().padStart(2, '0') + ':' +
                                                     blockedTime.getMinutes().toString().padStart(2, '0');

                                if (!blockedTimes.includes(blockedTimeStr)) {
                                    blockedTimes.push(blockedTimeStr);
                                }
                            }
                        }
                    @endforeach
                @endif

                // Get all time slots from the select element
                var timeSlots = [];
                $('#bk_time option').each(function() {
                    var value = $(this).val();
                    if (value) {
                        timeSlots.push(value);
                    }
                });

                // Update time select
                var html = '<option value="">Select time</option>';
                if (timeSlots.length === 0) {
                    html = '<option value="" disabled>Tidak ada jadwal tersedia</option>';
                } else {
                    timeSlots.forEach(function(time) {
                        var isBlocked = blockedTimes.includes(time);
                        var displayTime = time + (isBlocked ? ' (Tidak tersedia)' : '');
                        html += '<option value="' + time + '" ' +
                               (isBlocked ? 'disabled style="background-color: #f8d7da; color: #721c24;"' : '') + '>' +
                               displayTime + '</option>';
                    });
                }

                $('#bk_time').html(html);
            }

            function updateEstimatedPrice() {
                var totalServices = basePrice || 0;

                // add extra price from selected features
                $('.service-checkbox:checked').each(function() {
                    var extraPrice = parseInt($(this).data('price')) || 0;
                    totalServices += extraPrice;
                });

                var distance = parseFloat($('#bk_distance').val()) || 0;
                var extra = 0;
                if (maxDistance && additionalPerKm && distance > maxDistance) {
                    extra = (distance - maxDistance) * additionalPerKm;
                }

                var total = totalServices + extra;
                $('#estimatedPriceDisplay').text(formatRupiah(total));
            }

            // init estimated price on load
            updateEstimatedPrice();

            // recalc when services change
            $(document).on('change', '.service-checkbox:not(:disabled)', function() {
                updateEstimatedPrice();
            });

            // sync distance input and recalc
            $('#bk_distance_input').on('input', function() {
                var val = $(this).val();
                $('#bk_distance').val(val);
                updateEstimatedPrice();
            });

            // Check distance button click handler
            $('#check_distance_btn').on('click', function() {
                calculateDistance();
            });

            // Book Now handler - collects selected date/time/services and submits to server
            $('#bookNowBtn').on('click', function(e) {
                e.preventDefault(); // Prevent form submission and page refresh

                // selected date from date input
                var selectedDate = $('#bk_date').val();
                if (!selectedDate) {
                    alert('Please select a date first');
                    return;
                }

                // Convert date to YYYY-MM-DD format if needed
                var dateObj = new Date(selectedDate);
                var formattedDate = dateObj.toISOString().split('T')[0];
                console.log('Original date:', selectedDate, 'Formatted date:', formattedDate);

                // selected time from select
                var selectedTime = $('#bk_time').val();
                if (!selectedTime) {
                    alert('Please select a time slot');
                    return;
                }

                console.log('Selected time:', selectedTime);

                // services (collect ids)
                var services = [];
                var serviceIds = [];
                $('.service-checkbox:checked').each(function() {
                    var val = $(this).val();
                    var dataId = $(this).data('service-id');
                    if (val !== undefined && val !== null) {
                        services.push(val);
                        if (dataId) {
                            serviceIds.push(parseInt(dataId));
                        }
                    }
                });

                // Fallback: use activeService from window if available
                if (serviceIds.length === 0 && window.activeServiceId) {
                    serviceIds.push(parseInt(window.activeServiceId));
                }

                // set selected mua_service_id as first selected service ID (if any)
                var muaServiceId = serviceIds.length ? serviceIds[0] : null;
                $('#bk_mua_service_id').val(muaServiceId);
                $('#bk_services').val(JSON.stringify(services));

                console.log('Services names:', services);
                console.log('Service IDs:', serviceIds);
                console.log('Selected service ID:', muaServiceId);

                // contact
                var name = $('#bk_name').val();
                var email = $('#bk_email').val();
                var whatsapp = $('#bk_whatsapp').val();
                var address = $('#bk_address').val();
                if (!name || !email || !whatsapp || !address) {
                    alert('Please complete your contact information');
                    return;
                }

                // Debug: Log data sebelum dikirim
                console.log('Sending data:', {
                    selected_date: formattedDate,
                    selected_time: selectedTime,
                    services: services,
                    mua_service_id: muaServiceId,
                    name: name,
                    email: email,
                    whatsapp: whatsapp,
                    address: address
                });

                var url = $('#bookingForm').attr('action');
                console.log('Form action URL:', url);

                // Check if all required data is present
                if (!formattedDate || !selectedTime || !name || !email || !whatsapp || !address) {
                    console.error('Missing required data:', {
                        selected_date: !!formattedDate,
                        selected_time: !!selectedTime,
                        name: !!name,
                        email: !!email,
                        whatsapp: !!whatsapp,
                        address: !!address
                    });
                    alert('Please fill all required fields');
                    return;
                }

                // Disable book now button to prevent double clicks
                $('#bookNowBtn').prop('disabled', true);
                $('#bookNowBtn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        name: name,
                        email: email,
                        whatsapp: whatsapp,
                        address: address,
                        distance: $('#bk_distance').val() || null,
                        selected_date: formattedDate,
                        selected_time: selectedTime,
                        services: services,
                        mua_service_id: $('#bk_mua_service_id').val() || null
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            var html = '<div class="alert alert-success">' + res.message +
                                '<br>Booking ID: <strong>' + res.booking_id + '</strong></div>';
                            // prepend message and reset selections (only enabled checkboxes)
                            $('#bookNowBtn').after(html);
                            $('.service-checkbox:not(:disabled)').prop('checked', false);
                            $('#bk_date').val('');
                            $('#bk_time').val('');
                            $('#bk_services, #bk_mua_service_id').val('');
                            // reset form fields except prefilled auth info
                            $('#bk_address').val('');
                            setTimeout(function() {
                                $('.alert.alert-success').remove();
                            }, 5000);
                            // Re-enable book now button
                            $('#bookNowBtn').prop('disabled', false);
                            $('#bookNowBtn').html('<i class="fas fa-calendar-check me-2"></i>Send Request');
                        } else {
                            alert(res.message || 'Booking failed');
                            // Re-enable book now button
                            $('#bookNowBtn').prop('disabled', false);
                            $('#bookNowBtn').html('<i class="fas fa-calendar-check me-2"></i>Send Request');
                        }
                    },
                    error: function(xhr) {
                        console.log('XHR Status:', xhr.status);
                        console.log('XHR Response Text:', xhr.responseText);
                        console.log('XHR Response JSON:', xhr.responseJSON);
                        console.log('XHR Headers:', xhr.getAllResponseHeaders());

                        var msg = 'Booking failed.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var err = xhr.responseJSON.errors;
                            var errorList = Object.values(err).map(function(v) {
                                return v.join(', ');
                            }).join('\n');
                            msg += '\n\nValidation Errors:\n' + errorList;
                        }
                        if (xhr.status === 422) {
                            msg = 'Validation Error: ' + msg;
                        } else if (xhr.status === 500) {
                            msg = 'Server Error: ' + msg;
                            console.log('Full error response:', xhr);
                        } else if (xhr.status === 404) {
                            msg = 'Route not found. Please check the URL.';
                        } else if (xhr.status === 403) {
                            msg = 'Access forbidden. CSRF token may be invalid.';
                        }

                        console.log('Final error message:', msg);
                        alert(msg);
                    }
                });
            });
        });
    </script>
@endpush
