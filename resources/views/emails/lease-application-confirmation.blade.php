<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lease Application Received</title>
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

        .highlight-box {
            background-color: #e2d9f3;
            border-left: 4px solid #6610f2;
            padding: 15px;
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
            <img src="{{ isset($message) ? $message->embed(str_replace('\\', '/', public_path('assets/img/logo/stay-smart.png'))) : asset('assets/img/logo/stay-smart.png') }}"
                alt="Stay Smart Logo" style="width: 150px; height: auto; display: block; margin: 0 auto 15px auto;">
            <h1>Application Received!</h1>
        </div>

        <div class="content">
            <p>Dear {{ $data['first_name'] }},</p>

            <p>Thank you for choosing to lease your property to <strong>Stay Smart Apartments</strong>!</p>

            <div class="highlight-box">
                <p><strong>Your "Lease to Stay Smart" application has been successfully submitted.</strong></p>
            </div>

            <h3>Next Steps</h3>
            <ol>
                <li><strong>Initial Review</strong>: Our acquisitions team will review your property details (3-5
                    business days).</li>
                <li><strong>Property Inspection</strong>: We will contact you to schedule a physical inspection and
                    condition assessment.</li>
                <li><strong>Offer & Agreement</strong>: If approved, we will present a formal lease offer and management
                    agreement.</li>
                <li><strong>Key Handover</strong>: Once signed, verified, and insured, we take over full management
                    responsibilities.</li>
            </ol>

            <h3>Application Summary</h3>
            <p>
                <strong>Property:</strong> {{ $data['address'] }}, {{ $data['city'] }}<br>
                <strong>Type:</strong> {{ $data['property_type'] }} ({{ $data['bedrooms'] }} Bed,
                {{ $data['bathrooms'] }} Bath)<br>
                <strong>Lease Term:</strong> {{ $data['lease_duration'] }}<br>
                <strong>Earliest Start:</strong> {{ $data['start_date'] }}
            </p>

            <p><strong>Please prepare the following documents for the next stage:</strong></p>
            <ul>
                <li>Proof of Ownership (Title Deed or equivalent)</li>
                <li>Valid ID</li>
                <li>Recent Utility Bill</li>
                <li>Landlord Approval (if subleasing)</li>
            </ul>

            <p>If you have urgent questions, contact our acquisitions team at <a
                    href="mailto:partners@staysmart.com">partners@staysmart.com</a>.</p>

            <p><strong>Best regards,</strong><br>
                The Stay Smart Acquisitions Team</p>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} Stay Smart Apartments. All rights reserved.</p>
        </div>
    </div>
</body>

</html>