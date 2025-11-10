<!DOCTYPE html>
<html>
<head>
    <title>Registration Successful</title>
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
        .info-box {
            background-color: #fff3cd;
            border-left: 4px solid #b3927a;
            padding: 15px;
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
        <h1>Welcome to Just Cheques!</h1>
    </div>
    <div class="content">
        <p><b>Hello {{ $user->firstname }} {{ $user->lastname }},</b></p>

        <p>Thank you for registering with Just Cheques! We're excited to have you on board.</p>

        <div class="info-box">
            <strong>⏳ Account Pending Approval</strong>
            <p style="margin: 10px 0 0 0;">Your account has been successfully created and is currently pending admin verification. You will receive another email once your account has been approved.</p>
        </div>

        <p><strong>Your Registration Details:</strong></p>
        <ul>
            <li><strong>Name:</strong> {{ $user->firstname }} {{ $user->lastname }}</li>
            <li><strong>Email:</strong> {{ $user->email }}</li>
            <li><strong>Company:</strong> {{ $user->company }}</li>
        </ul>

        <p>Our admin team will review your registration shortly. Once approved, you'll be able to log in and start ordering cheques.</p>

        <p>If you have any questions or need assistance, please don't hesitate to contact us.</p>

        <p>Best regards,<br>The Just Cheques Team</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} Just Cheques. All rights reserved.</p>
    </div>
</body>
</html>
