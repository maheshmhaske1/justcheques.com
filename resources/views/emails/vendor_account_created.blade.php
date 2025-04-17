<h2>Hello {{ $user->firstname }} {{ $user->lastname }},</h2>

<p>Your vendor account has been created successfully. Welcome aboard!</p>

<p>You can now log in using your email: <strong>{{ $user->email }}</strong></p>

<p>Thanks,<br>{{ config('app.name') }} Team</p>
