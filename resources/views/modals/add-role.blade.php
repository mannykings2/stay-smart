<!-- Modal -->
<div class="modal fade" id="add-role" tabindex="-1" role="dialog" aria-labelledby="modal_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="d-flex p-3 justify-content-between">
                <h5 id="modal_title" class="modal-title">Create Role</h5>
                <div type="button" class="ml-auto" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </div>
            </div>
            <form action="{{route('roles.store')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Role Name:</label>
                                <input type="text" name="name" class="form-control" placeholder="Admin" aria-describedby="rolename" required>
                            </div>
                        </div>
                        <div class="col-md-12 mt-4 d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-secondary me-2 px-4" data-dismiss="modal" style="font-size: 12px">Close</button>
                            <button type="submit" class="btn btn-first px-4" style="font-size: 12px">Create</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
