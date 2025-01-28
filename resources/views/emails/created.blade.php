<!DOCTYPE html>
<html>
<head>
    <title>Account Created</title>
</head>
<body>
    <p><b>Hello {{ $user->firstname }} {{ $user->lastname }},</b></p>
    <p>Your account has been created successfully!</p>
    <p>You can now <a href="{{ url('/login') }}">log in</a>.</p>
    <p>Thank you for joining us!</p>
</body>
</html>
