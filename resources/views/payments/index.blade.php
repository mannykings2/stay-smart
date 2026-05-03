@extends('layouts.app', [$activePage = 'Payments'])

@section('content')
    <main class="page-content">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-12">
                    <h6 class="mb-2 text-uppercase fw-bold">Payment History</h6>
                    <hr>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(isset($payments) && $payments->count() > 0)
                        <div class="row g-3 payment-list">
                            @foreach ($payments as $payment)
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="payment-card shadow-sm" data-payment-id="{{ $payment->id }}"
                                        style="cursor:pointer;">
                                        <div class="payment-card-header d-flex justify-content-between align-items-center mb-3">
                                            <span class="payment-icon-circle">
                                                <i class="fas fa-receipt"></i>
                                            </span>
                                            <span class="badge bg-success">{{ $payment->status }}</span>
                                        </div>
                                        <div class="payment-property-name fw-bold mb-1 text-truncate">
                                            {{ optional(optional($payment->booking)->property)->name ?? 'Property' }}
                                        </div>
                                        <div class="payment-ref small text-muted mb-2 text-truncate">
                                            Ref: {{ $payment->trx_ref }}
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="payment-amount fw-bold">₦{{ number_format($payment->amount, 2) }}</div>
                                            <div class="payment-date small text-muted">{{ $payment->created_at->format('d M Y') }}
                                            </div>
                                        </div>
                                        <div class="mt-3 pt-2 border-top text-center small text-muted">
                                            <i class="fas fa-eye me-1"></i> Click to view details
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">You have no completed payments yet.</p>
                        </div>
                    @endif
                    @include('components.pagination', ['paginator' => $payments])
                </div>
            </div>
        </div>
    </main>

    {{-- Payment Detail Modal --}}
    <div class="modal fade" id="paymentDetailModal" tabindex="-1" aria-labelledby="paymentDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="paymentDetailModalLabel">
                        <i class="fas fa-receipt me-2 text-warning"></i> Payment Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="paymentModalBody">
                    <div class="text-center py-4" id="modalLoader">
                        <div class="spinner-border text-warning" role="status"></div>
                        <p class="mt-2 text-muted">Loading details...</p>
                    </div>
                    <div id="modalContent" style="display:none;">
                        {{-- Payment Summary --}}
                        <div class="receipt-preview p-4 rounded mb-4" id="receiptArea">
                            <div class="text-center mb-3">
                                <h5 class="fw-bold mb-0" style="color:#875233;">Stay Smart Apartments</h5>
                                <small class="text-muted">Official Payment Receipt</small>
                            </div>
                            <div class="text-center mb-3">
                                <span class="paid-badge">PAID</span>
                            </div>
                            <div class="amount-highlight mb-4">
                                <span class="amount-label">Amount Paid</span>
                                <span class="amount-value" id="m-amount"></span>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="receipt-section-title">Payment Info</h6>
                                    <table class="table table-sm table-borderless receipt-table">
                                        <tr>
                                            <th>Transaction Ref</th>
                                            <td id="m-trx-ref" class="text-break"></td>
                                        </tr>
                                        <tr>
                                            <th>Method</th>
                                            <td id="m-method"></td>
                                        </tr>
                                        <tr>
                                            <th>Date</th>
                                            <td id="m-date"></td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td><span id="m-status" class="badge bg-success"></span></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="receipt-section-title">Booking Info</h6>
                                    <table class="table table-sm table-borderless receipt-table">
                                        <tr>
                                            <th>Reference</th>
                                            <td id="m-booking-ref" class="fw-bold"></td>
                                        </tr>
                                        <tr>
                                            <th>Property</th>
                                            <td id="m-property"></td>
                                        </tr>
                                        <tr>
                                            <th>Guest</th>
                                            <td id="m-guest"></td>
                                        </tr>
                                        <tr>
                                            <th>Check-In</th>
                                            <td id="m-checkin"></td>
                                        </tr>
                                        <tr>
                                            <th>Check-Out</th>
                                            <td id="m-checkout"></td>
                                        </tr>
                                        <tr>
                                            <th>Guests</th>
                                            <td id="m-guests"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0" id="modalFooter" style="display:none;">
                    <button class="btn btn-outline-secondary btn-sm" id="downloadPngBtn">
                        <i class="fas fa-image me-1"></i> Download PNG
                    </button>
                    <a class="btn btn-danger btn-sm" id="downloadPdfBtn" href="#" target="_blank">
                        <i class="fas fa-file-pdf me-1"></i> Download PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Hidden Receipt Area for PNG Generation --}}
    <div id="hiddenReceiptWrapper" style="position: absolute; left: -9999px; top: -9999px;">
        <div id="receiptCaptureArea" class="receipt-container" style="width: 680px; background: white;">
            @include('partials.receipt_styles')
            <div id="dynamicReceiptContent">
                {{-- Content will be injected via JS for the specific payment --}}
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .payment-card {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 14px;
            padding: 20px;
            transition: all 0.2s ease;
        }

        .payment-card:hover {
            border-color: #875233;
            box-shadow: 0 6px 20px rgba(135, 82, 51, 0.12) !important;
            transform: translateY(-2px);
        }

        .payment-icon-circle {
            background: #fdf4ef;
            color: #875233;
            border-radius: 50%;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .payment-amount {
            font-size: 1.15rem;
            color: #875233;
        }

        .payment-property-name {
            font-size: 0.95rem;
        }

        /* Modal Receipt Style */
        .receipt-preview {
            background: #fdfaf8;
            border: 1px solid #f0e8e2;
        }

        .paid-badge {
            display: inline-block;
            border: 3px solid #16a34a;
            color: #16a34a;
            font-size: 1.4rem;
            font-weight: 900;
            padding: 4px 20px;
            border-radius: 6px;
            letter-spacing: 5px;
            transform: rotate(-4deg);
            opacity: 0.85;
        }

        .amount-highlight {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            border-left: 4px solid #875233;
            border-radius: 6px;
            padding: 14px 18px;
        }

        .amount-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #875233;
            font-weight: 700;
        }

        .amount-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #875233;
        }

        .receipt-section-title {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #875233;
            font-weight: 700;
            border-bottom: 1px solid #f0e8e2;
            padding-bottom: 6px;
            margin-bottom: 8px;
        }

        .receipt-table th {
            font-weight: 600;
            color: #555;
            font-size: 0.78rem;
            width: 45%;
            padding: 5px 4px;
        }

        .receipt-table td {
            color: #222;
            font-size: 0.78rem;
            padding: 5px 4px;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        var currentPaymentId = null;

        $(document).on('click', '.payment-card', function () {
            currentPaymentId = $(this).data('payment-id');
            console.log('Opening payment details for ID:', currentPaymentId);

            var modalEl = document.getElementById('paymentDetailModal');
            if (!modalEl) {
                console.error('Modal element not found!');
                return;
            }

            // Loader State
            $('#modalLoader').show();
            $('#modalContent').hide();
            $('#modalFooter').hide();

            // Open Modal (Compatibility for BS4 and BS5)
            if (window.bootstrap && bootstrap.Modal) {
                // Bootstrap 5
                var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            } else if ($.fn.modal) {
                // Bootstrap 4 (jQuery)
                $(modalEl).modal('show');
            } else {
                console.error('Bootstrap JS not found!');
                alert('Could not open modal. Bootstrap JS is missing.');
                return;
            }

            // Fetch Data
            $.get('/payments/' + currentPaymentId + '/show', function (data) {
                $('#m-amount').text('₦' + data.amount);
                $('#m-trx-ref').text(data.trx_ref);
                $('#m-method').text(data.payment_method || 'Paystack');
                $('#m-date').text(data.paid_at);
                $('#m-status').text(data.status);

                if (data.booking) {
                    $('#m-booking-ref').text(data.booking.reference);
                    $('#m-property').text(data.booking.property_name + (data.booking.property_addr ? ', ' + data.booking.property_addr : ''));
                    $('#m-guest').text(data.booking.guest_name || '—');
                    $('#m-checkin').text(data.booking.check_in || '—');
                    $('#m-checkout').text(data.booking.check_out || '—');
                    $('#m-guests').text(data.booking.guests || '1');
                }

                $('#downloadPdfBtn').attr('href', '/receipt/' + data.trx_ref);

                // Prepare hidden area for PNG
                $('#dynamicReceiptContent').html(`
                                <div class="receipt-wrapper">
                                    <div class="header">
                                        <h1>Stay Smart Apartments</h1>
                                        <p>Official Payment Receipt</p>
                                    </div>
                                    <div class="paid-stamp"><span>PAID</span></div>
                                    <div class="amount-box">
                                        <div class="label">Amount Paid</div>
                                        <div class="value">₦${data.amount}</div>
                                    </div>
                                    <p class="section-title">Payment Details</p>
                                    <table class="detail-table">
                                        <tr><td>Transaction Ref</td><td>${data.trx_ref}</td></tr>
                                        <tr><td>Payment Method</td><td>${data.payment_method || 'Paystack'}</td></tr>
                                        <tr><td>Payment Date</td><td>${data.paid_at}</td></tr>
                                        <tr><td>Status</td><td><strong style="color:#16a34a;">${data.status}</strong></td></tr>
                                    </table>
                                    ${data.booking ? `
                                        <p class="section-title">Booking Details</p>
                                        <table class="detail-table">
                                            <tr><td>Booking Reference</td><td><strong>${data.booking.reference}</strong></td></tr>
                                            <tr><td>Guest Name</td><td>${data.booking.guest_name}</td></tr>
                                            <tr><td>Property</td><td>${data.booking.property_name}</td></tr>
                                            <tr><td>Address</td><td>${data.booking.property_addr}</td></tr>
                                            <tr><td>Check-In</td><td>${data.booking.check_in}</td></tr>
                                            <tr><td>Check-Out</td><td>${data.booking.check_out}</td></tr>
                                            <tr><td>Guests</td><td>${data.booking.guests}</td></tr>
                                        </table>
                                    ` : ''}
                                    <div class="footer">
                                        Thank you for choosing <strong>Stay Smart Apartments</strong>.<br>
                                        For support, please contact us with your transaction reference.
                                    </div>
                                </div>
                            `);

                $('#modalLoader').hide();
                $('#modalContent').show();
                $('#modalFooter').css('display', 'flex');
            }).fail(function (xhr) {
                console.error('Failed to load payment details:', xhr);
                $('#modalLoader').html('<p class="text-danger">Failed to load payment details. Please try again.</p>');
            });
        });

        // PNG download using html2canvas
        $(document).on('click', '#downloadPngBtn', function () {
            var el = document.getElementById('receiptCaptureArea');
            if (!el) return;

            $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Generating...');

            var self = this;
            html2canvas(el, { scale: 2, useCORS: true }).then(function (canvas) {
                var link = document.createElement('a');
                link.download = 'receipt-' + currentPaymentId + '.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
                $(self).prop('disabled', false).html('<i class="fas fa-image me-1"></i> Download PNG');
            }).catch(function (err) {
                console.error('html2canvas error:', err);
                $(self).prop('disabled', false).html('<i class="fas fa-image me-1"></i> Download PNG');
            });
        });
    </script>
@endpush