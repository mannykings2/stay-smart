@extends('layouts.app', [$activePage = 'My Bookings'])

@section('content')
    <!--start content-->
    <main class="page-content">

        <div class="container p-0">
            <div class="row">
                <div class="col-md-12 p-md-4">
                    <div class="property-banner">
                        <img class="property-banner-image" src="{{ asset('storage/' . $booking->property->image_path) }}">
                        <div class="property-banner-content">
                            <div class="text-center">
                                <h1>{{$booking->property->name}}</h1>
                                <small class="">{{$booking->property->address}}, {{$booking->property->city}},
                                    {{ $booking->property->country }}</small>
                            </div>
                            <div class="property-badge" style="font-size: 14px">
                                <span
                                    class="booked {{$booking->property->status == 'Booked' ? 'bg-danger' : ($booking->property->status == 'Available' ? 'bg-success' : '')}}">{{$booking->property->status}}</span>
                                <span class="price bg-success">₦ {{$booking->property->price_per_night}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="amenities gap-2 px-md-5" style="flex-wrap: wrap">
                        <span class="item">{{$booking->property->max_guests}} Max Guests</span>
                        @foreach($booking->property->amenities as $amenity)
                            <span class="item">{{$amenity->name}}</span>
                        @endforeach
                    </div>
                    <div class="row justify-content-center mt-4">
                        <div class="col-md-5">
                            <table class="table">
                                <tr>
                                    <th>Booking Status</th>
                                    <td>
                                        <span
                                            class="badge {{$booking->status == 'Cancelled' ? 'bg-danger' : ($booking->status == 'Confirmed' ? ($booking->isCheckedIn() ? 'bg-info text-white' : 'bg-success') : ($booking->status == 'Pending' ? 'bg-warning' : ($booking->status == 'Completed' ? 'bg-dark' : 'bg-dark')))}}">{{ $booking->status == 'Confirmed' && $booking->isCheckedIn() ? 'Checked In' : $booking->status}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Booking Reference</th>
                                    <td class="text-primary fw-bold">{{$booking->reference}}</td>
                                </tr>
                                <tr>
                                    <th>Booking Name</th>
                                    <td>{{ ($booking->user->first_name ?? 'Guest') . ' ' . ($booking->user->last_name ?? '') }}
                                    </td>
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
                                    <td>{{$booking->check_in_date}} @if($booking->check_in_time)
                                    ({{ \Carbon\Carbon::parse($booking->check_in_time)->format('h:i A') }}) @endif</td>
                                </tr>
                                <tr>
                                    <th>Check-Out</th>
                                    <td>{{$booking->check_out_date}} @if($booking->check_out_time)
                                    ({{ \Carbon\Carbon::parse($booking->check_out_time)->format('h:i A') }}) @endif</td>
                                </tr>
                                <tr>
                                    <th>Total Price</th>
                                    <td>₦ {{ $booking->total_price }}</td>
                                </tr>
                                @if($booking->payment)
                                    <tr>
                                        <th>Transaction Ref</th>
                                        <td class="small text-muted">{{ $booking->payment->trx_ref }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    @if(auth()->check() && auth()->user()->id == $booking->user_id && auth()->user()->is_guest)
                        <div class="row justify-content-center mt-2">
                            <div class="col-md-5">
                                <div class="card border-0 shadow-sm p-4 text-center bg-light rounded-4">
                                    <h5 class="mb-3">Secure Your Account</h5>
                                    <p class="text-muted small">You are currently booking as a guest. Set a password to easily
                                        track and manage your bookings in the future.</p>
                                    <form action="{{ route('guest.set-password') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <input type="password" name="password" class="form-control radius-30"
                                                placeholder="New Password" required minlength="8">
                                        </div>
                                        <div class="mb-3">
                                            <input type="password" name="password_confirmation" class="form-control radius-30"
                                                placeholder="Confirm Password" required minlength="8">
                                        </div>
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-dark radius-30 px-4">Save Password & Secure
                                                Account</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif


                    @if($booking->status !== 'Confirmed' && $booking->status !== 'Cancelled' && (!isset($booking->payment) || $booking->payment->status !== 'Completed'))
                        <div class="desc px-5 mt-4">
                            <h4 class="text-center">Pay <b>securely</b> now to confirm your booking</h4>
                        </div>
                        <form class="px-5 pt-1" action="{{route('pay_now')}}" method="POST">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="booking_id" value="{{$booking->id}}">
                                <input type="hidden" name="reference" value="{{$booking->reference}}">
                                <input type="hidden" name="redirect_to" value="backend">
                                <div class="col-12 mt-4 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary rounded-4 px-4">Confirm Booking</button>
                                </div>
                            </div>
                        </form>
                    @endif

                </div>
            </div>
        </div>




    </main>
@endsection