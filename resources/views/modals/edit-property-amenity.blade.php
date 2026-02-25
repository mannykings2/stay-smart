<!-- Edit Amenity Modal -->
<div class="modal fade" id="editAmenityModal" tabindex="-1" aria-labelledby="editAmenityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editAmenityForm" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAmenityModalLabel">Edit Amenity</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_amenity_name">Amenity Name</label>
                        <input type="text" class="form-control" id="edit_amenity_name" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Amenity</button>
                </div>
            </div>
        </form>
    </div>
</div>