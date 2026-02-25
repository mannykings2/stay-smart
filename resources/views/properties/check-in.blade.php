@extends('layouts.app', [$activePage = 'Check In'])

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/sweetalert2.css') }}" />
@endpush

@section('content')
    <!--start content-->
    <main class="page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 mt-5">
                    <h1 class="text-center mb-5">Welcome to <span style="font-weight: 600;">StaySmart</span> </h1>
                    <div class="card rounded-4 p-4">
                        @if(isset($booking))
                            <div class="apartment-author-area pdright">
                                <div class="img1 mb-4" style="height: 300px; overflow: hidden; border-radius: 16px;">
                                    <img src="{{ asset('storage/' . $property->image_path) }}" alt=""
                                        style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <h2 class="mb-2">{{$property->name}}</h2>
                                <p class="mb-4 ps-0 text-dark">
                                    <i class="fa-solid fa-location-dot text-dark me-1"></i>
                                    {{$property->address}}, {{$property->city}}, {{$property->country}}
                                </p>

                                <div class="apartment-contactbox">
                                    <div class="row justify-content-center mt-4">
                                        <div class="col-12">
                                            <table class="table">
                                                <tr>
                                                    <th>Booking Status</th>
                                                    <td>
                                                        @php
                                                            $badgeClass = 'bg-dark';
                                                            if ($booking->status == 'Cancelled') {
                                                                $badgeClass = 'bg-danger';
                                                            } elseif (!empty($isCheckedOut) || $booking->status == 'Completed') {
                                                                $badgeClass = 'bg-dark';
                                                            } elseif ($booking->status == 'Scheduled') {
                                                                $badgeClass = 'bg-brown';
                                                            } elseif ($booking->status == 'Confirmed' || !empty($isCheckedIn)) {
                                                                $badgeClass = 'bg-success';
                                                            } elseif ($booking->status == 'Pending') {
                                                                $badgeClass = 'bg-warning';
                                                            }
                                                        @endphp
                                                        <span class="badge {{ $badgeClass }}">{{ $booking->status }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Booking Name</th>
                                                    <td>{{ ($booking->user->first_name ?? 'Guest') . ' ' . ($booking->user->last_name ?? '') }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Email</th>
                                                    <td>{{$booking->user->email}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Phone</th>
                                                    <td>{{$booking->user->phone_number}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Check-In</th>
                                                    <td>{{$booking->check_in_date}} @if($booking->check_in_time) ({{ \Carbon\Carbon::parse($booking->check_in_time)->format('h:i A') }}) @endif</td>
                                                </tr>
                                                <tr>
                                                    <th>Check-Out</th>
                                                    <td>{{$booking->check_out_date}} @if($booking->check_out_time) ({{ \Carbon\Carbon::parse($booking->check_out_time)->format('h:i A') }}) @endif</td>
                                                </tr>
                                                <tr>
                                                    <th>Total Price</th>
                                                    <td>₦ {{ $booking->total_price }}</td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div class="col-12 mt-4 text-center">
                                            @if(!empty($isCheckedIn))
                                                <button onclick="handleCheckOut('{{$booking->id}}')"
                                                    class="btn btn-primary rounded-3 px-4 checkOut">Check Out <i
                                                        class="fa-solid fa-sign-out ms-2"></i></button>
                                            @elseif(!empty($isCheckedOut))
                                                {{-- booking already checked out; no actions --}}
                                            @elseif($booking->status === "Confirmed")
                                                <button onclick="handleCheckIn('{{$booking->id}}')"
                                                    class="btn btn-primary rounded-3 px-4 checkIn">Check In <i
                                                        class="fa-solid fa-sign-in ms-2"></i></button>
                                            @endif
                                            <a href="{{ route('properties.checkIn') }}"
                                                class="btn btn-outline-secondary rounded-3 px-4 ms-2">Back to Search</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <h6 class="text-center">Enter your booking information</h6>
                            <form action="{{ route('properties.checkIn') }}" method="GET">
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <div class="input-area">
                                            <label class="d-lg-none mt-3" for="last_name">Last Name</label>
                                            <input type="text" name="last_name" placeholder="Last Name" class="form-control"
                                                value="{{ auth()->check() ? auth()->user()->last_name : '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-area">
                                            <label class="d-lg-none mt-3" for="booking_reference">Booking Reference</label>
                                            <input type="text" name="booking_reference" placeholder="Booking Reference"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary rounded-3 px-3">Access Booking</button>
                                </div>
                                <h6 class="text-center mt-4" style="font-size:13px">Our Smart homes are operated fully digital.
                                    Click <a href="/">here</a> to learn more.</h6>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
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
                            data: {
                                booking_id: booking_id,
                                last_name: "{{ $user->last_name ?? '' }}"
                            },
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
                        data: {
                            booking_id: booking_id,
                            last_name: "{{ $user->last_name ?? '' }}"
                        },
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
    </script>
@endpush