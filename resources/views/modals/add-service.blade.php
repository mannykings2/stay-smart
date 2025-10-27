<!-- New Service Modal -->
<div class="modal fade" id="newServiceModal" tabindex="-1" aria-labelledby="newServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST" action="{{ route('chef.service.store') }}">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="newServiceModalLabel">Add New Service</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="service_name">Service Name</label>
              <input type="text" class="form-control" id="service_name" name="name" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save Service</button>
          </div>
        </div>
      </form>
    </div>
  </div>
