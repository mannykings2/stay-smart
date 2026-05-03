<div class="receipt-wrapper">
    <div class="header">
        <h1>Stay Smart Apartments</h1>
        <p>Official Payment Receipt</p>
    </div>

    <div class="paid-stamp">
        <span>PAID</span>
    </div>

    <div class="amount-box">
        <div class="label">Amount Paid</div>
        <div class="value">&#8358;{{ number_format($payment->amount, 2) }}</div>
    </div>

    <p class="section-title">Payment Details</p>
    <table class="detail-table">
        <tr>
            <td>Transaction Ref</td>
            <td>{{ $payment->trx_ref }}</td>
        </tr>
        <tr>
            <td>Payment Method</td>
            <td>{{ $payment->payment_method ?? 'Paystack' }}</td>
        </tr>
        <tr>
            <td>Payment Date</td>
            <td>{{ $payment->created_at->format('D, d M Y \a\t h:i A') }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td><strong style="color:#16a34a;">{{ $payment->status }}</strong></td>
        </tr>
    </table>

    @if($payment->booking)
        <p class="section-title">Booking Details</p>
        <table class="detail-table">
            <tr>
                <td>Booking Reference</td>
                <td><strong>{{ $payment->booking->reference }}</strong></td>
            </tr>
            <tr>
                <td>Guest Name</td>
                <td>{{ ($payment->booking->user->first_name ?? '') . ' ' . ($payment->booking->user->last_name ?? '') }}
                </td>
            </tr>
            @if($payment->booking->property)
                <tr>
                    <td>Property</td>
                    <td>{{ $payment->booking->property->name }}</td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td>{{ $payment->booking->property->address }}, {{ $payment->booking->property->city }}</td>
                </tr>
            @endif
            <tr>
                <td>Check-In</td>
                <td>{{ \Carbon\Carbon::parse($payment->booking->check_in_date)->format('D, d M Y') }}</td>
            </tr>
            <tr>
                <td>Check-Out</td>
                <td>{{ \Carbon\Carbon::parse($payment->booking->check_out_date)->format('D, d M Y') }}</td>
            </tr>
            <tr>
                <td>Guests</td>
                <td>{{ $payment->booking->number_of_guests ?? '1' }}</td>
            </tr>
        </table>

        @if($payment->booking && $payment->booking->chefBookings->count() > 0)
            <p class="section-title">Chef Services</p>
            <table class="detail-table">
                @foreach($payment->booking->chefBookings as $cb)
                    <tr>
                        <td>{{ $cb->chefServiceType->chefService->name ?? 'Chef Service' }}</td>
                        <td>
                            ₦{{ number_format($cb->booking_base_price ?: $cb->price) }}
                            @if($cb->booking_per_unit_price)
                                <br><small>+ {{ $cb->number_of_guests }} guests @
                                    ₦{{ number_format($cb->booking_per_unit_price) }}</small>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif

        @if($payment->booking && $payment->booking->rideBookings->count() > 0)
            <p class="section-title">Driver Services</p>
            <table class="detail-table">
                @foreach($payment->booking->rideBookings as $rb)
                    @php
                        $durationHrs = ($rb->ride_duration_mins ?? 60) / 60;
                    @endphp
                    <tr>
                        <td>{{ $rb->driverServiceType->driverService->name ?? 'Driver Service' }}</td>
                        <td>
                            &#8358;{{ number_format($rb->price) }}
                            <br><small>
                                {{ $durationHrs }} hr(s) @ &#8358;{{ number_format($rb->booking_base_price) }}/hr
                                @if($rb->booking_per_unit_price && $rb->occupants > 1)
                                    <br>+ {{ $rb->occupants - 1 }} extra person(s) @
                                    &#8358;{{ number_format($rb->booking_per_unit_price) }}
                                @endif
                            </small>
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif
    @endif

    {{-- Standalone Chef Booking (not tied to a property booking) --}}
    @if($payment->chefBooking && !$payment->booking)
        <p class="section-title">Chef Booking Details</p>
        <table class="detail-table">
            <tr>
                <td>Booking Reference</td>
                <td><strong>{{ $payment->chefBooking->reference }}</strong></td>
            </tr>
            <tr>
                <td>Chef</td>
                <td>{{ $payment->chefBooking->chef?->first_name }} {{ $payment->chefBooking->chef?->last_name }}</td>
            </tr>
            <tr>
                <td>Service</td>
                <td>{{ $payment->chefBooking->chefServiceType?->chefService?->name ?? 'Chef Service' }}</td>
            </tr>
            <tr>
                <td>Date & Time</td>
                <td>{{ $payment->chefBooking->service_date }} at {{ $payment->chefBooking->service_time }}</td>
            </tr>
            <tr>
                <td>Guests</td>
                <td>{{ $payment->chefBooking->number_of_guests ?? '1' }}</td>
            </tr>
        </table>
    @endif

    {{-- Standalone Driver Booking (not tied to a property booking) --}}
    @if($payment->rideBooking && !$payment->booking)
        <p class="section-title">Driver Booking Details</p>
        <table class="detail-table">
            <tr>
                <td>Booking Reference</td>
                <td><strong>{{ $payment->rideBooking->reference }}</strong></td>
            </tr>
            <tr>
                <td>Driver</td>
                <td>{{ $payment->rideBooking->driver?->first_name }} {{ $payment->rideBooking->driver?->last_name }}</td>
            </tr>
            <tr>
                <td>Service</td>
                <td>{{ $payment->rideBooking->driverServiceType?->driverService?->name ?? 'Driver Service' }}</td>
            </tr>
            <tr>
                <td>Date & Time</td>
                <td>{{ $payment->rideBooking->ride_date }} at {{ $payment->rideBooking->ride_time }}</td>
            </tr>
            @if($payment->rideBooking->occupants)
            <tr>
                <td>Passengers</td>
                <td>{{ $payment->rideBooking->occupants }}</td>
            </tr>
            @endif
        </table>
    @endif

    <div class="footer">
        Thank you for choosing <strong>Stay Smart Apartments</strong>.<br>
        For support, please contact us with your transaction reference.
    </div>
</div>