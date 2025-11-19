<div class="row gx-4">
    <div class="col-lg-8">
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                value="{{ old('name', $user->name) }}" required>
            @if ($errors->has('name'))
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
            @endif
        </div>

        <div class="row gx-2">
            <div class="col-md-6 mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username"
                    class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
                    value="{{ old('username', $user->username) }}" required>
                @if ($errors->has('username'))
                    <div class="invalid-feedback">{{ $errors->first('username') }}</div>
                @endif
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email"
                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    value="{{ old('email', $user->email) }}" required>
                @if ($errors->has('email'))
                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                @endif
            </div>
        </div>

        <div class="row gx-2">
            <div class="col-md-6 mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password"
                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    {{ isset($user->id) ? '' : 'required' }}>
                @if ($errors->has('password'))
                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                @endif
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control"
                    {{ isset($user->id) ? '' : 'required' }}>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select {{ $errors->has('role') ? 'is-invalid' : '' }}">
                @php $roles = ['admin','mua','member']; @endphp
                @foreach ($roles as $r)
                    <option value="{{ $r }}" {{ old('role', $user->role) == $r ? 'selected' : '' }}>
                        {{ ucfirst($r) }}</option>
                @endforeach
            </select>
            @if ($errors->has('role'))
                <div class="invalid-feedback">{{ $errors->first('role') }}</div>
            @endif
        </div>

    </div>
    <div class="col-lg-4">
        <div class="card p-3">
            <label class="form-label small">Profile Image</label>
            @if (!empty($user->profile_image))
                <img src="{{ asset('uploads/' . $user->profile_image) }}" class="d-block mb-2"
                    style="width:100%; height: auto; object-fit:cover; border-radius:8px;">
            @endif
            <input type="file" name="profile_image" class="form-control">
            <small class="text-muted">Optional. PNG/JPG/WebP up to 2MB</small>
        </div>
    </div>
</div>
