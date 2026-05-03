<!-- Modal for booking -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">Book a Driver</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="bookingForm">
                    <div class="form-group mb-3">
                        <label for="driver_service">Driver Service</label>
                        <select id="driver_services" name="driver_service" class="form-control" required></select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label for="pickup_location">Pickup Location</label>
                            <input type="text" id="pickup_location" name="pickup_location" class="form-control"
                                placeholder="Enter pickup location" required>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="dropoff_location">Drop-off Location</label>
                            <input type="text" id="dropoff_location" name="dropoff_location" class="form-control"
                                placeholder="Enter drop-off location" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 form-group mb-3">
                            <label for="ride_date">Date</label>
                            <input type="date" id="ride_date" name="ride_date" class="form-control" required>
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label for="ride_time">Time</label>
                            <input type="time" id="ride_time" name="ride_time" class="form-control" required>
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label for="ride_duration_hours">Duration (Hrs)</label>
                            <input type="number" id="ride_duration_hours" name="ride_duration_hours"
                                class="form-control" min="1" value="1" required>
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label for="occupants">Occupants</label>
                            <input type="number" id="occupants" name="occupants" class="form-control" min="1" value="1"
                                required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group mb-3">
                            <label for="luggage_count">Luggage Count</label>
                            <input type="number" id="luggage_count" name="luggage_count" class="form-control" min="0"
                                value="0">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="special_instructions">Special Instructions</label>
                        <textarea id="special_instructions" name="special_instructions" class="form-control" rows="2"
                            placeholder="e.g. child seat, extra stops"></textarea>
                    </div>
                    <input type="hidden" name="driver_id" id="driver_id" required>
                    <div class="alert alert-info py-2" id="driver_price_alert" style="display:none;">
                        <strong>Estimated Price: </strong> <span id="driver_price_display">₦0</span>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2 w-100">Schedule Ride</button>
                </form>
            </div>
        </div>
    </div>
</div>