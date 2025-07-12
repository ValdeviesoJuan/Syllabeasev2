<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Chairperson Assignment</title>
</head>
<body style="font-family: Georgia, 'Times New Roman', serif; background-color: #f1f8ff; padding: 20px; margin: 0;">
    <table width="100%" cellspacing="0" cellpadding="0"
           style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        
        <!-- Slim Blue Header -->
        <tr>
            <td style="background-color: #007BFF; padding: 6px 16px; color: white; text-align: center;">
                <h3 style="margin: 0; font-weight: normal; font-size: 16px;">Chairperson Assignment</h3>
            </td>
        </tr>

        <!-- Email Body -->
        <tr>
            <td style="padding: 20px;">
                <h4 style="color: #004085; margin-top: 0; font-size: 17px;">Hi {{ $user->firstname }},</h4>

                <p style="font-size: 14px; color: #333; line-height: 1.6; margin: 8px 0;">
                    🎉 <strong style="color: #FFC107;">Congratulations!</strong> You have been officially assigned as a <strong>Chairperson</strong> in the system.
                </p>

                <div style="background-color: #e9f5ff; border-left: 5px solid #007BFF; padding: 12px; margin: 20px 0; color: #004085; font-size: 13px;">
                    You can now log in to <strong>SyllabEase</strong> and view your department assignments and responsibilities.
                </div>

                <p style="font-size: 14px; color: #333;">We wish you success in your new role!</p>

                <p style="font-size: 13px; color: #555; margin-top: 30px;">
                    Regards,<br>
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
