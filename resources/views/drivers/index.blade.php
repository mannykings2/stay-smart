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
                                                <th class="d-none d-md-table-cell">Image</th>
                                                <th>Full Name</th>
                                                <th class="d-none d-md-table-cell">Phone Number</th>
                                                <th>Vehicle Details</th>
                                                <th class="d-none d-md-table-cell">License Number</th>
                                                <th class="d-none d-md-table-cell">Services</th>
                                                <th class="d-none d-md-table-cell">Rates (₦)</th>
                                                <th class="d-none d-md-table-cell">Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($drivers as $index => $driver)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td class="d-none d-md-table-cell">
                                                        @if($driver->image)
                                                            <img src="{{ asset($driver->image) }}" width="40" height="40"
                                                                class="rounded-circle shadow-sm" />
                                                        @else
                                                            <span class="text-muted">No Image</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $driver->first_name }} {{ $driver->last_name }}</td>
                                                    <td class="d-none d-md-table-cell">{{ $driver->phone_number }}</td>
                                                    <td>{{ $driver->vehicle_details }}</td>
                                                    <td class="d-none d-md-table-cell">{{ $driver->license_number }}</td>
                                                    <td class="d-none d-md-table-cell">
                                                        @foreach($driver->driverServices as $service)
                                                            <span class="badge bg-secondary">{{ $service->name }}</span><br>
                                                        @endforeach
                                                        @if($driver->driverServices->isEmpty()) N/A @endif
                                                    </td>
                                                    <td class="d-none d-md-table-cell">
                                                        <small>Hourly: ₦{{ number_format($driver->hourly_rate) }}</small><br>
                                                        <small>Extra: ₦{{ number_format($driver->extra_person_charge) }}</small>
                                                    </td>
                                                    <td class="d-none d-md-table-cell">
                                                        <span
                                                            class="badge bg-{{ $driver->availability_status == 'Available' ? 'success' : 'warning' }}">
                                                            {{ $driver->availability_status }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group btn-sm">
                                                            <a href="{{ route('drivers.edit', $driver->id) }}"
                                                                class="btn btn-warning btn-sm">
                                                                <i class="bi bi-pencil ms-0"></i>
                                                            </a>
                                                            <button class="btn btn-primary btn-sm"
                                                                onclick="openAssignModal({{ $driver->id }})">
                                                                <i class="bi bi-link-45deg ms-0"></i>
                                                            </button>
                                                            @if($driver->availability_status == 'Busy')
                                                                <button class="btn btn-success btn-sm"
                                                                    onclick="markAsAvailable({{ $driver->id }})">
                                                                    <i class="bi bi-check-circle ms-0"></i>
                                                                </button>
                                                            @endif
                                                            <button class="btn btn-danger btn-sm"
                                                                onclick="deleteDriver({{ $driver->id }})">
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
            Swal.fire({
                title: 'Mark as Available?',
                text: 'Are you sure you want to mark this driver as available?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, mark available',
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary px-4 me-2',
                    cancelButton: 'btn btn-danger px-4',
                    popup: 'rounded-4 border-0 shadow'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/drivers/${driverId}/mark-available`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({})
                    }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Driver marked as available!',
                                    timer: 1500,
                                    showConfirmButton: false,
                                    customClass: {
                                        popup: 'rounded-4 border-0 shadow'
                                    }
                                }).then(() => location.reload());
                            } else {
                                Swal.fire('Error', 'Something went wrong.', 'error');
                            }
                        });
                }
            });
        }

        function deleteDriver(driverId) {
            Swal.fire({
                title: 'Delete Driver?',
                text: 'Are you sure you want to delete this driver? This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary px-4 me-2',
                    cancelButton: 'btn btn-danger px-4',
                    popup: 'rounded-4 border-0 shadow'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/drivers/${driverId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'Driver deleted successfully!',
                                    timer: 1500,
                                    showConfirmButton: false,
                                    customClass: {
                                        popup: 'rounded-4 border-0 shadow'
                                    }
                                }).then(() => location.reload());
                            } else {
                                Swal.fire('Error', 'Failed to delete driver.', 'error');
                            }
                        });
                }
            });
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
                        Swal.fire({
                            icon: 'success',
                            title: 'Assigned!',
                            text: 'Service assigned successfully!',
                            timer: 1500,
                            showConfirmButton: false,
                            customClass: {
                                popup: 'rounded-4 border-0 shadow'
                            }
                        }).then(() => location.reload());
                    } else {
                        Swal.fire('Error', 'Failed to assign service.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'An unexpected error occurred.', 'error');
                });
        });

    </script>
@endpush