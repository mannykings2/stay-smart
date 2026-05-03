@extends('layouts.app', ['activePage' => 'Drivers'])

@section('content')
    <main class="page-content">
        <div class="container">
            <div class="row">
                @foreach($drivers as $driver)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow rounded-4">
                            <img src="{{ asset($driver->image) }}" class="card-img-top" alt="Driver Image"
                                style="height: 350px; object-fit:cover;">
                            <div class="card-body text-center">
                                <h5>{{ $driver->first_name }} {{ $driver->last_name }}</h5>
                                <p>{{ $driver->specialty }}</p>
                                <p class="text-muted">{{ $driver->vehicle_details }}</p>
                                <button class="btn btn-primary rounded-3 px-4" onclick="openBookingModal({{ $driver->id }})">
                                    Book
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
            let currentServices = [];
            let driverRates = { hourly: 0, extra: 0 };

            function openBookingModal(driverId) {
                fetch(`/drivers/${driverId}/services`)
                    .then(response => response.json())
                    .then(data => {
                        currentServices = data.services;
                        driverRates.hourly = parseFloat(data.hourly_rate || 0);
                        driverRates.extra = parseFloat(data.extra_person_charge || 0);

                        const serviceSelect = document.getElementById('driver_services');
                        serviceSelect.innerHTML = '<option value="">-- Select Service --</option>';

                        if (Array.isArray(currentServices) && currentServices.length > 0) {
                            currentServices.forEach(service => {
                                let option = document.createElement('option');
                                option.value = service.pivot.id;
                                option.textContent = `${service.name}`;
                                serviceSelect.appendChild(option);
                            });
                        } else {
                            let option = document.createElement('option');
                            option.disabled = true;
                            option.textContent = 'No services available';
                            serviceSelect.appendChild(option);
                        }

                        $('#driver_id').val(driverId);
                        $('#driver_price_alert').hide();
                        $('#bookingModal').modal('show');
                    });
            }

            function calculateDriverPrice() {
                const hours = parseInt($('#ride_duration_hours').val() || 0);
                const occupants = parseInt($('#occupants').val() || 0);

                if (hours > 0 && occupants > 0) {
                    const baseTotal = driverRates.hourly * hours;
                    const extraTotal = occupants > 1 ? (occupants - 1) * driverRates.extra : 0;
                    const grandTotal = baseTotal + extraTotal;

                    $('#driver_price_display').text('₦' + grandTotal.toLocaleString());
                    $('#driver_price_alert').show();
                } else {
                    $('#driver_price_alert').hide();
                }
            }

            $(document).on('change input', '#driver_services, #ride_duration_hours, #occupants', calculateDriverPrice);

            document.getElementById('bookingForm').addEventListener('submit', function (e) {
                e.preventDefault();
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.disabled = true;
                submitBtn.textContent = 'Processing...';

                const formData = new FormData(this);

                fetch('/drivers/book', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            return response.text().then(text => { throw new Error(text) });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            if (window.Swal) {
                                Swal.fire('Success', data.message, 'success').then(() => location.reload());
                            } else {
                                alert(data.message);
                                location.reload();
                            }
                        } else {
                            if (window.Swal) {
                                Swal.fire('Error', data.message || 'Booking failed!', 'error');
                            } else {
                                alert(data.message || 'Booking failed!');
                            }
                            submitBtn.disabled = false;
                            submitBtn.textContent = originalText;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        let msg = 'An unexpected error occurred.';
                        try {
                            const json = JSON.parse(error.message);
                            msg = json.message || msg;
                        } catch (e) { }

                        if (window.Swal) {
                            Swal.fire('Error', msg, 'error');
                        } else {
                            alert(msg);
                        }
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    });
            });
        </script>
    @endpush
@endsection