<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Syllabus Deadline Notification</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <table width="100%" cellspacing="0" cellpadding="0" style="max-width: 600px; background-color: #ffffff; margin: auto; border-radius: 8px; padding: 20px;">
        
        <!-- Logo -->
        <tr>
            <td style="text-align: left;">
                <img src="https://i.imgur.com/e6DsGLI.png" alt="SyllabEase Logo" style="max-width: 200px;">
            </td>
        </tr>

        <!-- Message Title -->
        <tr>
            <td>
                <h3 style="color: #333;">Syllabus Deadline Alert</h3>
            </td>
        </tr>

        <!-- Dynamic Message from getMessage() -->
        <tr>
            <td>
                <p style="font-size: 16px; color: #444;">
                    <p>{{ $customMessage }}</p>
                </p>
            </td>
        </tr>

        <!-- Call to Action -->
        <tr>
            <td>
                <p>You may log in to the system to review the syllabus requirements or deadlines.</p>
            </td>
        </tr>

        <!-- Automated Note -->
        <tr>
            <td>
                <p style="font-size: 12px; color: #888;">
                    This is an automated email. Please do not reply.
                </p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="text-align: center;">
                <small style="color: #999;">&copy; {{ date('Y') }} Bayanihan System. All rights reserved.</small>
            </td>
        </tr>

    </table>
</body>
</html>
