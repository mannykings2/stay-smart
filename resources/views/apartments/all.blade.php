@extends('layouts.app', [$activePage = 'All Apartments'])

@section('content')
<main class="page-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-5">
                <h2 class="text-center mb-4">Apartment Listings</h2>
                <div class="card rounded-4">
                    <div class="card-body">
                        @if(count($apartments) > 0)
                            <div class="table-responsive">
                                <table id="apartmentsTable" class="mDatatable table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Apartment Name</th>
                                            <th>Location</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($apartments as $index => $apartment)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $apartment->name }}</td>
                                            <td>{{ $apartment->full_location }}</td>
                                            <td>${{ number_format($apartment->price, 2) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $apartment->status == 'Available' ? 'success' : ($apartment->status == 'Pending' ? 'warning' : ($apartment->status == 'Booked' ? 'danger' : 'dark') ) }}">
                                                    {{ ucfirst($apartment->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    @if($apartment->status == 'Pending')
                                                        <button class="btn btn-success btn-sm" onclick="markAsAvailable({{ $apartment->id }})">
                                                            <i class="bi bi-check-circle ms-0"></i>
                                                        </button>
                                                    @endif
                                                    <a href="#" class="btn btn-dark btn-sm">
                                                        <i class="bi bi-eye ms-0"></i>
                                                    </a>
                                                    <button class="btn btn-danger btn-sm" onclick="deleteApartment({{ $apartment->id }})">
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
                            <p class="text-center mb-0 p-3">There are no apartments available</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection


@push('js')
<script>
    function markAsAvailable(apartmentId) {
        if(confirm("Are you sure you want to mark this apartment as available?")) {
            fetch(`/apartments/${apartmentId}/mark-available`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            }).then(response => response.json())
              .then(data => {
                  if(data.success) {
                      location.reload();
                  } else {
                      alert("Something went wrong.");
                  }
              });
        }
    }
</script>
@endpush