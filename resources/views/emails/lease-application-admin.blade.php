<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Lease to Stay Smart Application</title>
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
            background-color: #6610f2;
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
            width: 40%;
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
            color: #6610f2;
            font-weight: bold;
        }

        .section-title {
            color: #6610f2;
            border-bottom: 2px solid #6610f2;
            padding-bottom: 5px;
            margin-top: 30px;
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
            <img src="{{ isset($message) ? $message->embed(str_replace('\\', '/', public_path('assets/img/logo/stay-smart.png'))) : asset('assets/img/logo/stay-smart.png') }}"
                alt="Stay Smart Logo" style="width: 150px; height: auto; display: block; margin: 0 auto 15px auto;">
            <h1>New Lease Application</h1>
        </div>

        <div class="content">
            <p><strong>A new Lease to Stay Smart application has been submitted!</strong></p>

            <h3 class="section-title">Owner Information</h3>
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
                    <th>Phone</th>
                    <td><a href="tel:{{ $data['phone_number'] }}">{{ $data['phone_number'] }}</a></td>
                </tr>
            </table>

            <h3 class="section-title">Property Location</h3>
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

            <h3 class="section-title">Property Details</h3>
            <table class="info-table">
                <tr>
                    <th>Type</th>
                    <td>{{ $data['property_type'] }}</td>
                </tr>
                <tr>
                    <th>Bedrooms</th>
                    <td>{{ $data['bedrooms'] }}</td>
                </tr>
                <tr>
                    <th>Bathrooms</th>
                    <td>{{ $data['bathrooms'] }}</td>
                </tr>
                <tr>
                    <th>Size</th>
                    <td>{{ $data['size'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Furnishing</th>
                    <td>{{ $data['furnishing'] }}</td>
                </tr>
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
            </table>

            <h3 class="section-title">Ownership & Legal</h3>
            <table class="info-table">
                <tr>
                    <th>Ownership Status</th>
                    <td>{{ $data['ownership_status'] }}</td>
                </tr>
                <tr>
                    <th>Title Deed Available?</th>
                    <td>{{ $data['title_deed_available'] }}</td>
                </tr>
                <tr>
                    <th>Tenancy Status</th>
                    <td>{{ $data['tenancy_status'] }}</td>
                </tr>
                @if($data['tenancy_status'] == 'Currently Occupied')
                    <tr>
                        <th>Vacancy Date</th>
                        <td>{{ $data['vacancy_date'] }}</td>
                    </tr>
                @endif
            </table>

            <h3 class="section-title">Lease Terms</h3>
            <table class="info-table">
                <tr>
                    <th>Desired Duration</th>
                    <td>{{ $data['lease_duration'] }}</td>
                </tr>
                <tr>
                    <th>Expected Annual Rent</th>
                    <td>{{ $data['expected_rent'] ? number_format($data['expected_rent'], 2) : 'Open to offers' }}</td>
                </tr>
                <tr>
                    <th>Earliest Start Date</th>
                    <td>{{ $data['start_date'] }}</td>
                </tr>
            </table>

            <h3 class="section-title">Condition</h3>
            <table class="info-table">
                <tr>
                    <th>Condition</th>
                    <td>{{ $data['condition'] }}</td>
                </tr>
                <tr>
                    <th>Renovations</th>
                    <td>{{ implode(', ', $data['renovations']) }}</td>
                </tr>
                <tr>
                    <th>Known Issues</th>
                    <td>{{ $data['issues'] ?? 'None stated' }}</td>
                </tr>
            </table>

            <h3 class="section-title">Additional Info</h3>
            <table class="info-table">
                <tr>
                    <th>Reason for Leasing</th>
                    <td>{{ $data['reason'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Special Requirements</th>
                    <td>{{ $data['special_requirements'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Images</th>
                    <td>{{ count($data['images']) }} attached</td>
                </tr>
            </table>

        </div>

        <div class="footer">
            <p>© {{ date('Y') }} Stay Smart Apartments. All rights reserved.</p>
        </div>
    </div>
</body>

</html>