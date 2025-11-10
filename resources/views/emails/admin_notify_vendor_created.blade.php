<!DOCTYPE html>
<html>
<head>
    <title>New User Registration</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        h2 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
        .details { background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .details ul { list-style: none; padding: 0; }
        .details li { padding: 8px 0; border-bottom: 1px solid #dee2e6; }
        .details li:last-child { border-bottom: none; }
        .role-badge { display: inline-block; padding: 5px 10px; border-radius: 3px; font-size: 12px; font-weight: bold; }
        .vendor { background-color: #28a745; color: white; }
        .admin { background-color: #dc3545; color: white; }
        .user { background-color: #007bff; color: white; }
        .footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #dee2e6; font-size: 12px; color: #6c757d; }
    </style>
</head>
<body>
    <div class="container">
        <h2>New User Registration Notification</h2>

        <p>A new user has registered on {{ config('app.name') }}:</p>

        <div class="details">
            <ul>
                <li><strong>User Role:</strong> <span class="role-badge {{ $user->role }}">{{ strtoupper($user->role ?? 'USER') }}</span></li>
                <li><strong>Name:</strong> {{ $user->firstname }} {{ $user->lastname }}</li>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Company:</strong> {{ $user->company ?? 'N/A' }}</li>
                <li><strong>Telephone:</strong> {{ $user->telephone ?? 'N/A' }}</li>
                <li><strong>Address:</strong> {{ $user->street_address ?? 'N/A' }}</li>
                <li><strong>Suburb:</strong> {{ $user->suburb ?? 'N/A' }}</li>
                <li><strong>City:</strong> {{ $user->city ?? 'N/A' }}</li>
                <li><strong>State:</strong> {{ $user->state ?? 'N/A' }}</li>
                <li><strong>Postcode:</strong> {{ $user->postcode ?? 'N/A' }}</li>
                <li><strong>Country:</strong> {{ $user->country ?? 'N/A' }}</li>
                <li><strong>Buzzer Code:</strong> {{ $user->buzzer_code ?? 'N/A' }}</li>
                <li><strong>Account Status:</strong> {{ strtoupper($user->status ?? 'PENDING') }}</li>
                <li><strong>Registration Date:</strong> {{ $user->created_at ? $user->created_at->format('F d, Y H:i:s') : 'N/A' }}</li>
            </ul>
        </div>

        <p><strong>Action Required:</strong> Please review and approve this user's account in the admin panel.</p>

        <div class="footer">
            <p>This is an automated notification from {{ config('app.name') }}.<br>
            Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
