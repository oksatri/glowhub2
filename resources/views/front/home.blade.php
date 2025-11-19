@extends('front._parts.master')
@section('content')
    @php
        // render content sections in configured order (lowest order value appears first)
        $orderedContents = isset($contents) ? $contents->sortBy('order')->values() : collect();
    @endphp

    @foreach ($orderedContents as $section)
        @switch(strtolower($section->section_type))
            @case('hero')
                <section id="home" class="py-5"
                    style="background: linear-gradient(135deg, var(--bs-light) 0%, #fff4ed 100%); min-height: 80vh;">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <h1 class="display-4 fw-bold mb-4" style="color: var(--bs-dark);">{!! $section->title ?? 'Find Your Perfect Makeup Artist' !!}</h1>
                                <p class="lead mb-4 text-muted">{!! $section->description ?? ($section->excerpt ?? '') !!}</p>
                                <div class="d-flex gap-3">
                                    @if ($section->has_button && is_array($section->buttons) && count($section->buttons) > 0)
                                        @foreach ($section->buttons as $btn)
                                            <a href="{{ $btn['url'] ?? '#' }}"
                                                class="btn btn-lg {{ isset($btn['url']) && strpos($btn['url'], '#') !== false ? 'btn-outline-primary' : 'btn-primary' }}">
                                                {{ $btn['label'] ?? 'Learn More' }}
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                @if ($section->image)
                                    <img src="{{ asset('uploads/' . $section->image) }}" alt="{{ $section->title }}"
                                        class="img-fluid rounded-3 shadow">
                                @else
                                    <img src="images/main-banner1.jpg" alt="Professional Makeup" class="img-fluid rounded-3 shadow">
                                @endif
                            </div>
                        </div>
                    </div>
                </section>
            @break

            @case('content')
                <section id="{{ $section->slug }}" class="py-5 section-bg-light">
                    <div class="container">
                        <div class="text-center mb-5">
                            <h2 class="fw-bold mb-3">{{ $section->title ?? 'How GlowHub Works' }}</h2>
                            <p class="lead text-muted">{{ $section->description ?? '' }}</p>
                        </div>
                        <div class="row g-4">
                            @if ($section->details && $section->details->count() > 0)
                                @php
                                    $aboutDetails = $section->details->where('category', 'about')->sortBy('order');
                                    $otherDetails = $section->details
                                        ->where('category', '!=', 'about')
                                        ->sortBy('order');
                                @endphp

                                @if ($otherDetails->count() > 0)
                                    <div class="row g-4">
                                        @foreach ($otherDetails as $detail)
                                            <div class="col-md-{{ 12 / max(1, $otherDetails->count()) }} text-center">
                                                <div class="p-4">
                                                    <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3"
                                                        style="width: 80px; height: 80px;">
                                                        @if ($detail->icon)
                                                            <i class="{{ $detail->icon }} text-white fs-3"></i>
                                                        @else
                                                            <i class="fas fa-check-circle text-white fs-3"></i>
                                                        @endif
                                                    </div>
                                                    <h4 class="fw-bold" style="letter-spacing: 0px;">
                                                        {{ $detail->title ?? 'Step' }}</h4>
                                                    <p class="text-muted">{{ Str::limit($detail->description ?? '', 160) }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                @if ($aboutDetails->count() > 0)
                                    <!-- MUA Benefits -->
                                    <div class="row align-items-center mb-5">
                                        <div class="col-lg-6">
                                            <img src="images/main-banner2.jpg" alt="Professional MUA"
                                                class="img-fluid rounded-3 shadow">
                                        </div>
                                        <div class="col-lg-6">
                                            <h3 class="fw-bold mb-0">{{ $aboutDetails->first()->title ?? 'Why Choose GlowHub?' }}
                                            </h3>
                                            <div class="mb-3">
                                                <p class="text-muted mb-0">{{ $aboutDetails->first()->description ?? '' }}
                                                </p>
                                            </div>
                                            @if (!empty($aboutDetails->first()->additional) && is_array($aboutDetails->first()->additional))
                                                @foreach ($aboutDetails->first()->additional as $item)
                                                    <div class="mb-3">
                                                        <div class="d-flex align-items-start mb-2">
                                                            <i
                                                                class="{{ $item['icon'] ?? 'fas fa-check-circle' }} text-primary me-3 mt-1"></i>
                                                            <div>
                                                                <strong>{{ $item['title'] ?? '' }}</strong>
                                                                <p class="text-muted mb-0">{{ $item['description'] ?? '' }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <div class="d-flex gap-3 mt-4">
                                                @if ($section->has_button && is_array($section->buttons) && count($section->buttons) > 0)
                                                    @foreach ($section->buttons as $btn)
                                                        <a href="{{ $btn['url'] ?? '#' }}"
                                                            class="btn btn-lg {{ isset($btn['url']) && strpos($btn['url'], '#') !== false ? 'btn-outline-primary' : 'btn-primary' }}">
                                                            {{ $btn['label'] ?? 'Learn More' }}
                                                        </a>
                                                    @endforeach
                                                @endif
                                                {{-- <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Join as MUA</a> --}}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </section>
            @break

            @case('testimonials')
                @php
                    // Ambil data dari tabel testimoni
                    $testimonials = \App\Models\Testimonial::where('status', 'publish')->orderBy('order')->get();
                @endphp
                <section class="py-5 section-bg-light">
                    <div class="container">
                        <div class="text-center mb-5">
                            <h2 class="fw-bold mb-3">{{ $section->title ?? 'Why Clients Love GlowHub' }}</h2>
                            <p class="lead text-muted">{{ $section->description ?? '' }}</p>
                        </div>
                        <div class="row g-4">
                            @if ($testimonials && $testimonials->count() > 0)
                                @foreach ($testimonials as $t)
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body p-4">
                                                <div class="mb-3">
                                                    @for ($s = 1; $s <= $t->rating; $s++)
                                                        <i class="fas fa-star text-warning"></i>
                                                    @endfor
                                                </div>
                                                <p class="mb-3">{{ $t->quote ?? '' }}</p>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $t->image ? asset('uploads/' . $t->image) : asset('images/default.png') }}"
                                                        alt="{{ $t->name ?? 'User' }}" class="rounded-circle me-3" width="50"
                                                        height="50">
                                                    <div>
                                                        <h6 class="mb-0">{{ $t->name ?? 'Anonymous' }}</h6>
                                                        <small class="text-muted">{{ $t->role ?? '' }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </section>
            @break

            @case('product')
                <section id="find-mua" class="py-5 section-bg-primary-light">
                    <div class="container">
                        <div class="text-center mb-5">
                            <h2 class="fw-bold mb-3">{{ $section->title ?? 'Discover Top-Rated MUAs' }}</h2>
                            <p class="lead text-muted">
                                {{ $section->description ?? 'Jelajahi makeup artist terverifikasi di dekat Anda.' }}</p>
                        </div>

                        <div class="row g-4">
                            @foreach ($topMuas ?? collect() as $m)
                                <div class="col-md-4">
                                    <div class="card h-100 shadow-sm border-0 position-relative">
                                        <div class="position-absolute top-0 end-0 p-3" style="z-index: 10;">
                                            <i class="far fa-heart text-primary" style="font-size: 1.2rem; cursor: pointer;"></i>
                                        </div>
                                        <div class="position-relative">
                                            <img src="{{ $m->image ? asset('uploads/' . $m->image) : asset('images/product-item1.jpg') }}"
                                                alt="{{ $m->name }}" class="card-img-top"
                                                style="height: 200px; object-fit: cover;">
                                        </div>
                                        <div class="card-body text-center p-4">
                                            <h5 class="fw-bold">{{ $m->name }}</h5>
                                            <p class="text-primary mb-2">{{ $m->specialty ?? '' }} •
                                                {{ $m->city ?? '' }}</p>
                                            <div class="mb-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star text-warning" style="font-size: 0.9rem;"></i>
                                                @endfor
                                                <span class="text-muted small ms-2">{{ number_format($m->rating ?? 4.5, 1) }}
                                                    ({{ $m->reviews ?? 0 }} reviews)
                                                </span>
                                            </div>
                                            @php
                                                // Cari harga paling murah dari semua service
                                                $minPrice = null;
                                                if ($m->services && count($m->services) > 0) {
                                                    $minPrice = collect($m->services)->min('price');
                                                }
                                            @endphp
                                            <p class="text-muted small mb-3">From Rp.
                                                {{ $minPrice ? number_format($minPrice, 0, ',', '.') : '-' }}</p>
                                            <a href="{{ url('mua/' . $m->id) }}" class="btn btn-outline-primary">View Profile</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="text-center mt-4">
                            @if ($section->has_button && is_array($section->buttons) && count($section->buttons) > 0)
                                @foreach ($section->buttons as $btn)
                                    <a href="{{ $btn['url'] ?? '#' }}"
                                        class="btn btn-lg {{ isset($btn['url']) && strpos($btn['url'], '#') !== false ? 'btn-outline-primary' : 'btn-primary' }}">
                                        {{ $btn['label'] ?? 'Learn More' }}
                                    </a>
                                @endforeach
                            @endif
                            {{-- <a href="{{ route('mua.listing') }}" class="btn btn-primary">Find MUAs</a> --}}
                        </div>
                    </div>
                </section>
                <div class="wave-separator">
                    <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
                        <path
                            d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                            opacity=".25" fill="currentColor" style="color: var(--bs-primary);"></path>
                    </svg>
                </div>
            @break

            @case('contact')
                <section id="contact" class="py-5 section-bg-pattern">
                    <div class="container">
                        <div class="text-center mb-5">
                            <h2 class="fw-bold mb-3">{{ $section->title ?? 'Contact Us' }}</h2>
                            <p class="lead text-muted">
                                {{ $section->description ?? 'Hubungi kami untuk bantuan atau pertanyaan.' }}</p>
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
                                                        <input type="text" class="form-control" placeholder="Nama Anda"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="email" class="form-control" placeholder="Email Anda"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <select class="form-control" required>
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
                                                    <p class="text-muted ms-4">
                                                        {!! $siteSetting->address ?? '123 Beauty Street<br>New York, NY 10001' !!}
                                                    </p>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fas fa-phone text-primary me-3"></i>
                                                        <strong>Phone</strong>
                                                    </div>
                                                    <p class="text-muted ms-4">
                                                        {{ $siteSetting->contact_phone ?? '+1 (555) 123-4567' }}
                                                    </p>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fas fa-envelope text-primary me-3"></i>
                                                        <strong>Email</strong>
                                                    </div>
                                                    <p class="text-muted ms-4">
                                                        {{ $siteSetting->contact_email ?? 'support@glowhub.com' }}</p>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fas fa-clock text-primary me-3"></i>
                                                        <strong>Hours</strong>
                                                    </div>
                                                    <p class="text-muted ms-4">
                                                        {!! $siteSetting->contact_hours ?? 'Monday - Friday: 9AM - 6PM<br>Weekend: 10AM - 4PM' !!}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @break

            @default
                <section class="py-5">
                    <div class="container">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold mb-3">{{ $section->title }}</h2>
                            <p class="lead text-muted">{{ $section->description }}</p>
                        </div>
                        @if ($section->image)
                            <div class="text-center mb-4"><img src="{{ asset('uploads/' . $section->image) }}"
                                    class="img-fluid rounded" alt="{{ $section->title }}" /></div>
                        @endif
                        <div class="text-center">
                            @if ($section->has_button && is_array($section->buttons))
                                @foreach ($section->buttons as $btn)
                                    <a href="{{ $btn['url'] ?? '#' }}"
                                        class="btn btn-outline-primary mx-1">{{ $btn['label'] ?? 'Learn more' }}</a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </section>
            @break
        @endswitch
    @endforeach
@endsection
