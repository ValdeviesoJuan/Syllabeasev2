<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bayanihan Leader Assignment</title>
</head>
<body style="margin: 0; font-family: Arial, sans-serif; background-color: #f5f5f5;">
    <table width="80%" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; max-width: 1000px; margin: auto;">

        <!-- Header Image -->
        <tr>
            <td style="padding: 0; margin: 0;" align="center">
                <img src="https://i.imgur.com/G3P07dR.png" alt="SyllabEase Banner" width="100%" style="display: block; width: 100%; max-width: 1080px; height: auto; border: 0; margin: 0; padding: 0;">
            </td>
        </tr>

        <!-- Content -->
        <tr>
            <td style="padding: 20px;">
                <h3 style="margin-top: 0;">Bayanihan Assignment</h3>

                <h4 style="margin-bottom: 10px;">Hello {{ $user->firstname }},</h4>

                <p style="font-size: 15px; margin-top: 0;">
                    You’ve been assigned as a <strong>Bayanihan Leader</strong> for the course <strong>{{ $bGroup->course_id }}</strong>.
                </p>

                <table cellpadding="0" cellspacing="0" style="font-size: 15px; margin-top: 15px;">
                    <tr>
                        <td><strong>School Year:</strong></td>
                        <td style="padding-left: 10px;">{{ $bGroup->bg_school_year }}</td>
                    </tr>
                    <tr>
                        <td><strong>Assigned by:</strong></td>
                        <td style="padding-left: 10px;">{{ $chairperson->firstname }} {{ $chairperson->lastname }}</td>
                    </tr>
                    <tr>
                        <td><strong>Department:</strong></td>
                        <td style="padding-left: 10px;">{{ $department->department_name }}</td>
                    </tr>
                </table>

                <p style="font-size: 15px; margin-top: 20px;">Thank you for your service!</p>
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
