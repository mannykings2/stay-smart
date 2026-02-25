<!-- Assign Amenity Modal -->
<div class="modal fade" id="assignAmenityModal" tabindex="-1" aria-labelledby="assignAmenityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content px-3">
            <div class="modal-header">
                <h5 class="modal-title" id="assignAmenityModalLabel">Assign Amenity to Apartment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="assignAmenityForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="property_id" id="assign_property_id">
                    <div class="mb-3">
                        <label for="amenity" class="form-label">Amenity</label>
                        <select name="amenity_id" id="amenity" class="form-select" required>
                            <option value="">-- Select Amenity --</option>
                            @foreach($amenities as $amenity)
                                <option value="{{ $amenity->id }}">{{ $amenity->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Assign</button>
                </div>
            </form>
        </div>
    </div>
</div>

