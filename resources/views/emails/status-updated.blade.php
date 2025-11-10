<!DOCTYPE html>
<html>
<head>
    <title>Account Status Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #b3927a;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            background-color: #f9f9f9;
            padding: 30px;
            border: 1px solid #ddd;
        }
        .status-box {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
            padding: 15px;
            margin: 20px 0;
        }
        .status-box.pending {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #b3927a;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Account Status Update</h1>
    </div>
    <div class="content">
        <p><b>Hello {{ $user->firstname }} {{ $user->lastname }},</b></p>

        <p>We're writing to inform you that your account status has been updated.</p>

        <div class="status-box {{ $status }}">
            <strong>New Status: {{ ucfirst($status) }}</strong>
        </div>

        @if($status === 'approved')
            <p><strong>Good news!</strong> Your account has been approved and is now active.</p>

            <p>You can now log in and start ordering cheques from Just Cheques.</p>

            <div style="text-align: center;">
                <a href="{{ url('/login') }}" class="button">Login to Your Account</a>
            </div>

            <p><strong>Your Account Details:</strong></p>
            <ul>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Company:</strong> {{ $user->company }}</li>
            </ul>
        @else
            <p>Your account status has been changed to <strong>{{ ucfirst($status) }}</strong>.</p>

            <p>If you have any questions about your account status, please contact our support team.</p>
        @endif

        <p>If you did not request this change or have any concerns, please contact us immediately.</p>

        <p>Best regards,<br>The Just Cheques Team</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} Just Cheques. All rights reserved.</p>
        <p>If you have questions, please contact us at {{ config('mail.from.address') }}</p>
    </div>
</body>
</html>
