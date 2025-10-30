@extends('auth.master')

@section('content')
    <div class="auth-box row">
        <div class="col-lg-7 col-md-5 modal-bg-img" style="background-image: url(admin/assets/images/big/3.jpg);">
        </div>
        <div class="col-lg-5 col-md-7 bg-white">
            <div class="p-3">
                <div class="text-center">
                    <img src="admin/assets/images/big/icon.png" alt="wrapkit">
                </div>
                <h2 class="mt-3 text-center">Sign In</h2>
                <p class="text-center">Enter your email address and password to access admin panel.</p>
                <form class="mt-4" method="POST" action="{{ route('auth.login') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="text-dark" for="login">Username or Email</label>
                                <input class="form-control @error('login') is-invalid @enderror" id="login"
                                    name="login" type="text" value="{{ old('login') }}"
                                    placeholder="Enter your username or email" required autofocus>
                                @error('login')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="text-dark" for="password">Password</label>
                                <input class="form-control @error('password') is-invalid @enderror" id="password"
                                    name="password" type="password" placeholder="Enter your password" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn btn-block btn-dark">Sign In</button>
                        </div>
                        <div class="col-lg-12 text-center mt-5">
                            Don't have an account? <a href="{{ route('register') }}" class="text-danger">Sign Up</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
