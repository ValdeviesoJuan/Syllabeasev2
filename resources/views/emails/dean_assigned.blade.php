<h2>Hello {{ $user->firstname }} {{ $user->lastname }},</h2>

<p>You have been officially assigned as the Dean of <strong>{{ $college->college_code }}</strong>.</p>

<p>
    <strong>Start of Validity:</strong> {{ \Carbon\Carbon::parse($start)->toFormattedDateString() }}<br>
    <strong>End of Validity:</strong> {{ \Carbon\Carbon::parse($end)->toFormattedDateString() }}
</p>

<p>Please coordinate with the administrator for further instructions.</p>

<p>—<br>SyllabEase Team</p>
