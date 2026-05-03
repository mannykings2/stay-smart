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
                <div class="card rounded-4 p-4 d-flex flex-row justify-content-between align-items-center">
                    <h3 class="mb-0 text-center" style="font-weight: 600">Ready for an exciting stay?</h3>
                    <div class="d-flex gap-2">
                        @if(auth()->user()->hasRole('Admin'))
                            <form action="{{ route('admin.bookings.bulk_cancel') }}" method="POST" id="bulkCancelForm">
                                @csrf
                                <button type="button" class="btn btn-warning rounded-3 px-3" onclick="confirmBulkCancel()">
                                    <i class="bi bi-trash me-1"></i> Clear Stale Bookings
                                </button>
                            </form>
                        @endif
                        <a href="{{route('properties.index')}}" role="button" class="btn btn-primary rounded-3 px-3">Book now</a>
                    </div>
                </div>
            </div>
        </div>
        @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super Admin'))
            <div class="row">
                <div class="col-md-12">
                    @if(auth()->user()->hasRole('Super Admin'))
                        <div class="card rounded-4 border-0 shadow-none bg-transparent mb-3">
                            <div class="card-body p-0">
                                <ul class="nav nav-pills gap-2" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active rounded-3 px-4" id="pills-apartments-tab" data-bs-toggle="pill" data-bs-target="#pills-apartments" type="button" role="tab" aria-controls="pills-apartments" aria-selected="true">Apartment Bookings</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link rounded-3 px-4" id="pills-chefs-tab" data-bs-toggle="pill" data-bs-target="#pills-chefs" type="button" role="tab" aria-controls="pills-chefs" aria-selected="false">Chef Bookings</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link rounded-3 px-4" id="pills-drivers-tab" data-bs-toggle="pill" data-bs-target="#pills-drivers" type="button" role="tab" aria-controls="pills-drivers" aria-selected="false">Driver Bookings</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @else
                        <h6 class="mb-2 text-uppercase">Manage All Bookings</h6>
                        <hr>
                    @endif

                    <div class="tab-content" id="pills-tabContent">
                        {{-- Apartment Bookings --}}
                        <div class="tab-pane fade show active" id="pills-apartments" role="tabpanel" aria-labelledby="pills-apartments-tab">
                            <div class="card rounded-4">
                                <div class="card-body">
                                    @if(isset($bookings) && $bookings->count() > 0)
                                        <div class="table-responsive">
                                            <table id="bookingsTable" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Ref</th>
                                                        <th>Guest</th>
                                                        <th>Property</th>
                                                        <th>Status</th>
                                                        <th>Dates</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($bookings as $booking)
                                                        <tr>
                                                            <td>{{ $bookings->firstItem() ? $bookings->firstItem() + $loop->index : $loop->iteration }}</td>
                                                            <td>{{ $booking->reference }}</td>
                                                            <td>{{ $booking->user ? ($booking->user->first_name . ' ' . $booking->user->last_name) : 'Guest' }}</td>
                                                            <td>{{ $booking->property->name ?? 'N/A' }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ $booking->status == 'Confirmed' ? ($booking->isCheckedIn() ? 'info' : 'success') : ($booking->status == 'Cancelled' ? 'danger' : ($booking->status == 'Completed' ? 'dark' : ($booking->status == 'Pending' ? 'warning' : 'dark'))) }}">
                                                                    {{ $booking->status == 'Confirmed' && $booking->isCheckedIn() ? 'Checked In' : ucfirst($booking->status) }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <small>{{ $booking->check_in_date }} to {{ $booking->check_out_date }}</small>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    @if($booking->status == 'Confirmed')
                                                                        <button class="btn btn-success btn-sm" onclick="handleCheckIn('{{ $booking->id }}')"><i class="bi bi-box-arrow-left"></i></button>
                                                                        <button class="btn btn-secondary btn-sm" onclick="handleCheckOut('{{ $booking->id }}')"><i class="bi bi-box-arrow-right"></i></button>
                                                                    @endif
                                                                    <a href="{{route('booking.view', $booking->reference)}}" class="btn btn-dark btn-sm"><i class="bi bi-eye"></i></a>
                                                                    @if(auth()->user()->hasRole('Super Admin') || $booking->status !== 'Completed')
                                                                        <button class="btn btn-danger btn-sm" onclick="handleCancel('{{ $booking->id }}')"><i class="bi bi-x-circle"></i></button>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @include('components.pagination', ['paginator' => $bookings])
                                    @else
                                        <p class="text-center mb-0 p-3">No bookings found in the system</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if(auth()->user()->hasRole('Super Admin'))
                            {{-- Chef Bookings --}}
                            <div class="tab-pane fade" id="pills-chefs" role="tabpanel" aria-labelledby="pills-chefs-tab">
                                <div class="card rounded-4">
                                    <div class="card-body">
                                        @if(isset($chefBookings) && $chefBookings->count() > 0)
                                            <div class="table-responsive">
                                                <table id="chefBookingsTable" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Ref</th>
                                                            <th>Guest</th>
                                                            <th>Chef</th>
                                                            <th>Service Date/Time</th>
                                                            <th>Price</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($chefBookings as $booking)
                                                            <tr>
                                                                <td>{{ $chefBookings->firstItem() ? $chefBookings->firstItem() + $loop->index : $loop->iteration }}</td>
                                                                <td>{{ $booking->reference }}</td>
                                                                <td>{{ $booking->user ? ($booking->user->first_name . ' ' . $booking->user->last_name) : 'Guest' }}</td>
                                                                <td>{{ $booking->chef?->first_name . ' ' . $booking->chef?->last_name ?? 'N/A' }}</td>
                                                                <td>{{ $booking->service_date }} at {{ $booking->service_time }}</td>
                                                                <td>₦ {{ number_format($booking->price) }}</td>
                                                                <td>
                                                                    <span class="badge bg-{{ $booking->status == 'Scheduled' ? 'brown' : ($booking->status == 'Cancelled' ? 'danger' : 'dark') }}">
                                                                        {{ ucfirst($booking->status) }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <div class="btn-group">
                                                                        <a href="{{route('booking.view', $booking->reference)}}" class="btn btn-dark btn-sm"><i class="bi bi-eye"></i></a>
                                                                        @if($booking->status !== 'Cancelled')
                                                                        <button class="btn btn-danger btn-sm" onclick="handleCancel('{{ $booking->id }}', 'chef')"><i class="bi bi-x-circle"></i></button>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @include('components.pagination', ['paginator' => $chefBookings])
                                        @else
                                            <p class="text-center mb-0 p-3">No chef bookings found</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Driver Bookings --}}
                            <div class="tab-pane fade" id="pills-drivers" role="tabpanel" aria-labelledby="pills-drivers-tab">
                                <div class="card rounded-4">
                                    <div class="card-body">
                                        @if(isset($driverBookings) && $driverBookings->count() > 0)
                                            <div class="table-responsive">
                                                <table id="driverBookingsTable" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Ref</th>
                                                            <th>Guest</th>
                                                            <th>Driver</th>
                                                            <th>Service Date/Time</th>
                                                            <th>Price</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($driverBookings as $booking)
                                                            <tr>
                                                                <td>{{ $driverBookings->firstItem() ? $driverBookings->firstItem() + $loop->index : $loop->iteration }}</td>
                                                                <td>{{ $booking->reference }}</td>
                                                                <td>{{ $booking->user ? ($booking->user->first_name . ' ' . $booking->user->last_name) : 'Guest' }}</td>
                                                                <td>{{ $booking->driver?->first_name . ' ' . $booking->driver?->last_name ?? 'N/A' }}</td>
                                                                <td>{{ $booking->ride_date }} at {{ $booking->ride_time }}</td>
                                                                <td>₦ {{ number_format($booking->price) }}</td>
                                                                <td>
                                                                    <span class="badge bg-{{ $booking->status == 'Scheduled' ? 'brown' : ($booking->status == 'Cancelled' ? 'danger' : 'dark') }}">
                                                                        {{ ucfirst($booking->status) }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <div class="btn-group">
                                                                        <a href="{{route('booking.view', $booking->reference)}}" class="btn btn-dark btn-sm"><i class="bi bi-eye"></i></a>
                                                                        @if($booking->status !== 'Cancelled')
                                                                        <button class="btn btn-danger btn-sm" onclick="handleCancel('{{ $booking->id }}', 'driver')"><i class="bi bi-x-circle"></i></button>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @include('components.pagination', ['paginator' => $driverBookings])
                                        @else
                                            <p class="text-center mb-0 p-3">No driver bookings found</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex flex-wrap gap-2 mb-2">
                        <span class="badge bg-primary">Active: {{ isset($activeBookings) ? $activeBookings->total() : 0 }}</span>
                        <span class="badge bg-dark">Completed: {{ isset($completedBookings) ? $completedBookings->total() : 0 }}</span>
                    </div>
                    <h6 class="mb-2 text-uppercase">My Property Bookings</h6>
                    <hr>
                    <div class="row">
                        @if(isset($activeBookings) && $activeBookings->count() > 0)
                            @foreach ($activeBookings as $booking)
                                <div class="col-md-4">
                                    <div class="card rounded-4 shadow-md p-0" style="overflow: hidden; margin-bottom: 0.5rem;">
                                        <div class="card-body p-0">
                                            <div class="row">
                                                <div class="col-4" style="overflow: hidden;">
                                                    <div class="booking-img" style="height: 100%; width: 100%;">
                                                        <img class="img-fluid" style="height: 100%; object-fit: cover;" src="{{ asset('storage/' . ($booking->property?->image_path ?? '')) }}" alt="booking-img">
                                                    </div>
                                                </div>
                                                <div class="col-8 p-2 ps-0">
                                                    <p class="card-title mb-0" style="font-weight: 500">{{ $booking->property?->name ?? 'Property Unavailable' }}</p>
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
                        @if(isset($completedBookings) && $completedBookings->count() > 0)
                            @foreach ($completedBookings as $booking)
                                <div class="col-md-4">
                                    <div class="card rounded-4 shadow-md p-0" style="overflow: hidden; margin-bottom: 0.5rem;">
                                        <div class="card-body p-0">
                                            <div class="row">
                                                <div class="col-4" style="overflow: hidden;">
                                                    <div class="booking-img" style="height: 100%; width: 100%;">
                                                        <img class="img-fluid" style="height: 100%; object-fit: cover;" src="{{ asset('storage/' . ($booking->property?->image_path ?? '')) }}" alt="booking-img">
                                                    </div>
                                                </div>
                                                <div class="col-8 p-2 ps-0">
                                                    <p class="card-title mb-0" style="font-weight: 500">{{ $booking->property?->name ?? 'Property Unavailable' }}</p>
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
        @endif
        @if(!auth()->user()->hasRole('Admin') && !auth()->user()->hasRole('Super Admin'))
            <div class="row mt-4">
                <div class="col-md-12">
                    <h6 class="mb-2 text-uppercase">My Chef Bookings</h6>
                    <hr>
                    <div class="row">
                        @if(isset($chefBookings) && $chefBookings->count() > 0)
                            @foreach ($chefBookings as $booking)
                                <div class="col-md-4">
                                    <div class="card rounded-4 shadow-md p-0" style="overflow: hidden; margin-bottom: 0.5rem;">
                                        <div class="card-body p-0">
                                            <div class="row">
                                                <div class="col-4" style="overflow: hidden;">
                                                    <div class="booking-img" style="height: 100px; width: 100%;">
                                                        <img class="img-fluid" style="width: 100%; object-fit: cover;" src="{{ asset($booking->chef?->image ?? 'assets/images/placeholder.jpg') }}" alt="booking-img">
                                                    </div>
                                                </div>
                                                <div class="col-8 p-2 ps-0">
                                                    <p class="card-title mb-0" style="font-weight: 500">{{ $booking->chef?->first_name . ' ' . $booking->chef?->last_name ?? 'Unknown Chef' }}</p>
                                                    <p class="card-text mb-0" style="font-size: 12px">{{$booking->service_date}} | {{$booking->service_time}} </p>
                                                    <p class="card-text mb-0" style="font-size: 12px">₦ {{ number_format($booking->price) }}</p>
                                                    <div class="d-flex justify-content-between align-items-center pe-3">
                                                        <p class="card-text mb-0" style="font-size: 12px">
                                                            <span class="badge bg-{{ $booking->status == 'Scheduled' ? 'brown' : ($booking->status == 'Cancelled' ? 'danger' : 'dark') }}">
                                                                {{ ucfirst($booking->status) }}
                                                            </span>
                                                        </p>
                                                        <div class="btn-group">
                                                            <a href="{{route('booking.view', $booking->reference)}}" role="button" class="btn btn-dark btn-sm"><i class="ms-0 bi bi-eye" style="font-size: 10px;"></i></a>
                                                            @if($booking->status !== 'Cancelled')
                                                            <button class="btn btn-danger btn-sm" onclick="handleCancel('{{ $booking->id }}', 'chef')"><i class="ms-0 bi bi-x-circle" style="font-size: 10px;"></i></button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @include('components.pagination', ['paginator' => $chefBookings])
                        @else
                            <p class="text-center mb-0 p-3">You have no Chef Bookings with us</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        @if(!auth()->user()->hasRole('Admin') && !auth()->user()->hasRole('Super Admin'))
            <div class="row mt-4">
                <div class="col-md-12">
                    <h6 class="mb-2 text-uppercase">My Driver Bookings</h6>
                    <hr>
                    <div class="row">
                        @if(isset($driverBookings) && $driverBookings->count() > 0)
                            @foreach ($driverBookings as $booking)
                                <div class="col-md-4">
                                    <div class="card rounded-4 shadow-md p-0" style="overflow: hidden; margin-bottom: 0.5rem;">
                                        <div class="card-body p-0">
                                            <div class="row">
                                                <div class="col-4" style="overflow: hidden;">
                                                    <div class="booking-img" style="height: 100px; width: 100%;">
                                                        <img class="img-fluid" style="width: 100%; object-fit: cover;" src="{{ asset($booking->driver?->image ?? 'assets/images/placeholder.jpg') }}" alt="booking-img">
                                                    </div>
                                                </div>
                                                <div class="col-8 p-2 ps-0">
                                                    <p class="card-title mb-0" style="font-weight: 500">{{ $booking->driver?->first_name . ' ' . $booking->driver?->last_name ?? 'Unknown Driver' }}</p>
                                                    <p class="card-text mb-0" style="font-size: 12px">{{$booking->ride_date}} | {{$booking->ride_time}} </p>
                                                    <p class="card-text mb-0" style="font-size: 12px">₦ {{ number_format($booking->price) }}</p>
                                                    <div class="d-flex justify-content-between align-items-center pe-3">
                                                        <p class="card-text mb-0" style="font-size: 12px">
                                                            <span class="badge bg-{{ $booking->status == 'Scheduled' ? 'brown' : ($booking->status == 'Cancelled' ? 'danger' : 'dark') }}">
                                                                {{ ucfirst($booking->status) }}
                                                            </span>
                                                        </p>
                                                        <div class="btn-group">
                                                            <a href="{{route('booking.view', $booking->reference)}}" role="button" class="btn btn-dark btn-sm"><i class="ms-0 bi bi-eye" style="font-size: 10px;"></i></a>
                                                            @if($booking->status !== 'Cancelled')
                                                            <button class="btn btn-danger btn-sm" onclick="handleCancel('{{ $booking->id }}', 'driver')"><i class="ms-0 bi bi-x-circle" style="font-size: 10px;"></i></button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @include('components.pagination', ['paginator' => $driverBookings])
                        @else
                            <p class="text-center mb-0 p-3">You have no Driver Bookings with us</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif
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
                confirmButton: 'btn btn-primary px-4 me-2',
                cancelButton: 'btn btn-danger px-4',
                popup: 'rounded-4 border-0 shadow'
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
            title: 'Check Out Guest?',
            html: "This will mark the booking as <strong>Completed</strong>, release the property, and finalize any revenue splits.",
            icon: 'question',
            buttonsStyling: false,
            showCancelButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            showLoaderOnConfirm: true,
            confirmButtonText: 'Yes, check out!',
            cancelButtonText: 'No, cancel',
            customClass: {
                confirmButton: 'btn btn-primary px-4 me-2',
                cancelButton: 'btn btn-danger px-4',
                popup: 'rounded-4 border-0 shadow'
            },
            preConfirm: () => {
                return new Promise(function (resolve, reject) {
                    $.ajax({
                        url: "{{ route('check_out_booking') }}",
                        type: "POST",
                        data: { booking_id: booking_id },
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        dataType: "json"
                    }).done(function (response) {
                        if (response && response.status === 'success') {
                            resolve(response);
                        } else {
                            var msg = (response && response.message) ? response.message : 'Check out failed';
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
                Swal.fire('Done!', resp.message || 'Guest has been checked out!', 'success').then(() => {
                    location.reload();
                });
            }
        }).catch(function(err){
            var msg = (err && err.message) ? err.message : 'Request failed';
            Swal.fire('Error', msg, 'error');
        });
    }

    function handleCancel(booking_id, type = 'property') {
        Swal.fire({
            title: 'Are you sure?',
            html: "You want to cancel this " + type + " booking?",
            icon: 'warning',
            buttonsStyling: false,
            showCancelButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            showLoaderOnConfirm: true,
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'No, keep it',
            customClass: {
                confirmButton: 'btn btn-primary px-4 me-2',
                cancelButton: 'btn btn-danger px-4',
                popup: 'rounded-4 border-0 shadow'
            },
            preConfirm: () => {
                return $.ajax({
                    url: "{{ route('cancel_booking') }}",
                    type: "POST",
                    data: { 
                        booking_id: booking_id,
                        booking_type: type
                    },
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    dataType: "json"
                }).then(function (response) {
                    if (response.status === 'success') return response;
                    throw new Error(response.message || 'Cancel failed');
                }).catch(function (err) { throw err; });
            }
        }).then(function (result) {
            if (result && result.value) {
                var resp = result.value;
                Swal.fire('Cancelled!', resp.message || 'Booking has been cancelled.', 'success').then(() => {
                    location.reload();
                });
            }
        }).catch(function (err) {
            var msg = (err && err.message) ? err.message : 'Request failed';
            Swal.fire('Error', msg, 'error');
        });
    }

    function confirmBulkCancel() {
        Swal.fire({
            title: 'Clear Stale Bookings?',
            text: "This will cancel all Pending bookings older than 24 hours.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, clear them',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-primary px-4 me-2',
                cancelButton: 'btn btn-danger px-4',
                popup: 'rounded-4 border-0 shadow'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('bulkCancelForm').submit();
            }
        });
    }
</script>
@endpush
