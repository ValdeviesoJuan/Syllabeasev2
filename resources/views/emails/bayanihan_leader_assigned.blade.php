<h2>Hello {{ $user->firstname }},</h2>
<p>You’ve been assigned as a <strong>Bayanihan Leader</strong> for the course {{ $bGroup->course_id }}.</p>
<p><strong>School Year:</strong> {{ $bGroup->bg_school_year }}</p>
<p><strong>Assigned by:</strong> {{ $chairperson->firstname }} {{ $chairperson->lastname }}</p>
<p><strong>Department:</strong> {{ $department->department_name }}</p>
<p>Thank you for your service!</p>
