<h2>Hello {{ $user->firstname }},</h2>
<p>You’ve been added as a <strong>Bayanihan Member</strong> for the course {{ $bGroup->course_id }}.</p>
<p><strong>School Year:</strong> {{ $bGroup->bg_school_year }}</p>
<p><strong>Assigned by:</strong> {{ $chairperson->firstname }} {{ $chairperson->lastname }}</p>
<p><strong>Department:</strong> {{ $department->department_name }}</p>
<p>Welcome to the Bayanihan Team!</p>
