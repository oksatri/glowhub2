@extends('_parts.master')

@section('content')
    <div class="auth-box row">
        <div class="col-lg-7 col-md-5 modal-bg-img" style="background-image: url(admin/assets/images/big/3.jpg);">
        </div>
        <div class="col-lg-5 col-md-7 bg-white">
            <div class="p-3">
                <div class="text-center">
                    <img src="admin/assets/images/big/icon.png" alt="wrapkit">
                </div>
                <h2 class="mt-3 text-center">Forgot Password</h2>
                <p class="text-center">Enter your email address.</p>
                <form class="mt-4" method="POST" action="{{ route('auth.forgot-password') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="text-dark" for="login">Email</label>
                                <input class="form-control @error('email') is-invalid @enderror" id="login"
                                    name="email" type="text" value="{{ old('email') }}" placeholder="Enter your email"
                                    required autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn btn-block btn-dark">Send Password Reset Link</button>
                        </div>
                        <div class="col-lg-12 text-center mt-5">
                            Already have an account? <a href="{{ route('login') }}" class="text-danger">Sign In</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
