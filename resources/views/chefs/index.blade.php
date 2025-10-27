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
                                            <th>Image</th>
                                            <th>Full Name</th>
                                            <th>Specialty</th>
                                            <th>Phone Number</th>
                                            <th>Service</th>
                                            <th>Price (₦)</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($chefs as $index => $chef)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                @if($chef->image)
                                                    <img src="{{ asset($chef->image) }}" width="40" height="40" class="rounded-circle shadow-sm" />
                                                @else
                                                    <span class="text-muted">No Image</span>
                                                @endif
                                            </td>
                                            <td>{{ $chef->first_name }} {{ $chef->last_name }}</td>
                                            <td>{{ $chef->specialty ?? 'N/A' }}</td>
                                            <td>{{ $chef->phone_number }}</td>
                                            <td>{{ optional($chef->chefServices->first())->name ?? 'N/A' }}</td>
                                            <td>{{ count($chef->chefServices) > 0 ? number_format(optional($chef->chefServices->first())->pivot->price) : '-' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $chef->availability_status == 'Available' ? 'success' : 'warning' }}">
                                                    {{ $chef->availability_status }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-sm">
                                                    <button class="btn btn-primary btn-sm" onclick="openAssignModal({{ $chef->id }})">
                                                        <i class="bi bi-link-45deg ms-0"></i>
                                                    </button>
                                                    @if($chef->availability_status == 'Busy')
                                                        <button class="btn btn-success btn-sm" onclick="markAsAvailable({{ $chef->id }})">
                                                            <i class="bi bi-check-circle ms-0"></i>
                                                        </button>
                                                    @endif
                                                    {{-- <a href="#" class="btn btn-dark btn-sm">
                                                        <i class="bi bi-eye ms-0"></i>
                                                    </a> --}}
                                                    <button class="btn btn-danger btn-sm" onclick="deleteChef({{ $chef->id }})">
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
        if(confirm("Are you sure you want to mark this chef as available?")) {
            fetch(`/chefs/${chefId}/mark-available`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            }).then(response => response.json())
            .then(data => {
                if(data.success) {
                    showSuccessMessage("Chef marked as available!");
                    setTimeout(() => location.reload(), 1500);
                } else {
                    alert("Something went wrong.");
                }
            });
        }
    }

    function deleteChef(chefId) {
        if(confirm("Are you sure you want to delete this chef?")) {
            fetch(`/chefs/${chefId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json())
            .then(data => {
                if(data.success) {
                    showSuccessMessage("Chef deleted successfully!");
                    setTimeout(() => location.reload(), 1500);
                } else {
                    alert("Failed to delete chef.");
                }
            });
        }
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
