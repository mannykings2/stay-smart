<!DOCTYPE html>
<html>

<head>
    <title>Verify Email Address</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eeeeee;
        }

        .header img {
            max-width: 150px;
            height: auto;
        }

        .content {
            padding: 20px 0;
            color: #333333;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            background-color: #3490dc;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eeeeee;
            font-size: 12px;
            color: #999999;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            {{-- The key fix: embedding the image directly --}}
            <img src="{{ $message->embed(public_path('assets/img/logo/stay-smart.png')) }}" alt="Stay Smart Logo">
        </div>
        <div class="content">
            <p>Hello {{ $user->first_name ?? '' }},</p>
            <p>Please click the button below to verify your email address.</p>
            <div style="text-align: center;">
                <a href="{{ $url }}" class="btn">Verify Email Address</a>
            </div>
            <p>If you did not create an account, no further action is required.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} StaySmart Apartments. All rights reserved.</p>
            <p>If you're having trouble clicking the "Verify Email Address" button, copy and paste the URL below into
                your web browser:</p>
            <p style="word-break: break-all;"><a href="{{ $url }}">{{ $url }}</a></p>
        </div>
    </div>
</body>

</html>