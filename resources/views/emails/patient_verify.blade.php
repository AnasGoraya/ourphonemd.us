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
            background-color: #4CAF50;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #45a049;
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

       <div style="text-align: center;">
        <p>Kindly, Verify your email before login</p>
            <a href="{{ url('/patient/verify-email/' . $token) }}" class="button">
                Verify Email Address
            </a>

        </div>

</body>
</html>
