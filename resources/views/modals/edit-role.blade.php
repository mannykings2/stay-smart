<!-- Modal -->
<div class="modal fade" id="edit-role" tabindex="-1" role="dialog" aria-labelledby="modal_title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="display: flex;">
                <h5 id="modal_title" class="modal-title">Edit Role</h5>
                <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit-role-form" method="post">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="panel panel-default card-view box-shadow" style="border-radius: 10px;">
                        <div class="panel-heading custom-card-header mb-10">
                            <div class="pull-left">
                                <h6 class="panel-title txt-dark">Role Form</h6>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="mb-0 text-dark">Role Name:</h6>
                                    <div class="form-group">
                                        <input type="text" id="role_name" name="name" class="form-control" placeholder="Role Name" aria-describedby="rolename" required>
                                        <small id="helpId" class="input-help-text text-muted">Enter Role Name</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                <input type="hidden" id="role_id" name="role_id" value="" />
            </form>
        </div>
    </div>
</div>
