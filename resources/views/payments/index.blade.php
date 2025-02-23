@extends('layouts.app', [$activePage = 'Payments'])

@section('content')
<main class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h6 class="mb-2 text-uppercase">Payments</h6>
                <hr>
                @if(count($payments) > 0)
                    <div class="row payment-list">
                        @foreach ($payments as $payment)
                            <div class="payment-item shadow-sm">
                                <div class="payment-info">
                                    <div class="payment-icon">
                                        <i class="fas fa-money-bill-alt"></i> </div>
                                    <div class="payment-details">
                                        <div class="payment-date">
                                            {{ $payment->created_at->format('M d, Y') }}
                                        </div>
                                        <div class="payment-description">
                                            Payment Ref: {{ $payment->trx_ref }}
                                        </div>
                                        <div class="payment-amount">
                                            -₦{{ number_format($payment->amount, 2) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center mb-0 p-3">You have no Payments with us</p>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection

@push('css')
<style>
    /* Mobile Styles */
    @media (max-width: 767px) {
        .payment-list {
            display: flex;
            flex-direction: column;
        }

        .payment-item {
            background-color: #f8f9fa; /* Light background */
            border-radius: 10px;
            margin-bottom: 10px;
            padding: 15px;
        }

        .payment-info {
            display: flex;
            align-items: center;
        }

        .payment-icon {
            background-color: #e9ecef; /* Light gray icon background */
            border-radius: 50%;
            padding: 10px;
            margin-right: 15px;
            font-size: 1.2rem;
        }

        .payment-details {
            flex-grow: 1;
        }

        .payment-date, .payment-description {
            font-size: 0.9rem;
            color: #495057;
        }

        .payment-amount {
            font-weight: bold;
            text-align: right;
            color: #212529;
        }
    }

    /* Desktop Styles (Cards) */
    @media (min-width: 768px) {
        .payment-list {
            display: flex;
            flex-wrap: wrap;
        }

        .payment-item {
            width: calc(33.33% - 10px); /* Adjust width for 3 cards per row */
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            margin: 5px;
            padding: 15px;
        }

        .payment-info {
            display: block;
        }

        .payment-icon {
            display: none; /* Hide icon on desktop */
        }

        .payment-date, .payment-description, .payment-amount {
            text-align: left;
        }
    }
</style>
@endpush
