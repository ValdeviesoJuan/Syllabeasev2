<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bayanihan Leader Assignment</title>
</head>
<body style="font-family: Georgia, 'Times New Roman', serif; background-color: #f1f8ff; padding: 20px; margin: 0;">
    <table width="100%" cellspacing="0" cellpadding="0" 
           style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        
        <!-- Slim Blue Header -->
        <tr>
            <td style="background-color: #007BFF; padding: 6px 16px; color: white; text-align: center;">
                <h3 style="margin: 0; font-weight: normal; font-size: 16px;">Bayanihan Assignment</h3>
            </td>
        </tr>

        <!-- Content -->
        <tr>
            <td style="padding: 20px;">
                <h4 style="color: #004085; margin-top: 0; font-size: 17px;">Hello {{ $user->firstname }},</h4>

                <p style="font-size: 14px; color: #333; line-height: 1.6; margin: 8px 0;">
                    You’ve been assigned as a <strong style="color: #FFC107;">Bayanihan Leader</strong> for the course <strong>{{ $bGroup->course_id }}</strong>.
                </p>

                <table cellpadding="0" cellspacing="0" style="margin: 12px 0; font-size: 14px; color: #333;">
                    <tr>
                        <td><strong style="color: #007BFF;">School Year:</strong></td>
                        <td style="padding-left: 10px;">{{ $bGroup->bg_school_year }}</td>
                    </tr>
                    <tr style="background-color: #e9f5ff;">
                        <td><strong style="color: #007BFF;">Assigned by:</strong></td>
                        <td style="padding-left: 10px;">{{ $chairperson->firstname }} {{ $chairperson->lastname }}</td>
                    </tr>
                    <tr>
                        <td><strong style="color: #007BFF;">Department:</strong></td>
                        <td style="padding-left: 10px;">{{ $department->department_name }}</td>
                    </tr>
                </table>

                <div style="background-color: #fff3cd; border-left: 6px solid #FFC107; padding: 12px; margin-top: 20px; color: #856404; font-size: 13px;">
                    Thank you for your service!
                </div>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background-color: #f7f7f7; padding: 10px; text-align: center; color: #555; font-size: 12px;">
                <small>&copy; {{ date('Y') }} Bayanihan Program. All rights reserved.</small>
            </td>
        </tr>
    </table>
</body>
</html>
