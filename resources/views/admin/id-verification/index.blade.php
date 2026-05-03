@extends('layouts.app', ['activePage' => 'ID Verification'])

@section('content')
    <main class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card rounded-4">
                    <div class="card-header border-0 p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">ID Verification Requests</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        {{-- Status Filter Tabs (client-side, no page reload) --}}
                        <ul class="nav nav-pills mb-4 border p-2 rounded-4 bg-light shadow-sm" id="idVerification-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active rounded-pill px-4 fw-bold" id="all-tab" data-bs-toggle="pill"
                                    data-bs-target="#all-pane" type="button" role="tab" aria-selected="true">
                                    <i class="bi bi-grid me-1"></i> All
                                    <span class="badge bg-white text-dark ms-1 rounded-pill">{{ $allVerifications->count() }}</span>
                                </button>
                            </li>
                            <li class="nav-item ms-2" role="presentation">
                                <button class="nav-link rounded-pill px-4 fw-bold" id="pending-tab" data-bs-toggle="pill"
                                    data-bs-target="#pending-pane" type="button" role="tab" aria-selected="false">
                                    <i class="bi bi-hourglass-split me-1"></i> Pending
                                    @if($pendingVerifications->count() > 0)
                                        <span class="badge bg-danger ms-1 rounded-pill">{{ $pendingVerifications->count() }}</span>
                                    @endif
                                </button>
                            </li>
                            <li class="nav-item ms-2" role="presentation">
                                <button class="nav-link rounded-pill px-4 fw-bold" id="verified-tab" data-bs-toggle="pill"
                                    data-bs-target="#verified-pane" type="button" role="tab" aria-selected="false">
                                    <i class="bi bi-patch-check me-1"></i> Verified
                                </button>
                            </li>
                            <li class="nav-item ms-2" role="presentation">
                                <button class="nav-link rounded-pill px-4 fw-bold" id="rejected-tab" data-bs-toggle="pill"
                                    data-bs-target="#rejected-pane" type="button" role="tab" aria-selected="false">
                                    <i class="bi bi-x-circle me-1"></i> Rejected
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="idVerification-tabContent">

                            {{-- Tab 1: All --}}
                            <div class="tab-pane fade show active" id="all-pane" role="tabpanel" aria-labelledby="all-tab">
                                @include('admin.id-verification.partials.table', ['verifications' => $allVerifications, 'emptyMessage' => 'No verification requests found.'])
                            </div>

                            {{-- Tab 2: Pending --}}
                            <div class="tab-pane fade" id="pending-pane" role="tabpanel" aria-labelledby="pending-tab">
                                @include('admin.id-verification.partials.table', ['verifications' => $pendingVerifications, 'emptyMessage' => 'No pending verification requests.'])
                            </div>

                            {{-- Tab 3: Verified --}}
                            <div class="tab-pane fade" id="verified-pane" role="tabpanel" aria-labelledby="verified-tab">
                                @include('admin.id-verification.partials.table', ['verifications' => $verifiedVerifications, 'emptyMessage' => 'No verified requests yet.'])
                            </div>

                            {{-- Tab 4: Rejected --}}
                            <div class="tab-pane fade" id="rejected-pane" role="tabpanel" aria-labelledby="rejected-tab">
                                @include('admin.id-verification.partials.table', ['verifications' => $rejectedVerifications, 'emptyMessage' => 'No rejected requests.'])
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- Rejection Modals (rendered once outside the tabs) --}}
    @foreach($allVerifications as $verification)
        @if($verification->isPending())
            <div class="modal fade" id="rejectModal{{ $verification->id }}" tabindex="-1"
                aria-labelledby="rejectModalLabel{{ $verification->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('admin.id-verification.reject', $verification->id) }}" method="POST"
                            id="reject-list-form-{{ $verification->id }}" class="confirm-submit" 
                            data-title="Confirm Rejection"
                            data-message="Are you sure you want to reject this ID verification?"
                            data-confirm-text="Yes, reject it"
                            data-type="error">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="rejectModalLabel{{ $verification->id }}">
                                    Reject ID Verification
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Rejecting ID for: <strong>{{ $verification->user->first_name ?? '' }} {{ $verification->user->last_name ?? '' }}</strong></p>
                                <div class="mb-3">
                                    <label for="rejection_reason{{ $verification->id }}" class="form-label">Reason for Rejection *</label>
                                    <textarea class="form-control" id="rejection_reason{{ $verification->id }}"
                                        name="rejection_reason" rows="3" required
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
    @endforeach

    @push('js')
        <script>
            $(function () {
                // Restore active tab from localStorage
                const activeTab = localStorage.getItem('id_verification_active_tab');
                if (activeTab) {
                    const tabEl = document.querySelector(`#${activeTab}`);
                    if (tabEl) { new bootstrap.Tab(tabEl).show(); }
                }
                // Save tab on change
                document.querySelectorAll('button[data-bs-toggle="pill"]').forEach(tab => {
                    tab.addEventListener('shown.bs.tab', e => {
                        localStorage.setItem('id_verification_active_tab', e.target.id);
                    });
                });
            });
        </script>
    @endpush
@endsection
