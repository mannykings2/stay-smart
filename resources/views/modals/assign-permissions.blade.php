<!-- Modal -->
<div class="modal fade" id="assign-permission" tabindex="-1" role="dialog" aria-labelledby="modal_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="d-flex p-3 justify-content-between">
                <h5 id="modal_title" class="modal-title">Assign Permissions</h5>
                <div type="button" class="ml-auto" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </div>
            </div>
            <form action="{{route('permission-assignment.store')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="subheader text-kdis-2 mb-4">
                                Permissions For Role: {<span id="role_name"></span>}
                            </div>
                            <div class="loading" style="display: none;">Loading...</div>
                            <div id="permission_body">
                                <div class="form-check">
                                    <input class="form-check-input" name="check_all" type="checkbox" id="check_all_permissions">
                                    <label class="form-check-label" for="check_all_permissions">
                                        Check All Permissions
                                    </label>
                                </div>
                                <hr class="mb-15"/>
                                <div class="row permission-list ml-auto" id="permission_list">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="role_id" name="role_id" value="" />
                        <div class="col-md-12 mt-4 d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-secondary me-2 px-4" data-dismiss="modal" style="font-size: 12px">Close</button>
                            <button type="submit" class="btn btn-first px-4" style="font-size: 12px">Assign</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
