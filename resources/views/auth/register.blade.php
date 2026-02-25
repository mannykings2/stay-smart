@extends('layouts.guest')

@section('content')
    <main class="authentication-content mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-5 mx-auto">
                    <div class="card shadow rounded-5 overflow-hidden">
                        <div class="card-body p-4 p-sm-5">
                            <h5 class="card-title">Create Your Account</h5>
                            <p class="text-muted small">Join StaySmart and start booking amazing properties</p>

                            @if (Session::has('message'))
                                <div class="alert alert-danger alert-dismissible show" role="alert">
                                    <strong>{{ Session::get('message') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible show" role="alert">
                                    <strong>{{ Session::get('success') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <form class="form-body" method="POST">
                                @csrf
                                <div class="row g-3 mt-3">
                                    <div class="col-12">
                                        <label for="inputEmailAddress" class="form-label">Email Address</label>
                                        <div class="ms-auto position-relative">
                                            <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                                                <i class="bi bi-envelope-fill"></i>
                                            </div>
                                            <input type="email" name="email" value="{{ session('invite_email') ?? request('email') ?? old('email') }}"
                                                class="form-control radius-30 ps-5 @error('email') is-invalid @enderror"
                                                id="inputEmailAddress" placeholder="Enter your email" autofocus required
                                                {{ session('invite_email') ? 'readonly' : '' }}>
                                        </div>
                                        @error('email')
                                            <small class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </small>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="inputChoosePassword" class="form-label">Password</label>
                                        <div class="ms-auto position-relative">
                                            <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                                                <i class="bi bi-lock-fill"></i>
                                            </div>
                                            <input type="password" name="password"
                                                class="form-control radius-30 ps-5 @error('password') is-invalid @enderror"
                                                id="inputChoosePassword" placeholder="Create a strong password" required>
                                        </div>
                                        @error('password')
                                            <small class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </small>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="inputConfirmPassword" class="form-label">Confirm Password</label>
                                        <div class="ms-auto position-relative">
                                            <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                                                <i class="bi bi-lock-fill"></i>
                                            </div>
                                            <input type="password" name="password_confirmation"
                                                class="form-control radius-30 ps-5" id="inputConfirmPassword"
                                                placeholder="Confirm your password" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary radius-30">Create Account</button>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="login-separater text-center mb-0"> <span>OR SIGN UP WITH EMAIL</span>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <a href="{{ route('auth.google') }}" class="btn btn-white radius-30 border d-flex align-items-center justify-content-center gap-2">
                                                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="" width="20">
                                                Continue with Google
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <p class="text-center text-muted small mb-0">
                                            <i class="bi bi-envelope-check me-1"></i>
                                            Check your email to verify and access your account
                                        </p>
                                    </div>
                                    <div class="col-12">
                                        <p class="text-center mb-0 mt-2">Already have an account? <a href="/login">Sign
                                                In</a> </p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection