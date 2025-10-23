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

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-5">
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

    <!-- Find MUA Section -->
    <section id="find-mua" class="py-5" style="background-color: var(--bs-light);">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Discover Top-Rated MUAs</h2>
                <p class="lead text-muted">Browse verified makeup artists near you. All profiles include portfolios,
                    reviews, and transparent pricing.</p>
            </div>

            <!-- Featured MUA Cards -->
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center p-4">
                            <img src="images/default.png" alt="Sarah" class="rounded-circle mb-3" width="80"
                                height="80">
                            <h5 class="fw-bold">Sarah Martinez</h5>
                            <p class="text-primary mb-2">Bridal Specialist • 5 years exp</p>
                            <p class="text-muted small">From $150 • New York</p>
                            <a href="#" class="btn btn-outline-primary">View Profile</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center p-4">
                            <img src="images/default.png" alt="Maria" class="rounded-circle mb-3" width="80"
                                height="80">
                            <h5 class="fw-bold">Maria Johnson</h5>
                            <p class="text-primary mb-2">Event Makeup • 7 years exp</p>
                            <p class="text-muted small">From $120 • Los Angeles</p>
                            <a href="#" class="btn btn-outline-primary">View Profile</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center p-4">
                            <img src="images/default.png" alt="Emma" class="rounded-circle mb-3" width="80"
                                height="80">
                            <h5 class="fw-bold">Emma Chen</h5>
                            <p class="text-primary mb-2">Fashion & Editorial • 8 years exp</p>
                            <p class="text-muted small">From $180 • Miami</p>
                            <a href="#" class="btn btn-outline-primary">View Profile</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center p-4">
                            <img src="images/default.png" alt="Sarah" class="rounded-circle mb-3" width="80"
                                height="80">
                            <h5 class="fw-bold">Sarah Martinez</h5>
                            <p class="text-primary mb-2">Bridal Specialist • 5 years exp</p>
                            <p class="text-muted small">From $150 • New York</p>
                            <a href="#" class="btn btn-outline-primary">View Profile</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center p-4">
                            <img src="images/default.png" alt="Maria" class="rounded-circle mb-3" width="80"
                                height="80">
                            <h5 class="fw-bold">Maria Johnson</h5>
                            <p class="text-primary mb-2">Event Makeup • 7 years exp</p>
                            <p class="text-muted small">From $120 • Los Angeles</p>
                            <a href="#" class="btn btn-outline-primary">View Profile</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center p-4">
                            <img src="images/default.png" alt="Emma" class="rounded-circle mb-3" width="80"
                                height="80">
                            <h5 class="fw-bold">Emma Chen</h5>
                            <p class="text-primary mb-2">Fashion & Editorial • 8 years exp</p>
                            <p class="text-muted small">From $180 • Miami</p>
                            <a href="#" class="btn btn-outline-primary">View Profile</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="#" class="btn btn-primary">View All Artists</a>
            </div>
        </div>
    </section>

    <!-- For MUA Section -->
    <section id="services" class="py-5">
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
                        <a href="#" class="btn btn-outline-primary btn-lg">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5" style="background-color: var(--bs-light);">
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
                                <img src="images/logo/avatar1.jpg" alt="Emily" class="rounded-circle me-3"
                                    width="50" height="50">
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
                                <img src="images/logo/avatar2.jpg" alt="Jessica" class="rounded-circle me-3"
                                    width="50" height="50">
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
                                <img src="images/logo/avatar3.jpg" alt="Rachel" class="rounded-circle me-3"
                                    width="50" height="50">
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

    <!-- Contact Section -->
    <section id="contact" class="py-5">
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
