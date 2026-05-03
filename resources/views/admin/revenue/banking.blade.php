@extends('layouts.app')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <style>
        .select2-container { width: 100% !important; }
        .account-name-loader { display: none; }
        .verified-badge { display: none; }
    </style>
@endpush

@section('content')
    <main class="page-content">
        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Revenue Hub</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.revenue.index') }}">Revenue Hub</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Banking Details</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-lg-7">

                @if($bankAccount)
                    <!-- Saved Account Card -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div>
                                    <h6 class="fw-bold mb-0">Saved Payout Account</h6>
                                    <small class="text-muted">Your earnings will be paid to this account.</small>
                                </div>
                                @if($bankAccount->is_verified)
                                    <span class="badge bg-success rounded-pill ms-auto px-3">
                                        <i class="bi bi-patch-check-fill me-1"></i>Verified
                                    </span>
                                @endif
                            </div>
                            <hr>
                            <div class="row g-3">
                                <div class="col-6">
                                    <p class="text-muted small mb-0 text-uppercase fw-bold">Bank</p>
                                    <p class="fw-bold mb-0">{{ $bankAccount->bank_name }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-muted small mb-0 text-uppercase fw-bold">Account Number</p>
                                    <p class="fw-bold mb-0">{{ $bankAccount->account_number }}</p>
                                </div>
                                <div class="col-12">
                                    <p class="text-muted small mb-0 text-uppercase fw-bold">Account Name</p>
                                    <p class="fw-bold mb-0">{{ $bankAccount->account_name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Banking Details Form -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <h6 class="fw-bold mb-0">{{ $bankAccount ? 'Update' : 'Add' }} Banking Details</h6>
                        <small class="text-muted">Your account details are resolved securely via Paystack.</small>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.revenue.banking.store') }}" method="POST" id="bankingForm">
                            @csrf

                            <!-- Bank Dropdown (Select2) -->
                            <div class="mb-4">
                                <label for="bank_code" class="form-label fw-bold">
                                    Bank <span class="text-danger">*</span>
                                </label>
                                <select name="bank_code" id="bank_code" class="form-select rounded-3" required>
                                    <option value="">Search for your bank...</option>
                                    @foreach($banks as $bank)
                                        <option value="{{ $bank['code'] }}"
                                            data-name="{{ $bank['name'] }}"
                                            {{ old('bank_code', $bankAccount?->bank_code) == $bank['code'] ? 'selected' : '' }}>
                                            {{ $bank['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="bank_name" id="bank_name"
                                    value="{{ old('bank_name', $bankAccount?->bank_name) }}">
                            </div>

                            <!-- Account Number -->
                            <div class="mb-4">
                                <label for="account_number" class="form-label fw-bold">
                                    Account Number <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="text" name="account_number" id="account_number"
                                        class="form-control rounded-start-3"
                                        maxlength="10" placeholder="Enter 10-digit account number"
                                        value="{{ old('account_number', $bankAccount?->account_number) }}" required>
                                    <span class="input-group-text rounded-end-3 account-name-loader" id="resolveSpinner">
                                        <span class="spinner-border spinner-border-sm text-primary"></span>
                                    </span>
                                </div>
                                <div class="form-text text-muted">Account name will auto-fill when number is entered.</div>
                            </div>

                            <!-- Account Name (Read-only, auto-filled) -->
                            <div class="mb-4">
                                <label for="account_name" class="form-label fw-bold">Account Name</label>
                                <div class="input-group">
                                    <input type="text" name="account_name" id="account_name"
                                        class="form-control rounded-start-3 bg-light"
                                        placeholder="Will be resolved automatically..."
                                        value="{{ old('account_name', $bankAccount?->account_name) }}"
                                        readonly required>
                                    <span class="input-group-text rounded-end-3 bg-success text-white verified-badge" id="verifiedBadge">
                                        <i class="bi bi-check-lg"></i>
                                    </span>
                                </div>
                                <div id="resolveError" class="text-danger small mt-1" style="display:none;"></div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary rounded-pill py-2 fw-bold" id="saveBtn" disabled>
                                    <i class="bi bi-save me-2"></i>Save Banking Details
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function () {
            // Initialize Select2 for bank dropdown
            $('#bank_code').select2({
                theme: 'bootstrap-5',
                placeholder: 'Search for your bank...',
                allowClear: true,
            });

            // When bank is selected, update the hidden bank_name field
            $('#bank_code').on('select2:select', function (e) {
                const selectedOption = e.params.data.element;
                $('#bank_name').val($(selectedOption).data('name'));
                // Reset account name if bank changes
                $('#account_name').val('');
                $('#verifiedBadge').hide();
                $('#saveBtn').prop('disabled', true);
                // Re-trigger resolve if account number is already entered
                const accNum = $('#account_number').val();
                if (accNum.length === 10) resolveAccount(accNum, $(this).val());
            });

            // Resolve account name on account number input
            $('#account_number').on('input', function () {
                const accNum = $(this).val().replace(/\D/g, '');
                $(this).val(accNum);
                if (accNum.length === 10) {
                    const bankCode = $('#bank_code').val();
                    if (!bankCode) {
                        $('#resolveError').text('Please select a bank first.').show();
                        return;
                    }
                    resolveAccount(accNum, bankCode);
                } else {
                    $('#account_name').val('');
                    $('#verifiedBadge').hide();
                    $('#resolveError').hide();
                    $('#saveBtn').prop('disabled', true);
                }
            });

            // If saved account already exists, enable save
            @if($bankAccount)
                $('#saveBtn').prop('disabled', false);
            @endif
        });

        function resolveAccount(accountNumber, bankCode) {
            $('#resolveSpinner').show();
            $('#resolveError').hide();
            $('#account_name').val('');
            $('#verifiedBadge').hide();
            $('#saveBtn').prop('disabled', true);

            $.ajax({
                url: '{{ route("api.banks.resolve") }}',
                method: 'GET',
                data: { account_number: accountNumber, bank_code: bankCode },
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                success: function (res) {
                    $('#resolveSpinner').hide();
                    if (res.success) {
                        $('#account_name').val(res.account_name);
                        $('#verifiedBadge').show();
                        $('#saveBtn').prop('disabled', false);
                    } else {
                        $('#resolveError').text(res.message || 'Could not resolve account.').show();
                    }
                },
                error: function () {
                    $('#resolveSpinner').hide();
                    $('#resolveError').text('An error occurred. Please check your account number and bank.').show();
                }
            });
        }
    </script>
@endpush
