@extends('back._parts.master')
@section('page-title', 'Site Settings')
@section('content')

    <div class="mb-4">
        <div class="p-4 rounded shadow-sm" style="background: linear-gradient(90deg,#fffaf0,#fff1f2);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1" style="font-weight:700; letter-spacing:-0.02em;">Site Settings</h1>
                    <p class="text-muted small mb-0">Configure site-wide values: branding, contact, appearance and
                        integrations.</p>
                </div>
                <div>
                    <button type="submit" form="site-settings-form" class="btn px-4 py-2 rounded-pill text-white"
                        style="background: linear-gradient(135deg,#6D28D9,#2563EB); border: none; box-shadow: 0 6px 18px rgba(37,99,235,0.12);">
                        <i class="fas fa-save me-2"></i> Save Settings
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form id="site-settings-form" action="{{ route('admin.settings.update') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="row gx-4">
                    <div class="col-lg-7">
                        <div class="card mb-3 shadow-sm border-0" style="border-radius:12px;">
                            <div class="card-body">
                                <h5 class="mb-3" style="font-weight:600">General</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small">Site Name</label>
                                        <input type="text" name="site_name" class="form-control rounded-3 shadow-sm"
                                            value="{{ old('site_name', $settings->site_name) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small">Tagline</label>
                                        <input type="text" name="site_tagline" class="form-control rounded-3 shadow-sm"
                                            value="{{ old('site_tagline', $settings->site_tagline) }}">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small">Footer Text</label>
                                    <input type="text" name="footer_text" class="form-control rounded-3 shadow-sm"
                                        value="{{ old('footer_text', $settings->footer_text) }}">
                                </div>
                                <div class="ms-3">
                                    <label class="form-label small mb-1">Favicon</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width:32px; height:32px;">
                                            @if (!empty($settings->favicon))
                                                <img src="{{ asset('storage/' . $settings->favicon) }}" alt="favicon"
                                                    style="width:32px; height:32px; object-fit:cover; border-radius:6px;">
                                            @endif
                                        </div>
                                        <input type="file" name="favicon" class="form-control form-control-sm"
                                            style="max-width:140px;">
                                    </div>
                                    <small class="text-muted d-block mt-1">Ideal size 32x32 — PNG, SVG, ICO
                                        accepted.</small>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3 shadow-sm border-0" style="border-radius:12px;">
                            <div class="card-body">
                                <h5 class="mb-3" style="font-weight:600">Contact</h5>
                                <div class="mb-3">
                                    <label class="form-label small">Contact Email</label>
                                    <input type="email" name="contact_email" class="form-control rounded-3 shadow-sm"
                                        value="{{ old('contact_email', $settings->contact_email) }}">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small">Phone</label>
                                        <input type="text" name="contact_phone" class="form-control rounded-3 shadow-sm"
                                            value="{{ old('contact_phone', $settings->contact_phone) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small">Support WhatsApp</label>
                                        <input type="text" name="support_whatsapp"
                                            class="form-control rounded-3 shadow-sm"
                                            value="{{ old('support_whatsapp', $settings->support_whatsapp) }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small">Address</label>
                                    <textarea name="address" class="form-control rounded-3 shadow-sm" rows="3">{{ old('address', $settings->address) }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small">Contact Hours</label>
                                    <textarea name="contact_hours" class="form-control rounded-3 shadow-sm" rows="2">{{ old('contact_hours', $settings->contact_hours) }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small">Social Links</label>
                                    <div class="row g-2">
                                        <div class="col-12 col-md-6 mb-2">
                                            <input type="url" name="social_links[instagram]"
                                                class="form-control rounded-3 shadow-sm" placeholder="Instagram URL"
                                                value="{{ old('social_links.instagram', $settings->social_links['instagram'] ?? '') }}">
                                        </div>
                                        <div class="col-12 col-md-6 mb-2">
                                            <input type="url" name="social_links[facebook]"
                                                class="form-control rounded-3 shadow-sm" placeholder="Facebook URL"
                                                value="{{ old('social_links.facebook', $settings->social_links['facebook'] ?? '') }}">
                                        </div>
                                        <div class="col-12 col-md-6 mb-2">
                                            <input type="url" name="social_links[twitter]"
                                                class="form-control rounded-3 shadow-sm" placeholder="Twitter URL"
                                                value="{{ old('social_links.twitter', $settings->social_links['twitter'] ?? '') }}">
                                        </div>
                                        <div class="col-12 col-md-6 mb-2">
                                            <input type="url" name="social_links[youtube]"
                                                class="form-control rounded-3 shadow-sm" placeholder="YouTube URL"
                                                value="{{ old('social_links.youtube', $settings->social_links['youtube'] ?? '') }}">
                                        </div>
                                        <div class="col-12 mb-2">
                                            <input type="url" name="social_links[linkedin]"
                                                class="form-control rounded-3 shadow-sm" placeholder="LinkedIn URL"
                                                value="{{ old('social_links.linkedin', $settings->social_links['linkedin'] ?? '') }}">
                                        </div>
                                    </div>
                                    <small class="text-muted">Enter full URLs for each social profile (leave blank to
                                        skip).</small>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3 shadow-sm border-0" style="border-radius:12px;">
                            <div class="card-body">
                                <h5 class="mb-3" style="font-weight:600">Appearance & SEO</h5>
                                <div class="mb-3">
                                    <label class="form-label small">Primary Color</label>
                                    <input type="color" name="primary_color"
                                        class="form-control form-control-color rounded-3"
                                        value="{{ old('primary_color', $settings->primary_color ?? '#2563EB') }}"
                                        style="width: 80px; padding: .25rem;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small">Meta Title</label>
                                    <input type="text" name="meta_title" class="form-control rounded-3 shadow-sm"
                                        value="{{ old('meta_title', $settings->meta_title) }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small">Meta Description</label>
                                    <textarea name="meta_description" class="form-control rounded-3 shadow-sm" rows="3">{{ old('meta_description', $settings->meta_description) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn px-4 py-2 rounded-pill text-white"
                                style="background: linear-gradient(135deg,#6D28D9,#2563EB);">
                                <i class="fas fa-save me-2"></i> Save Settings
                            </button>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="sticky-top">
                            <div class="card mb-3 shadow-sm border-0" style="border-radius:12px;">
                                <div class="card-body">
                                    <h5 class="mb-3" style="font-weight:600">Advanced</h5>
                                    <div class="mb-3">
                                        <label class="form-label small">Analytics / Tracking Code</label>
                                        <textarea name="analytics_code" class="form-control rounded-3 shadow-sm" rows="4">{{ old('analytics_code', $settings->analytics_code) }}</textarea>
                                        <small class="text-muted">Paste script or ID (will be rendered in
                                            front-end).</small>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="hidden" name="maintenance_mode" value="0">
                                        <input type="checkbox" name="maintenance_mode" value="1"
                                            class="form-check-input" id="maintenance_mode"
                                            {{ old('maintenance_mode', $settings->maintenance_mode) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="maintenance_mode">Maintenance mode</label>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="hidden" name="enable_registration" value="0">
                                        <input type="checkbox" name="enable_registration" value="1"
                                            class="form-check-input" id="enable_registration"
                                            {{ old('enable_registration', $settings->enable_registration) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="enable_registration">Allow
                                            registrations</label>
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow-sm mb-3 border-0" style="border-radius:12px;">
                                <div class="p-4 bg-white rounded-4 shadow-sm border"
                                    style="box-shadow: 0 4px 24px rgba(37,99,235,0.07); border:1px solid #e5e7eb;">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="bg-light d-flex align-items-center justify-content-center"
                                            style="width:64px; height:64px; border-radius:12px; border:1px solid #e5e7eb;">
                                            @if ($settings->logo)
                                                <img src="{{ asset('storage/' . $settings->logo) }}" alt="logo"
                                                    style="width:56px; height:56px; object-fit:cover; border-radius:10px;">
                                            @else
                                                <i class="fas fa-palette fa-lg" style="color:#2563EB"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="mb-0 fw-bold" style="color:#2563EB;">
                                                {{ $settings->site_name ?? 'GlowHub' }}</h4>
                                            <span class="text-muted small">{{ $settings->site_tagline }}</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="fas fa-map-marker-alt me-2" style="color:#2563EB"></i>
                                            <span class="text-muted small">{{ Str::limit($settings->address, 80) }}</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="fas fa-phone me-2" style="color:#2563EB"></i>
                                            <span class="text-muted small">{{ $settings->contact_phone }}</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="fas fa-envelope me-2" style="color:#2563EB"></i>
                                            <span class="text-muted small">{{ $settings->contact_email }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="form-label small fw-semibold mb-1">Change Logo</label>
                                        <input type="file" name="logo"
                                            class="form-control form-control-sm rounded-3 shadow-sm"
                                            style="max-width:180px;">
                                        <small class="text-muted d-block mt-1">Upload PNG/WebP (max 2MB). Preview shown
                                            above.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow-sm" style="border-radius:12px;">
                                <div class="card-body">
                                    <h6 style="font-weight:600">Social</h6>
                                    <div class="d-flex gap-2 mt-2">
                                        @if (!empty($settings->social_links['instagram']))
                                            <a href="{{ $settings->social_links['instagram'] }}" target="_blank"
                                                class="btn btn-outline-light border rounded-circle p-2"
                                                style="border-color:#F3F4F6"><i class="fab fa-instagram"
                                                    style="color:#E1306C"></i></a>
                                        @endif
                                        @if (!empty($settings->social_links['facebook']))
                                            <a href="{{ $settings->social_links['facebook'] }}" target="_blank"
                                                class="btn btn-outline-light border rounded-circle p-2"
                                                style="border-color:#F3F4F6"><i class="fab fa-facebook-f"
                                                    style="color:#1877F2"></i></a>
                                        @endif
                                        @if (!empty($settings->social_links['twitter']))
                                            <a href="{{ $settings->social_links['twitter'] }}" target="_blank"
                                                class="btn btn-outline-light border rounded-circle p-2"
                                                style="border-color:#F3F4F6"><i class="fab fa-twitter"
                                                    style="color:#1DA1F2"></i></a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

@endsection
