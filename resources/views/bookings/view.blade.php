@extends('layouts.app', [$activePage = 'My Bookings'])

@section('content')
    <!--start content-->
    <main class="page-content">

        <div class="container p-0">
            <div class="row">
                <div class="col-md-12 p-md-4">
                    <div class="property-banner">
                        @if($type === 'property')
                            <img class="property-banner-image" src="{{ asset('storage/' . $booking->property?->image_path) }}">
                        @elseif($type === 'chef')
                            <img class="property-banner-image"
                                src="{{ asset($booking->chef?->image ?? 'assets/images/placeholder.jpg') }}">
                        @elseif($type === 'driver')
                            <img class="property-banner-image"
                                src="{{ asset($booking->driver?->image ?? 'assets/images/placeholder.jpg') }}">
                        @endif
                        <div class="property-banner-content">
                            <div class="text-center">
                                @if($type === 'property')
                                    <h1>{{$booking->property?->name}}</h1>
                                    <small class="">{{$booking->property?->address}}, {{$booking->property?->city}},
                                        {{ $booking->property?->country }}</small>
                                @elseif($type === 'chef')
                                    <h1>Chef {{ $booking->chef?->first_name }} {{ $booking->chef?->last_name }}</h1>
                                    <small>{{ $booking->chefServiceType?->chefService?->name ?? 'Chef Service' }}</small>
                                @elseif($type === 'driver')
                                    <h1>Driver {{ $booking->driver?->first_name }} {{ $booking->driver?->last_name }}</h1>
                                    <small>{{ $booking->driverServiceType?->driverService?->name ?? 'Driver Service' }}</small>
                                @endif
                            </div>
                            <div class="property-badge" style="font-size: 14px">
                                @if($type === 'property')
                                    <span
                                        class="booked {{$booking->property->status == 'Booked' ? 'bg-danger' : ($booking->property->status == 'Available' ? 'bg-success' : '')}}">{{$booking->property->status}}</span>
                                    <span class="price bg-success">₦ {{$booking->property->price_per_night}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($type === 'property')
                        <div class="amenities gap-2 px-md-5" style="flex-wrap: wrap">
                            <span class="item">{{$booking->property->max_guests}} Max Guests</span>
                            @foreach($booking->property->amenities as $amenity)
                                <span class="item">{{$amenity->name}}</span>
                            @endforeach
                        </div>
                    @endif
                    <div class="row justify-content-center mt-4">
                        <div class="col-md-5">
                            <table class="table">
                                <tr>
                                    <th>Booking Status</th>
                                    <td>
                                        @php
                                            $statusClass = 'bg-dark';
                                            if ($booking->status == 'Cancelled')
                                                $statusClass = 'bg-danger';
                                            elseif ($booking->status == 'Confirmed')
                                                $statusClass = 'bg-success';
                                            elseif ($booking->status == 'Pending')
                                                $statusClass = 'bg-warning';
                                            elseif ($booking->status == 'Scheduled')
                                                $statusClass = 'bg-info';

                                            $displayStatus = $booking->status;
                                            if ($type === 'property' && $booking->status == 'Confirmed' && $booking->isCheckedIn()) {
                                                $displayStatus = 'Checked In';
                                                $statusClass = 'bg-info text-white';
                                            }
                                        @endphp
                                        <span class="badge {{ $statusClass }}">{{ ucfirst($displayStatus) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Booking Reference</th>
                                    <td class="text-primary fw-bold">{{$booking->reference}}</td>
                                </tr>
                                <tr>
                                    <th>Booking Name</th>
                                    <td>{{ (optional($booking->user)->first_name ?? 'Guest') . ' ' . (optional($booking->user)->last_name ?? '') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ optional($booking->user)->email }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ optional($booking->user)->phone_number }}</td>
                                </tr>

                                @if($type === 'property')
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
                                @elseif($type === 'chef')
                                    <tr>
                                        <th>Service Date</th>
                                        <td>{{$booking->service_date}} @ {{$booking->service_time}}</td>
                                    </tr>
                                    <tr>
                                        <th>Guests</th>
                                        <td>{{$booking->number_of_guests}}</td>
                                    </tr>
                                @elseif($type === 'driver')
                                    <tr>
                                        <th>Ride Date</th>
                                        <td>{{$booking->ride_date}} @ {{$booking->ride_time}}</td>
                                    </tr>
                                    <tr>
                                        <th>Pickup</th>
                                        <td>{{$booking->pickup_location}}</td>
                                    </tr>
                                    <tr>
                                        <th>Drop-off</th>
                                        <td>{{$booking->dropoff_location}}</td>
                                    </tr>
                                    <tr>
                                        <th>Duration</th>
                                        <td>{{ ($booking->ride_duration_mins ?? 60) / 60 }} hr(s)</td>
                                    </tr>
                                @endif

                                <tr>
                                    <th>Total Price</th>
                                    <td>₦ {{ number_format($booking->price ?: ($booking->total_price ?: 0)) }}</td>
                                </tr>
                                @if($type === 'property' && $booking->payment)
                                    <tr>
                                        <th>Transaction Ref</th>
                                        <td class="small text-muted">{{ $booking->payment->trx_ref }}</td>
                                    </tr>
                                @endif
                            </table>

                            @php
                                $isConfirmed = $booking->status == 'Confirmed';
                                $hasPayment = $booking->payment && $booking->payment->status == 'Completed';
                            @endphp

                            @if($isConfirmed && $hasPayment)
                                <div class="mt-3 d-flex flex-column gap-2" id="receipt-actions">
                                    <div class="d-flex gap-2">
                                        <button
                                            class="btn btn-outline-dark w-100 rounded-pill py-2 d-flex align-items-center justify-content-center gap-2"
                                            id="downloadPngBtn">
                                            <i class="fas fa-image"></i> Download PNG
                                        </button>
                                        <a href="{{ route('payment.receipt', $booking->payment->trx_ref ?? '') }}"
                                            class="btn btn-dark w-100 rounded-pill py-2 d-flex align-items-center justify-content-center gap-2">
                                            <i class="fas fa-file-pdf"></i> Download PDF
                                        </a>
                                    </div>
                                    <small class="text-muted text-center" style="font-size: 0.75rem;">Download your receipt for
                                        your records.</small>
                                </div>
                            @endif
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


                    @if($booking->status === 'Pending' && !($booking->payment && $booking->payment->status === 'Completed') && $type === 'property')
                        <div class="desc px-md-5 mt-4">
                            <h4 class="text-center">Complete payment now to secure your stay.</h4>
                            <p class="text-center text-muted small">Availability is on a first-come, first-served basis.</p>
                        </div>

                        <form class="px-md-5 pt-1" action="{{route('pay_now')}}" method="POST" id="paymentForm">
                            @csrf
                            <input type="hidden" name="booking_id" value="{{$booking->id}}">
                            <input type="hidden" name="booking_type" value="{{ $type }}">
                            <input type="hidden" name="reference" value="{{$booking->reference}}">
                            <input type="hidden" name="redirect_to" value="backend">

                            <div class="d-flex flex-column align-items-center gap-3 mt-3">
                                <button type="submit" class="btn btn-dark w-100 rounded-pill py-3 fw-bold">
                                    Make Payment
                                </button>

                                <a href="javascript:void(0)" id="cancelBookingLink"
                                    class="text-muted small text-decoration-underline">
                                    <i class="fas fa-times me-1"></i> Cancel booking
                                </a>
                            </div>
                        </form>
                    @elseif($booking->status !== 'Cancelled' && $booking->status !== 'Completed')
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-5 text-center">
                                <a href="javascript:void(0)" id="cancelBookingLink"
                                    class="text-danger small text-decoration-underline">
                                    <i class="fas fa-times me-1"></i> Cancel this {{ $type }} booking
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- Hidden Receipt Area for PNG Generation --}}
        @if($type === 'property' && $booking->payment)
            <div id="hiddenReceiptWrapper" style="position: absolute; left: -9999px; top: -9999px;">
                <div id="receiptCaptureArea" class="receipt-container" style="width: 680px; background: white;">
                    @include('partials.receipt_styles')
                    @php $payment = $booking->payment; @endphp
                    @include('partials.receipt_markup')
                </div>
            </div>
        @endif




    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        // Manual Cancellation
        document.getElementById('cancelBookingLink')?.addEventListener('click', function (e) {
            e.preventDefault();
            const type = "{{ $type }}";
            Swal.fire({
                title: "Cancel " + (type.charAt(0).toUpperCase() + type.slice(1)) + " Reservation?",
                text: "Are you sure you want to release this booking?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, cancel it",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary px-4 me-2',
                    cancelButton: 'btn btn-danger px-4',
                    popup: 'rounded-4 border-0 shadow'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('booking_id', "{{ $booking->id }}");
                    formData.append('booking_type', type);

                    fetch("{{ route('cancel_booking') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(res => res.json()).then(res => {
                        if (res.status === 'success') {
                            Swal.fire("Cancelled", "Reservation released.", "success").then(() => {
                                @if($type === 'property')
                                    window.location.href = "{{ route('properties') }}";
                                @else
                                    window.location.href = "{{ route('booking.mine') }}";
                                @endif
                                            });
                        } else {
                            Swal.fire("Error", res.message, "error");
                        }
                    });
                }
            });
        });

        document.getElementById('downloadPngBtn')?.addEventListener('click', function () {
            const btn = this;
            const originalHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating...';

            const receiptElement = document.getElementById('receiptCaptureArea');
            if (!receiptElement) {
                alert('Receipt data not found');
                btn.disabled = false;
                btn.innerHTML = originalHtml;
                return;
            }

            html2canvas(receiptElement, {
                scale: 2,
                useCORS: true,
                backgroundColor: '#ffffff'
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = 'StaySmart-Receipt-{{ $booking->reference }}.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            }).catch(err => {
                console.error('PNG Generation Error:', err);
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            });
        });
    </script>
@endsection