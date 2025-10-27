@extends('templates.front._parts.master')
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
                        GlowHub menghubungkan Anda dengan makeup artist profesional terverifikasi di area Anda.
                        Jelajahi profil, bandingkan harga, baca ulasan, dan booking MUA yang sempurna untuk acara spesial
                        Anda.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="{{ url('mua-listing') }}" class="btn btn-primary btn-lg">Browse MUAs</a>
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
                <p class="lead text-muted">Terhubung dengan makeup artist profesional dalam 4 langkah sederhana</p>
            </div>

            <div class="row g-4">
                <div class="col-md-3 text-center">
                    <div class="p-4">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 80px; height: 80px;">
                            <i class="fas fa-search text-white fs-3"></i>
                        </div>
                        <h4 class="fw-bold" style="letter-spacing: -0.5px;">1. Explore MUA Portfolios</h4>
                        <p class="text-muted">Masukkan tanggal makeup dan jenis acaranya.
                            Pilih style makeup yang paling cocok dengan vibe kamu!</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="p-4">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 80px; height: 80px;">
                            <i class="fas fa-paper-plane text-white fs-3"></i>
                        </div>
                        <h4 class="fw-bold" style="letter-spacing: -0.5px;">2. Send Booking Request</h4>
                        <p class="text-muted">Isi detail acara, tanggal, dan informasi lainnya. Klik "Request" dan tunggu
                            konfirmasi ketersediaan dan harga dari MUA.</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="p-4">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 80px; height: 80px;">
                            <i class="fas fa-check-circle text-white fs-3"></i>
                        </div>
                        <h4 class="fw-bold" style="letter-spacing: -0.5px;">3. MUA Review & Confirm</h4>
                        <p class="text-muted">Request kamu akan direview oleh MUA untuk memastikan ketersediaan jadwal dan
                            apakah terdapat penyesuaian dari estimasi harga (misalnya untuk hairdo khusus atau request
                            tambahan).</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="p-4">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 80px; height: 80px;">
                            <i class="fas fa-lock text-white fs-3"></i>
                        </div>
                        <h4 class="fw-bold" style="letter-spacing: -0.5px;">4. Secure Your Slot!</h4>
                        <p class="text-muted">Setelah request dikonfirmasi, kamu akan dihubungi via WA untuk melanjutkan
                            pembayaran sesuai harga yang dikonfirmasi. Booking akan otomatis terjadwal!</p>
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
                <p class="lead text-muted">Jelajahi makeup artist terverifikasi di dekat Anda. Semua profil mencakup
                    portfolio,
                    ulasan, dan harga yang transparan.</p>
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
                <p class="lead text-muted">Kembangkan bisnis Anda dan terhubung dengan klien yang menghargai
                    keahlian makeup profesional</p>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-users text-white fs-3"></i>
                            </div>
                            <h4 class="card-title fw-bold" style="letter-spacing: -0.5px;">Expand Your Clientele</h4>
                            <p class="card-text text-muted">Jangkau ribuan klien potensial yang secara aktif mencari
                                makeup artist profesional di area Anda.</p>
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
                            <h4 class="card-title fw-bold" style="letter-spacing: -0.5px;">Manage Your Schedule</h4>
                            <p class="card-text text-muted">Sistem booking mudah dengan integrasi kalender. Tetapkan
                                ketersediaan Anda dan biarkan klien booking langsung melalui platform.</p>
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
                            <h4 class="card-title fw-bold" style="letter-spacing: -0.5px;">Secure Payments</h4>
                            <p class="card-text text-muted">Dapatkan pembayaran dengan aman dan tepat waktu. Sistem
                                pembayaran aman kami menangani
                                transaksi dan merilis dana setelah layanan selesai.</p>
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
                                <p class="text-muted mb-0">Tampilkan portfolio, sertifikat, dan ulasan klien Anda dalam
                                    halaman profil yang indah.</p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex align-items-start mb-2">
                            <i class="fas fa-check-circle text-primary me-3 mt-1"></i>
                            <div>
                                <strong>Set Your Own Rates</strong>
                                <p class="text-muted mb-0">Anda mengontrol harga. Tidak ada biaya tersembunyi - hanya
                                    komisi kecil
                                    pada booking yang selesai.</p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex align-items-start mb-2">
                            <i class="fas fa-check-circle text-primary me-3 mt-1"></i>
                            <div>
                                <strong>Marketing Support</strong>
                                <p class="text-muted mb-0">Kami menangani marketing dan akuisisi pelanggan. Anda fokus pada
                                    yang terbaik - menciptakan tampilan yang indah.</p>
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
                <p class="lead text-muted">Pengalaman nyata dari pengguna platform kami</p>
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
                            <p class="mb-3">"GlowHub membuat pencarian MUA untuk pernikahan saya sangat mudah! Saya bisa
                                membandingkan portfolio,
                                membaca ulasan, dan booking langsung. Sarah sempurna dan makeup saya flawless sepanjang
                                hari."</p>
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
                            <p class="mb-3">"Saya suka bagaimana harga di GlowHub sangat transparan. Menemukan Maria
                                melalui
                                platform ini dan dia luar biasa untuk gala perusahaan saya. Proses booking sangat lancar!"
                            </p>
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
                            <p class="mb-3">"Sebagai model, saya butuh MUA yang reliable untuk berbagai pemotretan.
                                Sistem filter GlowHub
                                membantu saya menemukan Emma yang spesialis editorial work. Perfect match setiap waktu!"</p>
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
                <p class="lead text-muted">Tim kami dapat membantu Anda menemukan makeup artist yang sempurna untuk acara
                    Anda. Hubungi kami
                    untuk rekomendasi yang personal!</p>
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
                                            <input type="text" class="form-control" placeholder="Nama Anda" required>
                                        </div>
                                        <div class="mb-3">
                                            <input type="email" class="form-control" placeholder="Email Anda" required>
                                        </div>
                                        <div class="mb-3">
                                            <select class="form-select" required>
                                                <option value="">Apa yang dapat kami bantu?</option>
                                                <option>Mencari MUA untuk Pernikahan</option>
                                                <option>Makeup Artist untuk Event</option>
                                                <option>MUA Editorial/Fashion</option>
                                                <option>Dukungan Platform</option>
                                                <option>Menjadi MUA Partner</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <textarea class="form-control" rows="4"
                                                placeholder="Ceritakan tentang acara, budget, lokasi, dan requirements khusus Anda..." required></textarea>
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
