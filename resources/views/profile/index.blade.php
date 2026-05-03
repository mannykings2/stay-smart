@extends('layouts.app', [$activePage = 'Profile'])

@section('content')
    <!--start content-->
    <main class="page-content" style="background: ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 mt-5">
                    <div class="card rounded-4 p-4 d-flex justify-content-between">
                        <h6 class="text-center">Update your Profile</h6>
                        <form action="{{route('update.profile')}}" method="POST">
                            @csrf
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <div class="input-area">
                                        <label class="d-lg-none mt-3" for="first_name">First Name</label>
                                            <input type="text" name="first_name" value="{{ old('first_name', optional(auth()->user())->first_name) }}"
                                            placeholder="First Name">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-area">
                                        <label class="d-lg-none mt-3" for="last_name">Last Name</label>
                                            <input type="text" name="last_name" value="{{ old('last_name', optional(auth()->user())->last_name) }}"
                                            placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-area">
                                        <label class="d-lg-none mt-3" for="gender">Gender</label>
                                        <select name="gender" class="form-control">
                                            <option value="">Select Gender</option>
                                            <option value="Male" {{auth()->user()->gender == 'Male' ? 'selected' : ''}}>Male
                                            </option>
                                            <option value="Female" {{auth()->user()->gender == 'Female' ? 'selected' : ''}}>
                                                Female</option>
                                            <option value="Other" {{auth()->user()->gender == 'Other' ? 'selected' : ''}}>
                                                Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-area">
                                        <label class="d-lg-none mt-3" for="phone_number">Phone Number</label>
                                        <input type="text" name="phone_number" value="{{auth()->user()->phone_number}}"
                                            placeholder="Phone Number">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="input-area">
                                        <label class="d-lg-none mt-3" for="Email">Email</label>
                                            <input type="email" name="Email" placeholder="Email"
                                                value="{{ old('email', optional(auth()->user())->email) }}" readonly>
                                    </div>
                                </div>

                            </div>
                            <button type="submit" href="{{route('properties.index')}}" role="button"
                                class="btn btn-primary rounded-3 px-3">Update</button>
                        </form>
                    </div>
                    <div class="card rounded-4 p-4 d-flex justify-content-between mt-5">
                        <h6 class="text-center">Change Password</h6>
                        <form action="{{route('update.password')}}" method="POST">
                            @csrf
                            <div class="row mb-4">
                                <div class="col-md-12 mb-3">
                                    <div class="input-area">
                                        <label class="d-lg-none mt-3" for="current_password">Current Password</label>
                                        <input type="password" name="current_password" placeholder="Enter Current Password" required>
                                        @error('current_password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-area">
                                        <label class="d-lg-none mt-3" for="new_password">New Password</label>
                                        <input type="password" name="new_password" placeholder="Enter New Password" required>
                                        @error('new_password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-area">
                                        <label class="d-lg-none mt-3" for="new_password_confirmation">Confirm Password</label>
                                        <input type="password" name="new_password_confirmation" placeholder="Confirm Password" required>
                                    </div>
                                </div>

                            </div>
                            <button type="submit" href="{{route('properties.index')}}" role="button"
                                class="btn btn-primary rounded-3 px-3">Update</button>
                        </form>
                    </div>

                    {{-- ID Verification Section --}}
                    <div class="card rounded-4 p-4 d-flex justify-content-between mt-5">
                        <h6 class="text-center">ID Verification</h6>

                        @php
                            $latestVerification = auth()->user()->latestIdVerification;
                        @endphp

                        {{-- Show current status --}}
                        @if(auth()->user()->isIdVerified() && $latestVerification && $latestVerification->isVerified())
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <i class="bi bi-patch-check-fill me-2 fs-5"></i>
                                <div>
                                    <strong>ID Verified</strong> — Your identity has been verified.
                                    <br><small class="text-muted">Verified on {{ $latestVerification->reviewed_at->format('M d, Y') }}</small>
                                </div>
                            </div>

                        @elseif($latestVerification && $latestVerification->isPending())
                            <div class="alert alert-warning d-flex align-items-center" role="alert">
                                <i class="bi bi-hourglass-split me-2 fs-5"></i>
                                <div>
                                    <strong>Pending Review</strong> — Your ID document is currently being reviewed.
                                    <br><small class="text-muted">Submitted: {{ $latestVerification->created_at->format('M d, Y h:i A') }}</small>
                                    <br><small class="text-muted">Document: {{ $latestVerification->original_filename }}</small>
                                </div>
                            </div>

                        @elseif($latestVerification && $latestVerification->isRejected())
                            <div class="alert alert-danger d-flex align-items-center mb-3" role="alert">
                                <i class="bi bi-x-circle-fill me-2 fs-5"></i>
                                <div>
                                    <strong>Verification Rejected</strong>
                                    <br><small>Reason: {{ $latestVerification->rejection_reason }}</small>
                                    <br><small class="text-muted">Rejected on {{ $latestVerification->reviewed_at->format('M d, Y') }}</small>
                                </div>
                            </div>

                            <p class="text-muted mb-3">You can re-upload a new document for verification below.</p>

                            <form action="{{ route('id-verification.upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="id_document" class="form-label">Upload New ID Document</label>
                                    <input type="file" class="form-control" id="id_document" name="id_document"
                                        accept=".pdf,.jpg,.jpeg,.png" required>
                                    <div class="form-text">Accepted formats: PDF, JPG, PNG. Maximum file size: 5MB.</div>
                                </div>
                                <button type="submit" class="btn btn-primary rounded-3 px-3">
                                    <i class="bi bi-upload me-1"></i> Re-submit Document
                                </button>
                            </form>

                        @else
                            {{-- No submission yet --}}
                            <p class="text-muted mb-3">Upload a government-issued ID card (e.g. National ID, Passport, Driver's License) to verify your identity.</p>

                            <form action="{{ route('id-verification.upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="id_document" class="form-label">Upload ID Document</label>
                                    <input type="file" class="form-control" id="id_document" name="id_document"
                                        accept=".pdf,.jpg,.jpeg,.png" required>
                                    <div class="form-text">Accepted formats: PDF, JPG, PNG. Maximum file size: 5MB.</div>
                                </div>
                                <button type="submit" class="btn btn-primary rounded-3 px-3">
                                    <i class="bi bi-upload me-1"></i> Submit for Verification
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection