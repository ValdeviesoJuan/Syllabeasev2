<h2>New User Registration Notification</h2>
<p>A new user has just registered:</p>

<ul>
    <li><strong>Name:</strong> {{ $newUser->firstname }} {{ $newUser->lastname }}</li>
    <li><strong>Email:</strong> {{ $newUser->email }}</li>
    <li><strong>Phone:</strong> {{ $newUser->phone }}</li>
</ul>
