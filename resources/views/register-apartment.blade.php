<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>List Your Apartment - Stay Smart</title>

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
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
      background-color: #667eea;
      border-color: #667eea;
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
    <!--Breadcrumb -->
    <!-- <nav aria-label="breadcrumb" class="mb-4">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">List Your Apartment</li>
      </ol>
    </nav> -->

    <!-- Page Header -->
    <div class="text-center mb-5">
      <h1 class="display-4 fw-bold">List Your Apartment on Stay Smart</h1>
      <p class="lead text-muted">Manage your property, reach verified guests, and maximize your earnings</p>
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
          <h3 class="mb-4">Why List with Stay Smart?</h3>

          <div class="benefit-item">
            <h5>You Stay in Control</h5>
            <p class="mb-0">Manage your property through your own admin dashboard. Set prices, availability, and house
              rules.</p>
          </div>

          <div class="benefit-item">
            <h5>Reach More Guests</h5>
            <p class="mb-0">Get access to our verified guest network actively searching for quality apartments.</p>
          </div>

          <div class="benefit-item">
            <h5>Secure Payments</h5>
            <p class="mb-0">All payments are processed securely. Funds are transferred directly to your account.</p>
          </div>

          <div class="benefit-item">
            <h5>Guest Verification</h5>
            <p class="mb-0">Every guest is verified before booking, giving you peace of mind about who stays in your
              property.</p>
          </div>

          <div class="benefit-item">
            <h5>24/7 Platform Support</h5>
            <p class="mb-0">Our team is here to help you and your guests whenever needed.</p>
          </div>
        </div>
      </div>

      <!-- Registration Form -->
      <div class="col-lg-8">
        <div class="form-section">
          <h3 class="mb-4">Get Started - Tell Us About Your Property</h3>

          <form action="{{ route('register.apartment.submit') }}" method="POST" enctype="multipart/form-data"
            id="registrationForm">
            @csrf

            <!-- Personal Information -->
            <h5 class="mb-3 text-primary">Your Information</h5>
            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="first_name" name="first_name"
                  value="{{ old('first_name') }}" required>
              </div>
              <div class="col-md-6">
                <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}"
                  required>
              </div>
              <div class="col-md-6">
                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
              </div>
              <div class="col-md-6">
                <label for="phone_number" class="form-label">Phone Number <span class="text-danger">*</span></label>
                <input type="tel" class="form-control" id="phone_number" name="phone_number"
                  value="{{ old('phone_number') }}" required>
              </div>
            </div>

            <!-- Location Information -->
            <h5 class="mb-3 text-primary">Property Location</h5>
            <div class="row g-3 mb-4">
              <div class="col-md-12">
                <label for="address" class="form-label">Street Address <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}"
                  placeholder="e.g., 123 Main Street, Apartment 4B" required>
              </div>
              <div class="col-md-6">
                <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}"
                  placeholder="e.g., Lagos" required>
              </div>
              <div class="col-md-3">
                <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="state" name="state" value="{{ old('state') }}"
                  placeholder="e.g., Lagos" required>
              </div>
              <div class="col-md-3">
                <label for="postal_code" class="form-label">Postal Code</label>
                <input type="text" class="form-control" id="postal_code" name="postal_code"
                  value="{{ old('postal_code') }}" placeholder="e.g., 100001">
              </div>
            </div>

            <!-- Property Information -->
            <h5 class="mb-3 text-primary">Property Details</h5>
            <div class="mb-4">
              <label for="description" class="form-label">Tell us about your apartment <span
                  class="text-danger">*</span></label>
              <textarea class="form-control" id="description" name="description" rows="5"
                placeholder="Include details like: location, number of bedrooms/bathrooms, size, nearby amenities, what makes your property special, etc."
                required>{{ old('description') }}</textarea>
              <small class="text-muted">Minimum 50 characters - the more details, the better!</small>
            </div>

            <div class="mb-4">
              <label for="amenities" class="form-label">Property Amenities <span class="text-danger">*</span></label>
              <select class="form-select" id="amenities" name="amenities[]" multiple required>
                @foreach($amenities as $amenity)
                  <option value="{{ $amenity->id }}" {{ (collect(old('amenities'))->contains($amenity->id)) ? 'selected' : '' }}>
                    {{ $amenity->name }}
                  </option>
                @endforeach
              </select>
              <small class="text-muted">Select all amenities that apply to your property</small>
            </div>

            <div class="mb-4">
              <label for="images" class="form-label">Property Photos <span class="text-danger">*</span></label>
              <input type="file" class="form-control" id="images" name="images[]"
                accept="image/jpeg,image/jpg,image/png" multiple required>
              <small class="text-muted">Upload 1-10 high-quality photos (JPEG, JPG, PNG only, max 5MB each)</small>
              <div id="imagePreviewContainer" class="image-preview-container"></div>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                Submit Application
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
    // Initialize Select2 for amenities dropdown
    $(document).ready(function () {
      $('#amenities').select2({
        theme: 'bootstrap-5',
        placeholder: 'Select amenities for your property',
        allowClear: true,
        closeOnSelect: false,
        width: '100%'
      });
    });

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
    document.getElementById('registrationForm').addEventListener('submit', function (e) {
      const submitBtn = document.getElementById('submitBtn');
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Submitting...';
    });

    // Auto-dismiss success alert after 10 seconds
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