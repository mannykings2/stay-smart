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
            <h2>Search Results</h2>
            <div class="space12"></div>
            <p><a href="{{ url('/') }}">Home <i class="fa-solid fa-angle-right"></i></a> Search</p>
            <div class="space12"></div>
            <div class="search-summary-box p-3 rounded bg-light shadow-sm">
              <h5 class="mb-2 ps-0 text-dark">
                <i class="fa-solid fa-location-dot text-dark me-1"></i>
                {{ request('location') ?? 'Any Location' }}
              </h5>
              @php
                use Carbon\Carbon;

                $checkIn = request('check_in') ? Carbon::parse(request('check_in'))->format('D, jS M Y') : '-';
                $checkOut = request('check_out') ? Carbon::parse(request('check_out'))->format('D, jS M Y') : '-';
              @endphp

              <p class="mb-1 text-dark"><strong>Check-in:</strong> {{ $checkIn }}</p>
              <p class="mb-1 text-dark"><strong>Check-out:</strong> {{ $checkOut }}</p>
              <p class="mb-0 text-dark"><strong>Guests:</strong> {{ request('guests') ?? '1' }}</p>

              <div class="space12"></div>
              <a href="{{ url('/') }}" class="header-btn11 search border-0">Edit <i class="fa-solid fa-edit"></i></a>

            </div>
          </div>
        </div>
        <div class="col-lg-5 d-none d-lg-block"></div>
      </div>
    </div>
  </div>
  <!--===== HERO AREA ENDS =======-->


  <!--===== APARTMENT AREA STARTS =======-->
  <div class="apartment-inner2-section-area sp7 apartment11-area bg2">
    <div class="container">
      <div class="row">
        @php $duration = 800; @endphp

        @if(count($properties) > 0)

          @foreach($properties as $property)
            @php
              $encryptedId = \Illuminate\Support\Facades\Crypt::encrypt($property->id);
              $queryParams = http_build_query([
                'propertyId' => $encryptedId,
                'location' => request('location'),
                'check_in' => request('check_in'),
                'check_out' => request('check_out'),
                'guests' => request('guests'),
              ]);
            @endphp
            <div class="col-lg-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="{{ $duration }}">
              <div class="apartment-boxarea" style="position: relative;">
                @php
                  $allImages = [$property->image_path ? asset('storage/' . $property->image_path) : asset('assets/img/all-images/apartment/apartment-img1.png')];
                  if ($property->images) {
                    foreach ($property->images as $img) {
                      $allImages[] = asset('storage/' . $img->image_path);
                    }
                  }
                @endphp
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
                  @if(isset($property->is_unavailable) && $property->is_unavailable)
                    <div
                      style="position: absolute; top: 10px; right: 10px; background: #dc3545; color: white; padding: 5px 10px; border-radius: 5px; font-weight: bold; z-index: 10;">
                      Booked
                    </div>
                  @endif
                </div>
                <div class="content">
                  <a href="javascript:void(0);">{{$property->name}}</a>
                  <div class="space16"></div>
                  <p style="font-size: 13px">{{$property->address}}, {{$property->city}}</p>
                  <div class="space24"></div>
                  <!--<ul>
                            @foreach($property->amenities as $amenity)
                              <li><a href="#" style="font-size: 14px; margin-bottom: 5px;">{{$amenity->name}}</a></li>
                            @endforeach
                          </ul>-->
                  <div class="space28"></div>
                  <div class="btn-area1">
                    <div class="single-btn">
                      <a href="#">₦ {{$property->price_per_night}}</a>
                    </div>
                    <div class="single-btn">
                      @if(isset($property->is_unavailable) && $property->is_unavailable)
                        <button class="header-btn11" style="font-size: 14px; background: #6c757d; cursor: not-allowed;"
                          disabled>Booked</button>
                      @else
                        <a class="header-btn11" href="{{ url('/book_now') . '?' . $queryParams }}"
                          style="font-size: 14px">Book Now</a>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @php $duration += 100; @endphp
          @endforeach
        @endif

        <div class="col-lg-12">
          <div class="space30"></div>
          <div class="pagination-area">
            {{ $properties->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
          </div>
        </div>
        {{-- <div class="col-lg-12">
          <div class="space30"></div>
          <div class="pagination-area">
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li class="page-item">
                  <a class="page-link" href="#" aria-label="Previous">
                    <i class="fa-solid fa-angle-left"></i>
                  </a>
                </li>
                <li class="page-item"><a class="page-link active" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">...</a></li>
                <li class="page-item"><a class="page-link" href="#">12</a></li>
                <li class="page-item">
                  <a class="page-link m-0" href="#" aria-label="Next">
                    <i class="fa-solid fa-angle-right"></i>
                  </a>
                </li>
              </ul>
            </nav>
          </div>
        </div> --}}
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
  </script>

</body>

</html>