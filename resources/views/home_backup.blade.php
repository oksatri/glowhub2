@extends('templates.front.master')
@section('content')
    <!-- Hero Section -->
    <section id="home" class="py-5" style="background: linear-gradient(135deg, var(--bs-light) 0%, #fff4ed 100%); min-height: 80vh;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4" style="color: var(--bs-dark);">
                        Professional Makeup Artistry
                    </h1>
                    <p class="lead mb-4 text-muted">
                        Transform your look with expert makeup artists. From bridal beauty to glamorous events, 
                        we bring your vision to life with professional techniques and premium products.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#find-mua" class="btn btn-primary btn-lg">Find Your MUA</a>
                        <a href="#how-it-works" class="btn btn-outline-primary btn-lg">Learn More</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="images/main-banner1.jpg" alt="Professional Makeup" class="img-fluid rounded-3 shadow">
                </div>
            </div>
        </div>

    </section>



    <!-- How It Works Section -->
    <section id="featured-books" class="py-5 my-5 leaf-pattern-overlay">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header align-center mb-5">
                        <div class="title">
                            <span>Simple & Professional Process</span>
                        </div>
                        <h2 class="section-title">How It Works</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 text-center mb-4">
                    <div class="process-step">
                        <div class="step-icon mb-3">
                            <i class="icon icon-calendar" style="font-size: 3rem; color: var(--bs-primary);"></i>
                        </div>
                        <h4>1. Book Consultation</h4>
                        <p>Schedule your free consultation to discuss your vision, event details, and preferred style.</p>
                    </div>
                </div>

                <div class="col-md-3 text-center mb-4">
                    <div class="process-step">
                        <div class="step-icon mb-3">
                            <i class="icon icon-palette" style="font-size: 3rem; color: var(--bs-primary);"></i>
                        </div>
                        <h4>2. Design Your Look</h4>
                        <p>Our expert makeup artists create a personalized look that enhances your natural beauty.</p>
                    </div>
                </div>

                <div class="col-md-3 text-center mb-4">
                    <div class="process-step">
                        <div class="step-icon mb-3">
                            <i class="icon icon-clock" style="font-size: 3rem; color: var(--bs-primary);"></i>
                        </div>
                        <h4>3. Trial Session</h4>
                        <p>Perfect your look with a trial run, making adjustments until you're completely satisfied.</p>
                    </div>
                </div>

                <div class="col-md-3 text-center mb-4">
                    <div class="process-step">
                        <div class="step-icon mb-3">
                            <i class="icon icon-star" style="font-size: 3rem; color: var(--bs-primary);"></i>
                        </div>
                        <h4>4. Event Day</h4>
                        <p>Relax and enjoy your special day while we ensure you look absolutely stunning.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">How It Works</h2>
                <p class="lead text-muted">Simple steps to get your perfect makeup look</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-3 text-center">
                    <div class="p-4">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-search text-white fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Browse Artists</h5>
                        <p class="text-muted">Explore our network of professional makeup artists</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="p-4">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-calendar text-white fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Book Session</h5>
                        <p class="text-muted">Schedule your appointment at your convenience</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="p-4">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-palette text-white fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Get Styled</h5>
                        <p class="text-muted">Enjoy professional makeup application</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="p-4">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-star text-white fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Shine Bright</h5>
                        <p class="text-muted">Look stunning for your special occasion</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5" style="background-color: #fff;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Get In Touch</h2>
                <p class="lead text-muted">Ready to transform your look? Let's connect!</p>
            </div>

            <!-- For MUA Section -->
            <section id="special-offer" class="py-5 my-5">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="mua-signup-content">
                                <h2 class="section-title">Join Our Network of Professional MUAs</h2>
                                <p class="lead">Expand your client base and grow your makeup artistry business with
                                    GlowHub's
                                    platform.</p>

                                <div class="benefits-list">
                                    <div class="benefit-item d-flex align-items-center mb-3">
                                        <i class="icon icon-check-circle me-3"
                                            style="color: var(--bs-primary); font-size: 1.5rem;"></i>
                                        <span>Connect with clients seeking professional makeup services</span>
                                    </div>
                                    <div class="benefit-item d-flex align-items-center mb-3">
                                        <i class="icon icon-check-circle me-3"
                                            style="color: var(--bs-primary); font-size: 1.5rem;"></i>
                                        <span>Manage bookings and schedules effortlessly</span>
                                    </div>
                                    <div class="benefit-item d-flex align-items-center mb-3">
                                        <i class="icon icon-check-circle me-3"
                                            style="color: var(--bs-primary); font-size: 1.5rem;"></i>
                                        <span>Build your portfolio and showcase your work</span>
                                    </div>
                                    <div class="benefit-item d-flex align-items-center mb-4">
                                        <i class="icon icon-check-circle me-3"
                                            style="color: var(--bs-primary); font-size: 1.5rem;"></i>
                                        <span>Access professional development resources</span>
                                    </div>
                                </div>

                                <div class="cta-buttons">
                                    <a href="#" class="btn btn-primary btn-lg me-3">Join as MUA</a>
                                    <a href="#" class="btn btn-outline-primary btn-lg">Learn More</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mua-signup-image">
                                <img src="images/single-image.jpg" alt="Professional MUA at Work"
                                    class="img-fluid rounded shadow">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Portfolio Gallery Section -->
            <section id="portfolio" class="py-5 my-5">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-header align-center mb-5">
                                <div class="title">
                                    <span>Our stunning transformations</span>
                                </div>
                                <h2 class="section-title">Beauty Portfolio</h2>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="portfolio-item">
                                <figure class="image-hvr-effect">
                                    <img src="images/tab-item1.jpg" alt="Bridal Makeup Portfolio"
                                        class="post-image img-fluid rounded">
                                    <div class="portfolio-overlay">
                                        <div class="portfolio-content text-center">
                                            <h4 class="text-white">Bridal Elegance</h4>
                                            <p class="text-white mb-3">Classic wedding makeup with natural glow</p>
                                            <a href="#" class="btn btn-light btn-sm">View Details</a>
                                        </div>
                                    </div>
                                </figure>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="portfolio-item">
                                <figure class="image-hvr-effect">
                                    <img src="images/tab-item2.jpg" alt="Evening Glam Portfolio"
                                        class="post-image img-fluid rounded">
                                    <div class="portfolio-overlay">
                                        <div class="portfolio-content text-center">
                                            <h4 class="text-white">Evening Glamour</h4>
                                            <p class="text-white mb-3">Bold and sophisticated party look</p>
                                            <a href="#" class="btn btn-light btn-sm">View Details</a>
                                        </div>
                                    </div>
                                </figure>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="portfolio-item">
                                <figure class="image-hvr-effect">
                                    <img src="images/tab-item3.jpg" alt="Natural Beauty Portfolio"
                                        class="post-image img-fluid rounded">
                                    <div class="portfolio-overlay">
                                        <div class="portfolio-content text-center">
                                            <h4 class="text-white">Natural Beauty</h4>
                                            <p class="text-white mb-3">Fresh and radiant everyday look</p>
                                            <a href="#" class="btn btn-light btn-sm">View Details</a>
                                        </div>
                                    </div>
                                </figure>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="portfolio-item">
                                <figure class="image-hvr-effect">
                                    <img src="images/tab-item4.jpg" alt="Editorial Fashion Portfolio"
                                        class="post-image img-fluid rounded">
                                    <div class="portfolio-overlay">
                                        <div class="portfolio-content text-center">
                                            <h4 class="text-white">Editorial Fashion</h4>
                                            <p class="text-white mb-3">High-fashion editorial shoot</p>
                                            <a href="#" class="btn btn-light btn-sm">View Details</a>
                                        </div>
                                    </div>
                                </figure>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="portfolio-item">
                                <figure class="image-hvr-effect">
                                    <img src="images/tab-item5.jpg" alt="Special Event Portfolio"
                                        class="post-image img-fluid rounded">
                                    <div class="portfolio-overlay">
                                        <div class="portfolio-content text-center">
                                            <h4 class="text-white">Special Events</h4>
                                            <p class="text-white mb-3">Elegant formal event styling</p>
                                            <a href="#" class="btn btn-light btn-sm">View Details</a>
                                        </div>
                                    </div>
                                </figure>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="portfolio-item">
                                <figure class="image-hvr-effect">
                                    <img src="images/tab-item6.jpg" alt="Corporate Portfolio"
                                        class="post-image img-fluid rounded">
                                    <div class="portfolio-overlay">
                                        <div class="portfolio-content text-center">
                                            <h4 class="text-white">Professional</h4>
                                            <p class="text-white mb-3">Corporate and business styling</p>
                                            <a href="#" class="btn btn-light btn-sm">View Details</a>
                                        </div>
                                    </div>
                                </figure>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12 text-center">
                            <a href="#" class="btn btn-primary btn-lg">View Full Portfolio</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Testimonials Section -->
            <section id="testimonials" class="py-5 my-5" style="background-color: var(--bs-light);">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-header align-center mb-5">
                                <div class="title">
                                    <span>What our clients say</span>
                                </div>
                                <h2 class="section-title">Client Testimonials</h2>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="testimonial-card p-4 bg-white rounded">
                                <div class="stars mb-3">
                                    <i class="icon icon-star text-warning"></i>
                                    <i class="icon icon-star text-warning"></i>
                                    <i class="icon icon-star text-warning"></i>
                                    <i class="icon icon-star text-warning"></i>
                                    <i class="icon icon-star text-warning"></i>
                                </div>
                                <p class="testimonial-text">"Absolutely amazing! Sarah made me feel like a princess on my
                                    wedding
                                    day. The makeup lasted all day and looked perfect in every photo."</p>
                                <div class="client-info mt-3">
                                    <strong>Emma Johnson</strong>
                                    <small class="text-muted d-block">Bride, June 2024</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="testimonial-card p-4 bg-white rounded">
                                <div class="stars mb-3">
                                    <i class="icon icon-star text-warning"></i>
                                    <i class="icon icon-star text-warning"></i>
                                    <i class="icon icon-star text-warning"></i>
                                    <i class="icon icon-star text-warning"></i>
                                    <i class="icon icon-star text-warning"></i>
                                </div>
                                <p class="testimonial-text">"Professional, talented, and so easy to work with. The makeup
                                    for my
                                    photoshoot was absolutely stunning and photographed beautifully."</p>
                                <div class="client-info mt-3">
                                    <strong>Maria Rodriguez</strong>
                                    <small class="text-muted d-block">Model, Editorial Shoot</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="testimonial-card p-4 bg-white rounded">
                                <div class="stars mb-3">
                                    <i class="icon icon-star text-warning"></i>
                                    <i class="icon icon-star text-warning"></i>
                                    <i class="icon icon-star text-warning"></i>
                                    <i class="icon icon-star text-warning"></i>
                                    <i class="icon icon-star text-warning"></i>
                                </div>
                                <p class="testimonial-text">"The makeup lesson was so helpful! I learned techniques I never
                                    knew
                                    and now feel confident doing my own everyday makeup."</p>
                                <div class="client-info mt-3">
                                    <strong>Lisa Chen</strong>
                                    <small class="text-muted d-block">Makeup Lesson Client</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact Us Section -->
            <section id="latest-blog" class="py-5 my-5">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-header align-center mb-5">
                                <div class="title">
                                    <span>Get in touch with us</span>
                                </div>
                                <h2 class="section-title">Contact Us</h2>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="contact-form">
                                <form>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="firstName" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="firstName" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="lastName" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="lastName" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="phone" class="form-label">Phone</label>
                                            <input type="tel" class="form-control" id="phone">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="serviceType" class="form-label">Service Type</label>
                                        <select class="form-select" id="serviceType">
                                            <option value="">Select a service</option>
                                            <option value="bridal">Bridal Makeup</option>
                                            <option value="special-event">Special Event</option>
                                            <option value="photoshoot">Photoshoot</option>
                                            <option value="lesson">Makeup Lesson</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea class="form-control" id="message" rows="5"
                                            placeholder="Tell us about your event, preferred date, and any special requirements..."></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-lg">Send Message</button>
                                </form>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="contact-info">
                                <div class="contact-item mb-4">
                                    <h5><i class="icon icon-phone me-2" style="color: var(--bs-primary);"></i>Phone</h5>
                                    <p>+1 (555) 123-4567</p>
                                </div>

                                <div class="contact-item mb-4">
                                    <h5><i class="icon icon-envelope me-2" style="color: var(--bs-primary);"></i>Email
                                    </h5>
                                    <p>hello@glowhub.com</p>
                                </div>

                                <div class="contact-item mb-4">
                                    <h5><i class="icon icon-location me-2" style="color: var(--bs-primary);"></i>Location
                                    </h5>
                                    <p>123 Beauty Street<br>New York, NY 10001</p>
                                </div>

                                <div class="contact-item">
                                    <h5><i class="icon icon-clock me-2" style="color: var(--bs-primary);"></i>Hours</h5>
                                    <p>Monday - Saturday: 9AM - 7PM<br>Sunday: 10AM - 5PM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endsection
