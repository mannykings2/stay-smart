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
                            <li class="breadcrumb-item active" aria-current="page">Transactions</li>
                        </ol>
                    </nav>
                </div>-->
            <div class="ms-auto">
                <a href="{{ route('admin.revenue.export', request()->all()) }}"
                    class="btn btn-outline-primary btn-sm rounded-pill px-3">
                    <i class="bi bi-download me-2"></i>Export CSV
                </a>
            </div>
        </div>

        <!-- Filtering Toolbar -->
        <div class="card mb-4 rounded-4 shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('admin.revenue.transactions') }}" method="GET" class="row g-3 align-items-end"
                    id="filterForm">
                    <div class="col-12 col-md-3">
                        <label class="form-label small text-muted text-uppercase fw-bold">Select Period</label>
                        <select name="period" class="form-select rounded-3 border-light shadow-sm" id="periodSelect">
                            <option value="all" {{ request('period') == 'all' ? 'selected' : '' }}>All Time</option>
                            <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>This Week</option>
                            <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>This Month</option>
                            <option value="year" {{ request('period') == 'year' ? 'selected' : '' }}>This Year</option>
                            <option value="custom" {{ request('period') == 'custom' ? 'selected' : '' }}>Custom Range</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-2 date-range-inputs"
                        style="{{ request('period') == 'custom' ? '' : 'display: none;' }}">
                        <label class="form-label small text-muted text-uppercase fw-bold">Start Date</label>
                        <input type="date" name="start_date" class="form-control rounded-3 border-light shadow-sm"
                            value="{{ request('start_date') }}">
                    </div>

                    <div class="col-12 col-md-2 date-range-inputs"
                        style="{{ request('period') == 'custom' ? '' : 'display: none;' }}">
                        <label class="form-label small text-muted text-uppercase fw-bold">End Date</label>
                        <input type="date" name="end_date" class="form-control rounded-3 border-light shadow-sm"
                            value="{{ request('end_date') }}">
                    </div>

                    <div class="col-12 col-md-2">
                        <label class="form-label small text-muted text-uppercase fw-bold">Status</label>
                        <select name="status" class="form-select rounded-3 border-light shadow-sm">
                            <option value="">All Statuses</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Paid" {{ request('status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                            <option value="Available" {{ request('status') == 'Available' ? 'selected' : '' }}>Available
                            </option>
                            <option value="Withdrawn" {{ request('status') == 'Withdrawn' ? 'selected' : '' }}>Withdrawn
                            </option>
                            <option value="Voided" {{ request('status') == 'Voided' ? 'selected' : '' }}>Voided
                            </option>
                        </select>
                    </div>

                    <div class="col-12 col-md-3">
                        <label class="form-label small text-muted text-uppercase fw-bold">Search</label>
                        <input type="text" name="search" class="form-control rounded-3 border-light shadow-sm"
                            placeholder="Ref, guest, property..." value="{{ request('search') }}">
                    </div>

                    <div class="col-12 col-md-auto ms-auto">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-dark rounded-3 px-4">
                                <i class="bi bi-filter me-2"></i>Filter
                            </button>
                            @if(request()->hasAny(['period', 'start_date', 'end_date', 'status']))
                                <a href="{{ route('admin.revenue.transactions') }}" class="btn btn-outline-secondary rounded-3">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card rounded-4 shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Ref</th>
                                <th>Service</th>
                                @if($isSuperAdmin)
                                <th>Admin</th> @endif
                                <th>Amount Paid</th>
                                @if($isSuperAdmin)
                                <th>Admin Net</th> @endif
                                <th>Fee %</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $trx)
                                <tr>
                                    <td>{{ $trx->created_at->format('M d, Y') }}</td>
                                    <td><small class="text-muted">{{ $trx->payment->trx_ref ?? 'N/A' }}</small></td>
                                    <td>
                                        <span class="fw-bold">
                                            @if($trx->service_type === 'Chef')
                                                Chef Service
                                            @elseif($trx->service_type === 'Driver')
                                                Driver Service
                                            @else
                                                {{ $trx->payment->booking->property->name ?? 'Property' }}
                                            @endif
                                        </span>
                                    </td>
                                    @if($isSuperAdmin)
                                    <td>{{ optional($trx->admin)->first_name }}</td> @endif
                                    <td>₦{{ number_format($trx->total_amount, 2) }}</td>
                                    @if($isSuperAdmin)
                                        <td class="text-success fw-bold">₦{{ number_format($trx->admin_net_amount, 2) }}</td>
                                    @endif
                                    <td>
                                        <span class="badge bg-light text-dark" data-bs-toggle="tooltip"
                                            title="Fee: ₦{{ number_format($trx->platform_fee_amount, 2) }}">
                                            {{ $trx->commission_rate_applied ?? '10' }}%
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $badgeClass = match ($trx->status) {
                                                'Pending' => 'bg-warning text-dark',
                                                'Paid' => 'bg-soft-info text-info border border-info',
                                                'Available' => 'bg-success',
                                                'Withdrawn' => 'bg-primary',
                                                'Voided' => 'bg-dark',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }} rounded-pill px-3">{{ $trx->status }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $isSuperAdmin ? '8' : '6' }}" class="text-center py-5">
                                        <i class="bi bi-inbox text-muted display-4 d-block mb-3"></i>
                                        <p class="text-muted">No transactions found for the selected filters.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @include('components.pagination', ['paginator' => $transactions])
            </div>
        </div>
    </main>

    @push('js')
        <script>
            $(function () {
                $('[data-bs-toggle="tooltip"]').tooltip();
                document.getElementById('periodSelect')?.addEventListener('change', function () {
                    const dateInputs = document.querySelectorAll('.date-range-inputs');
                    if (this.value === 'custom') {
                        dateInputs.forEach(el => el.style.display = 'block');
                    } else {
                        dateInputs.forEach(el => el.style.display = 'none');
                        document.getElementById('filterForm').submit();
                    }
                });
            });
        </script>
    @endpush
@endsection