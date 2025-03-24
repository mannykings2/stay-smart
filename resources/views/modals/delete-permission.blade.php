<!-- Modal -->
<div class="modal fade" id="delete-permission" tabindex="-1" role="dialog" aria-labelledby="modal_title" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="display: flex;">
                <h5 id="modal_title" class="modal-title">Delete Permission</h5>
                <div class="ml-auto">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

            </div>
            <div class="modal-body" id="view_card_body">
                Are you sure you want to delete this permission?
            </div>
            <form method="post" id="permission_delete_form">
                @method('DELETE')
                @csrf
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info btn-sm">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
