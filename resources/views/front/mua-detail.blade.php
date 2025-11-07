@extends('front._parts.master')
@section('content')
    <!-- Stunning Hero Section -->
    <section class="hero-gradient position-relative overflow-hidden"
        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
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
                            class="text-white text-decoration-none opacity-75 hover-opacity">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/mua-listing') }}"
                            class="text-white text-decoration-none opacity-75 hover-opacity">Find MUA</a></li>
                    <li class="breadcrumb-item active text-white fw-bold" aria-current="page">{{ $mua['name'] }}</li>
                </ol>
            </nav>
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
                                        "Membuat Anda terlihat natural namun bersinar di setiap kesempatan"
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
                                        <strong>{{ $mua['rating'] }}/5</strong> ({{ $mua['reviews'] ?? '150' }} ulasan)
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
                                        <p class="fw-semibold text-dark mb-0">3+ Tahun</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Portfolio Section -->
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-body p-4">
                                <h5 class="fw-bold text-primary mb-3">
                                    <i class="fas fa-images me-2"></i>Portfolio
                                </h5>
                                <div class="row g-3">
                                    @php
                                        $portfolioImages = [
                                            asset('images/product-item1.jpg'),
                                            asset('images/product-item2.jpg'),
                                            asset('images/product-item3.jpg'),
                                            asset('images/product-item4.jpg'),
                                        ];
                                    @endphp
                                    @foreach ($portfolioImages as $index => $image)
                                        <div class="col-6">
                                            <div class="portfolio-item position-relative">
                                                <img src="{{ $image }}" alt="Portfolio" class="img-fluid rounded"
                                                    style="height: 120px; width: 100%; object-fit: cover; cursor: pointer;">
                                                @if ($index == 0)
                                                    <div class="position-absolute top-0 start-0 m-2">
                                                        <span class="badge bg-primary">Wedding</span>
                                                    </div>
                                                @elseif($index == 1)
                                                    <div class="position-absolute top-0 start-0 m-2">
                                                        <span class="badge bg-success">Party</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
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
                            <p class="mb-0 small opacity-75">Choose your preferred date and time</p>
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
                                                    {{ !$slot['available'] ? 'disabled' : '' }}
                                                    data-time="{{ $slot['time'] }}" style="padding: 8px;">
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

                            <!-- Services Selection -->
                            <div class="services-section mb-4">
                                <h6 class="fw-bold mb-3 text-primary">Select Services</h6>
                                <div class="row g-2">
                                    @php
                                        $services = [
                                            ['name' => 'Basic Makeup', 'price' => 200000, 'selected' => true],
                                            ['name' => 'Wedding Makeup', 'price' => 500000, 'selected' => false],
                                            ['name' => 'Party Makeup', 'price' => 350000, 'selected' => false],
                                            ['name' => 'Photoshoot', 'price' => 400000, 'selected' => false],
                                        ];
                                    @endphp

                                    @foreach ($services as $service)
                                        <div class="col-12">
                                            <div
                                                class="form-check p-3 border rounded {{ $service['selected'] ? 'bg-primary bg-opacity-10 border-primary' : '' }}">
                                                <input class="form-check-input service-checkbox" type="checkbox"
                                                    {{ $service['selected'] ? 'checked' : '' }}
                                                    id="service{{ $loop->index }}">
                                                <label class="form-check-label d-flex justify-content-between w-100"
                                                    for="service{{ $loop->index }}">
                                                    <span class="fw-semibold">{{ $service['name'] }}</span>
                                                    <span class="text-success fw-bold">Rp
                                                        {{ number_format($service['price'], 0, ',', '.') }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Book Now Button -->
                            <button type="button" id="bookNowBtn" class="btn w-100 btn-lg fw-bold"
                                style="background: linear-gradient(135deg, #845d70 0%, #6d4c5a 100%); color: white; border: none; border-radius: 25px; padding: 15px;">
                                <i class="fas fa-calendar-check me-2"></i>Book Now
                            </button>
                        </div>
                    </div>
                </div>
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
