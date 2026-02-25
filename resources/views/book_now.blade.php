<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stay Smart Apartments</title>

  <!--=====FAB ICON=======-->
  <link rel="shortcut icon" href="assets/img/logo/smart-favicon.png" type="image/x-icon">

  <!--===== CSS LINK =======-->
  <link rel="stylesheet" href="assets/css/plugins/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/plugins/aos.css">
  <link rel="stylesheet" href="assets/css/plugins/fontawesome.css">
  <link rel="stylesheet" href="assets/css/plugins/magnific-popup.css">
  <link rel="stylesheet" href="assets/css/plugins/mobile.css">
  <link rel="stylesheet" href="assets/css/plugins/owlcarousel.min.css">
  <link rel="stylesheet" href="assets/css/plugins/sidebar.css">
  <link rel="stylesheet" href="assets/css/plugins/slick-slider.css">
  <link rel="stylesheet" href="assets/css/plugins/nice-select.css">
  <link rel="stylesheet" href="assets/css/main.css?2">
  @include('partials.frontend.carousel_assets')

  <!--=====  JS SCRIPT LINK =======-->
  <script src="assets/js/plugins/jquery-3-6-0.min.js"></script>
</head>

<body class="homepage10-body">
  <style>
    .apartment11-area {
      position: relative;
      z-index: 1;
      background: #fcf8f6;
    }

    @media (max-width: 767px) {
      .apartment11-area {
        height: auto;
      }
    }

    @media only screen and (min-width: 768px) and (max-width: 991px) {
      .apartment11-area {
        height: auto;
      }
    }

    .apartment11-area .owl-carousel .owl-stage-outer {
      position: absolute !important;
    }

    @media (max-width: 767px) {
      .apartment11-area .owl-carousel .owl-stage-outer {
        position: relative !important;
      }
    }

    @media only screen and (min-width: 768px) and (max-width: 991px) {
      .apartment11-area .owl-carousel .owl-stage-outer {
        position: relative !important;
      }
    }

    .apartment11-area {
      position: relative;
      z-index: 1;
    }

    .apartment11-area .apartment-boxarea {
      background: var(--ztc-bg-bg-1);
      border-radius: 16px;
      position: relative;
      z-index: 1;
      overflow: hidden;
    }

    .apartment11-area .apartment-boxarea:hover .img1 img {
      transform: scale(1.1) rotate(-4deg);
      transition: all 0.4s;
    }

    .apartment11-area .apartment-boxarea .img1 {
      overflow: hidden;
      border-radius: 16px 16px 0 0;
      transition: all 0.4s;
    }

    .apartment11-area .apartment-boxarea .img1 img {
      height: 100%;
      width: 100%;
      -o-object-fit: cover;
      object-fit: cover;
      border-radius: 16px 16px 0 0;
      transition: all 0.4s;
    }

    .apartment11-area .apartment-boxarea .content {
      padding: 28px 24px;
    }

    .apartment11-area .apartment-boxarea .content a {
      color: var(--ztc-text-text-25);
      font-family: var(--ztc-family-font2);
      font-size: var(--ztc-font-size-font-s24);
      font-style: normal;
      font-weight: var(--ztc-weight-bold);
      line-height: 24px;
      transition: all 0.4s;
      display: inline-block;
    }

    .apartment11-area .apartment-boxarea .content a:hover {
      color: var(--ztc-text-text-27);
      transition: all 0.4s;
    }

    .apartment11-area .apartment-boxarea .content p {
      color: var(--ztc-text-text-26);
      font-family: var(--ztc-family-font2);
      font-size: var(--ztc-font-size-font-s16);
      font-style: normal;
      font-weight: var(--ztc-weight-medium);
      line-height: 16px;
    }

    .apartment11-area .apartment-boxarea .content ul {
      padding-bottom: 28px;
      border-bottom: 1px solid rgba(13, 15, 24, 0.1);
    }

    .apartment11-area .apartment-boxarea .content ul li {
      display: inline-block;
    }

    .apartment11-area .apartment-boxarea .content ul li a {
      color: var(--ztc-text-text-26);
      font-family: var(--ztc-family-font2);
      font-size: var(--ztc-font-size-font-s16);
      font-style: normal;
      font-weight: var(--ztc-weight-medium);
      line-height: 16px;
      transition: all 0.4s;
      border-radius: 110px;
      border: 1px solid rgba(13, 15, 24, 0.1);
      padding: 10px 16px;
      margin: 0 10px 0 0;
    }

    @media only screen and (min-width: 768px) and (max-width: 991px) {
      .apartment11-area .apartment-boxarea .content ul li a {
        margin: 0 8px 0 0;
      }
    }

    .apartment11-area .apartment-boxarea .content ul li a img {
      margin: 0 0 0 0;
      opacity: 0.6;
      height: 16px;
      width: 16px;
      -o-object-fit: cover;
      object-fit: cover;
      display: inline-block;
    }

    .apartment11-area .apartment-boxarea .content .btn-area1 {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .apartment11-area .apartment-boxarea .content .btn-area1 .header-btn11 {
      font-size: var(--ztc-font-size-font-s16);
      color: var(--ztc-text-text-1);
      line-height: 16px;
    }

    .apartment11-area .apartment-boxarea .content .btn-area1 .love a {
      height: 40px;
      width: 40px;
      text-align: center;
      line-height: 37px;
      border-radius: 50%;
      transition: all 0.4s;
      display: inline-block;
      background: #faece0;
      position: relative;
    }

    .apartment11-area .apartment-boxarea .content .btn-area1 .love a:hover img.heart1 {
      visibility: hidden;
      opacity: 0;
      transition: all 0.4s;
    }

    .apartment11-area .apartment-boxarea .content .btn-area1 .love a:hover img.heart2 {
      visibility: visible;
      opacity: 1;
      transition: all 0.4s;
      position: absolute;
    }

    .apartment11-area .apartment-boxarea .content .btn-area1 .love a.active {
      transition: all 0.4s;
    }

    .apartment11-area .apartment-boxarea .content .btn-area1 .love a.active img.heart1 {
      visibility: hidden;
      opacity: 0;
      transition: all 0.4s;
    }

    .apartment11-area .apartment-boxarea .content .btn-area1 .love a.active img.heart2 {
      visibility: visible;
      opacity: 1;
      transition: all 0.4s;
      position: absolute;
    }

    .apartment11-area .apartment-boxarea .content .btn-area1 .love a img {
      width: 18px;
      height: 16px;
      -o-object-fit: cover;
      object-fit: cover;
      display: inline-block;
    }

    .apartment11-area .apartment-boxarea .content .btn-area1 .love a img.heart1 {
      visibility: visible;
      opacity: 1;
      transition: all 0.4s;
    }

    .apartment11-area .apartment-boxarea .content .btn-area1 .love a img.heart2 {
      visibility: hidden;
      opacity: 0;
      transition: all 0.4s;
      position: absolute;
      top: 12px;
      left: 11px;
    }

    .active>.page-link,
    .page-link.active {
      background-color: #875233;
      border-color: #875233;
      color: white;
    }

    .page-link {
      height: 50px !important;
      width: 50px !important;
      display: flex;
      align-items: center;
      justify-content: center;
    }
  </style>

  @include('partials.frontend.header')
  <!--===== HERO AREA STARTS =======-->
  <div class="inner-main-hero-area">
    <div class="img1">
      <img src="{{ asset('assets/img/all-images/hero/hero-img1.png') }}" alt="">
    </div>
    <div class="img2">
      <img src="{{ asset('assets/img/all-images/hero/hero-img2.png') }}" alt="">
    </div>
    <div class="container">
      <div class="row justify-content-between align-items-center">
        <div class="col-lg-6">
          <div class="inner-heading header-heading">
            <h2>Booking Information</h2>
            <div class="space12"></div>
            <p><a href="{{ url('/') }}">Home <i class="fa-solid fa-angle-right"></i></a> Booking</p>
            <div class="space12"></div>

            <div class="search-summary-box p-3 rounded bg-light shadow-sm" style="z-index: 99 !important;">
              <h5 class="mb-3 ps-0 text-dark">
                <i class="fa-solid fa-house text-dark me-1"></i>
                {{$property->name}}
              </h5>
              <form id="bookingForm" method="POST" action="{{ route('booking.store') }}">
                @csrf
                <input type="hidden" name="property_id" value="{{ $property->id }}">
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <label for="check_in_date" class="form-label text-dark"><strong>Check-in Date</strong></label>
                    <input type="date" class="form-control" id="check_in_date" name="check_in_date"
                           value="{{ old('check_in_date', request('check_in')) }}" required>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="check_out_date" class="form-label text-dark"><strong>Check-out Date</strong></label>
                    <input type="date" class="form-control" id="check_out_date" name="check_out_date"
                           value="{{ old('check_out_date', request('check_out')) }}" required>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="number_of_guests" class="form-label text-dark"><strong>Number of Guests</strong></label>
                    <input type="number" class="form-control" id="number_of_guests" name="number_of_guests"
                           value="{{ old('number_of_guests', request('guests')) }}" min="1" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="check_in_time" class="form-label text-dark"><strong>Check-in Time</strong></label>
                    <input type="time" class="form-control" id="check_in_time" name="check_in_time" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="check_out_time" class="form-label text-dark"><strong>Check-out Time</strong></label>
                    <input type="time" class="form-control" id="check_out_time" name="check_out_time" required>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-5 d-none d-lg-block"></div>
      </div>
    </div>
  </div>
  <!--===== HERO AREA ENDS =======-->


  <!--===== APARTMENT AREA STARTS =======-->
  <div class="apartment-details-left sp6">
    <div class="container">
      <div class="row">
        <div class="col-lg-7 m-auto">
          <div class="apartment-author-area pdright">
            @php
              $allImages = [$property->image_path ? asset('storage/' . $property->image_path) : asset('assets/img/all-images/apartment/apartment-img1.png')];
              if($property->images) {
                foreach($property->images as $img) {
                  $allImages[] = asset('storage/' . $img->image_path);
                }
              }
            @endphp
            <div class="img1 property-carousel">
              @if(count($allImages) > 1)
                <button class="carousel-btn prev" onclick="togglePropertyImage(this, 'prev')"><i class="fa-solid fa-angle-left"></i></button>
              @endif
              <img src="{{ $allImages[0] }}" alt="" class="property-img-carousel"
                data-images="{{ json_encode($allImages) }}" data-current-index="0">
              @if(count($allImages) > 1)
                <button class="carousel-btn next" onclick="togglePropertyImage(this, 'next')"><i class="fa-solid fa-angle-right"></i></button>
              @endif
            </div>
            <div class="space40"></div>
            <h2>{{$property->name}}</h2><br><br>
            <p class="mb-2 ps-0 text-dark">
              <i class="fa-solid fa-location-dot text-dark me-1"></i>
              {{$property->address}}, {{$property->city}}, {{$property->country}}
            </p>
            <div class="space20"></div>
            <p>{{$property->description}}</p>
            <div class="space40"></div>
            <h3>{{$property->name}} Amenities</h3>
            <div class="space20"></div>
            <p>We provide a range of exceptional amenities. Here’s a list of the amenities offered:</p>
            <div class="space20"></div>
            <div class="row apartment11-area">
              <div class="apartment-boxarea">
                <div class="content">
                  <ul>
                    @foreach($property->amenities as $amenity)
                      <li><a href="#" style="font-size: 14px; margin-bottom: 5px;">{{$amenity->name}}</a></li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
            <div class="space32"></div>
            <div class="apartment-contactbox">
              <h3>Book Now</h3>
              <div class="space16"></div>
              <form class="px-md-5 pt-3" action="{{route('book')}}" method="POST">
                @csrf
                @if (session('error'))
                  <div class="alert alert-danger">
                    <strong>Error:</strong> {{ session('error') }}
                  </div>
                @endif
                @if ($errors->any())
                  <div class="alert alert-danger">
                    <ul class="mb-0">
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif
                <div class="row contact-input-section">
                  <div class="col-lg-6">
                    <div class="input-area">
                      <input type="text" name="first_name" placeholder="First Name" 
                        value="{{ old('first_name', auth()->check() ? auth()->user()->first_name : '') }}" required>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="input-area">
                      <input type="text" name="last_name" placeholder="Last Name" 
                        value="{{ old('last_name', auth()->check() ? auth()->user()->last_name : '') }}" required>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="input-area">
                      <input type="email" name="email" placeholder="Email" 
                        value="{{ old('email', auth()->check() ? auth()->user()->email : '') }}" 
                        {{ auth()->check() ? 'readonly' : '' }} required>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="input-area">
                      <input type="text" name="phone_number" placeholder="Mobile Number"
                        value="{{ old('phone_number', auth()->check() ? auth()->user()->phone_number : '') }}">
                    </div>
                  </div>
                  
                  @if(!auth()->check())
                  <div class="col-lg-12">
                    <div class="space20"></div>
                    <div class="input-area d-flex align-items-center">
                      <input type="checkbox" name="create_account" id="create_account" value="1"
                        style="width: 16px; height: 16px; border: 1px solid #ccc; margin-right: 10px; appearance: checkbox; -webkit-appearance: checkbox;">
                      <label for="create_account" class="m-0" style="font-size: 14px; cursor: pointer;">
                        Create an account for me and update my profile with the above details
                      </label>
                    </div>
                  </div>
                  
                  <div class="col-lg-6" id="password_field" style="display: none;">
                    <div class="space20"></div>
                    <div class="input-area">
                      <input type="password" name="password" placeholder="Enter Password" id="password_input">
                    </div>
                  </div>
                  <div class="col-lg-6" id="confirm_password_field" style="display: none;">
                    <div class="space20"></div>
                    <div class="input-area">
                      <input type="password" name="password_confirmation" placeholder="Confirm Password" id="confirm_password_input">
                    </div>
                  </div>
                  @else
                  <div class="col-lg-12">
                    <div class="space20"></div>
                    <div class="input-area d-flex align-items-center">
                      <input type="checkbox" name="update_profile" id="update_profile" value="1"
                        style="width: 16px; height: 16px; border: 1px solid #ccc; margin-right: 10px; appearance: checkbox; -webkit-appearance: checkbox;">
                      <label for="update_profile" class="m-0" style="font-size: 14px; cursor: pointer;">
                        Update my profile with the above details
                      </label>
                    </div>
                  </div>
                  @endif
                  
                  <div class="space24"></div>
                  <input type="hidden" name="number_of_guests" value="{{ old('number_of_guests', request('guests')) }}">
                  <input type="hidden" name="check_out_date" value="{{ old('check_out_date', request('check_out')) }}">
                  <input type="hidden" name="check_in_date" value="{{ old('check_in_date', request('check_in')) }}">
                  <input type="hidden" name="check_in_time" value="{{ old('check_in_time') }}">
                  <input type="hidden" name="check_out_time" value="{{ old('check_out_time') }}">
                  <input type="hidden" name="property_id" value="{{ old('property_id', $property->id) }}">
                  <div class="col-lg-12">
                    <div class="input-area text-end">
                      <button type="submit" class="header-btn11">Book</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--===== APARTMENT AREA ENDS =======-->

  @include('partials.frontend.footer')

  <script>
    $('#heroTabs a').on('click', function (e) {
      e.preventDefault()
      $(this).tab('show')
    })

    // Handle form submission to copy editable field values
    $('form').on('submit', function(e) {
      // Copy values from editable fields to hidden inputs
      $('input[name="check_in_date"]').val($('#check_in_date').val());
      $('input[name="check_out_date"]').val($('#check_out_date').val());
      $('input[name="check_in_time"]').val($('#check_in_time').val());
      $('input[name="check_out_time"]').val($('#check_out_time').val());
      $('input[name="number_of_guests"]').val($('#number_of_guests').val());
    });

    // Toggle password fields when create account checkbox is checked
    $('#create_account').on('change', function() {
      if ($(this).is(':checked')) {
        $('#password_field').slideDown();
        $('#confirm_password_field').slideDown();
        $('#password_input').attr('required', true);
        $('#confirm_password_input').attr('required', true);
      } else {
        $('#password_field').slideUp();
        $('#confirm_password_field').slideUp();
        $('#password_input').attr('required', false).val('');
        $('#confirm_password_input').attr('required', false).val('');
      }
    });

    // Real-time Availability Check
    $('#check_in_date, #check_out_date').on('change', function() {
        const checkIn = $('#check_in_date').val();
        const checkOut = $('#check_out_date').val();
        const propertyId = $('input[name="property_id"]').val();

        if (checkIn && checkOut && propertyId) {
            // Basic client-side validation
            if (new Date(checkIn) >= new Date(checkOut)) {
                $('#availability-message').remove();
                $('.header-btn11').prop('disabled', true).css('cursor', 'not-allowed');
                $('<div id="availability-message" class="alert alert-danger mt-3">Check-out date must be after check-in date.</div>').insertAfter('#bookingForm .row:last');
                return;
            }

            $('.header-btn11').prop('disabled', true).text('Checking...');

            $.ajax({
                url: "{{ route('booking.check_availability') }}",
                type: "GET",
                data: {
                    property_id: propertyId,
                    check_in_date: checkIn,
                    check_out_date: checkOut
                },
                success: function(response) {
                    $('#availability-message').remove();
                    if (response.available) {
                         $('.header-btn11').prop('disabled', false).css('cursor', 'pointer').text('Book');
                    } else {
                         $('.header-btn11').prop('disabled', true).css('cursor', 'not-allowed').text('Booked');
                         $('<div id="availability-message" class="alert alert-danger mt-3">' + response.message + '</div>').insertAfter('#bookingForm .row:last');
                    }
                },
                error: function(xhr) {
                    console.error('Availability check failed:', xhr);
                    $('.header-btn11').prop('disabled', false).text('Book'); // Allow retry or submit to handle error server-side
                }
            });
        }
    });
  </script>

</body>

</html>