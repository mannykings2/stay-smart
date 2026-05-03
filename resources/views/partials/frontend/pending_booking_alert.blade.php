@auth
    @php
        $pendingBooking = \App\Models\Booking::where('user_id', auth()->id())
            ->where('status', 'Pending')
            ->latest()
            ->first();
    @endphp

    @if($pendingBooking)
        <div class="alert alert-warning alert-dismissible fade show mb-0 text-center" role="alert"
            style="border-radius: 0; background-color: #875233; border: none; color: #fff; font-size: 14px; position: relative; z-index: 10001;">
            <div class="container d-flex justify-content-center align-items-center gap-2">
                <i class="fa-solid fa-credit-card"></i>
                <span>You have an incomplete booking for <strong>{{ $pendingBooking->property->name }}</strong>.</span>
                <a href="{{ route('booking.view', $pendingBooking->reference) }}"
                    class="btn btn-sm btn-light rounded-pill px-3 ms-2"
                    style="font-size: 12px; font-weight: 600; color: #875233;">Resume Payment</a>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"
                style="padding: 1rem;"></button>
        </div>
    @endif
@endauth