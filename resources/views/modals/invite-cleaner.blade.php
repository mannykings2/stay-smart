<!-- Modal -->
<div class="modal fade" id="invite-cleaner" tabindex="-1" role="dialog" aria-labelledby="invite_modal_title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="d-flex p-3 justify-content-between">
                <h5 id="invite_modal_title" class="modal-title">Invite New Cleaner</h5>
                <div type="button" class="ml-auto" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </div>
            </div>
            <form action="{{route('role-assignment.invite')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="">First Name:</label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="">Last Name:</label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-2">
                                <label class="">Email Address:</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-2">
                                <label class="">Phone Number:</label>
                                <input type="text" name="phone_number" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-12 mt-4 d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-secondary me-2 px-4" data-dismiss="modal"
                                style="font-size: 12px">Cancel</button>
                            <button type="submit" class="btn btn-first px-4" style="font-size: 12px">Invite & Assign
                                Role</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>