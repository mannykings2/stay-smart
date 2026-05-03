@extends('layouts.app', ['activePage' => 'Chefs'])

@section('content')
    <main class="page-content">
        <div class="container">
            <div class="row">
                @foreach($chefs as $chef)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow rounded-4">
                            <img src="{{ asset($chef->image) }}" class="card-img-top" alt="Chef Image"
                                style="height: 350px; object-fit:cover;">
                            <div class="card-body text-center">
                                <h5>{{ $chef->first_name }} {{ $chef->last_name }}</h5>
                                <p>{{ $chef->specialty }}</p>
                                <button class="btn btn-primary rounded-3 px-4" onclick="openBookingModal({{ $chef->id }})">
                                    Book
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
    @include('modals.book-chef')

    @push('js')
        <script>
            let currentServices = [];
            let selectedChef = null;

            function openBookingModal(chefId) {
                // Fetch chef details for capacity hint if needed, or just use the data from the services loop
                fetch(`/chefs/${chefId}/services`)
                    .then(response => response.json())
                    .then(data => {
                        currentServices = data;
                        const serviceSelect = document.getElementById('chef_services');
                        serviceSelect.innerHTML = '<option value="">-- Select Service --</option>';

                        if (Array.isArray(data) && data.length > 0) {
                            data.forEach(service => {
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

                        $('#chef_id').val(chefId);
                        $('#chef_price_alert').hide();
                        $('#bookingModal').modal('show');
                    });
            }

            function calculateChefPrice() {
                const serviceId = $('#chef_services').val();
                const guests = parseInt($('#number_of_guests').val()) || 1;

                const service = currentServices.find(s => s.pivot.id == serviceId);
                if (service) {
                    const base = parseFloat(service.pivot.base_price || service.pivot.price || 0);
                    const perUnit = parseFloat(service.pivot.per_unit_price || 0);
                    const total = base + (guests * perUnit);

                    $('#chef_price_display').text('₦' + total.toLocaleString());
                    $('#chef_price_alert').show();
                } else {
                    $('#chef_price_alert').hide();
                }
            }

            $(document).on('change', '#chef_services, #number_of_guests', calculateChefPrice);

            document.getElementById('bookingForm').addEventListener('submit', function (e) {
                e.preventDefault();
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.disabled = true;
                submitBtn.textContent = 'Processing...';

                const formData = new FormData(this);

                fetch('/chefs/book', {
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