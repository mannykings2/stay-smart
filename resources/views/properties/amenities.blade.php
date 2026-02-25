@extends('layouts.app', [$activePage = 'All Apartments'])

@section('content')
    <main class="page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 mt-5">
                    <div class="d-flex justify-content-between mb-4">
                        <h2 class="text-center">Apartment Amenities</h2>
                        <button type="button" class="btn btn-primary rounded-3 px-4" data-bs-toggle="modal"
                            data-bs-target="#newAmenityModal">
                            <i class="ms-0 bi bi-plus"></i>
                            New Amenity
                        </button>
                    </div>
                    <div class="card rounded-4">
                        <div class="card-body">
                            @if(count($amenities) > 0)
                                <div class="table-responsive">
                                    <table id="chefsTable" class="mDatatable table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Date Created</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($amenities as $index => $amenity)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $amenity->name }}</td>
                                                    <td>{{ $amenity->created_at->diffForHumans() }}</td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <button type="button" class="btn btn-sm btn-outline-primary rounded-3"
                                                                onclick="openEditAmenityModal('{{ $amenity->id }}', '{{ addslashes($amenity->name) }}')">
                                                                <i class="bi bi-pencil"></i> Edit
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-outline-danger rounded-3"
                                                                onclick="submitDeleteAmenity('{{ route('property.amenity.destroy', $amenity->id) }}')">
                                                                <i class="bi bi-trash"></i> Delete
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            @else
                                <p class="text-center mb-0 p-3">There are no apartment amenities available</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('modals.add-property-amenity')
        @include('modals.edit-property-amenity')

        {{-- Hidden form for amenity deletion --}}
        <form id="deleteAmenityForm" action="" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>

        <script>
            function openEditAmenityModal(id, name) {
                const form = document.getElementById('editAmenityForm');
                form.action = `/properties/amenities/${id}`;
                document.getElementById('edit_amenity_name').value = name;

                const modal = new bootstrap.Modal(document.getElementById('editAmenityModal'));
                modal.show();
            }

            function submitDeleteAmenity(url) {
                if (confirm('Are you sure you want to delete this amenity? It will be removed from all associated properties.')) {
                    const form = document.getElementById('deleteAmenityForm');
                    form.action = url;
                    form.submit();
                }
            }
        </script>
    </main>
@endsection