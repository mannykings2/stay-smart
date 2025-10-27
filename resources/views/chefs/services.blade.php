@extends('layouts.app', [$activePage = 'All Chefs'])

@section('content')
<main class="page-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-5">
                <div class="d-flex justify-content-between mb-4">
                    <h2 class="text-center">Chef Services</h2>
                    <button type="button" class="btn btn-primary rounded-3 px-4" data-bs-toggle="modal" data-bs-target="#newServiceModal">
                        <i class="ms-0 bi bi-plus"></i>
                        New Service
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
                                        @foreach ($services as $index => $service)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $service->name }}</td>
                                            <td>{{ $service->created_at->diffForHumans() }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        @else
                            <p class="text-center mb-0 p-3">There are no chefs services available</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('modals.add-service')
</main>
@endsection
