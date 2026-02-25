<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script>
    // expose Paystack public key from config/services.php (.env -> PAYSTACK_PUBLIC)
    var PAYSTACK_PUBLIC = "{{ config('services.paystack.public') ?? env('PAYSTACK_PUBLIC') }}";
    // route for verify endpoint (used by AJAX)
    var VERIFY_PAYMENT_URL = "{{ route('verify.payment') }}";
  </script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stay Smart Apartments</title>

  <!--=====FAB ICON=======-->
  <link rel="shortcut icon" href="{{ asset('assets/img/logo/smart-favicon.png') }}" type="image/x-icon">

  <!--===== CSS LINK =======-->
  <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/plugins/aos.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/plugins/fontawesome.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/plugins/magnific-popup.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/plugins/mobile.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/plugins/owlcarousel.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/plugins/sidebar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/plugins/slick-slider.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/plugins/nice-select.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/plugins/sweetalert2.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

  <!--=====  JS SCRIPT LINK =======-->
  <script src="{{ asset('assets/js/plugins/jquery-3-6-0.min.js') }}"></script>
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


              <p class="mb-1 text-dark"><strong>Check-in:</strong> {{ $checkIn }} @if($booking->check_in_time)
              ({{ \Carbon\Carbon::parse($booking->check_in_time)->format('h:i A') }}) @endif</p>
              <p class="mb-1 text-dark"><strong>Check-out:</strong> {{ $checkOut }} @if($booking->check_out_time)
              ({{ \Carbon\Carbon::parse($booking->check_out_time)->format('h:i A') }}) @endif</p>
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
            <p><i class="fa-solid fa-location-dot text-dark me-1"></i>{{$property->address}}, {{$property->city}},
              {{$property->country}}
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

              <div class="row justify-content-center mt-4">
                <div class="col-12">
                  <table class="table">
                    <tr>
                      <th>Booking Status</th>
                      <td>
                        <span
                          class="badge {{$booking->status == 'Cancelled' ? 'bg-danger' : ($booking->status == 'Confirmed' ? 'bg-success' : ($booking->status == 'Pending' ? 'bg-warning' : ($booking->status == 'Completed' ? 'bg-dark' : 'bg-dark')))}}">{{ $booking->status}}</span>
                      </td>
                    </tr>
                    <tr>
                      <th>Booking Reference</th>
                      <td class="text-primary fw-bold">{{$booking->reference}}</td>
                    </tr>
                    <tr>
                      <th>Booking Name</th>
                      <td>{{ ($booking->user->first_name ?? 'Guest') . ' ' . ($booking->user->last_name ?? '') }}</td>
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
                      <td>{{$booking->check_in_date}} @if($booking->check_in_time)
                      ({{ \Carbon\Carbon::parse($booking->check_in_time)->format('h:i A') }}) @endif</td>
                    </tr>
                    <tr>
                      <th>Check-Out</th>
                      <td>{{$booking->check_out_date}} @if($booking->check_out_time)
                      ({{ \Carbon\Carbon::parse($booking->check_out_time)->format('h:i A') }}) @endif</td>
                    </tr>
                    <tr>
                      <th>Total Price</th>
                      <td>₦ {{ $booking->total_price }}</td>
                    </tr>
                    @if($booking->payment)
                      <tr>
                        <th>Transaction Ref</th>
                        <td class="small text-muted">{{ $booking->payment->trx_ref }}</td>
                      </tr>
                    @endif
                  </table>

                  @if(!auth()->check())
                    <div class="alert alert-info mt-4 text-center"
                      style="background-color: #e7f3ff; border-color: #b3d9ff;">
                      <i class="fa-solid fa-circle-info me-2"></i>
                      <strong>Want to track your booking?</strong>
                      <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-underline">Log in to your
                        account</a>
                      to view your booking history, manage reservations, and receive updates.
                    </div>
                  @endif
                </div>
              </div>
              @if (in_array($booking->status, ['Cancelled', 'Confirmed']) || ($booking->payment && $booking->payment->status == 'Completed'))
              @else
                <div class="desc px-5 mt-4">
                  <h4 class="text-center">Pay <b>securely</b> now to confirm your booking</h4>
                </div>
                <div class="row">
                  <input type="hidden" name="property_id" value="{{$booking->property->id}}">
                  <div class="col-12 mt-4 d-flex justify-content-center">
                    <button type="button" data-id="{{$booking->id}}" data-email="{{$booking->user->email}}"
                      data-amount="{{$booking->total_price}}" data-phone_number="{{$booking->user->phone_number}}"
                      data-reference="{{$booking->reference}}" class="header-btn11 payNow">Confirm Booking</button>
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

  @include('partials.frontend.footer')

  <!--===== JS SCRIPT LINK =======-->
  <script src="https://js.paystack.co/v2/inline.js"></script>
  <script src="{{ asset('assets/js/plugins/sweetalert2.js') }}"></script>

  <script>
    $('#heroTabs a').on('click', function (e) {
      e.preventDefault()
      $(this).tab('show')
    })

    function pay_now(response, booking_id) {
      $.ajax({
        url: VERIFY_PAYMENT_URL,
        data: {
          reference: response.reference,
          booking_id: booking_id
        },
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: "json",
        success: function (res) {
          // re-enable the button (if present)
          var $btn = $("button.payNow[data-id='" + booking_id + "']");
          if (res.status === "failed") {
            Swal.fire("Cancelled!", res.message + ". Try again", "error");
            $btn.prop('disabled', false).text($btn.data('orig-text'));
          } else if (res.status === "success") {
            Swal.fire("Payment Successful!", res.message, "success").then(() => {
              // reload the page to show the updated status and CTA
              window.location.reload();
            });
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          var $btn = $("button.payNow[data-id='" + booking_id + "']");
          $btn.prop('disabled', false).text($btn.data('orig-text'));
          Swal.fire("Error!", "An error occurred while finalizing payment. Please try again.", "error");
          console.error('verify_payment ajax error', textStatus, errorThrown, jqXHR.responseText);
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
              onClose: function () {
              },
              callback: function (response) {
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
      var $btn = $(this);
      var amount = $btn.data("amount");
      var email = $btn.data("email");
      var booking_id = $btn.data("id");
      var phone_number = $btn.data("phone_number");
      var baseReference = $btn.data("reference");

      // append timestamp to ensure uniqueness and prevent 'Duplicate Reference' errors on retry
      var reference = (baseReference || "BOOK") + "-" + Math.floor(Date.now() / 1000);

      // disable the button and show a loading text to prevent duplicate clicks
      $btn.data('orig-text', $btn.text());
      $btn.prop('disabled', true).text('Processing...');

      let handler = PaystackPop.setup({
        key: PAYSTACK_PUBLIC || 'pk_test_0a2168c80b6a5054c4f98886e23943a93f93fc49',
        email: email,
        amount: amount * 100,
        reference: reference,
        "metadata": {
        },
        onClose: function () {
          // re-enable button if user closed the widget
          $btn.prop('disabled', false).text($btn.data('orig-text'));
        },
        callback: function (response) {
          // call server to verify and finalize
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