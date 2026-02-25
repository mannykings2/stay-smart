<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .header {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .details {
            margin: 20px 0;
        }

        .details table {
            width: 100%;
            border-collapse: collapse;
        }

        .details th,
        .details td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        .details th {
            background-color: #f9f9f9;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ isset($message) ? $message->embed(str_replace('\\', '/', public_path('assets/img/logo/stay-smart.png'))) : asset('assets/img/logo/stay-smart.png') }}"
                alt="Stay Smart Logo" style="width: 150px; height: auto; display: block; margin: 0 auto 15px auto;">
            <h2>Booking Confirmation</h2>
            <p>Your payment was successful!</p>
        </div>

        <p>Dear {{ $booking->user->first_name ?? 'Guest' }},</p>
        <p>Thank you for choosing <strong>StaySmart</strong>. Your booking has been confirmed.</p>

        <div class="details">
            <table>
                <tr>
                    <th>Booking Reference</th>
                    <td><strong>{{ $booking->reference }}</strong></td>
                </tr>
                <tr>
                    <th>Property</th>
                    <td>{{ $booking->property->name }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{ $booking->property->address }}, {{ $booking->property->city }}</td>
                </tr>
                <tr>
                    <th>Check-in</th>
                    <td>
                        {{ \Carbon\Carbon::parse($booking->check_in_date)->format('D, M j, Y') }}
                        @if($booking->check_in_time)
                            <br><small>({{ \Carbon\Carbon::parse($booking->check_in_time)->format('h:i A') }})</small>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Check-out</th>
                    <td>
                        {{ \Carbon\Carbon::parse($booking->check_out_date)->format('D, M j, Y') }}
                        @if($booking->check_out_time)
                            <br><small>({{ \Carbon\Carbon::parse($booking->check_out_time)->format('h:i A') }})</small>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Total Paid</th>
                    <td>₦ {{ number_format($booking->total_price, 2) }}</td>
                </tr>
            </table>
        </div>

        <div style="text-align: center;">
            <a href="{{ route('booking', ['reference' => $booking->reference]) }}" class="btn">View Booking
                Details</a>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} StaySmart Apartments. All rights reserved.</p>
        </div>
    </div>
</body>

</html>