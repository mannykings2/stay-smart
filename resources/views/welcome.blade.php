<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stay Smart Apartments</title>

  <!--=====FAB ICON=======-->
  <link rel="shortcut icon" href="{{ asset('assets/img/logo/smart-favicon.png') }}" type="image/x-icon">

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
  <link rel="stylesheet" href="assets/css/main.css">
  @include('partials.frontend.carousel_assets')

  <style>
    .error-message {
      color: #dc3545 !important;
      font-size: 12px;
      margin-top: 5px;
      font-weight: 500;
    }

    .input-area input:focus {
      border-color: #007bff;
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .input-area input.error {
      border-color: #dc3545 !important;
      box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }

    .header-btn11.search:disabled {
      background-color: #6c757d !important;
      cursor: not-allowed;
    }

    .autocomplete-suggestions {
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      background: #fff;
      border: 1px solid #ddd;
      border-top: none;
      z-index: 1000;
      max-height: 200px;
      overflow-y: auto;
      border-radius: 0 0 5px 5px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      display: none;
    }

    .suggestion-item {
      padding: 10px 15px;
      cursor: pointer;
      font-size: 14px;
      color: #333;
      border-bottom: 1px solid #eee;
    }

    .suggestion-item:last-child {
      border-bottom: none;
    }

    .suggestion-item:hover {
      background-color: #f8f9fa;
      color: #007bff;
    }
  </style>

  <!--=====  JS SCRIPT LINK =======-->
  <script src="assets/js/plugins/jquery-3-6-0.min.js"></script>
</head>

<body class="homepage10-body">

  @include('partials.frontend.header')
  <!--===== HERO AREA STARTS =======-->
  <div class="hero10-section-area">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-5">
          <div class="space70"></div>
          <div class="hero10-header">
            {{-- <h5 data-aos="fade-left" data-aos-duration="800"><i class="fa-solid fa-location-dot"></i> 538 Amino
              Kano Crescent, Wuse 2, Abuja.</h5> --}}
            <h2 class="text-anime-style-2">Book Your Stay With Us</h2>
            <div class="space32"></div>
            <div class="btn-area1" data-aos="fade-left" data-aos-duration="1000">
              <a href="{{ route('properties') }}" class="header-btn11">See Apartments <i
                  class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
        </div>
        <div class="col-lg-12 hero-nav-tabs-div mt-4" data-aos="zoom-in-up" data-aos-duration="1000">
          <div class="space70"></div>
          <ul class="nav nav-tabs hero-nav-tabs gap-2" id="heroTabs" role="tablist" style="width: max-content">
            <li class="nav-item">
              <a class="nav-link active" id="book-tab" data-toggle="tab" href="#book" role="tab" aria-controls="book"
                aria-selected="true">Book with us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="checkIn-tab" data-toggle="tab" href="#checkIn" role="tab" aria-controls="checkIn"
                aria-selected="false">Check-in</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="bookings-tab" data-toggle="tab" href="#bookings" role="tab"
                aria-controls="bookings" aria-selected="false">Your Booking</a>
            </li>
          </ul>
          <div class="header-contact-box tab-content" id="heroTabsContent" style="border-top-left-radius: 0;">
            <div class="tab-pane fade show active" id="book" role="tabpanel" aria-labelledby="book-tab">
              <form method="GET" action="{{ route('search') }}">
                <div class="row">
                  <div class="col-md-12">
                    <h3>Book an Apartment</h3>
                    <div class="space20"></div>
                  </div>
                  <div class="col-md-10">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="input-area position-relative">
                          <label class="d-lg-none" for="location">Location</label>
                          <input type="text" name="location" id="locationSearch" placeholder="Location"
                            autocomplete="off">
                          <div id="locationSuggestions" class="autocomplete-suggestions"></div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="input-area">
                          <label class="d-lg-none mt-3" for="check_in">Check-in</label>
                          <input type="date" name="check_in" placeholder="Check-in">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="input-area">
                          <label class="d-lg-none mt-3" for="check_out">Check-out</label>
                          <input type="date" name="check_out" placeholder="Check-out">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="input-area">
                          <label class="d-lg-none mt-3" for="check-out">Guests</label>
                          <input type="number" name="guests" placeholder="Guests">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2 align-items-center d-flex justify-content-end">
                    <div class="input-area text-end">
                      <div class="space30 d-lg-none"></div>
                      <button type="submit" class="header-btn11 search">Search <i
                          class="fa-solid fa-arrow-right"></i></button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="tab-pane fade" id="checkIn" role="tabpanel" aria-labelledby="checkIn-tab">
              <form method="GET" action="{{ route('check_in') }}">
                <div class="row">
                  <div class="col-md-12">
                    <h3>Online check-in</h3>
                    <div class="space20"></div>
                  </div>
                  <div class="col-md-10 col-lg-9">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="input-area">
                          <label class="d-lg-none mt-3" for="last_name">Last Name</label>
                          <input type="text" name="last_name" placeholder="Last Name"
                            value="{{ auth()->check() ? auth()->user()->last_name : '' }}">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="input-area">
                          <label class="d-lg-none mt-3" for="booking_reference">Booking Reference</label>
                          <input type="text" name="booking_reference" placeholder="Booking Reference">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2 col-lg-2 offset-lg-1 align-items-center d-flex justify-content-end">
                    <div class="input-area text-end">
                      <div class="space30 d-lg-none"></div>
                      <button type="submit" class="header-btn11 search">Submit <i
                          class="fa-solid fa-arrow-right"></i></button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="tab-pane fade" id="bookings" role="tabpanel" aria-labelledby="bookings-tab">
              <form method="GET" action="{{ route('booking') }}">
                <div class="row">
                  <div class="col-md-12">
                    <h3>Access your booking information</h3>
                    <div class="space20"></div>
                  </div>
                  <div class="col-md-10">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="input-area">
                          <label class="d-lg-none mt-3" for="last_name">Last Name</label>
                          <input type="text" name="last_name" placeholder="Last Name"
                            value="{{ auth()->check() ? auth()->user()->last_name : '' }}">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="input-area">
                          <label class="d-lg-none mt-3" for="booking_reference">Booking Reference</label>
                          <input type="text" name="reference" placeholder="Booking Reference">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2 align-items-center d-flex justify-content-end">
                    <div class="input-area text-end">
                      <div class="space30 d-lg-none"></div>
                      <button type="submit" class="header-btn11 search">Submit <i
                          class="fa-solid fa-arrow-right"></i></button>
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
  </div>
  <!--===== HERO AREA ENDS =======-->
  <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%"
    data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary rounded-2" tabindex="0">

    <div class="property10-section-area sp6" id="property">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-12">
            <div class="property-header heading10">
              <h5 data-aos="fade-left" data-aos-duration="800">Our Business Model</h5>
            </div>
            <div class="space40"></div>
          </div>
          <div class="col-lg-4">
            <div class="p-3 shadow-sm" style="border-radius: 15px;">
              <a href="{{route('properties')}}">
                <div class="property-images">
                  <div class="img1 reveal image-anime">
                    <img src="assets/img/all-images/about/Book.jpeg" alt="" style="height: 250px">
                  </div>
                </div>
                <div class="space20"></div>
                <div class="d-flex justify-content-between heading7">
                  <h2 class="" data-aos="fade-left" data-aos-duration="800" style="font-size: 25px"> Book Apartments
                  </h2>
                  <div class="btn-area1" data-aos="fade-up" data-aos-duration="1200">
                    <a href="{{route('properties')}}" target="_blank" class="header-btn11"
                      style="padding: 10px 10px; margin-top: 10px;">
                      <i class="fa-solid fa-arrow-right"></i>
                    </a>
                  </div>
                </div>
                <div class="space20"></div>
                <div class="heading10">
                  <p class="service-desc " data-aos="fade-left" data-aos-duration="1000">
                    Explore a wide range of beautiful apartments, compare options, and book your ideal home
                    effortlessly
                    in just a few clicks.
                  </p>
                </div>
              </a>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="p-3 shadow-sm" style="border-radius: 15px;">
              <a href="{{route('register.apartment')}}">
                <div class="property-images">
                  <div class="img1 reveal image-anime">
                    <img src="assets/img/all-images/about/Register.jpeg" alt="" style="height: 250px">
                  </div>
                </div>
                <div class="space20"></div>
                <div class="d-flex justify-content-between heading7">
                  <h2 class="" data-aos="fade-left" data-aos-duration="1000" style="font-size: 25px">Register Your
                    Home
                  </h2>
                  <div class="btn-area1" data-aos="fade-up" data-aos-duration="1400">
                    <a href="{{route('register.apartment')}}" target="_blank" class="header-btn11"
                      style="padding: 10px 10px; margin-top: 10px;">
                      <i class="fa-solid fa-arrow-right"></i>
                    </a>
                  </div>
                </div>
                <div class="space20"></div>
                <div class="heading10">
                  <p class="service-desc " data-aos="fade-left" data-aos-duration="1200">
                    Easily showcase your property to a broad audience of potential renters, manage inquiries, and
                    maximize
                    your rental income.
                  </p>
                </div>
              </a>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="p-3 shadow-sm" style="border-radius: 15px;">
              <a href="{{route('home')}}">
                <div class="property-images">
                  <div class="img1 reveal image-anime">
                    <img src="assets/img/all-images/about/Ride.jpeg" alt="" style="height: 250px">
                  </div>
                </div>
                <div class="space20"></div>
                <div class="d-flex justify-content-between heading7">
                  <h2 class="" data-aos="fade-left" data-aos-duration="1200" style="font-size: 25px">Book a Ride</h2>
                  <div class="btn-area1" data-aos="fade-up" data-aos-duration="1400">
                    <a href="{{route('home')}}" target="_blank" class="header-btn11"
                      style="padding: 10px 10px; margin-top: 10px;">
                      <i class="fa-solid fa-arrow-right"></i>
                    </a>
                  </div>
                </div>
                <div class="space20"></div>
                <div class="heading10">
                  <p class="service-desc " data-aos="fade-left" data-aos-duration="1800">
                    Plan your apartment tours hassle-free by booking a reliable ride directly through our platform for
                    a
                    seamless experience.
                  </p>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="property10-section-area sp6" id="property" style="background: #fff7ee;">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-4">
            <div class="space20"></div>
            <div class="property-header heading10">
              <h5 data-aos="fade-left" data-aos-duration="1000">Did you Know?</h5>
              <div class="space20"></div>
              <p data-aos="fade-left" data-aos-duration="1800">
                We are not a usual hotel or apartment provider, here's why…
              </p>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="p-3 shadow-sm" style="border-radius: 15px;">
              <div class="heading7 text-center">
                <h2 class="" data-aos="fade-left" data-aos-duration="1200" style="font-size: 25px">Digital Check-in
                </h2>
              </div>
              <div class="space20"></div>
              <div class="heading10">
                <p class="service-desc text-center" data-aos="fade-left" data-aos-duration="1600">
                  There’s <b>no physical reception</b> desk, which means no queues and no waiting around.

                  Before you arrive, you’ll complete a quick <b>online check-in</b>. Once that’s done, you’ll receive
                  all the details you need for smooth, self check-in access, perfect if you’re arriving late at night
                  or
                  just don’t want the usual front desk process.
                </p>
                <div class="space20"></div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="p-3 shadow-sm" style="border-radius: 15px;">
              <div class="heading7 text-center">
                <h2 class="" data-aos="fade-left" data-aos-duration="1400" style="font-size: 25px">Your Space, Ready
                  for
                  You</h2>
              </div>
              <div class="space20"></div>
              <div class="heading10">
                <p class="service-desc text-center" data-aos="fade-left" data-aos-duration="1800">
                  Enjoy the <b>privacy</b> of having a place entirely to yourself. You can settle in at your own pace,
                  it’s your space to use however you need.

                  Before you arrive, every suite is <b>professionally cleaned and carefully prepared</b> with fresh
                  linens and
                  essential amenities for your needs.
                </p>
                <div class="space20"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!--===== SERVICE AREA STARTS =======-->
    {{-- <div class="service10-section-area sp6" id="amenities">
      <div class="side-img">
        <img src="assets/img/all-images/apartment/apartment-img9.png" alt="" data-aos="fade-right"
          data-aos-duration="1000">
      </div>
      <div class="side-img2">
        <img src="assets/img/all-images/apartment/apartment-img10.png" alt="" data-aos="fade-left"
          data-aos-duration="1200">
      </div>
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="service-heading space-margin60">
              <div class="heading10">
                <h5 data-aos="fade-left" data-aos-duration="800">Featured Apartment</h5>
                <div class="space20"></div>
                <h2 class="text-anime-style-3">Discover Our D.Villa's <br class="d-lg-block d-none"> Exceptional
                  Amenities</h2>
              </div>
              <div class="author-box" data-aos="zoom-in-up" data-aos-duration="1000">
                <div class="others-box">
                  <div class="img3">
                    <img src="assets/img/all-images/others/others-img1.png" alt="">
                  </div>
                  <div class="text">
                    <h3>Luxury Suite Villa</h3>
                    <div class="space10"></div>
                    <p>₦1,800,000</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="service-images-area">
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-5">
                  <div class="img1 image-anime reveal">
                    <img src="assets/img/all-images/apartment/apartment-img11.png" alt="">
                  </div>
                </div>
                <div class="col-lg-5">
                  <div class="heading10 author-header">
                    <p data-aos="fade-left" data-aos-duration="800">We offer the best city apartments tailored to your
                      urban lifestyle. Whether you're seeking a chic downtown loft or a serene uptown retreat, our
                      diverse portfolio ensures.</p>
                    <div class="space24"></div>
                    <div class="others-area">
                      <div class="box1" data-aos="fade-up" data-aos-duration="800">
                        <h2>4X</h2>
                        <div class="space16"></div>
                        <p>BedRooms</p>
                      </div>
                      <div class="box1" data-aos="fade-up" data-aos-duration="900">
                        <h2>3X</h2>
                        <div class="space16"></div>
                        <p>BathRoom</p>
                      </div>

                      <div class="box1" style="margin: 0;" data-aos="fade-up" data-aos-duration="1000">
                        <h2>1X</h2>
                        <div class="space16"></div>
                        <p>Fitness Room</p>
                      </div>
                    </div>
                    <div class="space10"></div>
                    <div class="list-area" data-aos="fade-up" data-aos-duration="1100">
                      <ul>
                        <li><a href="#"><img src="assets/img/icons/check1.svg" alt=""> ECO Construction</a></li>
                        <li><a href="#"><img src="assets/img/icons/check1.svg" alt=""> New Construction</a></li>
                      </ul>
                      <ul>
                        <li><a href="#"><img src="assets/img/icons/check1.svg" alt=""> Fitness Facilities</a></li>
                        <li><a href="#"><img src="assets/img/icons/check1.svg" alt=""> Swimming Pool</a></li>
                      </ul>
                    </div>
                    <div class="space40"></div>
                    <div class="btn-area1" data-aos="fade-up" data-aos-duration="1200">
                      <a href="javascript:void(0);" class="header-btn11"> Schedule A Visit <i
                          class="fa-solid fa-arrow-right"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> --}}
    <!--===== SERVICE AREA ENDS =======-->

    <div class="property10-section-area sp6" id="property">
      <div class="container">
        <div class="col-md-7">
          <div class="property-header heading10">
            <h5 data-aos="fade-left" data-aos-duration="800">Our Locations</h5>
            <div class="space20"></div>
            <p class="ms-2" data-aos="fade-left" data-aos-duration="800">Discover our wide variety of locations across
              Nigeria. All our Homes are situated in prime locations, conveniently connected to public transport &
              our suites are suitable for short city trips as well as longer business stays. Stay tuned!</p>
          </div>
          <div class="space40"></div>
        </div>
        <div class="row align-items-center">
          <div class="col-lg-4">
            <div class="p-3" style="border-radius: 15px;">
              <div class="property-images">
                <div class="img1 reveal image-anime">
                  <img src="assets/img/all-images/about/Abuja2.jpeg" alt="" style="height: 250px">
                </div>
              </div>
              <div class="space20"></div>
              <div class="d-flex justify-content-between heading7">
                <h2 class="" data-aos="fade-left" data-aos-duration="800" style="font-size: 25px"> Abuja</h2>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="p-3" style="border-radius: 15px;">
              <div class="property-images">
                <div class="img1 reveal image-anime">
                  <img src="assets/img/all-images/about/Lagos2.jpeg" alt="" style="height: 250px">
                </div>
              </div>
              <div class="space20"></div>
              <div class="d-flex justify-content-between heading7">
                <h2 class="" data-aos="fade-left" data-aos-duration="800" style="font-size: 25px"> Lagos</h2>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="p-3" style="border-radius: 15px;">
              <div class="property-images">
                <div class="img1 reveal image-anime">
                  <img src="assets/img/all-images/about/PH2.jpeg" alt="" style="height: 250px">
                </div>
              </div>
              <div class="space20"></div>
              <div class="d-flex justify-content-between heading7">
                <h2 class="" data-aos="fade-left" data-aos-duration="800" style="font-size: 25px"> Port-Harcourt</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!--===== APARTMENT AREA STARTS =======-->
    <div class="apartment10-area sp6" id="apartment">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="apartment-header heading10 space-margin60">
              <h5 data-aos="fade-left" data-aos-duration="800">Trending</h5>
              <div class="space20"></div>
              <h2 class="text-anime-style-2">Our Latest Featured Listings</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="arpart-slider-area owl-carousel">
              @if(count($properties) > 0)
                @foreach($properties as $property)
                  @php
                    $allImages = [$property->image_path ? asset('storage/' . $property->image_path) : asset('assets/img/all-images/apartment/apartment-img1.png')];
                    if ($property->images) {
                      foreach ($property->images as $img) {
                        $allImages[] = asset('storage/' . $img->image_path);
                      }
                    }
                  @endphp
                  <div class="apartment-boxarea">
                    <div class="img1 image-anime property-carousel">
                      @if(count($allImages) > 1)
                        <button class="carousel-btn prev" onclick="togglePropertyImage(this, 'prev')"><i
                            class="fa-solid fa-angle-left"></i></button>
                      @endif
                      <img src="{{ $allImages[0] }}" alt="" class="property-img-carousel"
                        data-images="{{ json_encode($allImages) }}" data-current-index="0"
                        style="height: 250px; width: 100%; object-fit: cover;">
                      @if(count($allImages) > 1)
                        <button class="carousel-btn next" onclick="togglePropertyImage(this, 'next')"><i
                            class="fa-solid fa-angle-right"></i></button>
                      @endif
                    </div>
                    <div class="content">
                      <div class="d-flex justify-content-between align-items-center">
                        <a href="javascript:void(0);">{{$property->name}}</a>
                      </div>
                      <div class="space16"></div>
                      <p style="font-size: 13px">{{$property->address}}, {{$property->city}}</p>
                      <div class="space24"></div>
                      <!--<ul>
                                                                                                                                                            @foreach($property->amenities as $amenity)
                                                                                                                                                              <li><a href="#" style="font-size: 14px; margin-bottom: 5px;">{{$amenity->name}}</a></li>
                                                                                                                                                            @endforeach
                                                                                                                                                          </ul>
                                                                                                                                                          <div class="space28"></div>-->
                      <div class="btn-area1">
                        <div class="single-btn">
                          <a href="#">₦ {{$property->price_per_night}}</a>
                        </div>
                        <div class="single-btn">
                          <a class="header-btn11"
                            href="{{ route('book_now', ['propertyId' => \Illuminate\Support\Facades\Crypt::encrypt($property->id)]) }}"
                            style="font-size: 14px">Book</a>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--===== APARTMENT AREA ENDS =======-->

    <!--===== GALLERY AREA STARTS =======-->
    <!--<div class="gallery10-section-area sp6" id="gallery">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 m-auto">
            <div class="galler-header text-center heading10 space-margin60">
              <h5 data-aos="fade-left" data-aos-duration="800">our gallery</h5>
              <div class="space20"></div>
              <h2 class="text-anime-style-2">Diamond Apartment Gallery</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12" data-aos="fade-up" data-aos-duration="1000">
            <div class="gallery-slider-area owl-carousel">
              <div class="content-area">
                <div class="img1">
                  <img src="assets/img/all-images/gallery/gallery-img2.png" alt="">
                </div>
                <div class="icons">
                  <a href="javascript:void(0);"><i class="fa-solid fa-plus"></i></a>
                </div>
              </div>

              <div class="content-area">
                <div class="img1">
                  <img src="assets/img/all-images/gallery/gallery-img3.png" alt="">
                </div>
                <div class="icons">
                  <a href="javascript:void(0);"><i class="fa-solid fa-plus"></i></a>
                </div>
              </div>

              <div class="content-area">
                <div class="img1">
                  <img src="assets/img/all-images/gallery/gallery-img5.png" alt="">
                </div>
                <div class="icons">
                  <a href="javascript:void(0);"><i class="fa-solid fa-plus"></i></a>
                </div>
              </div>
              <div class="content-area">
                <div class="img1">
                  <img src="assets/img/all-images/gallery/gallery-img6.png" alt="">
                </div>
                <div class="icons">
                  <a href="javascript:void(0);"><i class="fa-solid fa-plus"></i></a>
                </div>
              </div>
            </div>
            <div class="space30"></div>
            <div class="gallery2-slider-area owl-carousel">
              <div class="content-area">
                <div class="img1">
                  <img src="assets/img/all-images/gallery/gallery-img7.png" alt="">
                </div>
                <div class="icons">
                  <a href="javascript:void(0);"><i class="fa-solid fa-plus"></i></a>
                </div>
              </div>

              <div class="content-area">
                <div class="img1">
                  <img src="assets/img/all-images/gallery/gallery-img8.png" alt="">
                </div>
                <div class="icons">
                  <a href="javascript:void(0);"><i class="fa-solid fa-plus"></i></a>
                </div>
              </div>

              <div class="content-area">
                <div class="img1">
                  <img src="assets/img/all-images/gallery/gallery-img9.png" alt="">
                </div>
                <div class="icons">
                  <a href="javascript:void(0);"><i class="fa-solid fa-plus"></i></a>
                </div>
              </div>
              <div class="content-area">
                <div class="img1">
                  <img src="assets/img/all-images/gallery/gallery-img7.png" alt="">
                </div>
                <div class="icons">
                  <a href="javascript:void(0);"><i class="fa-solid fa-plus"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>-->
    <!--===== GALLERY AREA ENDS =======-->

    <!--===== PROPERTIES AREA STARTS =======-->
    {{-- <div class="property10-section-area sp6" id="property">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="row align-items-center">
              <div class="col-lg-6">
                <div class="property-header heading10">
                  <h5 data-aos="fade-left" data-aos-duration="800">Property plans</h5>
                  <div class="space20"></div>
                  <h2 class="text-anime-style-3">Your Apartment Plan</h2>
                  <div class="space16"></div>
                  <p data-aos="fade-left" data-aos-duration="1000">When developing property plans for a villa, it is
                    essential to consider several key elements to ensure the design is both functional and
                    aesthetically
                    pleasing. </p>
                  <div class="space6"></div>
                  <ul data-aos="fade-left" data-aos-duration="1100">
                    <li><span>Floor</span> <span>03</span></li>
                    <li><span>Rooms</span> <span>08</span></li>
                    <li><span>Area M2</span> <span>03</span></li>
                    <li><span>Parking</span> <span>03</span></li>
                    <li><span>Pricing</span> <span>₦7000/M2</span></li>
                  </ul>
                  <div class="space32"></div>
                  <div class="btn-area1" data-aos="fade-left" data-aos-duration="1200">
                    <a href="javascript:void(0);" class="header-btn11">Schedule Visit Now <i
                        class="fa-solid fa-arrow-right"></i></a>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="property-images">
                  <div class="img1 reveal image-anime">
                    <img src="assets/img/all-images/about/about-img1.png" alt="">
                  </div>
                  <div class="img2 reveal image-anime">
                    <img src="assets/img/all-images/about/about-img2.png" alt="">
                  </div>
                  <div class="elements" style="filter: hue-rotate(165deg) saturate(150%);">
                    <img src="assets/img/elements/elements14.png" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> --}}
    <!--===== PROPERTIES AREA ENDS =======-->

    <!--===== TESTIMONIAL AREA STARTS =======-->
    <div class="testimonial10-section-area sp1" id="testimonials">
      <div class="container">
        <div class="row">
          <div class="col-lg-5">
            <div class="testimonial-header space-margin60 heading10">
              <h5 data-aos="fade-left" data-aos-duration="800">testimonials</h5>
              <div class="space20"></div>
              <h2 class="text-anime-style-3">What Our Clients Say</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="testimonialmain-slider">
              <div class="row align-items-center">
                <div class="col-lg-5">
                  <div class="images-area slider2">
                    <div class="img1 reveal image-anime">
                      <img src="assets/img/all-images/testimonial/testimonial-img1.png" alt="">
                    </div>
                    <div class="img1 reveal image-anime">
                      <img src="assets/img/all-images/testimonial/testimonial-img1.png" alt="">
                    </div>
                    <div class="img1 reveal image-anime">
                      <img src="assets/img/all-images/testimonial/testimonial-img1.png" alt="">
                    </div>
                    <div class="img1 reveal image-anime">
                      <img src="assets/img/all-images/testimonial/testimonial-img1.png" alt="">
                    </div>
                  </div>
                </div>
                <div class="col-lg-7">
                  <div class="testimonial-slider-area slider1">
                    <div class="testimonial-box">
                      <img src="assets/img/icons/quoto-icon3.svg" alt="">
                      <div class="space16"></div>
                      <p>“Booked for my sister when she came to Abuja. The environment was safe and easy to locate.
                        She
                        was comfortable the whole time. She works remotely, so good WiFi is non-negotiable. The
                        connection was stable and she had no issues during her meetings.”</p>
                      <div class="space32"></div>
                      <div class="auhtor-area">
                        <div class="img1">
                          <img src="assets/img/all-images/testimonial/testimonial2.png" alt="">
                        </div>
                        <div class="text">
                          <a href="#">Kunle</a>
                          <div class="space10"></div>
                          <p>Satisfied Client</p>
                        </div>
                      </div>
                    </div>
                    <div class="testimonial-box">
                      <img src="assets/img/icons/quoto-icon3.svg" alt="">
                      <div class="space16"></div>
                      <p>“This property exceeded all our expectations, especially the magnificent swimming pool. It
                        was
                        like our own private paradise—beautifully designed and impeccably maintained. This was the
                        highlight of our honeymoon.”</p>
                      <div class="space32"></div>
                      <div class="auhtor-area">
                        <div class="img1">
                          <img src="assets/img/all-images/testimonial/testimonial-couple.png" alt="">
                        </div>
                        <div class="text">
                          <a href="#"> Mr & Mrs Buchi-Samuels</a>
                          <div class="space10"></div>
                          <p>Satisfied Clients</p>
                        </div>
                      </div>
                    </div>

                    <div class="testimonial-box">
                      <img src="assets/img/icons/quoto-icon3.svg" alt="">
                      <div class="space16"></div>
                      <p>“I booked a short stay in Lekki and everything was exactly as shown. No surprises. The
                        generator and inverter worked perfectly, which is very important in Lagos. I’ll definitely
                        use
                        this platform again.”</p>
                      <div class="space32"></div>
                      <div class="auhtor-area">
                        <div class="img1">
                          <img src="assets/img/all-images/testimonial/testimonial-img2.png" alt="">
                        </div>
                        <div class="text">
                          <a href="#">Grace Olawale</a>
                          <div class="space10"></div>
                          <p>Satisfied Client</p>
                        </div>
                      </div>
                    </div>

                    <div class="testimonial-box">
                      <img src="assets/img/icons/quoto-icon3.svg" alt="">
                      <div class="space16"></div>
                      <p>“I was skeptical at first, but everything exceeded my expectations. The apartment was
                        spotless,
                        secure, and exactly as advertised. Customer support followed up to ensure everything went
                        well.
                        That level of service is rare.”</p>
                      <div class="space32"></div>
                      <div class="auhtor-area">
                        <div class="img1">
                          <img src="assets/img/all-images/testimonial/testimonial-img5.png" alt="">
                        </div>
                        <div class="text">
                          <a href="#">Chidi Mbachu</a>
                          <div class="space10"></div>
                          <p>Satisfied Client</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="testimonial-arrows">
                    <div class="prev-arrow">
                      <button><i class="fa-solid fa-arrow-left"></i></button>
                    </div>
                    <div class="next-arrow">
                      <button><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--===== TESTIMONIAL AREA ENDS =======-->

    <!--===== BLOG AREA STARTS =======-->
    <div class="blog10-section-area sp7" id="blogs">
      <div class="container">
        <div class="row">
          <div class="col-lg-5 m-auto">
            <div class="blog-header text-center heading10 space-margin60">
              <h5 data-aos="fade-left" data-aos-duration="800">Our Blog</h5>
              <div class="space20"></div>
              <h2 class="text-anime-style-3">Our News & Articles</h2>
            </div>
          </div>
        </div>
        <div class="row">
          @if(isset($blog_posts) && count($blog_posts) > 0)
            @foreach($blog_posts as $post)
              <div class="col-lg-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="800">
                <div class="blog-boxarea">
                  <div class="img1 image-anime">
                    <img
                      src="{{ $post->image_path ? asset('storage/' . $post->image_path) : 'assets/img/all-images/blog/blog-img3.png' }}"
                      alt="{{ $post->title }}" style="height: 250px; object-fit: cover;">
                  </div>
                  <div class="content-area">
                    <ul>
                      <li><a href="#"><img src="assets/img/icons/user.svg" alt="">
                          {{ $post->user->first_name ?? 'Admin' }}</a> <span> | </span></li>
                      <li><a href="#"><img src="assets/img/icons/calender.svg" alt="">
                          {{ $post->published_at ? $post->published_at->format('d M, Y') : 'Draft' }}</a></li>
                    </ul>
                    <div class="space20"></div>
                    <a href="{{ route('blog.show', $post->slug) }}" class="d-block text-truncate"
                      style="max-width: 100%;">{{ $post->title }}</a>
                    <div class="space24"></div>
                    <p class="mb-3"
                      style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; height: 4.5em;">
                      {{ $post->excerpt ?? strip_tags($post->content) }}
                    </p>
                    <a href="{{ route('blog.show', $post->slug) }}" class="readmore">Read More <i
                        class="fa-solid fa-arrow-right"></i></a>
                  </div>
                </div>
              </div>
            @endforeach
          @else
            <div class="col-12 text-center">
              <p>Check back soon for our latest updates!</p>
            </div>
          @endif
        </div>
      </div>
    </div>
    <!--===== BLOG AREA ENDS =======-->

    @include('partials.frontend.footer')

    <script>
      $('#heroTabs a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
      })





      document.addEventListener('DOMContentLoaded', function () {
        const searchForm = document.querySelector('form[action="{{ route("search") }}"]');

        if (searchForm) {
          searchForm.addEventListener('submit', function (e) {
            e.preventDefault(); // PREVENT DEFAULT FIRST

            const checkIn = document.querySelector('input[name="check_in"]');
            const checkOut = document.querySelector('input[name="check_out"]');
            const guests = document.querySelector('input[name="guests"]');

            let isValid = true;

            // Clear previous error styles
            clearErrors();

            // Validate check-in date
            if (!checkIn.value) {
              showError(checkIn, 'Check-in date is required');
              isValid = false;
            }

            // Validate check-out date
            if (!checkOut.value) {
              showError(checkOut, 'Check-out date is required');
              isValid = false;
            }

            // Validate guests
            if (!guests.value) {
              showError(guests, 'Enter Number of Guests');
              isValid = false;
            } else if (guests.value <= 0) {
              showError(guests, 'Number of guests must be at least 1');
              isValid = false;
            }

            // Validate date logic
            if (checkIn.value && checkOut.value) {
              const checkInDate = new Date(checkIn.value);
              const checkOutDate = new Date(checkOut.value);

              if (checkOutDate <= checkInDate) {
                showError(checkOut, 'Check-out date must be after check-in date');
                isValid = false;
              }
            }

            if (isValid) {
              // Only submit if validation passes
              this.submit();
            } else {
              // Show alert for better visibility
              alert('Please fill in all required fields correctly.');

              // Add visual feedback to the search button
              const searchBtn = this.querySelector('.search');
              if (searchBtn) {
                searchBtn.style.backgroundColor = '#dc3545';
                searchBtn.textContent = 'Please Fix Errors';
                setTimeout(() => {
                  searchBtn.style.backgroundColor = '';
                  searchBtn.innerHTML = 'Search <i class="fa-solid fa-arrow-right"></i>';
                }, 2000);
              }
            }
          });

          function showError(input, message) {
            // Add red border
            input.style.border = '2px solid #dc3545';
            input.style.backgroundColor = '#fff5f5';

            // Create error message element
            let errorElement = input.parentNode.querySelector('.error-message');
            if (!errorElement) {
              errorElement = document.createElement('div');
              errorElement.className = 'error-message text-danger small mt-1';
              errorElement.style.color = '#dc3545';
              errorElement.style.fontSize = '12px';
              errorElement.style.marginTop = '5px';
              input.parentNode.appendChild(errorElement);
            }
            errorElement.textContent = message;

            // Focus on the first error field
            if (!document.querySelector('input.error-focused')) {
              input.classList.add('error-focused');
              input.focus();
            }
          }

          function clearErrors() {
            const inputs = document.querySelectorAll('input[name="check_in"], input[name="check_out"], input[name="guests"]');
            inputs.forEach(input => {
              input.style.border = '';
              input.style.backgroundColor = '';
              input.classList.remove('error-focused');

              const errorElement = input.parentNode.querySelector('.error-message');
              if (errorElement) {
                errorElement.remove();
              }
            });
          }

          // Real-time validation as user types
          const inputs = document.querySelectorAll('input[name="check_in"], input[name="check_out"], input[name="guests"]');
          inputs.forEach(input => {
            input.addEventListener('input', function () {
              clearFieldError(this);
            });

            input.addEventListener('blur', function () {
              validateField(this);
            });
          });

          function validateField(input) {
            clearFieldError(input);

            if (!input.value) {
              let message = '';
              if (input.name === 'check_in') message = 'Check-in date is required';
              else if (input.name === 'check_out') message = 'Check-out date is required';
              else if (input.name === 'guests') message = 'Enter Number of Guests';

              if (message) showError(input, message);
            } else if (input.name === 'guests' && input.value <= 0) {
              showError(input, 'Number of guests must be at least 1');
            } else if ((input.name === 'check_in' || input.name === 'check_out') &&
              document.querySelector('input[name="check_in"]').value &&
              document.querySelector('input[name="check_out"]').value) {
              // Validate date logic if both dates are filled
              const checkIn = document.querySelector('input[name="check_in"]');
              const checkOut = document.querySelector('input[name="check_out"]');
              const checkInDate = new Date(checkIn.value);
              const checkOutDate = new Date(checkOut.value);

              if (checkOutDate <= checkInDate) {
                showError(checkOut, 'Check-out date must be after check-in date');
              }
            }
          }

          function clearFieldError(input) {
            input.style.border = '';
            input.style.backgroundColor = '';

            const errorElement = input.parentNode.querySelector('.error-message');
            if (errorElement) {
              errorElement.remove();
            }
          }
        }
      });

      // Tab functionality
      $('#heroTabs a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
      });

      // Location Autocomplete
      const locationInput = document.getElementById('locationSearch');
      const suggestionsContainer = document.getElementById('locationSuggestions');
      let debounceTimer;

      if (locationInput) {
        locationInput.addEventListener('input', function () {
          const query = this.value;
          clearTimeout(debounceTimer);

          if (query.length < 2) {
            suggestionsContainer.style.display = 'none';
            return;
          }

          debounceTimer = setTimeout(() => {
            fetch(`{{ route('api.locations') }}?q=${encodeURIComponent(query)}`)
              .then(response => response.json())
              .then(data => {
                suggestionsContainer.innerHTML = '';
                if (data.length > 0) {
                  data.forEach(location => {
                    const div = document.createElement('div');
                    div.className = 'suggestion-item';
                    div.textContent = location;
                    div.addEventListener('click', () => {
                      locationInput.value = location;
                      suggestionsContainer.style.display = 'none';
                    });
                    suggestionsContainer.appendChild(div);
                  });
                  suggestionsContainer.style.display = 'block';
                } else {
                  suggestionsContainer.style.display = 'none';
                }
              })
              .catch(error => console.error('Error fetching locations:', error));
          }, 300);
        });

        // Close suggestions when clicking outside
        document.addEventListener('click', function (e) {
          if (e.target !== locationInput && e.target !== suggestionsContainer) {
            suggestionsContainer.style.display = 'none';
          }
        });
      }
    </script>

</body>

</html>