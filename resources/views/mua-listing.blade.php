@extends('templates.front.master')
@section('content')
    <!-- Filter Section -->
    <section class="py-5" style="background: linear-gradient(135deg, var(--bs-light) 0%, #fff4ed 100%);">
        <div class="container">
            <!-- Elegant Filter Section -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="filter-container"
                        style="background: linear-gradient(145deg, rgba(255,255,255,0.95) 0%, rgba(248,187,189,0.1) 100%); backdrop-filter: blur(10px); border-radius: 20px; box-shadow: 0 8px 32px rgba(132, 93, 112, 0.15); border: 1px solid rgba(255,255,255,0.2); padding: 2rem; margin-bottom: 3rem;">
                        <!-- Filter Header -->
                        <div class="text-center mb-4">
                            <div class="filter-icon mb-3">
                                <i class="fas fa-search" style="font-size: 2rem; color: #845d70; opacity: 0.8;"></i>
                            </div>
                            <h3 class="fw-bold mb-2" style="color: #845d70; font-size: 1.5rem;">Find Your Perfect Match</h3>
                            <p class="text-muted mb-0" style="font-size: 0.9rem;">Customize your search preferences</p>
                        </div>

                        <!-- Filter Form -->
                        <form class="filter-form">
                            <div class="row g-4">
                                <!-- Event Type Filter -->
                                <div class="col-md-6">
                                    <div class="filter-group">
                                        <label class="filter-label mb-2">
                                            <i class="fas fa-calendar-alt me-2" style="color: #845d70;"></i>
                                            <span class="fw-semibold" style="color: #3d2a33;">Event Type</span>
                                        </label>
                                        <div class="custom-select-wrapper">
                                            <select class="form-select custom-select"
                                                style="border: 2px solid #f8bbbd; border-radius: 15px; padding: 12px 16px; background: rgba(255,255,255,0.8); color: #3d2a33; font-weight: 500;">
                                                <option value="" selected>Choose your event...</option>
                                                @foreach ($filterOptions['events'] as $event)
                                                    <option value="{{ $event }}">{{ $event }}</option>
                                                @endforeach
                                            </select>
                                            <i class="fas fa-chevron-down select-arrow"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- City Filter -->
                                <div class="col-md-6">
                                    <div class="filter-group">
                                        <label class="filter-label mb-2">
                                            <i class="fas fa-map-marker-alt me-2" style="color: #845d70;"></i>
                                            <span class="fw-semibold" style="color: #3d2a33;">Location</span>
                                        </label>
                                        <div class="custom-select-wrapper">
                                            <select class="form-select custom-select"
                                                style="border: 2px solid #f8bbbd; border-radius: 15px; padding: 12px 16px; background: rgba(255,255,255,0.8); color: #3d2a33; font-weight: 500;">
                                                <option value="" selected>Select your city...</option>
                                                @foreach ($filterOptions['cities'] as $city)
                                                    <option value="{{ $city }}">{{ $city }}</option>
                                                @endforeach
                                            </select>
                                            <i class="fas fa-chevron-down select-arrow"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Date Filter -->
                                <div class="col-md-6">
                                    <div class="filter-group">
                                        <label class="filter-label mb-2">
                                            <i class="fas fa-calendar-day me-2" style="color: #845d70;"></i>
                                            <span class="fw-semibold" style="color: #3d2a33;">Date</span>
                                        </label>
                                        <div class="custom-select-wrapper">
                                            <select class="form-select custom-select"
                                                style="border: 2px solid #f8bbbd; border-radius: 15px; padding: 12px 16px; background: rgba(255,255,255,0.8); color: #3d2a33; font-weight: 500;">
                                                <option value="" selected>When?</option>
                                                @foreach ($filterOptions['dates'] as $date)
                                                    <option value="{{ $date }}">{{ $date }}</option>
                                                @endforeach
                                            </select>
                                            <i class="fas fa-chevron-down select-arrow"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Time Filter -->
                                <div class="col-md-6">
                                    <div class="filter-group">
                                        <label class="filter-label mb-2">
                                            <i class="fas fa-clock me-2" style="color: #845d70;"></i>
                                            <span class="fw-semibold" style="color: #3d2a33;">Time</span>
                                        </label>
                                        <div class="custom-select-wrapper">
                                            <select class="form-select custom-select"
                                                style="border: 2px solid #f8bbbd; border-radius: 15px; padding: 12px 16px; background: rgba(255,255,255,0.8); color: #3d2a33; font-weight: 500;">
                                                <option value="" selected>What time?</option>
                                                @foreach ($filterOptions['times'] as $time)
                                                    <option value="{{ $time }}">{{ $time }}</option>
                                                @endforeach
                                            </select>
                                            <i class="fas fa-chevron-down select-arrow"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="filter-actions mt-4">
                                <div class="d-flex gap-3 justify-content-center">
                                    <button type="button" class="btn btn-search"
                                        style="background: linear-gradient(135deg, #845d70 0%, #6d4c5a 100%); border: none; border-radius: 25px; padding: 12px 32px; color: white; font-weight: 600; box-shadow: 0 4px 15px rgba(132, 93, 112, 0.3); transition: all 0.3s ease;">
                                        <i class="fas fa-search me-2"></i>Search MUAs
                                    </button>
                                    <button type="reset" class="btn btn-reset"
                                        style="background: transparent; border: 2px solid #f8bbbd; border-radius: 25px; padding: 12px 24px; color: #845d70; font-weight: 600; transition: all 0.3s ease;">
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
                                <a href="#" class="btn btn-outline-primary">View Profile</a>
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

@section('scripts')
    <style>
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

        .select-arrow {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #845d70;
            pointer-events: none;
            transition: transform 0.3s ease;
        }

        .custom-select:focus+.select-arrow {
            transform: translateY(-50%) rotate(180deg);
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

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
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
        }
    </style>

    <script>
        $(document).ready(function() {
            // Smooth scrolling for anchor links
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if (target.length) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 100
                    }, 800);
                }
            });

            // Heart icon toggle with elegant animation
            $('.fa-heart').on('click', function() {
                const heart = $(this);
                if (heart.hasClass('far')) {
                    heart.removeClass('far').addClass('fas').css('color', '#ff6b6b');
                    // Add heartbeat animation
                    heart.addClass('animate__animated animate__heartBeat');
                    setTimeout(() => heart.removeClass('animate__animated animate__heartBeat'), 1000);
                } else {
                    heart.removeClass('fas').addClass('far').css('color', '#845d70');
                }
            });

            // Enhanced filter select functionality
            $('.custom-select').on('change', function() {
                const select = $(this);
                if (select.val()) {
                    select.css({
                        'background': 'rgba(132, 93, 112, 0.1)',
                        'border-color': '#845d70'
                    });
                } else {
                    select.css({
                        'background': 'rgba(255,255,255,0.8)',
                        'border-color': '#f8bbbd'
                    });
                }
            });

            // Search functionality with animation
            $('.btn-search').on('click', function(e) {
                e.preventDefault();

                // Add loading animation
                const btn = $(this);
                const originalText = btn.html();
                btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Searching...');
                btn.prop('disabled', true);

                // Simulate search delay
                setTimeout(function() {
                    btn.html(originalText);
                    btn.prop('disabled', false);

                    // Smooth scroll to results
                    $('html, body').animate({
                        scrollTop: $('#mua-results').offset().top - 100
                    }, 800);

                    // Show success message
                    showFilterMessage('Filters applied successfully!', 'success');
                }, 1500);
            });

            // Reset functionality
            $('.btn-reset').on('click', function(e) {
                e.preventDefault();
                $('.custom-select').val('').css({
                    'background': 'rgba(255,255,255,0.8)',
                    'border-color': '#f8bbbd'
                }).trigger('change');
                showFilterMessage('Filters reset!', 'info');
            });

            // Card hover effects with enhanced animation
            $('.card').hover(
                function() {
                    $(this).addClass('shadow-lg').css({
                        'transform': 'translateY(-8px) scale(1.02)',
                        'transition': 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)'
                    });
                },
                function() {
                    $(this).removeClass('shadow-lg').css({
                        'transform': 'translateY(0) scale(1)',
                        'transition': 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)'
                    });
                }
            );

            // Filter message function
            function showFilterMessage(message, type) {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-info';
                const toast = $(`
                    <div class="alert ${alertClass} alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-info-circle'} me-2"></i>
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `);

                $('body').append(toast);
                setTimeout(() => toast.alert('close'), 3000);
            }

            // Add entrance animation to filter
            setTimeout(function() {
                $('.filter-container').addClass('animate__animated animate__fadeInUp');
            }, 200);
        });
    </script>
@endsection
