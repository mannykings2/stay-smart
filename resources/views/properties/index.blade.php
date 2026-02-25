@extends('layouts.app', [$activePage = 'Apartments'])

@section('content')
    <!--start content-->
    <main class="page-content">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h6 class="mb-0 text-uppercase">{{ auth()->user()->hasRole('Admin') ? 'My Properties' : 'Apartments' }}</h6>
            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse"
                data-bs-target="#filterSection">
                <i class="bi bi-filter"></i> Filter
            </button>
        </div>

        <div class="collapse mb-4" id="filterSection">
            <div class="card card-body shadow-sm rounded-4 border-0">
                <form action="{{ route('properties.index') }}" method="GET" class="row g-3">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <div class="col-md-3">
                        <label class="form-label small">City</label>
                        <select name="city" class="form-select form-select-sm">
                            <option value="">All Cities</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small">Min Price</label>
                        <input type="number" name="min_price" class="form-control form-control-sm"
                            value="{{ request('min_price') }}" placeholder="0">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small">Max Price</label>
                        <input type="number" name="max_price" class="form-control form-control-sm"
                            value="{{ request('max_price') }}" placeholder="Max">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small">Check-in</label>
                        <input type="date" name="check_in_date" class="form-control form-control-sm"
                            value="{{ request('check_in_date') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small">Check-out</label>
                        <input type="date" name="check_out_date" class="form-control form-control-sm"
                            value="{{ request('check_out_date') }}">
                    </div>
                    <div class="col-md-1 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-sm btn-primary w-100">Apply</button>
                    </div>
                    <div class="col-12 mt-2">
                        <a href="{{ route('properties.index') }}" class="text-muted small text-decoration-none">Clear All
                            Filters</a>
                    </div>
                </form>
            </div>
        </div>
        <hr />

        @if(count($bookmarked_properties) > 0)
            <h6 class="mb-2 text-uppercase">Bookmarked Apartments</h6>
            <div class="property-carousel p-0 row mb-4">
                @foreach ($bookmarked_properties as $property)
                    <div class="p-0 col-md-3">
                        @include('properties.partials.property-card', ['property' => $property, 'isBookmarked' => true])
                    </div>
                @endforeach
            </div>
            <hr />
        @endif

        <h6 class="mb-2 text-uppercase">{{ auth()->user()->hasRole('Admin') ? 'My Properties' : 'Trending' }}</h6>
        <div class="property-carousel p-0 row">
            @foreach ($trending_properties as $property)
                <div class="p-0 col-md-3">
                    @include('properties.partials.property-card', ['property' => $property])
                </div>
            @endforeach
        </div>
    </main>
@endsection

@push('js')
    <script>
        function toggleBookmark(propertyId, element) {
            fetch(`/admin/properties/${propertyId}/bookmark`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const icon = element.querySelector('i');
                        if (data.action === 'added') {
                            element.classList.add('text-warning');
                            icon.classList.replace('bi-bookmark', 'bi-bookmark-fill');
                        } else {
                            element.classList.remove('text-warning');
                            icon.classList.replace('bi-bookmark-fill', 'bi-bookmark');
                        }

                        // Optional: Reload page to update "Bookmarked Apartments" section
                        // For a better UX, we could just update the UI dynamically, but simple reload ensures consistency.
                        location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        $(document).ready(function () {
            $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 4
                    }
                }
            });
        });
    </script>
@endpush