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
                        <li class="breadcrumb-item active" aria-current="page">Settings</li>
                    </ol>
                </nav>
            </div>-->
        </div>

        @if($isSuperAdmin)
            <!-- Subsection 1: Global Platform Settings -->
            <div class="mb-5">
                <h5 class="mb-3 d-flex align-items-center fw-bold">
                    <i class="bi bi-globe me-2 text-primary"></i> Global Platform Settings
                </h5>
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        <form action="{{ route('admin.revenue.settings.update', $globalAdmin->id) }}" method="POST">
                            @csrf
                            <div class="row g-4">
                                <div class="col-md-3">
                                    <label class="form-label small text-muted text-uppercase fw-bold">Default Property
                                        Fee</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="commission_rate"
                                            class="form-control rounded-start-3"
                                            value="{{ $globalAdmin->revenueConfig?->commission_rate ?? 10 }}">
                                        <span class="input-group-text rounded-end-3">%</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small text-muted text-uppercase fw-bold">Default Service
                                        Fee</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="staff_commission_rate"
                                            class="form-control rounded-start-3"
                                            value="{{ $globalAdmin->revenueConfig?->staff_commission_rate ?? 15 }}">
                                        <span class="input-group-text rounded-end-3">%</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small text-muted text-uppercase fw-bold">Payout Frequency</label>
                                    <select name="payout_frequency" class="form-select rounded-3">
                                        <option value="Monthly" {{ ($globalAdmin->revenueConfig?->payout_frequency ?? '') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                        <option value="Quarterly" {{ ($globalAdmin->revenueConfig?->payout_frequency ?? '') == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                                        <option value="Yearly" {{ ($globalAdmin->revenueConfig?->payout_frequency ?? '') == 'Yearly' ? 'selected' : '' }}>
                                            Yearly</option>
                                        <option value="On Demand" {{ ($globalAdmin->revenueConfig?->payout_frequency ?? 'On Demand') == 'On Demand' ? 'selected' : '' }}>On Demand</option>
                                    </select>
                                </div>

                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary rounded-pill px-4">Update Global
                                        Defaults</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @if($isSuperAdmin)
                <!-- Tabbed Overrides Section (Super Admin only) -->
                <div class="mb-5">
                    <ul class="nav nav-pills mb-3 border p-2 rounded-4 bg-light shadow-sm" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active rounded-pill px-4 fw-bold" id="pills-property-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-property" type="button" role="tab" aria-controls="pills-property"
                                aria-selected="true">
                                <i class="bi bi-building me-2"></i>Property Overrides
                            </button>
                        </li>
                        <li class="nav-item ms-2" role="presentation">
                            <button class="nav-link rounded-pill px-4 fw-bold" id="pills-vendor-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-vendor" type="button" role="tab" aria-controls="pills-vendor"
                                aria-selected="false">
                                <i class="bi bi-person-badge me-2"></i>Vendor Overrides
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content pt-3" id="pills-tabContent">
                        <!-- Tab 1: Property Overrides -->
                        <div class="tab-pane fade show active" id="pills-property" role="tabpanel"
                            aria-labelledby="pills-property-tab">
                            <h5 class="mb-3 fw-bold text-dark">Property Commission Overrides</h5>
                            <div class="card shadow-sm border-0 rounded-4">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Property</th>
                                                    <th>Owner</th>
                                                    <th style="width: 200px;">Override Rate</th>
                                                    <th style="width: 140px;">Type</th>
                                                    <th style="width: 180px;">Payout Frequency</th>
                                                    <th class="text-end">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($properties as $property)
                                                    <tr>
                                                        <td><strong>{{ $property->name }}</strong></td>
                                                        <td><small>{{ $property->user->first_name ?? 'N/A' }}</small></td>
                                                        <form action="{{ route('admin.revenue.settings.property', $property->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <td>
                                                                <div class="input-group input-group-sm">
                                                                    <input type="number" step="0.01" name="commission_rate"
                                                                        class="form-control rounded-start-3"
                                                                        value="{{ $property->commission_rate }}"
                                                                        placeholder="Inherit ({{ $globalAdmin->revenueConfig?->commission_rate ?? 10 }}%)">
                                                                    <span
                                                                        class="input-group-text rounded-end-3">{{ $property->commission_type == 'Fixed' ? '₦' : '%' }}</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <select name="commission_type"
                                                                    class="form-select form-select-sm rounded-3">
                                                                    <option value="Percentage" {{ $property->commission_type == 'Percentage' ? 'selected' : '' }}>
                                                                        Percentage</option>
                                                                    <option value="Fixed" {{ $property->commission_type == 'Fixed' ? 'selected' : '' }}>Fixed Amount</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="payout_frequency"
                                                                    class="form-select form-select-sm rounded-3">
                                                                    <option value="">Inherit
                                                                        ({{ $globalAdmin->revenueConfig?->payout_frequency ?? 'On Demand' }})</option>
                                                                    <option value="On Demand" {{ $property->payout_frequency == 'On Demand' ? 'selected' : '' }}>On Demand</option>
                                                                    <option value="Monthly" {{ $property->payout_frequency == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                                                    <option value="Quarterly" {{ $property->payout_frequency == 'Quarterly' ? 'selected' : '' }}>
                                                                        Quarterly</option>
                                                                    <option value="Yearly" {{ $property->payout_frequency == 'Yearly' ? 'selected' : '' }}>Yearly</option>
                                                                </select>
                                                            </td>
                                                            <td class="text-end">
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-primary rounded-pill px-3">Save</button>
                                                            </td>
                                                        </form>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @include('components.pagination', ['paginator' => $properties])
                                </div>
                            </div>
                        </div>

                        <!-- Tab 2: Vendor Overrides -->
                        <div class="tab-pane fade" id="pills-vendor" role="tabpanel" aria-labelledby="pills-vendor-tab">
                            <h5 class="mb-3 fw-bold text-dark">Vendor Service Overrides</h5>
                            <div class="row g-4">
                                <!-- Chefs -->
                                <div class="col-12 col-xl-6">
                                    <div class="card shadow-sm border-0 rounded-4">
                                        <div class="card-header bg-transparent py-3">
                                            <h6 class="mb-0 fw-bold">Chefs</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-sm align-middle">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Rate</th>
                                                            <th style="width: 80px;">Type</th>
                                                            <th class="text-end"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($chefs as $chef)
                                                            <tr>
                                                                <td><small>{{ $chef->first_name }} {{ $chef->last_name }}</small></td>
                                                                <form action="{{ route('admin.revenue.settings.chef', $chef->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <td>
                                                                        <input type="number" step="0.01" name="commission_rate"
                                                                            class="form-control form-control-sm rounded-3"
                                                                            value="{{ $chef->commission_rate }}"
                                                                            placeholder="{{ $globalAdmin->revenueConfig?->staff_commission_rate ?? 15 }}%">
                                                                    </td>
                                                                    <td>
                                                                        <select name="commission_type"
                                                                            class="form-select form-select-sm rounded-3 p-1">
                                                                            <option value="Percentage" {{ $chef->commission_type == 'Percentage' ? 'selected' : '' }}>%</option>
                                                                            <option value="Fixed" {{ $chef->commission_type == 'Fixed' ? 'selected' : '' }}>₦</option>
                                                                        </select>
                                                                    </td>
                                                                    <td class="text-end">
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-link text-primary p-0"><i
                                                                                class="bi bi-check-circle"></i></button>
                                                                    </td>
                                                                </form>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @include('components.pagination', ['paginator' => $chefs])
                                        </div>
                                    </div>
                                </div>

                                <!-- Drivers -->
                                <div class="col-12 col-xl-6">
                                    <div class="card shadow-sm border-0 rounded-4">
                                        <div class="card-header bg-transparent py-3">
                                            <h6 class="mb-0 fw-bold">Drivers</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-sm align-middle">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Rate</th>
                                                            <th style="width: 80px;">Type</th>
                                                            <th class="text-end"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($drivers as $driver)
                                                            <tr>
                                                                <td><small>{{ $driver->first_name }} {{ $driver->last_name }}</small>
                                                                </td>
                                                                <form action="{{ route('admin.revenue.settings.driver', $driver->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <td>
                                                                        <input type="number" step="0.01" name="commission_rate"
                                                                            class="form-control form-control-sm rounded-3"
                                                                            value="{{ $driver->commission_rate }}"
                                                                            placeholder="{{ $globalAdmin->revenueConfig?->staff_commission_rate ?? 15 }}%">
                                                                    </td>
                                                                    <td>
                                                                        <select name="commission_type"
                                                                            class="form-select form-select-sm rounded-3 p-1">
                                                                            <option value="Percentage" {{ $driver->commission_type == 'Percentage' ? 'selected' : '' }}>%</option>
                                                                            <option value="Fixed" {{ $driver->commission_type == 'Fixed' ? 'selected' : '' }}>₦</option>
                                                                        </select>
                                                                    </td>
                                                                    <td class="text-end">
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-link text-primary p-0"><i
                                                                                class="bi bi-check-circle"></i></button>
                                                                    </td>
                                                                </form>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @include('components.pagination', ['paginator' => $drivers])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- Non-Super Admin: Just Property List Overview --}}
                @include('admin.revenue.partials.admin_settings_overview')
            @endif
            </div>
        @else
            {{-- Regular Admin View: Platform Settings Overview --}}
            @include('admin.revenue.partials.admin_settings_overview')
        @endif

        {{-- Audit Trail (Super Admin Only) --}}
        @if($isSuperAdmin && $auditLogs->count() > 0)
            <div class="mt-4">
                <div class="card rounded-4 shadow-sm border-0">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex align-items-center"
                         data-bs-toggle="collapse" data-bs-target="#auditTrail" role="button" aria-expanded="false">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2"></i>Recent Settings Changes</h6>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </div>
                    <div id="auditTrail" class="collapse">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>Changed By</th>
                                            <th>Entity</th>
                                            <th>Field</th>
                                            <th>Old</th>
                                            <th>New</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($auditLogs as $log)
                                            <tr>
                                                <td><small class="text-muted">{{ $log->created_at->format('M d, Y H:i') }}</small></td>
                                                <td>{{ $log->changedByUser?->first_name ?? 'System' }}</td>
                                                <td>
                                                    <span class="badge bg-light text-dark border">
                                                        {{ ucfirst($log->entity_type) }}
                                                        @if($log->entity_id) #{{ $log->entity_id }} @endif
                                                    </span>
                                                </td>
                                                <td><code>{{ str_replace('_', ' ', $log->field_changed) }}</code></td>
                                                <td><span class="text-danger">{{ $log->old_value ?? '—' }}</span></td>
                                                <td><span class="text-success">{{ $log->new_value ?? '—' }}</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        </main>
        @push('js')
            <script>
                    $(function () {
                        // Restore active tab from localStor                age
                                const activeTab = localStorage.getItem('revenue_settings_active_tab');
                                if (activeTab) {
                                    const tabEl = document.querySelector(`#${activeTab}`);
                                    if (tabEl) {
                                        const tab = new bootstrap.Tab(tabEl);
                                        tab.show();
                                    }
                                }

                                // Save active tab to localStorage on change
                                const tabs = document.querySelectorAll('button[data-bs-toggle="pill"]');
                                tabs.forEach(tab => {
                                    tab.addEventListener('shown.bs.tab', (event) => {
                                        localStorage.setItem('revenue_settings_active_tab', event.target.id);
                                    });
                                });
                            });
                        </script>
        @endpush
@endsection