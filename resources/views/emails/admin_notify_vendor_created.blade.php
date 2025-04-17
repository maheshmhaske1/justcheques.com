<h2>New Vendor Registered</h2>

<p>A new vendor has been created:</p>

<ul>
    <li><strong>Name:</strong> {{ $user->firstname }} {{ $user->lastname }}</li>
    <li><strong>Email:</strong> {{ $user->email }}</li>
    <li><strong>Company:</strong> {{ $user->company ?? 'N/A' }}</li>
</ul>

<p>Thanks,<br>{{ config('app.name') }} Notification</p>
