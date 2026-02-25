@extends('layouts.app', [$activePage = 'Dashboard'])

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/sweetalert2.css') }}" />
@endpush

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
        @if(auth()->user()->hasRole('Cleaner'))
            <div class="row">
                <h2>Welcome Back!</h2>
                <p>{{$greeting}}, {{auth()->user()->first_name}} (Cleaner) 🙂...</p>
            </div>

            <div class="row row-cols-1 row-cols-md-3 row-cols-xl-3">
                <div class="col">
                    <div class="card rounded-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <p class="mb-1">Under Maintenance</p>
                                    <h4 class="mb-0">{{count($to_clean)}}</h4>
                                </div>
                                <div class="ms-auto widget-icon bg-warning text-white">
                                    <i class="bi bi-hourglass-split"></i>
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
                                    <p class="mb-1">Cleaned Today</p>
                                    <h4 class="mb-0">{{$cleaned_today}}</h4>
                                </div>
                                <div class="ms-auto widget-icon bg-success text-white">
                                    <i class="bi bi-check-circle-fill"></i>
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
                                    <p class="mb-1">Reported Issues</p>
                                    <h4 class="mb-0">{{$reported_issues}}</h4>
                                </div>
                                <div class="ms-auto widget-icon bg-danger text-white">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row px-3 mt-3">
                <h6 class="mb-2 text-uppercase">Apartments To Clean</h6>
                <hr />
                <div class="card rounded-4">
                    <div class="card-body">
                        @if(count($to_clean) > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Apartment Name</th>
                                            <th>Location</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($to_clean as $index => $property)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $property->name }}</td>
                                                <td>{{ $property->full_location }}</td>
                                                <td>
                                                    <button class="btn btn-success btn-sm w-100"
                                                        onclick="markAsAvailable('{{ $property->id }}')">
                                                        <i class="bi bi-check-circle ms-0"></i> Mark Clean
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-center mb-0 p-3">No apartments currently need cleaning.</p>
                        @endif
                    </div>
                </div>
            </div>
        @elseif(auth()->user()->hasRole('Admin'))
            <div class="row">
                <h2>Welcome Back!</h2>
                <p>{{$greeting}}, {{auth()->user()->first_name}} (Admin) 🙂...</p>
            </div>
            <div class="row row-cols-1 row-cols-md-3 row-cols-xl-3">
                <div class="col">
                    <div class="card rounded-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <p class="mb-1">My Revenue</p>
                                    <h4 class="mb-0">₦ {{number_format($admin_revenue, 2)}}</h4>
                                </div>
                                <div class="ms-auto widget-icon bg-success text-white">
                                    <i class="bi bi-wallet2"></i>
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
                                    <p class="mb-1">Upcoming Check-ins</p>
                                    <h4 class="mb-0">{{$admin_upcoming_checkins}}</h4>
                                </div>
                                <div class="ms-auto widget-icon bg-primary text-white">
                                    <i class="bi bi-calendar-check"></i>
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
                                    <h4 class="mb-0">{{$admin_total_bookings}}</h4>
                                </div>
                                <div class="ms-auto widget-icon bg-secondary text-white">
                                    <i class="bi bi-journal-bookmark-fill"></i>
                                </div>
                            </div>
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
                    @if(count($admin_recent_bookings) > 0)
                        @foreach ($admin_recent_bookings as $booking)
                            <div class="col-md-4">
                                <div class="card rounded-4 shadow-md p-0" style="overflow: hidden; margin-bottom: 0.5rem;">
                                    <div class="card-body p-0">
                                        <div class="row">
                                            <div class="col-4" style="overflow: hidden;">
                                                <div class="booking-img" style="height: 100%; width: 100%;">
                                                    <img class="img-fluid" style="height: 100%; object-fit: cover;"
                                                        src="{{ asset('storage/' . $booking->property->image_path) }}"
                                                        alt="booking-img">
                                                </div>
                                            </div>
                                            <div class="col-8 p-2 ps-0">
                                                <p class="card-title mb-0" style="font-weight: 500">{{$booking->property->name}}</p>
                                                <p class="card-text mb-0" style="font-size: 12px">{{$booking->check_in_date}}
                                                    @if($booking->check_in_time) ({{ \Carbon\Carbon::parse($booking->check_in_time)->format('h:i A') }}) @endif -
                                                    {{$booking->check_out_date}} @if($booking->check_out_time)
                                                    ({{ \Carbon\Carbon::parse($booking->check_out_time)->format('h:i A') }}) @endif
                                                </p>
                                                <p class="card-text mb-0" style="font-size: 12px">₦ {{ $booking->total_price }}</p>
                                                <div class="d-flex justify-content-between align-items-center pe-3">
                                                    <p class="card-text mb-0" style="font-size: 12px">
                                                        <span
                                                            class="badge bg-{{ $booking->status == 'Confirmed' ? ($booking->isCheckedIn() ? 'info' : 'success') : ($booking->status == 'Cancelled' ? 'danger' : ($booking->status == 'Pending' ? 'warning' : 'dark')) }}">
                                                            {{ $booking->status == 'Confirmed' && $booking->isCheckedIn() ? 'Checked In' : ucfirst($booking->status) }}
                                                        </span>
                                                    </p>
                                                    <div class="btn-group">
                                                        @if($booking->status == 'Confirmed')
                                                            <button class="btn btn-success btn-sm"
                                                                onclick="handleCheckIn('{{ $booking->id }}')"><i
                                                                    class="ms-0 bi bi-box-arrow-left" style="font-size: 10px;"></i></button>
                                                            <button class="btn btn-secondary btn-sm"
                                                                onclick="handleCheckOut('{{ $booking->id }}')"><i
                                                                    class="ms-0 bi bi-box-arrow-right"
                                                                    style="font-size: 10px;"></i></button>
                                                        @endif
                                                        <a href="{{route('booking.view', $booking->reference)}}" role="button"
                                                            class="btn btn-dark btn-sm"><i class="ms-0 bi bi-eye"
                                                                style="font-size: 10px;"></i></a>
                                                        @if(auth()->user()->hasRole('Super Admin') || $booking->status !== 'Completed')
                                                            <button class="btn btn-danger btn-sm"
                                                                onclick="handleCancel('{{ $booking->id }}')"><i class="ms-0 bi bi-x-circle"
                                                                    style="font-size: 10px;"></i></button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center mb-0 p-3">No recent bookings found.</p>
                    @endif
                </div>
            </div>

            <div class="row px-3 mt-3">
                <h6 class="mb-2 text-uppercase">Manage All Bookings</h6>
                <hr />
                <div class="card rounded-4">
                    <div class="card-body">
                        @if(count($admin_bookings) > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Booking Ref</th>
                                            <th>Guest Name</th>
                                            <th class="d-none d-md-table-cell">Property</th>
                                            <th>Status</th>
                                            <th class="d-none d-md-table-cell">Start Date</th>
                                            <th class="d-none d-md-table-cell">End Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($admin_bookings as $index => $booking)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $booking->reference }}</td>
                                                <td>{{ $booking->user->first_name ?? 'Guest' }} {{ $booking->user->last_name ?? '' }}</td>
                                                <td class="d-none d-md-table-cell">{{ $booking->property->name }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $booking->status == 'Confirmed' ? ($booking->isCheckedIn() ? 'info' : 'success') : ($booking->status == 'Cancelled' ? 'danger' : ($booking->status == 'Completed' ? 'dark' : ($booking->status == 'Pending' ? 'warning' : 'dark'))) }}">
                                                        {{ $booking->status == 'Confirmed' && $booking->isCheckedIn() ? 'Checked In' : ucfirst($booking->status) }}
                                                    </span>
                                                </td>
                                                    <td>
                                                        {{ $booking->check_in_date }}
                                                        @if($booking->check_in_time) <br><small
                                                        class="text-muted">{{ \Carbon\Carbon::parse($booking->check_in_time)->format('h:i A') }}</small> @endif
                                                    </td>
                                                    <td>
                                                        {{ $booking->check_out_date }}
                                                        @if($booking->check_out_time) <br><small
                                                        class="text-muted">{{ \Carbon\Carbon::parse($booking->check_out_time)->format('h:i A') }}</small> @endif
                                                    </td>
                                                <td>
                                                    <div class="btn-group">
                                                        @if($booking->status == 'Confirmed')
                                                            <button class="btn btn-success btn-sm"
                                                                onclick="handleCheckIn('{{ $booking->id }}')"><i
                                                                    class="ms-0 bi bi-box-arrow-left"></i></button>
                                                            <button class="btn btn-secondary btn-sm"
                                                                onclick="handleCheckOut('{{ $booking->id }}')"><i
                                                                    class="ms-0 bi bi-box-arrow-right"></i></button>
                                                        @endif
                                                        <a href="{{ route('booking.view', $booking->reference) }}"
                                                            class="btn btn-dark btn-sm">
                                                            <i class="ms-0 bi bi-eye"></i>
                                                        </a>
                                                        @if(auth()->user()->hasRole('Super Admin') || $booking->status !== 'Completed')
                                                            <button class="btn btn-danger btn-sm"
                                                                onclick="handleCancel('{{ $booking->id }}')"><i
                                                                    class="ms-0 bi bi-x-circle"></i></button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-center mb-0 p-3">No recent bookings found.</p>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <h2>Welcome Back!</h2>
                <p>{{$greeting}}, {{auth()->user()->first_name}}🙂...</p>
            </div>
            @if(auth()->user()->can("access all records") && !auth()->user()->hasRole('Admin'))
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
                                <img src="{{asset('dashboard/assets/images/house.png')}}" alt=""
                                    style="text-align:center; width: 90%">
                            </div>
                            <p class="mt-4">Smart Apartments tailored for you.</p>
                            <a href="{{route('properties.index')}}" role="button" class="btn btn-primary rounded-3 px-4">Book an
                                Apartment</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="card rounded-4 p-3" style="width: 100%;">
                        <div class="card-body text-center">
                            <div class="row justify-content-center">
                                <img src="{{asset('dashboard/assets/images/chef.jpg')}}" alt=""
                                    style="text-align:center; width: 80%">
                            </div>
                            <p>Professional Chefs are waiting</p>
                            <a href="{{route('chefs.book')}}" class="btn btn-primary rounded-3 px-4" role="button">Book a
                                Chef</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="card rounded-4 p-3" style="width: 100%;">
                        <div class="card-body text-center">
                            <div class="row justify-content-center">
                                <img src="{{asset('dashboard/assets/images/driver.avif')}}" alt=""
                                    style="text-align:center; width: 94%">
                            </div>
                            <p class="mt-1">Our Drivers Available all day.</p>
                            <a href="{{route('drivers.book')}}" class="btn btn-primary rounded-3 px-4" type="button">Book a
                                Driver</a>
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
                    @if(count($my_bookings) > 0)
                        @foreach ($my_bookings as $index => $booking)
                            <div class="col-md-4">
                                <div class="card rounded-4 shadow-md p-0" style="overflow: hidden; margin-bottom: 0.5rem;">
                                    <div class="card-body p-0">
                                        <div class="row">
                                            <div class="col-4" style="overflow: hidden;">
                                                <div class="booking-img" style="height: 100%; width: 100%;">
                                                    <img class="img-fluid" style="height: 100%; object-fit: cover;"
                                                        src="{{ asset('storage/' . $booking->property->image_path) }}"
                                                        alt="booking-img">
                                                </div>
                                            </div>
                                            <div class="col-8 p-2 ps-0">
                                                <p class="card-title mb-0" style="font-weight: 500">{{$booking->property->name}}</p>
                                                <p class="card-text mb-0" style="font-size: 12px">{{$booking->check_in_date}}
                                                    @if($booking->check_in_time) ({{ \Carbon\Carbon::parse($booking->check_in_time)->format('h:i A') }}) @endif -
                                                    {{$booking->check_out_date}} @if($booking->check_out_time)
                                                    ({{ \Carbon\Carbon::parse($booking->check_out_time)->format('h:i A') }}) @endif
                                                </p>
                                                <p class="card-text mb-0" style="font-size: 12px">₦ {{ $booking->total_price }}</p>
                                                <div class="d-flex justify-content-between align-items-center pe-3">
                                                    <p class="card-text mb-0" style="font-size: 12px">
                                                        <span
                                                            class="badge bg-{{ $booking->status == 'Confirmed' ? ($booking->isCheckedIn() ? 'info' : 'success') : ($booking->status == 'Cancelled' ? 'danger' : ($booking->status == 'Pending' ? 'warning' : 'dark')) }}">
                                                            {{ $booking->status == 'Confirmed' && $booking->isCheckedIn() ? 'Checked In' : ucfirst($booking->status) }}
                                                        </span>
                                                    </p>
                                                    <div class="btn-group">
                                                        @if($booking->status == 'Confirmed')
                                                            <button class="btn btn-primary btn-sm"
                                                                onclick="handleCheckIn('{{ $booking->id }}')"><i
                                                                    class="ms-0 bi bi-box-arrow-left" style="font-size: 10px;"></i></button>
                                                            <button class="btn btn-secondary btn-sm"
                                                                onclick="handleCheckOut('{{ $booking->id }}')"><i
                                                                    class="ms-0 bi bi-box-arrow-right"
                                                                    style="font-size: 10px;"></i></button>
                                                        @endif
                                                        <a href="{{route('booking.view', $booking->reference)}}" role="button"
                                                            class="btn btn-dark btn-sm"><i class="ms-0 bi bi-eye"
                                                                style="font-size: 10px;"></i></a>
                                                        @if(auth()->user()->hasRole('Super Admin') || $booking->status !== 'Completed')
                                                            <button class="btn btn-danger btn-sm"
                                                                onclick="handleCancel('{{ $booking->id }}')"><i class="ms-0 bi bi-x-circle"
                                                                    style="font-size: 10px;"></i></button>
                                                        @endif
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
            @can("access all records")
                <div class="row px-3 mt-3">
                    <h6 class="mb-2 text-uppercase">Manage all Bookings</h6>
                    <hr />
                    <div class="card rounded-4">
                        <div class="card-body">
                            @if(count($bookings) > 0)
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
                                                    <td>{{ ($booking->user->first_name ?? 'Guest') . ' ' . ($booking->user->last_name ?? '') }}</td>
                                                    <td>{{ $booking->property->name }}</td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $booking->status == 'Confirmed' ? 'success' : ($booking->status == 'Cancelled' ? 'danger' : ($booking->status == 'Completed' ? 'dark' : ($booking->status == 'Pending' ? 'warning' : 'dark'))) }}">
                                                            {{ ucfirst($booking->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {{ $booking->check_in_date }}
                                                        @if($booking->check_in_time) <br><small
                                                        class="text-muted">{{ $booking->check_in_time }}</small> @endif
                                                    </td>
                                                    <td>
                                                        {{ $booking->check_out_date }}
                                                        @if($booking->check_out_time) <br><small
                                                        class="text-muted">{{ $booking->check_out_time }}</small> @endif
                                                    </td>
                                                    <td>
                                                        <!-- Action Buttons -->
                                                        <div class="btn-group">
                                                            @if($booking->status == 'Confirmed')
                                                                <button class="btn btn-success btn-sm"
                                                                    onclick="handleCheckIn('{{ $booking->id }}')"><i
                                                                        class="ms-0 bi bi-box-arrow-left"></i></button>
                                                                <button class="btn btn-secondary btn-sm"
                                                                    onclick="handleCheckOut('{{ $booking->id }}')"><i
                                                                        class="ms-0 bi bi-box-arrow-right"></i></button>
                                                            @endif
                                                            <a href="{{route('booking.view', $booking->reference)}}" role="button"
                                                                class="btn btn-dark btn-sm"><i class="ms-0 bi bi-eye"></i></a>
                                                            @if(auth()->user()->hasRole('Super Admin') || $booking->status !== 'Completed')
                                                                <button class="btn btn-danger btn-sm"
                                                                    onclick="handleCancel('{{ $booking->id }}')"><i
                                                                        class="ms-0 bi bi-x-circle"></i></button>
                                                            @endif
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
            @endcan
        @endif
    </main>
    <!--end page main-->
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
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
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
                            } catch (e) { }
                            reject(new Error(msg));
                        });
                    });
                }
            }).then(function (result) {
                if (result && result.value) {
                    var resp = result.value;
                    Swal.fire('Done!', resp.message || 'You have been checked in!', 'success').then(() => {
                        location.reload();
                    });
                }
            }).catch(function (err) {
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
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        dataType: "json"
                    }).then(function (response) {
                        if (response.status === 'success') return response;
                        throw new Error(response.message || 'Check out failed');
                    }).catch(function (err) { throw err; });
                }
            }).then(function (result) {
                if (result && result.value) {
                    var resp = result.value;
                    Swal.fire('Done!', resp.message || 'You have been checked out!', 'success').then(() => {
                        location.reload();
                    });
                }
            }).catch(function (err) {
                var msg = (err && err.message) ? err.message : 'Request failed';
                Swal.fire('Error', msg, 'error');
            });
        }

        // Alias functions to support inconsistent naming in HTML
        function checkIn(booking_id) {
            handleCheckIn(booking_id);
        }

        function checkOut(booking_id) {
            handleCheckOut(booking_id);
        }

        function handleCancel(booking_id) {
            Swal.fire({
                title: 'Are you sure?',
                html: "You will cancel this booking?",
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
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                },
                preConfirm: () => {
                    return $.ajax({
                        url: "{{ route('cancel_booking') }}",
                        type: "POST",
                        data: { booking_id: booking_id },
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
    </script>
    <script>
        function markAsAvailable(propertyId) {
            if (confirm("Are you sure you want to mark this apartment as available?")) {
                fetch(`/admin/properties/${propertyId}/mark-available`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert("Something went wrong.");
                        }
                    });
            }
        }
    </script>
@endpush