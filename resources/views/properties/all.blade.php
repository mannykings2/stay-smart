@extends('layouts.app', [$activePage = 'All Apartments'])

@section('content')
    <main class="page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 mt-5">
                    <h2 class="text-center mb-4">Apartment Listings</h2>
                    <div class="card rounded-4">
                        <div class="card-body">
                            @if(count($properties) > 0)
                                <div class="table-responsive">
                                    <table id="propertiesTable" class="mDatatable table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Apartment Name</th>
                                                <th>Location</th>
                                                @unless(auth()->user()->hasRole('Cleaner'))
                                                <th>Price</th>
                                                @endunless
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($properties as $index => $property)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $property->name }}</td>
                                                    <td>{{ $property->full_location }}</td>
                                                    @unless(auth()->user()->hasRole('Cleaner'))
                                                    <td>₦{{ number_format($property->price_per_night, 2) }}</td>
                                                    @endunless
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $property->status == 'Available' ? 'success' : ($property->status == 'Pending' ? 'warning' : ($property->status == 'Booked' ? 'danger' : ($property->status == 'Under Maintenance' ? 'secondary' : 'dark'))) }}">
                                                            {{ ucfirst($property->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="{{ auth()->user()->hasRole('Cleaner') ? '' : 'btn-group' }}">

                                                            @php
                                                                $showGreenTick = false;
                                                                if(auth()->user()->hasRole('Cleaner')) {
                                                                    if($property->status == 'Under Maintenance') $showGreenTick = true;
                                                                } else {
                                                                    if($property->status == 'Pending' || $property->status == 'Under Maintenance') $showGreenTick = true;
                                                                }
                                                            @endphp

                                                            @if($showGreenTick)
                                                                <button class="btn btn-success btn-sm {{ auth()->user()->hasRole('Cleaner') ? 'w-100' : '' }}"
                                                                    onclick="markAsAvailable('{{ $property->id }}')">
                                                                    <i class="bi bi-check-circle ms-0"></i>
                                                                </button>
                                                            @endif
                                                            @unless(auth()->user()->hasRole('Cleaner'))
                                                                <a href="{{ route('properties.edit', $property->id) }}" class="btn btn-warning btn-sm text-white">
                                                                    <i class="bi bi-pencil-square ms-0"></i>
                                                                </a>
                                                                <button class="btn btn-primary btn-sm"
                                                                    onclick="openAssignModal('{{ $property->id }}')">
                                                                    <i class="bi bi-link-45deg ms-0"></i>
                                                                </button>
                                                            @endunless

                                                            @if(auth()->user()->hasRole('Super Admin'))
                                                                <button class="btn btn-danger btn-sm"
                                                                    onclick="deleteProperty('{{ $property->id }}')">
                                                                    <i class="bi bi-trash ms-0"></i>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-center mb-0 p-3">There are no apartments available</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('modals.assign-amenity')

@endsection


@push('js')
    <script>
        function markAsAvailable(propertyId) {
            Swal.fire({
                title: 'Confirm Availability',
                text: 'Are you sure you want to mark this apartment as available?',
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
                    fetch(`/admin/properties/${propertyId}/mark-available`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({})
                    }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                Swal.fire('Error', 'Something went wrong.', 'error');
                            }
                        });
                }
            });
        }


        function deleteProperty(propertyId) {
            Swal.fire({
                title: 'Delete Apartment?',
                text: 'Are you sure you want to delete this apartment? This action cannot be undone.',
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
                    fetch(`/properties/${propertyId}`, {
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
                                    text: 'Apartment deleted successfully!',
                                    timer: 1500,
                                    showConfirmButton: false,
                                    customClass: {
                                        popup: 'rounded-4 border-0 shadow'
                                    }
                                }).then(() => location.reload());
                            } else {
                                Swal.fire('Error', 'Failed to delete apartment.', 'error');
                            }
                        });
                }
            });
        }

        function openAssignModal(propertyId) {
            document.getElementById('assign_property_id').value = propertyId;
            document.getElementById('assignAmenityForm').reset();
            new bootstrap.Modal(document.getElementById('assignAmenityModal')).show();
        }

        document.getElementById('assignAmenityForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('{{ route('property.amenity.assign') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    $('#assignAmenityModal').modal('hide');
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Assigned!',
                            text: 'Amenity assigned successfully!',
                            timer: 1500,
                            showConfirmButton: false,
                            customClass: {
                                popup: 'rounded-4 border-0 shadow'
                            }
                        }).then(() => location.reload());
                    } else {
                        Swal.fire('Error', 'Failed to assign amenity.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'An unexpected error occurred.', 'error');
                });
        });
    </script>
@endpush