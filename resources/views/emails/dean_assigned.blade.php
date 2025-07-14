<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dean Assignment Notification</title>
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
                <h3>Dean Assignment</h3>
            </td>
        </tr>

        <!-- Email Content -->
        <tr>
            <td>
                <h4>Hello {{ $user->firstname }} {{ $user->lastname }},</h4>

                <p>You have been officially assigned as the <strong>Dean</strong> of <strong>{{ $college->college_code }}</strong>.</p>

                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td><strong>Start of Validity:</strong></td>
                        <td style="padding-left: 10px;">{{ \Carbon\Carbon::parse($start)->toFormattedDateString() }}</td>
                    </tr>
                    <tr>
                        <td><strong>End of Validity:</strong></td>
                        <td style="padding-left: 10px;">{{ \Carbon\Carbon::parse($end)->toFormattedDateString() }}</td>
                    </tr>
                </table>

                <p>Please coordinate with the administrator for further instructions.</p>

                <p>—<br><strong>SyllabEase Team</strong></p>
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
