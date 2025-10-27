$(document).ready(function(){
    $(".message-alert").delay(7000).fadeOut("slow");

    $(document).on('change', '#check_all_permissions', function() {
        var checkAllStatus = $(this).prop('checked');
        $('input[name="permissions[]"]').prop('checked', checkAllStatus);
    });

    $(document).on('change', 'input[name="permissions[]"]', function() {
        var anyUnchecked = $('input[name="permissions[]"]:not(:checked)').length > 0;
        $('#check_all_permissions').prop('checked', !anyUnchecked);
        console.log(anyUnchecked)
    });
});

function viewAssignPermission(id, role_name){
    $('#role_name').html(role_name);
    $('#role_id').val(id);
    $('#assign-permission').modal('show');

    $.ajax({
        url: "/role-permissions/"+id,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        // data: {id: id},
        beforeSend: function(){
            $('#permission_list').html('');
            $('#assign-permission .loading').show();
        },
        success: function(data) {
            //console.log(data);
            if(data && data['all_permissions']){
                var groupedPermissions = {};
                data['all_permissions'].forEach(permission => {
                    var header = permission.name.substring(0, permission.name.lastIndexOf(' '));
                    if (!groupedPermissions[header]) {
                        groupedPermissions[header] = [];
                    }
                    groupedPermissions[header].push(permission);
                });

                var output = '';
                var allPermissionsChecked = true;
                for (const group in groupedPermissions) {
                    if (groupedPermissions.hasOwnProperty(group)) {
                        const groupId = group.replace(/\s+/g, '_');
                        output += `<div class="col-4-width mb-5 permission-item">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label"><h6>${group} ---- </h6></label>
                                            <input class="form-check-input check-all-checkbox" type="checkbox" id="check_all_${groupId}">
                                        </div>
                                    <div class="row">`;

                        groupedPermissions[group].forEach(permission => {
                            output += `<div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input permission-checkbox ${groupId}" name="permissions[]" type="checkbox" value="${permission.id}" id="permission-${permission.id}" ${data['assigned_permissions'].includes(permission.id) ? "checked" : ""}>
                                    <label class="form-check-label" for="permission-${permission.id}">
                                        ${permission.name}
                                    </label>
                                </div>
                            </div>`;

                            if (!data['assigned_permissions'].includes(permission.id)) {
                                allPermissionsChecked = false;
                            }
                        });

                        output += `</div>
                                </div>`;
                    }
                }
                $('#permission_list').html(output);
                initializeMasonry();

                $('.check-all-checkbox').change(function() {
                    var groupId = $(this).attr('id').replace('check_all_', '');
                    $(`.${groupId}`).prop('checked', $(this).prop('checked'));
                });

                var rowHeight = $('#permission_list').height();

                if (rowHeight === 0) {
                    $('#permission_list').css("height", "100%");
                }

                $('#assign-permission .loading').hide();
            }
        }
    });
}

function initializeMasonry() {

    $('.permission-list').masonry({
        itemSelector: '.permission-item',
        columnWidth: '.col-4-width',
        gutter: 16
    });
}

function editPermission(id, name){
    $('#edit-permission-form').attr('action', '/permissions/'+id)
    $('#permission_name').val(name);
    $('#edit-permission').modal('show');
}

function deletePermission(id){
    $('#delete-permission').modal('show');
    $('#permission_delete_form').attr('action', "/permissions/"+id);
}

function viewAssignRole(id, email, role_name){
    if(role_name){
        $('#current_role').val(role_name);
    }
    $('#username').html(email);
    $('#user_id').val(id);
    $('#assign-role').modal('show');
}

function editRole(id, name){
    $('#edit-role-form').attr('action', '/roles/'+id)
    $('#role_name').val(name);
    $('#edit-role').modal('show');
}

function deleteRole(id){
    $('#delete-role').modal('show');
    $('#role_delete_form').attr('action', "/roles/"+id);
}

function addRole(){
    $('#add-role').modal('show');
}

function showSuccessMessage(message) {
    const alertBox = document.createElement("div");
    alertBox.className = "alert alert-success message-alert";
    alertBox.innerHTML = `<i class="fa fa-check-circle"></i> <span class="pl-20 pr-20">${message}</span>`;

    document.body.prepend(alertBox);

    setTimeout(() => {
        alertBox.remove();
    }, 1400);
}
