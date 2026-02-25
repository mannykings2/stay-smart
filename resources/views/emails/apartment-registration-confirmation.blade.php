<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Confirmation</title>
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
            background-color: #28a745;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .content {
            background-color: #f8f9fa;
            padding: 30px;
        }

        .highlight-box {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
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
            <h1>✓ Registration Received!</h1>
        </div>

        <div class="content">
            <p>Dear {{ $data['first_name'] }} {{ $data['last_name'] }},</p>

            <p>Thank you for your interest in listing your property on <strong>Stay Smart Apartments</strong>!</p>

            <div class="highlight-box">
                <p><strong>Your property listing application has been successfully submitted.</strong></p>
            </div>

            <h3>What Happens Next?</h3>
            <ol>
                <li><strong>Application Review</strong>: Our team will review your property details within 24-48 hours.
                </li>
                <li><strong>Account Setup</strong>: Once approved, we'll create your property owner admin account where
                    you can manage your listing, set prices, and control availability.</li>
                <li><strong>Property Activation</strong>: After you complete your property profile in your dashboard,
                    your apartment will go live on our platform.</li>
                <li><strong>Start Earning</strong>: Begin receiving booking requests from verified guests!</li>
            </ol>

            <h3>Your Submission Summary</h3>
            <p><strong>Email:</strong> {{ $data['email'] }}<br>
                <strong>Phone:</strong> {{ $data['phone_number'] }}<br>
                <strong>Location:</strong> {{ $data['city'] }}, {{ $data['state'] }}<br>
                <strong>Amenities:</strong> {{ count($data['amenities']) }} selected<br>
                <strong>Images:</strong> {{ count($data['images']) }} uploaded
            </p>

            <p><strong>Remember:</strong> You will have full control over your property through your admin dashboard.
                You set the rules, prices, and availability.</p>
            </p>

            <p>If you have any questions in the meantime, please don't hesitate to contact us at <a
                    href="mailto:staysmartbookings@gmail.com">staysmartbookings@gmail.com</a> or call <a
                    href="tel:+2347044479938">+(234) 704 447 9938</a>.</p>

            <p>We look forward to partnering with you!</p>

            <p><strong>Best regards,</strong><br>
                The Stay Smart Team</p>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} Stay Smart Apartments. All rights reserved.</p>
        </div>
    </div>
</body>

</html>