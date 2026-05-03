@extends('layouts.app', [$activePage = 'Dashboard'])

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/sweetalert2.css') }}" />
    <style>
        .stat-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: default;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .task-row {
            transition: background-color 0.2s ease;
        }
        .task-row:hover {
            background-color: rgba(37, 117, 252, 0.05) !important;
        }
        .badge-status {
            font-weight: 500;
            padding: 0.5em 1em;
            border-radius: 2rem;
        }
    </style>
@endpush

@section('content')
    <main class="page-content">
        @php
            $hour = now()->format('H');
            $greeting = ($hour < 12) ? 'Good Morning' : (($hour < 18) ? 'Good Afternoon' : 'Good Evening');
        @endphp

        <!-- Hero Section -->
        <div class="row mb-3">
            <div class="col-12">
                <h2 class="fw-bold">Welcome Back!</h2>
                <p class="text-muted">{{ $greeting }}, {{ auth()->user()->first_name }} (Cleaner) 🙂...</p>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-4 stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted mb-1 text-uppercase small fw-bold">Pending Cleaning</h6>
                                <h2 class="mb-0">{{ count($to_clean) }}</h2>
                            </div>
                            <div class="ms-3 widget-icon bg-warning text-white rounded-4 p-3 fs-3">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-4 stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted mb-1 text-uppercase small fw-bold">Cleaned Today</h6>
                                <h2 class="mb-0">{{ $cleaned_today }}</h2>
                            </div>
                            <div class="ms-3 widget-icon bg-success text-white rounded-4 p-3 fs-3">
                                <i class="bi bi-check2-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-4 stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted mb-1 text-uppercase small fw-bold">Active Issues</h6>
                                <h2 class="mb-0">{{ $reported_issues }}</h2>
                            </div>
                            <div class="ms-3 widget-icon bg-danger text-white rounded-4 p-3 fs-3">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Task Area -->
        <div class="row">
            <div class="col-12 col-xl-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-list-task me-2 text-primary"></i>Immediate Cleaning Tasks</h5>
                            <span class="badge bg-primary rounded-pill">{{ count($to_clean) }} Total</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @if(count($to_clean) > 0)
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-4">Apartment</th>
                                            <th>Location</th>
                                            <th>Status</th>
                                            <th class="text-center pe-4">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($to_clean as $property)
                                            <tr class="task-row">
                                                <td class="ps-4">
                                                    <div class="fw-bold text-dark">{{ $property->name }}</div>
                                                    <div class="small text-muted">{{ $property->type }}</div>
                                                </td>
                                                <td>
                                                    <small><i class="bi bi-geo-alt me-1"></i>{{ $property->full_location }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge-status bg-warning bg-opacity-10 text-warning">Needs Cleaning</span>
                                                </td>
                                                <td class="text-center pe-4">
                                                    <button class="btn btn-primary rounded-pill px-4 py-2"
                                                        onclick="markAsAvailable('{{ $property->id }}')">
                                                        <i class="bi bi-check-circle me-1"></i> Mark Clean
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-emoji-smile fs-1 text-primary"></i>
                                </div>
                                <h5 class="text-muted">Great Job!</h5>
                                <p class="text-muted mb-0">All your assigned apartments are currently clean.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Side Assignments -->
            <div class="col-12 col-xl-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-building me-2 text-secondary"></i>Your Portfolio</h5>
                    </div>
                    <div class="card-body">
                        @if(count($properties) > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($properties as $property)
                                    <div class="list-group-item px-0 border-light border-bottom">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <div class="fw-bold small">{{ $property->name }}</div>
                                                <div class="text-muted" style="font-size: 0.75rem;">{{ $property->address }}</div>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge rounded-pill bg-{{ $property->status == 'Available' ? 'success' : ($property->status == 'Under Maintenance' ? 'warning' : 'info') }} text-white" style="font-size: 0.7rem;">
                                                    {{ $property->status }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted text-center py-3">No properties assigned yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('js')
    <script src="{{ asset('assets/js/plugins/sweetalert2.js') }}"></script>
    <script>
        function markAsAvailable(propertyId) {
            Swal.fire({
                title: 'Job Completed?',
                text: 'Are you sure you have finished cleaning this apartment?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Mark as Clean',
                cancelButtonText: 'Not Yet',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary px-4 me-2',
                    cancelButton: 'btn btn-outline-danger px-4',
                    popup: 'rounded-4 border-0 shadow'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Updating...',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading() }
                    });

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
                                Swal.fire({
                                    title: 'Excellent!',
                                    text: 'Apartment has been marked as clean and ready for guests.',
                                    icon: 'success',
                                    customClass: { confirmButton: 'btn btn-primary px-4' }
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error', 'Something went wrong while updating status.', 'error');
                            }
                        }).catch(() => {
                            Swal.fire('Error', 'Network error. Please try again.', 'error');
                        });
                }
            });
        }
    </script>
@endpush
