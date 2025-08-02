<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Syllabus Deadline Notification</title>
</head>
<body style="margin: 0; font-family: Arial, sans-serif; background-color: #f5f5f5;">
    <table width="80%" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; max-width: 1000px; margin: auto;">

        <!-- Header Image -->
        <tr>
            <td style="padding: 0; margin: 0;" align="center">
                <img src="https://i.imgur.com/G3P07dR.png" alt="SyllabEase Banner" width="100%" style="display: block; width: 100%; max-width: 1080px; height: auto; border: 0; margin: 0; padding: 0;">
            </td>
        </tr>

        <!-- Title and Content -->
        <tr>
            <td style="padding: 20px;">
                <h3 style="margin-top: 0; color: #333;">Syllabus Deadline Alert</h3>

                <p style="font-size: 15px; color: #444;">
                    {{ $customMessage }}
                </p>

                <p style="font-size: 15px;">You may log in to the system to review the syllabus requirements or deadlines.</p>
            </td>
        </tr>

        <!-- Automated Message -->
        <tr>
            <td style="padding: 0 20px;">
                <p style="font-size: 12px; color: #888;">This is an automated email. Please do not reply.</p>
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
