<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Syllabus Approved</title>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0">
        <!-- Logo -->
        <tr>
            <td style="text-align: left;">
                <img src="https://i.imgur.com/e6DsGLI.png" alt="SyllabEase Logo" style="max-width: 200px;">
            </td>
        </tr>

        <!-- Title -->
        <tr>
            <td>
                <h3>Syllabus Approved</h3>
            </td>
        </tr>

        <!-- Email Body -->
        <tr>
            <td>
                <p>The Chairperson has approved the syllabus for:</p>

                <ul>
                    <li><strong>Course Code:</strong> {{ $course_code }}</li>
                    <li><strong>School Year:</strong> {{ $bg_school_year }}</li>
                </ul>

                <p>You may now check the syllabus details in your dashboard.</p>
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
