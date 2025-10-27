@extends('layouts.app', [$activePage = 'My Bookings'])

@section('content')
<!--start content-->
<main class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card rounded-4 p-4 d-flex justify-content-between">
                    <h3 class="mb-4 text-center" style="font-weight: 600">Ready for an exciting stay?</h3>
                    <a href="{{route('apartments.index')}}" role="button" class="btn btn-primary rounded-3 px-3">Book now</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h6 class="mb-2 text-uppercase">My Property Bookings</h6>
                <hr>
                <div class="row">
                    @if(count($bookings)>0)
                        @foreach ($bookings as $index => $booking)
                            <div class="col-md-4">
                                <div class="card rounded-4 shadow-md p-0" style="overflow: hidden; margin-bottom: 0.5rem;">
                                    <div class="card-body p-0">
                                        <div class="row">
                                            <div class="col-4" style="overflow: hidden;">
                                                <div class="booking-img" style="height: 100%; width: 100%;">
                                                    <img class="img-fluid" style="height: 100%; object-fit: cover;" src="{{ asset('storage/' . $booking->property->image_path) }}" alt="booking-img">
                                                </div>
                                            </div>
                                            <div class="col-8 p-2 ps-0">
                                                <p class="card-title mb-0" style="font-weight: 500">{{$booking->property->name}}</p>
                                                <p class="card-text mb-0" style="font-size: 12px">{{$booking->check_in_date}} - {{$booking->check_out_date}}</p>
                                                <p class="card-text mb-0" style="font-size: 12px">₦ {{ $booking->total_price }}</p>
                                                <div class="d-flex justify-content-between align-items-center pe-3">
                                                    <p class="card-text mb-0" style="font-size: 12px">
                                                        <span class="badge bg-{{ $booking->status == 'Confirmed' ?'primary' : ($booking->status == 'Cancelled' ? 'danger' : 'dark') }}">
                                                            {{ ucfirst($booking->status) }}
                                                        </span>
                                                    </p>
                                                    <div class="btn-group">
                                                        @if($booking->status == 'Confirmed')
                                                            <button class="btn btn-primary btn-sm" onclick="handleCheckIn({{ $booking->id }})"><i class="ms-0 bi bi-box-arrow-left" style="font-size: 10px;"></i></button>
                                                            <button class="btn btn-secondary btn-sm" onclick="handleCheckOut({{ $booking->id }})"><i class="ms-0 bi bi-box-arrow-right" style="font-size: 10px;"></i></button>
                                                        @endif
                                                        <a href="{{route('booking.view', $booking->reference)}}" role="button" class="btn btn-dark btn-sm"><i class="ms-0 bi bi-eye" style="font-size: 10px;"></i></a>
                                                        <button class="btn btn-danger btn-sm" onclick="handleCancel({{ $booking->id }})"><i class="ms-0 bi bi-x-circle" style="font-size: 10px;"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center mb-0 p-3">You have no bookings with us</p>
                    @endif
                </div>
            </div>
            <div class="col-md-12 mt-4">
                <h6 class="mb-2 text-uppercase">Completed</h6>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card rounded-4 shadow-md p-0" style="overflow: hidden; margin-bottom: 0.5rem;">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-4" style="overflow: hidden;">
                                        <div class="booking-img" style="height: 100%; width: 100%;">
                                            <img class="img-fluid" style="height: 100%; object-fit: cover;" src="/storage/apartments/apartment-img4.png" alt="booking-img">
                                        </div>
                                    </div>
                                    <div class="col-8 p-2 ps-0">
                                        <p class="card-title mb-0" style="font-weight: 500">
                                            Volkman Group Apartment</p>
                                        <p class="card-text mb-0" style="font-size: 12px">07-01-2025 - 14-01-2025</p>
                                        <p class="card-text mb-0" style="font-size: 12px">₦ 50,000</p>
                                        <div class="d-flex justify-content-between align-items-center pe-3">
                                            <p class="card-text mb-0" style="font-size: 12px">
                                                <span class="badge bg-dark">
                                                    Completed
                                                </span>
                                            </p>
                                            <div class="btn-group">
                                                <a href="#" role="button" class="btn btn-dark btn-sm"><i class="ms-0 bi bi-eye" style="font-size: 10px;"></i></a>
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
        <div class="row mt-4">
            <div class="col-md-12">
                <h6 class="mb-2 text-uppercase">My Chef Bookings</h6>
                <hr>
                <div class="row">
                    @if(count($chefBookings)>0)
                        @foreach ($chefBookings as $index => $booking)
                            <div class="col-md-4">
                                <div class="card rounded-4 shadow-md p-0" style="overflow: hidden; margin-bottom: 0.5rem;">
                                    <div class="card-body p-0">
                                        <div class="row">
                                            <div class="col-4" style="overflow: hidden;">
                                                <div class="booking-img" style="height: 100px; width: 100%;">
                                                    <img class="img-fluid" style="width: 100%; object-fit: cover;" src="{{ asset($booking->chef->image) }}" alt="booking-img">
                                                </div>
                                            </div>
                                            <div class="col-8 p-2 ps-0">
                                                <p class="card-title mb-0" style="font-weight: 500">{{$booking->chef->first_name . ' '. $booking->chef->last_name}}</p>
                                                <p class="card-text mb-0" style="font-size: 12px">{{$booking->service_date}} | {{$booking->service_time}} </p>
                                                <p class="card-text mb-0" style="font-size: 12px">₦ {{ number_format($booking->price) }}</p>
                                                <div class="d-flex justify-content-between align-items-center pe-3">
                                                    <p class="card-text mb-0" style="font-size: 12px">
                                                        <span class="badge bg-{{ $booking->status == 'Scheduled' ?'primary' : ($booking->status == 'Cancelled' ? 'danger' : 'dark') }}">
                                                            {{ ucfirst($booking->status) }}
                                                        </span>
                                                    </p>
                                                    {{-- <div class="btn-group">
                                                        @if($booking->status == 'Confirmed')
                                                            <button class="btn btn-primary btn-sm" onclick="handleCheckIn({{ $booking->id }})"><i class="ms-0 bi bi-box-arrow-left" style="font-size: 10px;"></i></button>
                                                            <button class="btn btn-secondary btn-sm" onclick="handleCheckOut({{ $booking->id }})"><i class="ms-0 bi bi-box-arrow-right" style="font-size: 10px;"></i></button>
                                                        @endif
                                                        <a href="{{route('booking.view', $booking->reference)}}" role="button" class="btn btn-dark btn-sm"><i class="ms-0 bi bi-eye" style="font-size: 10px;"></i></a>
                                                        <button class="btn btn-danger btn-sm" onclick="handleCancel({{ $booking->id }})"><i class="ms-0 bi bi-x-circle" style="font-size: 10px;"></i></button>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center mb-0 p-3">You have no Chef Bookings with us</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
