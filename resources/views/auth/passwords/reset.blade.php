@extends('layouts.guest')

@section('content')
    <main class="authentication-content mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-4 mx-auto">
                    <div class="card shadow rounded-4 overflow-hidden">
                        <div class="card-body p-4 p-sm-5">
                            <h5 class="card-title">Genereate New Password</h5>
                            <p class="card-text mb-5">We received your reset password request. Please enter your new
                                password!</p>

                            <form class="form-body" method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="inputEmailAddress" class="form-label">Email Address</label>
                                        <div class="ms-auto position-relative">
                                            <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                                                <i class="bi bi-envelope-fill"></i>
                                            </div>
                                            <input type="email" name="email" value="{{ $email ?? old('email') }}"
                                                class="form-control radius-30 ps-5 @error('email') is-invalid @enderror"
                                                id="inputEmailAddress" placeholder="Email Address" required
                                                autocomplete="email" autofocus>
                                        </div>
                                        @error('email')
                                            <small class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </small>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="password" class="form-label">New Password</label>
                                        <div class="ms-auto position-relative">
                                            <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                                                <i class="bi bi-lock-fill"></i>
                                            </div>
                                            <input type="password" name="password"
                                                class="form-control radius-30 ps-5 @error('password') is-invalid @enderror"
                                                id="password" placeholder="Enter New Password" required
                                                autocomplete="new-password">
                                        </div>
                                        @error('password')
                                            <small class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </small>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="password-confirm" class="form-label">Confirm Password</label>
                                        <div class="ms-auto position-relative">
                                            <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                                                <i class="bi bi-lock-fill"></i>
                                            </div>
                                            <input type="password" name="password_confirmation"
                                                class="form-control radius-30 ps-5" id="password-confirm"
                                                placeholder="Confirm Password" required autocomplete="new-password">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary radius-30">Change Password</button>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <p class="text-center mb-0 mt-2">Remember your password? <a
                                                href="{{ route('login') }}">Sign In</a> </p>
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