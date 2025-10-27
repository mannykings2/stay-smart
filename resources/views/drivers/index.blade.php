@extends('layouts.app', ['activePage' => 'All Drivers'])

@section('content')
<main class="page-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-5">
                <h2 class="text-center mb-4">Driver Listings</h2>
                <div class="card rounded-4">
                    <div class="card-body">
                        @if(count($drivers) > 0)
                            <div class="table-responsive">
                                <table id="driversTable" class="mDatatable table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Full Name</th>
                                            <th>Specialty</th>
                                            <th>Phone Number</th>
                                            <th>Vehicle Details</th>
                                            <th>License Number</th>
                                            <th>Service</th>
                                            <th>Price (₦)</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($drivers as $index => $driver)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                @if($driver->image)
                                                    <img src="{{ asset($driver->image) }}" width="40" height="40" class="rounded-circle shadow-sm" />
                                                @else
                                                    <span class="text-muted">No Image</span>
                                                @endif
                                            </td>
                                            <td>{{ $driver->first_name }} {{ $driver->last_name }}</td>
                                            <td>{{ $driver->specialty ?? 'N/A' }}</td>
                                            <td>{{ $driver->phone_number }}</td>
                                            <td>{{ $driver->vehicle_details }}</td>
                                            <td>{{ $driver->license_number }}</td>
                                            <td>{{ optional($driver->driverServices->first())->name ?? 'N/A' }}</td>
                                            <td>{{ count($driver->driverServices) > 0 ? number_format(optional($driver->driverServices->first())->pivot->price) : '-' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $driver->availability_status == 'Available' ? 'success' : 'warning' }}">
                                                    {{ $driver->availability_status }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-sm">
                                                    <button class="btn btn-primary btn-sm" onclick="openAssignModal({{ $driver->id }})">
                                                        <i class="bi bi-link-45deg ms-0"></i>
                                                    </button>
                                                    @if($driver->availability_status == 'Busy')
                                                        <button class="btn btn-success btn-sm" onclick="markAsAvailable({{ $driver->id }})">
                                                            <i class="bi bi-check-circle ms-0"></i>
                                                        </button>
                                                    @endif
                                                    <button class="btn btn-danger btn-sm" onclick="deleteDriver({{ $driver->id }})">
                                                        <i class="bi bi-trash ms-0"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-center mb-0 p-3">There are no drivers available</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('modals.assign-driver-service')
</main>
@endsection

@push('js')
<script>
    function markAsAvailable(driverId) {
        if(confirm("Are you sure you want to mark this driver as available?")) {
            fetch(`/drivers/${driverId}/mark-available`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            }).then(response => response.json())
            .then(data => {
                if(data.success) {
                    showSuccessMessage("Driver marked as available!");
                    setTimeout(() => location.reload(), 1500);
                } else {
                    alert("Something went wrong.");
                }
            });
        }
    }

    function deleteDriver(driverId) {
        if(confirm("Are you sure you want to delete this driver?")) {
            fetch(`/drivers/${driverId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json())
            .then(data => {
                if(data.success) {
                    showSuccessMessage("Driver deleted successfully!");
                    setTimeout(() => location.reload(), 1500);
                } else {
                    alert("Failed to delete driver.");
                }
            });
        }
    }

    function openAssignModal(driverId) {
        document.getElementById('assign_driver_id').value = driverId;
        document.getElementById('assignServiceForm').reset();
        new bootstrap.Modal(document.getElementById('assignServiceModal')).show();
    }

    document.getElementById('assignServiceForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('{{ route('driver.service.assign') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            $('#assignServiceModal').modal('hide');
            if (data.success) {
                showSuccessMessage("Service assigned successfully!");
                setTimeout(() => location.reload(), 1500);
            } else {
                alert('Failed to assign service.');
            }
        })
        .catch(error => console.error('Error:', error));
    });

</script>
@endpush

