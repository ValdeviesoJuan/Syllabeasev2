<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Syllabus Approved</title>
</head>
<body style="margin: 0; font-family: Arial, sans-serif; background-color: #f5f5f5;">
    <table width="80%" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; max-width: 1000px; margin: auto;">

        <!-- Header Image -->
        <tr>
            <td style="padding: 0; margin: 0;" align="center">
                <img src="https://i.imgur.com/7pVnxWO.png" alt="SyllabEase Banner" width="100%" style="display: block; width: 100%; max-width: 1080px; height: auto; border: 0; margin: 0; padding: 0;">
            </td>
        </tr>

        <!-- Title and Body -->
        <tr>
            <td style="padding: 20px;">
                <h3 style="margin-top: 0;">Syllabus Approved</h3>

                <p style="font-size: 15px;">The Chairperson has approved the syllabus for:</p>

                <ul style="font-size: 15px; padding-left: 20px; margin: 10px 0;">
                    <li><strong>Course Code:</strong> {{ $course_code }}</li>
                    <li><strong>School Year:</strong> {{ $bg_school_year }}</li>
                </ul>

                <p style="font-size: 15px;">You may now check the syllabus details in your dashboard.</p>
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
