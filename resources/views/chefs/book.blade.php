@extends('layouts.app', ['activePage' => 'Chefs'])

@section('content')
<main class="page-content">
    <div class="container">
        <div class="row">
            @foreach($chefs as $chef)
                <div class="col-md-4 mb-4">
                    <div class="card shadow rounded-4">
                        <img src="{{ asset($chef->image) }}" class="card-img-top" alt="Chef Image" style="height: 350px; object-fit:cover;">
                        <div class="card-body text-center">
                            <h5>{{ $chef->first_name }} {{ $chef->last_name }}</h5>
                            <p>{{ $chef->specialty }}</p>
                            <button class="btn btn-primary rounded-3 px-4" onclick="openBookingModal({{ $chef->id }})">
                              Select Services
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
    function openBookingModal(chefId) {
        fetch(`/chefs/${chefId}/services`)
            .then(response => response.json())
            .then(data => {
                const serviceSelect = document.getElementById('chef_services');
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
                    option.textContent = 'No services available for this chef';
                    serviceSelect.appendChild(option);
                }

                $('#chef_id').val(chefId);
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

        fetch('/chefs/book', {
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
