@extends('front._parts.master')
@section('meta_title', ($mua['name'] ?? 'MUA Profile') . ' - ' . ($siteSetting->site_name ?? 'GlowHub'))
@section('meta_description', ($mua['speciality'] ?? '') . ' • ' . ($siteSetting->meta_description ??
    ($siteSetting->site_tagline ?? '')))
@section('content')
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
                                        // Use services passed from controller if available; otherwise fallback to sample list
                                        $services = $services ?? [
                                            [
                                                'id' => null,
                                                'name' => 'Basic Makeup',
                                                'price' => 200000,
                                                'selected' => true,
                                            ],
                                            [
                                                'id' => null,
                                                'name' => 'Wedding Makeup',
                                                'price' => 500000,
                                                'selected' => false,
                                            ],
                                            [
                                                'id' => null,
                                                'name' => 'Party Makeup',
                                                'price' => 350000,
                                                'selected' => false,
                                            ],
                                            [
                                                'id' => null,
                                                'name' => 'Photoshoot',
                                                'price' => 400000,
                                                'selected' => false,
                                            ],
                                        ];
                                    @endphp

                                    @foreach ($services as $service)
                                        <div class="col-12">
                                            <div
                                                class="form-check p-3 border rounded {{ $service['selected'] ?? false ? 'bg-primary bg-opacity-10 border-primary' : '' }}">
                                                <input class="form-check-input service-checkbox" type="checkbox"
                                                    name="service_ids[]" value="{{ $service['id'] ?? $loop->index }}"
                                                    {{ $service['selected'] ?? false ? 'checked' : '' }}
                                                    id="service{{ $loop->index }}">
                                                <label class="form-check-label d-flex justify-content-between w-100"
                                                    for="service{{ $loop->index }}">
                                                    <span class="fw-semibold">{{ $service['name'] }}</span>
                                                    <span class="text-success fw-bold">Rp
                                                        {{ number_format($service['price'] ?? 0, 0, ',', '.') }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Booking Form -->
                            <form id="bookingForm" method="POST" action="{{ route('mua.book', $mua['id']) }}">
                                @csrf

                                <!-- Contact fields (prefilled if authenticated) -->
                                <div class="mb-3">
                                    <label class="form-label small">Your name</label>
                                    <input type="text" name="name" id="bk_name" class="form-control"
                                        value="{{ optional(auth()->user())->name ?? '' }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small">Email</label>
                                    <input type="email" name="email" id="bk_email" class="form-control"
                                        value="{{ optional(auth()->user())->email ?? '' }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small">WhatsApp</label>
                                    <input type="text" name="whatsapp" id="bk_whatsapp" class="form-control"
                                        value="{{ optional(auth()->user())->phone ?? '' }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small">Address</label>
                                    <input type="text" name="address" id="bk_address" class="form-control" required>
                                </div>

                                <!-- Hidden inputs populated by JS -->
                                <input type="hidden" name="distance" id="bk_distance">
                                <input type="hidden" name="selected_date" id="bk_selected_date">
                                <input type="hidden" name="selected_time" id="bk_selected_time">
                                <input type="hidden" name="services" id="bk_services">
                                <input type="hidden" name="mua_service_id" id="bk_mua_service_id">

                                <button type="button" id="bookNowBtn" class="btn w-100 btn-lg fw-bold"
                                    style="background: linear-gradient(135deg, #845d70 0%, #6d4c5a 100%); color: white; border: none; border-radius: 25px; padding: 15px;">
                                    <i class="fas fa-calendar-check me-2"></i>Book Now
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
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

            // Book Now handler - collects selected date/time/services and submits to server
            $('#bookNowBtn').on('click', function() {
                // selected day
                var dayBtn = $('.day-btn.btn-primary');
                if (dayBtn.length === 0) {
                    alert('Please select a date first');
                    return;
                }
                var day = dayBtn.data('day');

                // parse month and year from calendar header (e.g. "October 2025")
                var monthYear = $('.calendar-container h6').first().text().trim();
                var parts = monthYear.split(' ');
                var monthName = parts[0];
                var year = parts[1] || new Date().getFullYear();
                var monthMap = {
                    January: 1,
                    February: 2,
                    March: 3,
                    April: 4,
                    May: 5,
                    June: 6,
                    July: 7,
                    August: 8,
                    September: 9,
                    October: 10,
                    November: 11,
                    December: 12
                };
                var month = monthMap[monthName] || (new Date().getMonth() + 1);
                var dayP = ('0' + day).slice(-2);
                var monthP = ('0' + month).slice(-2);
                var selectedDate = year + '-' + monthP + '-' + dayP;

                // selected time
                var timeBtn = $('.time-slot.btn-primary');
                if (timeBtn.length === 0) {
                    alert('Please select a time slot');
                    return;
                }
                var selectedTime = timeBtn.data('time');

                // services (collect ids)
                var services = [];
                $('.service-checkbox:checked').each(function() {
                    var val = $(this).val();
                    if (val !== undefined && val !== null) services.push(val);
                });

                // set selected mua_service_id as first selected service id (if any)
                var muaServiceId = services.length ? services[0] : null;
                $('#bk_mua_service_id').val(muaServiceId);
                $('#bk_services').val(JSON.stringify(services));

                // contact
                var name = $('#bk_name').val();
                var email = $('#bk_email').val();
                var whatsapp = $('#bk_whatsapp').val();
                var address = $('#bk_address').val();
                if (!name || !email || !whatsapp || !address) {
                    alert('Please complete your contact information');
                    return;
                }

                var url = $('#bookingForm').attr('action');

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
                        selected_date: selectedDate,
                        selected_time: selectedTime,
                        services: services,
                        mua_service_id: $('#bk_mua_service_id').val() || null
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            var html = '<div class="alert alert-success">' + res.message +
                                '<br>Booking ID: <strong>' + res.booking_id + '</strong></div>';
                            // prepend message and reset selections
                            $('.card-body').first().prepend(html);
                            $('.day-btn').removeClass('btn-primary').addClass(
                                'btn-outline-secondary');
                            $('.time-slot').removeClass('btn-primary').addClass(
                                'btn-outline-primary');
                            $('.service-checkbox').prop('checked', false);
                            $('#bk_selected_date, #bk_selected_time, #bk_services, #bk_mua_service_id')
                                .val('');
                            // reset form fields except prefilled auth info
                            $('#bk_address').val('');
                        } else {
                            alert(res.message || 'Booking failed');
                        }
                    },
                    error: function(xhr) {
                        var msg = 'Booking failed.';
                        if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON
                            .message;
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var err = xhr.responseJSON.errors;
                            msg += '\n' + Object.values(err).map(function(v) {
                                return v.join(', ');
                            }).join('\n');
                        }
                        alert(msg);
                    }
                });
            });
        });
    </script>
@endpush
