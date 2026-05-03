<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stay Smart Apartments - Properties</title>

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
  <link rel="stylesheet" href="{{ asset('assets/css/main.css?2') }}">
  @include('partials.frontend.carousel_assets')
  <style>
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
  <script src="{{ asset('assets/js/plugins/jquery-3-6-0.min.js') }}"></script>

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
</head>

<body class="homepage10-body">

  @include('partials.frontend.pending_booking_alert')
  @include('partials.frontend.header')

  <!--===== APARTMENT AREA STARTS =======-->
  <div class="apartment-inner2-section-area sp7 apartment11-area bg2">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="card shadow-sm border-0 mb-5" style="border-radius: 20px; background: #fff;">
            <div class="card-body p-4">
              <form action="{{ route('properties') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-lg-3 col-md-6">
                  <div class="input-area position-relative">
                    <label class="form-label fw-bold" style="font-size: 14px;">Location</label>
                    <input type="text" name="location" id="locationSearch" value="{{ request('location') }}"
                      placeholder="City, Address..." class="form-control"
                      style="border-radius: 10px; height: 45px; border: 1px solid #eee;">
                    <div id="locationSuggestions" class="autocomplete-suggestions"></div>
                  </div>
                </div>
                <div class="col-lg-2 col-md-4">
                  <label class="form-label fw-bold" style="font-size: 14px;">Min Price</label>
                  <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min"
                    class="form-control" style="border-radius: 10px; height: 45px; border: 1px solid #eee;">
                </div>
                <div class="col-lg-2 col-md-4">
                  <label class="form-label fw-bold" style="font-size: 14px;">Max Price</label>
                  <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max"
                    class="form-control" style="border-radius: 10px; height: 45px; border: 1px solid #eee;">
                </div>
                <div class="col-lg-4 col-md-6">
                  <label class="form-label fw-bold" style="font-size: 14px;">Check-in / Out</label>
                  <div class="d-flex gap-2">
                    <input type="date" name="check_in" value="{{ request('check_in') }}" class="form-control"
                      style="border-radius: 10px; height: 45px; border: 1px solid #eee; font-size: 12px;">
                    <input type="date" name="check_out" value="{{ request('check_out') }}" class="form-control"
                      style="border-radius: 10px; height: 45px; border: 1px solid #eee; font-size: 12px;">
                  </div>
                </div>
                <div class="col-lg-1 col-md-6 text-end">
                  <button type="submit" class="header-btn11 w-100" style="padding: 12px; border-radius: 10px;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                  </button>
                </div>
                <div class="col-12 mt-3 d-flex justify-content-between">
                  <a href="{{ route('properties') }}" class="text-muted small">Clear All Filters</a>
                  @if(request()->anyFilled(['location', 'city', 'min_price', 'max_price', 'check_in', 'check_out']))
                    <span class="badge bg-primary text-white p-2" style="border-radius: 5px;">Filters Active</span>
                  @endif
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        @php $duration = 800; @endphp
        @if(count($properties) > 0)

          @foreach($properties as $property)
            @php
              $encryptedId = \Illuminate\Support\Facades\Crypt::encrypt($property->id);
              $queryParams = http_build_query([
                'propertyId' => $encryptedId,
              ]);
            @endphp
            <div class="col-lg-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="{{ $duration }}">
              <div class="apartment-boxarea">
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
                </div>
                <div class="content">
                  <div class="d-flex justify-content-between align-items-center">
                    <a href="javascript:void(0);">{{$property->name}}</a>
                    <!--<span
                                                              class="badge bg-{{ $property->status == 'Available' ? 'success' : ($property->status == 'Booked' ? 'danger' : 'danger') }}"
                                                              style="font-size: 10px;">
                                                              {{ $property->status }}
                                                            </span>-->
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
                      <a class="header-btn11" href="{{ url('/book_now') . '?' . $queryParams }}" {{--
                        href="{{route('booking.book', $property->id)}}" --}} style="font-size: 14px">Book</a>
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
      </div>
    </div>
  </div>
  <!--===== APARTMENT AREA ENDS =======-->

  @include('partials.frontend.footer')
  <script>
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