<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Table of Specifications Submitted</title>
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
                <h3>New Table of Specifications Submitted</h3>
            </td>
        </tr>

        <!-- Email Body -->
        <tr>
            <td>
                <p><strong>Term:</strong> {{ $tos->tos_term }}</p>
                <p><strong>Total No. of Items:</strong> {{ $tos->tos_no_items }}</p>
                <p><strong>Curricular Program/Year/Section:</strong> {{ $tos->tos_cpys }}</p>

                <p><strong>Cognitive Percentages:</strong></p>
                <ul>
                    <li><strong>Knowledge:</strong> {{ $tos->col_1_per }}%</li>
                    <li><strong>Comprehension:</strong> {{ $tos->col_2_per }}%</li>
                    <li><strong>Application/Analysis:</strong> {{ $tos->col_3_per }}%</li>
                    <li><strong>Synthesis/Evaluation:</strong> {{ $tos->col_4_per }}%</li>
                </ul>
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
