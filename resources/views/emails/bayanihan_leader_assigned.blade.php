<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bayanihan Leader Assignment</title>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0">
        <!-- Logo at Top -->
        <tr>
            <td style="text-align: left;">
                <img src="https://i.imgur.com/e6DsGLI.png" alt="SyllabEase Logo" style="max-width: 200px;">
            </td>
        </tr>

        <!-- Title -->
        <tr>
            <td>
                <h3>Bayanihan Assignment</h3>
            </td>
        </tr>

        <!-- Content -->
        <tr>
            <td>
                <h4>Hello {{ $user->firstname }},</h4>

                <p>
                    You’ve been assigned as a <strong>Bayanihan Leader</strong> for the course <strong>{{ $bGroup->course_id }}</strong>.
                </p>

                <table cellpadding="0" cellspacing="0">
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

                <p>Thank you for your service!</p>
            </td>
        </tr>

        <!-- Automated Notice -->
        <tr>
            <td>
                <p>This is an automated email. Please do not reply to this email.</p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="text-align: center;">
                <small>&copy; {{ date('Y') }} Bayanihan Program. All rights reserved.</small>
            </td>
        </tr>
    </table>
</body>
</html>
