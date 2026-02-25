<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lease to Stay Smart - Guaranteed Income, Zero Stress</title>

    <!--=====FAB ICON=======-->
    <link rel="shortcut icon" href="{{ asset('assets/img/logo/smart-favicon.png') }}" type="image/x-icon">

    <!--===== CSS LINK =======-->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/mobile.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/nice-select.css') }}">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />

    <!--===== JS SCRIPT LINK =======-->
    <script src="{{ asset('assets/js/plugins/jquery-3-6-0.min.js') }}"></script>

    <style>
        .benefits-section {
            background: linear-gradient(135deg, #20c997 0%, #28a745 100%);
            /* Green/Teal theme for Leasing */
            color: white;
            padding: 40px;
            border-radius: 15px;
            height: 100%;
        }

        .benefit-item {
            margin-bottom: 25px;
            padding-left: 35px;
            position: relative;
        }

        .benefit-item:before {
            content: "✓";
            position: absolute;
            left: 0;
            top: 0;
            width: 25px;
            height: 25px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .form-section {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .image-preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }

        .image-preview {
            position: relative;
            width: 100px;
            height: 100px;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #dee2e6;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-preview .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-container--bootstrap-5 .select2-selection {
            min-height: 38px;
        }

        .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }

        /* Mobile Optimization */
        @media (max-width: 768px) {
            .container.my-5 {
                margin-top: 2rem !important;
                margin-bottom: 2rem !important;
            }

            .benefits-section,
            .form-section {
                padding: 25px !important;
            }

            h1.display-4 {
                font-size: 2.5rem;
            }

            h3 {
                font-size: 1.5rem;
            }

            .image-preview {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>

<body>
    <!--===== PRELOADER STARTS =======-->
    <div class="preloader"
        style="background-image: url('{{ asset('assets/img/logo/preloader.gif') }}'); filter: hue-rotate(315deg) saturate(80%)">
    </div>
    <!--===== PRELOADER ENDS =======-->

    <!--===== PROGRESS STARTS=======-->
    <div class="paginacontainer">
        <div class="progress-wrap">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg>
        </div>
    </div>
    <!--===== PROGRESS ENDS=======-->

    <div class="container my-5">
        <!-- Breadcrumb -->
        <!--<nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Lease to Stay Smart</li>
            </ol>
        </nav>-->

        <!-- Page Header -->
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold">Lease Your Property to Stay Smart</h1>
            <p class="lead text-muted">Guaranteed income, professional management, and total peace of mind</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- Benefits Section -->
            <div class="col-lg-4">
                <div class="benefits-section">
                    <h3 class="mb-4">Why Lease to Stay Smart?</h3>



                    <div class="benefit-item">
                        <h5>Guaranteed Annual Income</h5>
                        <p class="mb-0">We pay you a fixed annual rent regardless of occupancy. No more vacant months
                            or income fluctuation.</p>
                    </div>

                    <div class="benefit-item">
                        <h5>100% Hands-Off Management</h5>
                        <p class="mb-0">We handle everything: finding guests, cleaning, maintenance, and 24/7 support.
                            You just collect rent.</p>
                    </div>

                    <div class="benefit-item">
                        <h5>Professional Property Care</h5>
                        <p class="mb-0">Our professional cleaning and maintenance teams keep your property in showroom
                            condition.</p>
                    </div>

                    <div class="benefit-item">
                        <h5>No Tenant Hassles</h5>
                        <p class="mb-0">We are your ideal tenant. No late payments, no excuses, and we handle all
                            underlying guest issues.</p>
                    </div>

                    <div class="benefit-item">
                        <h5>Corporate Reliability</h5>
                        <p class="mb-0">Partner with a trusted company. We carry full insurance and ensure legal
                            compliance.</p>
                    </div>
                </div>
            </div>

            <!-- Registration Form -->
            <div class="col-lg-8">
                <div class="form-section">
                    <h3 class="mb-4">Get an Offer - Tell Us About Your Property</h3>

                    <form action="{{ route('lease.staysmart.submit') }}" method="POST" enctype="multipart/form-data"
                        id="leaseForm">
                        @csrf

                        <!-- Personal Information -->
                        <h5 class="mb-3 text-primary">Owner Information</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">First Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                    value="{{ old('first_name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Last Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                    value="{{ old('last_name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone_number" class="form-label">Phone Number <span
                                        class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="phone_number" name="phone_number"
                                    value="{{ old('phone_number') }}" required>
                            </div>
                        </div>

                        <!-- Location Information -->
                        <h5 class="mb-3 text-primary">Property Location</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label for="address" class="form-label">Street Address <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="address" name="address"
                                    value="{{ old('address') }}" placeholder="e.g., 123 Main Street, Apartment 4B"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}"
                                    placeholder="e.g., Lagos" required>
                            </div>
                            <div class="col-md-3">
                                <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="state" name="state"
                                    value="{{ old('state') }}" placeholder="e.g., Lagos" required>
                            </div>
                            <div class="col-md-3">
                                <label for="postal_code" class="form-label">Postal Code</label>
                                <input type="text" class="form-control" id="postal_code" name="postal_code"
                                    value="{{ old('postal_code') }}" placeholder="e.g., 100001">
                            </div>
                        </div>

                        <!-- Property Details -->
                        <h5 class="mb-3 text-primary">Property Details</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="property_type" class="form-label">Property Type <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="property_type" name="property_type" required>
                                    <option value="" selected disabled>Select type</option>
                                    <option value="Apartment" {{ old('property_type') == 'Apartment' ? 'selected' : '' }}>
                                        Apartment</option>
                                    <option value="House" {{ old('property_type') == 'House' ? 'selected' : '' }}>House
                                    </option>
                                    <option value="Duplex" {{ old('property_type') == 'Duplex' ? 'selected' : '' }}>Duplex
                                    </option>
                                    <option value="Studio" {{ old('property_type') == 'Studio' ? 'selected' : '' }}>Studio
                                    </option>
                                    <option value="Villa" {{ old('property_type') == 'Villa' ? 'selected' : '' }}>Villa
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="furnishing" class="form-label">Furnishing Status <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="furnishing" name="furnishing" required>
                                    <option value="" selected disabled>Select status</option>
                                    <option value="Fully Furnished" {{ old('furnishing') == 'Fully Furnished' ? 'selected' : '' }}>Fully Furnished</option>
                                    <option value="Partially Furnished" {{ old('furnishing') == 'Partially Furnished' ? 'selected' : '' }}>Partially Furnished</option>
                                    <option value="Unfurnished" {{ old('furnishing') == 'Unfurnished' ? 'selected' : '' }}>Unfurnished</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="bedrooms" class="form-label">Bedrooms <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="bedrooms" name="bedrooms" required>
                                    <option value="Studio" {{ old('bedrooms') == 'Studio' ? 'selected' : '' }}>Studio
                                    </option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ old('bedrooms') == $i ? 'selected' : '' }}>{{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="bathrooms" class="form-label">Bathrooms <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="bathrooms" name="bathrooms" required>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ old('bathrooms') == $i ? 'selected' : '' }}>{{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="size" class="form-label">Size (sqm/sqft)</label>
                                <input type="text" class="form-control" id="size" name="size" value="{{ old('size') }}">
                            </div>

                            <div class="col-12">
                                <label for="amenities" class="form-label">Key Amenities <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="amenities" name="amenities[]" multiple required>
                                    @foreach($amenities as $amenity)
                                        <option value="{{ $amenity->id }}" {{ (collect(old('amenities'))->contains($amenity->id)) ? 'selected' : '' }}>
                                            {{ $amenity->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label">Description <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="4"
                                    placeholder="Briefly describe the property layout, view, and highlights..."
                                    required>{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <!-- Ownership & Terms -->
                        <h5 class="mb-3 text-primary">Ownership & Terms</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Ownership Status <span class="text-danger">*</span></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="ownership_status" id="own_yes"
                                        value="I own this property" {{ old('ownership_status') == 'I own this property' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="own_yes">I own this property</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="ownership_status" id="own_lease"
                                        value="I have landlord permission to lease" {{ old('ownership_status') == 'I have landlord permission to lease' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="own_lease">I have landlord permission to lease
                                        (Sublease)</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Title Deed/Proof Available? <span
                                        class="text-danger">*</span></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="title_deed_available"
                                        id="title_yes" value="Yes" {{ old('title_deed_available') == 'Yes' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="title_yes">Yes, available</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="title_deed_available"
                                        id="title_no" value="No" {{ old('title_deed_available') == 'No' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="title_no">No / In Process</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Current Tenancy <span class="text-danger">*</span></label>
                                <select class="form-select" name="tenancy_status" id="tenancy_status" required
                                    onchange="toggleVacancyDate()">
                                    <option value="Vacant" {{ old('tenancy_status') == 'Vacant' ? 'selected' : '' }}>
                                        Vacant (Ready to move)</option>
                                    <option value="Currently Occupied" {{ old('tenancy_status') == 'Currently Occupied' ? 'selected' : '' }}>Currently Occupied</option>
                                </select>
                            </div>

                            <div class="col-md-6" id="vacancy_div" style="display:none;">
                                <label for="vacancy_date" class="form-label">Expected Vacancy Date</label>
                                <input type="date" class="form-control" id="vacancy_date" name="vacancy_date"
                                    value="{{ old('vacancy_date') }}">
                            </div>

                            <div class="col-md-6">
                                <label for="lease_duration" class="form-label">Preferred Lease Duration <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="lease_duration" name="lease_duration" required>
                                    <option value="1 Year" {{ old('lease_duration') == '1 Year' ? 'selected' : '' }}>1
                                        Year</option>
                                    <option value="2 Years" {{ old('lease_duration') == '2 Years' ? 'selected' : '' }}>2
                                        Years</option>
                                    <option value="3 Years" {{ old('lease_duration') == '3 Years' ? 'selected' : '' }}>3
                                        Years</option>
                                    <option value="5+ Years" {{ old('lease_duration') == '5+ Years' ? 'selected' : '' }}>
                                        5+ Years</option>
                                    <option value="Open to discussion" {{ old('lease_duration') == 'Open to discussion' ? 'selected' : '' }}>Open to discussion</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Earliest Start Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="start_date" name="start_date"
                                    value="{{ old('start_date') }}" required>
                            </div>

                            <div class="col-md-12">
                                <label for="expected_rent" class="form-label">Expected Annual Rent (Optional)</label>
                                <input type="number" class="form-control" id="expected_rent" name="expected_rent"
                                    value="{{ old('expected_rent') }}" placeholder="Enter amount">
                            </div>
                        </div>

                        <!-- Condition -->
                        <h5 class="mb-3 text-primary">Property Condition</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <label class="form-label">Overall Condition <span class="text-danger">*</span></label>
                                <select class="form-select" name="condition" required>
                                    <option value="Excellent" {{ old('condition') == 'Excellent' ? 'selected' : '' }}>
                                        Excellent (Like New)</option>
                                    <option value="Good" {{ old('condition') == 'Good' ? 'selected' : '' }}>Good (Minor
                                        wear)</option>
                                    <option value="Fair" {{ old('condition') == 'Fair' ? 'selected' : '' }}>Fair (Livable
                                        but aged)</option>
                                    <option value="Needs Renovation" {{ old('condition') == 'Needs Renovation' ? 'selected' : '' }}>Needs Renovation</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Recent Renovations (Select all that apply)</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check"><input class="form-check-input" type="checkbox"
                                                name="renovations[]" value="Kitchen" id="r_kitchen"><label
                                                class="form-check-label" for="r_kitchen">Kitchen</label></div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox"
                                                name="renovations[]" value="Bathroom" id="r_bathroom"><label
                                                class="form-check-label" for="r_bathroom">Bathroom</label></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check"><input class="form-check-input" type="checkbox"
                                                name="renovations[]" value="Flooring" id="r_flooring"><label
                                                class="form-check-label" for="r_flooring">Flooring</label></div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox"
                                                name="renovations[]" value="Painting" id="r_painting"><label
                                                class="form-check-label" for="r_painting">Painting</label></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check"><input class="form-check-input" type="checkbox"
                                                name="renovations[]" value="Electrical/Plumbing" id="r_ep"><label
                                                class="form-check-label" for="r_ep">Electrical/Plumbing</label></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="issues" class="form-label">Known Issues / Repairs Needed</label>
                                <textarea class="form-control" id="issues" name="issues" rows="2"
                                    placeholder="Start honest - describe any known leaks, cracks, or appliance issues...">{{ old('issues') }}</textarea>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="images" class="form-label">Property Photos <span
                                    class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="images" name="images[]"
                                accept="image/jpeg,image/jpg,image/png" multiple required>
                            <small class="text-muted">Upload 1-10 high-quality photos (JPEG, JPG, PNG only, max 5MB
                                each)</small>
                            <div id="imagePreviewContainer" class="image-preview-container"></div>
                        </div>

                        <div class="mb-4">
                            <label for="reason" class="form-label">Why do you want to lease to Stay Smart?</label>
                            <textarea class="form-control" id="reason" name="reason"
                                rows="2">{{ old('reason') }}</textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
                                <i class="fa-solid fa-handshake me-2"></i>Submit Lease Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-5">
            <a href="{{ route('welcome') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-2"></i>Back to Home
            </a>
        </div>
    </div>

    </div>
    <!--===== JS SCRIPT LINK =======-->
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/fontawesome.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/aos.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/counter.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sidebar.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/magnific-popup.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/mobilemenu.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/owlcarousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/nice-select.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/waypoints.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/slick-slider.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/circle-progress.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/gsap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/ScrollTrigger.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/Splitetext.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Initialize Select2
        $(document).ready(function () {
            $('#amenities').select2({
                theme: 'bootstrap-5',
                placeholder: 'Select main amenities',
                allowClear: true,
                closeOnSelect: false,
                width: '100%'
            });
        });

        // Toggle Vacancy Date
        function toggleVacancyDate() {
            const status = document.getElementById('tenancy_status').value;
            const div = document.getElementById('vacancy_div');
            if (status === 'Currently Occupied') {
                div.style.display = 'block';
            } else {
                div.style.display = 'none';
            }
        }
        // Run on load in case of old input
        window.onload = toggleVacancyDate;

        // Image preview functionality
        document.getElementById('images').addEventListener('change', function (e) {
            const container = document.getElementById('imagePreviewContainer');
            container.innerHTML = '';

            const files = Array.from(e.target.files);

            if (files.length > 10) {
                Swal.fire({
                    icon: 'error',
                    title: 'Too Many Images',
                    text: 'You can only upload a maximum of 10 images',
                });
                e.target.value = '';
                return;
            }

            files.forEach((file, index) => {
                if (file.size > 5 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Too Large',
                        text: `${file.name} is larger than 5MB`,
                    });
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (event) {
                    const preview = document.createElement('div');
                    preview.className = 'image-preview';
                    preview.innerHTML = `
            <img src="${event.target.result}" alt="Preview ${index + 1}">
            <button type="button" class="remove-image" data-index="${index}">×</button>
          `;
                    container.appendChild(preview);
                };
                reader.readAsDataURL(file);
            });
        });

        // Remove image functionality
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-image')) {
                const input = document.getElementById('images');
                const dt = new DataTransfer();
                const files = Array.from(input.files);
                const indexToRemove = parseInt(e.target.dataset.index);

                files.forEach((file, index) => {
                    if (index !== indexToRemove) {
                        dt.items.add(file);
                    }
                });

                input.files = dt.files;
                e.target.closest('.image-preview').remove();
            }
        });

        // Form submission with loading state
        document.getElementById('leaseForm').addEventListener('submit', function (e) {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Submitting...';
        });

        // Auto-dismiss success alert
        setTimeout(function () {
            const alert = document.querySelector('.alert-success');
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 10000);
    </script>
</body>

</html>