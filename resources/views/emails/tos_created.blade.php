<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Table of Specifications Submitted</title>
</head>
<body style="margin: 0; font-family: Arial, sans-serif; background-color: #f5f5f5;">
    <table width="80%" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; max-width: 1000px; margin: auto;">

        <!-- Header Image -->
        <tr>
            <td style="padding: 0; margin: 0;" align="center">
                <img src="https://i.imgur.com/G3P07dR.png" alt="SyllabEase Banner" width="100%" style="display: block; width: 100%; max-width: 1080px; height: auto; border: 0; margin: 0; padding: 0;">
            </td>
        </tr>

        <!-- Title and Body -->
        <tr>
            <td style="padding: 20px;">
                <h3 style="margin-top: 0;">New Table of Specifications Submitted</h3>

                <p style="font-size: 15px;"><strong>Term:</strong> {{ $tos->tos_term }}</p>
                <p style="font-size: 15px;"><strong>Total No. of Items:</strong> {{ $tos->tos_no_items }}</p>
                <p style="font-size: 15px;"><strong>Curricular Program/Year/Section:</strong> {{ $tos->tos_cpys }}</p>

                <p style="font-size: 15px;"><strong>Cognitive Percentages:</strong></p>
                <ul style="font-size: 15px; padding-left: 20px;">
                    <li><strong>Knowledge:</strong> {{ $tos->col_1_per }}%</li>
                    <li><strong>Comprehension:</strong> {{ $tos->col_2_per }}%</li>
                    <li><strong>Application/Analysis:</strong> {{ $tos->col_3_per }}%</li>
                    <li><strong>Synthesis/Evaluation:</strong> {{ $tos->col_4_per }}%</li>
                </ul>
            </td>
        </tr>

        <!-- Automated Message -->
        <tr>
            <td style="padding: 0 20px;">
                <p style="font-size: 12px; color: #888;">This is an automated email. Please do not reply to this message.</p>
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
