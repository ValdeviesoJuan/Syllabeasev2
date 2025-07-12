<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Memo Notification</title>
</head>
<body style="font-family: Georgia, 'Times New Roman', serif; background-color: #f1f8ff; padding: 20px; margin: 0;">
    <table width="100%" cellspacing="0" cellpadding="0" 
           style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <!-- Slim Blue Header -->
        <tr>
            <td style="background-color: #007BFF; padding: 6px 16px; color: white; text-align: center;">
                <h3 style="margin: 0; font-weight: normal; font-size: 16px;">New Memo Notification</h3>
            </td>
        </tr>

        <!-- Main Content -->
        <tr>
            <td style="padding: 20px;">
                <h4 style="color: #004085; margin-top: 0; font-size: 17px;">{{ $memo->title }}</h4>
                <p style="font-size: 14px; color: #333; line-height: 1.6; margin: 8px 0;">
                    {{ $memo->description }}
                </p>
                <p style="font-size: 14px; color: #333; margin-top: 12px;">
                    <strong style="color: #007BFF;">Date:</strong> 
                    {{ $memo->date ? $memo->date->format('F d, Y') : 'N/A' }}
                </p>

                <!-- Notice Box -->
                <div style="background-color: #fff3cd; border-left: 6px solid #FFC107; padding: 12px; margin-top: 20px; color: #856404; font-size: 13px;">
                    You can view or download the memo from the system.
                </div>
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
