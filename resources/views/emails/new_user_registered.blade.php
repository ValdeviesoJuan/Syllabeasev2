<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New User Registration Notification</title>
</head>
<body style="font-family: Georgia, 'Times New Roman', serif; background-color: #f1f8ff; padding: 20px; margin: 0;">
    <table width="100%" cellspacing="0" cellpadding="0"
           style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px;
                  overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

        <!-- Slim Blue Header -->
        <tr>
            <td style="background-color: #007BFF; padding: 6px 16px; color: white; text-align: center;">
                <h3 style="margin: 0; font-weight: normal; font-size: 16px;">New User Registered</h3>
            </td>
        </tr>

        <!-- Email Body -->
        <tr>
            <td style="padding: 20px;">
                <h4 style="color: #004085; margin-top: 0; font-size: 17px;">New User Registration Notification</h4>

                <p style="font-size: 14px; color: #333; line-height: 1.6;">
                    A new user has just registered:
                </p>

                <ul style="font-size: 14px; color: #333; padding-left: 20px; margin-top: 10px;">
                    <li><strong style="color: #007BFF;">Name:</strong> {{ $newUser->firstname }} {{ $newUser->lastname }}</li>
                    <li><strong style="color: #007BFF;">Email:</strong> {{ $newUser->email }}</li>
                    <li><strong style="color: #007BFF;">Phone:</strong> {{ $newUser->phone }}</li>
                </ul>
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
