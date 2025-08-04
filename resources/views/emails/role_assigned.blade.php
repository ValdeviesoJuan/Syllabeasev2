<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Role Assignment</title>
</head>
<body style="margin: 0; font-family: Arial, sans-serif; background-color: #f5f5f5;">
    <table width="80%" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; max-width: 1000px; margin: auto;">

        
        <!-- Header Image -->
        <tr>
            <td style="padding: 0; margin: 0;" align="center">
                <img src="https://i.imgur.com/7pVnxWO.png" alt="SyllabEase Banner" width="100%" style="display: block; width: 100%; max-width: 1080px; height: 50%; border: 0; margin: 0; padding: 0;">
            </td>
        </tr>

        <!-- Greeting and Confirmation -->
        <tr>
            <td style="padding: 20px;">
                <p style="margin: 0; font-weight: bold; font-size: 16px;">Dear {{ strtoupper($user->lastname) }}, {{ strtoupper($user->firstname) }}</p>

                <p style="margin-top: 15px; font-size: 15px;">
                    Congratulations! You have been assigned a new role in <strong>SyllabEase</strong>.
                </p>

                <p style="font-size: 15px;"><strong>Role:</strong> {{ $roleName }}</p>

                <p style="font-size: 15px;">
                    If you have any questions or believe this was an error, please contact the administrator.
                </p>

                <p style="margin-top: 20px;">
                    <a href="{{ url('/dashboard') }}" style="color: #0645AD; text-decoration: none; font-size: 14px;">Go to your dashboard</a>
                </p>
            </td>
        </tr>

        <!-- Note -->
        <tr>
            <td style="padding: 0 20px;">
                <p style="font-size: 12px; color: #555;">This is an automated email. Please do not reply to this message.</p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background-color: #000000; color: #ffffff; text-align: center; padding: 20px; font-size: 13px;">
                <p style="margin: 0;"><strong>SyllabEase</strong></p>
                <p style="margin: 4px 0;">Your Learning Management Assistant</p>
                <p style="margin: 4px 0;">Email: support@syllabease.com | Contact No: +63 912 345 6789</p>
                <p style="margin: 4px 0;">© {{ date('Y') }} SyllabEase. All rights reserved.</p>
            </td>
        </tr>
    </table>
</body>
</html>
