@extends('layouts.app', [$activePage = 'All Chefs'])

@section('content')
<main class="page-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-5">
                <div class="d-flex justify-content-between mb-4">
                    <h2 class="text-center">Apartment Amenities</h2>
                    <button type="button" class="btn btn-primary rounded-3 px-4" data-bs-toggle="modal" data-bs-target="#newAmenityModal">
                        <i class="ms-0 bi bi-plus"></i>
                        New Amenity
                    </button>
                </div>
                <div class="card rounded-4">
                    <div class="card-body">
                        @if(count($services) > 0)
                            <div class="table-responsive">
                                <table id="chefsTable" class="mDatatable table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Date Created</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($amenities as $index => $amenity)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $amenity->name }}</td>
                                            <td>{{ $amenity->created_at->diffForHumans() }}</td>
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
    @include('modals.add-amenity')
</main>
@endsection
