<!-- Assign Service Modal -->
<div class="modal fade" id="assignServiceModal" tabindex="-1" aria-labelledby="assignServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content px-3">
            <div class="modal-header">
                <h5 class="modal-title" id="assignServiceModalLabel">Assign Service to Driver</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="assignServiceForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="driver_id" id="assign_driver_id">
                    <div class="mb-3">
                        <label for="driver_service" class="form-label">Service</label>
                        <select name="driver_service_id" id="driver_service" class="form-select" required>
                            <option value="">-- Select Service --</option>
                            @foreach($servicesList as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price (₦)</label>
                        <input type="number" name="price" id="price" class="form-control" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Assign</button>
                </div>
            </form>
        </div>
    </div>
</div>

