@extends('layouts.app', ['activePage' => 'Drivers'])

@section('content')
<main class="page-content">
    <div class="container">
        <div class="row">
            @foreach($drivers as $driver)
                <div class="col-md-4 mb-4">
                    <div class="card shadow rounded-4">
                        <img src="{{ asset($driver->image) }}" class="card-img-top" alt="Driver Image" style="height: 350px; object-fit:cover;">
                        <div class="card-body text-center">
                            <h5>{{ $driver->first_name }} {{ $driver->last_name }}</h5>
                            <p>{{ $driver->specialty }}</p>
                            <p class="text-muted">{{ $driver->vehicle_details }}</p>
                            <button class="btn btn-primary rounded-3 px-4" onclick="openBookingModal({{ $driver->id }})">
                              Select Services
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</main>
@include('modals.book-driver')

@push('js')
<script>
    function openBookingModal(driverId) {
        fetch(`/drivers/${driverId}/services`)
            .then(response => response.json())
            .then(data => {
                const serviceSelect = document.getElementById('driver_services');
                serviceSelect.innerHTML = '';

                if (Array.isArray(data) && data.length > 0) {
                    console.log(data);
                    data.forEach(service => {
                        let option = document.createElement('option');
                        option.value = service.pivot.id;
                        option.textContent = `${service.name} - ₦${service.pivot.price}`;
                        serviceSelect.appendChild(option);
                    });
                } else {
                    let option = document.createElement('option');
                    option.disabled = true;
                    option.textContent = 'No services available for this driver';
                    serviceSelect.appendChild(option);
                }

                $('#driver_id').val(driverId);
                $('#bookingModal').modal('show');
            })
            .catch(error => {
                console.error('Error fetching services:', error);
                alert('Something went wrong while fetching services.');
            });
    }


    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        console.log(':formData ', formData);

        fetch('/drivers/book', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Booking failed!');
            }
        });
    });
</script>
@endpush
@endsection

