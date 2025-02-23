@extends('layouts.app', [$activePage = 'Dashboard'])

@section('content')
    <!--start content-->
    <main class="page-content">
        @php
            $hour = now()->format('H');
            $greeting = '';

            if ($hour < 12) {
                $greeting = 'Good Morning';
            } elseif ($hour < 18) {
                $greeting = 'Good Afternoon';
            } else {
                $greeting = 'Good Evening';
            }
        @endphp
        <div class="row">
            <h2>Welcome Back!</h2>
            <p>{{$greeting}}, {{auth()->user()->first_name}}🙂...</p>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-md-7">
                <div class="points-notice p-4 rounded-4 shadow-sm d-flex gap-3 align-items-center">
                    <i class="bi bi-info-circle"></i>
                    <span class="points-text">You have 459 points. Please redeem them until the 30.04.2025. Learn more <a href="#">here</a></span>
                </div>
            </div>
        </div>
        @if(auth()->user()->role != 'User')
        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">
            <div class="col">
                <div class="card rounded-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="">
                                <p class="mb-1">Total Properties</p>
                                <h4 class="mb-0">{{number_format($properties->count())}}</h4>
                                <p class="mb-0 mt-2 font-13"><i class="bi bi-arrow-up"></i><span>Since Inception</span></p>
                            </div>
                            <div class="ms-auto widget-icon bg-primary text-white">
                                <i class="bi bi-house-heart-fill"></i>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card rounded-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="">
                                <p class="mb-1">My Bookings</p>
                                <h4 class="mb-0">{{number_format($my_bookings->count())}}</h4>
                                <p class="mb-0 mt-2 font-13"><i class="bi bi-arrow-up"></i><span>Since Inception</span></p>
                            </div>
                            <div class="ms-auto widget-icon bg-success text-white">
                                <i class="bi bi-calendar2-check-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card rounded-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="">
                                <p class="mb-1">Total Bookings</p>
                                <h4 class="mb-0">{{number_format($bookings->count())}}</h4>
                                <p class="mb-0 mt-2 font-13"><i class="bi bi-arrow-up"></i><span>Since Inception</span></p>
                            </div>
                            <div class="ms-auto widget-icon bg-secondary text-white">
                                <i class="bi bi-calendar2-check-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card rounded-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="">
                                <p class="mb-1">Total Users</p>
                                <h4 class="mb-0">{{number_format($users)}}</h4>
                                <p class="mb-0 mt-2 font-13"><i class="bi bi-arrow-up"></i><span>Since Inception</span></p>
                            </div>
                            <div class="ms-auto widget-icon bg-dark text-white">
                                <i class="bi bi-people-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @endif
        <!--end row-->


        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-12">
                <div class="card rounded-4 p-3" style="width: 100%;">
                    <div class="card-body text-center">
                        <div class="row justify-content-center">
                            <img src="{{asset('dashboard/assets/images/house.png')}}" alt="" style="text-align:center; width: 90%">
                        </div>
                        <p class="mt-4">Smart Apartments tailored for you.</p>
                        <a href="{{route('apartments.index')}}" role="button" class="btn btn-primary rounded-3 px-4">Book an Apartment</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="card rounded-4 p-3" style="width: 100%;">
                    <div class="card-body text-center">
                        <div class="row justify-content-center">
                            <img src="{{asset('dashboard/assets/images/chef.jpg')}}" alt="" style="text-align:center; width: 80%">
                        </div>
                        <p>Professional Chefs are waiting</p>
                        <button type="button" class="btn btn-primary rounded-3 px-4">Book a Chef</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="card rounded-4 p-3" style="width: 100%;">
                    <div class="card-body text-center">
                        <div class="row justify-content-center">
                            <img src="{{asset('dashboard/assets/images/driver.avif')}}" alt="" style="text-align:center; width: 94%">
                        </div>
                        <p class="mt-1">Our Drivers Available all day.</p>
                        <button type="button" class="btn btn-primary rounded-3 px-4">Book a Driver</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-4 mb-5">
            <h6 class="mb-2 text-uppercase px-3">
                My Bookings
                <hr>
            </h6>
            <div class="row p-0">
                @if(count($my_bookings)>0)
                    @foreach ($my_bookings as $index => $booking)
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
        @if(auth()->user()->role != 'User')
        <div class="row px-3 mt-3">
            <h6 class="mb-2 text-uppercase">Manage all Bookings</h6>
            <hr/>
            <div class="card rounded-4">
                <div class="card-body">
                    @if(count($bookings)>0)
                        <div class="table-responsive">
                            <table id="bookingsTable" class="mDatatable table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Booking Ref</th>
                                        <th>User</th>
                                        <th>Property</th>
                                        <th>Status</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bookings as $index => $booking)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $booking->reference }}</td>
                                        <td>{{ $booking->user->first_name . ' ' . $booking->user->last_name }}</td>
                                        <td>{{ $booking->property->name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $booking->status == 'Confirmed' ? 'success' : ($booking->status == 'Cancelled' ? 'danger' : 'dark') }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $booking->check_in_date }}</td>
                                        <td>{{ $booking->check_out_date }}</td>
                                        <td>
                                            <!-- Action Buttons -->
                                            <div class="btn-group">
                                                @if($booking->status == 'Confirmed')
                                                    <button class="btn btn-success btn-sm" onclick="handleCheckIn({{ $booking->id }})"><i class="ms-0 bi bi-box-arrow-left"></i></button>
                                                    <button class="btn btn-secondary btn-sm" onclick="handleCheckOut({{ $booking->id }})"><i class="ms-0 bi bi-box-arrow-right"></i></button>
                                                @endif
                                                <a href="{{route('booking.view', $booking->reference)}}" role="button" class="btn btn-dark btn-sm"><i class="ms-0 bi bi-eye"></i></a>
                                                <button class="btn btn-danger btn-sm" onclick="handleCancel({{ $booking->id }})"><i class="ms-0 bi bi-x-circle"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center mb-0 p-3">There are no bookings in the system</p>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </main>
    <!--end page main-->
@endsection
