<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
  @include('partials.frontend.carousel_assets')

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
            <h2>Online Check In</h2>
            <div class="space12"></div>
            <p><a href="{{ url('/') }}">Home <i class="fa-solid fa-angle-right"></i></a> Check In</p>
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
      @if($user)
        <div class="row">
          <div class="col-lg-7 m-auto">
            <div class="apartment-author-area pdright">
              @php
                $allImages = [$property->image_path ? asset('storage/' . $property->image_path) : asset('assets/img/all-images/apartment/apartment-img1.png')];
                if ($property->images) {
                  foreach ($property->images as $img) {
                    $allImages[] = asset('storage/' . $img->image_path);
                  }
                }
              @endphp
              <div class="img1 property-carousel">
                @if(count($allImages) > 1)
                  <button class="carousel-btn prev" onclick="togglePropertyImage(this, 'prev')"><i
                      class="fa-solid fa-angle-left"></i></button>
                @endif
                <img src="{{ $allImages[0] }}" alt="" class="property-img-carousel"
                  data-images="{{ json_encode($allImages) }}" data-current-index="0">
                @if(count($allImages) > 1)
                  <button class="carousel-btn next" onclick="togglePropertyImage(this, 'next')"><i
                      class="fa-solid fa-angle-right"></i></button>
                @endif
              </div>
              <div class="space40"></div>
              <h2>{{$property->name}}</h2>
              <div class="space20"></div>
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
                <div class="row justify-content-center mt-4">
                  <div class="col-12">
                    <table class="table">
                      <tr>
                        <th>Booking Status</th>
                        <td>
                          @php
                            $badgeClass = 'bg-dark';
                            if ($booking->status == 'Cancelled') {
                              $badgeClass = 'bg-danger';
                            } elseif (!empty($isCheckedOut) || $booking->status == 'Completed') {
                              $badgeClass = 'bg-dark';
                            } elseif ($booking->status == 'Scheduled') {
                              $badgeClass = 'bg-brown';
                            } elseif ($booking->status == 'Confirmed' || !empty($isCheckedIn)) {
                              $badgeClass = 'bg-success';
                            } elseif ($booking->status == 'Pending') {
                              $badgeClass = 'bg-warning';
                            }
                          @endphp
                          <span class="badge {{ $badgeClass }}">{{ $booking->status }}</span>
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
                  </div>
                  @if(!empty($isCheckedIn))
                    <div class="align-items-center">
                      <a href="#" data-id="{{$booking->id}}" class="header-btn11 search border-0 checkOut">Check Out <i
                          class="fa-solid fa-sign-out"></i></a>
                    </div>
                  @elseif(!empty($isCheckedOut))
                    {{-- booking already checked out; no actions --}}
                  @elseif($booking->status === "Confirmed")
                    <div class="align-items-center">
                      <a href="#" data-id="{{$booking->id}}" class="header-btn11 search border-0 checkIn">Check In <i
                          class="fa-solid fa-sign-in"></i></a>
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      @else

      @endif
    </div>
  </div>
  <!--===== APARTMENT AREA ENDS =======-->

  @include('partials.frontend.footer')

  <!--===== JS SCRIPT LINK =======-->
  <script src="{{ asset('assets/js/plugins/sweetalert2.js') }}"></script>

  <script>
    $('#heroTabs a').on('click', function (e) {
      e.preventDefault()
      $(this).tab('show')
    })

    $(document).on("click", ".checkIn", function (e) {
      e.preventDefault();
      var $btn = $(this);
      var booking_id = $btn.data("id");

      Swal.fire({
        title: 'Are you sure?',
        html: "You will be checked in?",
        icon: 'info',
        buttonsStyling: false,
        showCancelButton: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        showLoaderOnConfirm: true,
        confirmButtonText: 'Yes, submit it!',
        cancelButtonText: 'No, cancel it',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-danger'
        },
        preConfirm: () => {
          // disable the button to prevent duplicate clicks
          $btn.addClass('disabled').attr('aria-disabled', 'true').css('pointer-events', 'none');

          // Wrap jQuery AJAX in a native Promise so SweetAlert gets a proper Promise
          return new Promise(function (resolve, reject) {
            $.ajax({
              url: "check_in_booking",
              type: "POST",
              data: {
                booking_id: booking_id,
                last_name: "{{ $user->last_name ?? '' }}"
              },
              headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
              dataType: "json"
            }).done(function (response) {
              if (response && response.status === 'success') {
                resolve(response);
              } else {
                // make sure we pass a useful message
                var msg = (response && response.message) ? response.message : 'Check in failed';
                reject(new Error(msg));
              }
            }).fail(function (jqXHR) {
              // Try to parse server-sent JSON error message, fallback to generic
              var msg = 'Request failed';
              try {
                if (jqXHR && jqXHR.responseJSON && jqXHR.responseJSON.message) {
                  msg = jqXHR.responseJSON.message;
                } else if (jqXHR && jqXHR.responseText) {
                  // sometimes server returns plain text
                  msg = jqXHR.responseText;
                }
              } catch (e) {
                // ignore parse errors
              }
              reject(new Error(msg));
            });
          }).catch(function (err) {
            // re-enable the button on error so user can retry
            $btn.removeClass('disabled').removeAttr('aria-disabled').css('pointer-events', '');
            throw err;
          });
        }
      }).then(function (result) {
        if (result && result.value) {
          var resp = result.value;
          Swal.fire('Done!', resp.message || 'You have been checked in!', 'success');

          // Update status badge (first badge in the table)
          $('table .badge').first().text(resp.booking_status).removeClass('bg-dark bg-secondary bg-danger').addClass('bg-success');

          // Replace Check In button with Check Out button
          $('.align-items-center').html('<a href="#" data-id="' + booking_id + '" class="header-btn11 search border-0 checkOut">Check Out <i class="fa-solid fa-sign-out"></i></a>');
        }
      }).catch(function (err) {
        var msg = (err && err.message) ? err.message : 'Request failed';
        Swal.fire('Error', msg, 'error');
      });
    });

    // Handle check out action
    $(document).on("click", ".checkOut", function (e) {
      var booking_id = $(this).data("id");
      e.preventDefault();
      Swal.fire({
        title: 'Are you sure?',
        html: "You will be checked out?",
        icon: 'info',
        buttonsStyling: false,
        showCancelButton: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        showLoaderOnConfirm: true,
        confirmButtonText: 'Yes, submit it!',
        cancelButtonText: 'No, cancel it',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-danger'
        },
        preConfirm: () => {
          return $.ajax({
            url: "check_out_booking",
            type: "POST",
            data: {
              booking_id: booking_id,
              last_name: "{{ $user->last_name ?? '' }}"
            },
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json"
          }).then(function (response) {
            if (response.status === 'success') return response;
            throw new Error(response.message || 'Check out failed');
          }).catch(function (err) { throw err; });
        }
      }).then(function (result) {
        if (result && result.value) {
          var resp = result.value;
          Swal.fire('Done!', resp.message || 'You have been checked out!', 'success');

          // Update status badge
          $('table .badge').first().text(resp.booking_status).removeClass('bg-success bg-dark bg-danger').addClass('bg-secondary');

          // Remove action buttons
          $('.align-items-center').empty();
        }
      }).catch(function (err) {
        var msg = (err && err.message) ? err.message : 'Request failed';
        Swal.fire('Error', msg, 'error');
      });
    });
  </script>

</body>

</html>