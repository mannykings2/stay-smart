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
        @if(auth()->user()->hasRole('Admin'))
            <div class="row">
                <h2>Welcome Back!</h2>
                <p>{{$greeting}}, {{ optional(auth()->user())->first_name }} (Admin) 🙂...</p>
            </div>
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                <div class="col">
                    <div class="card rounded-4" data-bs-toggle="tooltip" title="Total net earnings from completed bookings.">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <p class="mb-1">Net Revenue <i class="bi bi-info-circle ms-1"></i></p>
                                    <h4 class="mb-0 text-success">₦ {{number_format($revenueStats['net'], 2)}}</h4>
                                </div>
                                <div class="ms-auto widget-icon bg-success text-white">
                                    <i class="bi bi-wallet2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card rounded-4" data-bs-toggle="tooltip"
                        title="Estimated earnings from active bookings.">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <p class="mb-1">Pending Balance <i class="bi bi-info-circle ms-1"></i></p>
                                    <h4 class="mb-0 text-warning">₦ {{number_format($revenueStats['pending'], 2)}}</h4>
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

            <!-- Revenue Chart Section -->
            <div class="row mt-4">
                <div class="col-12 col-lg-8">
                    <div class="card rounded-4">
                        <div class="card-header bg-transparent">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">Revenue Overview ({{ ucfirst($timeframe) }})</h6>
                                </div>
                                <div class="ms-auto">
                                    <form action="{{ route('home') }}" method="GET" id="timeframeForm">
                                        <select name="timeframe" class="form-select form-select-sm"
                                            onchange="this.form.submit()">
                                            <option value="week" {{ $timeframe == 'week' ? 'selected' : '' }}>This Week</option>
                                            <option value="month" {{ $timeframe == 'month' ? 'selected' : '' }}>This Month
                                            </option>
                                            <option value="year" {{ $timeframe == 'year' ? 'selected' : '' }}>This Year</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container-1" style="height: 300px;">
                                <canvas id="revenueChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card rounded-4">
                        <div class="card-header bg-transparent">
                            <h6 class="mb-0">Revenue Distribution</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-container-2" style="height: 200px;">
                                <canvas id="distributionChart"></canvas>
                            </div>
                            <div class="mt-4">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <p class="mb-0">Admin Net</p>
                                    <p class="mb-0">{{ number_format($revenueStats['admin_percentage'], 1) }}%</p>
                                </div>
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar bg-success" role="progressbar"
                                        style="width: {{ $revenueStats['admin_percentage'] }}%"></div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-3 mb-2">
                                    <p class="mb-0">Platform Fee</p>
                                    <p class="mb-0">{{ number_format($revenueStats['platform_percentage'], 1) }}%</p>
                                </div>
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar bg-danger" role="progressbar"
                                        style="width: {{ $revenueStats['platform_percentage'] }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


             {{-- Manage All Bookings table moved to My Bookings page --}}
        @else
            <div class="row">
                <h2>Welcome Back!</h2>
                <p>{{$greeting}}, {{ optional(auth()->user())->first_name }}🙂...</p>
            </div>
            @if(auth()->user()->can("access all records") && !auth()->user()->hasRole('Admin'))
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">
                    <div class="col">
                        <div class="card rounded-4" data-bs-toggle="tooltip"
                            title="Total business volume generated across all properties and services.">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="">
                                        <p class="mb-1">Platform Revenue <i class="bi bi-info-circle ms-1"></i></p>
                                        <h4 class="mb-0">₦ {{number_format($revenueStats['total'], 2)}}</h4>
                                        <p class="mb-0 mt-2 font-13"><i class="bi bi-arrow-up"></i><span>Lifetime</span></p>
                                    </div>
                                    <div class="ms-auto widget-icon bg-primary text-white">
                                        <i class="bi bi-currency-exchange"></i>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card rounded-4" data-bs-toggle="tooltip"
                            title="The Platform's share earned from global commissions.">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="">
                                        <p class="mb-1">Platform Fees <i class="bi bi-info-circle ms-1"></i></p>
                                        <h4 class="mb-0">₦ {{number_format($revenueStats['platform'], 2)}}</h4>
                                        <p class="mb-0 mt-2 font-13"><i class="bi bi-shield-check"></i><span>Lifetime</span></p>
                                    </div>
                                    <div class="ms-auto widget-icon bg-danger text-white">
                                        <i class="bi bi-shield-lock"></i>
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
                                        <p class="mb-0 mt-2 font-13"><i class="bi bi-arrow-up"></i><span>All Time</span></p>
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
                                        <h4 class="mb-0">{{number_format($usersCount)}}</h4>
                                        <p class="mb-0 mt-2 font-13"><i class="bi bi-people-fill"></i><span>Users registered</span>
                                        </p>
                                    </div>
                                    <div class="ms-auto widget-icon bg-dark text-white">
                                        <i class="bi bi-people-fill"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                @if(auth()->user()->hasRole('Super Admin'))
                    <!-- Super Admin Revenue Chart Section -->
                    <div class="row mt-4 mb-4">
                        <div class="col-12 col-lg-8">
                            <div class="card rounded-4">
                                <div class="card-header bg-transparent">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h6 class="mb-0">Platform Performance ({{ ucfirst($timeframe) }})</h6>
                                        </div>
                                        <div class="ms-auto">
                                            <form action="{{ route('home') }}" method="GET">
                                                <select name="timeframe" class="form-select form-select-sm"
                                                    onchange="this.form.submit()">
                                                    <option value="week" {{ $timeframe == 'week' ? 'selected' : '' }}>This Week</option>
                                                    <option value="month" {{ $timeframe == 'month' ? 'selected' : '' }}>This Month
                                                    </option>
                                                    <option value="year" {{ $timeframe == 'year' ? 'selected' : '' }}>This Year</option>
                                                </select>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container-1" style="height: 300px;">
                                        <canvas id="revenueChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card rounded-4">
                                <div class="card-header bg-transparent">
                                    <h6 class="mb-0">Revenue Distribution</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container-2" style="height: 200px;">
                                        <canvas id="distributionChart"></canvas>
                                    </div>
                                    <div class="mt-4">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <p class="mb-0">Admins Share</p>
                                            <p class="mb-0">{{ number_format($revenueStats['admin_percentage'], 1) }}%</p>
                                        </div>
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: {{ $revenueStats['admin_percentage'] }}%"></div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-3 mb-2">
                                            <p class="mb-0">Platform Fees</p>
                                            <p class="mb-0">{{ number_format($revenueStats['platform_percentage'], 1) }}%</p>
                                        </div>
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-danger" role="progressbar"
                                                style="width: {{ $revenueStats['platform_percentage'] }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            <!--end row-->


        @endif
        {{-- Booking action cards for regular users --}}
        @if(!auth()->user()->hasRole('Admin') && !auth()->user()->hasRole('Super Admin'))
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
        @endif

        @if(!auth()->user()->hasRole('Admin') && !auth()->user()->hasRole('Super Admin'))
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
                                                        src="{{ asset('storage/' . $booking->property?->image_path) }}"
                                                        alt="booking-img">
                                                </div>
                                            </div>
                                            <div class="col-8 p-2 ps-0">
                                                <p class="card-title mb-0" style="font-weight: 500">{{$booking->property->name}}</p>
                                                <p class="card-text mb-0" style="font-size: 12px">{{$booking->check_in_date}}
                                                    @if($booking->check_in_time)
                                                    ({{ \Carbon\Carbon::parse($booking->check_in_time)->format('h:i A') }}) @endif -
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
        @endif
    </main>
    <!--end page main-->
@endsection

@push('js')
    <script src="{{ asset('assets/js/plugins/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sweetalert2.js') }}"></script>

    @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super Admin'))
        <script>
            $(function () {
                "use strict";

                // Initialize Tooltips
                $('[data-bs-toggle="tooltip"]').tooltip();

                // Main Revenue Chart
                var ctx = document.getElementById('revenueChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($chartData['labels']) !!},
                        datasets: [{
                            label: 'Total Revenue',
                            data: {!! json_encode($chartData['datasets'][0]['data']) !!},
                            backgroundColor: "rgba(54, 162, 235, 0.4)",
                            borderColor: "rgba(54, 162, 235, 1)",
                            borderWidth: 1,
                            borderRadius: 5,
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function (value) { return '₦' + value.toLocaleString(); }
                                }
                            }
                        }
                    }
                });

                // Distribution Chart
                var ctx2 = document.getElementById('distributionChart').getContext('2d');
                var distributionChart = new Chart(ctx2, {
                    type: 'doughnut',
                    data: {
                        labels: ['Admin Share', 'Platform Fee'],
                        datasets: [{
                            data: [{{ $revenueStats['net'] }}, {{ $revenueStats['platform'] }}],
                            backgroundColor: [
                                'rgba(40, 167, 69, 0.7)',
                                'rgba(220, 53, 69, 0.7)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        cutout: '80%',
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            });
        </script>
    @endif
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
    </script>
@endpush