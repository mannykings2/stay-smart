<!DOCTYPE html>
<html>

<head>
    <title>New Contact Inquiry</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 5px;">
        <h2 style="color: #007bff; border-bottom: 2px solid #007bff; padding-bottom: 10px;">New Contact Us Inquiry</h2>

        <p>You have received a new message from the Stay Smart website contact form.</p>

        <div style="background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin-top: 20px;">
            <p><strong>Name:</strong> {{ $data['name'] }}</p>
            <p><strong>Phone:</strong> {{ $data['phone'] }}</p>
        </div>

        <h3 style="margin-top: 20px;">Message:</h3>
        <p style="background-color: #f0f8ff; padding: 15px; border-radius: 5px; border-left: 4px solid #007bff;">
            {{ nl2br(e($data['message'])) }}
        </p>

        <p style="margin-top: 30px; font-size: 12px; color: #888;">
            This email was sent from the Stay Smart contact form.
        </p>
    </div>
</body>

</html>