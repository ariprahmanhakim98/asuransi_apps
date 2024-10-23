<!DOCTYPE html>
<html>
<head>
    <title>Password Change Reminder</title>
</head>
<body>
    <h1>Hello {{ $user->name }},</h1>
    <p>It has been over 7 days since you last changed your password.</p>
    <p>For security reasons, we recommend that you update your password regularly.</p>
    <p>Please <a href="{{ url('/change-password') }}">click here</a> to change your password.</p>
    <p>Thank you.</p>
</body>
</html>
