<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bayanihan Team Notification</title>
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
                <h3>New Bayanihan Team Created</h3>
            </td>
        </tr>

        <!-- Main Content -->
        <tr>
            <td>
                <p>{{ $messageContent }}</p>
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
                <small>&copy; {{ date('Y') }} Bayanihan System. All rights reserved.</small>
            </td>
        </tr>
    </table>
</body>
</html>
