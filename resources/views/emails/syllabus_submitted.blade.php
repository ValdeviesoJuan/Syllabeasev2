<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Syllabus Submitted</title>
</head>
<body style="font-family: Georgia, 'Times New Roman', serif; background-color: #f1f8ff; padding: 20px; margin: 0;">
    <table width="100%" cellspacing="0" cellpadding="0"
           style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px;
                  overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

        <!-- Slim Blue Header -->
        <tr>
            <td style="background-color: #007BFF; padding: 6px 16px; color: white; text-align: center;">
                <h3 style="margin: 0; font-weight: normal; font-size: 16px;">Syllabus Submitted</h3>
            </td>
        </tr>

        <!-- Email Body -->
        <tr>
            <td style="padding: 20px;">
                <p style="font-size: 14px; color: #333; line-height: 1.6;">Dear Chairperson,</p>

                <p style="font-size: 14px; color: #333;">
                    The following syllabus has been submitted by the Bayanihan Leader for your review:
                </p>

                <ul style="font-size: 14px; color: #333; padding-left: 20px; margin-top: 10px;">
                    <li><strong style="color: #007BFF;">Course Code:</strong> {{ $course_code }}</li>
                    <li><strong style="color: #007BFF;">School Year:</strong> {{ $bg_school_year }}</li>
                </ul>

                <div style="background-color: #fff3cd; border-left: 6px solid #FFC107; padding: 12px; margin-top: 20px; color: #856404; font-size: 13px;">
                    You may now proceed to review it in the system.
                </div>

                <p style="font-size: 13px; color: #555; margin-top: 30px;">
                    Thank you.
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
