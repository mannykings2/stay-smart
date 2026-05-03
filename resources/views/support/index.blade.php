@extends('layouts.app')

@section('activePage', 'Support')

@section('content')
    <main class="page-content">
        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Support</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="/home"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Support Center</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
                <div class="text-white">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- FAQ Section -->
        <div class="card rounded-4">
            <div class="card-header border-0 shadow-none bg-transparent d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Frequently Asked Questions</h5>
                @if (auth()->user()->hasRole('Super Admin'))
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addFaqModal">
                        <i class="bi bi-plus-circle"></i> Add FAQ
                    </button>
                @endif
            </div>
            <div class="card-body">
                <div class="accordion accordion-flush" id="accordionFAQ">
                    @forelse ($faqs as $faq)
                        <div class="accordion-item {{ $loop->first ? 'border-top' : '' }}">
                            <h2 class="accordion-header d-flex align-items-center" id="flush-heading{{ $faq->id }}">
                                <button class="accordion-button collapsed flex-grow-1" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapse{{ $faq->id }}" aria-expanded="false"
                                    aria-controls="flush-collapse{{ $faq->id }}">
                                    {{ $faq->question }}
                                </button>
                                @if (auth()->user()->hasRole('Super Admin'))
                                    <div class="px-3 d-flex gap-2">
                                        <a href="javascript:;" class="text-primary" data-bs-toggle="modal"
                                            data-bs-target="#editFaqModal{{ $faq->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('support.faqs.destroy', $faq) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this FAQ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="border-0 bg-transparent text-danger p-0">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Edit FAQ Modal -->
                                    <div class="modal fade" id="editFaqModal{{ $faq->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content text-start">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit FAQ</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('support.faqs.update', $faq) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Question</label>
                                                            <input type="text" name="question" class="form-control"
                                                                value="{{ $faq->question }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Answer</label>
                                                            <textarea name="answer" class="form-control" rows="4" required>{{ $faq->answer }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Order</label>
                                                            <input type="number" name="order" class="form-control"
                                                                value="{{ $faq->order }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </h2>
                            <div id="flush-collapse{{ $faq->id }}" class="accordion-collapse collapse"
                                aria-labelledby="flush-heading{{ $faq->id }}" data-bs-parent="#accordionFAQ">
                                <div class="accordion-body">
                                    {{ $faq->answer }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            No FAQs available yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        @if (auth()->user()->hasRole('Super Admin'))
            <!-- Add FAQ Modal -->
            <div class="modal fade" id="addFaqModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New FAQ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('support.faqs.store') }}" method="POST">
                            @csrf
                            <div class="modal-body text-start">
                                <div class="mb-3">
                                    <label class="form-label">Question</label>
                                    <input type="text" name="question" class="form-control"
                                        placeholder="e.g., How to book?" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Answer</label>
                                    <textarea name="answer" class="form-control" rows="4" placeholder="Provide the answer..." required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Order</label>
                                    <input type="number" name="order" class="form-control" value="0">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add FAQ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        @if (auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Cleaner'))
            <!-- Tickets Management Section -->
            <div class="card rounded-4">
                <div class="card-header border-0 p-4">
                    <h5 class="mb-0">Support Tickets</h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>#</th>
                                    <th>Subject</th>
                                    <th>Sender</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Assigned To</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($tickets) > 0)
                                    @foreach ($tickets as $ticket)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="fw-bold">{{ $ticket->subject }}</div>
                                                <small class="text-muted">{{ \Illuminate\Support\Str::limit($ticket->message, 50) }}</small>
                                            </td>
                                            <td>{{ optional($ticket->user)->first_name ?? 'Deleted' }} {{ optional($ticket->user)->last_name ?? 'User' }}</td>
                                            <td>
                                                @if($ticket->priority == 'High')
                                                    <span class="badge bg-danger">High</span>
                                                @elseif($ticket->priority == 'Medium')
                                                    <span class="badge bg-warning text-dark">Medium</span>
                                                @else
                                                    <span class="badge bg-info">Low</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($ticket->status == 'Open')
                                                    <span class="badge bg-primary">Open</span>
                                                @elseif($ticket->status == 'Pending')
                                                    <span class="badge bg-info">Pending</span>
                                                @else
                                                    <span class="badge bg-success">Closed</span>
                                                @endif
                                            </td>
                                            <td>{{ optional($ticket->forwardedTo)->first_name ?? 'Unassigned' }}</td>
                                            <td>{{ $ticket->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    @unless(auth()->user()->hasRole('Cleaner'))
                                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                        data-bs-target="#forwardModal{{ $ticket->id }}">
                                                        <i class="bi bi-person-plus-fill"></i> Forward
                                                    </button>
                                                    @endunless
                                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                                                        data-bs-target="#statusModal{{ $ticket->id }}">
                                                        <i class="bi bi-gear-fill"></i> Status
                                                    </button>
                                                </div>

                                                <!-- Forward Modal -->
                                                <div class="modal fade" id="forwardModal{{ $ticket->id }}" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Forward Ticket</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('support.forward', $ticket) }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <label class="form-label">Select Agent</label>
                                                                    <select class="form-select" name="agent_id" required>
                                                                        <option value="" disabled selected>Choose Staff...</option>
                                                                        @foreach ($agents as $agent)
                                                                            <option value="{{ $agent->id }}">
                                                                                {{ $agent->first_name }} {{ $agent->last_name }} ({{ $agent->getRoleNames()->first() }})
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Forward</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Status Modal -->
                                                <div class="modal fade" id="statusModal{{ $ticket->id }}" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Update Ticket Status</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('support.status', $ticket) }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <label class="form-label">Status</label>
                                                                    <select class="form-select" name="status" required>
                                                                        <option value="Open" {{ $ticket->status == 'Open' ? 'selected' : '' }}>Open</option>
                                                                        <option value="Pending" {{ $ticket->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                                        <option value="Closed" {{ $ticket->status == 'Closed' ? 'selected' : '' }}>Closed</option>
                                                                    </select>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="text-center py-4">No tickets found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <!-- User Submit Ticket Form -->
            <div class="card rounded-4">
                <div class="card-header border-0 shadow-none bg-transparent">
                    <h5 class="mb-0">Contact Support</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('support.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control" placeholder="e.g., WiFi Issue" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Priority</label>
                            <select class="form-select" name="priority">
                                <option value="Low">Low</option>
                                <option value="Medium" selected>Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-control" rows="5" placeholder="Tell us more about your issue..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary px-5">Submit Ticket</button>
                    </form>
                </div>
            </div>

            <!-- User's Existing Tickets -->
             @if($tickets->isNotEmpty())
            <div class="card rounded-4">
                <div class="card-header border-0 shadow-none bg-transparent">
                    <h5 class="mb-0">Your Recent Tickets</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->subject }}</td>
                                    <td>
                                        <span class="badge bg-{{ $ticket->status == 'Closed' ? 'success' : 'primary' }}">
                                            {{ $ticket->status }}
                                        </span>
                                    </td>
                                    <td>{{ $ticket->created_at->format('M d') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        @endif
    </main>
@endsection
