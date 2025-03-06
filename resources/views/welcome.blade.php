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
    <link rel="stylesheet" href="assets/css/main.css">

    <!--=====  JS SCRIPT LINK =======-->
    <script src="assets/js/plugins/jquery-3-6-0.min.js"></script>
</head>
<body class="homepage10-body">

<!--===== PRELOADER STARTS =======-->
<div class="preloader" style="background-image: url('assets/img/logo/preloader.gif'); filter: hue-rotate(315deg) saturate(80%)"></div>
<!--===== PRELOADER ENDS =======-->

<!--===== PROGRESS STARTS=======-->
<div class="paginacontainer">
     <div class="progress-wrap">
       <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
         <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
       </svg>
     </div>
   </div>
 <!--===== PROGRESS ENDS=======-->

  <!--=====HEADER START=======-->
  <header>
    <div class="header-area homepage10 header header-sticky d-none d-lg-block " id="header">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <nav id="navbar-example2" class="navbar">
            <div class="header-elements">
              <div class="site-logo">
                <a href="/"><img src="assets/img/logo/stay-smart.png" alt=""></a>
              </div>
              <div class="main-menu">
                <ul>
                    {{-- <li class="nav-item"><a href="#amenities" class="nav-link active"><span>Amenities</span></a></li> --}}
                    <li class="nav-item"><a href="#apartment" class="nav-link"><span>Apartment</span></a></li>
                    <li class="nav-item"><a href="#gallery" class="nav-link"><span>Gallery</span></a></li>
                    <li class="nav-item"><a href="#property" class="nav-link"><span>Property</span></a></li>
                    <li class="nav-item"><a href="#testimonials" class="nav-link"><span>Testimonials</span></a></li>
                    <li class="nav-item"><a href="{{route('home')}}" class="nav-link"><span>My Account</span></a></li>
                </ul>
              </div>
              <div class="btn-area4">
                <div class="search-icon header__search header-search-btn">
                  <a href="#"><img src="assets/img/icons/search-icon1.svg" alt=""> <span></span></a>
                </div>
                <ul>
                  <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                  <li><a href="#"><i class="fa-brands fa-google-plus-g"></i></a></li>
                  <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                  <li><a href="#" class="m-0"><i class="fa-brands fa-youtube"></i></a></li>
                </ul>
              </div>

              <div class="header-search-form-wrapper">
                <div class="tx-search-close tx-close"><i class="fa-solid fa-xmark"></i></div>
                <div class="header-search-container">
                    <form role="search" class="search-form">
                    <input type="search"  class="search-field" placeholder="Search …" value="" name="s">
                    <button type="submit" class="search-submit"><img src="assets/img/icons/search-icon1.svg" alt=""></button>
                    </form>
                </div>
            </div>
            <div class="body-overlay"></div>
            </div>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!--=====HEADER END =======-->

  <!--===== MOBILE HEADER STARTS =======-->
  <div class="mobile-header mobile-haeder10 d-block d-lg-none">
    <div class="container-fluid">
      <div class="col-12">
        <div class="mobile-header-elements">
          <div class="mobile-logo">
            <a href="javascript:void(0);"><img src="assets/img/logo/stay-smart.png" alt=""></a>
          </div>
          <div class="mobile-nav-icon dots-menu">
            <i class="fa-solid fa-bars"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="mobile-sidebar mobile-sidebar10">
    <div class="logosicon-area">
      <div class="logos">
        <img src="assets/img/logo/stay-smart.png" alt="">
      </div>
      <div class="menu-close">
        <i class="fa-solid fa-xmark"></i>
      </div>
     </div>
    <div class="mobile-nav mobile-nav1">
      <ul class="mobile-nav-list nav-list1">
        {{-- <li class="nav-item"><a href="#amenities" class="nav-link active"><span>Amenities</span></a></li> --}}
        <li class="nav-item"><a href="#apartment" class="nav-link"><span>Apartment</span></a></li>
        <li class="nav-item"><a href="#gallery" class="nav-link"><span>Gallery</span></a></li>
        <li class="nav-item"><a href="#property" class="nav-link"><span>Property</span></a></li>
        <li class="nav-item"><a href="#testimonials" class="nav-link"><span>Testimonials</span></a></li>
        <li class="nav-item"><a href="{{route('home')}}" class="nav-link"><span>My Account</span></a></li>
      </ul>

      <div class="allmobilesection">
        <a href="{{route('home')}}"  class="header-btn11">Get Started <span><i class="fa-solid fa-arrow-right"></i></span></a>
        <div class="single-footer">
          <h3>Contact Info</h3>
          <div class="footer1-contact-info">
            <div class="contact-info-single">
              <div class="contact-info-icon">
                <i class="fa-solid fa-phone-volume"></i>
              </div>
              <div class="contact-info-text">
                <a href="tel:+(234)7044479938">+(234) 704 447 9938
                </a>
              </div>
            </div>

            <div class="contact-info-single">
              <div class="contact-info-icon">
                <i class="fa-solid fa-envelope"></i>
              </div>
              <div class="contact-info-text">
                <a href="mailto:staysmartbookings@gmail.com">staysmartbookings@gmail.com
                </a>
              </div>
            </div>

            {{-- <div class="single-footer">
              <h3>Our Location</h3>

              <div class="contact-info-single">
                <div class="contact-info-icon">
                  <i class="fa-solid fa-location-dot"></i>
                </div>
                <div class="contact-info-text">
                  <a href="mailto:info@example.com" >55 East Birchwood Ave.Brooklyn, <br> New York 11201,United States</a>
                </div>
              </div>

            </div> --}}
            <div class="single-footer">
              <h3>Social Links</h3>

              <div class="social-links-mobile-menu">
                <ul>
                  <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                  <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                  <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                  <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
       </div>
    </div>
  </div>
<!--===== MOBILE HEADER STARTS =======-->

<!--===== HERO AREA STARTS =======-->
<div class="hero10-section-area">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <div class="space70"></div>
                <div class="hero10-header">
                    {{-- <h5 data-aos="fade-left" data-aos-duration="800"><i class="fa-solid fa-location-dot"></i> 538 Amino Kano Crescent, Wuse 2, Abuja.</h5> --}}
                    <h2 class="text-anime-style-2">Book your smart stay with us.</h2>
                    <div class="space32"></div>
                    <div class="btn-area1" data-aos="fade-left" data-aos-duration="1000">
                        <a href="javascript:void(0);" class="header-btn11">See Apartments <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 hero-nav-tabs-div mt-4" data-aos="zoom-in-up" data-aos-duration="1000">
                <div class="space70"></div>
                <ul class="nav nav-tabs hero-nav-tabs gap-2" id="heroTabs" role="tablist" style="width: max-content">
                    <li class="nav-item">
                      <a class="nav-link active" id="book-tab" data-toggle="tab" href="#book" role="tab" aria-controls="book" aria-selected="true">Book with us</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="checkIn-tab" data-toggle="tab" href="#checkIn" role="tab" aria-controls="checkIn" aria-selected="false">Check-in</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="bookings-tab" data-toggle="tab" href="#bookings" role="tab" aria-controls="bookings" aria-selected="false">Your Booking</a>
                    </li>
                </ul>
                <div class="header-contact-box tab-content" id="heroTabsContent" style="border-top-left-radius: 0;">
                    <div class="row tab-pane fade show active" id="book" role="tabpanel" aria-labelledby="book-tab">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="input-area">
                                        <label class="d-lg-none" for="location">Location</label>
                                        <input type="text" name="location" placeholder="Location">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-area">
                                        <label class="d-lg-none mt-3" for="check-in">Check-in</label>
                                        <input type="date" name="check-in" placeholder="Check-in">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-area">
                                        <label class="d-lg-none mt-3" for="check-out">Check-out</label>
                                        <input type="date" name="check-out" placeholder="Check-out">
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
                                <button type="submit" class="header-btn11 search">Search <i class="fa-solid fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row tab-pane fade" id="checkIn" role="tabpanel" aria-labelledby="checkIn-tab">
                        <div class="col-md-12">
                            <h3>Online check-in</h3>
                            <div class="space20"></div>
                        </div>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-area">
                                        <label class="d-lg-none mt-3" for="last_name">Last Name</label>
                                        <input type="text" name="last_name" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-area">
                                        <label class="d-lg-none mt-3" for="booking_reference">Booking Reference</label>
                                        <input type="number" name="booking_reference" placeholder="Booking Reference">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 align-items-center d-flex justify-content-end">
                            <div class="input-area text-end">
                                <div class="space30 d-lg-none"></div>
                                <button type="submit" class="header-btn11 search">Submit <i class="fa-solid fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row tab-pane fade" id="bookings" role="tabpanel" aria-labelledby="bookings-tab">
                        <div class="col-md-12">
                            <h3>Access your booking information</h3>
                            <div class="space20"></div>
                        </div>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-area">
                                        <label class="d-lg-none mt-3" for="last_name">Last Name</label>
                                        <input type="text" name="last_name" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-area">
                                        <label class="d-lg-none mt-3" for="booking_reference">Booking Reference</label>
                                        <input type="number" name="booking_reference" placeholder="Booking Reference">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 align-items-center d-flex justify-content-end">
                            <div class="input-area text-end">
                                <div class="space30 d-lg-none"></div>
                                <button type="submit" class="header-btn11 search">Submit <i class="fa-solid fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== HERO AREA ENDS =======-->
<div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary rounded-2" tabindex="0">

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
                    <div class="property-images">
                        <div class="img1 reveal image-anime">
                            <img src="assets/img/all-images/about/about-img1.png" alt="" style="height: 250px">
                        </div>
                    </div>
                    <div class="space20"></div>
                    <div class="d-flex justify-content-between heading7">
                        <h2 class="" data-aos="fade-left" data-aos-duration="800" style="font-size: 25px"> Book Apartments</h2>
                        <div class="btn-area1" data-aos="fade-up" data-aos-duration="1200">
                            <a href="{{route('home')}}" target="_blank" class="header-btn11" style="padding: 10px 10px; margin-top: 10px;">
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="space20"></div>
                    <div class="heading10">
                        <p class="service-desc " data-aos="fade-left" data-aos-duration="1000">
                            Explore a wide range of beautiful apartments, compare options, and book your ideal home effortlessly in just a few clicks.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="p-3 shadow-sm" style="border-radius: 15px;">
                    <div class="property-images">
                        <div class="img1 reveal image-anime">
                            <img src="assets/img/all-images/about/about-img2.png" alt="" style="height: 250px">
                        </div>
                    </div>
                    <div class="space20"></div>
                    <div class="d-flex justify-content-between heading7">
                        <h2 class="" data-aos="fade-left" data-aos-duration="1000" style="font-size: 25px">List Your Apartments</h2>
                        <div class="btn-area1" data-aos="fade-up" data-aos-duration="1400">
                            <a href="{{route('home')}}" target="_blank" class="header-btn11" style="padding: 10px 10px; margin-top: 10px;">
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="space20"></div>
                    <div class="heading10">
                        <p class="service-desc " data-aos="fade-left" data-aos-duration="1200">
                            Easily showcase your property to a broad audience of potential renters, manage inquiries, and maximize your rental income.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="p-3 shadow-sm" style="border-radius: 15px;">
                    <div class="property-images">
                        <div class="img1 reveal image-anime">
                            <img src="assets/img/all-images/about/vehicles.jpeg" alt="" style="height: 250px">
                        </div>
                    </div>
                    <div class="space20"></div>
                    <div class="d-flex justify-content-between heading7">
                        <h2 class="" data-aos="fade-left" data-aos-duration="1200" style="font-size: 25px">Book a Ride</h2>
                        <div class="btn-area1" data-aos="fade-up" data-aos-duration="1400">
                            <a href="{{route('home')}}" target="_blank" class="header-btn11" style="padding: 10px 10px; margin-top: 10px;">
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="space20"></div>
                    <div class="heading10">
                        <p class="service-desc " data-aos="fade-left" data-aos-duration="1800">
                            Plan your apartment tours hassle-free by booking a reliable ride directly through our platform for a seamless experience.
                        </p>
                    </div>
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
                    <p  data-aos="fade-left" data-aos-duration="1800">
                        We are not a usual hotel or apartment provider, here's why…
                    </p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="p-3 shadow-sm" style="border-radius: 15px;">
                    <div class="heading7 text-center">
                        <h2 class="" data-aos="fade-left" data-aos-duration="1200" style="font-size: 25px">Digital Check-in</h2>
                    </div>
                    <div class="space20"></div>
                    <div class="heading10">
                        <p class="service-desc text-center" data-aos="fade-left" data-aos-duration="1600">
                            <b>No physical reception</b> on site means <b>less waiting time</b>  for you, but a mandatory <b>online check-in</b> before your arrival.
                        </p>
                        <div class="space20"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="p-3 shadow-sm" style="border-radius: 15px;">
                    <div class="heading7 text-center">
                        <h2 class="" data-aos="fade-left" data-aos-duration="1400" style="font-size: 25px">Bed Layout</h2>
                    </div>
                    <div class="space20"></div>
                    <div class="heading10">
                        <p class="service-desc text-center" data-aos="fade-left" data-aos-duration="1800">
                            Our suites are usually equipped with <b>double beds</b>  - suites for more than 2 adults tend to have an <b>additional sofa bed</b>.
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
      <img src="assets/img/all-images/apartment/apartment-img9.png" alt="" data-aos="fade-right" data-aos-duration="1000">
    </div>
    <div class="side-img2">
      <img src="assets/img/all-images/apartment/apartment-img10.png" alt="" data-aos="fade-left" data-aos-duration="1200">
    </div>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="service-heading space-margin60">
            <div class="heading10">
              <h5 data-aos="fade-left" data-aos-duration="800">Featured Apartment</h5>
              <div class="space20"></div>
              <h2 class="text-anime-style-3">Discover Our D.Villa's <br class="d-lg-block d-none"> Exceptional Amenities</h2>
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
            <p data-aos="fade-left" data-aos-duration="800">We offer the best city apartments tailored to your urban lifestyle. Whether you're seeking a chic downtown loft or a serene uptown retreat, our diverse portfolio ensures.</p>
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
              <a href="javascript:void(0);" class="header-btn11"> Schedule A Visit <i class="fa-solid fa-arrow-right"></i></a>
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
                <p class="ms-2" data-aos="fade-left" data-aos-duration="800">Discover our wide variety of locations across Europe. All our Smart Homes are situated in prime locations, conveniently connected to public transport & our suites are suitable for short city trips as well as longer business stays. Stay tuned!</p>
            </div>
            <div class="space40"></div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-4">
                <div class="p-3" style="border-radius: 15px;">
                    <div class="property-images">
                        <div class="img1 reveal image-anime">
                            <img src="assets/img/all-images/about/abuja.jpg" alt="" style="height: 250px">
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
                            <img src="assets/img/all-images/about/lagos.jpg" alt="" style="height: 250px">
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
                            <img src="assets/img/all-images/about/port.webp" alt="" style="height: 250px">
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
            <h5 data-aos="fade-left" data-aos-duration="800">recent added apartment</h5>
            <div class="space20"></div>
            <h2 class="text-anime-style-2">Our Latest Featured Listing</h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="arpart-slider-area owl-carousel">
            @if(count($properties)>0)
                @foreach($properties as $property)
                    <div class="apartment-boxarea">
                    <div class="img1 image-anime">
                        <img src="{{ asset('storage/' . $property->image_path) }}" alt="">
                    </div>
                    <div class="content">
                        <a href="javascript:void(0);">{{$property->name}}</a>
                        <div class="space16"></div>
                        <p style="font-size: 13px">{{$property->address}}, {{$property->city}}</p>
                        <div class="space24"></div>
                        <ul>
                            @foreach($property->amenities as $amenity)
                                <li><a href="#" style="font-size: 14px; margin-bottom: 5px;">{{$amenity->name}}</a></li>
                            @endforeach
                        </ul>
                        <div class="space28"></div>
                        <div class="btn-area1">
                            <div class="single-btn">
                                <a href="#" >₦ {{$property->price_per_night}}</a>
                            </div>
                            <div class="single-btn">
                                <a class="header-btn11" href="{{route('booking.book', $property->id)}}" style="font-size: 14px">Book</a>
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
<div class="gallery10-section-area sp6" id="gallery">
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
</div>
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
                <p data-aos="fade-left" data-aos-duration="1000">When developing property plans for a villa, it is essential to consider several key elements to ensure the design is both functional and aesthetically pleasing. </p>
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
                  <a href="javascript:void(0);" class="header-btn11">Schedule Visit Now <i class="fa-solid fa-arrow-right"></i></a>
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
            <h5 data-aos="fade-left" data-aos-duration="800">testimonial</h5>
            <div class="space20"></div>
            <h2 class="text-anime-style-3">What Our Client Says</h2>
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
                    <p>“This property exceeded all our expectations, especially the magnificent swimming pool. It was like our own private paradise—beautifully designed and impeccably maintained.”</p>
                    <div class="space32"></div>
                    <div class="auhtor-area">
                      <div class="img1">
                        <img src="assets/img/all-images/testimonial/testimonial-img2.png" alt="">
                      </div>
                      <div class="text">
                        <a href="#">Shakib Mahmud</a>
                        <div class="space10"></div>
                        <p>Happy Client</p>
                      </div>
                    </div>
                  </div>
                  <div class="testimonial-box">
                    <img src="assets/img/icons/quoto-icon3.svg" alt="">
                    <div class="space16"></div>
                    <p>“This property exceeded all our expectations, especially the magnificent swimming pool. It was like our own private paradise—beautifully designed and impeccably maintained.”</p>
                    <div class="space32"></div>
                    <div class="auhtor-area">
                      <div class="img1">
                        <img src="assets/img/all-images/testimonial/testimonial-img2.png" alt="">
                      </div>
                      <div class="text">
                        <a href="#">Shakib Mahmud</a>
                        <div class="space10"></div>
                        <p>Happy Client</p>
                      </div>
                    </div>
                  </div>

                  <div class="testimonial-box">
                    <img src="assets/img/icons/quoto-icon3.svg" alt="">
                    <div class="space16"></div>
                    <p>“This property exceeded all our expectations, especially the magnificent swimming pool. It was like our own private paradise—beautifully designed and impeccably maintained.”</p>
                    <div class="space32"></div>
                    <div class="auhtor-area">
                      <div class="img1">
                        <img src="assets/img/all-images/testimonial/testimonial-img2.png" alt="">
                      </div>
                      <div class="text">
                        <a href="#">Shakib Mahmud</a>
                        <div class="space10"></div>
                        <p>Happy Client</p>
                      </div>
                    </div>
                  </div>

                  <div class="testimonial-box">
                    <img src="assets/img/icons/quoto-icon3.svg" alt="">
                    <div class="space16"></div>
                    <p>“This property exceeded all our expectations, especially the magnificent swimming pool. It was like our own private paradise—beautifully designed and impeccably maintained.”</p>
                    <div class="space32"></div>
                    <div class="auhtor-area">
                      <div class="img1">
                        <img src="assets/img/all-images/testimonial/testimonial-img2.png" alt="">
                      </div>
                      <div class="text">
                        <a href="#">Shakib Mahmud</a>
                        <div class="space10"></div>
                        <p>Happy Client</p>
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
      <div class="col-lg-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="800">
        <div class="blog-boxarea">
          <div class="img1 image-anime">
            <img src="assets/img/all-images/blog/blog-img3.png" alt="">
          </div>
          <div class="content-area">
            <ul>
              <li><a href="#"><img src="assets/img/icons/user.svg" alt=""> Joe Root</a> <span> | </span></li>
              <li><a href="#"><img src="assets/img/icons/calender.svg" alt=""> 16 April, 2024</a></li>
            </ul>
            <div class="space20"></div>
            <a href="javascript:void(0);">How Luxury Suite Offers the Perfect Blend the Comfort</a>
            <div class="space24"></div>
            <a href="javascript:void(0);" class="readmore">Read More <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="1000">
        <div class="blog-boxarea">
          <div class="img1 image-anime">
            <img src="assets/img/all-images/blog/blog-img4.png" alt="">
          </div>
          <div class="content-area">
            <ul>
              <li><a href="#"><img src="assets/img/icons/user.svg" alt=""> Joe Root</a> <span> | </span></li>
              <li><a href="#"><img src="assets/img/icons/calender.svg" alt=""> 16 April, 2024</a></li>
            </ul>
            <div class="space20"></div>
            <a href="javascript:void(0);">Guest Spotlight: Memorable Moments at Luxury Suite Villa</a>
            <div class="space24"></div>
            <a href="javascript:void(0);" class="readmore">Read More <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="1200">
        <div class="blog-boxarea">
          <div class="img1 image-anime">
            <img src="assets/img/all-images/blog/blog-img5.png" alt="">
          </div>
          <div class="content-area">
            <ul>
              <li><a href="#"><img src="assets/img/icons/user.svg" alt=""> Joe Root</a> <span> | </span></li>
              <li><a href="#"><img src="assets/img/icons/calender.svg" alt=""> 16 April, 2024</a></li>
            </ul>
            <div class="space20"></div>
            <a href="javascript:void(0);">Behind the Scenes: The Art of Creating Luxury Suite Villa</a>
            <div class="space24"></div>
            <a href="javascript:void(0);" class="readmore">Read More <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--===== BLOG AREA ENDS =======-->

<!--===== FOOTER AREA STARTS =======-->
<div class="footer10-section-area">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="footer-instagram-area">
            <div class="row">
              <div class="col-lg-6" data-aos="zoom-in-down" data-aos-duration="1000">
                <div class="footer-contact-box">
                    <h3>Send Us A Message</h3>
                    <div class="space16"></div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="space16"></div>
                            <div class="input-area">
                                <input type="text" placeholder="Your Name*">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="space16"></div>
                            <div class="input-area">
                                <input type="number" placeholder="Mobile Number*">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="space16"></div>
                            <div class="input-area">
                               <textarea placeholder="Your Message*"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="space32"></div>
                            <div class="input-area text-end">
                                <button type="submit" class="header-btn11">Send Message <i class="fa-solid fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="instagram-images">
                    <div class="row">
                        <div class="col-lg-5 col-md-6" data-aos="fade-up" data-aos-duration="800">
                            <div class="instagram-posts">
                                <div class="img1">
                                  <img src="assets/img/all-images/others/others-img7.png" alt="">
                                </div>
                                <div class="icons">
                                  <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                </div>
                              </div>
                        </div>
                        <div class="col-lg-7 col-md-6" data-aos="fade-up" data-aos-duration="1000">
                            <div class="instagram-posts">
                                <div class="img1">
                                  <img src="assets/img/all-images/others/others-img8.png" alt="">
                                </div>
                                <div class="icons">
                                  <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                </div>
                              </div>
                        </div>

                        <div class="col-lg-7 col-md-6" data-aos="fade-up" data-aos-duration="1200">
                            <div class="instagram-posts">
                                <div class="img1">
                                  <img src="assets/img/all-images/others/others-img9.png" alt="">
                                </div>
                                <div class="icons">
                                  <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                </div>
                              </div>
                        </div>

                        <div class="col-lg-5 col-md-6" data-aos="fade-up" data-aos-duration="1000">
                            <div class="instagram-posts">
                                <div class="img1">
                                  <img src="assets/img/all-images/others/others-img10.png" alt="">
                                </div>
                                <div class="icons">
                                  <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
  <div class="space40"></div>
  <div class="footer10-bottom-section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="footer-bottom-area">
            <div class="footer-menu-area">
              <div class="footer-logo">
                <a href="javascript:void(0);"><img src="assets/img/logo/stay-smart.png" alt=""></a>
              </div>
              <div class="footer-menu">
                <ul>
                  <li><a href="javascript:void(0);">Home</a></li>
                  <li class="space24"></li>
                  <li><a href="javascript:void(0);">Properties</a></li>
                  <li class="space24"></li>
                  <li><a href="javascript:void(0);">Gallery</a></li>
                </ul>
              </div>
              <div class="footer-menu">
                <ul>
                  <li><a href="javascript:void(0);">Blog</a></li>
                  <li class="space24"></li>
                  <li><a href="#">Pages</a></li>
                  <li class="space24"></li>
                  <li><a href="javascript:void(0);">Contact</a></li>
                </ul>
              </div>
              <div class="footer-menu2">
                <ul>
                  {{-- <li><a href="#"> <span><i class="fa-solid fa-location-dot"></i></span> <span>65, Brand Tower <br> New York, USA </span></a></li> --}}
                  <li class="space24"></li>
                  <li><a href="tel:+(234) 704 447 9938"><span><i class="fa-solid fa-phone"></i></span> <span>+(234) 704 447 9938</span></a></li>
                </ul>
              </div>
              <div class="footer-social">
               <ul>
                <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-google-plus-g"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
               </ul>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="space48"></div>
                <div class="copyright-area">
                  <p>© 2024 Stay Smart Apartments</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--===== FOOTER AREA ENDS =======-->
</div>
<!--===== JS SCRIPT LINK =======-->
<script src="assets/js/plugins/bootstrap.min.js"></script>
<script src="assets/js/plugins/fontawesome.js"></script>
<script src="assets/js/plugins/aos.js"></script>
<script src="assets/js/plugins/counter.js"></script>
<script src="assets/js/plugins/sidebar.js"></script>
<script src="assets/js/plugins/magnific-popup.js"></script>
<script src="assets/js/plugins/mobilemenu.js"></script>
<script src="assets/js/plugins/owlcarousel.min.js"></script>
<script src="assets/js/plugins/nice-select.js"></script>
<script src="assets/js/plugins/waypoints.js"></script>
<script src="assets/js/plugins/slick-slider.js"></script>
<script src="assets/js/plugins/circle-progress.js"></script>
<script src="assets/js/plugins/gsap.min.js"></script>
<script src="assets/js/plugins/ScrollTrigger.min.js"></script>
<script src="assets/js/plugins/Splitetext.js"></script>
<script src="assets/js/main.js"></script>

<script>
    $('#heroTabs a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    })
</script>

</body>
</html>
