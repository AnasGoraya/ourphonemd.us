<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verify Your Email</title>
</head>
<body>
    <h2>Hello {{ $user->name }},</h2>
    <p>Thank you for registering. Please verify your email by cliccking the link below:</p>

    @if(isset($user) && get_class($user) === 'App\Models\Admin')
        <a href="{{ url('/admin/verify-email/' . $token) }}" style="background-color:#4CAF50;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;">
            Verify Email
        </a>
    @else
        <a href="{{ url('/verify-email/' . $token) }}" style="background-color:#4CAF50;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;">
            Verify Email
        </a>
    @endif

    <p>If you did not create this account, no further action is required.</p>
    <p>Regards,<br>{{ config('app.name') }}</p>
</body>
</html>
