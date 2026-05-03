@extends('layouts.app')

@section('content')
    <!--start content-->
    <main class="page-content">
        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <!--<div class="breadcrumb-title pe-3">Revenue Hub</div>-->
            <!--<div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.revenue.index') }}">Revenue Hub</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Payouts</li>
                    </ol>
                </nav>
            </div>-->
            @if(!auth()->user()->hasRole('Super Admin') && $stats['available'] > 0 && $pendingPayouts->isEmpty())
                <div class="ms-auto">
                    <form action="{{ route('admin.revenue.payout.request') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                            <i class="bi bi-wallet2 me-2"></i>Request ₦{{ number_format($stats['available'], 2) }}
                        </button>
                    </form>
                </div>
            @elseif(!auth()->user()->hasRole('Super Admin') && $pendingPayouts->isNotEmpty())
                <div class="ms-auto">
                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fs-6">
                        <i class="bi bi-hourglass-split me-1"></i>Payout Pending Approval
                    </span>
                </div>
            @endif
        </div>

        <!-- Payout Stats Cards -->
        <div class="row row-cols-1 row-cols-md-3 g-3 mb-4">
            <div class="col">
                <div class="card rounded-4 border-0 shadow-sm">
                    <div class="card-body">
                        <p class="text-muted small text-uppercase fw-bold mb-1">Available for Withdrawal</p>
                        <h4 class="mb-0 text-primary">₦{{ number_format($stats['available'], 2) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card rounded-4 border-0 shadow-sm">
                    <div class="card-body">
                        <p class="text-muted small text-uppercase fw-bold mb-1">Pending Approval</p>
                        <h4 class="mb-0 text-warning">
                            ₦{{ $pendingPayouts->sum('amount') > 0 ? number_format($pendingPayouts->sum('amount'), 2) : '0.00' }}
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card rounded-4 border-0 shadow-sm">
                    <div class="card-body">
                        <p class="text-muted small text-uppercase fw-bold mb-1">Total Withdrawn</p>
                        <h4 class="mb-0">₦{{ number_format($stats['withdrawn'], 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap Tabbed Navigation -->
        <ul class="nav nav-pills mb-3 border p-2 rounded-4 bg-light shadow-sm" id="payouts-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-pill px-4 fw-bold" id="pending-tab" data-bs-toggle="pill"
                    data-bs-target="#pending-pane" type="button" role="tab" aria-selected="true">
                    <i class="bi bi-hourglass-split me-2"></i>Pending Requests
                    @if($pendingPayouts->isNotEmpty())
                        <span class="badge bg-danger ms-1 rounded-pill">{{ $pendingPayouts->count() }}</span>
                    @endif
                </button>
            </li>
            <li class="nav-item ms-2" role="presentation">
                <button class="nav-link rounded-pill px-4 fw-bold" id="history-tab" data-bs-toggle="pill"
                    data-bs-target="#history-pane" type="button" role="tab" aria-selected="false">
                    <i class="bi bi-receipt me-2"></i>Payout History
                </button>
            </li>
        </ul>

        <div class="tab-content" id="payouts-tabContent">

            <!-- Tab 1: Pending Requests -->
            <div class="tab-pane fade show active" id="pending-pane" role="tabpanel" aria-labelledby="pending-tab">

                {{-- Super Admin: Payout Due Alerts --}}
                @if($isSuperAdmin && $adminDueStatuses->isNotEmpty())
                    <div class="card rounded-4 shadow-sm border-0 mb-4">
                        <div class="card-header bg-transparent border-0 pt-3 pb-0 px-4">
                            <h6 class="fw-bold mb-0">
                                <i class="bi bi-bell-fill text-warning me-2"></i>Payout Due Alerts
                                <span class="badge bg-warning text-dark rounded-pill ms-2">{{ $adminDueStatuses->count() }}</span>
                            </h6>
                            <small class="text-muted">Admins with available funds who have not yet submitted a request.</small>
                        </div>
                        <div class="card-body px-4 py-3">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Admin</th>
                                            <th>Frequency</th>
                                            <th>Last Paid</th>
                                            <th>Available Balance</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($adminDueStatuses as $item)
                                            @php
                                                $badgeClass = match($item['status']['state']) {
                                                    'overdue'   => 'danger',
                                                    'due'       => 'warning text-dark',
                                                    'upcoming'  => 'info text-dark',
                                                    'available' => 'secondary',
                                                    default     => 'light text-dark',
                                                };
                                                $iconClass = match($item['status']['state']) {
                                                    'overdue'   => 'bi-exclamation-triangle-fill',
                                                    'due'       => 'bi-clock-fill',
                                                    'upcoming'  => 'bi-hourglass-split',
                                                    'available' => 'bi-wallet2',
                                                    default     => 'bi-check-circle',
                                                };
                                            @endphp
                                            <tr>
                                                <td>
                                                    <strong>{{ optional($item['admin'])->first_name }} {{ optional($item['admin'])->last_name }}</strong>
                                                    <br><small class="text-muted">{{ optional($item['admin'])->email }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light text-dark border rounded-pill px-3">{{ $item['frequency'] }}</span>
                                                </td>
                                                <td>
                                                    @if($item['last_paid'])
                                                        {{ \Carbon\Carbon::parse($item['last_paid'])->format('M d, Y') }}
                                                    @else
                                                        <span class="text-muted fst-italic">Never paid</span>
                                                    @endif
                                                </td>
                                                <td class="fw-bold text-success">
                                                    ₦{{ number_format($item['balance'], 2) }}
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $badgeClass }} rounded-pill px-3">
                                                        <i class="bi {{ $iconClass }} me-1"></i>{{ $item['status']['label'] }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card rounded-4 shadow-sm border-0">
                    <div class="card-body">
                        @if($pendingPayouts->isEmpty())
                            <div class="text-center py-5">
                                <i class="bi bi-check-circle text-success display-4 d-block mb-3"></i>
                                <p class="text-muted mb-0">No pending payout requests.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date Requested</th>
                                            <th>Reference</th>
                                            @if($isSuperAdmin)
                                            <th>Admin</th> @endif
                                            <th>Amount</th>
                                            <th>Status</th>
                                            @if($isSuperAdmin)
                                            <th class="text-end">Action</th> @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendingPayouts as $payout)
                                            <tr>
                                                <td>{{ $payout->created_at->format('M d, Y') }}</td>
                                                <td><code class="text-primary">{{ $payout->reference }}</code></td>
                                                @if($isSuperAdmin)
                                                    <td>
                                                        <strong>{{ optional($payout->admin)->first_name }} {{ optional($payout->admin)->last_name }}</strong>
                                                        <br><small class="text-muted">{{ optional($payout->admin)->email }}</small>
                                                    </td>
                                                @endif
                                                <td class="fw-bold fs-5">₦{{ number_format($payout->amount, 2) }}</td>
                                                <td>
                                                    <span class="badge bg-warning text-dark rounded-pill px-3">Pending
                                                        Approval</span>
                                                </td>
                                                @if($isSuperAdmin)
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-success rounded-pill px-3" data-bs-toggle="modal"
                                                            data-bs-target="#approveModal{{ $payout->id }}">
                                                            <i class="bi bi-check-lg me-1"></i>Approve
                                                        </button>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tab 2: Payout History -->
            <div class="tab-pane fade" id="history-pane" role="tabpanel" aria-labelledby="history-tab">
                <div class="card rounded-4 shadow-sm border-0">
                    <div class="card-body">
                        @if($payoutHistory->isEmpty())
                            <div class="text-center py-5">
                                <i class="bi bi-inbox text-muted display-4 d-block mb-3"></i>
                                <p class="text-muted mb-0">No payout history yet.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date Paid</th>
                                            <th>Reference</th>
                                            @if($isSuperAdmin)
                                            <th>Admin</th> @endif
                                            <th>Amount</th>
                                            <th>Method</th>
                                            <th>Status</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($payoutHistory as $payout)
                                            <tr>
                                                <td>{{ $payout->paid_at ? \Carbon\Carbon::parse($payout->paid_at)->format('M d, Y') : '—' }}
                                                </td>
                                                <td><code class="text-primary">{{ $payout->reference }}</code></td>
                                                @if($isSuperAdmin)
                                                    <td>{{ optional($payout->admin)->first_name }} {{ optional($payout->admin)->last_name }}</td>
                                                @endif
                                                <td class="fw-bold">₦{{ number_format($payout->amount, 2) }}</td>
                                                <td><span
                                                        class="badge bg-light text-dark border">{{ $payout->payment_method ?? '—' }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success rounded-pill px-3">Paid</span>
                                                </td>
                                                <td class="text-end">
                                                    <button class="btn btn-sm btn-outline-dark rounded-circle p-1 lh-1" 
                                                        data-bs-toggle="modal" data-bs-target="#viewPayoutModal{{ $payout->id }}"
                                                        title="View Details">
                                                        <i class="bi bi-eye fs-6"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @include('components.pagination', ['paginator' => $payoutHistory])
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Approve Modals (Super Admin only) -->
    @if($isSuperAdmin)
        @foreach($pendingPayouts as $payout)
            <div class="modal fade" id="approveModal{{ $payout->id }}" tabindex="-1" aria-labelledby="approveLabel{{ $payout->id }}"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4 border-0 shadow">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title fw-bold" id="approveLabel{{ $payout->id }}">Approve Payout</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('admin.revenue.payout.approve', $payout->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <!-- Bank Details Section -->
                                <div class="card bg-light border-0 rounded-4 mb-3">
                                    <div class="card-body">
                                        <h6 class="fw-bold small text-uppercase text-primary mb-3">Recipient Bank Details</h6>
                                        @if(optional($payout->admin)->bankAccount)
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Bank Name</small>
                                                    <span class="fw-bold">{{ optional(optional($payout->admin)->bankAccount)->bank_name }}</span>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Account Name</small>
                                                    <span class="fw-bold">{{ optional(optional($payout->admin)->bankAccount)->account_name }}</span>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <small class="text-muted d-block">Account Number</small>
                                                    <span class="fw-bold fs-5">{{ optional(optional($payout->admin)->bankAccount)->account_number }}</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-center py-2">
                                                <i class="bi bi-exclamation-circle text-warning fs-4"></i>
                                                <p class="small text-muted mb-0">No bank details provided by admin.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="alert alert-soft rounded-4 border mb-3 p-3 bg-light">
                                    <p class="mb-1"><strong>Admin:</strong> {{ optional($payout->admin)->first_name }} {{ optional($payout->admin)->last_name }}</p>
                                    <p class="mb-1"><strong>Amount:</strong> ₦{{ number_format($payout->amount, 2) }}</p>
                                    <p class="mb-0"><strong>Ref:</strong> <code>{{ $payout->reference }}</code></p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Payment Method <span class="text-danger">*</span></label>
                                    <select name="payment_method" class="form-select rounded-3" required>
                                        <option value="">Select method...</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                        <option value="Flutterwave">Flutterwave</option>
                                        <option value="Manual Cash">Manual Cash</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Payment Reference</label>
                                    <input type="text" name="payment_reference" class="form-control rounded-3"
                                        placeholder="e.g. bank transaction ID...">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Note (optional)</label>
                                    <textarea name="admin_note" class="form-control rounded-3" rows="2"
                                        placeholder="Any note for this approval..."></textarea>
                                </div>

                                <div class="mb-0">
                                    <label class="form-label fw-bold">Upload Receipt (Evidence)</label>
                                    <input type="file" name="receipt_image" class="form-control rounded-3" accept="image/*,.pdf">
                                    <div class="form-text small">Recommended: JPG, PNG or PDF (Max 2MB).</div>
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success rounded-pill px-4">
                                    <i class="bi bi-check-circle me-1"></i>Confirm & Approve
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <!-- View Payout Modals -->
    @foreach($payoutHistory as $payout)
        <div class="modal fade" id="viewPayoutModal{{ $payout->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 border-0 shadow">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold">Payout Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold mb-0">₦{{ number_format($payout->amount, 2) }}</h2>
                            <span class="badge bg-success rounded-pill px-3 mt-1">Status: Paid</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-6">
                                <small class="text-muted d-block text-uppercase small fw-bold">Date Paid</small>
                                <span>{{ $payout->paid_at->format('M d, Y') }}</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block text-uppercase small fw-bold">Reference</small>
                                <code>{{ $payout->reference }}</code>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block text-uppercase small fw-bold">Method</small>
                                <span>{{ $payout->payment_method }}</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block text-uppercase small fw-bold">Bank Ref</small>
                                <span>{{ $payout->payment_reference ?? 'N/A' }}</span>
                            </div>

                            @if($payout->admin_note)
                                <div class="col-12">
                                    <small class="text-muted d-block text-uppercase small fw-bold">Super Admin Remarks</small>
                                    <div class="bg-light p-2 rounded-3 small">
                                        {{ $payout->admin_note }}
                                    </div>
                                </div>
                            @endif

                            @if($payout->receipt_image)
                                <div class="col-12">
                                    <small class="text-muted d-block text-uppercase small fw-bold mb-2">Payment Receipt</small>
                                    <div class="border rounded-4 p-2 text-center bg-light">
                                        @php $extension = pathinfo($payout->receipt_image, PATHINFO_EXTENSION); @endphp
                                        @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ asset('storage/' . $payout->receipt_image) }}" class="img-fluid rounded-3 mb-2 shadow-sm" style="max-height: 200px;">
                                        @else
                                            <div class="py-3">
                                                <i class="bi bi-file-earmark-pdf text-danger display-4"></i>
                                                <p class="mb-0 small text-muted">PDF Evidence</p>
                                            </div>
                                        @endif
                                        <div class="mt-2">
                                            <a href="{{ asset('storage/' . $payout->receipt_image) }}" target="_blank" class="btn btn-sm btn-dark rounded-pill px-3">
                                                <i class="bi bi-download me-1"></i>View / Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @push('js')
        <script>
            $(function () {
                // Restore active tab from localStorage
                const activeTab = localStorage.getItem('revenue_payouts_active_tab');
                if (activeTab) {
                    const tabEl = document.querySelector(`#${activeTab}`);
                    if (tabEl) { new bootstrap.Tab(tabEl).show(); }
                }
                // Save tab on change
                document.querySelectorAll('button[data-bs-toggle="pill"]').forEach(tab => {
                    tab.addEventListener('shown.bs.tab', e => {
                        localStorage.setItem('revenue_payouts_active_tab', e.target.id);
                    });
                });
            });
        </script>
    @endpush
@endsection