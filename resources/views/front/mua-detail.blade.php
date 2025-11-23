@extends('front._parts.master')
@section('meta_title', ($mua['location'] ?? 'MUA Profile') . ' - ' . ($siteSetting->site_name ?? 'GlowHub'))
@section('meta_description', ($mua['description'] ?? '') . ' • ' . ($siteSetting->meta_description ??
    ($siteSetting->site_tagline ?? '')))
@section('content')
    <style>
        /* === CLEAN & PROFESSIONAL STYLING === */
        .hero-gradient {
            background: linear-gradient(135deg, #ffd6e8 0%, #ffe9f2 100%) !important;
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
                            class="text-white text-decoration-none opacity-75 hover-opacity">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/mua-listing') }}"
                            class="text-white text-decoration-none opacity-75 hover-opacity">Find MUA</a></li>
                    <li class="breadcrumb-item active text-white fw-bold" aria-current="page">{{ $mua['location'] }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- MUA Detail Section -->
    <section class="py-5" style="background-color:#FFF4ED;">
        <div class="container">
            <div class="row g-4">
                <!-- Left Column - Profile & Portfolio -->
                <div class="col-lg-6">
                    <div class="profile-section">
                        <!-- Profile Card -->
                        <div class="card shadow-sm border-0 mb-4"
                            style="background-color:#FDE1E1; border-radius:22px; overflow:hidden;">
                            <!-- Profile Image -->
                            <div class="position-relative">
                                <div style="width:100%; aspect-ratio:3/4; overflow:hidden;">
                                    <img src="{{ $mua['image'] }}" alt="{{ $mua['name'] }}"
                                        style="width:100%; height:100%; object-fit:cover;">
                                </div>
                                <!-- Location Badge -->
                                <div class="position-absolute bottom-0 start-0 m-3">
                                    <span class="badge px-3 py-2 rounded-pill"
                                        style="background-color:#F7BCC6; color:#4B2E2E;">
                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $mua['location'] }}
                                    </span>
                                </div>
                            </div>

                            <!-- Profile Info -->
                            <div class="card-body p-4">
                                <!-- Location at top -->
                                <div class="text-center mb-3">
                                    <div class="d-flex justify-content-center align-items-center mb-2">
                                        <i class="fas fa-map-marker-alt me-2" style="color:#D23B3B;"></i>
                                        <span class="fw-semibold text-primary">{{ $mua['location'] }}</span>
                                    </div>
                                </div>
                                
                                <div class="text-center mb-4">
                                    <p class="text-muted mb-2">
                                        @if (!empty($mua['max_distance']))
                                            Available within {{ $mua['max_distance'] }} km radius
                                        @else
                                            Service area available
                                        @endif
                                    </p>
                                    <p class="small text-secondary fst-italic">
                                        {{ $mua['description'] }}
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
                                        <h6 class="fw-bold text-primary mb-1">Schedule</h6>
                                        <p class="fw-semibold text-dark mb-0">
                                            @if (!empty($mua['operational_hours']))
                                                {{ $mua['operational_hours'] }}
                                            @endif
                                            @if (!empty($mua['availability_hours']))
                                                @if (!empty($mua['operational_hours']))
                                                    •
                                                @endif
                                                {{ $mua['availability_hours'] }}
                                            @endif
                                            @if (empty($mua['operational_hours']) && empty($mua['availability_hours']))
                                                —
                                            @endif
                                        </p>
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
                                        $badgeClasses = [
                                            'bg-primary',
                                            'bg-success',
                                            'bg-danger',
                                            'bg-warning',
                                            'bg-info',
                                            'bg-secondary',
                                        ];
                                    @endphp
                                    @foreach ($portfolio as $index => $val)
                                        <div class="col-6">
                                            <div class="portfolio-item position-relative">
                                                <img src="{{ $val['image'] }}" alt="Portfolio" class="img-fluid rounded"
                                                    style="height: 120px; width: 100%; object-fit: cover; cursor: pointer;">
                                                <div class="position-absolute top-0 start-0 m-2">
                                                    <span
                                                        class="badge {{ $badgeClasses[array_rand($badgeClasses)] }}">{{ $val['service_name'] }}</span>
                                                </div>
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
                            <!-- Simple Date & Time Selection -->
                            <div class="calendar-section mb-4">
                                <div class="row g-3">
                                    <div class="col-7">
                                        <label class="form-label small mb-1">Select Date</label>
                                        <input type="date" class="form-control" id="bk_date">
                                        <small class="text-muted d-block mt-1">You can change month and year from the
                                            picker.</small>
                                    </div>

                                    <!-- Time Slots -->
                                    <div class="col-5">
                                        <h6 class="fw-bold mb-2 text-primary">Available Times</h6>
                                        @php
                                            $timeSlots = [];
                                            $selectedTime = null;

                                            // Generate time slots every 2 hours based on operational_hours if possible
                                            $op = $mua['operational_hours'] ?? '';
                                            if (!empty($op) && preg_match('/(\d{1,2})[:\.](\d{2}).*?(\d{1,2})[:\.](\d{2})/u', $op, $m)) {
                                                try {
                                                    $start = new \DateTime($m[1] . ':' . $m[2]);
                                                    $end = new \DateTime($m[3] . ':' . $m[4]);
                                                    while ($start < $end) {
                                                        $timeSlots[] = $start->format('H:i');
                                                        $start->modify('+2 hours');
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
                                                    $fallbackStart->modify('+2 hours');
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
                                    </div>
                                </div>
                            </div>

                            <!-- Features Selection for the active service -->
                            <div class="services-section mb-4">
                                <h6 class="fw-bold mb-3 text-primary">Select Features for This Service</h6>
                                <div class="row g-2">
                                    @php
                                        $features = $features ?? [];
                                    @endphp

                                    @foreach ($features as $idx => $feature)
                                        @php
                                            $hasPriceRange = (!empty($feature['min_price']) && $feature['min_price'] > 0) || (!empty($feature['max_price']) && $feature['max_price'] > 0);
                                        @endphp
                                        <div class="col-12">
                                            <div
                                                class="form-check p-3 border rounded {{ !$hasPriceRange ? 'bg-light' : '' }}">
                                                <input class="form-check-input service-checkbox" type="checkbox"
                                                    name="feature_names[]" value="{{ $feature['name'] }}"
                                                    data-price="{{ $feature['min_price'] ?? $feature['max_price'] ?? 0 }}"
                                                    id="feature{{ $idx }}"
                                                    @if (!$hasPriceRange)
                                                        checked disabled
                                                    @endif>
                                                <label class="form-check-label d-flex justify-content-between w-100 {{ !$hasPriceRange ? 'text-muted' : '' }}"
                                                    for="feature{{ $idx }}">
                                                    <span class="fw-semibold {{ !$hasPriceRange ? 'text-decoration-line-through' : '' }}">
                                                        {{ $feature['name'] }}
                                                        @if (!$hasPriceRange)
                                                            <small class="text-muted">(Wajib)</small>
                                                        @endif
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
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Estimated Price -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <div class="fw-semibold">Estimated Price</div>
                                    <div class="small text-muted">Final price confirmed after MUA approval</div>
                                </div>
                                <div id="estimatedPriceDisplay" class="h5 fw-bold text-primary mb-0">
                                    Rp 0
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
                                    @if (!empty($mua['max_distance']) && !empty($mua['additional_charge']))
                                        <small class="text-muted d-block mt-1">
                                            Locations beyond {{ $mua['max_distance'] }} km from the MUA may incur an
                                            additional charge of Rp {{ number_format($mua['additional_charge'], 0, ',', '.') }}
                                            per km.
                                        </small>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small">Estimated Distance (km)</label>
                                    <input type="number" min="0" step="0.1" class="form-control" id="bk_distance_input"
                                        placeholder="e.g. 5" inputmode="decimal">
                                </div>

                                <!-- Hidden inputs populated by JS -->
                                <input type="hidden" name="distance" id="bk_distance">
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
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        $(document).ready(function() {
            var maxDistance = {{ $mua['max_distance'] ?? 'null' }};
            var additionalPerKm = {{ $mua['additional_charge'] ?? 'null' }};
            var basePrice = {{ $mua['price'] ?? 0 }};
            function formatRupiah(num) {
                num = num || 0;
                return 'Rp ' + num.toLocaleString('id-ID');
            }

            // initialize datepicker for booking date
            if (typeof flatpickr !== 'undefined') {
                flatpickr('#bk_date', {
                    minDate: 'today',
                    dateFormat: 'Y-m-d'
                });
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

            // Book Now handler - collects selected date/time/services and submits to server
            $('#bookNowBtn').on('click', function() {
                // selected date from date input
                var selectedDate = $('#bk_date').val();
                if (!selectedDate) {
                    alert('Please select a date first');
                    return;
                }

                // selected time from select
                var selectedTime = $('#bk_time').val();
                if (!selectedTime) {
                    alert('Please select a time slot');
                    return;
                }

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
