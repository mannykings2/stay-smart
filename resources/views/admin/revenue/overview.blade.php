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
                                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Overview</li>
                            </ol>
                        </nav>
                    </div>-->
        </div>

        <!-- Filtering Toolbar -->
        <div class="card mb-4 rounded-4 shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('admin.revenue.index') }}" method="GET" class="row g-3 align-items-end"
                    id="filterForm">
                    <div class="col-12 col-md-3">
                        <label class="form-label small text-muted text-uppercase fw-bold">Select Period</label>
                        <select name="period" class="form-select rounded-3 border-light shadow-sm" id="periodSelect">
                            <option value="all" {{ request('period') == 'all' ? 'selected' : '' }}>All Time</option>
                            <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>This Week</option>
                            <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>This Month</option>
                            <option value="year" {{ request('period') == 'year' ? 'selected' : '' }}>This Year</option>
                            <option value="custom" {{ request('period') == 'custom' ? 'selected' : '' }}>Custom Range
                            </option>
                        </select>
                    </div>

                    <div class="col-12 col-md-3 date-range-inputs"
                        style="{{ request('period') == 'custom' ? '' : 'display: none;' }}">
                        <label class="form-label small text-muted text-uppercase fw-bold">Start Date</label>
                        <input type="date" name="start_date" class="form-control rounded-3 border-light shadow-sm"
                            value="{{ request('start_date') }}">
                    </div>

                    <div class="col-12 col-md-3 date-range-inputs"
                        style="{{ request('period') == 'custom' ? '' : 'display: none;' }}">
                        <label class="form-label small text-muted text-uppercase fw-bold">End Date</label>
                        <input type="date" name="end_date" class="form-control rounded-3 border-light shadow-sm"
                            value="{{ request('end_date') }}">
                    </div>

                    <div class="col-12 col-md-auto ms-auto">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-dark rounded-3 px-4">
                                <i class="bi bi-filter me-2"></i>Apply Filter
                            </button>
                            @if(request()->hasAny(['period', 'start_date', 'end_date']))
                                <a href="{{ route('admin.revenue.index') }}" class="btn btn-outline-secondary rounded-3">
                                    <i class="bi bi-x-circle me-1"></i>Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Stats -->
        <div
            class="row row-cols-1 row-cols-md-2 row-cols-lg-{{ $isSuperAdmin ? '3' : '4' }} row-cols-xl-{{ $isSuperAdmin ? '6' : '4' }} g-3 mb-4">
            @if($isSuperAdmin)
                <div class="col">
                    <div class="card rounded-4 h-100 mb-0 shadow-sm border-0" data-bs-toggle="tooltip"
                        title="Total business volume generated.">
                        <div class="card-body">
                            <div class="text-center">
                                <p class="mb-1 small text-muted text-uppercase fw-bold">Total Revenue</p>
                                <h5 class="mb-0">₦{{ number_format($stats['total_revenue'] ?? 0, 2) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card rounded-4 text-danger h-100 mb-0 shadow-sm border-0" data-bs-toggle="tooltip"
                        title="Platform's share of the revenue.">
                        <div class="card-body">
                            <div class="text-center">
                                <p class="mb-1 small text-muted text-uppercase fw-bold text-dark">Platform Fees</p>
                                <h5 class="mb-0">₦{{ number_format($stats['platform_fees'] ?? 0, 2) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col">
                <div class="card rounded-4 border-success border-bottom border-3 h-100 mb-0 shadow-sm"
                    data-bs-toggle="tooltip" title="Net amount earned by the property admin.">
                    <div class="card-body">
                        <div class="text-center">
                            <p class="mb-1 small text-muted text-uppercase fw-bold">Admin Net</p>
                            <h5 class="mb-0 text-success">₦{{ number_format($stats['admin_net'] ?? 0, 2) }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card rounded-4 h-100 mb-0 shadow-sm border-0" data-bs-toggle="tooltip"
                    title="Revenue from active bookings awaiting checkout.">
                    <div class="card-body">
                        <div class="text-center">
                            <p class="mb-1 small text-muted text-uppercase fw-bold">Pending</p>
                            <h5 class="mb-0 text-warning">₦{{ number_format($stats['pending'] ?? 0, 2) }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card rounded-4 h-100 mb-0 shadow-sm border-0" data-bs-toggle="tooltip"
                    title="Client paid but funds maturing based on payout frequency.">
                    <div class="card-body">
                        <div class="text-center">
                            <p class="mb-1 small text-muted text-uppercase fw-bold">Paid</p>
                            <h5 class="mb-0 text-info">₦{{ number_format($stats['paid'] ?? 0, 2) }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card rounded-4 h-100 mb-0 shadow-sm border-0" data-bs-toggle="tooltip"
                    title="Cleared for withdrawal.">
                    <div class="card-body">
                        <div class="text-center">
                            <p class="mb-1 small text-muted text-uppercase fw-bold">Available</p>
                            <h5 class="mb-0 text-primary">₦{{ number_format($stats['available'] ?? 0, 2) }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card rounded-4 h-100 mb-0 shadow-sm border-0">
                    <div class="card-body">
                        <div class="text-center">
                            <p class="mb-1 small text-muted text-uppercase fw-bold">Withdrawn</p>
                            <h5 class="mb-0">₦{{ number_format($stats['withdrawn'] ?? 0, 2) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(!auth()->user()->hasRole('Super Admin') && $stats['available'] > 0)
            <div class="alert alert-success border-0 bg-success alert-dismissible fade show rounded-4 shadow-sm mb-4">
                <div class="d-flex align-items-center">
                    <div class="font-35 text-white"><i class='bi bi-check-circle-fill'></i></div>
                    <div class="ms-3">
                        <h6 class="mb-0 text-white">Funds Available</h6>
                        <div class="text-white">You have ₦{{ number_format($stats['available'], 2) }} ready for withdrawal.
                        </div>
                    </div>
                    <div class="ms-auto">
                        <form action="{{ route('admin.revenue.payout.request') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-light rounded-3 px-4">Request Payout</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        {{-- Revenue Trend Chart --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card rounded-4 shadow-sm border-0">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h6 class="mb-0 fw-bold">Revenue Trend (Last 6 Months)</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueTrendChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Recent Transactions -->
            <div class="col-12 col-lg-7">
                <div class="card rounded-4 shadow-sm border-0">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0 fw-bold">Recent Transactions</h6>
                            <a href="{{ route('admin.revenue.transactions') }}"
                                class="ms-auto btn btn-sm btn-outline-dark rounded-pill px-3">View All</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Service</th>
                                        <th>Amount Paid</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTransactions as $trx)
                                        <tr>
                                            <td>{{ $trx->created_at->format('M d') }}</td>
                                            <td>
                                                <small class="d-block fw-bold text-truncate" style="max-width: 150px;">
                                                    @if($trx->service_type === 'Chef')
                                                        Chef Service
                                                    @elseif($trx->service_type === 'Driver')
                                                        Driver Service
                                                    @else
                                                        {{ $trx->payment->booking->property->name ?? 'Property' }}
                                                    @endif
                                                </small>
                                            </td>
                                            <td>₦{{ number_format($trx->total_amount, 2) }}</td>
                                            <td>
                                                @php
                                                    $badgeClass = match ($trx->status) {
                                                        'Pending' => 'bg-warning text-dark',
                                                        'Paid' => 'bg-info',
                                                        'Available' => 'bg-success',
                                                        'Withdrawn' => 'bg-primary',
                                                        'Voided' => 'bg-dark',
                                                        default => 'bg-secondary'
                                                    };
                                                @endphp
                                                <span class="badge {{ $badgeClass }} rounded-pill">
                                                    {{ $trx->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Payouts -->
            <div class="col-12 col-lg-5">
                <div class="card rounded-4 shadow-sm border-0">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0 fw-bold">Recent Payouts</h6>
                            <a href="{{ route('admin.revenue.payouts') }}"
                                class="ms-auto btn btn-sm btn-outline-dark rounded-pill px-3">History</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(count($recentPayouts) > 0)
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Ref</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentPayouts as $payout)
                                            <tr>
                                                <td><small class="text-muted">{{ $payout->reference }}</small></td>
                                                <td class="fw-bold">₦{{ number_format($payout->amount, 2) }}</td>
                                                <td>
                                                    <span
                                                        class="badge {{ $payout->status == 'Paid' ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill">
                                                        {{ $payout->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p class="text-muted small mb-0">No recent payout activity.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
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

                // Revenue Trend Chart - Premium Gradient Area Graph
                const ctx = document.getElementById('revenueTrendChart').getContext('2d');
                const trendData = @json($monthlyTrend);
                const labels = trendData.map(d => {
                    const [y, m] = d.month.split('-');
                    return new Date(y, m - 1).toLocaleString('default', { month: 'short', year: '2-digit' });
                });

                // Create Gradients
                const blueGradient = ctx.createLinearGradient(0, 0, 0, 400);
                blueGradient.addColorStop(0, 'rgba(59, 130, 246, 0.4)');
                blueGradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

                const emeraldGradient = ctx.createLinearGradient(0, 0, 0, 400);
                emeraldGradient.addColorStop(0, 'rgba(16, 185, 129, 0.4)');
                emeraldGradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

                const amberGradient = ctx.createLinearGradient(0, 0, 0, 400);
                amberGradient.addColorStop(0, 'rgba(245, 158, 11, 0.4)');
                amberGradient.addColorStop(1, 'rgba(245, 158, 11, 0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Total Revenue',
                                data: trendData.map(d => parseFloat(d.total)),
                                borderColor: '#3b82f6',
                                backgroundColor: blueGradient,
                                fill: true,
                                tension: 0.45,
                                borderWidth: 3,
                                pointRadius: 2,
                                pointHoverRadius: 6,
                                pointBackgroundColor: '#3b82f6',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                            },
                            {
                                label: 'Admin Earnings',
                                data: trendData.map(d => parseFloat(d.net)),
                                borderColor: '#10b981',
                                backgroundColor: emeraldGradient,
                                fill: true,
                                tension: 0.45,
                                borderWidth: 3,
                                pointRadius: 2,
                                pointHoverRadius: 6,
                                pointBackgroundColor: '#10b981',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                            },
                            @if($isSuperAdmin)
                            {
                                label: 'Portal Fees',
                                data: trendData.map(d => parseFloat(d.fees)),
                                borderColor: '#f59e0b',
                                backgroundColor: amberGradient,
                                fill: true,
                                tension: 0.45,
                                borderWidth: 3,
                                pointRadius: 2,
                                pointHoverRadius: 6,
                                pointBackgroundColor: '#f59e0b',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                            }
                            @endif
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                align: 'end',
                                labels: {
                                    boxWidth: 12,
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    padding: 20,
                                    font: { size: 12, weight: 'bold' }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(17, 24, 39, 0.9)',
                                padding: 12,
                                titleFont: { size: 13, weight: 'bold' },
                                bodyFont: { size: 13 },
                                cornerRadius: 8,
                                displayColors: true,
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) label += ': ';
                                        if (context.parsed.y !== null) {
                                            label += new Intl.NumberFormat('en-NG', {
                                                style: 'currency',
                                                currency: 'NGN',
                                                minimumFractionDigits: 2
                                            }).format(context.parsed.y);
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { font: { size: 11 } }
                            },
                            y: {
                                beginAtZero: true,
                                border: { display: false },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)',
                                    drawBorder: false,
                                    lineWidth: 1,
                                    tickColor: 'transparent'
                                },
                                ticks: {
                                    font: { size: 11 },
                                    callback: v => '₦' + v.toLocaleString(),
                                    padding: 10
                                },
                            },
                        },
                    },
                });
            });
        </script>
    @endpush
@endsection