<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Table of Specifications Submitted</title>
</head>
<body style="font-family: Georgia, 'Times New Roman', serif; background-color: #f1f8ff; padding: 20px; margin: 0;">
    <table width="100%" cellspacing="0" cellpadding="0"
           style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px;
                  overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

        <!-- Slim Blue Header -->
        <tr>
            <td style="background-color: #007BFF; padding: 6px 16px; color: white; text-align: center;">
                <h3 style="margin: 0; font-weight: normal; font-size: 16px;">New Table of Specifications Submitted</h3>
            </td>
        </tr>

        <!-- Email Body -->
        <tr>
            <td style="padding: 20px;">
                <p style="font-size: 14px; color: #333;"><strong style="color: #007BFF;">Term:</strong> {{ $tos->tos_term }}</p>
                <p style="font-size: 14px; color: #333;"><strong style="color: #007BFF;">Total No. of Items:</strong> {{ $tos->tos_no_items }}</p>
                <p style="font-size: 14px; color: #333;"><strong style="color: #007BFF;">Curricular Program/Year/Section:</strong> {{ $tos->tos_cpys }}</p>

                <p style="font-size: 14px; color: #333;"><strong style="color: #007BFF;">Cognitive Percentages:</strong></p>
                <ul style="font-size: 14px; color: #333; padding-left: 20px; margin-top: 8px;">
                    <li><strong>Knowledge:</strong> {{ $tos->col_1_per }}%</li>
                    <li><strong>Comprehension:</strong> {{ $tos->col_2_per }}%</li>
                    <li><strong>Application/Analysis:</strong> {{ $tos->col_3_per }}%</li>
                    <li><strong>Synthesis/Evaluation:</strong> {{ $tos->col_4_per }}%</li>
                </ul>
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
