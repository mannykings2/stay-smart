(₦)@extends('layouts.app', [$activePage = 'All Chefs'])

@section('content')
    <main class="page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 mt-5">
                    <h2 class="text-center mb-4">Chef Listings</h2>
                    <div class="card rounded-4">
                        <div class="card-body">
                            @if(count($chefs) > 0)
                                <div class="table-responsive">
                                    <table id="chefsTable" class="mDatatable table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th class="d-none d-md-table-cell">Image</th>
                                                <th>Full Name</th>
                                                <th>Specialty</th>
                                                <th class="d-none d-md-table-cell">Phone Number</th>
                                                <th class="d-none d-md-table-cell">Service</th>
                                                <th class="d-none d-md-table-cell">Price (₦)</th>
                                                <th class="d-none d-md-table-cell">Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($chefs as $index => $chef)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td class="d-none d-md-table-cell">
                                                        @if($chef->image)
                                                            <img src="{{ asset($chef->image) }}" width="40" height="40"
                                                                class="rounded-circle shadow-sm" />
                                                        @else
                                                            <span class="text-muted">No Image</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $chef->first_name }} {{ $chef->last_name }}</td>
                                                    <td>{{ $chef->specialty ?? 'N/A' }}</td>
                                                    <td class="d-none d-md-table-cell">{{ $chef->phone_number }}</td>
                                                    <td class="d-none d-md-table-cell">
                                                        @foreach($chef->chefServices as $service)
                                                            <span class="badge bg-secondary">{{ $service->name }}</span><br>
                                                        @endforeach
                                                        @if($chef->chefServices->isEmpty()) N/A @endif
                                                    </td>
                                                    <td class="d-none d-md-table-cell">
                                                        @foreach($chef->chefServices as $service)
                                                            <small>base:
                                                                ₦{{ number_format($service->pivot->base_price ?: $service->pivot->price) }}</small><br>
                                                            @if($service->pivot->per_unit_price)
                                                                <small>unit:
                                                                    ₦{{ number_format($service->pivot->per_unit_price) }}</small><br>
                                                            @endif
                                                        @endforeach
                                                        @if($chef->chefServices->isEmpty()) - @endif
                                                    </td>
                                                    <td class="d-none d-md-table-cell">
                                                        <span
                                                            class="badge bg-{{ $chef->availability_status == 'Available' ? 'success' : 'warning' }}">
                                                            {{ $chef->availability_status }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group btn-sm">
                                                            <button class="btn btn-primary btn-sm"
                                                                onclick="openAssignModal({{ $chef->id }})">
                                                                <i class="bi bi-link-45deg ms-0"></i>
                                                            </button>
                                                            @if($chef->availability_status == 'Busy')
                                                                <button class="btn btn-success btn-sm"
                                                                    onclick="markAsAvailable({{ $chef->id }})">
                                                                    <i class="bi bi-check-circle ms-0"></i>
                                                                </button>
                                                            @endif
                                                            {{-- <a href="#" class="btn btn-dark btn-sm">
                                                                <i class="bi bi-eye ms-0"></i>
                                                            </a> --}}
                                                            <button class="btn btn-danger btn-sm"
                                                                onclick="deleteChef({{ $chef->id }})">
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
                                <p class="text-center mb-0 p-3">There are no chefs available</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('modals.assign-chef-service')
    </main>
@endsection

@push('js')
    <script>
        function markAsAvailable(chefId) {
            Swal.fire({
                title: 'Mark as Available?',
                text: 'Are you sure you want to mark this chef as available?',
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
                    fetch(`/chefs/${chefId}/mark-available`, {
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
                                    text: 'Chef marked as available!',
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

        function deleteChef(chefId) {
            Swal.fire({
                title: 'Delete Chef?',
                text: 'Are you sure you want to delete this chef? This action cannot be undone.',
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
                    fetch(`/chefs/${chefId}`, {
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
                                    text: 'Chef deleted successfully!',
                                    timer: 1500,
                                    showConfirmButton: false,
                                    customClass: {
                                        popup: 'rounded-4 border-0 shadow'
                                    }
                                }).then(() => location.reload());
                            } else {
                                Swal.fire('Error', 'Failed to delete chef.', 'error');
                            }
                        });
                }
            });
        }

        function openAssignModal(chefId) {
            document.getElementById('assign_chef_id').value = chefId;
            document.getElementById('assignServiceForm').reset();
            new bootstrap.Modal(document.getElementById('assignServiceModal')).show();
        }

        document.getElementById('assignServiceForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('{{ route('chef.service.assign') }}', {
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