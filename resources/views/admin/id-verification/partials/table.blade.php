{{-- Shared table partial for ID verification listings --}}
<div class="table-responsive">
    <table class="table table-striped table-bordered align-middle">
        <thead class="bg-light">
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Email</th>
                <th>Role</th>
                <th>Document</th>
                <th>Submitted</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
                    @forelse($verifications as $verification)
                        <tr>
                            <td>{{ $verifications->firstItem() ? $verifications->firstItem() + $loop->index : $loop->iteration }}</td>
                    <td>
                        <strong>{{ $verification->user->first_name ?? '' }} {{ $verification->user->last_name ?? '' }}</strong>
                    </td>
                    <td>{{ $verification->user->email ?? 'N/A' }}</td>
                    <td>
                        @if($verification->user)
                            @foreach($verification->user->roles as $role)
                                <span class="badge bg-info text-white">{{ $role->name }}</span>
                            @endforeach
                            @if($verification->user->roles->isEmpty())
                                <span class="badge bg-secondary">User</span>
                            @endif
                        @endif
                    </td>
                    <td>
                        <small>
                            <i class="bi bi-file-earmark-{{ $verification->document_type === 'pdf' ? 'pdf' : 'image' }}"></i>
                            {{ $verification->original_filename }}
                        </small>
                    </td>
                    <td>{{ $verification->created_at->format('M d, Y') }}</td>
                    <td>
                        @if($verification->isPending())
                            <span class="badge bg-warning text-dark">
                                <i class="bi bi-hourglass-split"></i> Pending
                            </span>
                        @elseif($verification->isVerified())
                            <span class="badge bg-success">
                                <i class="bi bi-patch-check-fill"></i> Verified
                            </span>
                        @elseif($verification->isRejected())
                            <span class="badge bg-danger">
                                <i class="bi bi-x-circle-fill"></i> Rejected
                            </span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            <a href="{{ route('admin.id-verification.show', $verification->id) }}"
                                class="btn btn-sm btn-info text-white" title="View Details">
                                <i class="bi bi-eye-fill"></i> View
                            </a>
                            @if($verification->isPending())
                                <form action="{{ route('admin.id-verification.verify', $verification->id) }}" method="POST"
                                    id="approve-list-form-{{ $verification->id }}" class="confirm-submit" 
                                    data-title="Confirm Approval"
                                    data-message="Are you sure you want to verify this ID?"
                                    data-confirm-text="Yes, verify it!">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" title="Approve">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                                <button type="button" class="btn btn-sm btn-danger" title="Reject"
                                    data-bs-toggle="modal" data-bs-target="#rejectModal{{ $verification->id }}">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-4">{{ $emptyMessage ?? 'No verification requests found.' }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @include('components.pagination', ['paginator' => $verifications])
</div>
