<!-- Modal -->
<div class="modal fade" id="assign-role" tabindex="-1" role="dialog" aria-labelledby="modal_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="d-flex p-3 justify-content-between">
                <h5 id="modal_title" class="modal-title">Assign Role</h5>
                <div type="button" class="ml-auto" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </div>
            </div>
            <form action="{{route('role-assignment.store')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="subheader text-kdis-2 mb-4">
                        Role For {<span id="username"></span>}
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-2">
                                <label class="">Current Role:</label>
                                <input type="text" name="name" id="current_role" class="form-control" aria-describedby="rolename" required readonly>
                            </div>
                            <div class="form-group">
                                <label class="">New Role:</label>
                                <select name="role_id" class="form-control" required>
                                    <option value="">- Select a Role -</option>
                                    @if($roles)
                                        @foreach($roles as $key => $role)
                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <input type="hidden" id="user_id" name="user_id" value="" />
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
