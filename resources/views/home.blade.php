@extends('templates.front.master')
@section('content')
    <!-- Hero Section -->
    <section id="home" class="py-5"
        style="background: linear-gradient(135deg, var(--bs-light) 0%, #fff4ed 100%); min-height: 80vh;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4" style="color: var(--bs-dark);">
                        Find Your Perfect Makeup Artist
                    </h1>
                    <p class="lead mb-4 text-muted">
                        GlowHub connects you with verified professional makeup artists in your area.
                        Browse profiles, compare prices, read reviews, and book the perfect MUA for your special occasion.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#find-mua" class="btn btn-primary btn-lg">Browse MUAs</a>
                        <a href="#how-it-works" class="btn btn-outline-primary btn-lg">How It Works</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="images/main-banner1.jpg" alt="Professional Makeup" class="img-fluid rounded-3 shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Section Separator -->
    <div class="section-separator">
        <div class="section-separator-icon">
            <i class="fas fa-star"></i>
        </div>
    </div>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-5 section-bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">How GlowHub Works</h2>
                <p class="lead text-muted">Connect with professional makeup artists in 4 simple steps</p>
            </div>

            <div class="row g-4">
                <div class="col-md-3 text-center">
                    <div class="p-4">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 80px; height: 80px;">
                            <i class="fas fa-search text-white fs-3"></i>
                        </div>
                        <h5 class="fw-bold">1. Browse & Compare</h5>
                        <p class="text-muted">Search MUAs by location, style, and price. View portfolios and read reviews
                            from real clients.</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="p-4">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 80px; height: 80px;">
                            <i class="fas fa-comments text-white fs-3"></i>
                        </div>
                        <h5 class="fw-bold">2. Contact & Discuss</h5>
                        <p class="text-muted">Message your chosen MUA to discuss your vision, event details, and
                            availability.</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="p-4">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 80px; height: 80px;">
                            <i class="fas fa-calendar-check text-white fs-3"></i>
                        </div>
                        <h5 class="fw-bold">3. Book & Pay</h5>
                        <p class="text-muted">Secure your booking with our safe payment system and get instant confirmation.
                        </p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="p-4">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 80px; height: 80px;">
                            <i class="fas fa-star text-white fs-3"></i>
                        </div>
                        <h5 class="fw-bold">4. Get Gorgeous</h5>
                        <p class="text-muted">Enjoy your professional makeup session and don't forget to rate your
                            experience!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Geometric Separator -->
    <div class="geometric-separator"></div>

    <!-- Find MUA Section -->
    <section id="find-mua" class="py-5 section-bg-primary-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Discover Top-Rated MUAs</h2>
                <p class="lead text-muted">Browse verified makeup artists near you. All profiles include portfolios,
                    reviews, and transparent pricing.</p>
            </div>

            <!-- Featured MUA Cards -->
            <div class="row g-4">
                @for ($x = 1; $x <= 6; $x++)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0 position-relative">
                            <!-- Heart Icon -->
                            <div class="position-absolute top-0 end-0 p-3" style="z-index: 10;">
                                <i class="far fa-heart text-primary" style="font-size: 1.2rem; cursor: pointer;"></i>
                            </div>

                            <!-- MUA Image -->
                            <div class="position-relative">
                                <img src="images/product-item{{ $x }}.jpg" alt="sarah" class="card-img-top"
                                    style="height: 200px; object-fit: cover;">
                            </div>

                            <!-- Card Body -->
                            <div class="card-body text-center p-4">
                                <h5 class="fw-bold">Sarah Martinez</h5>
                                <p class="text-primary mb-2">Bridal • Malang | Lowokwaru</p>

                                <!-- Rating -->
                                <div class="mb-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-warning" style="font-size: 0.9rem;"></i>
                                    @endfor
                                    <span class="text-muted small ms-2">4.8 (10 reviews)</span>
                                </div>

                                <p class="text-muted small mb-3">From Rp. 250.000</p>
                                <a href="#" class="btn btn-outline-primary">View Profile</a>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('mua.listing') }}" class="btn btn-primary">View All Artists</a>
            </div>
        </div>
    </section>

    <!-- Wave Separator -->
    <div class="wave-separator">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path
                d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                opacity=".25" fill="currentColor" style="color: var(--bs-primary);"></path>
            <path
                d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z"
                opacity=".5" fill="currentColor" style="color: var(--bs-primary);"></path>
            <path
                d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"
                fill="currentColor" style="color: var(--bs-primary);"></path>
        </svg>
    </div>

    <!-- For MUA Section -->
    <section id="services" class="py-5 section-bg-pattern">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Join GlowHub as a Makeup Artist</h2>
                <p class="lead text-muted">Grow your business and connect with clients who value professional makeup
                    artistry</p>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-users text-white fs-3"></i>
                            </div>
                            <h5 class="card-title fw-bold">Expand Your Clientele</h5>
                            <p class="card-text text-muted">Reach thousands of potential clients actively searching for
                                professional makeup artists in your area.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-calendar-alt text-white fs-3"></i>
                            </div>
                            <h5 class="card-title fw-bold">Manage Your Schedule</h5>
                            <p class="card-text text-muted">Easy booking system with calendar integration. Set your
                                availability and let clients book directly through the platform.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-credit-card text-white fs-3"></i>
                            </div>
                            <h5 class="card-title fw-bold">Secure Payments</h5>
                            <p class="card-text text-muted">Get paid safely and on time. Our secure payment system handles
                                transactions and releases funds after completed services.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MUA Benefits -->
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <img src="images/main-banner2.jpg" alt="Professional MUA" class="img-fluid rounded-3 shadow">
                </div>
                <div class="col-lg-6">
                    <h3 class="fw-bold mb-4">Why Choose GlowHub?</h3>
                    <div class="mb-3">
                        <div class="d-flex align-items-start mb-2">
                            <i class="fas fa-check-circle text-primary me-3 mt-1"></i>
                            <div>
                                <strong>Professional Profile</strong>
                                <p class="text-muted mb-0">Showcase your portfolio, certifications, and client reviews in a
                                    beautiful profile page.</p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex align-items-start mb-2">
                            <i class="fas fa-check-circle text-primary me-3 mt-1"></i>
                            <div>
                                <strong>Set Your Own Rates</strong>
                                <p class="text-muted mb-0">You control your pricing. No hidden fees - only a small
                                    commission on completed bookings.</p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex align-items-start mb-2">
                            <i class="fas fa-check-circle text-primary me-3 mt-1"></i>
                            <div>
                                <strong>Marketing Support</strong>
                                <p class="text-muted mb-0">We handle the marketing and customer acquisition. You focus on
                                    what you do best - creating beautiful looks.</p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex align-items-start mb-2">
                            <i class="fas fa-check-circle text-primary me-3 mt-1"></i>
                            <div>
                                <strong>24/7 Support</strong>
                                <p class="text-muted mb-0">Our dedicated support team is always here to help you succeed on
                                    the platform.</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <a href="#" class="btn btn-primary btn-lg">Join as MUA</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Separator -->
    <div class="section-separator">
        <div class="section-separator-icon">
            <i class="fas fa-heart"></i>
        </div>
    </div>

    <!-- Testimonials Section -->
    <section class="py-5 section-bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Why Clients Love GlowHub</h2>
                <p class="lead text-muted">Real experiences from our platform users</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p class="mb-3">"GlowHub made finding my wedding MUA so easy! I could compare portfolios,
                                read reviews, and book directly. Sarah was perfect and my makeup was flawless all day."</p>
                            <div class="d-flex align-items-center">
                                <img src="images/default.png" alt="Emily" class="rounded-circle me-3" width="50"
                                    height="50">
                                <div>
                                    <h6 class="mb-0">Emily Johnson</h6>
                                    <small class="text-muted">Bride</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p class="mb-3">"I love how transparent the pricing is on GlowHub. Found Maria through the
                                platform and she was amazing for my company gala. The booking process was seamless!"</p>
                            <div class="d-flex align-items-center">
                                <img src="images/default.png" alt="Jessica" class="rounded-circle me-3" width="50"
                                    height="50">
                                <div>
                                    <h6 class="mb-0">Jessica Chen</h6>
                                    <small class="text-muted">Corporate Event</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p class="mb-3">"As a model, I need reliable MUAs for different shoots. GlowHub's filter
                                system helped me find Emma who specializes in editorial work. Perfect match every time!"</p>
                            <div class="d-flex align-items-center">
                                <img src="images/default.png" alt="Rachel" class="rounded-circle me-3" width="50"
                                    height="50">
                                <div>
                                    <h6 class="mb-0">Rachel Adams</h6>
                                    <small class="text-muted">Model</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

    <!-- Contact Section -->
    <section id="contact" class="py-5 section-bg-pattern">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Need Help Finding the Right MUA?</h2>
                <p class="lead text-muted">Our team can help you find the perfect makeup artist for your event. Contact us
                    for personalized recommendations!</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body p-4">
                                    <h5 class="fw-bold mb-4">Get Personalized Help</h5>
                                    <form>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" placeholder="Your Name" required>
                                        </div>
                                        <div class="mb-3">
                                            <input type="email" class="form-control" placeholder="Your Email" required>
                                        </div>
                                        <div class="mb-3">
                                            <select class="form-select" required>
                                                <option value="">What do you need help with?</option>
                                                <option>Finding a Bridal MUA</option>
                                                <option>Event Makeup Artist</option>
                                                <option>Editorial/Fashion MUA</option>
                                                <option>Platform Support</option>
                                                <option>Become a MUA Partner</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <textarea class="form-control" rows="4"
                                                placeholder="Tell us about your event, budget, location, and any specific requirements..." required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Send Message</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body p-4">
                                    <h5 class="fw-bold mb-4">GlowHub Support</h5>

                                    <div class="mb-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-map-marker-alt text-primary me-3"></i>
                                            <strong>Location</strong>
                                        </div>
                                        <p class="text-muted ms-4">123 Beauty Street<br>New York, NY 10001</p>
                                    </div>

                                    <div class="mb-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-phone text-primary me-3"></i>
                                            <strong>Phone</strong>
                                        </div>
                                        <p class="text-muted ms-4">+1 (555) 123-4567</p>
                                    </div>

                                    <div class="mb-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-envelope text-primary me-3"></i>
                                            <strong>Email</strong>
                                        </div>
                                        <p class="text-muted ms-4">support@glowhub.com</p>
                                    </div>

                                    <div class="mb-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-clock text-primary me-3"></i>
                                            <strong>Hours</strong>
                                        </div>
                                        <p class="text-muted ms-4">Monday - Friday: 9AM - 6PM<br>Weekend: 10AM - 4PM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
