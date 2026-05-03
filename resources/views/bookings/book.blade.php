@extends('layouts.app', [$activePage = 'My Bookings'])

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
                    <form class="px-md-5 pt-3" action="{{route('booking.store')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label for="inputCheckInDate" class="form-label">Check-in Date</label>
                                <div class="ms-auto position-relative">
                                    <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                                        <i class="bi bi-calendar-range-fill"></i>
                                    </div>
                                    <input type="date" name="check_in_date"
                                        class="form-control radius-30 ps-5 @error('check_in_date') is-invalid @enderror"
                                        id="inputCheckInDate" value="{{old('check_in_date')}}" min="{{ date('Y-m-d') }}" required>
                                </div>
                                @error('check_in_date')
                                    <small class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="inputCheckOutDate" class="form-label">Check-out Date</label>
                                <div class="ms-auto position-relative">
                                    <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                                        <i class="bi bi-calendar-range-fill"></i>
                                    </div>
                                    <input type="date" name="check_out_date"
                                        class="form-control radius-30 ps-5 @error('check_out_date') is-invalid @enderror"
                                        id="inputCheckOutDate" value="{{old('check_out_date')}}" min="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="inputNumberOfGuests" class="form-label">Number of Guests</label>
                                <div class="ms-auto position-relative">
                                    <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <input type="number" name="number_of_guests"
                                        class="form-control radius-30 ps-5 @error('number_of_guests') is-invalid @enderror"
                                        id="inputNumberOfGuests" value="{{old('number_of_guests')}}" min="1"
                                        max="{{$property->max_guests}}" required>
                                </div>
                                @error('number_of_guests')
                                    <small class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="inputCheckInTime" class="form-label">Check-in Time</label>
                                    <div class="ms-auto position-relative">
                                        <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                                            <i class="bi bi-clock-fill"></i>
                                        </div>
                                        <input type="time" name="check_in_time"
                                            class="form-control radius-30 ps-5 @error('check_in_time') is-invalid @enderror"
                                            id="inputCheckInTime" value="{{old('check_in_time')}}" required>
                                    </div>
                                    @error('check_in_time')
                                        <small class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="inputCheckOutTime" class="form-label">Check-out Time</label>
                                    <div class="ms-auto position-relative">
                                        <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                                            <i class="bi bi-clock-fill"></i>
                                        </div>
                                        <input type="time" name="check_out_time"
                                            class="form-control radius-30 ps-5 @error('check_out_time') is-invalid @enderror"
                                            id="inputCheckOutTime" value="{{old('check_out_time')}}" required>
                                    </div>
                                    @error('check_out_time')
                                        <small class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <input type="hidden" name="property_id" value="{{$property->id}}">

                            @if(!auth()->check() || empty(auth()->user()->last_name) || empty(auth()->user()->phone_number))
                                <div class="col-12 mt-4">
                                    <div class="alert alert-info border-0 bg-info alert-dismissible fade show py-2">
                                        <div class="d-flex align-items-center">
                                            <div class="font-35 text-dark"><i class='bx bx-info-circle'></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="mb-0 text-dark">
                                                    {{ !auth()->check() ? 'Guest Booking' : 'Please complete your profile to continue' }}
                                                </h6>
                                                <div class="text-dark">
                                                    {{ !auth()->check() ? 'Please provide your details to manage your booking.' : 'We need a few more details to secure your booking.' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if(!auth()->check())
                                    <div class="col-md-3">
                                        <label for="inputFirstName" class="form-label">First Name</label>
                                        <input type="text" name="first_name" class="form-control radius-30 ps-3"
                                            value="{{ old('first_name') }}" placeholder="First Name" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputLastName" class="form-label">Last Name</label>
                                        <input type="text" name="last_name" class="form-control radius-30 ps-3"
                                            value="{{ old('last_name') }}" placeholder="Last Name" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputEmail" class="form-label">Email Address</label>
                                        <input type="email" name="email" class="form-control radius-30 ps-3"
                                            value="{{ old('email') }}" placeholder="Email Address" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputPhoneNumber" class="form-label">Phone Number</label>
                                        <input type="text" name="phone_number" class="form-control radius-30 ps-3"
                                            value="{{ old('phone_number') }}" placeholder="Phone Number" required>
                                    </div>
                                @else
                                    <div class="col-md-4">
                                        <label for="inputFirstName" class="form-label">First Name</label>
                                        <input type="text" name="first_name" class="form-control radius-30 ps-3"
                                            value="{{ old('first_name', auth()->user()->first_name) }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="inputLastName" class="form-label">Last Name</label>
                                        <input type="text" name="last_name" class="form-control radius-30 ps-3"
                                            value="{{ old('last_name', auth()->user()->last_name) }}" placeholder="Last Name"
                                            required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="inputPhoneNumber" class="form-label">Phone Number</label>
                                        <input type="text" name="phone_number" class="form-control radius-30 ps-3"
                                            value="{{ old('phone_number', auth()->user()->phone_number) }}"
                                            placeholder="Phone Number" required>
                                    </div>
                                @endif
                            @endif
                            <div class="col-12 my-4 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary rounded-4 px-4">Book Now</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection