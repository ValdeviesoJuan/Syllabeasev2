<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Deadline Notification</title>
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
                <h3>New Deadline Notification</h3>
            </td>
        </tr>

        <!-- Email Body -->
        <tr>
            <td>
                <p>Dear Bayanihan Leader,</p>

                <p>The Dean has set a new deadline:</p>

                <ul>
                    <li><strong>Syllabus:</strong> {{ \Carbon\Carbon::parse($deadline->dl_syll)->toDayDateTimeString() }}</li>
                    <li><strong>Midterm TOS:</strong> {{ \Carbon\Carbon::parse($deadline->dl_tos_midterm)->toDayDateTimeString() }}</li>
                    <li><strong>Final TOS:</strong> {{ \Carbon\Carbon::parse($deadline->dl_tos_final)->toDayDateTimeString() }}</li>
                </ul>

                <p>
                    <strong>School Year:</strong> {{ $deadline->dl_school_year }}<br>
                    <strong>Semester:</strong> {{ $deadline->dl_semester }}
                </p>

                <p>Please make sure to submit all required documents on or before the specified deadlines.</p>

                <p>Thank you!</p>
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
