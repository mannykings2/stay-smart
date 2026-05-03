@extends('layouts.app', ['activePage' => 'ID Verification'])

@section('content')
    <main class="page-content">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card rounded-4">
                    <div class="card-header border-0 p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">ID Verification Details</h5>
                            <a href="{{ route('admin.id-verification.index') }}" class="btn btn-outline-secondary btn-sm rounded-3">
                                <i class="bi bi-arrow-left me-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        {{-- User Info --}}
                        <div class="mb-4">
                            <h6 class="text-muted mb-3">User Information</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Name:</strong> {{ $verification->user->first_name ?? '' }} {{ $verification->user->last_name ?? '' }}</p>
                                    <p><strong>Email:</strong> {{ $verification->user->email ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Role:</strong>
                                        @if($verification->user)
                                            @foreach($verification->user->roles as $role)
                                                <span class="badge bg-info text-white">{{ $role->name }}</span>
                                            @endforeach
                                            @if($verification->user->roles->isEmpty())
                                                <span class="badge bg-secondary">User</span>
                                            @endif
                                        @endif
                                    </p>
                                    <p><strong>Phone:</strong> {{ $verification->user->phone_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- Verification Info --}}
                        <div class="mb-4">
                            <h6 class="text-muted mb-3">Verification Request</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Status:</strong>
                                        @if($verification->isPending())
                                            <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split"></i> Pending</span>
                                        @elseif($verification->isVerified())
                                            <span class="badge bg-success"><i class="bi bi-patch-check-fill"></i> Verified</span>
                                        @elseif($verification->isRejected())
                                            <span class="badge bg-danger"><i class="bi bi-x-circle-fill"></i> Rejected</span>
                                        @endif
                                    </p>
                                    <p><strong>Submitted:</strong> {{ $verification->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>File:</strong> {{ $verification->original_filename }}</p>
                                    <p><strong>Type:</strong> {{ strtoupper($verification->document_type) }}</p>
                                </div>
                            </div>

                            @if($verification->reviewer)
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <p><strong>Reviewed by:</strong> {{ optional($verification->reviewer)->first_name }} {{ optional($verification->reviewer)->last_name }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Reviewed on:</strong> {{ $verification->reviewed_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($verification->isRejected() && $verification->rejection_reason)
                                <div class="alert alert-danger mt-2">
                                    <strong>Rejection Reason:</strong> {{ $verification->rejection_reason }}
                                </div>
                            @endif
                        </div>

                        <hr>

                        {{-- Document Preview --}}
                        <div class="mb-4">
                            <h6 class="text-muted mb-3">Uploaded Document</h6>

                            <div class="d-flex gap-2 mb-3">
                                <a href="{{ route('admin.id-verification.download', $verification->id) }}"
                                    class="btn btn-outline-primary btn-sm rounded-3">
                                    <i class="bi bi-download me-1"></i> Download Document
                                </a>
                                <a href="{{ route('admin.id-verification.preview', $verification->id) }}"
                                    class="btn btn-outline-info btn-sm rounded-3" target="_blank">
                                    <i class="bi bi-box-arrow-up-right me-1"></i> Open in New Tab
                                </a>
                            </div>

                            @if(in_array($verification->document_type, ['jpg', 'jpeg', 'png']))
                                <div class="border rounded-3 p-2 text-center" style="max-height: 500px; overflow: auto;">
                                    <img src="{{ route('admin.id-verification.preview', $verification->id) }}"
                                        alt="ID Document" class="img-fluid rounded-3"
                                        style="max-width: 100%; max-height: 480px; object-fit: contain;">
                                </div>
                            @elseif($verification->document_type === 'pdf')
                                <div class="border rounded-3" style="height: 500px;">
                                    <iframe src="{{ route('admin.id-verification.preview', $verification->id) }}"
                                        width="100%" height="100%" style="border: none; border-radius: 12px;">
                                        Your browser does not support PDFs.
                                        <a href="{{ route('admin.id-verification.download', $verification->id) }}">Download the PDF</a>.
                                    </iframe>
                                </div>
                            @endif
                        </div>

                        <hr>

                        {{-- Action Buttons --}}
                        @if($verification->isPending())
                            <div class="d-flex gap-3 mt-4">
                                <form action="{{ route('admin.id-verification.verify', $verification->id) }}" method="POST"
                                    id="approve-form-{{ $verification->id }}" class="confirm-submit" 
                                    data-title="Confirm Approval"
                                    data-message="Are you sure you want to approve this ID verification?"
                                    data-confirm-text="Yes, approve!">
                                    @csrf
                                    <button type="submit" class="btn btn-success rounded-3 px-4">
                                        <i class="bi bi-patch-check me-1"></i> Approve Verification
                                    </button>
                                </form>

                                <button type="button" class="btn btn-danger rounded-3 px-4"
                                    data-bs-toggle="modal" data-bs-target="#rejectDetailModal">
                                    <i class="bi bi-x-circle me-1"></i> Reject Verification
                                </button>
                            </div>

                            {{-- Rejection Modal --}}
                            <div class="modal fade" id="rejectDetailModal" tabindex="-1" aria-labelledby="rejectDetailModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.id-verification.reject', $verification->id) }}" method="POST"
                                            id="reject-form-{{ $verification->id }}" class="confirm-submit" 
                                            data-title="Confirm Rejection"
                                            data-message="Are you sure you want to reject this ID verification?"
                                            data-confirm-text="Yes, reject it"
                                            data-type="error">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="rejectDetailModalLabel">Reject ID Verification</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Rejecting ID for: <strong>{{ $verification->user->first_name ?? '' }} {{ $verification->user->last_name ?? '' }}</strong></p>
                                                <div class="mb-3">
                                                    <label for="rejection_reason" class="form-label">Reason for Rejection *</label>
                                                    <textarea class="form-control" id="rejection_reason" name="rejection_reason"
                                                        rows="3" required
                                                        placeholder="e.g. Document is blurry, ID is expired, wrong document type..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="bi bi-x-circle me-1"></i> Reject Verification
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection


