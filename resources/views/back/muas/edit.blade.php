@extends('back._parts.master')
@section('page-title', 'Edit MUA')
@section('content')
    @php
        $base = Auth::check() && Auth::user()->role === 'admin' ? 'admin/muas' : 'muas';
    @endphp
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">Edit MUA</h1>
            <p class="text-muted small mb-0">Update MUA profile and manage services/portfolio.</p>
        </div>
        <a href="{{ url($base) }}" class="btn px-3 py-2" style="background:white; border:1px solid #E5E7EB; color:#374151;">
            <i class="fas fa-arrow-left me-2"></i>Back to list
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="{{ url($base . '/' . $mua->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('back.muas._form')

                <div class="mt-3 d-flex justify-content-between">
                    <button class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-header">
            <h4 class="text-primary">Quick Add Service</h4>
        </div>
        <div class="card-body p-4">
            <!-- Quick add service -->
            <form method="POST" action="{{ url($base . '/' . $mua->id . '/services') }}">
                @csrf
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label small">Service Name</label>
                        <input type="text" name="nama_service" class="form-control" placeholder="Service name" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small">Price</label>
                        <input type="number" name="harga" class="form-control" placeholder="Price">
                    </div>
                    <div class="col-12">
                        <label class="form-label small">Description</label>
                        <textarea name="deskripsi" class="form-control" placeholder="Description" rows="3"></textarea>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small">Features</label>
                        <div id="features-list">
                            <div class="input-group mb-2 feature-item">
                                <input type="text" name="features[name][]" class="form-control" placeholder="Feature">
                                <button type="button" class="btn btn-outline-danger remove-feature" tabindex="-1">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="input-group mb-2 feature-item">
                                <input type="number" name="features[min_price][]" class="form-control" placeholder="Min Price">
                            </div>
                            <div class="input-group mb-2 feature-item">
                                <input type="number" name="features[max_price][]" class="form-control" placeholder="Max Price">
                            </div>
                            <div class="input-group mb-2 feature-item">
                                <div class="form-check">
                                    <input type="checkbox" name="features[brands][]" class="form-check-input">
                                    <label class="form-check-label">Brands</label>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="add-feature">
                            <i class="fas fa-plus"></i> Add Feature
                        </button>
                        <small class="text-muted d-block mt-1">Add as many features as you want for this service.</small>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Occasions</label>
                        @php
                            $occasionOptions = [
                                'Akad',
                                'Wedding (Resepsi)',
                                'Prewedding',
                                'Engagement/Lamaran',
                                'Wedding Guest',
                                'Party',
                                'Bridesmaid',
                                'Graduation',
                                'Graduation Companion',
                                'Maternity Shoot',
                                'Photoshoot',
                                'Family Makeup',
                                'Event',
                            ];
                            $selectedOccasions = old('categori_service', []);
                            if (!is_array($selectedOccasions)) {
                                $selectedOccasions = (array) $selectedOccasions;
                            }
                        @endphp
                        <div class="row g-2">
                            @foreach ($occasionOptions as $opt)
                                @php
                                    $id = 'occasion-' . \Illuminate\Support\Str::slug($opt);
                                @endphp
                                <div class="col-6">
                                    <div class="form-check">
                                        <input type="checkbox" name="categori_service[]" value="{{ $opt }}"
                                            id="{{ $id }}" class="form-check-input"
                                            {{ in_array($opt, $selectedOccasions, true) ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="{{ $id }}">{{ $opt }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <small class="text-muted d-block mt-1">Pilih satu atau lebih occasion yang sesuai untuk service
                            ini.</small>
                        @if ($errors->has('categori_service'))
                            <div class="invalid-feedback d-block">{{ $errors->first('categori_service') }}</div>
                        @endif
                    </div>
                </div>

                @push('scripts')
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const featuresList = document.getElementById('features-list');
                            const addFeatureBtn = document.getElementById('add-feature');

                            addFeatureBtn.addEventListener('click', function() {
                                const featureItem = document.createElement('div');
                                featureItem.className = 'input-group mb-2 feature-item';
                                featureItem.innerHTML = `
                                    <input type="text" name="features[name][]" class="form-control" placeholder="Feature">
                                    <button type="button" class="btn btn-outline-danger remove-feature" tabindex="-1">
                                        <i class="fas fa-times"></i>
                                    </button>
                                `;
                                featuresList.appendChild(featureItem);

                                const minPriceItem = document.createElement('div');
                                minPriceItem.className = 'input-group mb-2 feature-item';
                                minPriceItem.innerHTML = `
                                    <input type="number" name="features[min_price][]" class="form-control" placeholder="Min Price">
                                `;
                                featuresList.appendChild(minPriceItem);

                                const maxPriceItem = document.createElement('div');
                                maxPriceItem.className = 'input-group mb-2 feature-item';
                                maxPriceItem.innerHTML = `
                                    <input type="number" name="features[max_price][]" class="form-control" placeholder="Max Price">
                                `;
                                featuresList.appendChild(maxPriceItem);

                                const brandsItem = document.createElement('div');
                                brandsItem.className = 'input-group mb-2 feature-item';
                                brandsItem.innerHTML = `
                                    <div class="form-check">
                                        <input type="checkbox" name="features[brands][]" class="form-check-input">
                                        <label class="form-check-label">Brands</label>
                                    </div>
                                `;
                                featuresList.appendChild(brandsItem);
                            });

                            featuresList.addEventListener('click', function(e) {
                                if (e.target.closest('.remove-feature')) {
                                    const item = e.target.closest('.feature-item');
                                    if (featuresList.children.length > 1) {
                                        item.remove();
                                    } else {
                                        item.querySelector('input').value = '';
                                    }
                                }
                            });
                        });
                    </script>
                @endpush
                <div class="d-flex justify-content-end">
                    <button class="btn btn-outline-primary">Add Service</button>
                </div>
            </form>
            <hr class="my-4">

            <h5>Services & Portfolios</h5>

            @if ($mua->services->count())
                <div class="row row-cols-1 row-cols-md-2 g-3">
                    @foreach ($mua->services as $s)
                        <div class="col-12">
                            <div class="card h-100 shadow-sm border-0">
                                {{-- compact header with toggle --}}
                                <div
                                    class="card-body p-3 border-bottom bg-white d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="d-flex align-items-center gap-3">
                                            <button type="button" class="btn btn-sm btn-outline-secondary service-toggle"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#service-collapse-{{ $s->id }}" aria-expanded="true"
                                                aria-controls="service-collapse-{{ $s->id }}">
                                                <i class="fas fa-chevron-up"></i>
                                            </button>
                                            <div class="ml-2">
                                                <h5 class="card-title mb-0">{{ $s->service_name }}</h5>
                                                <div class="small text-muted">Rp {{ number_format($s->price) }}</div>
                                                @php
                                                    $categories = [];
                                                    if (!empty($s->categori_service)) {
                                                        if (is_array($s->categori_service)) {
                                                            $categories = $s->categori_service;
                                                        } else {
                                                            $decodedCat = json_decode($s->categori_service, true);
                                                            if (is_array($decodedCat)) {
                                                                $categories = $decodedCat;
                                                            } elseif (is_string($s->categori_service)) {
                                                                $categories = [$s->categori_service];
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                @if (!empty($categories))
                                                    <div class="small text-muted mt-1">
                                                        {{ implode(' • ', $categories) }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <form action="{{ url($base . '/' . $mua->id . '/services/' . $s->id) }}"
                                            method="POST" onsubmit="return confirm('Remove service?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">Remove</button>
                                        </form>
                                    </div>
                                </div>

                                <div id="service-collapse-{{ $s->id }}" class="collapse show">
                                    <div class="card-body">
                                        <form method="POST" action="{{ url($base . '/' . $mua->id . '/services/' . $s->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label small">Service Name</label>
                                                    <input type="text" name="nama_service" class="form-control" value="{{ $s->service_name }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">Price</label>
                                                    <input type="number" name="harga" class="form-control" value="{{ $s->price }}">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label small">Description</label>
                                                    <textarea name="deskripsi" class="form-control" rows="3">{{ $s->description }}</textarea>
                                                </div>
                                                @php
                                                    $features = [];
                                                    if (!empty($s->features)) {
                                                        if (is_array($s->features)) {
                                                            $features = $s->features;
                                                        } else {
                                                            $features = json_decode($s->features, true) ?? [];
                                                            if (!is_array($features)) {
                                                                $features = [];
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                <div class="col-md-6">
                                                    <label class="form-label small">Features</label>
                                                    <div id="features-list-2">
                                                        @foreach ($features as $index => $feature)
                                                            <div class="input-group mb-2 feature-item">
                                                                <input type="text" name="features[name][]" class="form-control" placeholder="Feature">
                                                                <button type="button" class="btn btn-outline-danger remove-feature" tabindex="-1" value="{{ $feature['name'][$index] }}">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </div>
                                                            <div class="input-group mb-2 feature-item">
                                                                <input type="number" name="features[min_price][]" class="form-control" placeholder="Min Price" value="{{ $feature['min_price'][$index] }}">
                                                            </div>
                                                            <div class="input-group mb-2 feature-item">
                                                                <input type="number" name="features[max_price][]" class="form-control" placeholder="Max Price" value="{{ $feature['max_price'][$index] }}">
                                                            </div>
                                                            <div class="input-group mb-2 feature-item">
                                                                <div class="form-check">
                                                                    <input type="checkbox" name="features[mandatory][]" class="form-check-input" value="{{ $feature['mandatory'][$index] }}">
                                                                    <label class="form-check-label">Mandatory</label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="add-feature-2">
                                                        <i class="fas fa-plus"></i> Add Feature
                                                    </button>
                                                    <small class="text-muted d-block mt-1">Add as many features as you want for this service.</small>
                                                    @push('scripts')
                                                        <script>
                                                            document.addEventListener('DOMContentLoaded', function() {
                                                                const featuresList = document.getElementById('features-list-2');
                                                                const addFeatureBtn = document.getElementById('add-feature-2');

                                                                addFeatureBtn.addEventListener('click', function() {
                                                                    const featureItem = document.createElement('div');
                                                                    featureItem.className = 'input-group mb-2 feature-item';
                                                                    featureItem.innerHTML = `
                                                                        <input type="text" name="features[name][]" class="form-control" placeholder="Feature">
                                                                        <button type="button" class="btn btn-outline-danger remove-feature" tabindex="-1">
                                                                            <i class="fas fa-times"></i>
                                                                        </button>
                                                                    `;
                                                                    featuresList.appendChild(featureItem);

                                                                    const minPriceItem = document.createElement('div');
                                                                    minPriceItem.className = 'input-group mb-2 feature-item';
                                                                    minPriceItem.innerHTML = `
                                                                        <input type="number" name="features[min_price][]" class="form-control" placeholder="Min Price">
                                                                    `;
                                                                    featuresList.appendChild(minPriceItem);

                                                                    const maxPriceItem = document.createElement('div');
                                                                    maxPriceItem.className = 'input-group mb-2 feature-item';
                                                                    maxPriceItem.innerHTML = `
                                                                        <input type="number" name="features[max_price][]" class="form-control" placeholder="Max Price">
                                                                    `;
                                                                    featuresList.appendChild(maxPriceItem);

                                                                    const brandsItem = document.createElement('div');
                                                                    brandsItem.className = 'input-group mb-2 feature-item';
                                                                    brandsItem.innerHTML = `
                                                                        <div class="form-check">
                                                                            <input type="checkbox" name="features[brands][]" class="form-check-input" id="brands-checkbox-{{ $loop->index }}" required>
                                                                            <label class="form-check-label" for="brands-checkbox-{{ $loop->index }}">Brands</label>
                                                                        </div>
                                                                    `;
                                                                    featuresList.appendChild(brandsItem);
                                                                });

                                                                featuresList.addEventListener('click', function(e) {
                                                                    if (e.target.closest('.remove-feature')) {
                                                                        const item = e.target.closest('.feature-item');
                                                                        if (featuresList.children.length > 1) {
                                                                            item.remove();
                                                                        } else {
                                                                            item.querySelector('input').value = '';
                                                                        }
                                                                    }
                                                                });
                                                            });
                                                        </script>
                                                    @endpush
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Occasions</label>
                                                    @php
                                                        $occasionOptions = [
                                                            'Akad',
                                                            'Wedding (Resepsi)',
                                                            'Prewedding',
                                                            'Engagement/Lamaran',
                                                            'Wedding Guest',
                                                            'Party',
                                                            'Bridesmaid',
                                                            'Graduation',
                                                            'Graduation Companion',
                                                            'Maternity Shoot',
                                                            'Photoshoot',
                                                            'Family Makeup',
                                                            'Event',
                                                        ];
                                                        $categories = [];
                                                        if (!empty($s->categori_service)) {
                                                            if (is_array($s->categori_service)) {
                                                                $categories = $s->categori_service;
                                                            } else {
                                                                $decodedCat = json_decode($s->categori_service, true);
                                                                if (is_array($decodedCat)) {
                                                                    $categories = $decodedCat;
                                                                } else {
                                                                    $categories = explode(',', $s->categori_service);
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                    <div class="row g-2">
                                                        @foreach ($occasionOptions as $opt)
                                                            @php
                                                                $idOcc = 'occasion-edit-' . $s->id . '-' . \Illuminate\Support\Str::slug($opt);
                                                            @endphp
                                                            <div class="col-6">
                                                                <div class="form-check">
                                                                    <input type="checkbox" name="categori_service[]" value="{{ $opt }}" id="{{ $idOcc }}" class="form-check-input" {{ in_array($opt, $categories, true) ? 'checked' : '' }}>
                                                                    <label class="form-check-label small" for="{{ $idOcc }}">{{ $opt }}</label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <small class="text-muted d-block mt-1">Pilih occasion untuk service ini.</small>
                                                </div>
                                                <div class="col-12 d-flex justify-content-end">
                                                    <button class="btn btn-sm btn-primary">Update Service</button>
                                                </div>
                                            </div>
                                        </form>

                                        {{-- Portfolio gallery for this service --}}
                                        @php
                                            $servicePortfolios = $mua->portfolios->where('mua_service_id', $s->id);
                                        @endphp
                                        <div class="mt-3">
                                            @if ($servicePortfolios->count())
                                                <div class="row g-2">
                                                    @foreach ($servicePortfolios as $p)
                                                        <div class="col-6 col-sm-4 col-md-3">
                                                            <div class="card border-0">
                                                                @if ($p->image)
                                                                    <img src="{{ asset('uploads/' . $p->image) }}"
                                                                        class="img-fluid rounded"
                                                                        style="object-fit:cover; height:120px; width:100%;">
                                                                @else
                                                                    <div class="bg-light d-flex align-items-center justify-content-center"
                                                                        style="height:120px;">No image</div>
                                                                @endif
                                                                <div class="card-body p-2 small">
                                                                    <form method="POST" action="{{ url($base . '/' . $mua->id . '/portfolios/' . $p->id) }}">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="text" name="description" class="form-control form-control-sm mb-2" value="{{ $p->description }}" placeholder="Description">
                                                                        <div class="d-flex gap-1">
                                                                            <button class="btn btn-sm btn-primary flex-fill">Update</button>
                                                                        </div>
                                                                    </form>
                                                                    <form
                                                                        action="{{ url($base . '/' . $mua->id . '/portfolios/' . $p->id) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Remove?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button
                                                                            class="btn btn-sm btn-outline-danger w-100 mt-2">Remove</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="text-muted small">No portfolios for this service yet.</div>
                                            @endif
                                        </div>

                                        {{-- Upload form for this specific service --}}
                                        <div class="mt-3">
                                            <form method="POST"
                                                action="{{ url($base . '/' . $mua->id . '/portfolios') }}"
                                                enctype="multipart/form-data" class="d-flex gap-2 align-items-center">
                                                @csrf
                                                <input type="hidden" name="mua_service_id" value="{{ $s->id }}">
                                                <input type="file" name="images[]"
                                                    class="form-control form-control-sm portfolio-input" accept="image/*"
                                                    multiple required>
                                                <input type="text" name="description"
                                                    class="form-control form-control-sm"
                                                    placeholder="Description (optional)">
                                                <button class="btn btn-sm btn-outline-primary">Upload</button>
                                            </form>
                                            <div class="mt-2 preview-container"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">No services yet. Use the "Add Service" box above to create one.</p>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ url($base) }}" class="btn px-3 py-2"
                style="background:white; border:1px solid #E5E7EB; color:#374151;">
                <i class="fas fa-arrow-left me-2"></i>Back to list
            </a>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function bytesToSize(bytes) {
                const sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
                if (bytes === 0) return '0 B';
                const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)), 10);
                return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
            }

            document.querySelectorAll('.portfolio-input').forEach(function(input) {
                input.addEventListener('change', function(e) {
                    const files = Array.from(this.files || []);
                    const container = this.closest('form').nextElementSibling;
                    if (!container) return;
                    container.innerHTML = '';
                    if (!files.length) return;

                    const info = document.createElement('div');
                    info.className = 'small text-muted mb-2';
                    info.textContent = files.length + ' file(s) selected, total ' + bytesToSize(
                        files.reduce((s, f) => s + f.size, 0));
                    container.appendChild(info);

                    const row = document.createElement('div');
                    row.className = 'row g-2';
                    files.forEach(function(file) {
                        const col = document.createElement('div');
                        col.className = 'col-auto';
                        const thumb = document.createElement('div');
                        thumb.style.width = '90px';
                        thumb.style.height = '70px';
                        thumb.style.overflow = 'hidden';
                        thumb.style.borderRadius = '6px';
                        thumb.style.background = '#f3f4f6';
                        thumb.className =
                            'd-flex align-items-center justify-content-center';

                        const img = document.createElement('img');
                        img.style.width = '100%';
                        img.style.height = '100%';
                        img.style.objectFit = 'cover';
                        img.alt = file.name;

                        const reader = new FileReader();
                        reader.onload = function(ev) {
                            img.src = ev.target.result;
                        };
                        reader.readAsDataURL(file);

                        thumb.appendChild(img);
                        col.appendChild(thumb);
                        row.appendChild(col);
                    });
                    container.appendChild(row);
                });
            });

            // collapse toggle icons
            document.querySelectorAll('.service-toggle').forEach(function(btn) {
                const targetSelector = btn.getAttribute('data-bs-target') || btn.getAttribute(
                    'data-target');
                const target = document.querySelector(targetSelector);
                if (!target) return;

                // ensure button does not submit forms
                if (!btn.hasAttribute('type')) {
                    btn.setAttribute('type', 'button');
                }

                // click handler to toggle collapse (handles Bootstrap 5, Bootstrap 4/jQuery, or DOM-only fallback)
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    try {
                        // If Bootstrap 5 is present and provides Collapse.getInstance
                        if (window.bootstrap && bootstrap.Collapse) {
                            if (typeof bootstrap.Collapse.getInstance === 'function') {
                                let inst = bootstrap.Collapse.getInstance(target);
                                if (!inst) inst = new bootstrap.Collapse(target, {
                                    toggle: false
                                });
                                inst.toggle();
                                return;
                            }

                            // If bootstrap.Collapse exists but doesn't have getInstance, try instantiating
                            try {
                                const inst = new bootstrap.Collapse(target, {
                                    toggle: false
                                });
                                if (inst && typeof inst.toggle === 'function') {
                                    inst.toggle();
                                    return;
                                }
                            } catch (err) {
                                // continue to jQuery fallback
                            }
                        }

                        // Bootstrap 4 / jQuery fallback
                        if (window.jQuery) {
                            jQuery(target).collapse('toggle');
                            return;
                        }

                        // Final DOM-only fallback
                        const willShow = !target.classList.contains('show');
                        target.classList.toggle('show');
                        target.dispatchEvent(new Event(willShow ? 'show.bs.collapse' :
                            'hide.bs.collapse'));
                    } catch (err) {
                        console.error('Collapse toggle failed:', err);
                    }
                });

                // set initial icon based on collapse state
                const icon = btn.querySelector('i');
                if (target.classList.contains('show')) {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                } else {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                }

                // listen bootstrap collapse events (or custom dispatched fallback events)
                target.addEventListener('show.bs.collapse', function() {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                });
                target.addEventListener('hide.bs.collapse', function() {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                });
            });
        });
    </script>
@endpush
