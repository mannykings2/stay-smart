<!-- Modal for booking -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">Book a Chef</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="bookingForm">
                    <div class="form-group mb-3">
                        <label for="chef_service">Chef Service</label>
                        <select id="chef_services" name="chef_service" class="form-control" required></select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label for="service_date">Date</label>
                            <input type="date" id="service_date" name="service_date" class="form-control" required>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="service_time">Time</label>
                            <input type="time" id="service_time" name="service_time" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="number_of_guests">Number of Guests</label>
                        <input type="number" id="number_of_guests" name="number_of_guests" class="form-control" min="1"
                            value="1" required>
                        <small class="text-muted" id="chef_max_guests_hint"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="dietary_requirements">Dietary Requirements</label>
                        <textarea id="dietary_requirements" name="dietary_requirements" class="form-control" rows="2"
                            placeholder="e.g. Allergies, Vegan"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="menu_notes">Menu Notes</label>
                        <textarea id="menu_notes" name="menu_notes" class="form-control" rows="2"
                            placeholder="Special requests or dishes"></textarea>
                    </div>
                    <input type="hidden" name="chef_id" id="chef_id" required>
                    <div class="alert alert-info py-2" id="chef_price_alert" style="display:none;">
                        <strong>Estimated Price: </strong> <span id="chef_price_display">₦0</span>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2 w-100">Schedule Service</button>
                </form>
            </div>
        </div>
    </div>
</div>