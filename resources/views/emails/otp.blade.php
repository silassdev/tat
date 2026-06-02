<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verify Your Email</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #0b0f19;
            color: #e2e8f0;
            margin: 0;
            padding: 40px 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #111827;
            border: 1px solid #1f2937;
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #10b981;
            letter-spacing: -0.05em;
            margin-bottom: 24px;
        }
        h1 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #ffffff;
        }
        p {
            font-size: 15px;
            color: #9ca3af;
            line-height: 1.6;
            margin-bottom: 24px;
        }
        .otp-box {
            display: inline-block;
            font-family: monospace;
            background-color: #1f2937;
            border: 1px solid #10b981;
            color: #10b981;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 6px;
            padding: 16px 28px;
            border-radius: 8px;
            margin: 16px 0;
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.1);
        }
        .footer {
            font-size: 12px;
            color: #4b5563;
            margin-top: 32px;
            border-top: 1px solid #1f2937;
            padding-top: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">SHOP</div>
        <h1>Email Verification Code</h1>
        <p>You requested a one-time verification code to secure your email. Use the code below to complete your transaction. This code is valid for 10 minutes.</p>
        <div class="otp-box">{{ $otp }}</div>
        <p>If you did not request this, please ignore this email.</p>
        <div class="footer">
            &copy; {{ date('Y') }} Shop Inc. All rights reserved.
        </div>
    </div>
</body>
</html>
