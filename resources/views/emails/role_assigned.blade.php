<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Role Assignment</title>
</head>
<body style="font-family: Georgia, 'Times New Roman', serif; background-color: #f1f8ff; padding: 20px; margin: 0;">
    <table width="100%" cellspacing="0" cellpadding="0"
           style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px;
                  overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

        <!-- Slim Blue Header -->
        <tr>
            <td style="background-color: #007BFF; padding: 6px 16px; color: white; text-align: center;">
                <h3 style="margin: 0; font-weight: normal; font-size: 16px;">Role Assignment</h3>
            </td>
        </tr>

        <!-- Body -->
        <tr>
            <td style="padding: 20px;">
                <p style="font-size: 14px; color: #333; line-height: 1.6;">
                    Hello {{ $user->firstname }} {{ $user->lastname }},
                </p>

                <p style="font-size: 14px; color: #333;">
                    You have been assigned a new role in <strong>SyllabEase</strong>:
                </p>

                <p style="font-size: 14px; color: #333; margin: 15px 0;">
                    <strong style="color: #007BFF;">Role:</strong> {{ $roleName }}
                </p>

                <p style="font-size: 14px; color: #333;">
                    If you have questions or believe this was an error, please contact the administrator.
                </p>

                <p style="font-size: 13px; color: #555; margin-top: 30px;">
                    Thank you,<br>
                    <strong>The SyllabEase Team</strong>
                </p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background-color: #f7f7f7; padding: 10px; text-align: center; color: #555; font-size: 12px;">
                <small>&copy; {{ date('Y') }} SyllabEase. All rights reserved.</small>
            </td>
        </tr>
    </table>
</body>
</html>
