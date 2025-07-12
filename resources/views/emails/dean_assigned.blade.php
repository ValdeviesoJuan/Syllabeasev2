<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dean Assignment Notification</title>
</head>
<body style="font-family: Georgia, 'Times New Roman', serif; background-color: #f1f8ff; padding: 20px; margin: 0;">
    <table width="100%" cellspacing="0" cellpadding="0" 
           style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        
        <!-- Slim Blue Header -->
        <tr>
            <td style="background-color: #007BFF; padding: 6px 16px; color: white; text-align: center;">
                <h3 style="margin: 0; font-weight: normal; font-size: 16px;">Dean Assignment</h3>
            </td>
        </tr>

        <!-- Email Content -->
        <tr>
            <td style="padding: 20px;">
                <h4 style="color: #004085; margin-top: 0; font-size: 17px;">Hello {{ $user->firstname }} {{ $user->lastname }},</h4>

                <p style="font-size: 14px; color: #333; line-height: 1.6; margin: 8px 0;">
                    You have been officially assigned as the <strong style="color: #FFC107;">Dean</strong> of <strong>{{ $college->college_code }}</strong>.
                </p>

                <table cellpadding="0" cellspacing="0" style="margin: 12px 0; font-size: 14px; color: #333;">
                    <tr>
                        <td><strong style="color: #007BFF;">Start of Validity:</strong></td>
                        <td style="padding-left: 10px;">{{ \Carbon\Carbon::parse($start)->toFormattedDateString() }}</td>
                    </tr>
                    <tr style="background-color: #e9f5ff;">
                        <td><strong style="color: #007BFF;">End of Validity:</strong></td>
                        <td style="padding-left: 10px;">{{ \Carbon\Carbon::parse($end)->toFormattedDateString() }}</td>
                    </tr>
                </table>

                <p style="font-size: 14px; color: #333;">
                    Please coordinate with the administrator for further instructions.
                </p>

                <p style="font-size: 13px; color: #555; margin-top: 30px;">
                    —<br><strong>SyllabEase Team</strong>
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
