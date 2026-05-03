<div class="mb-4">
    <h5 class="mb-3 fw-bold">Platform Settings Overview</h5>
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="alert alert-soft-primary border-0 rounded-4 mb-4">
                <i class="bi bi-info-circle-fill me-2"></i> These settings are managed by the platform. Rates are
                applied automatically to your property earnings.
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Property</th>
                            <th>Applied Rate</th>
                            <th>Type</th>
                            <th>Payout Frequency</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($properties as $property)
                            @php
                                $isOverride = !is_null($property->commission_rate);
                                $rate = $isOverride ? $property->commission_rate : ($globalAdmin->revenueConfig?->commission_rate ?? 10);
                                $type = $property->commission_type ?? 'Percentage';
                            @endphp
                            <tr>
                                <td class="fw-bold">{{ $property->name }}</td>
                                <td>
                                    @if($type == 'Fixed') ₦ @endif{{ $rate }}{{ $type == 'Percentage' ? '%' : '' }}
                                </td>
                                <td>{{ $type }}</td>
                                <td>
                                    @php $freq = $property->payout_frequency ?? $globalAdmin->revenueConfig?->payout_frequency ?? 'On Demand'; @endphp
                                    <span class="badge bg-light text-dark border">{{ $freq }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @include('components.pagination', ['paginator' => $properties])
        </div>
    </div>
</div>
