@extends('auth.master')

@section('content')
    <div class="auth-box row text-center" style="min-width: 800px;">
        <div class="col-lg-7 col-md-5 modal-bg-img" style="background-image: url(admin/assets/images/big/3.jpg);">
        </div>
        <div class="col-lg-5 col-md-7 bg-white">
            <div class="p-3">
                <img src="admin/assets/images/big/icon.png" alt="wrapkit">
                <h2 class="mt-3 text-center">Sign Up for Free</h2>
                <form class="mt-4" method="POST" action="{{ route('auth.register') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="mb-2 font-weight-bold">Select Your Role</label>
                                <div class="d-flex justify-content-between gap-3">
                                    <label class="role-card card flex-fill mx-1 p-3 text-center"
                                        style="cursor:pointer; border-radius: 1rem;">
                                        <input type="radio" name="role" value="member" required class="d-none"
                                            id="role-member" />
                                        <div class="role-content">
                                            <span class="role-icon mb-2">
                                                <i class="fa fa-user fa-2x text-primary"></i>
                                            </span>
                                            <div class="font-weight-bold mt-2">Member</div>
                                            <small class="text-muted d-block mt-1">For regular users</small>
                                        </div>
                                    </label>
                                    <label class="role-card card flex-fill mx-1 p-3 text-center"
                                        style="cursor:pointer; border-radius: 1rem;">
                                        <input type="radio" name="role" value="mua" required class="d-none"
                                            id="role-mua" />
                                        <div class="role-content">
                                            <span class="role-icon mb-2">
                                                <i class="fa fa-magic fa-2x text-danger"></i>
                                            </span>
                                            <div class="font-weight-bold mt-2">MUA</div>
                                            <small class="text-muted d-block mt-1">Make Up Artist</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <style>
                            .role-card {
                                border: 2px solid #eee;
                                transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
                                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
                                position: relative;
                            }

                            .role-card .role-content {
                                pointer-events: none;
                            }

                            .role-card.selected {
                                border-color: #007bff;
                                background: linear-gradient(135deg, #e3f2fd 0%, #fff 100%);
                                box-shadow: 0 0 0 3px #007bff33;
                            }

                            .role-card:hover {
                                border-color: #80bdff;
                                box-shadow: 0 0 0 2px #80bdff33;
                            }

                            .role-icon {
                                display: inline-block;
                                background: #f8f9fa;
                                border-radius: 50%;
                                padding: 10px;
                                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.07);
                            }

                            .gap-3 {
                                gap: 1.5rem;
                            }
                        </style>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                function toggleFields() {
                                    var selected = document.querySelector('.role-card input[type="radio"]:checked');
                                    var fields = document.getElementById('register-fields');
                                    if (selected) {
                                        fields.style.display = '';
                                    } else {
                                        fields.style.display = 'none';
                                    }
                                }
                                document.querySelectorAll('.role-card input[type="radio"]').forEach(function(input) {
                                    input.addEventListener('change', function() {
                                        document.querySelectorAll('.role-card').forEach(function(card) {
                                            card.classList.remove('selected');
                                        });
                                        if (input.checked) {
                                            input.closest('.role-card').classList.add('selected');
                                        }
                                        toggleFields();
                                    });
                                    // Preselect if already checked (for validation error reload)
                                    if (input.checked) {
                                        input.closest('.role-card').classList.add('selected');
                                    }
                                });
                                // Initial state
                                toggleFields();
                            });
                        </script>
                        <div id="register-fields" style="display:none; width:100%;">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="name" placeholder="Your Name"
                                        required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="username" placeholder="Username (no spaces or special characters)"
                                        pattern="^[a-zA-Z0-9_-]+$" title="Username can only contain letters, numbers, underscores, and hyphens"
                                        required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input class="form-control" type="email" name="email" placeholder="Email Address"
                                        required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input class="form-control" type="password" name="password" placeholder="Password"
                                        required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input class="form-control" type="password" name="password_confirmation"
                                        placeholder="Confirm Password" required>
                                </div>
                            </div>
                            <div class="col-lg-12 text-center">
                                <button type="submit" class="btn btn-block btn-dark">Sign Up</button>
                            </div>
                            <div class="col-lg-12 text-center mt-5">
                                Already have an account? <a href="{{ route('login') }}" class="text-danger">Sign In</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
