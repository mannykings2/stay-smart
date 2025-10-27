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
                    <div class="form-group">
                        <label for="driver_service">Driver Service</label>
                        <select id="driver_services" name="driver_service" class="form-control" required></select>
                    </div>
                    <div class="form-group">
                        <label for="pickup_location">Pickup Location</label>
                        <input type="text" id="pickup_location" name="pickup_location" class="form-control" placeholder="Enter pickup location" required>
                    </div>
                    <div class="form-group">
                        <label for="dropoff_location">Drop-off Location</label>
                        <input type="text" id="dropoff_location" name="dropoff_location" class="form-control" placeholder="Enter drop-off location" required>
                    </div>
                    <div class="form-group">
                        <label for="service_date">Date</label>
                        <input type="date" id="service_date" name="service_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="service_time">Time</label>
                        <input type="time" id="service_time" name="service_time" class="form-control" required>
                    </div>
                    <input type="hidden" name="driver_id" id="driver_id" required>
                    <button type="submit" class="btn btn-primary mt-3 px-4">Book Now</button>
                </form>
            </div>
        </div>
    </div>
</div>

