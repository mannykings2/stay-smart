@extends('layouts.app', [$activePage = 'Assign Role'])

@section('content')
    <!-- Row -->
    @include('modals.assign-role', ['roles' => $roles])
    <main class="page-content">
        <div class="container">
            @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super Admin'))
                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div
                            class="card border-0 shadow-sm p-3 p-md-4 h-100 bg-kdis-2 text-white overflow-hidden position-relative">
                            <i class="bx bx-user-plus position-absolute"
                                style="font-size: 15rem; right: -2rem; bottom: -3rem; opacity: 0.1;"></i>
                            <div class="position-relative">
                                <h6 class="text-uppercase fw-bold text-muted mb-3" style="letter-spacing: 1px;">Invite New Team
                                    Member</h6>
                                <p class="small mb-4 text-muted">Select a role and generate a secure, one-time use invitation
                                    link. Share it with your staff so they can claim their role privately.</p>

                                <form action="{{ route('invitations.generate') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <select name="role" class="form-control form-control-sm bg-white border-dark text-dark"
                                            required style="font-size: 0.8rem;">
                                            <option value="">Select Role...</option>
                                            @foreach($invitationRoles as $role)
                                                <option value="{{ $role }}">{{ $role }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <input type="email" name="email"
                                            class="form-control form-control-sm bg-white border-dark text-dark"
                                            placeholder="Enter email to send invite (optional)..." style="font-size: 0.8rem;">
                                    </div>
                                    <button type="submit" class="btn btn-light rounded-pill px-4 fw-bold">
                                        <i class="bx bx-link me-2"></i>Generate & Send Link
                                    </button>
                                </form>

                                @if(session('invite_link'))
                                    <div class="mt-4 p-3 bg-white bg-opacity-10 rounded-4 border border-white border-opacity-25">
                                        <div class="small fw-bold mb-2">Invite Link Generated:</div>
                                        <div class="input-group input-group-sm">
                                            <input type="text" value="{{ session('invite_link') }}"
                                                class="form-control bg-transparent text-white border-white border-opacity-25"
                                                readonly id="inviteLinkInput">
                                            <button class="btn btn-outline-light" type="button"
                                                onclick="copyText('{{ session('invite_link') }}')">
                                                <i class="bx bx-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm p-3 p-md-4 h-100 bg-white">
                            <h6 class="text-uppercase fw-bold text-dark opacity-50 mb-3" style="letter-spacing: 1px;">All
                                Invitations</h6>
                            <div class="table-responsive">
                                <table class="table table-sm align-middle mb-0">
                                    <thead>
                                        <tr class="text-muted" style="font-size: 0.7rem;">
                                            <th>SHARE</th>
                                            <th>EMAIL</th>
                                            <th>ROLE</th>
                                            <th>STATUS</th>
                                            <th>EXPIRES</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 0.8rem;">
                                        @forelse($pendingInvitations as $invite)
                                            <tr>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary p-1 border-0"
                                                        onclick="copyText('{{ route('invite.accept', $invite->token) }}')"
                                                        title="Copy Entire Link">
                                                        <i class="bx bx-copy-alt" style="font-size: 1.1rem;"></i>
                                                    </button>
                                                    <code class="ms-1 text-muted small"
                                                        style="opacity: 0.6;">{{ substr($invite->token, 0, 8) }}...</code>
                                                </td>
                                                <td>
                                                    @if($invite->email)
                                                        <span class="text-dark small fw-bold">{{ $invite->email }}</span>
                                                    @else
                                                        <span class="text-muted small italic">Any</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $invite->role }}</span>
                                                </td>
                                                <td>
                                                    @if($invite->isClaimed())
                                                        <span class="badge bg-success">Claimed</span>
                                                    @elseif($invite->isExpired())
                                                        <span class="badge bg-danger">Expired</span>
                                                    @else
                                                        <span class="badge bg-warning">Pending</span>
                                                    @endif
                                                </td>
                                                <td class="text-muted">
                                                    {{ $invite->expires_at->diffForHumans() }}
                                                </td>
                                                <td>
                                                    @if(!$invite->isClaimed() && !$invite->isExpired())
                                                        <form action="{{ route('invitations.destroy', $invite->id) }}" method="POST"
                                                            class="confirm-submit" data-message="Are you sure you want to revoke this invitation link?">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger p-1 border-0">
                                                                <i class="bx bx-trash" style="font-size: 1rem;"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-muted small">N/A</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4 text-muted small italic">No invitations
                                                    found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm p-3">
                        <h5 class="text-kdis-2 subheader">Team Members</h5>
                        <div class="table-responsive">
                            <table class="table mDatatable table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Firstname</th>
                                        <th>Lastname</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th class="d-none d-md-table-cell">Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Firstname</th>
                                        <th>Lastname</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th class="d-none d-md-table-cell">Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody style="font-size: 12px">
                                    @if ($users)
                                        @foreach ($users as $key => $user)
                                            @php
                                                $createdAt = $user->created_at;
                                                $formattedDate = ($createdAt->isToday()) ? 'Today' : (($createdAt->isYesterday()) ? 'Yesterday' : $createdAt->format('M d'));
                                                $formattedDateTime = $createdAt->format('h:i A');
                                            @endphp
                                            <tr>
                                                <td>{{$key + 1}}</td>
                                                <td>{{$user->first_name}}</td>
                                                <td>{{$user->last_name}}</td>
                                                <td>{{$user->email}}</td>
                                                <td>
                                                    @foreach($user->getRoleNames() as $key => $val)
                                                        <span>{{$val}}</span>
                                                    @endforeach
                                                </td>
                                                <td class="d-none d-md-table-cell" style="font-size: 11px;">{{$formattedDate}},
                                                    {{$formattedDateTime}}</td>
                                                <td class="action-btn">
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        @if($user->hasRole('Admin') || $user->hasRole('Cleaner'))
                                                            <a class="btn btn-outline-primary btn-sm" href="javascript:void(0);"
                                                                onclick="openPropertyModal({{ $user->id }}, '{{ $user->first_name }} {{ $user->last_name }}')"
                                                                title="Manage Properties">
                                                                <i class="bx bx-building-house ms-0"></i>
                                                            </a>
                                                        @endif
                                                        <a class="btn btn-dark btn-sm" href="javascript:void(0);"
                                                            onclick="viewAssignRole({{$user->id}}, '{{$user->email}}', '{{count($user->getRoleNames()) > 0 ? $user->getRoleNames()[0] : ''}}')"
                                                            role="button">
                                                            <i class="bx bx-plus ms-0"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @if(auth()->user()->hasRole('Super Admin') && $allUsers->count() > 0)
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card shadow-sm p-3">
                            <h5 class="text-kdis-2 subheader">All Users</h5>
                            <p class="text-muted small mb-3">Assign roles to registered users who don't currently have Admin or
                                Cleaner roles.</p>
                            <div class="table-responsive">
                                <table class="table mDatatable table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Firstname</th>
                                            <th>Lastname</th>
                                            <th>Email</th>
                                            <th>Current Role</th>
                                            <th class="d-none d-md-table-cell">Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Firstname</th>
                                            <th>Lastname</th>
                                            <th>Email</th>
                                            <th>Current Role</th>
                                            <th class="d-none d-md-table-cell">Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody style="font-size: 12px">
                                        @if ($allUsers)
                                            @foreach ($allUsers as $key => $user)
                                                @php
                                                    $createdAt = $user->created_at;
                                                    $formattedDate = ($createdAt->isToday()) ? 'Today' : (($createdAt->isYesterday()) ? 'Yesterday' : $createdAt->format('M d'));
                                                    $formattedDateTime = $createdAt->format('h:i A');
                                                @endphp
                                                <tr>
                                                    <td>{{$key + 1}}</td>
                                                    <td>{{$user->first_name}}</td>
                                                    <td>{{$user->last_name}}</td>
                                                    <td>{{$user->email}}</td>
                                                    <td>
                                                        @if(count($user->getRoleNames()) > 0)
                                                            @foreach($user->getRoleNames() as $key => $val)
                                                                <span>{{$val}}</span>
                                                            @endforeach
                                                        @else
                                                            <span class="text-muted">No Role</span>
                                                        @endif
                                                    </td>
                                                    <td class="d-none d-md-table-cell" style="font-size: 11px;">{{$formattedDate}},
                                                        {{$formattedDateTime}}</td>
                                                    <td class="action-btn">
                                                        <div class="btn-group btn-group-sm" role="group">
                                                            <a class="btn btn-primary btn-sm" href="javascript:void(0);"
                                                                onclick="viewAssignRole({{$user->id}}, '{{$user->email}}', '{{count($user->getRoleNames()) > 0 ? $user->getRoleNames()[0] : ''}}')"
                                                                role="button">
                                                                <i class="bx bx-plus ms-0"></i> Assign Role
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>

    <script>
        function copyText(text) {
            navigator.clipboard.writeText(text).then(function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Copied!',
                    text: 'Link copied to clipboard',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            }, function (err) {
                console.error('Could not copy text: ', err);
            });
        }
    </script>

    {{-- Property Assignment Modal --}}
    <div class="modal fade" id="propertyModal" tabindex="-1" aria-labelledby="propertyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-kdis-2 text-white">
                    <h6 class="modal-title" id="propertyModalLabel">
                        <i class="bx bx-building-house me-2"></i><span id="propModalTitle">Manage Properties</span> — <span id="propModalUserName"></span>
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-3">
                    <div id="propModalLoading" class="text-center py-4">
                        <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                        <span class="ms-2 text-muted">Loading properties...</span>
                    </div>
                    
                    <div id="propModalContent" style="display:none;">
                        {{-- Mode Info Alert --}}
                        <div class="alert alert-info py-2 px-3 mb-3 border-0 rounded-4" style="font-size: 0.75rem;">
                            <i class="bx bx-info-circle me-1"></i>
                            <span id="modeDescription"></span>
                        </div>

                        <div class="row g-3">
                            {{-- Assigned --}}
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="fw-bold text-success mb-0" style="font-size:0.85rem;">
                                        <i class="bx bx-check-circle me-1"></i>Selected
                                        <span class="badge bg-success rounded-pill ms-1" id="assignedCount">0</span>
                                    </h6>
                                </div>
                                <div id="assignedList" class="border rounded-4 p-2" style="min-height:200px;max-height:350px;overflow-y:auto;background:#f8fdf8;">
                                    <p class="text-muted small text-center py-4" id="noAssigned">No properties selected</p>
                                </div>
                            </div>
                            {{-- Available --}}
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="fw-bold text-secondary mb-0" style="font-size:0.85rem;">
                                        <i class="bx bx-list-ul me-1"></i>Available
                                        <span class="badge bg-secondary rounded-pill ms-1" id="availableCount">0</span>
                                    </h6>
                                </div>
                                <input type="text" class="form-control form-control-sm rounded-pill mb-2 border-light bg-light" id="propSearch" placeholder="Search properties...">
                                <div id="availableList" class="border rounded-4 p-2" style="min-height:200px;max-height:310px;overflow-y:auto;">
                                    <p class="text-muted small text-center py-4" id="noAvailable">No available properties</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm" id="propSaveBtn" onclick="savePropertyAssignments()">
                        <i class="bx bx-save me-1"></i>Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let propModalUserId = null;
        let propModalMode = 'staff'; // Automatically set based on role
        let currentAssignedIds = new Set();
        let allPropertiesList = [];

        function openPropertyModal(userId, userName) {
            propModalUserId = userId;
            document.getElementById('propModalUserName').textContent = userName;
            document.getElementById('propModalLoading').style.display = '';
            document.getElementById('propModalContent').style.display = 'none';
            
            const modal = new bootstrap.Modal(document.getElementById('propertyModal'));
            modal.show();

            fetch(`/role-assignment/${userId}/properties`, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(data => {
                allPropertiesList = data.available;
                const titleEl = document.getElementById('propModalTitle');
                const descEl = document.getElementById('modeDescription');

                if (data.user.is_admin) {
                    propModalMode = 'ownership';
                    currentAssignedIds = new Set(data.owned.map(p => p.id));
                    titleEl.innerHTML = '<i class="bx bx-shield-quarter me-1"></i>Manage Ownership';
                    descEl.innerHTML = 'Assign properties for <strong>ownership/management</strong>. This Admin will be responsible for these apartments.';
                } else {
                    propModalMode = 'staff';
                    currentAssignedIds = new Set(data.staff.map(p => p.id));
                    titleEl.innerHTML = '<i class="bx bx-user-check me-1"></i>Assign Cleaning Duties';
                    descEl.innerHTML = 'Assign properties for <strong>cleaning/staff duties</strong>. This does NOT change property ownership.';
                }

                renderPropertyLists();
                document.getElementById('propModalLoading').style.display = 'none';
                document.getElementById('propModalContent').style.display = '';
            })
            .catch(err => {
                console.error(err);
                document.getElementById('propModalLoading').innerHTML = '<span class="text-danger">Failed to load properties.</span>';
            });
        }

        function renderPropertyLists() {
            const assignedEl = document.getElementById('assignedList');
            const availableEl = document.getElementById('availableList');
            assignedEl.innerHTML = '';
            availableEl.innerHTML = '';

            let assignedCount = 0, availableCount = 0;

            allPropertiesList.forEach(p => {
                const isAssigned = currentAssignedIds.has(p.id);
                const item = createPropertyItem(p, isAssigned);
                if (isAssigned) {
                    assignedEl.appendChild(item);
                    assignedCount++;
                } else {
                    availableEl.appendChild(item);
                    availableCount++;
                }
            });

            document.getElementById('assignedCount').textContent = assignedCount;
            document.getElementById('availableCount').textContent = availableCount;

            if (assignedCount === 0) {
                assignedEl.innerHTML = '<p class="text-muted small text-center py-4">No properties selected</p>';
            }
            if (availableCount === 0) {
                availableEl.innerHTML = '<p class="text-muted small text-center py-4">All properties available</p>';
            }
        }

        function createPropertyItem(property, isAssigned) {
            const div = document.createElement('div');
            div.className = `d-flex align-items-center justify-content-between p-2 mb-2 rounded-4 prop-item ${isAssigned ? 'bg-success bg-opacity-10 border border-success border-opacity-25' : 'bg-white border'}`;
            div.dataset.name = (property.name + ' ' + (property.address || '') + ' ' + (property.city || '')).toLowerCase();

            let ownerInfo = '';
            if (propModalMode === 'staff' && property.owner_name) {
                ownerInfo = `<div class="text-muted" style="font-size:0.65rem;"><i class="bx bx-user" style="font-size:0.6rem;"></i> Owner: <strong>${property.owner_name}</strong></div>`;
            } else if (propModalMode === 'ownership' && !isAssigned && property.owner_name) {
                 ownerInfo = `<div class="text-muted" style="font-size:0.65rem;"><i class="bx bx-transfer" style="font-size:0.6rem;"></i> Current Owner: <strong>${property.owner_name}</strong></div>`;
            }

            div.innerHTML = `
                <div class="me-2" style="min-width:0;">
                    <div class="fw-bold small text-truncate" style="font-size:0.8rem;">${property.name}</div>
                    <div class="text-muted" style="font-size:0.65rem;">${property.address || ''}, ${property.city || ''}</div>
                    ${ownerInfo}
                </div>
                <button class="btn btn-sm ${isAssigned ? 'btn-danger' : 'btn-success'} rounded-circle p-0" style="width:24px;height:24px;"
                    onclick="toggleProperty(${property.id}, ${isAssigned ? 'true' : 'false'})">
                    <i class="bx ${isAssigned ? 'bx-x' : 'bx-plus'}"></i>
                </button>
            `;
            return div;
        }

        function toggleProperty(propertyId, currentlyAssigned) {
            if (currentlyAssigned) {
                currentAssignedIds.delete(propertyId);
            } else {
                currentAssignedIds.add(propertyId);
            }
            renderPropertyLists();
        }

        // Search filter
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('propSearch');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const term = this.value.toLowerCase();
                    document.querySelectorAll('#availableList .prop-item').forEach(item => {
                        item.style.display = item.dataset.name.includes(term) ? '' : 'none';
                    });
                });
            }
        });

        function savePropertyAssignments(forceOverwrite = false) {
            const btn = document.getElementById('propSaveBtn');
            const originalHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Saving...';

            const payload = { 
                property_ids: Array.from(currentAssignedIds),
                type: propModalMode 
            };
            if (forceOverwrite) payload.force = true;

            fetch(`/role-assignment/${propModalUserId}/properties`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(payload)
            })
            .then(r => r.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = originalHtml;

                if (data.conflicts) {
                    // Show conflict confirmation dialog
                    let conflictHtml = '<div class="mb-3"><strong>Ownership conflict:</strong></div>';
                    conflictHtml += '<div class="list-group mb-3">';
                    data.conflict_details.forEach(c => {
                        conflictHtml += `<div class="list-group-item list-group-item-warning d-flex justify-content-between align-items-center py-2 border-0 mb-1 rounded-4">
                            <div class="small"><i class="bx bx-building-house me-1"></i><strong>${c.name}</strong></div>
                            <span class="badge bg-dark rounded-pill" style="font-size:0.6rem;">Owned by: ${c.current_owner}</span>
                        </div>`;
                    });
                    conflictHtml += '</div>';
                    conflictHtml += '<p class="text-muted small">Transfer ownership of these properties to this admin?</p>';

                    const modalContent = document.getElementById('propModalContent');
                    const conflictDiv = document.createElement('div');
                    conflictDiv.id = 'conflictDialog';
                    conflictDiv.className = 'mt-3 p-3 border border-warning rounded-4 bg-warning bg-opacity-10';
                    conflictDiv.innerHTML = conflictHtml + `
                        <div class="d-flex gap-2 justify-content-end mt-2">
                            <button class="btn btn-sm btn-light rounded-pill px-3" onclick="document.getElementById('conflictDialog').remove();">Cancel</button>
                            <button class="btn btn-sm btn-warning rounded-pill px-3" onclick="document.getElementById('conflictDialog').remove(); savePropertyAssignments(true);">
                                <i class="bx bx-transfer me-1"></i>Confirm Transfer
                            </button>
                        </div>
                    `;
                    const prev = document.getElementById('conflictDialog');
                    if (prev) prev.remove();
                    modalContent.appendChild(conflictDiv);
                    conflictDiv.scrollIntoView({ behavior: 'smooth' });
                    return;
                }

                if (data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('propertyModal')).hide();
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false,
                        customClass: { popup: 'rounded-4 border-0 shadow' }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to save assignments.',
                        customClass: { popup: 'rounded-4 border-0 shadow' }
                    });
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'System Error',
                    text: 'An unexpected error occurred. Please try again.',
                    customClass: { popup: 'rounded-4 border-0 shadow' }
                });
            });
        }
    </script>

@endsection