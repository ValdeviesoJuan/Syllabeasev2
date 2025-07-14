<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New User Registration Notification</title>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0">
        <!-- Logo at Top -->
        <tr>
            <td style="text-align: left;">
                <img src="https://i.imgur.com/e6DsGLI.png" alt="SyllabEase Logo" style="max-width: 200px;">
            </td>
        </tr>

        <!-- Title -->
        <tr>
            <td>
                <h3>New User Registered</h3>
            </td>
        </tr>

        <!-- Email Body -->
        <tr>
            <td>
                <h4>New User Registration Notification</h4>
                <p>A new user has just registered:</p>
                <ul>
                    <li><strong>Name:</strong> {{ $newUser->firstname }} {{ $newUser->lastname }}</li>
                    <li><strong>Email:</strong> {{ $newUser->email }}</li>
                    <li><strong>Phone:</strong> {{ $newUser->phone }}</li>
                </ul>
            </td>
        </tr>

        <!-- Automated Notice -->
        <tr>
            <td>
                <p>This is an automated email. Please do not reply to this email.</p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="text-align: center;">
                <small>&copy; {{ date('Y') }} SyllabEase. All rights reserved.</small>
            </td>
        </tr>
    </table>
</body>
</html>
