@extends('layouts.app', [$activePage = 'All Chefs'])

@section('content')
    <main class="page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 mt-5">
                    <div class="d-flex justify-content-between mb-4">
                        <h2 class="text-center">Chef Services</h2>
                        <button type="button" class="btn btn-primary rounded-3 px-4" data-bs-toggle="modal"
                            data-bs-target="#newServiceModal">
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
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($services as $index => $service)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $service->name }}</td>
                                                    <td>{{ $service->created_at->diffForHumans() }}</td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <button type="button" class="btn btn-sm btn-outline-primary rounded-3"
                                                                onclick="openEditServiceModal('{{ $service->id }}', '{{ addslashes($service->name) }}')">
                                                                <i class="bi bi-pencil"></i> Edit
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-outline-danger rounded-3"
                                                                onclick="submitDeleteService('{{ route('chef.service.destroy', $service->id) }}')">
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
                                <p class="text-center mb-0 p-3">There are no chefs services available</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('modals.add-service')
        @include('modals.edit-chef-service')

        <form id="deleteServiceForm" action="" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>

        <script>
            function openEditServiceModal(id, name) {
                const form = document.getElementById('editServiceForm');
                form.action = `/chef-service/${id}`;
                document.getElementById('edit_service_name').value = name;

                const modal = new bootstrap.Modal(document.getElementById('editServiceModal'));
                modal.show();
            }

            function submitDeleteService(url) {
                if (confirm('Are you sure you want to delete this service?')) {
                    const form = document.getElementById('deleteServiceForm');
                    form.action = url;
                    form.submit();
                }
            }
        </script>
    </main>
@endsection