@extends('layouts.app', [$activePage = 'Apartments'])

@section('content')
    <!--start content-->
    <main class="page-content">
        <div class="container p-0">
            <div class="row">
                <div class="col-md-12 p-md-4">
                    <div class="property-banner">
                        <img class="property-banner-image" src="{{ asset('storage/' . $property->image_path) }}">
                        <div class="property-banner-content">
                            <div class="text-center">
                                <h1>{{$property->name}}</h1>
                                <small class="">{{$property->address}}, {{$property->city}},
                                    {{ $property->country }}</small>
                            </div>
                            <div class="property-badge" style="font-size: 14px">
                                <span
                                    class="booked {{ $property->status == 'Booked' ? 'bg-danger' : ($property->status == 'Available' ? 'bg-success' : ($property->status == 'Pending' ? 'bg-warning' : ($property->status == 'Under Maintenance' ? 'bg-secondary' : 'bg-dark'))) }}">{{$property->status}}</span>
                                <span class="price bg-success">₦ {{$property->price_per_night}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="amenities gap-2 px-md-5" style="flex-wrap: wrap">
                        <span class="item">{{$property->max_guests}} Max Guests</span>
                        @foreach($property->amenities as $amenity)
                            <span class="item">{{$amenity->name}}</span>
                        @endforeach
                    </div>
                    <div class="desc px-md-5 mt-3">
                        <p class="text-center">{{$property->description}}</p>
                    </div>

                    @if($property->images->count() > 0)
                        <div class="property-gallery px-md-5 mt-4">
                            <h5 class="text-center mb-3 text-muted">A Look Inside</h5>
                            <div class="row g-2 justify-content-center">
                                @foreach($property->images as $image)
                                    <div class="col-6 col-md-3">
                                        <a href="{{ asset('storage/' . $image->image_path) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                                class="img-fluid rounded shadow-sm"
                                                style="height: 150px; width: 100%; object-fit: cover; transition: transform 0.2s;"
                                                onmouseover="this.style.transform='scale(1.05)'"
                                                onmouseout="this.style.transform='scale(1)'">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div class="px-md-5 pt-3 text-center">
                        <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary rounded-4 px-4 me-2">Back
                            to Apartments</a>
                        @unless(auth()->user()->hasRole('Cleaner'))
                            <a href="/book/property/{{$property->id}}" class="btn btn-primary rounded-4 px-4">Book Now</a>
                        @endunless
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection