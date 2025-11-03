@extends('back._parts.master')
@section('page-title', 'My Profile')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">My Profile</h1>
            <p class="text-muted small mb-0">Update your profile information. Keep it concise and professional.</p>
        </div>
        <a href="{{ url('/dashboard') }}" class="btn btn-outline-secondary">Back to site</a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ url('profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-4 text-center">
                                <div class="mb-3">
                                    @php $avatarUrl = $user->profile_image ? asset('storage/'.$user->profile_image) : asset('admin/assets/images/users/d1.jpg'); @endphp
                                    <img src="{{ $avatarUrl }}" id="avatarPreview" alt="avatar" class="rounded-circle"
                                        style="width:140px;height:140px;object-fit:cover;border:1px solid #e9ecef;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small d-block">Upload Avatar</label>
                                    <input type="file" name="profile_image" id="avatarInput"
                                        class="form-control form-control-sm">
                                    @if ($errors->has('profile_image'))
                                        <div class="invalid-feedback d-block">{{ $errors->first('profile_image') }}</div>
                                    @endif
                                </div>
                                <p class="text-muted small">Square image, at least 300x300 recommended.</p>
                            </div>

                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Full name</label>
                                    <input type="text" name="name"
                                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                        value="{{ old('name', $user->name) }}" required>
                                    @if ($errors->has('name'))
                                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username"
                                        class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
                                        value="{{ old('username', $user->username) }}" required>
                                    @if ($errors->has('username'))
                                        <div class="invalid-feedback">{{ $errors->first('username') }}</div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email"
                                        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                        value="{{ old('email', $user->email) }}" required>
                                    @if ($errors->has('email'))
                                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone"
                                        class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                        value="{{ old('phone', $user->phone) }}">
                                    @if ($errors->has('phone'))
                                        <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" rows="2" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}">{{ old('address', $user->address) }}</textarea>
                                    @if ($errors->has('address'))
                                        <div class="invalid-feedback">{{ $errors->first('address') }}</div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Birth Date</label>
                                    <input type="date" name="birth_date"
                                        class="form-control {{ $errors->has('birth_date') ? 'is-invalid' : '' }}"
                                        value="{{ old('birth_date', $user->birth_date ? $user->birth_date->format('Y-m-d') : '') }}">
                                    @if ($errors->has('birth_date'))
                                        <div class="invalid-feedback">{{ $errors->first('birth_date') }}</div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Gender</label>
                                    <select name="gender"
                                        class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}">
                                        <option value="">Select gender</option>
                                        <option value="male"
                                            {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female"
                                            {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female
                                        </option>
                                        <option value="other"
                                            {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @if ($errors->has('gender'))
                                        <div class="invalid-feedback">{{ $errors->first('gender') }}</div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Facebook</label>
                                    <input type="text" name="facebook"
                                        class="form-control {{ $errors->has('facebook') ? 'is-invalid' : '' }}"
                                        value="{{ old('facebook', $user->facebook) }}" placeholder="Facebook profile/link">
                                    @if ($errors->has('facebook'))
                                        <div class="invalid-feedback">{{ $errors->first('facebook') }}</div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Instagram</label>
                                    <input type="text" name="instagram"
                                        class="form-control {{ $errors->has('instagram') ? 'is-invalid' : '' }}"
                                        value="{{ old('instagram', $user->instagram) }}"
                                        placeholder="Instagram username/link">
                                    @if ($errors->has('instagram'))
                                        <div class="invalid-feedback">{{ $errors->first('instagram') }}</div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">TikTok</label>
                                    <input type="text" name="tiktok"
                                        class="form-control {{ $errors->has('tiktok') ? 'is-invalid' : '' }}"
                                        value="{{ old('tiktok', $user->tiktok) }}" placeholder="TikTok username/link">
                                    @if ($errors->has('tiktok'))
                                        <div class="invalid-feedback">{{ $errors->first('tiktok') }}</div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">LinkedIn</label>
                                    <input type="text" name="linkedin"
                                        class="form-control {{ $errors->has('linkedin') ? 'is-invalid' : '' }}"
                                        value="{{ old('linkedin', $user->linkedin) }}"
                                        placeholder="LinkedIn profile/link">
                                    @if ($errors->has('linkedin'))
                                        <div class="invalid-feedback">{{ $errors->first('linkedin') }}</div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Biodata (optional)</label>
                                    <textarea name="biodata" rows="3" class="form-control {{ $errors->has('biodata') ? 'is-invalid' : '' }}">{{ old('biodata', $user->biodata ?? '') }}</textarea>
                                    @if ($errors->has('biodata'))
                                        <div class="invalid-feedback">{{ $errors->first('biodata') }}</div>
                                    @endif
                                </div>

                                <div class="d-flex gap-2">
                                    <button class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ url('profile') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Change password (optional)</label>
                            <input type="password" name="password"
                                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                placeholder="New password">
                            @if ($errors->has('password'))
                                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                        <button class="btn btn-secondary btn-sm" type="submit">Update Password</button>
                    </form>
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Account</h4>
                    <p class="small text-muted mb-2">Role:</p>
                    <div
                        class="mb-3 {{ $user->role == 'admin' ? 'text-danger' : ($user->role == 'mua' ? 'text-primary' : ($user->role == 'member' ? 'text-success' : '')) }}">
                        <strong>{{ $user->role ?? '—' }}</strong>
                    </div>
                    <hr>
                    <p class="small text-muted">Last updated</p>
                    <div>{{ $user->updated_at ? $user->updated_at->format('Y-m-d H:i') : '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            (function() {
                const input = document.getElementById('avatarInput');
                const preview = document.getElementById('avatarPreview');
                if (!input || !preview) return;
                input.addEventListener('change', function() {
                    const file = this.files && this.files[0];
                    if (!file) return;
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                });
            })();
        </script>
    @endpush

@endsection
