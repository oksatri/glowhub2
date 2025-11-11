@extends('front._parts.master')
@section('content')
    <!-- Stunning Hero Section -->
    <section class="hero-gradient position-relative overflow-hidden"
        style="min-height: 40vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 80px 0;">
        <!-- Animated Background Elements -->
        <div class="floating-elements">
            <div class="floating-circle circle-1"></div>
            <div class="floating-circle circle-2"></div>
            <div class="floating-circle circle-3"></div>
        </div>

        <div class="container position-relative">
            <!-- Elegant Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb breadcrumb-elegant">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"
                            class="text-white text-decoration-none opacity-75 hover-opacity">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/mua-listing') }}"
                            class="text-white text-decoration-none opacity-75 hover-opacity">Find MUA</a></li>
                    <li class="breadcrumb-item active text-white fw-bold" aria-current="page">{{ $mua['name'] }}</li>
                </ol>
            </nav>

            <!-- Hero Content -->
            <div class="text-center text-white">
                <div class="hero-badge mb-3">
                    <span class="badge badge-glass px-4 py-2">
                        <i class="fas fa-palette me-2"></i>Professional MUA Profile
                    </span>
                </div>
                <h1 class="display-4 fw-bold mb-3 text-glow">{{ $mua['name'] }}</h1>
                <p class="lead mb-4 opacity-90">{{ $mua['speciality'] }} • {{ $mua['location'] }}</p>
                <div class="hero-rating">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star text-warning me-1"></i>
                    @endfor
                    <span class="ms-2 fw-semibold">{{ $mua['rating'] }} ({{ $mua['reviews'] ?? '150' }} reviews)</span>
                </div>
            </div>
        </div>
    </section>

    <!-- MUA Detail Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <!-- Left Column - Profile & Portfolio -->
                <div class="col-lg-6">
                    <div class="profile-section">
                        <!-- Profile Card -->
                        <div class="card shadow-sm border-0 rounded-3 mb-4">
                            <!-- Profile Image -->
                            <div class="position-relative">
                                <img src="{{ $mua['image'] }}" alt="{{ $mua['name'] }}" class="card-img-top rounded-top"
                                    style="height: 300px; object-fit: cover;">
                                <!-- Location Badge -->
                                <div class="position-absolute bottom-0 start-0 m-3">
                                    <span class="badge bg-primary px-3 py-2 rounded-pill">
                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $mua['location'] }}
                                    </span>
                                </div>
                            </div>

                            <!-- Profile Info -->
                            <div class="card-body p-4">
                                <div class="text-center mb-4">
                                    <h3 class="fw-bold text-primary mb-2">{{ $mua['name'] }}</h3>
                                    <p class="text-muted mb-2">{{ $mua['speciality'] }} Specialist</p>
                                    <p class="small text-secondary fst-italic">
                                        "Making you look natural yet glowing for every occasion"
                                    </p>
                                </div>

                                <!-- Rating & Reviews -->
                                <div class="text-center mb-4">
                                    <div class="rating mb-2">
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
                                        <strong>{{ $mua['rating'] }}/5</strong> ({{ $mua['reviews'] ?? '150' }} reviews)
                                    </p>
                                </div>

                                <!-- Services & Price -->
                                <div class="row text-center">
                                    <div class="col-6">
                                        <div class="border-end">
                                            <h6 class="fw-bold text-primary mb-1">Starting From</h6>
                                            <p class="h5 text-success fw-bold mb-0">Rp
                                                {{ number_format($mua['price'], 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <h6 class="fw-bold text-primary mb-1">Experience</h6>
                                        <p class="fw-semibold text-dark mb-0">3+ Years</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="mb-3">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= floor($mua['rating']))
                                    <i class="fas fa-star text-warning" style="font-size: 1.1rem;"></i>
                                @elseif($i <= $mua['rating'])
                                    <i class="fas fa-star-half-alt text-warning" style="font-size: 1.1rem;"></i>
                                @else
                                    <i class="far fa-star text-warning" style="font-size: 1.1rem;"></i>
                                @endif
                            @endfor
                            <span class="ms-2 fw-bold" style="color: #845d70;">{{ $mua['rating'] }}
                                ({{ $mua['reviews_count'] }} reviews)</span>
                        </div>

                        <!-- Price -->
                        <h4 class="fw-bold mb-0" style="color: #845d70;">Rp
                            {{ number_format($mua['price'], 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>

            <!-- Portfolio Gallery -->
            <div class="card h-100 shadow-sm border-0 position-relative">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3" style="color: #3d2a33;">Portfolio Gallery</h5>
                    <div class="row g-2">
                        @foreach ($portfolio as $index => $image)
                            <div class="col-6">
                                @if ($index < 3)
                                    <div class="position-relative portfolio-item">
                                        <img src="{{ $image }}" alt="Portfolio {{ $index + 1 }}"
                                            class="img-fluid"
                                            style="border-radius: 12px; height: 120px; width: 100%; object-fit: cover; cursor: pointer;">
                                        @if ($index == 0)
                                            <div class="position-absolute top-0 start-0 m-2">
                                                <span class="badge bg-primary">Wedding Guest</span>
                                            </div>
                                        @elseif($index == 1)
                                            <div class="position-absolute top-0 start-0 m-2">
                                                <span class="badge bg-success">Graduation</span>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="position-relative portfolio-item">
                                        <img src="{{ $image }}" alt="Portfolio" class="img-fluid"
                                            style="border-radius: 12px; height: 120px; width: 100%; object-fit: cover; cursor: pointer; filter: brightness(0.7);">
                                        <div class="position-absolute top-50 start-50 translate-middle text-center">
                                            <div class="text-white">
                                                <h6 class="fw-bold mb-1">See All</h6>
                                                <p class="mb-0">Portfolio</p>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Right Column - Booking Form -->
        <div class="col-lg-6">
            <!-- Booking Card -->
            <div class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0">
                        <i class="fas fa-calendar-alt me-2"></i>Book Your Session
                    </h4>
                    <p class="mb-0 small opacity-75">Select your preferred date and time</p>
                </div>

                <div class="card-body p-4">
                    <!-- Simple Calendar -->
                    <div class="calendar-section mb-4">
                        <div class="row">
                            <!-- Calendar Grid -->
                            <div class="col-7">
                                <div class="calendar-container p-3 bg-light rounded">
                                    <!-- Calendar Header -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <button class="btn btn-outline-primary btn-sm" type="button">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <h6 class="fw-bold mb-0">October 2025</h6>
                                        <button class="btn btn-outline-primary btn-sm" type="button">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>

                                    <!-- Days of Week -->
                                    <div class="row text-center mb-2">
                                        @foreach (['S', 'M', 'T', 'W', 'T', 'F', 'S'] as $day)
                                            <div class="col p-1">
                                                <small class="text-muted fw-bold">{{ $day }}</small>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Calendar Days -->
                                    @php
                                        $days = [
                                            ['', '', '1', '2', '3', '4', '5'],
                                            ['6', '7', '8', '9', '10', '11', '12'],
                                            ['13', '14', '15', '16', '17', '18', '19'],
                                            ['20', '21', '22', '23', '24', '25', '26'],
                                            ['27', '28', '29', '30', '31', '', ''],
                                        ];
                                        $availableDays = [8, 15, 22, 25];
                                        $selectedDay = 25;
                                    @endphp

                                    @foreach ($days as $week)
                                        <div class="row text-center mb-1">
                                            @foreach ($week as $day)
                                                <div class="col p-1">
                                                    @if ($day)
                                                        @if (in_array((int) $day, $availableDays))
                                                            <button
                                                                class="btn btn-sm w-100 day-btn {{ $day == $selectedDay ? 'btn-primary' : 'btn-outline-secondary' }}"
                                                                style="height: 30px; font-size: 12px;"
                                                                data-day="{{ $day }}">
                                                                {{ $day }}
                                                            </button>
                                                        @else
                                                            <span class="d-block text-muted small"
                                                                style="line-height: 30px; font-size: 11px;">{{ $day }}</span>
                                                        @endif
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Time Slots -->
                            <div class="col-5">
                                <h6 class="fw-bold mb-3 text-primary">Available Times</h6>
                                <div class="time-slots">
                                    @php
                                        $timeSlots = [
                                            ['time' => '09:00', 'available' => true],
                                            ['time' => '11:00', 'available' => true],
                                            ['time' => '13:00', 'available' => false],
                                            ['time' => '15:00', 'available' => true],
                                            ['time' => '17:00', 'available' => false],
                                        ];
                                        $selectedTime = '15:00';
                                    @endphp

                                    @foreach ($timeSlots as $slot)
                                        <button
                                            class="btn btn-sm w-100 mb-2 time-slot {{ $slot['time'] == $selectedTime ? 'btn-primary' : ($slot['available'] ? 'btn-outline-primary' : 'btn-outline-secondary') }}"
                                            {{ !$slot['available'] ? 'disabled' : '' }} data-time="{{ $slot['time'] }}"
                                            style="padding: 8px;">
                                            {{ $slot['time'] }}
                                            @if (!$slot['available'])
                                                <small class="d-block">Booked</small>
                                            @endif
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Calendar -->
                    <div class="calendar-section mb-4">
                        <div class="row">
                            <!-- Calendar Grid -->
                            <div class="col-7">
                                <div class="calendar-grid">
                                    <!-- Calendar Header -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <button class="btn btn-sm btn-outline-secondary" type="button">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <h6 class="fw-bold mb-0">October 2025</h6>
                                        <button class="btn btn-sm btn-outline-secondary" type="button">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>

                                    <!-- Days of Week -->
                                    <div class="row text-center mb-2">
                                        @foreach (['S', 'M', 'T', 'W', 'T', 'F', 'S'] as $day)
                                            <div class="col">
                                                <small class="text-muted fw-bold">{{ $day }}</small>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Calendar Days -->
                                    @php
                                        $days = [
                                            ['', '', '1', '2', '3', '4', '5'],
                                            ['6', '7', '8', '9', '10', '11', '12'],
                                            ['13', '14', '15', '16', '17', '18', '19'],
                                            ['20', '21', '22', '23', '24', '25', '26'],
                                            ['27', '28', '29', '30', '31', '', ''],
                                        ];
                                        $availableDays = [8, 15, 22, 25];
                                        $selectedDay = 8;
                                    @endphp

                                    @foreach ($days as $week)
                                        <div class="row text-center mb-1">
                                            @foreach ($week as $day)
                                                <div class="col">
                                                    @if ($day)
                                                        @if (in_array((int) $day, $availableDays))
                                                            <button
                                                                class="btn btn-sm w-100 day-btn {{ $day == $selectedDay ? 'selected' : '' }}"
                                                                style="height: 32px; {{ $day == $selectedDay ? 'background: #845d70; color: white; border: none;' : 'background: #f8f9fa; color: #333; border: 1px solid #dee2e6;' }}"
                                                                data-day="{{ $day }}">
                                                                {{ $day }}
                                                            </button>
                                                        @else
                                                            <span class="d-block text-muted small"
                                                                style="line-height: 32px;">{{ $day }}</span>
                                                        @endif
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Time Slots -->
                            <div class="col-5">
                                <div class="time-slots">
                                    @php
                                        $timeSlots = [
                                            ['time' => '02:00 - 03:30', 'available' => true],
                                            ['time' => '04:00 - 05:30', 'available' => true],
                                            ['time' => '06:00 - 07:30', 'available' => false],
                                            ['time' => '08:00 - 09:30', 'available' => true],
                                            ['time' => '10:00 - 11:30', 'available' => false],
                                        ];
                                        $selectedTime = '04:00 - 05:30';
                                    @endphp

                                    @foreach ($timeSlots as $slot)
                                        <button
                                            class="btn btn-sm w-100 mb-2 time-slot {{ $slot['time'] == $selectedTime ? 'selected' : '' }}"
                                            style="padding: 8px 12px; {{ $slot['time'] == $selectedTime ? 'background: #845d70; color: white; border: none;' : ($slot['available'] ? 'background: #f8f9fa; color: #333; border: 1px solid #f8bbbd;' : 'background: #e9ecef; color: #6c757d; border: 1px solid #dee2e6;') }}"
                                            {{ !$slot['available'] ? 'disabled' : '' }} data-time="{{ $slot['time'] }}">
                                            {{ $slot['time'] }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Services Selection -->
            <div class="card h-100 shadow-sm border-0 position-relative">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3" style="color: #3d2a33;">Select Services</h6>

                    @php
                        $services = [
                            ['name' => 'Hair do', 'price' => '35.000 - 70.000', 'checked' => false],
                            ['name' => 'Hijab do', 'price' => '35.000', 'checked' => true],
                            ['name' => 'Softlens', 'price' => 'Free', 'checked' => true],
                            ['name' => 'Home Service', 'price' => '10.000/km', 'checked' => true],
                            ['name' => 'Hair do', 'price' => '35.000', 'checked' => false],
                            ['name' => 'Hair do', 'price' => '35.000', 'checked' => false],
                        ];
                    @endphp

                    @foreach ($services as $index => $service)
                        <div class="form-check mb-3">
                            <input class="form-check-input service-checkbox" type="checkbox"
                                id="service{{ $index }}" {{ $service['checked'] ? 'checked' : '' }}
                                style="border: 2px solid #f8bbbd;">
                            <label class="form-check-label w-100" for="service{{ $index }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>{{ $service['name'] }}</span>
                                    <span class="text-muted small">(+ Rp {{ $service['price'] }})</span>
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Location Check -->
            <div class="card h-100 shadow-sm border-0 position-relative">
                <div class="card-body p-4">
                    <p class="mb-3" style="color: #6c757d;">Check distance from location to MUA studio here.
                    </p>
                    <button class="btn w-100"
                        style="background: #845d70; color: white; border-radius: 25px; padding: 10px;">
                        MUA Location
                    </button>
                </div>
            </div>

            <!-- Booking Form -->
            <div class="card h-100 shadow-sm border-0 position-relative">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3" style="color: #3d2a33;">Booking Information</h6>

                    <form id="bookingForm">
                        @csrf
                        <input type="hidden" name="selected_date" id="selectedDate" value="8">
                        <input type="hidden" name="selected_time" id="selectedTime" value="04:00 - 05:30">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Your name..."
                                    required style="border: 1px solid #f8bbbd; border-radius: 8px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Your email..."
                                    required style="border: 1px solid #f8bbbd; border-radius: 8px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">WhatsApp</label>
                                <input type="text" name="whatsapp" class="form-control"
                                    placeholder="Your WhatsApp..." required
                                    style="border: 1px solid #f8bbbd; border-radius: 8px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Address</label>
                                <input type="text" name="address" class="form-control" placeholder="Your address..."
                                    required style="border: 1px solid #f8bbbd; border-radius: 8px;">
                            </div>
                            <div class="col-12">
                                <label class="form-label small">Estimated Distance (km)</label>
                                <input type="number" name="distance" class="form-control" placeholder="Distance..."
                                    step="0.1" style="border: 1px solid #f8bbbd; border-radius: 8px;">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Estimated Price -->
            <div class="card h-100 shadow-sm border-0 position-relative"
                style="border-radius: 20px; background: linear-gradient(135deg, #f8bbbd 0%, rgba(132, 93, 112, 0.1) 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold mb-1" style="color: #3d2a33;">Estimated Price</h6>
                            <small class="text-muted">(final price confirmed after MUA approval)</small>
                        </div>
                        <h4 class="fw-bold mb-0" style="color: #845d70;">Rp 350.000</h4>
                    </div>
                </div>
            </div>

            <!-- Book Now Button -->
            <button type="button" id="bookNowBtn" class="btn w-100 btn-lg fw-bold"
                style="background: linear-gradient(135deg, #845d70 0%, #6d4c5a 100%); color: white; border: none; border-radius: 25px; padding: 15px;">
                <i class="fas fa-calendar-check me-2"></i>Book Now
            </button>
        </div>
        </div>
    </section>
@endsection

@section('scripts')
    <style>
        /* === CLEAN & PROFESSIONAL STYLING === */
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
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
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
        }

        .circle-2 {
            width: 100px;
            height: 100px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .circle-3 {
            width: 60px;
            height: 60px;
            top: 40%;
            left: 70%;
            animation-delay: 4s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .breadcrumb-elegant {
            background: none !important;
            padding: 0;
        }

        .breadcrumb-elegant .breadcrumb-item+.breadcrumb-item::before {
            color: rgba(255, 255, 255, 0.7);
            content: "›";
        }

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

        /* === SIMPLE INTERACTIONS === */
        .day-btn:hover:not(.btn-primary) {
            background-color: var(--bs-primary) !important;
            color: white !important;
        }

        .time-slot:hover:not(:disabled):not(.btn-primary) {
            background-color: var(--bs-primary) !important;
            color: white !important;
        }

        .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Calendar day selection
            $('.day-btn').on('click', function() {
                $('.day-btn').removeClass('btn-primary').addClass('btn-outline-secondary');
                $(this).removeClass('btn-outline-secondary').addClass('btn-primary');
            });

            // Time slot selection
            $('.time-slot').on('click', function() {
                if (!$(this).prop('disabled')) {
                    $('.time-slot:not(:disabled)').removeClass('btn-primary').addClass(
                        'btn-outline-primary');
                    $(this).removeClass('btn-outline-primary').addClass('btn-primary');
                }
            });
        });
    </script>
@endsection
transform: scale(1.1);
}

.image-overlay {
position: absolute;
top: 0;
left: 0;
right: 0;
bottom: 0;
background: linear-gradient(135deg, rgba(102, 126, 234, 0.3) 0%, rgba(118, 75, 162, 0.3) 100%);
}

.floating-badge {
position: absolute;
bottom: 20px;
left: 20px;
animation: bounceIn 1s ease-out 0.5s both;
}

.location-badge {
background: rgba(255, 255, 255, 0.9);
color: #667eea;
padding: 8px 16px;
border-radius: 50px;
font-weight: 600;
font-size: 0.875rem;
backdrop-filter: blur(10px);
box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

@keyframes bounceIn {
0% {
opacity: 0;
transform: scale(0.3);
}

50% {
opacity: 1;
transform: scale(1.1);
}

100% {
opacity: 1;
transform: scale(1);
}
}

.profile-content {
padding: 30px;
position: relative;
}

.profile-avatar-wrapper {
position: relative;
display: inline-block;
margin-bottom: 20px;
}

.profile-avatar {
width: 80px;
height: 80px;
border-radius: 50%;
border: 4px solid #fff;
box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
object-fit: cover;
}

.avatar-status-dot {
position: absolute;
bottom: 8px;
right: 8px;
width: 20px;
height: 20px;
background: #4ade80;
border-radius: 50%;
border: 3px solid white;
animation: pulse 2s infinite;
}

@keyframes pulse {
0% {
transform: scale(1);
}

50% {
transform: scale(1.1);
}

100% {
transform: scale(1);
}
}

.gradient-text {
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
background-clip: text;
font-weight: 700;
}

.profile-name {
font-size: 1.75rem;
margin: 0;
}

.profile-subtitle {
color: #6b7280;
font-weight: 500;
font-size: 1rem;
}

.profile-tagline {
font-style: italic;
color: #9ca3af;
font-size: 0.95rem;
padding: 15px;
background: rgba(102, 126, 234, 0.05);
border-radius: 12px;
border-left: 4px solid #667eea;
}

/* === BOOKING SECTION === */
.booking-card {
min-height: 500px;
}

.booking-header {
padding: 30px 30px 20px;
text-align: center;
border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.booking-title {
font-size: 1.5rem;
margin: 0;
}

.booking-subtitle {
color: #6b7280;
margin: 0;
font-size: 0.95rem;
}

.booking-content {
padding: 30px;
}

/* === ANIMATIONS === */
.profile-wrapper {
animation: slideInLeft 0.8s ease-out;
}

.booking-wrapper {
animation: slideInRight 0.8s ease-out;
}

@keyframes slideInLeft {
from {
opacity: 0;
transform: translateX(-50px);
}

to {
opacity: 1;
transform: translateX(0);
}
}

@keyframes slideInRight {
from {
opacity: 0;
transform: translateX(50px);
}

to {
opacity: 1;
transform: translateX(0);
}
}

/* === RESPONSIVE === */
@media (max-width: 991.98px) {

.profile-wrapper,
.booking-wrapper {
animation: fadeInUp 0.6s ease-out;
}

.hero-gradient {
min-height: 30vh !important;
padding: 60px 0 !important;
}
}

.day-btn:hover {
background: #845d70 !important;
color: white !important;
border: none !important;
}

.time-slot:hover:not(:disabled) {
background: #845d70 !important;
color: white !important;
border: none !important;
}

.service-checkbox:checked {
background-color: #845d70;
border-color: #845d70;
}

.portfolio-item:hover {
transform: scale(1.05);
transition: all 0.3s ease;
}

.form-control:focus {
border-color: #845d70;
box-shadow: 0 0 0 0.2rem rgba(132, 93, 112, 0.25);
}

/* Animations */
@keyframes slideInLeft {
from {
</style>

<script>
    $(document).ready(function() {
        // Calendar day selection
        $('.day-btn').on('click', function() {
            $('.day-btn').removeClass('selected').css({
                'background': '#f8f9fa',
                'color': '#333',
                'border': '1px solid #dee2e6'
            });
            $(this).addClass('selected').css({
                'background': '#845d70',
                'color': 'white',
                'border': 'none'
            });
        });

        // Time slot selection
        inline: false,
            locale: "en",
            disable: [
                // Disable some dates (example: weekends or unavailable dates)
                function(date) {
                    // Disable Sundays (0 = Sunday)
                    return (date.getDay() === 0);
                }
            ],
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length > 0) {
                    loadTimeSlots(dateStr);
                    updateSelectedDisplay(dateStr, null);
                }
            }
    });

    // Load available time slots for selected date
    function loadTimeSlots(selectedDate) {
        // Simulate different time slots for different days
        const timeSlots = [{
                time: '09:00 - 10:30',
                available: true
            },
            {
                time: '11:00 - 12:30',
                available: Math.random() > 0.3
            },
            {
                time: '14:00 - 15:30',
                available: Math.random() > 0.5
            },
            {
                time: '16:00 - 17:30',
                available: true
            },
            {
                time: '19:00 - 20:30',
                available: Math.random() > 0.4
            }
        ];

        let slotsHtml = '';
        timeSlots.forEach((slot, index) => {
            slotsHtml += `
                        <button class="btn w-100 mb-2 time-slot-btn ${!slot.available ? 'disabled' : ''}"
                                style="padding: 12px; border-radius: 10px; border: 2px solid ${slot.available ? '#f8bbbd' : '#e9ecef'};
                                       background: ${slot.available ? '#fff' : '#f8f9fa'};
                                       color: ${slot.available ? '#845d70' : '#6c757d'};"
                                ${!slot.available ? 'disabled' : ''}
                                data-time="${slot.time}">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="fw-semibold">${slot.time}</span>
                                ${slot.available ? '<i class="fas fa-clock text-muted"></i>' : '<small class="text-danger">Booked</small>'}
                            </div>
                        </button>
                    `;
        });

        $('#timeSlots').html(slotsHtml);
        $('#defaultTimeSlots').hide();
    }

    // Update selected date & time display
    function updateSelectedDisplay(date, time) {
        const dateObj = new Date(date);
        const formattedDate = dateObj.toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        let displayText = formattedDate;
        if (time) {
            displayText += ` at ${time}`;
        }

        $('#selectedDateTime').text(displayText);
        if (date) {
            $('.selected-datetime').show();
        }
    }

    // Time slot selection (delegated event for dynamic content)
    $(document).on('click', '.time-slot-btn:not(:disabled)', function() {
        $('.time-slot-btn').removeClass('selected').each(function() {
            const isAvailable = !$(this).hasClass('disabled');
            $(this).css({
                'background': isAvailable ? '#fff' : '#f8f9fa',
                'color': isAvailable ? '#845d70' : '#6c757d',
                'border-color': isAvailable ? '#f8bbbd' : '#e9ecef'
            });
        });

        $(this).addClass('selected').css({
            'background': '#845d70',
            'color': 'white',
            'border-color': '#845d70'
        });

        const selectedTime = $(this).data('time');
        const selectedDate = $('#datePickerMua').val();
        if (selectedDate) {
            updateSelectedDisplay(selectedDate, selectedTime);
        }
    });

    // Original time slot selection (for default slots)
    $('.time-slot').on('click', function() {
        if (!$(this).prop('disabled')) {
            $('.time-slot').removeClass('selected').each(function() {
                if (!$(this).prop('disabled')) {
                    $(this).css({
                        'background': '#f8f9fa',
                        'color': '#333',
                        'border': '1px solid #f8bbbd'
                    });
                }
            });
            $(this).addClass('selected').css({
                'background': '#845d70',
                'color': 'white',
                'border': 'none'
            });
        }
    });

    // Service selection calculation
    $('.service-checkbox').on('change', function() {
        // Add price calculation logic here
        updateEstimatedPrice();
    });

    function updateEstimatedPrice() {
        // Calculate total price based on selected services
        let total = 270000; // Base price
        $('.service-checkbox:checked').each(function() {
            // Add service prices
        });

        // Update estimated price display
        // This is a placeholder - implement actual calculation
    }

    // Book Now button click
    $('#bookNowBtn').on('click', function() {
        // Validate form
        const form = $('#bookingForm')[0];
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        // Show loading state
        const btn = $(this);
        const originalText = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Processing...').prop('disabled', true);

        // Collect form data
        const formData = new FormData(form);

        // Add selected services
        const selectedServices = [];
        $('.service-checkbox:checked').each(function() {
            selectedServices.push($(this).closest('.form-check').find('label').text()
                .trim());
        });
        formData.append('services', JSON.stringify(selectedServices));

        // Submit booking
        fetch(`{{ route('auth-mua.book', $mua['id']) }}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Show success modal or alert
                    showBookingSuccess(data);
                } else {
                    throw new Error(data.message || 'Booking failed');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Booking failed: ' + error.message);
            })
            .finally(() => {
                // Restore button state
                btn.html(originalText).prop('disabled', false);
            });
    });

    // Portfolio image click
    $('.portfolio-item img').on('click', function() {
        // Implement lightbox or modal for portfolio viewing
        const src = $(this).attr('src');
        // You can add a modal here to show larger image
    });

    // Update selected date and time
    $('.day-btn').on('click', function() {
        $('#selectedDate').val($(this).data('day'));
    });

    $('.time-slot').on('click', function() {
        if (!$(this).prop('disabled')) {
            $('#selectedTime').val($(this).data('time'));
        }
    });

    // Show booking success message
    function showBookingSuccess(data) {
        const modal = `
            <div class="modal fade" id="successModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 20px;">
                        <div class="modal-body text-center p-5">
                            <div class="mb-4">
                                <i class="fas fa-check-circle" style="font-size: 4rem; color: #28a745;"></i>
                            </div>
                            <h4 class="fw-bold mb-3" style="color: #845d70;">Booking Successful!</h4>
                            <p class="text-muted mb-4">Your booking request has been submitted successfully.
                               The MUA will contact you soon to confirm the details.</p>
                            <p class="small text-muted">Booking ID: <strong>${data.booking_id}</strong></p>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                                    style="background: #845d70; border: none; border-radius: 15px; padding: 10px 30px;">
                                Got it!
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        $('body').append(modal);
        $('#successModal').modal('show');

        // Remove modal after it's hidden
        $('#successModal').on('hidden.bs.modal', function() {
            $(this).remove();
        });
    }
    });
</script>
@endsection
