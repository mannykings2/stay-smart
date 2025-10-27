<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <link rel="stylesheet" href="assets/css/plugins/sweetalert2.css" />
    <link rel="stylesheet" href="assets/css/main.css?2">

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
.apartment11-area  {
  position: relative;
  z-index: 1;
}
.apartment11-area  .apartment-boxarea {
  background: var(--ztc-bg-bg-1);
  border-radius: 16px;
  position: relative;
  z-index: 1;
  overflow: hidden;
}
.apartment11-area  .apartment-boxarea:hover .img1 img {
  transform: scale(1.1) rotate(-4deg);
  transition: all 0.4s;
}
.apartment11-area  .apartment-boxarea .img1 {
  overflow: hidden;
  border-radius: 16px 16px 0 0;
  transition: all 0.4s;
}
.apartment11-area  .apartment-boxarea .img1 img {
  height: 100%;
  width: 100%;
  -o-object-fit: cover;
     object-fit: cover;
  border-radius: 16px 16px 0 0;
  transition: all 0.4s;
}
.apartment11-area  .apartment-boxarea .content {
  padding: 28px 24px;
}
.apartment11-area  .apartment-boxarea .content a {
  color: var(--ztc-text-text-25);
  font-family: var(--ztc-family-font2);
  font-size: var(--ztc-font-size-font-s24);
  font-style: normal;
  font-weight: var(--ztc-weight-bold);
  line-height: 24px;
  transition: all 0.4s;
  display: inline-block;
}
.apartment11-area  .apartment-boxarea .content a:hover {
  color: var(--ztc-text-text-27);
  transition: all 0.4s;
}
.apartment11-area  .apartment-boxarea .content p {
  color: var(--ztc-text-text-26);
  font-family: var(--ztc-family-font2);
  font-size: var(--ztc-font-size-font-s16);
  font-style: normal;
  font-weight: var(--ztc-weight-medium);
  line-height: 16px;
}
.apartment11-area  .apartment-boxarea .content ul {
  padding-bottom: 28px;
  border-bottom: 1px solid rgba(13, 15, 24, 0.1);
}
.apartment11-area  .apartment-boxarea .content ul li {
  display: inline-block;
}
.apartment11-area  .apartment-boxarea .content ul li a {
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
  .apartment11-area  .apartment-boxarea .content ul li a {
    margin: 0 8px 0 0;
  }
}
.apartment11-area  .apartment-boxarea .content ul li a img {
  margin: 0 0 0 0;
  opacity: 0.6;
  height: 16px;
  width: 16px;
  -o-object-fit: cover;
     object-fit: cover;
  display: inline-block;
}
.apartment11-area  .apartment-boxarea .content .btn-area1 {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.apartment11-area  .apartment-boxarea .content .btn-area1 .header-btn11 {
  font-size: var(--ztc-font-size-font-s16);
  color: var(--ztc-text-text-1);
  line-height: 16px;
}
.apartment11-area  .apartment-boxarea .content .btn-area1 .love a {
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
.apartment11-area  .apartment-boxarea .content .btn-area1 .love a:hover img.heart1 {
  visibility: hidden;
  opacity: 0;
  transition: all 0.4s;
}
.apartment11-area  .apartment-boxarea .content .btn-area1 .love a:hover img.heart2 {
  visibility: visible;
  opacity: 1;
  transition: all 0.4s;
  position: absolute;
}
.apartment11-area  .apartment-boxarea .content .btn-area1 .love a.active {
  transition: all 0.4s;
}
.apartment11-area  .apartment-boxarea .content .btn-area1 .love a.active img.heart1 {
  visibility: hidden;
  opacity: 0;
  transition: all 0.4s;
}
.apartment11-area  .apartment-boxarea .content .btn-area1 .love a.active img.heart2 {
  visibility: visible;
  opacity: 1;
  transition: all 0.4s;
  position: absolute;
}
.apartment11-area  .apartment-boxarea .content .btn-area1 .love a img {
  width: 18px;
  height: 16px;
  -o-object-fit: cover;
     object-fit: cover;
  display: inline-block;
}
.apartment11-area  .apartment-boxarea .content .btn-area1 .love a img.heart1 {
  visibility: visible;
  opacity: 1;
  transition: all 0.4s;
}
.apartment11-area  .apartment-boxarea .content .btn-area1 .love a img.heart2 {
  visibility: hidden;
  opacity: 0;
  transition: all 0.4s;
  position: absolute;
  top: 12px;
  left: 11px;
}
.active > .page-link,
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
                    <div class="search-summary-box p-3 rounded bg-light shadow-sm">
                        <h5 class="mb-2 ps-0 text-dark">
                            <i class="fa-solid fa-house text-dark me-1"></i> 
                            {{$property->name}}
                        </h5>
                        @php
                            use Carbon\Carbon;

                            $checkIn = Carbon::parse($booking->check_in_date)->format('D, jS M Y');
                            $checkOut = Carbon::parse($booking->check_out_date)->format('D, jS M Y');
                        @endphp

                        <p class="mb-1 text-dark"><strong>Check-in:</strong> {{ $checkIn }}</p>
                        <p class="mb-1 text-dark"><strong>Check-out:</strong> {{ $checkOut }}</p>
                        <p class="mb-0 text-dark"><strong>Guests:</strong> {{ $booking->number_of_guests ?? '1' }}</p>

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
                    <div class="img1">
                        <img src="{{ asset('storage/' . $property->image_path) }}" alt="">
                    </div>
                    <div class="space40"></div>
                    <h2>{{$property->name}}</h2>
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

                    <div class="row justify-content-center mt-4">
                        <div class="col-12">
                            <table class="table">
                                <tr>
                                    <th>Booking Status</th>
                                    <td>
                                        <span class="badge {{$booking->status == 'Cancelled' ? 'bg-danger' : ($booking->status == 'Confirmed' ? 'bg-success' : 'bg-dark')}}">{{ $booking->status}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Booking Name</th>
                                    <td>{{$booking->user->first_name . ' ' . $booking->user->last_name}}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{$booking->user->email}}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{$booking->user->phone_number}}</td>
                                </tr>
                                <tr>
                                    <th>Check-In</th>
                                    <td>{{$booking->check_in_date}}</td>
                                </tr>
                                <tr>
                                    <th>Check-Out</th>
                                    <td>{{$booking->check_out_date}}</td>
                                </tr>
                                <tr>
                                    <th>Total Price</th>
                                    <td>₦ {{ $booking->total_price }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @if ($booking->status == 'Cancelled' || ($booking->payment && $booking->payment->status == 'Completed'))
                @else
                <div class="desc px-5 mt-4">
                    <h4 class="text-center">Pay <b>securely</b> now to confirm your booking</h4>
                </div>
                <div class="row">
                    <input type="hidden" name="property_id" value="{{$booking->property->id}}">
                    <div class="col-12 mt-4 d-flex justify-content-center">
                        <button type="button" data-id="{{$booking->id}}" data-email="{{$booking->user->email}}" data-amount="{{$booking->total_price}}" data-phone_number="{{$booking->user->phone_number}}" class="header-btn11 payNow">Confirm Booking</button>
                    </div>
                </div>
                @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== APARTMENT AREA ENDS =======-->

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
    <script src="https://js.paystack.co/v2/inline.js"></script>
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
<script src="assets/js/plugins/sweetalert2.js"></script>
<script src="assets/js/main.js"></script>

<script>
    $('#heroTabs a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    })

    function pay_now(response, booking_id) {
        $.ajax({
            url: "pay_now",
            data: {
                reference: response.reference,
                booking_id: booking_id
            },
            type: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType: "json",
            success: function (res) {
                if (res.status === "failed") {
                    Swal.fire("Cancelled!", res.message + ". Try again", "error");
                } else if (res.status === "success") {
                    Swal.fire("Finalizing!", res.message + ". Please wait...", "info");
                    // window.location = res.url;
                }
            },
            error: function (data) {
            },
        });
    }
    
    function pay_later() {
        $("#registerForm").ajaxSubmit({
            url: "vendor_register",
            type: "POST",
            success: function (response) {
                if (response.status === "success") {
                        var email = $("#vendorEmail").val();
                        let handler = PaystackPop.setup({
                            key: 'pk_test_aca0b9922750d1933bcfa2823c5edde461a5fbb9',
                            email: email,
                            amount: 20000 * 100,
                            onClose: function(){
                            },
                            callback: function(response){
                                verify_payment(response);
                            }
                        });
                        handler.openIframe();
                } else {
                    Swal.fire("Cancelled!", response.message, "error");
                }
                Swal.hideLoading();
            },
            error: function (response) {
                Swal.fire("Error!", response.responseJSON.message, "error");
                Swal.hideLoading();
            }
        });
    }

    $(document).on("click", ".payNow", function (e) {
        var amount = $(this).data("amount");
        var email = $(this).data("email");
        var booking_id = $(this).data("id");
        var phone_number = $(this).data("phone_number");
        let handler = PaystackPop.setup({
            key: 'pk_test_aca0b9922750d1933bcfa2823c5edde461a5fbb9',
            email: email,
            amount: amount * 100,
            "metadata": {
            },
            onClose: function(){
            },
            callback: function(response){
                pay_now(response, booking_id);
            }
        });
        handler.openIframe();
    });
    
    $(document).on("click", ".payNows", function (e) {
        var email = $(".email").val();
        pay_now();
    });
    
</script>

</body>
</html>
