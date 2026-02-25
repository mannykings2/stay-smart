<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Apartment Registration</title>
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
        }

        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .content {
            background-color: #f8f9fa;
            padding: 30px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .info-table th {
            background-color: #e9ecef;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }

        .info-table td {
            padding: 12px;
            border-bottom: 1px solid #dee2e6;
        }

        .amenities-list {
            list-style: none;
            padding: 0;
        }

        .amenities-list li {
            padding: 5px 0;
            padding-left: 20px;
            position: relative;
        }

        .amenities-list li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #28a745;
            font-weight: bold;
        }

        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #6c757d;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ isset($message) ? $message->embed(str_replace('\\', '/', public_path('assets/img/logo/stay-smart.png'))) : asset('assets/img/logo/stay-smart.png') }}" alt="Stay Smart Logo"
                style="width: 150px; height: auto; display: block; margin: 0 auto 15px auto;">
            <h1>New Apartment Registration</h1>
        </div>

        <div class="content">
            <p><strong>A new apartment has been registered on Stay Smart!</strong></p>

            <h3>Applicant Information</h3>
            <table class="info-table">
                <tr>
                    <th>Name</th>
                    <td>{{ $data['first_name'] }} {{ $data['last_name'] }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a></td>
                </tr>
                <tr>
                    <th>Phone Number</th>
                    <td><a href="tel:{{ $data['phone_number'] }}">{{ $data['phone_number'] }}</a></td>
                </tr>
            </table>

            <h3>Property Location</h3>
            <table class="info-table">
                <tr>
                    <th>Address</th>
                    <td>{{ $data['address'] }}</td>
                </tr>
                <tr>
                    <th>City</th>
                    <td>{{ $data['city'] }}</td>
                </tr>
                <tr>
                    <th>State</th>
                    <td>{{ $data['state'] }}</td>
                </tr>
                <tr>
                    <th>Postal Code</th>
                    <td>{{ $data['postal_code'] }}</td>
                </tr>
            </table>

            <h3>Property Details</h3>
            <table class="info-table">
                <tr>
                    <th>Description</th>
                    <td>{{ $data['description'] }}</td>
                </tr>
                <tr>
                    <th>Amenities</th>
                    <td>
                        <ul class="amenities-list">
                            @foreach($data['amenities'] as $amenity)
                                <li>{{ $amenity }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                <tr>
                    <th>Images</th>
                    <td>{{ count($data['images']) }} image(s) attached to this email</td>
                </tr>
            </table>

            <p style="text-align: center;">
                <a href="{{ route('home') }}" class="button">Review in Dashboard</a>
            </p>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} Stay Smart Apartments. All rights reserved.</p>
            <p>This is an automated notification from your Stay Smart admin panel.</p>
        </div>
    </div>
</body>

</html>