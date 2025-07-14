<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Role Assignment</title>
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
                <h3>Role Assignment</h3>
            </td>
        </tr>

        <!-- Body -->
        <tr>
            <td>
                <p>Hello {{ $user->firstname }} {{ $user->lastname }},</p>

                <p>You have been assigned a new role in <strong>SyllabEase</strong>:</p>

                <p><strong>Role:</strong> {{ $roleName }}</p>

                <p>If you have questions or believe this was an error, please contact the administrator.</p>

                <p>Thank you,<br>
                <strong>The SyllabEase Team</strong></p>
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
