@extends('front.app')

@section('title', ($mua['name'] ?? 'MUA Profile') . ' - ' . ($siteSetting->site_name ?? 'GlowHub'))
@section('meta-description', ($mua['description'] ?? 'Professional makeup artist services') . ' - ' . ($siteSetting->site_tagline ?? ''))

@section('content')
<style>
/* === MODERN ELEGANT STYLING === */
.hero-gradient {
    background: linear-gradient(135deg, #ff6b9d 0%, #feca57 100%);
    position: relative;
    overflow: hidden;
}

.hero-pattern {
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.floating-shapes {
    position: absolute;
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.shape {
    position: absolute;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    animation: float 8s ease-in-out infinite;
}

.shape-1 {
    width: 120px;
    height: 120px;
    top: 10%;
    left: 5%;
    animation-delay: 0s;
}

.shape-2 {
    width: 80px;
    height: 80px;
    top: 20%;
    right: 10%;
    animation-delay: 2s;
}

.shape-3 {
    width: 60px;
    height: 60px;
    bottom: 20%;
    left: 15%;
    animation-delay: 4s;
}

.shape-4 {
    width: 100px;
    height: 100px;
    bottom: 10%;
    right: 5%;
    animation-delay: 6s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

.mua-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 4px solid rgba(255, 255, 255, 0.9);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    object-fit: cover;
}

.mua-name {
    font-size: 2.5rem;
    font-weight: 700;
    color: white;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.mua-title {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 300;
}

.stat-card {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 15px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
}

.stat-card:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-5px);
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: white;
    display: block;
}

.stat-label {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.8);
    text-transform: uppercase;
    letter-spacing: 1px;
}

.booking-card {
    border-radius: 20px;
    border: none;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.booking-header {
    background: linear-gradient(135deg, #ff6b9d 0%, #feca57 100%);
    color: white;
    padding: 2rem;
    text-align: center;
}

.form-control, .form-select {
    border-radius: 10px;
    border: 2px solid #e5e7eb;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #ff6b9d;
    box-shadow: 0 0 0 0.2rem rgba(255, 107, 157, 0.25);
}

.portfolio-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.portfolio-item {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s ease;
}

.portfolio-item:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

.portfolio-item img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.portfolio-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
    background: rgba(255, 107, 157, 0.9);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-size: 0.8rem;
    font-weight: 600;
}

.service-card {
    border: 2px solid #f3f4f6;
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.service-card:hover {
    border-color: #ff6b9d;
    background: #fff5f8;
}

.service-card.active {
    border-color: #ff6b9d;
    background: linear-gradient(135deg, rgba(255, 107, 157, 0.1) 0%, rgba(254, 202, 87, 0.1) 100%);
}

.btn-gradient {
    background: linear-gradient(135deg, #ff6b9d 0%, #feca57 100%);
    color: white;
    border: none;
    border-radius: 25px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-gradient:hover {
    background: linear-gradient(135deg, #ff5a8c 0%, #feb947 100%);
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(255, 107, 157, 0.3);
}

.info-section {
    background: #f8f9ff;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
}

.info-title {
    color: #ff6b9d;
    font-weight: 700;
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.breadcrumb-modern {
    background: none;
    padding: 1rem 0;
}

.breadcrumb-modern .breadcrumb-item {
    color: rgba(255, 255, 255, 0.8);
}

.breadcrumb-modern .breadcrumb-item.active {
    color: white;
}

.breadcrumb-modern .breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: rgba(255, 255, 255, 0.6);
}

.sticky-top {
    position: sticky;
    top: 20px;
}

.profile-card {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.profile-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.profile-image-container {
    position: relative;
    height: 300px;
    overflow: hidden;
}

.profile-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.location-badge {
    position: absolute;
    bottom: 1rem;
    left: 1rem;
    background: rgba(255, 255, 255, 0.95);
    color: #ff6b9d;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-weight: 600;
}

.rating-stars {
    color: #feca57;
}

.feature-badge {
    background: linear-gradient(135deg, #ff6b9d 0%, #feca57 100%);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
}

.day-btn, .time-slot {
    border-radius: 10px;
    border: 2px solid #e5e7eb;
    background: white;
    color: #333;
    font-weight: 500;
    transition: all 0.3s ease;
}

.day-btn:hover:not(.btn-primary), .time-slot:hover:not(:disabled):not(.btn-primary) {
    border-color: #ff6b9d;
    background: #fff5f8;
    color: #ff6b9d;
}

.day-btn.btn-primary, .time-slot.btn-primary {
    background: linear-gradient(135deg, #ff6b9d 0%, #feca57 100%);
    border-color: #ff6b9d;
}

.time-slot:disabled {
    background: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}
</style>

<!-- Hero Section -->
<div class="hero-gradient hero-pattern">
    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="shape shape-4"></div>
    </div>

    <div class="container py-5">
        <nav aria-label="breadcrumb" class="breadcrumb-modern">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('mua.listing') }}" class="text-white text-decoration-none">MUA Directory</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $mua['name'] ?? 'MUA Profile' }}</li>
            </ol>
        </nav>

        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center mb-4">
                    <img src="{{ $mua['image'] ?? asset('images/default-avatar.png') }}" alt="{{ $mua['name'] }}" class="mua-avatar me-4">
                    <div>
                        <h1 class="mua-name mb-2">{{ $mua['name'] ?? 'Professional MUA' }}</h1>
                        <p class="mua-title mb-3">{{ $mua['mua_name'] ?? 'Professional Makeup Artist' }}</p>

                        <div class="d-flex flex-wrap gap-3 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-map-marker-alt me-2 text-white"></i>
                                <span class="text-white">{{ $mua['location'] ?? 'Location Available' }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-star me-2 text-warning"></i>
                                <span class="text-white">{{ $mua['rating'] ?? '4.8' }}/5 ({{ $mua['reviews'] ?? '150' }} reviews)</span>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            @if (!empty($mua['specialties']))
                                @foreach (explode(',', $mua['specialties']) as $specialty)
                                    <span class="badge bg-white bg-opacity-20 text-white px-3 py-2 rounded-pill">
                                        {{ trim($specialty) }}
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="stat-card">
                            <span class="stat-number">{{ $mua['experience'] ?? '5+' }}</span>
                            <span class="stat-label">Years Experience</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-card">
                            <span class="stat-number">{{ $mua['clients'] ?? '500+' }}</span>
                            <span class="stat-label">Happy Clients</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-card">
                            <span class="stat-number">{{ $mua['portfolio_count'] ?? '50+' }}</span>
                            <span class="stat-label">Portfolio</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-card">
                            <span class="stat-number">Rp{{ number_format($mua['price'] ?? '500000', 0, ',', '.') }}</span>
                            <span class="stat-label">Starting From</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <div class="row">
        <!-- Left Column - MUA Info & Portfolio -->
        <div class="col-lg-8">
            <!-- Profile Card -->
            <div class="profile-card mb-4">
                <div class="profile-image-container">
                    <img src="{{ $mua['image'] ?? asset('images/default-avatar.png') }}" alt="{{ $mua['name'] }}">
                    <div class="location-badge">
                        <i class="fas fa-map-marker-alt me-2"></i>{{ $mua['location'] ?? 'Location Available' }}
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h3 class="card-title mb-2">{{ $mua['name'] ?? 'Professional MUA' }}</h3>
                        <p class="text-muted">{{ $mua['description'] ?? 'Professional makeup artist with years of experience in bridal, commercial, and special events makeup. Passionate about enhancing natural beauty and creating stunning looks that make every client feel confident and beautiful.' }}</p>

                        <div class="rating-stars mb-3">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= floor($mua['rating'] ?? 4.5))
                                    <i class="fas fa-star"></i>
                                @elseif ($i <= ($mua['rating'] ?? 4.5))
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                            <span class="ms-2 text-muted">({{ $mua['reviews'] ?? '150' }} reviews)</span>
                        </div>

                        <div class="d-flex justify-content-center gap-3 mb-3">
                            <div class="text-center">
                                <h5 class="text-primary mb-0">Rp{{ number_format($mua['price'] ?? 500000, 0, ',', '.') }}</h5>
                                <small class="text-muted">Starting Price</small>
                            </div>
                            <div class="text-center">
                                <h5 class="text-primary mb-0">{{ $mua['operational_hours'] ?? '09:00-19:00' }}</h5>
                                <small class="text-muted">Working Hours</small>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap justify-content-center gap-2">
                            @if (!empty($mua['specialties']))
                                @foreach (explode(',', $mua['specialties']) as $specialty)
                                    <span class="feature-badge">{{ trim($specialty) }}</span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Services Section -->
            <div class="info-section">
                <h3 class="info-title">
                    <i class="fas fa-palette me-2"></i>Services & Pricing
                </h3>

                <div class="row g-3">
                    @if (isset($activeService) && $activeService)
                        <div class="col-12">
                            <div class="service-card active">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h5 class="mb-1 fw-bold text-primary">{{ $activeService->service_name }}</h5>
                                        <p class="mb-0 text-muted small">{{ $activeService->description ?? 'Professional makeup service' }}</p>
                                    </div>
                                    <div class="text-end">
                                        <p class="mb-0 h5 text-success fw-bold">Rp{{ number_format($activeService->price, 0, ',', '.') }}</p>
                                        <p class="mb-0 text-muted small">{{ $activeService->duration ?? '2 hours' }}</p>
                                    </div>
                                </div>

                                @if (!empty($activeService->features))
                                    <div class="mt-2">
                                        <small class="text-muted">Includes:</small>
                                        <div class="d-flex flex-wrap gap-1 mt-1">
                                            @if (is_array($activeService->features))
                                                @foreach ($activeService->features as $feature)
                                                    <span class="badge bg-light text-dark">{{ is_array($feature) ? $feature['name'] ?? 'Feature' : $feature }}</span>
                                                @endforeach
                                            @else
                                                <span class="badge bg-light text-dark">{{ $activeService->features }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="col-12">
                            <div class="text-center py-4">
                                <i class="fas fa-paint-brush fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Services information will be available soon.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Portfolio Section -->
            <div class="info-section">
                <h3 class="info-title">
                    <i class="fas fa-images me-2"></i>Portfolio Gallery
                </h3>

                @if (isset($portfolio) && !empty($portfolio) && count($portfolio) > 0)
                    <div class="portfolio-grid">
                        @foreach ($portfolio as $index => $item)
                            <div class="portfolio-item" data-bs-toggle="modal" data-bs-target="#portfolioModal{{ $index }}">
                                <img src="{{ $item['image'] ?? asset('images/portfolio-placeholder.jpg') }}" alt="Portfolio">
                                <div class="portfolio-badge">{{ $item['service_name'] ?? 'Makeup' }}</div>
                            </div>

                            <!-- Portfolio Modal -->
                            <div class="modal fade" id="portfolioModal{{ $index }}" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ $item['service_name'] ?? 'Portfolio' }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="{{ $item['image'] ?? asset('images/portfolio-placeholder.jpg') }}" class="img-fluid rounded" alt="Portfolio">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-camera fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Portfolio will be available soon.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column - Booking Form -->
        <div class="col-lg-4">
            <div class="booking-card sticky-top">
                <div class="booking-header">
                    <h4 class="mb-2">
                        <i class="fas fa-calendar-check me-2"></i>Book Your Session
                    </h4>
                    <p class="mb-0 opacity-75">Choose your preferred date and time</p>
                </div>

                <div class="card-body p-4">
                    <!-- Date & Time Selection -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Select Date</label>
                        <input type="date" class="form-control" id="bk_date">
                        <small class="text-muted d-block mt-1">You can change month and year from the picker.</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Available Times</label>
                        @php
                            $timeSlots = [];
                            $selectedTime = null;

                            // Generate time slots every 30 minutes
                            $op = $mua['operational_hours'] ?? '';
                            if (!empty($op) && preg_match('/(\d{1,2})[:\.](\d{2}).*?(\d{1,2})[:\.](\d{2})/u', $op, $m)) {
                                try {
                                    $start = new \DateTime($m[1] . ':' . $m[2]);
                                    $end = new \DateTime($m[3] . ':' . $m[4]);
                                    while ($start < $end) {
                                        $timeSlots[] = $start->format('H:i');
                                        $start->modify('+30 minutes');
                                    }
                                } catch (\Exception $e) {
                                    $timeSlots = [];
                                }
                            }

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
                        <select class="form-select" id="bk_time">
                            <option value="">Select time</option>
                            @foreach ($timeSlots as $time)
                                <option value="{{ $time }}" {{ $time == $selectedTime ? 'selected' : '' }}>
                                    {{ $time }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-warning d-block mt-2">
                            <i class="fas fa-info-circle me-1"></i>
                            <strong>Note:</strong> Jam yang kamu pilih adalah waktu MUA selesai makeup-mu
                        </small>
                    </div>

                    <!-- Service Selection -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Select Service</label>
                        <div class="service-selection">
                            @if (isset($activeService) && $activeService)
                                <div class="form-check mb-2">
                                    <input class="form-check-input service-checkbox" type="checkbox"
                                           value="{{ $activeService->service_name }}"
                                           data-service-id="{{ $activeService->id }}"
                                           id="service_{{ $activeService->id }}" checked>
                                    <label class="form-check-label" for="service_{{ $activeService->id }}">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-medium">{{ $activeService->service_name }}</span>
                                            <span class="text-primary fw-bold">Rp{{ number_format($activeService->price, 0, ',', '.') }}</span>
                                        </div>
                                        <small class="text-muted">{{ $activeService->duration ?? '2 hours' }}</small>
                                    </label>
                                </div>
                            @else
                                <p class="text-muted">No services available at the moment.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Your Information</label>
                        <div class="row g-3">
                            <div class="col-12">
                                <input type="text" class="form-control" id="bk_name" placeholder="Your Name">
                            </div>
                            <div class="col-12">
                                <input type="email" class="form-control" id="bk_email" placeholder="Your Email">
                            </div>
                            <div class="col-12">
                                <input type="tel" class="form-control" id="bk_whatsapp" placeholder="WhatsApp Number">
                            </div>
                            <div class="col-12">
                                <textarea class="form-control" id="bk_address" rows="2" placeholder="Your Address"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="button" class="btn btn-gradient w-100" onclick="submitBooking()">
                        <i class="fas fa-check-circle me-2"></i>Complete Booking
                    </button>

                    <div class="text-center mt-3">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt me-1"></i>
                            Your information is secure and will not be shared
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Form for Submission -->
<form id="bookingForm" action="{{ route('mua.book', $mua['id'] ?? '') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="mua_id" value="{{ $mua['id'] ?? '' }}">
    <input type="hidden" name="selected_date" id="form_selected_date">
    <input type="hidden" name="selected_time" id="form_selected_time">
    <input type="hidden" name="services" id="form_services">
    <input type="hidden" name="mua_service_id" id="form_mua_service_id">
    <input type="hidden" name="name" id="form_name">
    <input type="hidden" name="email" id="form_email">
    <input type="hidden" name="whatsapp" id="form_whatsapp">
    <input type="hidden" name="address" id="form_address">
</form>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Store active service ID globally - handle null case
    @if(isset($activeService) && $activeService)
        window.activeServiceId = {{ $activeService->id }};
    @else
        window.activeServiceId = null;
    @endif

    // Initialize date picker
    if (typeof flatpickr !== "undefined") {
        var bookedDates = [];
        @if(isset($existingBookings) && $existingBookings && !empty($existingBookings))
            @foreach ($existingBookings as $booking)
                bookedDates.push('{{ $booking->selected_date->format('Y-m-d') }}');
            @endforeach
        @endif

        flatpickr("#bk_date", {
            minDate: 'today',
            maxDate: new Date().fp_incr(30),
            dateFormat: 'Y-m-d',
            disable: [
                function(date) {
                    // Disable past dates
                    var today = new Date();
                    today.setHours(0, 0, 0, 0);
                    if (date < today) {
                        return true;
                    }

                    // Check if date is in booked dates array
                    var dateStr = date.getFullYear() + '-' +
                        String(date.getMonth() + 1).padStart(2, '0') + '-' +
                        String(date.getDate()).padStart(2, '0');
                    return bookedDates.includes(dateStr);
                }
            ],
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
                updateTimeSlots(dateStr);
            }
        });
    }

    function updateTimeSlots(selectedDate) {
        if (!selectedDate) return;

        var blockedTimes = [];
        @if(isset($existingBookings) && $existingBookings && !empty($existingBookings))
            @foreach ($existingBookings as $booking)
                if ('{{ $booking->selected_date->format('Y-m-d') }}' === selectedDate) {
                    var bookingTime = '{{ $booking->selected_time }}';
                    var bookingDateTime = new Date('2000-01-01T' + bookingTime + ':00');
                    for (var i = 0; i < 3; i++) {
                        var timeStr = bookingDateTime.getHours().toString().padStart(2, '0') + ':' +
                                     bookingDateTime.getMinutes().toString().padStart(2, '0');
                        if (!blockedTimes.includes(timeStr)) {
                            blockedTimes.push(timeStr);
                        }
                        bookingDateTime.setMinutes(bookingDateTime.getMinutes() + 30);
                    }
                }
            @endforeach
        @endif

        var timeSlots = [];
        $('#bk_time option').each(function() {
            var value = $(this).val();
            if (value) {
                timeSlots.push(value);
            }
        });

        var html = '<option value="">Select time</option>';
        if (timeSlots.length === 0) {
            html = '<option value="" disabled>Tidak ada jadwal tersedia</option>';
        } else {
            timeSlots.forEach(function(time) {
                var isBlocked = blockedTimes.includes(time);
                var displayTime = time + (isBlocked ? ' (Sudah dibooking)' : '');
                html += '<option value="' + time + '" ' +
                       (isBlocked ? 'disabled style="background-color: #f8d7da; color: #721c24;"' : '') + '>' +
                       displayTime + '</option>';
            });
        }

        $('#bk_time').html(html);
    }

    // Service selection interaction
    $('.service-checkbox').on('change', function() {
        $('.service-card').removeClass('active');
        $('.service-checkbox:checked').each(function() {
            $(this).closest('.service-card').addClass('active');
        });
    });

    // Initialize service card as active since checkbox is checked by default
    $('.service-checkbox:checked').each(function() {
        $(this).closest('.service-card').addClass('active');
    });

    // Booking submission
    window.submitBooking = function() {
        var selectedDate = $('#bk_date').val();
        var selectedTime = $('#bk_time').val();
        var services = [];
        var serviceIds = [];
        var muaServiceId = null;

        $('.service-checkbox:checked').each(function() {
            var val = $(this).val();
            var dataId = $(this).data('service-id');
            if (val !== undefined && val !== null) {
                services.push(val);
                if (dataId) {
                    serviceIds.push(parseInt(dataId));
                    muaServiceId = parseInt(dataId); // Use the first (and only) service ID
                }
            }
        });

        // If no service is selected (shouldn't happen with checked default), use active service
        if (serviceIds.length === 0 && window.activeServiceId) {
            muaServiceId = window.activeServiceId;
            services.push(['Default Service']); // Fallback service name
        }

        var name = $('#bk_name').val();
        var email = $('#bk_email').val();
        var whatsapp = $('#bk_whatsapp').val();
        var address = $('#bk_address').val();

        // Validation
        if (!selectedDate || !selectedTime || !muaServiceId || !name || !email || !whatsapp || !address) {
            alert('Please complete all required fields');
            return;
        }

        // Set form values
        $('#form_selected_date').val(selectedDate);
        $('#form_selected_time').val(selectedTime);
        $('#form_services').val(JSON.stringify(services));
        $('#form_mua_service_id').val(muaServiceId);
        $('#form_name').val(name);
        $('#form_email').val(email);
        $('#form_whatsapp').val(whatsapp);
        $('#form_address').val(address);

        // Submit form
        $('#bookingForm').submit();
    };
});
</script>
@endpush
