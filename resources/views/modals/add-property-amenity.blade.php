<!-- New Service Modal -->
<div class="modal fade" id="newAmenityModal" tabindex="-1" aria-labelledby="newAmenityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST" action="{{ route('property.amenity.store') }}">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="newAmenityModalLabel">Add New Amenity</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="amenity_name">Amenity Name</label>
              <input type="text" class="form-control" id="amenity_name" name="name" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save Amenity</button>
          </div>
        </div>
      </form>
    </div>
  </div>

