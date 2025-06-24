<p>Dear Bayanihan Leader,</p>
<p>The Dean has set a new deadline:</p>
<ul>
    <li><strong>Syllabus:</strong> {{ \Carbon\Carbon::parse($deadline->dl_syll)->toDayDateTimeString() }}</li>
    <li><strong>Midterm TOS:</strong> {{ \Carbon\Carbon::parse($deadline->dl_tos_midterm)->toDayDateTimeString() }}</li>
    <li><strong>Final TOS:</strong> {{ \Carbon\Carbon::parse($deadline->dl_tos_final)->toDayDateTimeString() }}</li>
</ul>
<p>School Year: {{ $deadline->dl_school_year }}</p>
<p>Semester: {{ $deadline->dl_semester }}</p>
<p>Thank you!</p>
