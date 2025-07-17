<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Chairperson Assignment</title>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0">
        <!-- Logo -->
        <tr>
            <td style="text-align: left;">
                <img src="https://i.imgur.com/e6DsGLI.png" alt="SyllabEase Logo" style="max-width: 200px;">
            </td>
        </tr>

        <!-- Title -->
        <tr>
            <td>
                <h3>Chairperson Assignment</h3>
            </td>
        </tr>

        <!-- Email Body -->
        <tr>
            <td>
                <h4>Hi {{ $user->firstname }},</h4>

                <p>🎉 <strong>Congratulations!</strong> You have been officially assigned as a <strong>Chairperson</strong> in the system.</p>

                <p>You can now log in to <strong>SyllabEase</strong> and view your department assignments and responsibilities.</p>

                <p>We wish you success in your new role!</p>

                <p>Regards,<br>
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
