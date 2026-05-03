<!-- Assign Service Modal -->
<div class="modal fade" id="assignServiceModal" tabindex="-1" aria-labelledby="assignServiceModalLabel"
    aria-hidden="true">
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
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>Service</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($servicesList as $service)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="services[{{ $service->id }}][selected]" value="1"
                                                class="form-check-input">
                                        </td>
                                        <td>{{ $service->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Assignments</button>
                </div>
            </form>
        </div>
    </div>
</div>