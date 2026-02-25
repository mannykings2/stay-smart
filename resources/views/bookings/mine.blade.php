@extends('layouts.app', [$activePage = 'My Bookings'])

@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/plugins/sweetalert2.css') }}" />
@endpush

@section('content')
<!--start content-->
<main class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card rounded-4 p-4 d-flex justify-content-between">
                    <h3 class="mb-4 text-center" style="font-weight: 600">Ready for an exciting stay?</h3>
                    <a href="{{route('properties.index')}}" role="button" class="btn btn-primary rounded-3 px-3">Book now</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h6 class="mb-2 text-uppercase">My Property Bookings</h6>
                <hr>
                <div class="row">
                    @php
                        $activeBookings = $bookings->where('status', '!=', 'Completed');
                    @endphp
                    @if($activeBookings->count() > 0)
                        @foreach ($activeBookings as $index => $booking)
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
                                                <p class="card-text mb-0" style="font-size: 12px">{{$booking->check_in_date}} @if($booking->check_in_time) ({{ \Carbon\Carbon::parse($booking->check_in_time)->format('h:i A') }}) @endif - {{$booking->check_out_date}} @if($booking->check_out_time) ({{ \Carbon\Carbon::parse($booking->check_out_time)->format('h:i A') }}) @endif</p>
                                                <p class="card-text mb-0" style="font-size: 12px">₦ {{ $booking->total_price }}</p>
                                                <div class="d-flex justify-content-between align-items-center pe-3">
                                                    <p class="card-text mb-0" style="font-size: 12px">
                                                    </p>
                                                    <div class="btn-group">
                                                        @if($booking->status == 'Confirmed')
                                                            <button class="btn btn-primary btn-sm" onclick="handleCheckIn('{{ $booking->id }}')"><i class="ms-0 bi bi-box-arrow-left" style="font-size: 10px;"></i></button>
                                                            <button class="btn btn-secondary btn-sm" onclick="handleCheckOut('{{ $booking->id }}')"><i class="ms-0 bi bi-box-arrow-right" style="font-size: 10px;"></i></button>
                                                        @endif
                                                        <a href="{{route('booking.view', $booking->reference)}}" role="button" class="btn btn-dark btn-sm"><i class="ms-0 bi bi-eye" style="font-size: 10px;"></i></a>
                                                        <button class="btn btn-danger btn-sm" onclick="handleCancel('{{ $booking->id }}')"><i class="ms-0 bi bi-x-circle" style="font-size: 10px;"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center mb-0 p-3">You have no active bookings with us</p>
                    @endif
                </div>
            </div>
            <div class="col-md-12 mt-4">
                <h6 class="mb-2 text-uppercase">Completed</h6>
                <hr>
                <div class="row">
                    @php
                        $completedBookings = $bookings->where('status', 'Completed');
                    @endphp
                    @if($completedBookings->count() > 0)
                        @foreach ($completedBookings as $index => $booking)
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
                                                <p class="card-text mb-0" style="font-size: 12px">{{$booking->check_in_date}} @if($booking->check_in_time) ({{ \Carbon\Carbon::parse($booking->check_in_time)->format('h:i A') }}) @endif - {{$booking->check_out_date}} @if($booking->check_out_time) ({{ \Carbon\Carbon::parse($booking->check_out_time)->format('h:i A') }}) @endif</p>
                                                <p class="card-text mb-0" style="font-size: 12px">₦ {{ $booking->total_price }}</p>
                                                <div class="d-flex justify-content-between align-items-center pe-3">
                                                    <p class="card-text mb-0" style="font-size: 12px">
                                                        <span class="badge bg-dark">
                                                            {{ ucfirst($booking->status) }}
                                                        </span>
                                                    </p>
                                                    <div class="btn-group">
                                                        <a href="{{route('booking.view', $booking->reference)}}" role="button" class="btn btn-dark btn-sm"><i class="ms-0 bi bi-eye" style="font-size: 10px;"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center mb-0 p-3">You have no completed bookings</p>
                    @endif
                </div>
            </div>
        </div>
        @unless(auth()->user()->hasRole('Admin'))
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
                                                            <span class="badge bg-{{ $booking->status == 'Scheduled' ? 'brown' : ($booking->status == 'Cancelled' ? 'danger' : 'dark') }}">
                                                                {{ ucfirst($booking->status) }}
                                                            </span>
                                                        </p>
                                                        {{-- <div class="btn-group">
                                                            <a href="{{route('booking.view', $booking->reference)}}" role="button" class="btn btn-dark btn-sm"><i class="ms-0 bi bi-eye" style="font-size: 10px;"></i></a>
                                                            <button class="btn btn-danger btn-sm" onclick="handleCancel('{{ $booking->id }}')"><i class="ms-0 bi bi-x-circle" style="font-size: 10px;"></i></button>
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
        @endunless
        @unless(auth()->user()->hasRole('Admin'))
            <div class="row mt-4">
                <div class="col-md-12">
                    <h6 class="mb-2 text-uppercase">My Driver Bookings</h6>
                    <hr>
                    <div class="row">
                        @if(count($driverBookings)>0)
                            @foreach ($driverBookings as $index => $booking)
                                <div class="col-md-4">
                                    <div class="card rounded-4 shadow-md p-0" style="overflow: hidden; margin-bottom: 0.5rem;">
                                        <div class="card-body p-0">
                                            <div class="row">
                                                <div class="col-4" style="overflow: hidden;">
                                                    <div class="booking-img" style="height: 100px; width: 100%;">
                                                        <img class="img-fluid" style="width: 100%; object-fit: cover;" src="{{ asset($booking->driver->image) }}" alt="booking-img">
                                                    </div>
                                                </div>
                                                <div class="col-8 p-2 ps-0">
                                                    <p class="card-title mb-0" style="font-weight: 500">{{$booking->driver->first_name . ' '. $booking->driver->last_name}}</p>
                                                    <p class="card-text mb-0" style="font-size: 12px">{{$booking->ride_date}} | {{$booking->ride_time}} </p>
                                                    <p class="card-text mb-0" style="font-size: 12px">₦ {{ number_format($booking->price) }}</p>
                                                    <div class="d-flex justify-content-between align-items-center pe-3">
                                                        <p class="card-text mb-0" style="font-size: 12px">
                                                            <span class="badge bg-{{ $booking->status == 'Scheduled' ? 'brown' : ($booking->status == 'Cancelled' ? 'danger' : 'dark') }}">
                                                                {{ ucfirst($booking->status) }}
                                                            </span>
                                                        </p>
                                                        {{-- <div class="btn-group">
                                                            <a href="{{route('booking.view', $booking->reference)}}" role="button" class="btn btn-dark btn-sm"><i class="ms-0 bi bi-eye" style="font-size: 10px;"></i></a>
                                                            <button class="btn btn-danger btn-sm" onclick="handleCancel('{{ $booking->id }}')"><i class="ms-0 bi bi-x-circle" style="font-size: 10px;"></i></button>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center mb-0 p-3">You have no Driver Bookings with us</p>
                        @endif
                    </div>
                </div>
            </div>
        @endunless
    </div>
</main>
@endsection

@push('js')
<script src="{{ asset('assets/js/plugins/sweetalert2.js') }}"></script>
<script>
    function handleCheckIn(booking_id) {
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
                return new Promise(function (resolve, reject) {
                    $.ajax({
                        url: "{{ route('check_in_booking') }}",
                        type: "POST",
                        data: { booking_id: booking_id },
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        dataType: "json"
                    }).done(function (response) {
                        if (response && response.status === 'success') {
                            resolve(response);
                        } else {
                            var msg = (response && response.message) ? response.message : 'Check in failed';
                            reject(new Error(msg));
                        }
                    }).fail(function (jqXHR) {
                        var msg = 'Request failed';
                        try {
                            if (jqXHR && jqXHR.responseJSON && jqXHR.responseJSON.message) {
                                msg = jqXHR.responseJSON.message;
                            } else if (jqXHR && jqXHR.responseText) {
                                msg = jqXHR.responseText;
                            }
                        } catch (e) {}
                        reject(new Error(msg));
                    });
                });
            }
        }).then(function(result){
            if (result && result.value) {
                var resp = result.value;
                Swal.fire('Done!', resp.message || 'You have been checked in!', 'success').then(() => {
                    location.reload();
                });
            }
        }).catch(function(err){
            var msg = (err && err.message) ? err.message : 'Request failed';
            Swal.fire('Error', msg, 'error');
        });
    }

    function handleCheckOut(booking_id) {
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
                    url: "{{ route('check_out_booking') }}",
                    type: "POST",
                    data: { booking_id: booking_id },
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: "json"
                }).then(function(response){
                    if (response.status === 'success') return response;
                    throw new Error(response.message || 'Check out failed');
                }).catch(function(err){ throw err; });
            }
        }).then(function(result){
            if (result && result.value) {
                var resp = result.value;
                Swal.fire('Done!', resp.message || 'You have been checked out!', 'success').then(() => {
                    location.reload();
                });
            }
        }).catch(function(err){
            var msg = (err && err.message) ? err.message : 'Request failed';
            Swal.fire('Error', msg, 'error');
        });
    }
</script>
@endpush
