<footer id="footer" style="padding-bottom: 0px !important;margin-top: 0px !important;margin-bottom: 35px !important;">
</footer>
<div id="footer-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="copyright">
                    <div class="row">

                        <div class="col-md-6">
                            <p>©2025 All rights reserved by <a href="https://www.kodeku.id/" target="_blank">GlowHub</a>
                            </p>
                        </div>

                        <div class="col-md-6">
                            @php
                                // Prefer the view-provided $siteSetting when available.
                                $setting = isset($siteSetting) ? $siteSetting : \App\Models\SiteSetting::first();
                                $socialLinks = $setting->social_links ?? [];
                                if (!is_array($socialLinks)) {
                                    $decoded = json_decode($socialLinks, true);
                                    $socialLinks = is_array($decoded) ? $decoded : [];
                                }

                                // Map known social names to icon classes (FontAwesome preferred).
                                $iconMap = [
                                    'facebook' => 'fab fa-facebook-f',
                                    'twitter' => 'fab fa-twitter',
                                    'youtube' => 'fab fa-youtube',
                                    'instagram' => 'fab fa-instagram',
                                    'linkedin' => 'fab fa-linkedin-in',
                                ];
                            @endphp
                            <div class="social-links align-right">
                                <ul>
                                    @foreach ($socialLinks as $name => $link)
                                        @php $key = strtolower(trim($name)); @endphp
                                        @if (!empty($link))
                                            <li>
                                                <a href="{{ $link }}" target="_blank" rel="noopener noreferrer">
                                                    @if (isset($iconMap[$key]))
                                                        <i class="{{ $iconMap[$key] }}"></i>
                                                    @else
                                                        {{-- fallback to legacy icon class used in project --}}
                                                        <i class="icon icon-{{ $key }}"></i>
                                                    @endif
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                    </div>
                </div><!--grid-->

            </div><!--footer-bottom-content-->
        </div>
    </div>
</div>
