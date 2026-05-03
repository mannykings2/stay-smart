<!-- Assign Service Modal -->
<div class="modal fade" id="assignServiceModal" tabindex="-1" aria-labelledby="assignServiceModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content px-3">
            <div class="modal-header">
                <h5 class="modal-title" id="assignServiceModalLabel">Assign Service to Chef</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="assignServiceForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="chef_id" id="assign_chef_id">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>Service</th>
                                    <th>Base Price (₦)</th>
                                    <th>Per Person (₦)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($servicesList as $service)
                                    @php
                                        // We will need to pass the current assignments to the modal for pre-checking
                                        // For now, let's just show the list
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="services[{{ $service->id }}][selected]" value="1"
                                                class="form-check-input">
                                        </td>
                                        <td>{{ $service->name }}</td>
                                        <td>
                                            <input type="number" name="services[{{ $service->id }}][base_price]"
                                                class="form-control form-control-sm" placeholder="Base">
                                        </td>
                                        <td>
                                            <input type="number" name="services[{{ $service->id }}][per_unit_price]"
                                                class="form-control form-control-sm" placeholder="Per Person">
                                        </td>
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