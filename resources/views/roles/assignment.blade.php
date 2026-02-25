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
                                                            onsubmit="return confirm('Revoke this link?')">
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
                alert("Link copied to clipboard!");
            }, function (err) {
                console.error('Could not copy text: ', err);
            });
        }
    </script>
@endsection