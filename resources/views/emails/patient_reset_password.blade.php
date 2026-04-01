<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password - OurPhoneMD</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 30px 0;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            overflow: hidden;
        }
        .header {
            text-align: center;
            background-color: #ffffff;
            padding: 20px 0;
            border-bottom: 1px solid #e5e5e5;
        }
        .header h2 {
            margin: 0;
            color: #333333;
        }
        .content {
            padding: 25px;
            color: #555555;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #318C7E;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            font-weight: bold;
        }
        .button:hover {
            background-color: #2a7a6d;
        }
        .footer {
            text-align: center;
            font-size: 13px;
            color: #777777;
            padding: 15px;
            border-top: 1px solid #e5e5e5;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Reset Your Password</h2>
        </div>
        <div class="content">
            <p>Hello {{ $patient->first_name }} {{ $patient->last_name }},</p>
            <p>You requested to reset your password for your OurPhoneMD account. Please click the button below to confirm and update your password.</p>
            <p>If you did not make this request, please ignore this email.</p>
            <a href="{{ url('/patient/confirm-reset/' . $token) }}" class="button">Reset Password</a>
            <p style="margin-top: 20px;">This link will expire in 60 minutes.</p>
        </div>
        <div class="footer">
            <p>This email was sent by <strong>OurPhoneMD</strong>. If you have any questions, please contact support.</p>
        </div>
    </div>
</body>
</html>
