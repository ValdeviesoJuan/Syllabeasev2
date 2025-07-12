<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bayanihan Team Notification</title>
</head>
<body style="font-family: Georgia, 'Times New Roman', serif; background-color: #f1f8ff; padding: 20px; margin: 0;">
    <table width="100%" cellspacing="0" cellpadding="0" 
           style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        
        <!-- Slim Blue Header -->
        <tr>
            <td style="background-color: #007BFF; padding: 6px 16px; color: white; text-align: center;">
                <h3 style="margin: 0; font-weight: normal; font-size: 16px;">New Bayanihan Team Created</h3>
            </td>
        </tr>

        <!-- Main Content -->
        <tr>
            <td style="padding: 20px;">
                <p style="font-size: 14px; color: #333; line-height: 1.6;">
                    {{ $messageContent }}
                </p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background-color: #f7f7f7; padding: 10px; text-align: center; color: #555; font-size: 12px;">
                <small>&copy; {{ date('Y') }} Bayanihan System. All rights reserved.</small>
            </td>
        </tr>
    </table>
</body>
</html>
