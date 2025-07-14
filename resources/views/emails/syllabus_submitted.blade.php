<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Syllabus Submitted</title>
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
                <h3>Syllabus Submitted</h3>
            </td>
        </tr>

        <!-- Email Body -->
        <tr>
            <td>
                <p>Dear Chairperson,</p>

                <p>The following syllabus has been submitted by the Bayanihan Leader for your review:</p>

                <ul>
                    <li><strong>Course Code:</strong> {{ $course_code }}</li>
                    <li><strong>School Year:</strong> {{ $bg_school_year }}</li>
                </ul>

                <p>You may now proceed to review it in the system.</p>

                <p>Thank you.</p>
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
                <small>&copy; {{ date('Y') }} SyllabEase. All rights reserved.</small>
            </td>
        </tr>
    </table>
</body>
</html>
