@extends('layouts.app', [$activePage = 'Apartments'])

@section('content')
<!--start content-->
    <main class="page-content">
        <h6 class="mb-2 text-uppercase">Trending</h6>
        <hr/>
        <div class="property-carousel p-0 row">
            @foreach ($trending_properties as $property)
                <div class="p-0 col-md-3">
                    <div class="card">
                        <div class="property-badge">
                            <span class="booked {{$property->status == 'Booked' ? 'bg-danger' : ($property->status == 'Available' ? 'bg-success' : '')}}">{{$property->status}}</span>
                            <span class="price bg-success">₦ {{$property->price_per_night}}</span>
                        </div>
                        <img src="{{ asset('storage/' . $property->image_path) }}" alt="{{ $property->name }}" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">{{ $property->name }}</h5>
                            <p class="card-text">{{ $property->location }}</p>
                            <p class="card-text buttons gap-2">
                                <a href="/book/property/{{$property->id}}" class="icons plus">
                                    <i class="bi bi-plus-lg"></i>
                                </a>
                                <a href="#" class="icons bookmark">
                                    <i class="bi bi-bookmark"></i>
                                </a>
                                <a href="#" class="icons eye">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </p>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                dots: true,
                autoplay:true,
                autoplayTimeout:3000,
                autoplayHoverPause:true,
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
